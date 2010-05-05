<?php

/**
 * Responds to request or runs routing information.
 *
 * @package    BachelorThesis
 * @subpackage Runner
 */
class ControllerRunner implements IControllerRunner
{
	protected $emitter;

	public function __construct(IEventEmitter $emitter)
	{
		$this->emitter = $emitter;
	}

	public function respondTo(IRequest $request)
	{
		try
		{
			$route = $this->notifyLoadRoute($request);
			$request->setRoute($route);
			return $this->run($route);
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

	public function run(IRoute $route)
	{
		// load controller instance
		$controller = $this->notifyLoadController($route);

		// invoke controller instance with route parameters
		$response   = $this->notifyInvokeController($route, $controller);

		// decorate controller with appropriate view
		$response   = ($response instanceof IResponse)
			? $response
			: $this->notifyView($route, $response);

		return $this->filterResponse($response);
	}

	protected function notifyLoadRoute(IRequest $request)
	{
		$event = new Event($this, 'route.load', array(
			'request' => $request
		));
		$this->emitter->notifyUntil($event);
		if (! $event->isHandled())
			throw new NotFoundHttpException("No route found for '{$request->getPathInfo()}' request");
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

	protected function notifyView(IRoute $route, IResponsePresenter $presenter)
	{
		$this->emitter->notify(new Event($this, 'controller.view_context', array(
			'route'      => $route,
			'presenter'  => $presenter,
		)));
		$event = new Event($this, 'controller.view', array(
			'route'      => $route,
			'presenter'  => $presenter,
		));
		$this->emitter->notifyUntil($event);
		if (! $event->isHandled())
			throw new RuntimeException("No template applied for '{$presenter->getViewName()}' view name, which was called by '{$route->getController()}/{$route->getAction()}'");
		return $event->getValue();
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
