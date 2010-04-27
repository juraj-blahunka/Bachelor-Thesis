<?php

class RouterManager implements IRouter
{
	private
		$rules,
		$basePath,
		$basePathStrategy,
		$factory,
		$matcher,
		$compiler,
		$creator;

	public function __construct(IUrlStrategy $basePathStrategy, IRouterFactory $factory, IRouteMatcher $matcher, IRoutingRuleCompiler $compiler, IUrlCreator $creator)
	{
		$this->rules    = array();
		$this->basePath = null;
		$this->basePathStrategy  = $basePathStrategy;
		$this->factory  = $factory;
		$this->matcher  = $matcher;
		$this->compiler = $compiler;
		$this->creator  = $creator;
	}

	public function getBasePath()
	{
		if ($this->basePath === null)
			$this->basePath = rtrim($this->basePathStrategy->getUrl(), '/');
		return $this->basePath;
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
			throw new RuntimeException("Routing rule {$name} not found");

		$rule = $this->rules[$name]->getRule();
		$part = $this->creator->makeUrl($rule, $parameters);
		$url  = $this->getBasePath() . '/' . ltrim($part, '/');
		return $url;
	}

	public function fetchRoute($path)
	{
		$path  = '/' . urldecode(ltrim($path, '/'));
		$route = $this->factory->createRoute();
		foreach ($this->rules as $rule)
		{
			if ($this->matcher->match($path, $rule, $route))
				return $route;
		}
		return false;
	}
}
