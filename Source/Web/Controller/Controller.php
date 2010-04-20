<?php

class Controller extends BaseController
{
	private $_response;

	public function getRequest()
	{
		return $this->container->getInstanceOf('request_service');
	}

	public function getResponse()
	{
		if ($this->_response === null)
			$this->_response = $this->container->getInstanceOf('response_service');
		return $this->_response;
	}

	public function getRenderableResponse(IResponse $original = null)
	{
		return $this->container->getInstanceOfWith('renderable_response_service', array(
			array('value', is_null($original) ? $this->getResponse() : $original)
		));
	}

	public function getRouter()
	{
		return $this->container->getInstanceOf('router_service');
	}

	public function render($view, $variables)
	{
		$response = $this->getRenderableResponse($this->getResponse());
		$response->setViewName($view);
		$response->setVariables($variables);
		return $response;
	}

	public function forward($package, $controller, $action, array $parameters = array())
	{
		$route = $this->container->getInstanceOf('Route');
		$route->setPackage($package)
			->setController($controller)
			->setAction($action)
			->setParameters($parameters);
		$runner = $this->container->getInstanceOf('controller_runner_service');
		return $runner->run($route);
	}
}
