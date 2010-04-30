<?php

/**
 * Event variable holder.
 *
 * @package    BachelorThesis
 * @subpackage Events
 */
class Event implements IEvent
{
	protected
		$sender       = null,
		$name         = '',
		$parameters   = null,
		$handled      = false,
		$value        = null;

	/**
	 * Constructor.
	 *
	 * @param mixed $sender
	 * @param string $name
	 * @param array $parameters
	 */
	public function __construct($sender, $name, array $parameters = array())
	{
		$this->sender = $sender;
		$this->name = $name;
		$this->parameters = $parameters;
		$this->handled = false;
		$this->value = null;
	}

	/**
	 * Get the sender of event.
	 *
	 * @return mixed
	 */
	public function getSender()
	{
		return $this->sender;
	}

	/**
	 * Get name of event.
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get parameters of event.
	 *
	 * @return array
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

	/**
	 * Checks if event has defined parameter with $name.
	 *
	 * @param string $name
	 * @return bool
	 */
	public function hasParameter($name)
	{
		return isset($this->parameters[$name]);
	}

	/**
	 * Get parameter identified by $name, return $default, if not parameter
	 * with name was found.
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getParameter($name, $default = null)
	{
		return isset($this->parameters[$name])
			? $this->parameters[$name]
			: $default;
	}

	/**
	 * Set the event parameter.
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function setParameter($name, $value)
	{
		$this->parameters[$name] = $value;
	}

	/**
	 * Check, if event is handled.
	 *
	 * @return bool
	 */
	public function isHandled()
	{
		return $this->handled;
	}

	/**
	 * Set boolean handled property of event.
	 *
	 * @param bool $handled
	 */
	public function setHandled($handled)
	{
		$this->handled = (bool) $handled;
	}

	/**
	 * Set value of event.
	 *
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

	/**
	 * Get value of event.
	 *
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
}
