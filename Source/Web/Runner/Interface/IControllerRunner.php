<?php

/**
 * A controller runner can either respond to request or run specified route.
 *
 * @package    BachelorThesis
 * @subpackage Runner
 */
interface IControllerRunner
{
	function respondTo(IRequest $request);
	function run(IRoute $route);
}
