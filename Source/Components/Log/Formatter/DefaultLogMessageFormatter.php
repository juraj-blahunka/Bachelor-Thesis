<?php

class DefaultLogMessageFormatter implements ILogMessageFormatter
{
	public function format(ILogMessage $log)
	{
		return $log->getParameter('timestamp') . ': ' . $log->getMessage();
	}
}
