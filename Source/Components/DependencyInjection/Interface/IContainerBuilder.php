<?php

interface IContainerBuilder
{
	// constants
	function setConstant($key, $value);
	function getConstant($key);
	function addConstants(array $constants);
	function getConstants();

	// definitions of components
	function define($component);
	function getDefinition($component);
	function getDefinitions();

	// merge with another builder
	function merge($container);

	// find noted component definitions with $name
	function getNotedDefinitions($name);
}
