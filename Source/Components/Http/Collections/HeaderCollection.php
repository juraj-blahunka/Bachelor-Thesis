<?php

class HeaderCollection
{
	private $headers;

	public function __construct(array $headers = array())
	{
		$this->setFromArray($headers);
	}

	public function setValue($name, $value)
	{
		$this->headers[$this->normalizeHeaderName($name)] = $value;
	}

	public function getValue($name, $default = null)
	{
		return isset($this->headers[$name])
			? $this->headers[$name]
			: $default;
	}

	public function setFromArray(array $headers)
	{
		$this->headers = array();
		foreach ($headers as $name => $value)
		{
			$this->setValue($name, $value);
		}
	}

	public function getArray()
	{
		return $this->headers;
	}

	protected function normalizeHeaderName($name)
	{
		return strtolower($name);
	}
}
