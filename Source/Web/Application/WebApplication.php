<?php

abstract class WebApplication extends Application
{
	public function run()
	{
		$request = $this->container->getInstanceOf('request_service');
		$runner  = $this->container->getInstanceOf('ControllerRunner');
		return $runner->run($request);
	}

	public function configure()
	{
		parent::configure();
		$rules = $this->registerRouting();
		if (is_array($rules))
		{
			$this->container->getDefinition('router_service')
				->addMethod('addRules', array(
					array('value', $rules)
				));
		}
	}

	abstract function registerRouting();
}
