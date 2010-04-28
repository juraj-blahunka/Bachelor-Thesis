<?php

class ComponentDefinition implements IComponentDefinition
{
	protected
		$id,
		$class,
		$arguments,
		$scope,
		$methods,
		$notes;

	/**
	 * Constructor.
	 *
	 * @param string $id
	 * @param array $arguments
	 */
	public function __construct($id, array $arguments = array())
	{
		$this->id = $id;
		$this->setClass($id);
		$this->setArguments($arguments);
		$this->setDefaultScope();
		$this->methods = array();
		$this->notes   = array();
	}

	/**
	 * Get the Id.
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set class name.
	 *
	 * @param string $class
	 * @return ComponentDefinition
	 */
	public function setClass($class)
	{
		$this->class = $class;
		return $this;
	}

	/**
	 * Get class name.
	 *
	 * @return string The class name
	 */
	public function getClass()
	{
		return $this->class;
	}

	/**
	 * Set arguments.
	 *
	 * @param array $arguments
	 * @return ComponentDefinition
	 */
	public function setArguments(array $arguments)
	{
		$this->arguments = $arguments;
		return $this;
	}

	/**
	 * Get defined arguments.
	 *
	 * @return array
	 */
	public function getArguments()
	{
		return $this->arguments;
	}

	/**
	 * Add argument to constructor arguments collection.
	 *
	 * @param string $type
	 * @param mixed $value
	 * @return ComponentDefinition
	 */
	public function addArgument($type, $value)
	{
		$this->arguments[] = array($type, $value);
		return $this;
	}

	/**
	 * Sets the scope in which the component will be instantiated
	 *
	 * @param string $scope
	 * @return ComponentDefinition
	 */
	public function setScope($scope)
	{
		$this->scope = $scope;
		return $this;
	}

	/**
	 * Get name of scope.
	 *
	 * @return string
	 */
	public function getScope()
	{
		return $this->scope;
	}

	/**
	 * Use default scope.
	 *
	 * @return ComponentDefinition
	 */
	public function setDefaultScope()
	{
		$this->setShared();
		return $this;
	}

	/**
	 * Set shared scope.
	 *
	 * @return ComponentDefinition
	 */
	public function setShared()
	{
		$this->setScope('shared');
		return $this;
	}

	/**
	 * Set transient scope.
	 *
	 * @return ComponentDefinition
	 */
	public function setTransient()
	{
		$this->setScope('transient');
		return $this;
	}

	/**
	 * Set array of methods to be called on instantiation
	 *
	 * @param array $methods
	 * @return ComponentDefinition
	 */
	public function setMethods(array $methods)
	{
		$this->methods = $methods;
		return $this;
	}

	/**
	 * Add method to be called on instantiation.
	 *
	 * @param string $methodName
	 * @param array $methodArguments
	 * @return ComponentDefinition
	 */
	public function addMethod($methodName, array $methodArguments = array())
	{
		$this->methods[] = array($methodName, $methodArguments);
		return $this;
	}

	/**
	 * Get array of declared methods to be called on instantiation.
	 *
	 * @return array
	 */
	public function getMethods()
	{
		return $this->methods;
	}

	/**
	 * Give the definition an array of notes.
	 *
	 * @param array $notes
	 * @return ComponentDefinition
	 */
	public function setNotes(array $notes)
	{
		$this->notes = $notes;
		return $this;
	}

	/**
	 * Add new notes to exisiting notes base.
	 *
	 * @param array $notes
	 * @return ComponentDefinition
	 */
	public function addNotes(array $notes)
	{
		$this->notes = array_merge($this->notes, $notes);
		return $this;
	}

	/**
	 * Get declared Notes.
	 *
	 * @return array
	 */
	public function getNotes()
	{
		return $this->notes;
	}

	/**
	 * Add single note to notes base.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @return ComponentDefinition
	 */
	public function addNote($name, $value)
	{
		$this->notes[$name] = $value;
		return $this;
	}

	/**
	 * Retrieve the note base on its $name.
	 * $default returned, when note not found.
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getNote($name, $default = null)
	{
		return isset($this->notes[$name])
			? $this->notes[$name]
			: $default;
	}
}
