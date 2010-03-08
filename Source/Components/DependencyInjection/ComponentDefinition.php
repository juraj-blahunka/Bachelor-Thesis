<?php

class ComponentDefinition implements IComponentDefinition
{
	const
		DEFAULT_SCOPE = 'transient';

	protected
		$class,
		$arguments,
		$scope,
		$methods;

	public function __construct($class, array $arguments = array())
	{
		$this->setClass($class);
		$this->setArguments($arguments);
		$this->setScope(self::DEFAULT_SCOPE);
		$this->methods = array();
	}

	public function setClass($class)
	{
		$this->class = $class;
		return $this;
	}

	public function getClass()
	{
		return $this->class;
	}

	public function setArguments(array $arguments)
	{
		$this->arguments = $arguments;
		return $this;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function addArgument($type, $value)
	{
		$this->arguments[] = array($type, $value);
		return $this;
	}

	public function setScope($scope)
	{
		$this->scope = $scope;
		return $this;
	}

	public function getScope()
	{
		return $this->scope;
	}

	public function setMethods(array $methods)
	{
		$this->methods = $methods;
		return $this;
	}

	public function addMethod($methodName, array $methodArguments = array())
	{
		$this->methods[] = array($methodName, $methodArguments);
		return $this;
	}

	public function getMethods()
	{
		return $this->methods;
	}
}
