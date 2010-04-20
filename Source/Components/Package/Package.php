<?php

abstract class Package implements IPackage
{
	private	$classLoaders;

	/**
	 * Template method for registering class loaders, nested packages and
	 * configuring the dependency injection container
	 *
	 * @param IContainerBuilder $builder
	 */
	public function register(IContainerBuilder $builder, PathCollection $paths)
	{
		$this->classLoaders = $this->registerClassLoaders();
		if (is_array($this->classLoaders))
		{
			foreach ($this->classLoaders as $classLoader)
				$classLoader->registerClassLoader();
		}
		else
			$this->classLoaders = array();

		$newPaths = $this->registerPaths();
		if (is_object($newPaths))
			$paths->merge($newPaths);

		$this->registerWiring($builder);
	}
}
