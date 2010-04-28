<?php

class ComponentDefinitionToComponentAdapter implements IComponentDefinitionToComponentAdapter
{
	/**
	 * Converts the Component Definition to the appropriate Component Adapter
	 * representation.
	 *
	 * @param IComponentDefinition $definition
	 * @return IComponentAdapter
	 */
	public function convert(IComponentDefinition $definition)
	{
		$componentKey = $definition->getId();
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

	/**
	 * Transform array of arguments into array of instanceof of IInjecteeArgument.
	 *
	 * @param array $arguments
	 * @return array of IInjecteeArgument
	 */
	protected function createArgumentObjectsFromArray(array $arguments)
	{
		$objectArguments = array();
		foreach ($arguments as $argument)
		{
			if (is_array($argument) && (count($argument) == 2))
				list($type, $value) = $argument;
			else
			{
				$type  = 'value';
				$value = $argument;
			}
			$objectArguments[] = $this->createArgument($type, $value);
		}
		return $objectArguments;
	}

	/**
	 * Create single argument instance of IInjecteeArgument.
	 *
	 * Available types of argument are:
	 *		value
	 *		constant
	 *		component
	 *		array
	 *
	 * @param string $type
	 * @param mixed $value
	 * @return IInjecteeArgument
	 *
	 * @throws InvalidArgumentException when argument type was not found in enabled argument types
	 */
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
	
	/**
	 * Transforms array of methods into array of methods with array of instances
	 * of IInjecteeArgument
	 *
	 * @param array $methods
	 * @return array
	 */
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
