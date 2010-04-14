<?php

class Event implements IEvent
{
	protected
		$sender       = null,
		$name         = '',
		$parameters   = null,
		$handled      = false,
		$value        = null;

	/**
	 * Constructor
	 *
	 * @param stdclass $sender
	 * @param string $name
	 * @param array $parameters
	 */
	public function __construct($sender, $name, $parameters=array())
	{
		$this->sender = $sender;
		$this->name = $name;
		$this->parameters = $parameters;
		$this->handled = false;
		$this->value = null;
	}

	public function getSender()
	{
		return $this->sender;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function hasParameter($name)
	{
		return isset($this->parameters[$name]);
	}

	public function getParameter($name, $default = null)
	{
		return isset($this->parameters[$name])
			? $this->parameters[$name]
			: $default;
	}

	public function setParameter($name, $value)
	{
		$this->parameters[$name] = $value;
	}

	public function isHandled()
	{
		return $this->handled;
	}

	public function setHandled($bool)
	{
		$this->handled = $bool;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function getValue()
	{
		return $this->value;
	}
}
