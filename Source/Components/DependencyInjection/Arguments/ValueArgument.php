<?php

class ValueArgument implements IInjecteeArgument
{
	protected
		$value;

	public function __construct($value)
	{
		$this->value = $value;
	}
	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter, $expectedType)
	{
		return $this->value;
	}
}