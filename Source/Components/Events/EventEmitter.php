<?php

class EventEmitter implements IEventEmitter
{
	protected $listeners = array();

	/**
	 * Attach array listener to event name.
	 *
	 * @param string $name
	 * @param array $listener Callable
	 */
	public function attach($name, $listener)
	{
		if (!isset($this->listeners[$name]))
		{
			$this->listeners[$name] = array();
		}
		$this->listeners[$name][] = $listener;
	}

	/**
	 * Remove the listener from events defined by name.
	 * Returns false, when listener is not found, true otherwise.
	 *
	 * @param string $name
	 * @param array $listener
	 * @return bool
	 */
	public function detach($name, $listener)
	{
		if (! isset($this->listeners[$name]))
		{
			return false;
		}

		$found = false;
		foreach ($this->listeners[$name] as $index => $callable)
		{
			if ($listener == $callable)
			{
				unset($this->listeners[$name][$index]);
				$found = true;
			}
		}
		return $found;
	}

	/**
	 * Get callable listeners of event defined by name
	 *
	 * @param string $name
	 * @return array
	 */
	public function getListeners($name)
	{
		if (! isset($this->listeners[$name]))
		{
			$this->listeners[$name] = array();
		}

		return $this->listeners[$name];
	}

	/**
	 * Notifies all listeners of event name.
	 *
	 * @param IEvent $event
	 * @return IEvent
	 */
	public function notify(IEvent $event)
	{
		foreach ($this->getListeners($event->getName()) as $callable)
		{
			$this->emitEvent($event, $callable);
		}

		return $event;
	}

	/**
	 * Notifies all listeners of event name, unit the callable returns $state,
	 * or the $event is set to handled.
	 *
	 * @param IEvent $event
	 * @param mixed $state
	 * @return IEvent
	 */
	public function notifyUntil(IEvent $event, $state = true)
	{
		foreach ($this->getListeners($event->getName()) as $callable)
		{
			$result = $this->emitEvent($event, $callable);
			if (($result === $state) || $event->isHandled())
			{
				$event->setHandled(true);
				break;
			}
		}

		return $event;
	}

	/**
	 * Calls the callable with $event as parameter.
	 * Returns the callable result.
	 *
	 * @param IEvent $event
	 * @param array $callable
	 * @return mixed
	 */
	protected function emitEvent(IEvent $event, array $callable)
	{
		return call_user_func($callable, $event);
	}
}
