<?php

class ActionNameStrategy implements ISimpleNameStrategy
{
	public function getName($name)
	{
		$camelized = StringUtil::camelize($name);
		return lcfirst($camelized) . 'Action';
	}
}
