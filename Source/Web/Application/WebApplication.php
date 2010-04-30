<?php

/**
 * A Runnable application, with Routing.
 *
 * @package    BachelorThesis
 * @subpackage Application
 */
abstract class WebApplication extends Application
{
	public function run()
	{
		$request = $this->container->getInstanceOf('request_service');
		$runner  = $this->container->getInstanceOf('controller_runner_service');
		return $runner->respondTo($request);
	}

	public function configure()
	{
		parent::configure();
		$this->loadRouting();
	}

	abstract function registerRouting();

	protected function loadRouting()
	{
		$rules = $this->registerRouting();
		if (is_array($rules))
		{
			$this->container->getDefinition('router_service')
				->addMethod('addRules', array(
					array('value', $rules)
				));
		}
	}

	protected function loadPackages()
	{
		parent::loadPackages();
		$this->container->addConstants(array(
			'controller.paths' => $this->paths->getPaths('controllers'),
			'command.paths'    => $this->paths->getPaths('commands'),
			'view.paths'       => $this->paths->getPaths('views'),
		));
	}
}
