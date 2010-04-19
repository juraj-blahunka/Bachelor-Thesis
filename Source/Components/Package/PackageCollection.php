<?php

class PackageCollection implements IPackageCollection
{
	protected $packages;

	public function __construct(array $packages = array())
	{
		$this->setPackages($packages);
	}

	public function addPackage(IPackage $package)
	{
		$this->packages[$package->getPackageName()] = $package;
	}

	public function getPackage($name, $default = null)
	{
		return isset($this->packages[$name])
			? $this->packages[$name]
			: $default;
	}

	public function setPackages(array $packages)
	{
		$this->packages = array();
		foreach ($packages as $package)
			$this->addPackage($package);
	}

	public function getPackages()
	{
		return $this->packages;
	}
}
