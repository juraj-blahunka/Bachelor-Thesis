<?php

interface IClassReflectionCache
{
	function storeClass(ReflectionClass $reflection);
	function retrieveClass($key);
	function hasClass($key);
	function deleteClass($key);
}
