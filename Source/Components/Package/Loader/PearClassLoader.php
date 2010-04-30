<?php

/**
 * Lazily loads classes, which are named after PEAR conventions.
 *
 * @package    BachelorThesis
 * @subpackage Package
 */
class PearClassLoader extends AbstractClassLoader
{
	protected
		$directories,
		$prefixes;

	public function __construct(array $prefixes, array $directories)
	{
		parent::__construct();
		$this->directories = $directories;
		$this->prefixes    = $prefixes;
	}

	protected function getPrefix($class)
	{
		$classParts = explode('_', $class);
		return array_shift($classParts);
	}

	public function resourceExists($class)
	{
		return in_array($this->getPrefix($class), $this->prefixes);
	}

	public function importResource($class)
	{
		$index = array_search($this->getPrefix($class), $this->prefixes);
		$path = str_replace('_', DIRECTORY_SEPARATOR, $class);
		include $this->directories[$index] . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path . '.php';
		return class_exists($class);
	}
}
