<?php

class NullLogger implements ILogger
{
	public function alert($log, $additional = null)
	{
	}

	public function critical($log, $additional = null)
	{
	}

	public function debug($log, $additional = null)
	{
	}

	public function emergency($log, $additional = null)
	{
	}

	public function error($log, $additional = null)
	{
	}

	public function info($log, $additional = null)
	{
	}

	public function notice($log, $additional = null)
	{
	}

	public function warning($log, $additional = null)
	{
	}
}
