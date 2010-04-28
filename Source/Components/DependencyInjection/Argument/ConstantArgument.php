<?php

class ConstantArgument implements IInjecteeArgument
{
	/**
	 * The constant name.
	 *
	 * @var string
	 */
	protected $constantId;

	/**
	 * Constructor.
	 *
	 * @param string $constantId
	 */
	public function __construct($constantId)
	{
		$this->constantId = $constantId;
	}

	/**
	 * Resolve the constant value.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @param IComponentAdapter $adapter
	 * @return mixed
	 */
	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter)
	{
		$value = $container->getConstant($this->constantId);
		if (is_null($value))
			throw new InjecteeArgumentException("No constant with id {$this->constantId} found!");
		return $value;
	}
}
