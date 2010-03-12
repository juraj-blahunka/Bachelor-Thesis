<?php

class ComponentArgument implements IInjecteeArgument
{
	protected
		$component;

	public function __construct($component)
	{
		$this->component = $component;
	}

	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter)
	{
		$instance = $container->getInstanceOf($this->component);
		if (is_null($instance))
			throw new InjecteeArgumentException("Cannot create '{$this->component}' component, reffered to by '{$adapter->getKey()}' component");
		return $instance;
	}
}
