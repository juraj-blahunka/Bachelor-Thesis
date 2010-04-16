<?php

interface IDependencyInjectionContainer extends IContainerBuilder
{
	// child container
	function createChildContainer();

	// components adapters
	function setComponentAdapter(IComponentAdapter $adapter);
	function getComponentAdapter($key);
	function getAdaptersOfType($type);

	// component instantiation
	function getInstanceOf($component);
	function getInstanceOfWith($component, array $arguments);
}
