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
				try {
					$parameterClass = $parameter->getClass();
				} catch (ReflectionException  $e) {
					throw new InjecteeArgumentException("Argument '{$parameter->getName()}' cannot be instantiated, it is either a Value or an Unknown type, caused by: {$e->getMessage()}");
				}
				$result[] = $container->getInstanceOf($parameterClass->getName());
			}
		}
		return $result;
	}
}
