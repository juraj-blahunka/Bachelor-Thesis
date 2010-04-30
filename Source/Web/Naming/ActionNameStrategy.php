<?php

/**
 * An action name inside controllers.
 *
 * @package    BachelorThesis
 * @subpackage Naming
 */
class ActionNameStrategy implements ISimpleNameStrategy
{
	public function getName($name)
	{
		$camelized = StringUtil::camelize($name);
		return lcfirst($camelized) . 'Action';
	}
}
