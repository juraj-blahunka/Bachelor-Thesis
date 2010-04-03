<?php

class ArrayCollection implements ICollection
{
	protected $values;

	public function __construct(array $values = array())
	{
		$this->setFromArray($values);
	}

	public function setValue($name, $value)
	{
		$this->values[$name] = $value;
	}

	public function getValue($name, $default = null)
	{
		return $this->hasValue($name)
			? $this->values[$name]
			: $default;
	}

	public function hasValue($name)
	{
		return isset($this->values[$name]);
	}

	public function deleteValue($name)
	{
		unset($this->values[$name]);
	}

	public function setFromArray(array $values)
	{
		$this->values = array();
		foreach ($values as $name => $value)
		{
			$this->setValue($name, $value);
		}
	}

	public function getArray()
	{
		return $this->values;
	}
}
