<?php

/**
 * Handles the Log Message instance.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
interface ILogMessageHandler
{
	function handle(ILogMessage $log);
}
