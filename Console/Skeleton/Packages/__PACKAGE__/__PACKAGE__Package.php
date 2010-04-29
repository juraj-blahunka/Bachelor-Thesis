<?php

class {{ package }}Package extends MvcPackage
{
	public function getPackageName()
	{
		return '{{ package }}';
	}

	public function registerClassLoaders() {}

	public function registerPaths() {}

	public function registerWiring(IContainerBuilder $container)
	{
		$loader  = new ContainerPhpFileLoader(new ContainerArrayLoader());
		$builder = $loader->load(dirname(__FILE__).'/Resources/{{ package }}PackageConfiguration.php');
		$container->merge($builder);
	}

	public function registerControllerPaths()
	{
		return array(
			dirname(__FILE__).'/Controllers'
		);
	}

	public function registerCommandPaths()
	{
		return array(
			dirname(__FILE__).'/Commands'
		);
	}

	public function registerViewPaths()
	{
		return array(
			dirname(__FILE__).'/Views'
		);
	}
}
