<?php

interface IRoutingRule
{
	function __construct($name, $pattern, $parameters, $requirements = array());

	function getName();
	function getPattern();
	function getParameters();
	function getRequirements();
}