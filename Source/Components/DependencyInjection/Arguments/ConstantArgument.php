<?php

class ConstantArgument implements IInjecteeArgument
{
	protected
		$constantId;

	public function __construct($constantId)
	{
		$this->constantId = $constantId;
	}

	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter)
	{
		$value = $container->getConstant($this->constantId);
		if (is_null($value))
			throw new InjecteeArgumentException("No constant with id {$this->constantId} found!");
		return $value;
	}
}
