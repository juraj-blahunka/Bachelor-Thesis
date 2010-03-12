<?php

class FrontendPackage extends ApplicationPackage implements IPackage
{
	public function getPackageName()
	{
		return 'Frontend';
	}

	public function register()
	{

	}

	public function registerClassLoaders()
	{
		return array(

		);
	}
}
