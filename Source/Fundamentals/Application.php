<?php

class Application
{
	protected
		$environment,
		$debug,
		$packages,
		$packagePaths,
		$initialized;

	public function __construct($environment, $debug)
	{
		$this->environment  = $environment;
		$this->debug        = $debug;
		$this->initialized  = false;

		$this->packages     = $this->registerPackages();
		$this->packagePaths = $this->registerPackagePaths();
	}

	abstract function registerPackages() {}

	abstract function registerPackagePaths() {}

	abstract function getApplicationName() {}

	protected function initialize()
	{
		if ($this->initialized)
		{
			throw new Exception('Application already initalized');
		}
		$this->initialized = true;

		$this->container = new DIContainer();

		foreach ($this->packagePaths as $path)
		{
			require $path;
		}
		
		foreach ($this->packages as $package)
		{
			$package->register($this->container);
		}
	}

	public function run()
	{
		if (! $this->initialized)
		{
			$this->initialize();
		}
		$request = $this->container->getRequestService();
		$handler = $this->container->getRequestHandlerService();

		$response = $handler->handle($request);

		$response->send();
	}

	public function getEnvironment()
	{
		return $this->environment;
	}

	public function isDebug()
	{
		return $this->debug;
	}
}
