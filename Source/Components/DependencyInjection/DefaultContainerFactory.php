<?php

/**
 * A factory.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
class DefaultContainerFactory implements IDependencyInjectionContainerFactory
{
	private $converter;

	public function __construct(IComponentDefinitionToComponentAdapter $converter = null)
	{
		$this->converter = is_null($converter)
			? new ComponentDefinitionToComponentAdapter()
			: $converter;
	}

	public function createContainerBuilder()
	{
		return new ContainerBuilder($this);
	}

	public function createComponentDefinition($class, array $arguments)
	{
		return new ComponentDefinition($class, $arguments);
	}

	public function createInstanceAdapter($key, $object)
	{
		return new InstanceComponentAdapter($key, $object);
	}

	public function createConstructorAdapter($key, $class, array $arguments)
	{
		return new ConstructorComponentAdapter($key, $class, $arguments);
	}

	public function createAdapterFromDef(IComponentDefinition $definition)
	{
		return $this->converter->convert($definition);
	}
}
