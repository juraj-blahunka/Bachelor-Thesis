<?php

/**
 * A facade on top of IClassReflectionCache and IMethodReflectionCache.
 *
 * @package    BachelorThesis
 * @subpackage Cache_Reflection
 */
class ReflectionCache implements IReflectionCache
{
	protected
		$methods,
		$classes;

	/**
	 * Constructor.
	 *
	 * @param IClassReflectionCache $classes
	 * @param IMethodReflectionCache $methods
	 */
	public function __construct(IClassReflectionCache $classes, IMethodReflectionCache $methods)
	{
		$this->classes = $classes;
		$this->methods = $methods;
	}

	/**
	 * Store ReflectionClass with computed key, the key is returned.
	 *
	 * @param ReflectionClass $reflection
	 * @return string the key
	 */
	public function storeClass(ReflectionClass $reflection)
	{
		return $this->classes->storeClass($reflection);
	}

	/**
	 * Get ReflectionClass object identified by key.
	 *
	 * @param string $class
	 * @return mixed
	 */
	public function retrieveClass($class)
	{
		return $this->classes->retrieveClass($class);
	}

	/**
	 * Checks if ReflectionClass exists.
	 *
	 * @param string $class
	 * @return bool
	 */
	public function hasClass($class)
	{
		return $this->classes->hasClass($class);
	}

	/**
	 * Remove ReflectionClass identified by key.
	 *
	 * @param string $class
	 */
	public function deleteClass($class)
	{
		return $this->classes->deleteClass($class);
	}

	/**
	 * Store ReflectionMethod object with computed key, the key is returned.
	 * Method also stores the declaring class into class reflection collection.
	 *
	 * @param ReflectionMethod $reflection
	 * @return string the key
	 */
	public function storeMethod(ReflectionMethod $reflection)
	{
		$classReflection = $reflection->getDeclaringClass();
		if (! $this->classes->hasClass($classReflection->getName()))
			$this->classes->storeClass($classReflection);

		return $this->methods->storeMethod($reflection);
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
		if ($this->hasMethod($class, $method))
			return $this->methods->retrieveMethod($class, $method);
		throw new OutOfBoundsException("{$class} doesn't declare '{$method}' method");
	}

	/**
	 * Checks whether method defined by $class and $method exists.
	 * If no direct method has been found, look into reflection classes and
	 * try to find, store the method.
	 *
	 * @param string $class
	 * @param string $method
	 * @return bool
	 */
	public function hasMethod($class, $method)
	{
		if ($this->methods->hasMethod($class, $method))
			return true;
		if ($this->classes->hasClass($class))
		{
			$classReflection = $this->classes->retrieveClass($class);
			if ($classReflection->hasMethod($method))
			{
				$methodReflection = $classReflection->getMethod($method);
				$this->methods->storeMethod($methodReflection);
				return true;
			}
		}
		return false;
	}

	/**
	 * Remove ReflectionMethod object.
	 *
	 * @param string $class
	 * @param string $method
	 */
	public function deleteMethod($class, $method)
	{
		return $this->methods->deleteMethod($class, $method);
	}
}
