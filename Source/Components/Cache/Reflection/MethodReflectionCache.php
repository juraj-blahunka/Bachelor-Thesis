<?php

class MethodReflectionCache implements IMethodReflectionCache
{
	protected $collection = array();

	/**
	 * Store ReflectionMethod object with computed key, the key is returned.
	 *
	 * @param ReflectionMethod $reflection
	 * @return string the key
	 */
	public function storeMethod(ReflectionMethod $reflection)
	{
		$key = $this->computeKey($reflection);
		$this->collection[$key] = $reflection;
		return $key;
	}

	/**
	 * Get ReflectionMethod based on class name and method name.
	 *
	 * @param string $class
	 * @param string $method
	 * @return mixed
	 */
	public function retrieveMethod($class, $method)
	{
		return $this->collection[$class . '.' . $method];
	}

	/**
	 * Checks whether method defined by $class and $method exists.
	 *
	 * @param string $class
	 * @param string $method
	 * @return bool
	 */
	public function hasMethod($class, $method)
	{
		return isset($this->collection[$class . '.' . $method]);
	}

	/**
	 * Remove ReflectionMethod object.
	 *
	 * @param string $class
	 * @param string $method
	 */
	public function deleteMethod($class, $method)
	{
		unset($this->collection[$class . '.' . $method]);
	}

	/**
	 * Compute key from ReflectionMethod object.
	 * The key is represented by "classname.methodname"
	 *
	 * @param ReflectionMethod $reflection
	 * @return string
	 */
	protected function computeKey(ReflectionMethod $reflection)
	{
		return $reflection->getDeclaringClass()->getName() . '.' . $reflection->getName();
	}
}
