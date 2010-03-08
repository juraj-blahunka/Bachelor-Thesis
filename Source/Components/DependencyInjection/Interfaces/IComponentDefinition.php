<?php

interface IComponentDefinition
{
	function setClass($class);
	function getClass();

	function setArguments(array $arguments);
	function getArguments();

	function addArgument($type, $value);

	function setScope($scope);
	function getScope();

	function setMethods(array $methods);
	function getMethods();
	function addMethod($methodName, array $methodArguments = array());
}