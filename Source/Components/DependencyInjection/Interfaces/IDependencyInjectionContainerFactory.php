<?php

interface IDependencyInjectionContainerFactory
{
	function createComponentDefinition($class, array $arguments);
	function createInstanceAdapter($key, $object);
	function createAdapterFromDef($key, IComponentDefinition $definition);
}
