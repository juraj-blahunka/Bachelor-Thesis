<?php

class RouteMatcher implements IRouteMatcher
{
	public function match($url, ICompiledRule $rule, IRoute $route)
	{
		if (! preg_match($rule->getRegex(), $url, $matches))
			return false;

		$vars = $this->findVariables(
			$matches,
			$rule->getRule()->getParameters()
		);

		$route->setController($vars['controller'])
			->setAction($vars['action'])
			->setPackage($vars['package']);

		unset($vars['controller'], $vars['action'], $vars['package']);
		$route->setParameters($vars);

		return true;
	}

	private function findVariables(array $matched, array $defaults)
	{
		$vars = $defaults;
		foreach ($matched as $key => $value)
		{
			if (is_numeric($key))
				continue;
			$vars[$key] = $value;
		}
		return $vars;
	}
}
