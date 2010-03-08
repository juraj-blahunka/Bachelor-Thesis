<?php

class Dispatcher implements IDispatcher
{
	protected $listeners = array();

	public function attach($name, $listener)
	{
		if (!isset($this->listeners[$name]))
		{
			$this->listeners[$name] = array();
		}
		$this->listeners[$name][] = $listener;
	}
	
	public function detach($name, $listener)
	{
		if (! isset($this->listeners[$name]))
		{
			return false;
		}
		
		foreach ($this->listeners[$name] as $index => $callable)
		{
			if ($listener == $callable)
			{
				unset($this->listeners[$name][$index]);
			}
		}
	}
	
	public function getListeners($name)
	{
		if (! isset($this->listeners[$name]))
		{
			$this->listeners[$name] = array();
		}
		
		return $this->listeners[$name];
	}
	
	public function notify(IEvent $event)
	{
		foreach ($this->getListeners($event->getName()) as $callable)
		{
			call_user_func($callable, $event);
		}
		
		return $event;
	}
	
	public function notifyUntil(IEvent $event, $state = true)
	{
		foreach ($this->getListeners($event->getName()) as $callable)
		{
			$result = call_user_func($callable, $event);
			if (($result === $state) || $event->isHandled())
			{
				$event->setHandled(true);
				break;
			}
		}
		
		return $event;
	}
}
