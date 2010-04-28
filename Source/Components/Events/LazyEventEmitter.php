<?php

class LazyEventEmitter extends EventEmitter
{
	protected $container;

	/**
	 * Constructor.
	 *
	 * @param IDependencyInjectionContainer $container
	 */
	public function __construct(IDependencyInjectionContainer $container)
	{
		$this->container = $container;
	}

	/**
	 * Retrieve listeners attached to $name event.
	 *
	 * If listener is declared lazy ($listener[0] === 'lazy'), the listener
	 * is substitutes with new instantiated listener. Instantiation is
	 * provided by IDependencyInjectionContainer instance.
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

		foreach ($this->listeners[$name] as $key => $listener)
		{
			if (count($listener) === 3 && isset($listener[0]) && ($listener[0] === 'lazy'))
			{
				$newListener = array(
					$this->container->getInstanceOf($listener[1]),
					$listener[2]
				);
				$this->listeners[$name][$key] = $newListener;
			}
		}

		return $this->listeners[$name];
	}
}
