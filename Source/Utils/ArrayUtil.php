<?php

class ArrayUtil
{
	static public function inArrayCaseInsensitive($needle, $haystack)
	{
		foreach ($haystack as $value)
		{
			if (strtolower($value) == strtolower($needle))
			return true;
		}
		return false;
	}
}
