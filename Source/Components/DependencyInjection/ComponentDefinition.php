<?php

class ComponentDefinition implements IComponentDefinition
{
	protected
		$class,
		$arguments,
		$scope,
		$methods,
		$notes;

	public function __construct($class, array $arguments = array())
	{
		$this->setClass($class);
		$this->setArguments($arguments);
		$this->setDefaultScope();
		$this->methods = array();
		$this->notes   = array();
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

	public function setDefaultScope()
	{
		$this->setShared();
		return $this;
	}

	public function setShared()
	{
		$this->setScope('shared');
		return $this;
	}

	public function setTransient()
	{
		$this->setScope('transient');
		return $this;
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

	public function setNotes(array $notes)
	{
		$this->notes = $notes;
		return $this;
	}

	public function addNotes(array $notes)
	{
		$this->notes = array_merge($this->notes, $notes);
		return $this;
	}

	public function getNotes()
	{
		return $this->notes;
	}

	public function addNote($name, $value)
	{
		$this->notes[$name] = $value;
		return $this;
	}

	public function getNote($name, $default = null)
	{
		return isset($this->notes[$name])
			? $this->notes[$name]
			: $default;
	}
}
