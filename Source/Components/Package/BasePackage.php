<?php

abstract class BasePackage implements IPackage
{
	private
		$classLoaders,
		$packages;

	/**
	 * Template method for registering class loaders, nested packages and
	 * configuring the dependency injection container
	 *
	 * @param IContainerBuilder $builder
	 */
	public function register(IContainerBuilder $builder)
	{
		$this->classLoaders  = $this->registerClassLoaders();
		foreach ($this->classLoaders as $classLoader)
		{
			$classLoader->registerClassLoader();
		}
		
		$this->registerWiring($builder);

		$this->packages = $this->registerPackages();
		foreach ($this->packages as $package)
		{
			$package->register($builder);
		}
	}

	abstract function registerClassLoaders();

	abstract function registerPackages();

	abstract function registerWiring(IContainerBuilder $container);
}
