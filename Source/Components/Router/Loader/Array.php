<?php

class RoutingRuleArrayLoader
{
	public function load(array $array)
	{
		$result = array();
		foreach ($array as $name => $rule)
		{
			$result[] = new RoutingRule(
				$name,
				$rule['pattern'],
				isset($rule['params']) ? $rule['params'] : array(),
				isset($rule['rules'])  ? $rule['rules'] : array()
			);
		}
		return $result;
	}
}
