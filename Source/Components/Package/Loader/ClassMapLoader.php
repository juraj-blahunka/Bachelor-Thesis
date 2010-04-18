<?php

class ClassMapLoader extends AbstractClassLoader
{
	private
		$directory,
		$map;

	public function __construct($directory, array $map)
	{
		parent::__construct();
		$this->directory = $directory;
		$this->map       = $map;
	}

	public function resourceExists($class)
	{
		return isset($this->map[$class]);
	}

	public function importResource($class)
	{
		include($this->directory . DIRECTORY_SEPARATOR . $this->map[$class]);
		return class_exists($class);
	}
}
