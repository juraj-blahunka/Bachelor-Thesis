<?php

class RoutingRuleArrayLoader
{
	protected $defaultPackage;

	public function __construct($defaultPackage = null)
	{
		$this->defaultPackage = $defaultPackage;
	}

	public function load(array $array)
	{
		$result = array();
		foreach ($array as $name => $rule)
		{
			$result[] = new RoutingRule(
				$name,
				$rule['pattern'],
				$this->parseParams(isset($rule['params']) ? $rule['params'] : array()),
				isset($rule['rules'])  ? $rule['rules'] : array()
			);
		}
		return $result;
	}

	private function parseParams(array $params)
	{
		if (! isset($params['package']))
		{
			if ($this->defaultPackage !== null)
				$params['package'] = $this->defaultPackage;
			else
				throw new RuntimeException(sprintf("No package set four rule with parameters: %s", var_export($params, true)));
		}
		return $params;
	}
}
