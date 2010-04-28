<?php

abstract class BaseComponentAdapter implements IComponentAdapter
{
	/**
	 * Resolve array of Injectee arguments to array of mixed values.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @param array $arguments of IInjecteeArgument
	 * @return array of mixed
	 */
	protected function resolveArguments(IDependencyInjectionContainer $container, array $arguments)
	{
		$result = array();
		for ($i = 0; $i < count($arguments); $i++)
			$result[] = $arguments[$i]->resolve($container, $this);
		return $result;
	}

	/**
	 * Resolve arguments of ReflectionMethod by their optionality or class name.
	 *
	 * If argument is optional and it's default value is supplied,
	 * use its default value. Else the argument must be a Class or Interface,
	 * so the container is able to instantiate and provide proper values.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @param ReflectionMethod $method
	 * @return array of mixed
	 */
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
					throw new InjecteeArgumentException("Argument '{$parameter->getName()}' cannot be instantiated, it is either a Value or an Unknown type");
				$result[] = $container->getInstanceOf($parameterClass->getName());
			}
		}
		return $result;
	}
}
