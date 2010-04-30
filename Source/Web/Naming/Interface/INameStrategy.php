<?php

/**
 * Retrieve class name and filename from provided identifier.
 *
 * @package    BachelorThesis
 * @subpackage Naming
 */
interface INameStrategy extends ISimpleNameStrategy
{
	function getClassName($name);
	function getFileName($name);
}
