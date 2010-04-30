<?php

/**
 * Grouping class for defining main functionality locations.
 *
 * @package    BachelorThesis
 * @subpackage Package
 */
abstract class MvcPackage extends Package
{
	public function register(IContainerBuilder $builder, PathCollection $paths)
	{
		parent::register($builder, $paths);

		$controllers = $this->registerControllerPaths();
		if (! is_array($controllers))
			$controllers = array();

		$commands = $this->registerCommandPaths();
		if (! is_array($commands))
			$commands = array();

		$views = $this->registerViewPaths();
		if (! is_array($views))
			$views = array();

		$name = $this->getPackageName();
		$paths->addPaths('controllers', $controllers);
		$paths->addPaths($name . '.controllers', $controllers);
		$paths->addPaths('commands', $commands);
		$paths->addPaths($name . '.commands', $commands);
		$paths->addPaths('views', $views);
		$paths->addPaths($name . '.views', $views);
	}

	abstract function registerControllerPaths();

	abstract function registerCommandPaths();

	abstract function registerViewPaths();
}
