<?php

abstract class BasePackage implements IPackage
{
	private
		$classLoaders;

	public function register()
	{
		$this->classLoaders  = $this->registerClassLoaders();
		foreach ($this->classLoaders as $classLoader)
		{
			$classLoader->registerClassLoader();
		}
	}

	abstract function registerClassLoaders();
}
