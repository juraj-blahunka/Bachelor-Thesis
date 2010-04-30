<?php

/**
 * Creates Route instances from url and rules.
 *
 * @package    BachelorThesis
 * @subpackage Router
 */
interface IRouteMatcher
{
	function match($url, ICompiledRule $rule, IRoute $route);
}
