<?php

class RoutingRule implements IRoutingRule
{
	private
		$name,
		$pattern,
		$parameters,
		$requirements;

	public function __construct($name, $pattern, array $parameters = array(), array $requirements = array())
	{
		$this->name         = $name;
		$this->pattern      = $pattern;
		$this->parameters   = $parameters;
		$this->requirements = $requirements;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function getParameter($name, $default = null)
	{
		return isset($this->parameters[$name])
			? $this->parameters[$name]
			: $default;
	}

	public function getPattern()
	{
		return $this->pattern;
	}

	public function getRequirements()
	{
		return $this->requirements;
	}
}
