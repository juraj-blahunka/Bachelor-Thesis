<?php

class ReflectionCache implements IReflectionCache
{
	protected
		$methods,
		$classes;

	public function __construct(IClassReflectionCache $classes, IMethodReflectionCache $methods)
	{
		$this->classes = $classes;
		$this->methods = $methods;
	}

	public function storeClass(ReflectionClass $reflection)
	{
		return $this->classes->storeClass($reflection);
	}

	public function retrieveClass($class)
	{
		return $this->classes->retrieveClass($class);
	}

	public function hasClass($class)
	{
		return $this->classes->hasClass($class);
	}

	public function deleteClass($class)
	{
		return $this->classes->deleteClass($class);
	}

	public function storeMethod(ReflectionMethod $reflection)
	{
		$classReflection = $reflection->getDeclaringClass();
		if (! $this->classes->hasClass($classReflection->getName()))
			$this->classes->storeClass($classReflection);

		return $this->methods->storeMethod($reflection);
	}

	public function retrieveMethod($class, $method)
	{
		if ($this->hasMethod($class, $method))
			return $this->methods->retrieveMethod($class, $method);
	}

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

	public function deleteMethod($class, $method)
	{
		return $this->methods->deleteMethod($class, $method);
	}
}
