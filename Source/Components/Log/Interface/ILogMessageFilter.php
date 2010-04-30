<?php

/**
 * Filters Log Messages.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
interface ILogMessageFilter
{
	function accept(ILogMessage $log);
}
