<?php

/**
 * A Package grouping functionality.
 *
 * @package    BachelorThesis
 * @subpackage Package
 */
interface IPackage
{
	function getPackageName();
	function register(IContainerBuilder $builder, PathCollection $paths);
	function registerClassLoaders();
	function registerPaths();
	function registerWiring(IContainerBuilder $container);
}
