<?php

class DefaultContainerFactory implements IDependencyInjectionContainerFactory
{
	private
		$converter;

	public function __construct(IComponentDefinitionToComponentAdapter $converter = null)
	{
		$this->converter = is_null($converter)
			? new ComponentDefinitionToComponentAdapter()
			: $converter;
	}

	public function createComponentDefinition($class, array $arguments)
	{
		return new ComponentDefinition($class, $arguments);
	}

	public function createInstanceAdapter($key, $object)
	{
		return new InstanceComponentAdapter($key, $object);
	}

	public function createAdapterFromDef($key, IComponentDefinition $definition)
	{
		return $this->converter->convert($key, $definition);
	}
}
