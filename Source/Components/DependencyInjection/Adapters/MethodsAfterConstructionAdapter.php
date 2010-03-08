<?php

class MethodsAfterConstructionAdapter extends DecoratingComponentAdapter
{
	private
		$methods;

	public function __construct(array $methods, IComponentAdapter $adapter)
	{
		parent::__construct($adapter);
		$this->methods = $methods;
	}

	public function getMethods()
	{
		return $this->methods;
	}

	public function getInstance(IDependencyInjectionContainer $container)
	{
		$instance = parent::getInstance($container);
		foreach ($this->getMethods() as $method)
		{
			list($methodName, $arguments) = $method;
			$resolved = array();
			for ($i = 0; $i < count($arguments); $i++)
				$resolved[] = $arguments[$i]->resolve($container, $this, '');
			
			call_user_func_array(array($instance, $methodName), $resolved);
		}
		return $instance;
	}
}
