<?php

/**
 * Helper class for array manipulation.
 *
 * @package    BachelorThesis
 * @subpackage Utils
 */
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
