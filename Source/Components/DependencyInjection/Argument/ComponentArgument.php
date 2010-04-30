<?php

/**
 * Creates instance of a component by specifying its id or class.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
class ComponentArgument implements IInjecteeArgument
{
	/**
	 * Component identified by its Key or Classname.
	 *
	 * @var string
	 */
	protected $component;

	/**
	 * Constructor.
	 *
	 * @param string $component
	 */
	public function __construct($component)
	{
		$this->component = $component;
	}

	/**
	 * Resolve the Component string into an Object instance.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @param IComponentAdapter $adapter
	 * @return mixed
	 */
	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter)
	{
		$instance = $container->getInstanceOf($this->component);
		if (is_null($instance))
			throw new InjecteeArgumentException("Cannot create '{$this->component}' component, reffered to by '{$adapter->getKey()}' component");
		return $instance;
	}
}
