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
		$this->classLoaders = $this->registerClassLoaders();
		if (is_array($this->classLoaders))
		{
			foreach ($this->classLoaders as $classLoader)
				$classLoader->registerClassLoader();
		}
		else
			$this->classLoaders = array();

		$this->registerWiring($builder);

		$this->packages = $this->registerPackages();
		if (is_array($this->packages))
		{
			foreach ($this->packages as $package)
				$package->register($builder);
		}
		else
			$this->packages = array();
	}

	abstract function registerClassLoaders();

	abstract function registerPackages();

	abstract function registerWiring(IContainerBuilder $container);
}
