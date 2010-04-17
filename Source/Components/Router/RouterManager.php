<?php

class RouterManager implements IRouter
{
	private
		$rules,
		$baseUrl,
		$baseUrlStrategy,
		$factory,
		$matcher,
		$compiler,
		$creator;

	public function __construct(IUrlStrategy $baseUrlStrategy, IRouterFactory $factory, IRouteMatcher $matcher, IRoutingRuleCompiler $compiler, IUrlCreator $creator)
	{
		$this->rules    = array();
		$this->baseUrl  = null;
		$this->baseUrlStrategy  = $baseUrlStrategy;
		$this->factory  = $factory;
		$this->matcher  = $matcher;
		$this->compiler = $compiler;
		$this->creator  = $creator;
	}

	public function getBaseUrl()
	{
		if ($this->baseUrl === null)
			$this->baseUrl = rtrim($this->baseUrlStrategy->getUrl(), '/');
		return $this->baseUrl;
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
		$part = $this->creator->makeUrl($rule, $parameters);
		$url  = $this->getBaseUrl() . ltrim($part, '/');
		return $url;
	}

	public function fetchRoute($path)
	{
		$path   = '/' . ltrim($path, '/');
		$route = $this->factory->createRoute();
		foreach ($this->rules as $rule)
		{
			if ($this->matcher->match($path, $rule, $route))
				return $route;
		}
		return false;
	}
}
