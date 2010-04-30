<?php

/**
 * Retrieve uniform name from provided identifier.
 *
 * @package    BachelorThesis
 * @subpackage Naming
 */
interface ISimpleNameStrategy
{
	function getName($name);
}
