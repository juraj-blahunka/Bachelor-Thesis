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

	public function getComponentAdapter($key)
	{
		if (isset($this->adapters[$key]))
		{
			return $this->adapters[$key];
		}

		if (isset($this->definitions[$key]))
		{
			$adapter = $this->factory->createAdapterFromDef($key, $this->definitions[$key]);
			$this->setComponentAdapter($adapter);
			return $adapter;
		}

		return !is_null($this->parent)
			? $this->parent->getComponentAdapter($key)
			: null;
	}

	public function getComponentInstance($key)
	{
		$adapter = $this->getComponentAdapter($key);
		return is_null($adapter)
			? null
			: $adapter->getInstance($this);
	}

	public function registerComponent($componentKey, $class)
	{
		$definition = $this->factory->createComponentDefinition($class, array());
		$this->definitions[$componentKey] = $definition;
		return $definition;
	}

	public function getDefinitions()
	{
		return $this->definitions;
	}

	public function getClassInstance($class, array $arguments = array())
	{
		$adapter = new ConstructorComponentAdapter($class, $class, $arguments);
		return $adapter->getInstance($this);
	}
}






$mainConfig = array(
	'constants' => array(
		'event_dispatcher.class' => 'Dispacher',
		'database.class'          => 'Outlet',
		'database.user'           => 'root',
		'database.passsword'      => 'very secret',
	),
	'components' => array(
		'event_dispatcher' => array(
			'class'       => array('constant' => 'event_dispatcher.class'),
			'constructor' => array(),
			'scope'       => 'shared'
		),
		'outlet_orm' => array(
			'class'       => array('constant' => 'database.class'),
			'constructor' => array(
				'reference' => 'event_dispatcher',
				'constant'  => 'database.user',
				'constant'  => 'databse.password',
				'value'     => '2',
				'class'     => 'SomeClass',
			),
			'scope' => 'shared',
			'calls' => array(
				'preconfigure',
				'configure' => array(
					'value'    => 'special',
					'constant' => 'database.class',
				),
			),
		),
		'some_service' => array(
			'class'       => array('constant' => 'look here'),
			'constructor' => array(),
			'scope'       => 'transient',
		),
	),
	'classes' => array(
		'MySpecialClass' => array(
			'constructor' => ''
		),
	)
);
