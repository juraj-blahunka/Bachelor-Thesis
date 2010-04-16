<?php

class CompiledRule implements ICompiledRule
{
	public function  __construct(IRoutingRule $rule, $regex)
	{
		$this->rule  = $rule;
		$this->regex = $regex;
	}

	public function getRule()
	{
		return $this->rule;
	}

	public function getRegex()
	{
		return $this->regex;
	}
}
