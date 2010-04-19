<?php

class ControllerRunner
{
	private $emitter;

	public function __construct(IEventEmitter $emitter)
	{
		$this->emitter = $emitter;
	}

	public function run(IRequest $request)
	{
		try
		{
			$route = $this->notifyLoadRoute($request);
			return $this->respond($route);
		}
		catch (Exception $e)
		{
			$event = new Event($this, 'application.exception', array(
				'exception' => $e
			));
			$this->emitter->notifyUntil($event);
			if ($event->isHandled() && $event->hasParameter('response'))
				return $this->filterResponse($event->getParameter('response'));

			throw $e;
		}
	}

	public function respond(IRoute $route)
	{
		// load controller instance
		$controller = $this->notifyLoadController($route);

		// invoke controller instance with route parameters
		$response   = $this->notifyInvokeController($route, $controller);

		// decorate controller with appropriate view
		$response   = ($response instanceof IRenderableResponse)
			? $this->notifyView($response)
			: $response;
		

		return $this->filterResponse($response);
	}

	protected function notifyLoadRoute(IRequest $request)
	{
		$event = new Event($this, 'route.load', array(
			'request' => $request
		));
		$this->emitter->notifyUntil($event);
		if (! $event->isHandled())
			throw new NotFoundHttpException("No route found for request");
		return $event->getValue();
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

	protected function notifyView(IRenderableResponse $response)
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
