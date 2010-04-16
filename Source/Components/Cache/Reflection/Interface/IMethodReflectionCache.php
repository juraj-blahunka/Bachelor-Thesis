<?php

interface IMethodReflectionCache
{
	function storeMethod(ReflectionMethod $reflection);
	function retrieveMethod($class, $method);
	function hasMethod($class, $method);
	function deleteMethod($class, $method);
}
