<?php

class ClassMapLoader implements IClassLoader
{
	private
		$directory,
		$map,
		$callback;

	public function __construct($directory, array $map)
	{
		$this->directory = $directory;
		$this->map       = $map;
		$this->callback  = array($this, 'loadClass');
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
		if (isset($this->map[$class]))
		{
			include($this->directory.'/'.$this->map[$class]);
			return class_exists($class);
		}
		return false;
	}

}
