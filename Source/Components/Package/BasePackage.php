<?php

abstract class BasePackage implements IPackage
{
	private
		$classLoaders,
		$packages;

	public function register()
	{
		$this->classLoaders  = $this->registerClassLoaders();
		foreach ($this->classLoaders as $classLoader)
		{
			$classLoader->registerClassLoader();
		}
		$this->packages = $this->registerPackages();
		foreach ($this->packages as $package)
		{
			$package->register();
		}

	}

	abstract function registerClassLoaders();

	abstract function registerPackages();
}
