<?php

/**
 * ContainerArrayLoader.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 *
 * Loads an array resource into a ContainerBuilder, which is returned for
 * further configuration.
 *
 *
 * example usage:
 *
 * <code>
 *  $data = array(
 *	  'constants' => array(
 *	     'my.constant' => 'data',
 *	  ),
 *
 *	  'components' => array(
 *		 'Component' => array(
 *			'class' => 'may have, or not',
 *			'constructor' => array(
 *				array('value', 'some val'),
 *				array('component', 'Other'),
 *			),
 *			'methods' => array(
 *				array('resolve', array(
 *					array('constant', 'my.constant')
 *				)),
 *				array('anotherMethod', array())
 *			),
 *			'scope' => 'transient'
 *		  ),
 *		 'Other' => array(
 *
 *	     ),
 *	   ),
 *  );
 *
 *  $loader  = new ContainerArrayLoader();
 *  $builder = $loader->load($data);
 * </code>
 */
class ContainerArrayLoader implements IContainerLoader
{
	protected $factory;

	public function __construct(IDependencyInjectionContainerFactory $factory = null)
	{
		$this->factory = is_null($factory)
			? new DefaultContainerFactory()
			: $factory;
	}

	public function load($data)
	{
		if (! is_array($data))
			throw new UnexpectedValueException("ContainerArrayLoader can load only from array of data");

		$builder = $this->factory->createContainerBuilder();

		$this->loadConstants(
			$builder,
			isset($data['constants'])
				? $data['constants']
			: array()
		);

		$this->loadComponents(
			$builder,
			isset($data['components'])
				? $data['components']
				: array()
		);

		return $builder;

	}

	protected function loadConstants(IContainerBuilder $builder, array $constants)
	{
		$builder->addConstants($constants);
	}

	protected function loadComponents(IContainerBuilder $builder, array $components)
	{
		foreach ($components as $name => $component)
		{
			// component is valid identifier, only tu put it in collection
			// of registered classes
			if (is_numeric($name) && is_string($component))
				$builder->define($component);
			else
				$this->loadComponent($builder, $name, $component);
		}
	}

	protected function loadComponent(IContainerBuilder $builder, $name, array $component)
	{
		$definition = $builder->define($name);
		if (isset($component['class']))
			$definition->setClass($component['class']);
		if (isset($component['constructor']) && $this->validateArguments($name, $component['constructor']))
			$definition->setArguments($component['constructor']);
		if (isset($component['notes']))
			$definition->setNotes($component['notes']);
		if (isset($component['methods']) && $this->validateMethods($name, $component['methods']))
			$definition->setMethods($component['methods']);
		if (isset($component['scope']))
			$definition->setScope($component['scope']);
	}

	protected function validateArguments($component, $arguments)
	{
		if (! is_array($arguments))
			throw new UnexpectedValueException("Defined arguments in '{$component}' declaration are not an array");

		foreach ($arguments as $arg)
		{
			if (! (is_array($arg) && (count($arg) == 2)))
				throw new UnexpectedValueException("Argument declared in '{$component}' is not a valid argument");
		}
		return true;
	}

	protected function validateMethods($component, $methods)
	{
		if (! is_array($methods))
			throw new UnexpectedValueException("Methods declared in '{$component}' are not valid array declaration");
		foreach ($methods as $method)
		{
			if (! (is_array($method) && (count($method) == 2)))
				throw new UnexpectedValueException("Method declaration should be array, found in '{$component}'");
			$this->validateArguments($component, $method[1]);
		}
		return true;
	}
}
