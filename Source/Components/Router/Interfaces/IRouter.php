<?php

interface IRouter
{
	function addRule(IRoutingRule $rule);
	function addRules(array $rules);
	function generateUrl($name, array $parameters = array());
	function fetchRoute($url);
}
