<?php

interface IComponentAdapter
{
	function getKey();
	function getClass();
	function getInstance(IDependencyInjectionContainer $container);
}
