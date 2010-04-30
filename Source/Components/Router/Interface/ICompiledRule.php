<?php

/**
 * Interface for storing compiled routing rules.
 *
 * @package    BachelorThesis
 * @subpackage Router
 */
interface ICompiledRule
{
	function __construct(IRoutingRule $rule, $regex);

	function getRule();
	function getRegex();
}
