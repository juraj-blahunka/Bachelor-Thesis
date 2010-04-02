<?php

interface IContainerBuilder
{
	// constants
	function setConstant($key, $value);
	function getConstant($key);
	function addConstants(array $constants);
	function getConstants();

	// definitions of components
	function registerComponent($component);
	function getDefinition($component);
	function getDefinitions();
}
