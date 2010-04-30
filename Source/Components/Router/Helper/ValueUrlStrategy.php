<?php

/**
 * Provides injected url.
 *
 * @package    BachelorThesis
 * @subpackage Router
 */
class ValueUrlStrategy implements IUrlStrategy
{
	protected $url;

	public function __construct($url)
	{
		$this->url = $url;
	}

	public function getUrl()
	{
		return $this->url;
	}
}
