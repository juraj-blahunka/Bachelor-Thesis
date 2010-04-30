<?php

/**
 * A required resource was not found (404).
 *
 * @package    BachelorThesis
 * @subpackage Http
 */
class NotFoundHttpException extends HttpException
{
    public function __construct($message)
	{
		parent::__construct(404, $message);
	}
}
