<?php

class CommandNameStrategy extends AbstractNameStrategy
{
	public function getClassName($name)
	{
		return StringUtil::camelize(str_replace('/', '-', $name)) . 'Command';
	}

	public function getFileName($name)
	{
		return StringUtil::camelize(str_replace('/', '/ ', $name));
	}
}