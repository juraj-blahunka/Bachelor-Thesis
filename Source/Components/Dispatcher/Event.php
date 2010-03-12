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

	/**
	 * Implement ArrayAccess
	 *
	 * @param mixed $offset
	 */
	public function offsetExists($offset)
	{
		return isset($this->parameters[$offset]);
	}

	/**
	 * Implement ArrayAccess
	 *
	 * @param mixed $offset
	 */
	public function offsetGet($offset)
	{
		return $this->parameters[$offset];
	}

	/**
	 * Implement ArrayAccess
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value)
	{
		$this->parameters[$offset] = $value;
	}

	/**
	 * Implement ArrayAccess
	 *
	 * @param mixed $offset
	 */
	public function offsetUnset($offset)
	{
		unset($this->parameters[$offset]);
	}
}
