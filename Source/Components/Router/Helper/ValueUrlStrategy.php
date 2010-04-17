<?php

class ValueUrlStrategy implements IUrlStrategy
{
	protected $url;

	public function __construct($url)
	{
		$this->url = rtrim($url, '/');
	}

	public function getUrl()
	{
		return $this->url;
	}
}
