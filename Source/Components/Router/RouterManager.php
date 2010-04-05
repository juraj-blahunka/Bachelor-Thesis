<?php

class RouterManager implements IRouter
{
	private
		$rules,
		$factory,
		$matcher,
		$compiler,
		$creator;

	public function __construct(IRouterFactory $factory, IRouteMatcher $matcher, IRoutingRuleCompiler $compiler, IUrlCreator $creator)
	{
		$this->rules    = array();
		$this->factory  = $factory;
		$this->matcher  = $matcher;
		$this->compiler = $compiler;
		$this->creator  = $creator;
	}

	public function addRule(IRoutingRule $rule)
	{
		$compiled = $this->compiler->compile($rule);
		$this->rules[$rule->getName()] = $compiled;
	}

	public function addRules(array $rules)
	{
		foreach ($rules as $rule)
		{
			$this->addRule($rule);
		}
	}

	public function generateUrl($name, array $parameters = array())
	{
		if (! isset($this->rules[$name]))
			throw new Exception("Routing rule {$name} not found");

		$rule = $this->rules[$name]->getRule();
		return $this->creator->makeUrl($rule, $parameters);
	}

	public function fetchRoute($url)
	{
		$route = $this->factory->createRoute();
		foreach ($this->rules as $rule)
		{
			if ($this->matcher->match($url, $rule, $route))
				return $route;
		}
		return false;
	}
}
