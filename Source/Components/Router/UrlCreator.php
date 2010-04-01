<?php

class UrlCreator implements IUrlCreator
{
	public function makeUrl(IRoutingRule $rule, array $parameters = array())
	{
		$vars = array_merge($rule->getParameters(), $parameters);
		$url  = $this->replaceVariablesWithParameters($rule->getPattern(), $vars);
		if ($this->hasVariableHolders($url))
			throw new InvalidArgumentException("Not all variables where substituted, this url remained: {$url}");

		return $url;
	}

	private function replaceVariablesWithParameters($url, $parameters)
	{
		foreach ($parameters as $key => $value)
			$url = str_replace('{'.$key.'}', $value, $url);
		return $url;
	}

	private function hasVariableHolders($url)
	{
		return preg_match('/{.+}/', $url);
	}
}
