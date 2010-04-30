<?php

class FlatFolderClassLoader extends AbstractClassLoader
{
	protected
		$directory,
		$extension;

	public function __construct($directory, $extension = '.php')
	{
		parent::__construct();
		$this->directory = $directory;
		$this->extension = $extension;
	}

	public function resourceExists($class)
	{
		return file_exists($this->directory . DIRECTORY_SEPARATOR . $class . $this->extension);
	}

	public function importResource($class)
	{
		include($this->directory . DIRECTORY_SEPARATOR . $class . $this->extension);
		return class_exists($class);
	}
}
