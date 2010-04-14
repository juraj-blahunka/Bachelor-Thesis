<?php

class ControllerNameStrategy extends AbstractNameStrategy
{
	public function getClassName($name)
	{
		return StringUtil::camelize($name) . 'Controller';
	}
}
