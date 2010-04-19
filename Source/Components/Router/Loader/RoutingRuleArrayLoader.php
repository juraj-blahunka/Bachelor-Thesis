<?php

class RoutingRuleArrayLoader
{
	protected
		$defaultPackage,
		$requiredOptions = array('pattern'),
		$enabledOptions  = array('pattern', 'parameters', 'rules');

	public function __construct($defaultPackage = null)
	{
		$this->defaultPackage = $defaultPackage;
	}

	public function load(array $array)
	{
		$result = array();
		foreach ($array as $name => $rule)
		{
			$this->validateRule($name, $rule);
			$pattern    = $rule['pattern'];
			$parameters = isset($rule['parameters']) ? $rule['parameters'] : array();
			$parameters = $this->parseParameters($parameters);
			$rules      = isset($rule['rules'])  ? $rule['rules'] : array();

			$result[]   = new RoutingRule($name, $pattern, $parameters, $rules);
		}
		return $result;
	}

	private function validateRule($name, array $rule)
	{
		foreach ($this->requiredOptions as $option)
			if (! isset($rule[$option]))
				throw new RuntimeException("Required option '{$option}' is not defined in '{$name}' routing rule");
		foreach ($rule as $option => $value)
			if (! in_array($option, $this->enabledOptions))
				throw new OutOfBoundsException("Defined option '{$option}' is not supported in rule declaration, found in '{$name}' rule");
	}

	private function parseParameters(array $params)
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
