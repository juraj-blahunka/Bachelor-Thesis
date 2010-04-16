<?php

class ControllerRunner
{
	private $emitter;

	public function __construct(IEventEmitter $emitter)
	{
		$this->emitter = $emitter;
	}

	public function runSafe(IRoute $route)
	{
		try
		{
			return $this->run($route);
		}
		catch (Exception $e)
		{
			$event = new Event($this, 'application.exception', array(
				'exception' => $e
			));
			$this->emitter->notifyUntil($event);
			if ($event->isHandled())
				return $this->filterResponse($event->getParameter('response'));

			throw $e;
		}
	}

	public function run(IRoute $route)
	{
		// load controller instance
		$controller = $this->notifyLoadController($route);

		// invoke controller instance with route parameters
		$response   = $this->notifyInvokeController($route, $controller);

		// decorate controller with appropriate view
		$response   = $this->notifyView($response);

		return $this->filterResponse($response);
	}

	protected function notifyLoadController(IRoute $route)
	{
		$event = new Event($this, 'controller.load', array(
			'route'   => $route,
		));
		$this->emitter->notifyUntil($event);
		if (! $event->isHandled())
			throw new NotFoundHttpException("Controller {$route->getController()} couldn't be loaded");
		if (! is_object($event->getValue()))
			throw new RuntimeException('Controller is not an object instance');
		return $event->getValue();
	}

	protected function notifyInvokeController(IRoute $route, IController $controller)
	{
		$event = new Event($this, 'controller.invoke', array(
			'controller' => $controller,
			'route'      => $route,
		));
		$this->emitter->notifyUntil($event);
		if (! $event->isHandled())
			throw new NotFoundHttpException("Controller {$route->getController()} couldn't be invoked");
		return $event->getValue();
	}

	protected function notifyView(IResponse $response)
	{
		$event = new Event($this, 'controller.view', array(
			'response' => $response,
		));
		$this->emitter->notifyUntil($event);
		return $event->isHandled() ? $event->getValue() : $response;
	}

	protected function filterResponse($response)
	{
		if (! $response instanceof IResponse)
			throw new RuntimeException("Response result is not compliant to IResponse interface");
		$event = new Event($this, 'controller.response', array(
			'response' => $response
		));
		$this->emitter->notify($event);
		$response = $event->getParameter('response');
		if (! $response instanceof IResponse)
			throw new RuntimeException("Response result is not compliant to IResponse interface");
		return $response;
	}
}
