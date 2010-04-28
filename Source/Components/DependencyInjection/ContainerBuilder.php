<?php

class ContainerBuilder implements IContainerBuilder
{
	protected
		$factory,
		$constants,
		$definitions;

	/**
	 * Constructor.
	 *
	 * @param IDependencyInjectionContainerFactory $factory
	 */
	public function __construct(IDependencyInjectionContainerFactory $factory = null)
	{
		$this->factory = is_null($factory) ? new DefaultContainerFactory() : $factory;
		$this->constants   = array();
		$this->definitions = array();
	}

	/**
	 * Set constant with specified $key.
	 *
	 * @param string $key
	 * @param string $value
	 */
	public function setConstant($key, $value)
	{
		$this->constants[$key] = $value;
	}

	/**
	 * Get constant assigned to $key.
	 *
	 * @param string $key
	 * @return mixed
	 *
	 * @throws RuntimeException on accessing undefined constant
	 */
	public function getConstant($key)
	{
		if (! isset($this->constants[$key]))
			throw new RuntimeException("Access to undefined constant '{$key}'");

		return $this->constants[$key];
	}

	/**
	 * Add more constants to container's repository.
	 *
	 * @param array $constants Array of 'key' => 'constant' mapping
	 */
	public function addConstants(array $constants)
	{
		$this->constants = array_merge($this->constants, $constants);
	}

	/**
	 * Get all constants in container's repository.
	 *
	 * @return array Array of 'key' => 'value' mapping
	 */
	public function getConstants()
	{
		return $this->constants;
	}

	/**
	 * Create new component definition with $component key in repository.
	 *
	 * @param string $component
	 * @return ComponentDefinition Builder for fluent interface interaction
	 */
	public function define($component)
	{
		$definition = $this->factory->createComponentDefinition($component, array());
		$this->definitions[$component] = $definition;
		return $definition;
	}

	/**
	 * Find defined class or component in component definition repository.
	 *
	 * @param string $component
	 * @return ComponentDefinition
	 */
	public function getDefinition($component)
	{
		return isset($this->definitions[$component])
			? $this->definitions[$component]
			: null;
	}

	/**
	 * Get component definition repository array
	 *
	 * @return array Array of ComponentDefinition instances
	 */
	public function getDefinitions()
	{
		return $this->definitions;
	}

	/**
	 * Merge settings with other container/builder, new settings will overwrite
	 * old one.
	 *
	 * @param IContainerBuilder $container
	 */
	public function merge($container)
	{
		$this->addConstants($container->getConstants());
		$this->definitions = array_merge(
			$this->definitions,
			$container->getDefinitions()
		);
	}

	/**
	 * Find an array of noted definitions, which have a note with named $name
	 *
	 * @param string $name
	 * @return array
	 */
	public function getNotedDefinitions($name)
	{
		$result = array();
		foreach ($this->definitions as $key => $definition)
		{
			if ($definition->getNote($name, null) !== null)
				$result[] = $definition;
		}
		return $result;
	}
}
