<?php

interface IRoutingRule
{
	function getName();
	function getPattern();
	function getParameters();
	function getParameter($name, $default = null);
	function getRequirements();
}
