<?php

/**
 * Data representation of a Routing Rule.
 *
 * @package    BachelorThesis
 * @subpackage Router
 */
interface IRoutingRule
{
	function getName();
	function getPattern();
	function getParameters();
	function getParameter($name, $default = null);
	function getRequirements();
}
