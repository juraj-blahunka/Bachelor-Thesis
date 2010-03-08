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
			throw new CyclicInstantiationException("Cyclic instantiation of {$this->getKey()} component");

		$this->preventCyclic = true;
		
		$reflection = new ReflectionClass($this->getClass());

		$argumentsForConstructor = array();

		$constructor = $reflection->getConstructor();
		
		if (count($this->arguments))
		{
			foreach ($this->arguments as $argument)
			$argumentsForConstructor[] = $argument->resolve($container, $this, null);
		}
		else if (count($constructor->getParameters()))
		{
			// try to guess the args.
		}

		throw new Exception('Tu som skoncil, pokracovat v magickom vytvarani (hladani argumentov do konstruktora)');
		

		
		$instance = is_null($reflection->getConstructor())
			? $reflection->newInstance()
			: $reflection->newInstanceArgs($argumentsForConstructor);
		
		$this->preventCyclic = false;
		return $instance;
	}

	public function getArguments()
	{
		return $this->arguments;
	}
}