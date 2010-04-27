<?php

class LogMessageHandlerComposite extends AbstractLogMessageHandler
{
	protected $handlers;

	public function __construct(array $handlers, array $filters = array())
	{
		parent::__construct(null, $filters);
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
