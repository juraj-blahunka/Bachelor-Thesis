<?php

/**
 * User data definition.
 *
 * @package    BachelorThesis
 * @subpackage User
 */
interface IUser
{
	function setProperty($key, $value);
	function getProperty($key, $default = null);
	function setProperties(array $properties);
	function getProperties();
}
