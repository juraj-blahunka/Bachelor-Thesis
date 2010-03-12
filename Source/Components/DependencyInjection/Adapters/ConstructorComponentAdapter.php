<?php

class ConstructorComponentAdapter extends AbstractComponentAdapter
{
	private
		$arguments,
		$preventCyclic;

	public function __construct($key, $class, array $arguments = array())
	{
		parent::__construct($key, $class, $arguments);
		$this->arguments     = $arguments;
		$this->preventCyclic = false;
	}

	public function getInstance(IDependencyInjectionContainer $container)
	{
		if ($this->preventCyclic)
			throw new CyclicInstantiationException("Cyclic instantiation of {$this->getKey()} component, with '{$this->getClass()}' class");

		$this->preventCyclic = true;

		$reflection  = new ReflectionClass($this->getClass());
		$constructor = $reflection->getConstructor();
		$instance    = null;

		if (count($this->arguments))
		{
			$argstoPass = array();
			foreach ($this->arguments as $argument)
				$argstoPass[] = $argument->resolve($container, $this);
			$instance = $reflection->newInstanceArgs($argstoPass);
		}
		else if ($constructor && count($constructor->getParameters()))
		{
			$argstoPass = array();
			$parameters = $constructor->getParameters();
			foreach ($parameters as $argument)
			{
				$argumentClassReflection = $argument->getClass();
				if (! $argumentClassReflection)
					throw new InjecteeArgumentException("{$argument->getName()} requires a value and no object");
				$argstoPass[] = $container->getInstanceOf($argumentClassReflection->getName());
			}
			$instance = $reflection->newInstanceArgs($argstoPass);
		}
		else
			$instance = $reflection->newInstance();

		$this->preventCyclic = false;

		return $instance;
	}

	public function getArguments()
	{
		return $this->arguments;
	}
}
