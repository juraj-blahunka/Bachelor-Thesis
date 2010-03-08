<?php

class PearClassLoader implements IClassLoader
{
	protected
		$directories,
		$prefixes,
		$callback;

	public function __construct($prefixes, $directories)
	{
		$this->directories = $directories;
		$this->prefixes    = $prefixes;
		$this->callback    = array($this, 'loadClass');
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
		$classParts = explode('_', $class);
		$prefix = array_shift($classParts);
		if (($index = array_search($prefix, $this->prefixes)) > -1)
		{
			$path = str_replace('_', '/', $class);
			include $this->directories[$index].'/../'.$path.'.php';
			return class_exists($class);
		}
		return false;
	}
}