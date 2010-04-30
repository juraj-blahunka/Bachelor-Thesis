<?php

/**
 * Loads a php file and passes its contents to another loader.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
class ContainerPhpFileLoader implements IContainerLoader
{
	protected $loader;

	public function __construct(IContainerLoader $loader)
	{
		$this->loader = $loader;
	}

	public function load($resource)
	{
		if (! file_exists($resource))
			throw new RuntimeException("Cannot find file resource '{$resource}'");

		$data = (array) include($resource);
		return $this->loader->load($data);
	}
}
