<?php

class FrontendApplication extends Application
{
	public function getApplicationName()
	{
		return 'Frontend';
	}

	protected function registerPackages()
	{
		return array(
			new FrameworkPackage(),
			new FrontendPackage(),
		);
	}

	protected function registerPackagePaths()
	{
		return array(
			dirname(__FILE__).'/../FrameworkPackage.php',
			dirname(__FILE__).'/FrontendPackage.php',
		);
	}
}
