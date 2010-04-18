<?php

class Controller extends BaseController
{
	public function getRequest()
	{
		return $this->container->getInstanceOf('Request');
	}

	public function getResponse()
	{
		return $this->container->getInstanceOf('Response');
	}

	public function getRenderableResponse(IResponse $original)
	{
		return $this->container->getInstanceOfWith('RenderableResponse', array(
			array('value', $original)
		));
	}

	public function getRouter()
	{
		return $this->container->getInstanceOf('RouterManager');
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
		$runner = $this->container->getInstanceOf('ControllerRunner');
		return $runner->respond($route);
	}
}
