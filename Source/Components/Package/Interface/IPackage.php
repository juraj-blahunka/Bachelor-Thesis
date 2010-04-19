<?php

interface IPackage
{
	function getPackageName();
	function register(IContainerBuilder $builder);
	function registerClassLoaders();
	function registerWiring(IContainerBuilder $container);
}
