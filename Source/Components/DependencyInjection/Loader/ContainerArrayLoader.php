<?php

/**
 * ContainerArrayLoader.
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

class ContainerArrayLoader
{
	protected $factory;

	public function __construct(IDependencyInjectionContainerFactory $factory = null)
	{
		$this->factory = is_null($factory)
			? new DefaultContainerFactory()
			: $factory;
	}

	public function load(array $data)
	{
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
			$this->loadComponent($builder, $name, $component);
		}
	}

	protected function loadComponent(IContainerBuilder $builder, $name, array $component)
	{
		$definition = $builder->define($name);
		if (isset($component['class']))
			$definition->setClass($component['class']);
		if (isset($component['constructor']))
			$definition->setArguments($component['constructor']);
		if (isset($component['notes']))
			$definition->setNotes($component['notes']);
		if (isset($component['methods']))
			$definition->setMethods($component['methods']);
		if (isset($component['scope']))
			$definition->setScope($component['scope']);
	}
}
