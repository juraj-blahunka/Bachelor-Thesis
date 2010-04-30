<?php

/**
 * Listener to invoke controller's action.
 *
 * @package    BachelorThesis
 * @subpackage Listener
 */
class ControllerInvokeListener
{
	private $invoker;

	public function __construct(IActionInvoker $invoker)
	{
		$this->invoker = $invoker;
	}

	public function handle(IEvent $event)
	{
		$route      = $event->getParameter('route');
		$controller = $event->getParameter('controller');

		if (! $this->invoker->canInvoke($controller, $route))
			return false;

		$result = $this->invoker->invoke($controller, $route);
		$event->setValue($result);
		return true;
	}
}
