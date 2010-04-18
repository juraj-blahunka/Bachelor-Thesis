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
		if (is_array($this->packagePaths))
		{
			foreach ($this->packagePaths as $path)
				require $path;
		}
		else
			$this->packagePaths = array();

		$this->container->setConstant(
			'application.package_paths', $this->packagePaths
		);

		$this->packages     = $this->registerPackages();
		if (is_array($this->packages))
		{
			foreach ($this->packages as $package)
				$package->register($this->container);
		}
		else
			$this->packages = array();

		$builder = $this->registerWiring();
		if (is_object($builder))
			$this->container->merge($builder);
	}

	abstract function run();

	abstract function registerPackages();

	abstract function registerPackagePaths();

	abstract function registerWiring();

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