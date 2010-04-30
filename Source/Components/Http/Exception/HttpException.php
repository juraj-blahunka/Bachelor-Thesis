<?php

/**
 * Base class for Http exceptions (404, 403, ..).
 *
 * @package    BachelorThesis
 * @subpackage Http
 */
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
