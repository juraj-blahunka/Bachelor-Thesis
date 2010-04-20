<?php

class ControllerLoader implements IControllerLoader
{
	protected
		$container,
		$paths,
		$controllerNaming;

	public function __construct(PathCollection $paths, IDependencyInjectionContainer $container, INameStrategy $controllerNaming)
	{
		$this->paths            = $paths;
		$this->container        = $container;
		$this->controllerNaming = $controllerNaming;
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
		$package  = $route->getPackage();
		$name     = $route->getController();
		$fileName = $this->controllerNaming->getFileName($name);
		$class    = $this->controllerNaming->getClassName($name);

		if (! $this->includeController($package, $class, $fileName))
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
	protected function includeController($package, $class, $fileName)
	{
		if (class_exists($class, true))
			return true;

		$paths = $this->paths->getPaths($package.'.controllers');
		foreach ($paths as $dir)
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
