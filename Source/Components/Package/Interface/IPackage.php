<?php

interface IPackage
{
	function getPackageName();
	function register(IContainerBuilder $builder);
}
