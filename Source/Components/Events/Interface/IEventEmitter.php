<?php

/**
 * Attaching, detaching listeners from events and event notification.
 *
 * @package    BachelorThesis
 * @subpackage Events
 */
interface IEventEmitter
{
	function attach($name, $listener);
	function detach($name, $listener);

	function getListeners($name);

	function notify(IEvent $event);
	function notifyUntil(IEvent $event, $state = true);
}
