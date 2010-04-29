<?php

class {{ name }}Application extends WebApplication
{
	public function registerPackages()
	{
		return array(
			new FrameworkPackage(),
			new {{ package }}Package(),
		);
	}

	public function registerPackagePaths()
	{
		return array(
			dirname(__FILE__).'/../../../Bachelor-Thesis/Source/FrameworkPackage.php',
			dirname(__FILE__).'/../Packages/{{ package }}/{{ package }}Package.php',
		);
	}

	public function registerConfiguration()
	{
		$loader = new ContainerPhpFileLoader(new ContainerArrayLoader());
		return $loader->load(dirname(__FILE__).'/Resources/{{ name }}Configuration.php');
	}

	public function registerRouting()
	{
		$data = include dirname(__FILE__).'/Resources/{{ name }}Routing.php';
		$loader = new RoutingRuleArrayLoader('{{ package }}');
		return $loader->load($data);
	}
}
