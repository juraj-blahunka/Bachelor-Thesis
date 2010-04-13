<?php

class CommandNameStrategy extends AbstractNameStrategy
{
	public function getClassName($name)
	{
		return StringUtil::camelize($name) . 'Command';
	}
}
