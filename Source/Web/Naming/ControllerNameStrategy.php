<?php

/**
 * Uniform controller names.
 *
 * @package    BachelorThesis
 * @subpackage Naming
 */
class ControllerNameStrategy extends AbstractNameStrategy
{
	public function getClassName($name)
	{
		return StringUtil::camelize($name) . 'Controller';
	}

	public function getFileName($name)
	{
		return StringUtil::camelize($name) . 'Controller';
	}
}
