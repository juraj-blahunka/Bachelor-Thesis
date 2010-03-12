<?php

abstract class AbstractComponentAdapter implements IComponentAdapter
{
	protected
		$key,
		$class;

	public function __construct($key, $class, array $arguments = array())
	{
		$this->key   = $key;
		$this->class = $class;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function getClass()
	{
		return $this->class;
	}
}
