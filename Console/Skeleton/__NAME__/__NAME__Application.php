<?php

class {{ name }}Application extends WebApplication
{
	public function registerPackages()
	{
		return array(
			new FrameworkPackage(),
			new {{ name }}Package(),
		);
	}

	public function registerPackagePaths()
	{
		return array(
			dirname(__FILE__).'/path_to_framework_package/FrameworkPackage.php',
			dirname(__FILE__).'/../Packages/{{ package }}/{{ package }}Package.php',
		);
	}

	public function registerWiring()
	{
		$loader = new ContainerPhpFileLoader(new ContainerArrayLoader());
		return $loader->load(dirname(__FILE__).'/Resources/{{ name }}Configuration.php');
	}

	public function registerRouting()
	{
		$data = include dirname(__FILE__).'/Resources/{{ name }}Routing.php';
		$loader = new RoutingRuleArrayLoader({{ name }});
		return $loader->load($data);
	}
}
