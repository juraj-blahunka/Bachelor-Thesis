<?php

interface IDependencyInjectionContainerFactory
{
	function createComponentDefinition($class, array $arguments);
	function createInstanceAdapter($key, $object);
	function createConstructorAdapter($key, $class, array $arguments);
	function createAdapterFromDef($key, IComponentDefinition $definition);
}
