<?php

/**
 * Invokes Command instances.
 *
 * @package    BachelorThesis
 * @subpackage Runner
 */
class CommandActionInvoker implements IActionInvoker
{
	private
		$paths,
		$container,
		$cache,
		$actionNaming,
		$commandNaming;

	public function __construct(PathCollection $paths, IDependencyInjectionContainer $container, IReflectionCache $cache, ISimpleNameStrategy $actionNaming, INameStrategy $commandNaming)
	{
		$this->paths         = $paths;
		$this->container     = $container;
		$this->cache         = $cache;
		$this->actionNaming  = $actionNaming;
		$this->commandNaming = $commandNaming;
	}

	/**
	 * Transform the action name by using actionNaming,
	 * find the Command name identifier inside the $controller::getCommands().
	 * If command is not set, return false.
	 *
	 * @param mixed $controller
	 * @param IRoute $route
	 * @return mixed
	 */
	protected function getCommandIdentifier($controller, IRoute $route)
	{
		$commands = $controller->getCommands();
		$actionName = $this->actionNaming->getName($route->getAction());
		return isset($commands[$actionName])
			? $commands[$actionName]
			: false;
	}

	/**
	 * Check, if action name can be found in commands declared by $controller.
	 *
	 * @param <type> $controller
	 * @param IRoute $route
	 * @return <type>
	 */
	public function canInvoke($controller, IRoute $route)
	{
		$identifier = $this->getCommandIdentifier($controller, $route);
		return ($identifier === false)
			? false
			: true;
	}

	public function invoke($controller, IRoute $route)
	{
		$identifier = $this->getCommandIdentifier($controller, $route);
		$classname  = $this->commandNaming->getClassName($identifier);
		$filename   = $this->commandNaming->getFileName($identifier);

		if (! $this->includeCommand($route->getPackage(), $filename, $classname))
			throw new RuntimeException("Couldn't find command with class '{$classname}' in '{$filename}'");

		$reflection = $this->getCommandClassReflection($classname);
		$this->checkInvokableClass($reflection);

		$command = $this->container->getInstanceOf($classname);
		$command->setContainer($this->container);
		return call_user_func(array($command, 'execute'));
	}

	protected function checkInvokableClass(ReflectionClass $reflection)
	{
		$classname = $reflection->getName();
		if (! $reflection->hasMethod('execute'))
			throw new RuntimeException("Command '{$classname}' doesn't implement execute method");

		$method = $reflection->getMethod('execute');
		if ((! $method->isPublic()) || $method->isStatic())
			throw new RuntimeException("Method 'execute' is either static or not public, so it cannot be called");

		if (! $reflection->implementsInterface('IController'))
			throw new RuntimeException("Cannot instantiate '{$classname}' it doesn't implement IController interface");
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
}
