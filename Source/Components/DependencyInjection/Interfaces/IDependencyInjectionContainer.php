<?php

interface IDependencyInjectionContainer
{
	// constants
	function setConstant($key, $value);
	function getConstant($key);
	function addConstants(array $constants);
	function getConstants();

	// components through adapters
	function setComponentAdapter(IComponentAdapter $adapter);
	function getComponentAdapter($key);
	function getComponentInstance($key);

	// components through definitions
	function registerComponent($componentKey, $class);
	function getDefinitions();

	// class resolving
	function getClassInstance($class, array $arguments);

}