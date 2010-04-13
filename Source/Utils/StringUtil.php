<?php

class StringUtil
{
	/**
	 * Underscores and hyphens represent a word separator, which is
	 * removed and next character is capitalized
	 *
	 * @param string $string
	 * @return string
	 */
	static public function camelize($string)
	{
		$words = str_replace('-', ' ', str_replace('_', '-', $string));
		$upper = ucwords($words);
        return str_replace(' ','', $upper);
    }
}
