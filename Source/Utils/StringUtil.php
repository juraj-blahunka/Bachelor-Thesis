<?php

class StringUtil
{
	/**
	 * Underscores and hyphens represent a word separator, which is
	 * removed and next character is capitalized.
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

	/**
	 * Converts a string to slugified representation. Removes non alpha numeric
	 * characters, substitutes spaces with hyphens.
	 * Eg: "Hello World!" becomes "hello-world"
	 *
	 * @param string $string
	 * @return string
	 */
	static public function slugify($string)
	{
		$slug = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		$slug = strtolower($slug);
		$slug = preg_replace('/[^a-z0-9- ]/', '', $slug ); // remove all non-alphanumeric characters except for spaces and hyphens
		$slug = str_replace(' ', '-', $slug);              // substitute spaces with hyphens
		$slug = preg_replace('/(\-)+/', '-', $slug);       // remove continuous hyphens
		return $slug;
	}
}
