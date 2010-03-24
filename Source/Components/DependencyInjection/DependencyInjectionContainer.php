<?php

class DependencyInjectionContainer implements IDependencyInjectionContainer
{
	const
		CONTAINER_KEY = 'dependency_injection_container';

	protected
		$parent,
		$factory,
		$constants,
		$definitions,
		$adapters;

	public function __construct(IDependencyInjectionContainer $parent = null, IDependencyInjectionContainerFactory $factory = null)
	{
		$this->parent  = $parent;
		$this->factory = is_null($factory) ? new DefaultContainerFactory() : $factory;

		$this->constants   = array();
		$this->definitions = array();
		$this->adapters    = array();

		$adapter = $this->factory->createInstanceAdapter(self::CONTAINER_KEY, $this);
		$this->setComponentAdapter($adapter);
	}

	public function createChildContainer()
	{
		return new DependencyInjectionContainer($this, $this->factory);
	}

	public function setConstant($key, $value)
	{
		$this->constants[$key] = $value;
	}

	public function getConstant($key)
	{
		return isset($this->constants[$key])
			? $this->constants[$key]
			: (!is_null($this->parent)
				? $this->parent->getConstant($key)
				: null);
	}

	public function addConstants(array $constants)
	{
		$this->constants = array_merge($this->constants, $constants);
	}

	public function getConstants()
	{
		return $this->constants;
	}

	public function setComponentAdapter(IComponentAdapter $adapter)
	{
		$this->adapters[$adapter->getKey()] = $adapter;
	}

	public function getComponentAdapter($component)
	{
		if (isset($this->adapters[$component]))
			return $this->adapters[$component];

		if (isset($this->definitions[$component]))
		{
			$adapter = $this->factory->createAdapterFromDef($component, $this->definitions[$component]);
			$this->setComponentAdapter($adapter);
			return $adapter;
		}

		return !is_null($this->parent)
			? $this->parent->getComponentAdapter($component)
			: null;
	}

	public function getAdaptersOfType($type)
	{
		if (isset($this->adapters[$type]) || isset($this->definitions[$type]))
			return array($this->getComponentAdapter($type));

		$typeReflection = new ReflectionClass($type);
		$result = array();
		$foundClasses = array();
		$definitionsAndAdapters = array_merge($this->definitions, $this->adapters);
		foreach ($definitionsAndAdapters as $key => $component)
		{
			if (isset($foundClasses[$component->getClass()]))
				continue;
			if ($type == $component->getClass())
			{
				$result[] = $this->getComponentAdapter($key);
				$foundClasses[$component->getClass()] = true;
			}
			else if (class_exists($component->getClass(), true))
			{
				$componentReflection = new ReflectionClass($component->getClass());
				$implements = $typeReflection->isInterface() && $componentReflection->implementsInterface($type);
				$extends    = $componentReflection->isSubclassOf($type);
				if ($implements || $extends)
				{
					$result[] = $this->getComponentAdapter($key);
					$foundClasses[$component->getClass()] = true;
				}
			}
		}

		return $result;
	}

	public function registerComponent($component)
	{
		$definition = $this->factory->createComponentDefinition($component, array());
		$this->definitions[$component] = $definition;
		unset($this->adapters[$component]);
		return $definition;
	}

	public function getDefinition($component)
	{
		return isset($this->definitions[$component])
			? $this->definitions[$component]
			: null;
	}

	public function getDefinitions()
	{
		return $this->definitions;
	}

	public function getInstanceOf($component, array $withArguments = array())
	{
		// $component is a named Component
		$adapter = $this->getComponentAdapter($component);
		if(! is_null($adapter))
			return $adapter->getInstance($this);

		// $component is a class or interface name
		$adapters = $this->getAdaptersOfType($component);
		if (count($adapters) == 0)
		{
			// no adapters found, try to create a new adapter
			$adapter = $this->factory->createConstructorAdapter(null, $component, $withArguments);
			return $adapter->getInstance($this);
		}
		else if (count($adapters) == 1)
		{
			// found exactly one adapter with the specified type
			$adapter = array_shift($adapters);
			return $adapter->getInstance($this);
		}
		else
			throw new AmbiguousArgumentException("Class '{$component}' is ambiguous, too many similar classes found");
	}
}
