<?php

/**
 * Works with resolvable component types, instantiates components.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 *
 * usage:
 *
 * <code>
 *   $container = new DependencyInjectionContainer();
 *
 *   $container->addConstants(array(
 *     'key'       => 'my value',
 *     'other key' => 'other value',
 *   ));
 *
 *   $container->registerComponent('SimpleClass');
 *
 *   $container->registerComponent('my_component')
 *     ->setClass('Dependable')
 *     ->addArgument('component' 'SimpleClass');
 *     ->addArgument('constant', 'key')
 *     ->addArgument('constant', 'other key');
 *
 *   $object = $container->getInstanceOf('my_component');
 *
 *   $custom = $container->getInstanceOfWith('Dependable', array(
 *     new SimpleDerivedClass(),
 *     array('constant', 'key'),
 *     'just another value',
 *   ));
 * </code>
 */
class DependencyInjectionContainer extends ContainerBuilder implements IDependencyInjectionContainer
{
	const CONTAINER_KEY = 'container_service';

	protected $adapters;

	/**
	 * Constructor.
	 *
	 * @param IDependencyInjectionContainerFactory $factory
	 */
	public function __construct(IDependencyInjectionContainerFactory $factory = null)
	{
		parent::__construct($factory);
		$this->adapters = array();

		$adapter = $this->factory->createInstanceAdapter(self::CONTAINER_KEY, $this);
		$this->setComponentAdapter($adapter);
	}

	/**
	 * Create new component definition with $component key in repository.
	 * Dispose of already created adapter associated with $component
	 *
	 * @param string $component
	 * @return ComponentDefinition Builder for fluent interface interaction
	 */
	public function define($component)
	{
		unset($this->adapters[$component]);
		return parent::define($component);
	}

	/**
	 * Add a component adapter to container's repository
	 *
	 * @param IComponentAdapter $adapter
	 */
	public function setComponentAdapter(IComponentAdapter $adapter)
	{
		$this->adapters[$adapter->getKey()] = $adapter;
	}

	/**
	 * If specified adapter is found, return the associated adapter.
	 * If a definition assigned to $component is found, create and add new
	 * adapter to adapter repository, return adapter.
	 *
	 * @param string $component
	 * @return IComponentAdapter
	 */
	public function getComponentAdapter($component)
	{
		if (isset($this->adapters[$component]))
			return $this->adapters[$component];

		if (isset($this->definitions[$component]))
		{
			$adapter = $this->factory->createAdapterFromDef($this->definitions[$component]);
			$this->setComponentAdapter($adapter);
			return $adapter;
		}

		return null;
	}

	/**
	 * Find an array of component adapters, which are assigned to $type in
	 * class binding, which classes are equal to $type, which extend $type or
	 * implement $type.
	 *
	 * @param string $type
	 * @return array Array of IComponentAdapter instances
	 */
	public function getAdaptersOfType($type)
	{
		if (isset($this->adapters[$type]) || isset($this->definitions[$type]))
			return array($this->getComponentAdapter($type));

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
				$typeReflection      = new ReflectionClass($type);
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

	/**
	 * Instantiate component, which is either a component name or
	 * component class.
	 *
	 * If lookup in definition and adapter repository fails, create adapter
	 * with class set to $component.
	 *
	 * @param string $component
	 * @return mixed Instance of $component
	 *
	 * @throws AmbiguousArgumentException When adapter count is more than 1
	 */
	public function getInstanceOf($component)
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
			$adapter = $this->factory->createConstructorAdapter(null, $component, array());
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

	/**
	 * Instantiate component adapter created from
	 * $component class and $arguments array.
	 *
	 * @param string $component
	 * @param array $arguments
	 * @return mixed
	 */
	public function getInstanceOfWith($component, array $arguments)
	{
		$defined = $this->getDefinition($component);
		if (! is_null($defined))
		{
			$definition = clone $defined;
			$definition->setArguments($arguments);
		}
		else
			$definition = $this->factory->createComponentDefinition($component, $arguments)->setTransient();

		$adapter    = $this->factory->createAdapterFromDef($definition);
		return $adapter->getInstance($this);
	}

	/**
	 * Merge settings and created component adapters from other container
	 *
	 * @param DependencyInjectionContainer $container
	 */
	public function merge($container)
	{
		parent::merge($container);
		if ($container instanceof self)
			$this->adapters = array_merge($this->adapters, $container->adapters);
	}
}
