<?php

class MethodReflectionCache implements IMethodReflectionCache
{
	protected $collection = array();

	public function storeMethod(ReflectionMethod $reflection)
	{
		$key = $this->computeKey($reflection);
		$this->collection[$key] = $reflection;
		return $key;
	}

	public function retrieveMethod($class, $method)
	{
		return $this->collection[$class . '.' . $key];
	}

	public function hasMethod($class, $method)
	{
		return isset($this->collection[$class . '.' . $key]);
	}

	public function deleteMethod($class, $method)
	{
		unset($this->collection[$class . '.' . $method]);
	}

	protected function computeKey(ReflectionMethod $reflection)
	{
		return $reflection->getDeclaringClass()->getName() . '.' . $reflection->getName();
	}
}
