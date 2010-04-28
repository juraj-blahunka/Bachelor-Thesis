<?php

class InstanceComponentAdapter implements IComponentAdapter
{
	protected
		$key,
		$instance;

	/**
	 * Constructor.
	 *
	 * @param string $key
	 * @param mixed $instance The object instance
	 */
	public function __construct($key, $instance)
	{
		$this->key      = $key;
		$this->instance = $instance;
	}

	/**
	 * Get class of object instance.
	 *
	 * @return string
	 */
	public function getClass()
	{
		return get_class($this->instance);
	}

	/**
	 * Get the Key.
	 *
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Get the instance.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @return mixed
	 */
	public function getInstance(IDependencyInjectionContainer $container)
	{
		return $this->instance;
	}
}
