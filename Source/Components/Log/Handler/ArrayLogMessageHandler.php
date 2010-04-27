<?php

class ArrayLogMessageHandler implements ILogMessageHandler
{
	public $logs = array();

	public function handle(ILogMessage $log)
	{
		$this->logs[] = $log;
	}
}
