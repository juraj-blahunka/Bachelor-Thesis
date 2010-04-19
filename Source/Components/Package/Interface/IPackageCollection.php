<?php

interface IPackageCollection
{
	function addPackage(IPackage $package);
	function getPackage($name, $default = null);
	function setPackages(array $packages);
	function getPackages();
}
