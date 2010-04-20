<?php

class PathCollection
{
	protected $paths;

	public function __construct(array $paths = array())
	{
		$this->setPaths($paths);
	}

	public function setPaths(array $pathArray)
	{
		$this->paths = array();
		foreach ($pathArray as $type => $paths)
		{
			foreach ($paths as $path)
				$this->addPath($type, $path);
		}
	}

	public function addPath($type, $path)
	{
		if (! is_dir($path))
			throw new UnexpectedValueException("Provided path '{$path}' is not a valid directory");
		$this->paths[$type][] = $path;
	}

	public function getPaths($type)
	{
		return isset($this->paths[$type])
			? $this->paths[$type]
			: array();
	}

	public function getAll()
	{
		$result = array();
		foreach ($this->paths as $paths)
			$result = array_merge($result, $paths);
		return $result;
	}
}
