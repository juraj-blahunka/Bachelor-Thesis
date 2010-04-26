<?php

class Request implements IRequest
{
	private
		$parameters,
		$cookies,
		$server,
		$httpHost,
		$basePath,
		$requestUri,
		$pathInfo;

	public function __construct($get = null, $post = null, $cookies = null, $server = null)
	{
		if ($get === null)     $get     = $_GET;
		if ($post === null)	   $post    = $_POST;
		if ($cookies === null) $cookies = $_COOKIE;
		if ($server === null)  $server  = $_SERVER;

		$this->parameters = array_merge($get, $post);
		$this->cookies    = $cookies;
		$this->server     = $server;

		$this->httpHost   = null;
		$this->basePath   = null;
		$this->requestUri = null;
		$this->pathInfo   = null;

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

	public function isSecure()
	{
		return strtolower($this->getServer('HTTPS')) == 'on' ||
			$this->getServer('HTTPS') == 1 ||
			strtolower($this->getServer('HTTP_SSL_HTTPS')) == 'on' ||
			$this->getServer('HTTP_SSL_HTTPS') == 1;
	}

	public function getProtocol()
	{
		return $this->isSecure() ? 'https' : 'http';
	}

	public function getHost()
	{
		if (($server = $this->getServer('HTTP_HOST')) !== null)
			return $server;
		if (($server = $this->getServer('SERVER_NAME')) !== null)
			return $server;
		if (($server = $this->getServer('SERVER_ADDR')) !== null)
			return $server;
		return '';
	}

	public function getHttpHost()
	{
		if ($this->httpHost === null)
			$this->httpHost = $this->fetchHttpHost();
		return $this->httpHost;
	}

	public function getMethod()
	{
		$method = $this->getServer('REQUEST_METHOD', 'GET');
		if (in_array($method, array('GET', 'POST', 'PUT', 'DELETE', 'HEAD')))
			return $method;
		return 'GET';
	}

	public function getBasePath()
	{
		if ($this->basePath === null)
			$this->basePath = $this->fetchBasePath();
		return $this->basePath;
	}

	public function getRequestUri()
	{
		if ($this->requestUri === null)
			$this->requestUri = $this->fetchRequestUri();
		return $this->requestUri;
	}

	public function getPathInfo()
	{
		if ($this->pathInfo === null)
			$this->pathInfo = $this->fetchPathInfo();
		return $this->pathInfo;
	}

	public function isXmlHttpRequest()
	{
		return $this->getServer('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest';
	}

	protected function fetchHttpHost()
	{
		if (($server = $this->getServer('HTTP_HOST')) !== null)
			return $server;

		$protocol = $this->getProtocol();
		$name     = $this->getServer('SERVER_NAME');
		$port     = $this->getServer('SERVER_PORT');

		return ($protocol === 'http' && $port == 80) || ($protocol === 'https' && $port == 443)
			? $name
			: $name . ':' . $port;
	}

	protected function fetchBasePath()
	{
		$basePath = '';
		$filename = basename($this->getServer('SCRIPT_FILENAME', ''));
		if (basename($this->getServer('SCRIPT_NAME')) === $filename)
			$basePath = $this->getServer('SCRIPT_NAME');
		elseif (basename($this->getServer('PHP_SELF')) === $filename)
			$basePath = $this->getServer('PHP_SELF');
		else
			throw new RuntimeException("Cannot decide base path");

		$requestUri = $this->getRequestUri();

		if (strpos($requestUri, $basePath) === 0)
		{
			return $basePath;
		}

		if (strpos($requestUri, dirname($basePath)) === 0)
		{
			$dir = dirname($basePath);
			return rtrim(dirname($basePath), '/');
		}

		return rtrim($basePath, '/');
	}

	protected function fetchRequestUri()
	{
		if (($requestUri = $this->getServer('REQUEST_URI')) !== null)
		{
			$location = $this->getProtocol() . '://' . $this->getHost();
			if (strpos($requestUri, $location) === 0)
				$requestUri = substr($requestUri, strlen($location));
		}
		return $requestUri;
	}

	protected function fetchPathInfo()
	{
		if (($path = $this->getServer('PATH_INFO')) !== null)
			return $path;

		$path       = '';
		$baseUrl    = $this->getBasePath();
		$requestUri = $this->getRequestUri();
		$query      = '?' . $this->getServer('QUERY_STRING', '');

		if (strpos($requestUri, $baseUrl) === 0)
			$path = '/' . ltrim(substr($requestUri, strlen($baseUrl)), '/');
		if (($pos = strpos($path, $query)) != 0)
			$path = substr($path, 0, $pos);

		return $path;
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
