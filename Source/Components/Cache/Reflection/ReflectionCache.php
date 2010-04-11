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
		return $this->methods->storeMethod($reflection);
	}

	public function retrieveMethod($class, $method)
	{
		return $this->methods->retrieveMethod($class, $method);
	}

	public function hasMethod($class, $method)
	{
		return $this->methods->hasMethod($class, $method);
	}

	public function deleteMethod($class, $method)
	{
		return $this->methods->deleteMethod($class, $method);
	}
}
