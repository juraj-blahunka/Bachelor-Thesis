<?php

class Logger implements ILogger
{
	const
		EMERGENCY = 0,
		ALERT     = 1,
		CRITICAL  = 2,
		ERROR     = 3,
		WARNING   = 4,
		NOTICE    = 5,
		INFO      = 6,
		DEBUG     = 7;

	protected $handler;

	public function __construct(ILogMessageHandler $handler)
	{
		$this->handler = $handler;
	}

	public function emergency($message, $additional = null)
	{
		$this->log(self::EMERGENCY, $message, $additional);
	}

	public function alert($message, $additional = null)
	{
		$this->log(self::ALERT, $message, $additional);
	}

	public function critical($message, $additional = null)
	{
		$this->log(self::CRITICAL, $message, $additional);
	}

	public function error($message, $additional = null)
	{
		$this->log(self::ERROR, $message, $additional);
	}

	public function warning($message, $additional = null)
	{
		$this->log(self::WARNING, $message, $additional);
	}

	public function notice($message, $additional = null)
	{
		$this->log(self::NOTICE, $message, $additional);
	}

	public function info($message, $additional = null)
	{
		$this->log(self::INFO, $message, $additional);
	}

	public function debug($message, $additional = null)
	{
		$this->log(self::DEBUG, $message, $additional);
	}

	protected function log($level, $message, $additional)
	{
		if (is_null($additional))
			$additional = array();
		elseif (is_string($additional))
			$additional = array('extra' => $additional);

		$log = new LogMessage($message,	array_merge(
			$additional, array(
				'level' => $level,
				'timestamp' => date('c')
			)
		));

		$this->handler->handle($log);
	}
}
