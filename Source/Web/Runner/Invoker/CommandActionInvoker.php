<?php

class CommandActionInvoker implements IActionInvoker
{
	private
		$directories,
		$container,
		$cache,
		$naming;

	public function __construct(array $directories, IDependencyInjectionContainer $container, IReflectionCache $cache, INameStrategy $naming)
	{
		$this->directories = $directories;
		$this->container   = $container;
		$this->cache       = $cache;
		$this->naming      = $naming;
	}

	public function canInvoke($controller, IRoute $route)
	{
		$commandName = $this->naming->getName($route->getAction());
		if (!($location = $this->findCommandLocation($commandName, $controller->getCommands())))
			return false;

		$commandClass = $this->naming->getClassName($location);
		if (! $this->includeCommand($location, $commandClass))
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
		$location = $this->findCommandLocation($this->naming->getName($route->getAction()), $controller->getCommands());
		$commandClass = $this->naming->getClassName($location);
		$commandClass = $this->container->getInstanceOf($commandClass);
		$commandClass->setContainer($this->container);
		return call_user_func(array($commandClass, 'execute'));
	}

	protected function includeCommand($location, $class)
	{
		if (class_exists($class, true))
			return true;
		foreach ($this->directories as $dir)
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
		return $this->naming->getFileName($location);
	}
}
