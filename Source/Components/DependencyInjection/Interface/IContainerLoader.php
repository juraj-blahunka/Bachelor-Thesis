<?php

/**
 * Loads a Container Builder.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
interface IContainerLoader
{
	function load($resource);
}
