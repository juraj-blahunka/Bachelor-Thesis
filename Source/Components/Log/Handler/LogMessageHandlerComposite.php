<?php

class LogMessageHandlerComposite extends AbstractLogMessageHandler
{
	protected $handlers;

	public function __construct(array $handlers, ILogMessageFormatter $formatter = null, array $filters = array())
	{
		parent::__construct($formatter, $filters);
		$this->handlers = $handlers;
	}

	public function handleLogMessage($message, ILogMessage $log)
	{
		foreach ($this->handlers as $handler)
		{
			$handler->handle($log);
		}
	}
}
