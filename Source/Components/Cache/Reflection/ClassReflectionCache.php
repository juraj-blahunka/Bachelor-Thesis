<?php

/**
 * Stores class reflection objects.
 *
 * @package    BachelorThesis
 * @subpackage Cache_Reflection
 */
class ClassReflectionCache implements IClassReflectionCache
{
	protected $collection = array();

	/**
	 * Store ReflectionClass with computed key, the key is returned.
	 *
	 * @param ReflectionClass $reflection
	 * @return string the key
	 */
	public function storeClass(ReflectionClass $reflection)
	{
		$key = $this->computeKey($reflection);
		$this->collection[$key] = $reflection;
		return $key;
	}

	/**
	 * Get ReflectionClass object identified by key.
	 *
	 * @param string $class
	 * @return mixed
	 */
	public function retrieveClass($class)
	{
		return $this->collection[$class];
	}

	/**
	 * Checks if ReflectionClass exists.
	 *
	 * @param string $class
	 * @return bool
	 */
	public function hasClass($class)
	{
		return isset($this->collection[$class]);
	}

	/**
	 * Remove ReflectionClass identified by key.
	 *
	 * @param string $class
	 */
	public function deleteClass($class)
	{
		unset($this->collection[$class]);
	}

	/**
	 * Compute key from ReflectionClass for storage.
	 * ReflectionClass class name represents the key.
	 *
	 * @param ReflectionClass $reflection
	 * @return string
	 */
	protected function computeKey(ReflectionClass $reflection)
	{
		return $reflection->getName();
	}
}
