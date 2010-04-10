<?php

class ArrayUtil
{
	public static function inArrayCaseInsensitive($needle, $haystack)
	{
		foreach ($haystack as $value)
		{
			if (strtolower($value) == strtolower($needle))
			return true;
		}
		return false;
	}
}
