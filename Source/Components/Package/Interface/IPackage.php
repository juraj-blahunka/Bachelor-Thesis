<?php

interface IPackage
{
	function getPackageName();
	function register(IDependencyInjectionContainer $container);
}