<?php

abstract class BaseComponentAdapter implements IComponentAdapter
{
	protected function resolveArguments(IDependencyInjectionContainer $container, array $arguments)
	{
		$result = array();
		for ($i = 0; $i < count($arguments); $i++)
			$result[] = $arguments[$i]->resolve($container, $this);
		return $result;
	}

	protected function getArgumentsOfMethod(
		IDependencyInjectionContainer $container,
		ReflectionMethod $method)
	{
		$result = array();
		$parameters  = $method->getParameters();
		foreach ($parameters as $parameter)
		{
			if ($parameter->isOptional() || $parameter->isDefaultValueAvailable())
				$result[] = $parameter->getDefaultValue();
			else
			{
				$parameterClass = $parameter->getClass();
				if (! $parameterClass)
					throw new InjecteeArgumentException("Argument {$parameter->getName()} requires a value and no object");
				$result[] = $container->getInstanceOf($parameterClass->getName());
			}
		}
		return $result;
	}
}
