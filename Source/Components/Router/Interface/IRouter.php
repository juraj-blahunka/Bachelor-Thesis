<?php

interface IRouter
{
	function addRule(IRoutingRule $rule);
	function addRules(array $rules);
	function getRules();
	function getRule($name);

	function generateUrl($name, array $parameters = array());
	function fetchRoute($url);
}
