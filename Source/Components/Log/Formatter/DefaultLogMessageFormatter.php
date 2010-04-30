<?php

/**
 * Default formatting for a Log Message.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
class DefaultLogMessageFormatter implements ILogMessageFormatter
{
	public function format(ILogMessage $log)
	{
		return sprintf('%s (%s) %s',
			$log->getParameter('timestamp', 'no timestamp'),
			$log->getParameter('level', 'NO LEVEL'),
			$log->getMessage()
		);
	}
}
