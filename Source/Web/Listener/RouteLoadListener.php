<?php

class RouteLoadListener
{
	protected $router;

	public function  __construct(IRouter $router)
	{
		$this->router = $router;
	}

	public function handle(IEvent $event)
	{
		$request = $event->getParameter('request');
		$route = $this->router->fetchRoute($request->getPathInfo());
		$event->setValue($route);
		return $route !== false;
	}
}
