<?php

abstract class BasePackage implements IPackage
{
	private
		$classLoaders,
		$packages;

	public function register(IDependencyInjectionContainer $container)
	{
		$this->classLoaders  = $this->registerClassLoaders();
		foreach ($this->classLoaders as $classLoader)
		{
			$classLoader->registerClassLoader();
		}
		
		$this->registerWiring($container);

		$this->packages = $this->registerPackages();
		foreach ($this->packages as $package)
		{
			$package->register($container);
		}

	}

	abstract function registerClassLoaders();

	abstract function registerPackages();

	abstract function registerWiring(IDependencyInjectionContainer $container);
}
