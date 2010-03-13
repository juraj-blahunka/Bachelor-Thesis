<?php

interface IDependencyInjectionContainer
{
	// child container
	function createChildContainer();

	// constants
	function setConstant($key, $value);
	function getConstant($key);
	function addConstants(array $constants);
	function getConstants();

	// components adapters
	function setComponentAdapter(IComponentAdapter $adapter);
	function getComponentAdapter($key);
	function getAdaptersOfType($type);

	// definitions of adapters
	function registerComponent($component);
	function getDefinitions();

	// component instantiation
	function getInstanceOf($component, array $withArguments = array());
}
