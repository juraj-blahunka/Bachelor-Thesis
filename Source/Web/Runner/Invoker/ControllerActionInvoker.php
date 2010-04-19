<?php

class ControllerActionInvoker implements IActionInvoker
{
	protected $cache;
	protected $naming;

	public function  __construct(IReflectionCache $cache, ISimpleNameStrategy $naming)
	{
		$this->cache  = $cache;
		$this->naming = $naming;
	}

	public function canInvoke($controller, IRoute $route)
	{
		$action = $this->naming->getName($route->getAction());
		$method = $this->getActionMethod($controller, $action);
		return $method && $method->isPublic() && (! $method->isStatic());
	}

	/**
	 * Call controller's action with parameters
	 *
	 * @param Object $controller
	 * @param IRoute $route
	 * @return mixed
	 */
	public function invoke($controller, IRoute $route)
	{
		$action    = $this->naming->getName($route->getAction());
		$method    = $this->getActionMethod($controller, $action);
		$arguments = $this->findArguments($method, $route->getParameters());
		return $method->invokeArgs($controller, $arguments);
	}

	protected function getActionMethod($controller, $action)
	{
		$className = get_class($controller);
		if ($this->cache->hasMethod($className, $action))
			return $this->cache->retrieveMethod($className, $action);

		$class = new ReflectionClass($controller);
		if (! $class->hasMethod($action))
			return false;
		$method = $class->getMethod($action);
		$this->cache->storeMethod($method);
		return $method;
	}

	/**
	 * Find correct controller's action arguments from $parameters, based
	 * on method's parameter names
	 *
	 * @param ReflectionMethod $method
	 * @param array $parameters
	 * @return array
	 */
	protected function findArguments(ReflectionMethod $method, array $parameters)
	{
		foreach ($parameters as $key => $value)
			$parameters[str_replace('-', '_', $key)] = $value;

		$result = array();
		foreach ($method->getParameters() as $parameter)
		{
			if (isset($parameters[$parameter->getName()]))
				$result[] = $parameters[$parameter->getName()];
			else if ($parameter->isOptional() || $parameter->isDefaultValueAvailable())
				$result[] = $parameter->getDefaultValue();
			else
				throw new NotFoundHttpException("Argument {$parameter->getName()} in {$method->getDeclaringClass()->getName()}::{$method->getName()} was not found in parameters");
		}
		return $result;
	}
}
