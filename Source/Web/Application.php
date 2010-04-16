<?php

abstract class Application
{
	protected
		$environment,
		$debug,
		$factory,
		$container,
		$packages,
		$packagePaths;

	public function __construct($environment, $debug, ApplicationFactory $factory = null)
	{
		$this->environment  = $environment;
		$this->debug        = (bool) $debug;
		$this->factory      = is_null($factory)
			? new ApplicationFactory()
			: $factory;

		$this->setContainer($this->factory->createContainer());
	}

	public function configure()
	{
		$this->packagePaths = $this->registerPackagePaths();
		foreach ($this->packagePaths as $path)
			require $path;

		$this->packages     = $this->registerPackages();
		foreach ($this->packages as $package)
			$package->register($this->container);

		$builder = $this->registerWiring();
		$this->container->merge($builder);

		$rules = $this->registerRouting();
		$this->container->getInstanceOf('RouterManager')->addRules($rules);
	}

	public function run()
	{
		$request = $this->container->getInstanceOf('Request');
		$runner  = $this->container->getInstanceOf('ControllerRunner');
		return $runner->run($request);
	}

	abstract function registerPackages();

	abstract function registerPackagePaths();

	abstract function registerWiring();

	abstract function registerRouting();

	public function getEnvironment()
	{
		return $this->environment;
	}

	public function isDebug()
	{
		return $this->debug;
	}

	public function setContainer(IDependencyInjectionContainer $container)
	{
		$this->container = $container;
	}

	public function getContainer()
	{
		return $this->container;
	}
}