<?php

class ReferenceArgument implements IInjecteeArgument
{
	protected
		$componentKey;

	public function __construct($componentKey)
	{
		$this->componentKey = $componentKey;
	}

	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter, $expectedType)
	{
		$value = $container->getComponentInstance($this->componentKey);
		if (is_null($value))
			throw new InjecteeArgumentException("Cannot create '{$this->componentKey}' component, reffered to by '{$adapter->getKey()}' component");
		return $value;
	}
}
