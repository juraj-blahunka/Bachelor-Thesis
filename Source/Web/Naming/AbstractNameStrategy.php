<?php

/**
 * Wide adopted strategy of camelization the identifier.
 *
 * @package    BachelorThesis
 * @subpackage Naming
 */
abstract class AbstractNameStrategy implements INameStrategy
{
	public function getName($name)
	{
		return StringUtil::camelize($name);
	}

	public function getFileName($name)
	{
		return StringUtil::camelize($name);
	}
}
