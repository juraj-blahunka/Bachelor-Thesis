<?php

class ClassArgument implements IInjecteeArgument
{
	protected
		$class;

	public function __construct($class)
	{
		$this->class = $class;
	}

	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter, $expectedType)
	{
		$instance = $container->getClassInstance($this->class, array());
		if (is_null($instance))
			throw new InjecteeArgumentException("Cannot instantiate class '{$this->class}'");
		return $instance;
	}
}
