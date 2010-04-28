<?php

class FrameworkPackage extends Package
{
	public function getPackageName()
	{
		return 'Framework';
	}

	public function registerPackages()
	{
		return array();
	}

	public function registerPaths() {}

	public function registerWiring(IContainerBuilder $builder)
	{
		$components = dirname(__FILE__) . '/Resources/ComponentsConfiguration.php';
		$web        = dirname(__FILE__) . '/Resources/WebConfiguration.php';

		$loader = new ContainerPhpFileLoader(new ContainerArrayLoader());
		$builder->merge($loader->load($components));
		$builder->merge($loader->load($web));
	}

	public function registerClassLoaders()
	{
		$loaders = include(dirname(__FILE__) . '/Resources/FrameworkClassLoaders.php');
		return $loaders;
	}
}
