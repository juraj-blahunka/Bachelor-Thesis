<?php

class ComponentDefinitionToComponentAdapter implements IComponentDefinitionToComponentAdapter
{
	public function convert($componentKey, IComponentDefinition $definition)
	{
		$class        = $definition->getClass();
		$arguments    = $this->createArgumentObjectsFromArray($definition->getArguments());
		$instantiater = new ConstructorComponentAdapter($componentKey, $class, $arguments);
		$methods      = count($definition->getMethods()) > 0
			? new MethodsAfterConstructionAdapter($this->createMethodsArray($definition->getMethods()), $instantiater)
			: $instantiater;
		$scoper       = $definition->getScope() === 'shared'
			? new SharedComponentAdapter($methods)
			: $methods;

		return $scoper;
	}

	protected function createArgumentObjectsFromArray(array $arguments)
	{
		$objectArguments = array();
		foreach ($arguments as $argument)
		{
			list($type, $value) = $argument;
			$objectArguments[] = $this->createArgument($type, $value);
		}
		return $objectArguments;
	}

	protected function createArgument($type, $value)
	{
		if (in_array($type, array('value', 'constant', 'component')))
		{
			$classNameArgument = ucfirst($type).'Argument';
			return new $classNameArgument($value);
		}
		else if ($type === 'array')
		{
			$resolved = array();
			foreach ($value as $key => $argument)
			{
				list($type, $value) = $argument;
				$resolved[$key] = $this->createArgument($type, $value);
			}
			return new ArrayArgument($resolved);
		}
		else
			throw new InvalidArgumentException("Argument of type '{$type}' is not valid, value = '{$value}'");
	}

	protected function createMethodsArray(array $methods)
	{
		$bulkedMethods = array();
		foreach ($methods as $method)
		{
			list($name, $arguments) = $method;
			$objectArguments = $this->createArgumentObjectsFromArray($arguments);
			$bulkedMethods[] = array($name, $objectArguments);
		}
		return $bulkedMethods;
	}
}
