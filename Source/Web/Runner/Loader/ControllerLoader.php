<?php

class ControllerLoader implements IControllerLoader
{
	protected
		$container,
		$directories,
		$naming;

	public function __construct(array $directories, IDependencyInjectionContainer $container, INameStrategy $naming)
	{
		$this->directories = $directories;
		$this->container   = $container;
		$this->naming      = $naming;
	}

	/**
	 * Container creates a controller instance or returns false, if
	 * controller couldn't be created.
	 *
	 * @param IRoute $route Routing information about controller
	 * @return mixed Controller instance or false
	 */
	public function loadController(IRoute $route)
	{
		$name     = $route->getController();
		$fileName = $this->naming->getFileName($name);
		$class    = $this->naming->getClassName($name);

		if (! $this->includeController($class, $fileName))
			return false;
		else
		{
			$controller = $this->container->getInstanceOf($class);;
			$controller->setContainer($this->container);
			return $controller;
		}
	}

	/**
	 * Load controller file based on $fileName.
	 * Returns true if controller file was succesfully included, false instead.
	 *
	 * @param string $class
	 * @param string $fileName
	 * @return Boolean
	 */
	protected function includeController($class, $fileName)
	{
		if (class_exists($class, true))
			return true;

		foreach ($this->directories as $dir)
		{
			$location = $dir . DIRECTORY_SEPARATOR . $fileName . '.php';
			if (! file_exists($location))
				continue;
			include $location;
			if (class_exists($class))
				return true;
		}
		return false;
	}
}
