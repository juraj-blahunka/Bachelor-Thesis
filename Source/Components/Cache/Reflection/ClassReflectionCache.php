<?php

class ClassReflectionCache implements IClassReflectionCache
{
	protected $collection = array();

	public function storeClass(ReflectionClass $reflection)
	{
		$key = $this->computeKey($reflection);
		$this->collection[$key] = $reflection;
		return $key;
	}

	public function retrieveClass($class)
	{
		return $this->collection[$class];
	}

	public function hasClass($class)
	{
		return isset($this->collection[$class]);
	}

	public function deleteClass($class)
	{
		unset($this->collection[$class]);
	}

	protected function computeKey(ReflectionClass $reflection)
	{
		return $reflection->getName();
	}
}
