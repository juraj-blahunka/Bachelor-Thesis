<?php

class Response implements IResponse
{
	private
		$headers,
		$cookies,
		$content,
		$status;

	public function __construct(array $headers = array(), array $cookies = array(), HttpStatusCode $status = null)
	{
		$this->setHeaders($headers);
		$this->setCookies($cookies);
		$this->status = is_null($status) ? new HttpStatusCode(200) : $status;
		$this->setContent('');
	}

	public function dispatch()
	{
		$this->dispatchHeaders();
		$this->dispatchContent();
	}

	public function setHttpStatusCode($code)
	{
		$this->status->setCode($code);
		return $this;
	}

	public function getHttpStatus()
	{
		return $this->status;
	}

	public function setHeaders(array $headers)
	{
		$this->headers = array();
		foreach ($headers as $name => $value)
		{
			$this->setHeader($name, $value);
		}
		return $this;
	}

	public function setHeader($name, $value)
	{
		$this->headers[$this->normalizeHeaderName($name)] = $value;
		return $this;
	}

	public function addHeader($name, $value)
	{
		$name = $this->normalizeHeaderName($name);
		if (isset($this->headers[$name]))
		{
			$value = $this->getHeader($name) . ',' . $value;
		}
		$this->setHeader($name, $value);
		return $this;
	}

	public function getHeader($name, $default = null)
	{
		$name = $this->normalizeHeaderName($name);
		return isset($this->headers[$name])
			? $this->headers[$name]
			: $default;
	}

	public function deleteHeader($name)
	{
		unset($this->headers[$this->normalizeHeaderName($name)]);
		return $this;
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	protected function normalizeHeaderName($name)
	{
		return strtolower($name);
	}

	public function setCookies(array $cookies)
	{
		$this->cookies = array();
		foreach ($cookies as $name => $value)
		{
			$this->setCookie($name);
		}
		return $this;
	}

	public function setCookie($name, $value, $expire, $path, $domain, $secure, $httponly)
	{
		return $this;
	}

	public function getCookies()
	{
		return $this->cookies;
	}

	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function write($content)
	{
		$this->content .= $content;
		return $this;
	}

	protected function dispatchContent()
	{
		echo $this->getContent();
	}

	protected function dispatchHeaders()
	{
		foreach ($this->headers as $name => $value)
		{
			$string = $name . ': ' . $value;
			header($string);
		}

		foreach ($this->cookies as $name => $value)
		{
			setcookie($name, $value['value'], $value['expire'], $value['path'], $value['domain'], $value['secure'], $value['httponly']);
		}
	}
}
