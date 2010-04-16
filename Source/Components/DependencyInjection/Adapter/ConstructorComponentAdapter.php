<?php

class ConstructorComponentAdapter extends BaseComponentAdapter
{
	private
		$key,
		$class,
		$arguments,
		$preventCyclic;

	public function __construct($key, $class, array $arguments = array())
	{
		$this->key   = $key;
		$this->class = $class;
		$this->arguments     = $arguments;
		$this->preventCyclic = false;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function getClass()
	{
		return $this->class;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

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
