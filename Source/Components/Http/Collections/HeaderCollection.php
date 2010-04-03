<?php

class HeaderCollection extends ArrayCollection
{
	public function setValue($name, $value)
	{
		$this->values[$this->normalizeHeaderName($name)] = $value;
	}

	public function getValue($name, $default = null)
	{
		return $this->hasValue($name)
			? $this->values[$this->normalizeHeaderName($name)]
			: $default;
	}

	public function hasValue($name)
	{
		return isset($this->values[$this->normalizeHeaderName($name)]);
	}

	public function deleteValue($name)
	{
		unset($this->values[$this->normalizeHeaderName($name)]);
	}

	protected function normalizeHeaderName($name)
	{
		return strtolower($name);
	}
}
