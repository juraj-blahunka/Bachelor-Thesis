<?php

/**
 * Collection of packages.
 *
 * @package    BachelorThesis
 * @subpackage Package
 */
interface IPackageCollection
{
	function addPackage(IPackage $package);
	function getPackage($name, $default = null);
	function setPackages(array $packages);
	function getPackages();
}
