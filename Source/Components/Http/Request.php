<?php

class Request implements IRequest
{
	private
		$parameters,
		$cookies,
		$server;

	public function __construct($get = null, $post = null, $cookies = null, $server = null)
	{
		if ($get === null)     $get     = $_GET;
		if ($post === null)	   $post    = $_POST;
		if ($cookies === null) $cookies = $_COOKIE;
		if ($server === null)  $server  = $_SERVER;

		$this->parameters = array_merge($get, $post);
		$this->cookies    = $cookies;
		$this->server     = $server;

		$this->cleanRequest();
	}

	public function hasParameter($parameterKey)
	{
		return isset($this->parameters[$parameterKey]);
	}

	public function getParameter($parameterKey, $defaultValue = null)
	{
		return $this->hasParameter($parameterKey)
			? $this->parameters[$parameterKey]
			: $defaultValue;
	}

	public function setParameter($parameterKey, $parameterValue)
	{
		$this->parameters[$parameterKey] = $parameterValue;
	}

	public function hasCookie($cookieKey)
	{
		return isset($this->cookies[$cookieKey]);
	}

	public function getCookie($cookieKey, $defaultValue = null)
	{
		return $this->hasCookie($cookieKey)
			? $this->cookies[$cookieKey]
			: $defaultValue;
	}

	public function hasServer($serverKey)
	{
		return isset($this->server[$serverKey]);
	}

	public function getServer($serverKey, $defaultValue = null)
	{
		return $this->hasServer($serverKey)
			? $this->server[$serverKey]
			: $defaultValue;
	}

	public function isXmlHttpRequest()
	{
		return $this->getServer('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest';
	}

	protected function cleanRequest()
	{
		if (get_magic_quotes_gpc())
		{
			$this->parameters = $this->deepStripSlashes($this->parameters);
			$this->cookies    = $this->deepStripSlashes($this->cookies);
		}
	}

	protected function deepStripSlashes($value)
	{
		return is_array($value)
			? array_map(array($this, 'deepStripSlashes'), $value)
			: stripslashes($value);
	}
}

class RoutableRequest extends Request
{
	private
		$route;

	public function setRoute(IRoute $route)
	{
		$this->route = $route;
	}

	public function getRoute()
	{
		return $this->route;
	}
}

// usage
$r = new Request();
