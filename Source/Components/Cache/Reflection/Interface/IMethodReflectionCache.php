<?php

/**
 * Interface to store method reflection objects.
 *
 * @package    BachelorThesis
 * @subpackage Cache_Reflection
 */
interface IMethodReflectionCache
{
	function storeMethod(ReflectionMethod $reflection);
	function retrieveMethod($class, $method);
	function hasMethod($class, $method);
	function deleteMethod($class, $method);
}
