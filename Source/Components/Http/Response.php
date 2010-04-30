<?php

/**
 * Writable response with headers, cookies.
 *
 * @package    BachelorThesis
 * @subpackage Http
 */
class Response implements IResponse
{
	private
		$headers,
		$cookies,
		$content,
		$status;

	public function __construct(array $headers = array(), array $cookies = array(), IStatusCode $status = null)
	{
		$this->setContent('');
		$this->setHeaders($headers);
		$this->setCookies($cookies);
		$this->status = is_null($status) ? new HttpStatusCode(200) : $status;
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
			$this->setCookie(
				$name,
				isset($value['value']) ? $value['value'] : null,
				isset($value['expire']) ? $value['expire'] : null,
				isset($value['path']) ? $value['path'] : '/',
				isset($value['domain']) ? $value['domain'] : '',
				isset($value['secure']) ? $value['secure'] : false,
				isset($value['httponly']) ? $value['httponly'] : false
			);
		}
		return $this;
	}

	public function setCookie($name, $value, $expire = null, $path = '/', $domain = '', $secure = false, $httponly = false)
	{
		if (! is_null($expire))
		{
			if (is_numeric($expire))
			{
				$expire = (int) $expire;
			}
			else
			{
				$expire = strtotime($expire);
				if (($expire === false) || ($expire === -1))
				{
				  throw new InvalidArgumentException("Cookie[expire] parameter '{$expire}' is not valid");
				}
			}
		}

		$this->cookies[$name] = array(
			'name'     => $name,
			'value'    => $value,
			'expire'   => $expire,
			'path'     => $path,
			'domain'   => $domain,
			'secure'   => (Boolean) $secure,
			'httponly' => (Boolean) $httponly,
		);

		return $this;
	}

	public function getCookie($name, $default = null)
	{
		return isset($this->cookies[$name])
			? $this->cookies[$name]
			: $default;
	}

	public function deleteCookie($name)
	{
		$hourAgo = time() - 3600;
		$this->setCookie($name, "", $hourAgo);
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
		header($this->status->getHeaderText());

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
