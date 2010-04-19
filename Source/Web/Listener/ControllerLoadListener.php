<?php

class ControllerLoadListener
{
	private $loader;

	public function __construct(IControllerLoader $loader)
	{
		$this->loader = $loader;
	}

	public function handle(IEvent $event)
	{
		$route      = $event->getParameter('route');
		$controller = $this->loader->loadController($route);
		if ($controller)
		{
			$event->setValue($controller);
			return true;
		}
		else
			return false;
	}
}
