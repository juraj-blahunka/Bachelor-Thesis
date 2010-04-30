<?php

/**
 * Stores Log messages into a file.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
class FileLogMessageHandler extends AbstractLogMessageHandler
{
	protected
		$filename,
		$handle;

	public function __construct($filename, ILogMessageFormatter $formatter = null, array $filters = array())
	{
		parent::__construct($formatter, $filters);
		$this->filename = $filename;
		$this->handle   = @fopen($filename, 'a', false);
		if ($this->handle === false)
			throw new RuntimeException("Cannot open file '{$filename}' for writing");
	}

	public function __destruct()
	{
		if (is_resource($this->handle))
		{
			fclose($this->handle);
		}
	}

	public function handleLogMessage($message, ILogMessage $log)
	{
		if (false === @fwrite($this->handle, $message.PHP_EOL))
			throw new RuntimeException("Cannot write to {$this->filename}");
	}
}
