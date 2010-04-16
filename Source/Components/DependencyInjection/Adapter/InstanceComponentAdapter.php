<?php

class InstanceComponentAdapter implements IComponentAdapter
{
	protected
		$key,
		$instance;

	public function __construct($key, $instance)
	{
		$this->key      = $key;
		$this->instance = $instance;
	}

	public function getClass()
	{
		return get_class($this->instance);
	}

	public function getInstance(IDependencyInjectionContainer $container)
	{
		return $this->instance;
	}

	public function getKey()
	{
		return $this->key;
	}
}
