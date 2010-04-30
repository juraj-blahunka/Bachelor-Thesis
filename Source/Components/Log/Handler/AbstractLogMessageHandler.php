<?php

/**
 * Layer between the actual handler and required logic.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
abstract class AbstractLogMessageHandler implements ILogMessageHandler
{
	protected
		$formatter,
		$filters;

	public function __construct(ILogMessageFormatter $formatter = null, array $filters = array())
	{
		$this->formatter = $formatter;
		$this->filters   = $filters;
	}

	abstract function handleLogMessage($message, ILogMessage $log);

	public function handle(ILogMessage $log)
	{
		if (! $this->accept($log))
			return false;

		$message = $this->format($log);

		$this->handleLogMessage($message, $log);
	}

	protected function accept(ILogMessage $log)
	{
		foreach ($this->filters as $filter)
		{
			if (! $filter->accept($log))
				return false;
		}
		return true;
	}

	protected function format(ILogMessage $log)
	{
		return is_null($this->formatter)
			? $log->getMessage()
			: $this->formatter->format($log);
	}
}
