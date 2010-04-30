<?php

/**
 * A factory.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
interface IDependencyInjectionContainerFactory
{
	function createContainerBuilder();
	function createComponentDefinition($class, array $arguments);
	function createInstanceAdapter($key, $object);
	function createConstructorAdapter($key, $class, array $arguments);
	function createAdapterFromDef(IComponentDefinition $definition);
}
