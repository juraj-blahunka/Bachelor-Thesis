<?php

/**
 * Format a Log Message into a string format.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
interface ILogMessageFormatter
{
	function format(ILogMessage $log);
}
