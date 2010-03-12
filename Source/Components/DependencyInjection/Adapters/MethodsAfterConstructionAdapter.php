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
				$resolved = array();
				for ($i = 0; $i < count($arguments); $i++)
					$resolved[] = $arguments[$i]->resolve($container, $this, '');

				call_user_func_array(array($instance, $methodName), $resolved);
			}
			else if($methodReflection && $methodReflection->getParameters())
			{
				$argsToPass = array();
				$parameters  = $methodReflection->getParameters();
				foreach ($parameters as $parameter)
				{
					$parameterClassReflection = $parameter->getClass();
					if (! $parameterClassReflection)
						throw new InjecteeArgumentException("Argument {$parameter->getName()} requires a value and no object");
					$argsToPass[] = $container->getInstanceOf($parameterClassReflection->getName());
				}

				call_user_func_array(array($instance, $methodName), $argsToPass);
			}
			else
				call_user_func(array($instance, $methodName));
		}
		return $instance;
	}
}
