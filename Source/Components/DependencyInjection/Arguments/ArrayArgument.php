<?php

class ArrayArgument implements IInjecteeArgument
{
	protected
		$array;

	public function __construct(array $array)
	{
		$this->array = $array;
		
	}
	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter, $expectedType)
	{
		$resolved = array();
		foreach ($this->array as $index => $item)
			$resolved[$index] = $item->resolve($container, $adapter, $expectedType);
		return $resolved;
	}
}
