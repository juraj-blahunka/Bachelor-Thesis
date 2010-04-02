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

			$methodReflection = new ReflectionMethod($instance, $methodName);

			if (count($arguments))
			{
				$resolved = $this->resolveArguments($container, $arguments);
				call_user_func_array(array($instance, $methodName), $resolved);
			}
			else if($methodReflection && $methodReflection->getParameters())
			{
				$argsToPass = $this->getArgumentsOfMethod($container, $methodReflection);
				call_user_func_array(array($instance, $methodName), $argsToPass);
			}
			else
				call_user_func(array($instance, $methodName));
		}
		return $instance;
	}
}
