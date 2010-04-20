<?php

abstract class Application
{
	protected
		$environment,
		$debug,
		$factory,
		$container,
		$paths,
		$packages,
		$packageCollection,
		$packagePaths;

	public function __construct($environment, $debug, ApplicationFactory $factory = null)
	{
		$this->environment  = $environment;
		$this->debug        = (bool) $debug;
		$this->factory      = is_null($factory)
			? new ApplicationFactory()
			: $factory;

		$this->setContainer($this->factory->createContainer());

		$this->container->define('path_collection_service')->setClass('PathCollection');
		$this->paths = $this->container->getInstanceOf('path_collection_service');

		$this->container->define('package_collection_service')->setClass('PackageCollection');
		$this->packages = $this->container->getInstanceOf('package_collection_service');
	}

	public function configure()
	{
		$this->loadPackagePaths();
		$this->loadPackages();
		$this->loadWiring();
		$this->loadEvents();
	}

	abstract function run();

	abstract function registerPackages();

	abstract function registerPackagePaths();

	abstract function registerWiring();

	protected function loadPackagePaths()
	{
		$this->packagePaths = $this->registerPackagePaths();
		if (is_array($this->packagePaths))
		{
			foreach ($this->packagePaths as $path)
				require $path;
		}
		else
			$this->packagePaths = array();

		$this->container->setConstant('package.paths', $this->packagePaths);
	}

	protected function loadPackages()
	{
		$packageArray = $this->registerPackages();
		if (is_array($packageArray))
		{
			foreach ($packageArray as $package)
				$package->register($this->container, $this->paths);
		}
		else
			$packageArray = array();

		$this->packages->setPackages($packageArray);
	}

	protected function loadWiring()
	{
		$builder = $this->registerWiring();
		if (is_object($builder))
			$this->container->merge($builder);
	}

	protected function loadEvents()
	{
		$emitter = $this->container->getInstanceOf('event_emitter_service');
		$definitions = $this->container->getNotedDefinitions('listener');
		foreach ($definitions as $definition)
		{
			$listeners = $definition->getNote('listener');
			foreach ($listeners as $listener)
				$emitter->attach($listener[0], array('lazy', $definition->getId(), $listener[1]));
		}
	}

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
