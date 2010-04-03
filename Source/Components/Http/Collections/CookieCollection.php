<?php

class CookieCollection
{
	private $cookies;

	public function __construct(array $cookies = array())
	{
		$this->setFromArray($cookies);
	}

	public function setValue($name, $value)
	{
		$this->cookies[$name] = $value;
	}

	public function getValue($name, $default = null)
	{
		return isset($this->cookies[$name])
			? $this->cookies[$name]
			: $default;
	}

	public function setFromArray(array $cookies)
	{
		$this->cookies = array();
		foreach ($cookies as $name => $value)
		{
			$this->setValue($name, $value);
		}
	}

	public function getArray()
	{
		return $this->cookies;
	}
}
