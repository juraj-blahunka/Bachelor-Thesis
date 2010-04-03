<?php

interface ICollection
{
	function setValue($name, $value);
	function getValue($name, $default = null);
	function hasValue($name);

	function setFromArray(array $values);
	function getArray();
}
