<?php

/**
 * Loads a controller instance based on provided routing information.
 *
 * @package    BachelorThesis
 * @subpackage Runner
 */
interface IControllerLoader
{
	/**
	 * @var IRoute $route
	 * @return IController instance or false
	 */
	function loadController(IRoute $route);
}
