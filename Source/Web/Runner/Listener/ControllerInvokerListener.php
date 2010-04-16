<?php

class ControllerInvokerListener
{
	private $invoker;

	public function __construct(IActionInvoker $invoker)
	{
		$this->invoker = $invoker;
	}

	public function handle(IEvent $event)
	{
		$action     = $event->getParameter('route')->getAction();
		$parameters = $event->getParameter('route')->getParameters();
		$controller = $event->getParameter('controller');

		if (! $this->invoker->canInvoke($controller, $action, $parameters))
			return false;

		$result = $this->invoker->invoke($controller, $action, $parameters);
		$event->setValue($result);
		return true;
	}
}
