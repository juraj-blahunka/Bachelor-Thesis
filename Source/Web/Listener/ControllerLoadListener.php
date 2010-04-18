<?php

class ControllerLoadListener
{
	private $loader;

	public function __construct(ControllerLoader $loader)
	{
		$this->loader = $loader;
	}
	public function handle(IEvent $event)
	{
		$route      = $event->getParameter('route');
		$controller = $this->loader->loadController($route->getController());
		if ($controller)
		{
			$event->setValue($controller);
			return true;
		}
		else
			return false;
	}
}
