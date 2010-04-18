<?php

class Response implements IResponse
{
	private
		$headers,
		$cookies,
		$content,
		$variables;

	public function __construct(HeaderCollection $headers, CookieCollection $cookies)
	{
		$this->headers = $headers;
		$this->cookies = $cookies;
		$this->setContent('');
		$this->setVariables(array());
	}

	public function dispatch()
	{
		$this->dispatchHeaders();
		$this->dispatchContent();
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function getCookies()
	{
		return $this->cookies;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function write($content)
	{
		$this->content .= $content;
	}

	public function setVariables(array $variables)
	{
		$this->variables = $variables;
	}

	public function getVariables()
	{
		return $this->variables;
	}

	protected function dispatchContent()
	{
		echo $this->getContent();
	}

	protected function dispatchHeaders()
	{
		$headers = $this->getHeaders()->getArray();
		foreach ($headers as $name => $value)
		{
			header($name.': '.$value);
		}

		$cookies = $this->getCookies()->getArray();
		foreach ($cookies as $name => $value)
		{
			setcookie($name, $value['value'], $value['expire'], $value['path'], $value['domain'], $value['secure'], $value['httponly']);
		}
	}
}
