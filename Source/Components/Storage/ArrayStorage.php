<?php

class ArrayStorage implements IStorage
{
	protected $collection = array();

	public function __construct(array $data = array())
	{
		$this->collection = $data;
	}

	public function read($key, $default = null)
	{
		return isset($this->collection[$key])
			? $this->collection[$key]
			: $default;
	}

	public function write($key, $data)
	{
		$this->collection[$key] = $data;
	}

	public function delete($key)
	{
		unset($this->collection[$key]);
	}

	public function regenerate($destroy = false) {}
}
