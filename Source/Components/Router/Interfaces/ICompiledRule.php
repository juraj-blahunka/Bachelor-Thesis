<?php

interface ICompiledRule
{
	function __construct(IRoutingRule $rule, $regex);

	function getRule();
	function getRegex();
}