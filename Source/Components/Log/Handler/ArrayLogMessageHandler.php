<?php

/**
 * Stores LogMessage istances into array, for Mock purposes.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
class ArrayLogMessageHandler implements ILogMessageHandler
{
	public $logs = array();

	public function handle(ILogMessage $log)
	{
		$this->logs[] = $log;
	}
}
