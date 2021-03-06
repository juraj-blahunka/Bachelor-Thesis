<?php

/**
 * Executes methods on an instance.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
class MethodsAfterConstructionAdapter extends DecoratingComponentAdapter
{
	/**
	 * Methods to be called after component instantiation.
	 *
	 * @var array
	 */
	private $methods;

	/**
	 * Constructor.
	 *
	 * @param array $methods
	 * @param IComponentAdapter $adapter
	 */
	public function __construct(array $methods, IComponentAdapter $adapter)
	{
		parent::__construct($adapter);
		$this->methods = $methods;
	}

	/**
	 * Get Methods.
	 *
	 * @return array
	 */
	public function getMethods()
	{
		return $this->methods;
	}

	/**
	 * Get instance of decorated adapter instantiation.
	 * Apply methods on object instance.
	 *
	 * @param IDependencyInjectionContainer $container
	 * @return mixed The object instance
	 */
	public function getInstance(IDependencyInjectionContainer $container)
	{
		$instance = parent::getInstance($container);
		foreach ($this->getMethods() as $method)
		{
			list($methodName, $arguments) = $method;

			$methodReflection = new ReflectionMethod($instance, $methodName);

			if (count($arguments))
			{
				$resolved = $this->resolveArguments($container, $arguments);
				call_user_func_array(array($instance, $methodName), $resolved);
			}
			else if($methodReflection && $methodReflection->getParameters())
			{
				$argsToPass = $this->getArgumentsOfMethod($container, $methodReflection);
				call_user_func_array(array($instance, $methodName), $argsToPass);
			}
			else
				call_user_func(array($instance, $methodName));
		}
		return $instance;
	}
}
