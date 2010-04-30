<?php

/**
 * Provides a value, which is injected in constructor.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
class ValueArgument implements IInjecteeArgument
{
	/**
	 * The value.
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Constructor.
	 *
	 * @param mixed $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * Resolve the argument by returning the Value.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @param IComponentAdapter $adapter
	 * @return mixed
	 */
	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter)
	{
		return $this->value;
	}
}
