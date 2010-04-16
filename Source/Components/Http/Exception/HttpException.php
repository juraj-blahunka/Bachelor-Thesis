<?php

class HttpException extends Exception
{
	private $statusCode;

	public function __construct($statusCode, $message)
	{
		$this->statusCode = $statusCode;
		parent::__construct($message);
	}

	public function getStatusCode()
	{
		return $this->statusCode;
	}
}
