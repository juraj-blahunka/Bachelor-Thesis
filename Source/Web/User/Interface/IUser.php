<?php

interface IUser
{
	function setProperty($key, $value);
	function getProperty($key, $default = null);
	function setProperties(array $properties);
	function getProperties();
}
