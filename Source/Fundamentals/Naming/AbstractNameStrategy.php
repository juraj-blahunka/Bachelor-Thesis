<?php

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
