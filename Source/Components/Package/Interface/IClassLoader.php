<?php

/**
 * A class loader.
 *
 * @package    BachelorThesis
 * @subpackage Package
 */
interface IClassLoader
{
	function registerClassLoader();
	function unregisterClassLoader();
}
