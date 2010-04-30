<?php

/**
 * Defines whether an action can be invoked on a controller and invokes the action.
 *
 * @package    BachelorThesis
 * @subpackage Runner
 */
interface IActionInvoker
{
	function canInvoke($controller, IRoute $route);
	function invoke($controller, IRoute $route);
}
