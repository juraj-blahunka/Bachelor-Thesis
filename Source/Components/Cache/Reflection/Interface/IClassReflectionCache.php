<?php

/**
 * Interface to store class reflection objects.
 *
 * @package    BachelorThesis
 * @subpackage Cache_Reflection
 */
interface IClassReflectionCache
{
	function storeClass(ReflectionClass $reflection);
	function retrieveClass($key);
	function hasClass($key);
	function deleteClass($key);
}
