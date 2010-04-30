<?php

/**
 * Constructor adapter for a class with arguments.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
class ConstructorComponentAdapter extends BaseComponentAdapter
{
	private
		$key,
		$class,
		$arguments,
		$preventCyclic;

	/**
	 * Constructor.
	 *
	 * @param string $key
	 * @param string $class
	 * @param array $arguments array of IInjecteeArgument
	 */
	public function __construct($key, $class, array $arguments = array())
	{
		$this->key   = $key;
		$this->class = $class;
		$this->arguments     = $arguments;
		$this->preventCyclic = false;
	}

	/**
	 * Get Key.
	 *
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Get Class name.
	 *
	 * @return string
	 */
	public function getClass()
	{
		return $this->class;
	}

	/**
	 * Get Arguments.
	 *
	 * @return array of IInjecteeArgument
	 */
	public function getArguments()
	{
		return $this->arguments;
	}

	/**
	 * Instantiate the component based on provided class and arguments.
	 * If no arguments are passed, try to resolve them automatically by
	 * using Reflection.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @return mixed
	 *
	 * @throws CyclicInstantiationException when Adapter tries to instantiate itself
	 */
	public function getInstance(IDependencyInjectionContainer $container)
	{
		if ($this->preventCyclic)
			throw new CyclicInstantiationException("Cyclic instantiation of {$this->getKey()} component, with '{$this->getClass()}' class");

		$this->preventCyclic = true;

		$reflection  = new ReflectionClass($this->getClass());
		$constructor = $reflection->getConstructor();
		$instance    = null;

		if (count($this->getArguments()))
		{
			$resolved = $this->resolveArguments($container, $this->getArguments());
			$instance = $reflection->newInstanceArgs($resolved);
		}
		else if ($constructor && count($constructor->getParameters()))
		{
			$argstoPass = $this->getArgumentsOfMethod($container, $constructor);
			$instance = $reflection->newInstanceArgs($argstoPass);
		}
		else
			$instance = $reflection->newInstance();

		$this->preventCyclic = false;

		return $instance;
	}
}
