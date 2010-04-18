<?php

abstract class WebApplication extends Application
{
	public function run()
	{
		$request = $this->container->getInstanceOf('Request');
		$runner  = $this->container->getInstanceOf('ControllerRunner');
		return $runner->run($request);
	}

	public function configure()
	{
		parent::configure();
		$rules = $this->registerRouting();
		if (is_array($rules))
		{
			$router = $this->container->getInstanceOf('RouterManager');
			$router->addRules($rules);
		}
	}

	abstract function registerRouting();
}
