<?php

/**
 * Layer between the interface and concrete implementations.
 * Defines two methods to implement.
 *
 * @package    BachelorThesis
 * @subpackage Package
 */
abstract class AbstractClassLoader implements IClassLoader
{
	protected $callback;

	public function __construct()
	{
		$this->callback = array($this, 'loadClass');
	}

	public function registerClassLoader()
	{
		spl_autoload_register($this->callback);
	}

	public function unregisterClassLoader()
	{
		spl_autoload_unregister($this->callback);
	}

	public function loadClass($class)
	{
		if ($this->resourceExists($class))
			$this->importResource($class);
	}

	abstract public function resourceExists($class);

	abstract public function importResource($class);
}
