<?php

interface IPackage
{
	function getPackageName();
	function register();
	function registerClassLoaders();
}