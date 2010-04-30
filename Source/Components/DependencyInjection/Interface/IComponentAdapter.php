<?php

/**
 * Component Adapter instantiates components.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
interface IComponentAdapter
{
	function getKey();
	function getClass();
	function getInstance(IDependencyInjectionContainer $container);
}
