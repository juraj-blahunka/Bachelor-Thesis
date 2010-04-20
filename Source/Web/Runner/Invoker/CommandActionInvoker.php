<?php

class CommandActionInvoker implements IActionInvoker
{
	private
		$paths,
		$container,
		$cache,
		$commandNaming;

	public function __construct(PathCollection $paths, IDependencyInjectionContainer $container, IReflectionCache $cache, INameStrategy $commandNaming)
	{
		$this->paths         = $paths;
		$this->container     = $container;
		$this->cache         = $cache;
		$this->commandNaming = $commandNaming;
	}

	public function canInvoke($controller, IRoute $route)
	{
		$commandName = $this->commandNaming->getName($route->getAction());
		$package     = $route->getPackage();

		if (!($location = $this->findCommandLocation($commandName, $controller->getCommands())))
			return false;

		$commandClass = $this->commandNaming->getClassName($location);
		if (! $this->includeCommand($package, $location, $commandClass))
			return false;

		$reflection = $this->getCommandClassReflection($commandClass);
		if (! $reflection->hasMethod('execute'))
			return false;

		$method       = $reflection->getMethod('execute');
		$isController = $reflection->implementsInterface('IController');
		$isInvokable  = $method->isPublic() && (! $method->isStatic());

		return $isController && $isInvokable;
	}

	public function invoke($controller, IRoute $route)
	{
		$location = $this->findCommandLocation($this->commandNaming->getName($route->getAction()), $controller->getCommands());
		$commandClass = $this->commandNaming->getClassName($location);
		$commandClass = $this->container->getInstanceOf($commandClass);
		$commandClass->setContainer($this->container);
		return call_user_func(array($commandClass, 'execute'));
	}

	protected function includeCommand($package, $location, $class)
	{
		if (class_exists($class, true))
			return true;

		$paths = $this->paths->getPaths($package.'.commands');
		foreach ($paths as $dir)
		{
			$file = $dir . DIRECTORY_SEPARATOR . $location . '.php';
			if (! file_exists($file))
				continue;
			include $file;
			if (class_exists($class))
				return true;
		}
		return false;
	}

	protected function getCommandClassReflection($commandClass)
	{
		if ($this->cache->hasClass($commandClass))
			$reflection = $this->cache->retrieveClass($commandClass);
		else
		{
			$reflection = new ReflectionClass($commandClass);
			$this->cache->storeClass($reflection);
		}
		return $reflection;
	}

	protected function findCommandLocation($name, array $commands)
	{
		if (! isset($commands[$name]))
			return false;
		$location = $commands[$name];
		return $this->commandNaming->getFileName($location);
	}
}
