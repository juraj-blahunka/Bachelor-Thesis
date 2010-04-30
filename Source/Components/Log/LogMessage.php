<?php

/**
 * The data representation of a Log Message.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
class LogMessage implements ILogMessage
{
	protected
		$message,
		$parameters;

	public function __construct($message, array $parameters = array())
	{
		$this->setMessage($message);
		$this->setParameters($parameters);
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setParameters(array $params)
	{
		$this->parameters = $params;
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function addParameters(array $params)
	{
		$this->parameters = array_merge($this->parameters, $params);
	}

	public function setParameter($name, $parameter)
	{
		$this->parameters[$name] = $parameter;
	}

	public function getParameter($name, $default = null)
	{
		return isset($this->parameters[$name])
			? $this->parameters[$name]
			: $default;
	}
}
