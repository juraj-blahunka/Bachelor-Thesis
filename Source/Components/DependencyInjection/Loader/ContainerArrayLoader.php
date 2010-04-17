<?php

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

	}

	protected function loadConstants(array $constants)
	{

	}

	protected function loadComponents(array $components)
	{

	}

	protected function loadComponent($name, $component)
	{

	}
}

return array(
	'constants' => array(
		'my.constant' => 'data'
	),

	'components' => array(
		'Component' => array(
			'class' => 'may have, or not',
			'constructor' => array(
				array('value', 'some val'),
				array('component', 'ou jeee'),
			)
		)
	),
);