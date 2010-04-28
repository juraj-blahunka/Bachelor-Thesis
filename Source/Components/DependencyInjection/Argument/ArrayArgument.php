<?php

class ArrayArgument implements IInjecteeArgument
{
	/**
	 * The associative array of IInjecteeArgument.
	 *
	 * @var array of IInjecteeArgument
	 */
	protected $array;

	/**
	 * Constructor.
	 *
	 * @param array $array Array of IInjecteeArgument
	 */
	public function __construct(array $array)
	{
		$this->array = $array;
	}

	/**
	 * Resolve the collection of IInjecteeArgument inside to their values.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @param IComponentAdapter $adapter
	 * @return array of mixed
	 */
	public function resolve(IDependencyInjectionContainer $container, IComponentAdapter $adapter)
	{
		$resolved = array();
		foreach ($this->array as $index => $item)
			$resolved[$index] = $item->resolve($container, $adapter);
		return $resolved;
	}
}
