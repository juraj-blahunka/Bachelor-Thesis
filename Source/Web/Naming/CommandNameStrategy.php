<?php

class CommandNameStrategy extends AbstractNameStrategy
{
	public function getClassName($name)
	{
		$command = '';
		if (strpos($name, '/') === false)
		{
			$command = $name;
		}
		else
		{
			$parts = explode('/', $name);
			$command = array_pop($parts);
		}
		return StringUtil::camelize($command) . 'Command';
	}

	public function getFileName($name)
	{
		return StringUtil::camelize(str_replace('/', '/ ', $name)) . 'Command';
	}
}
