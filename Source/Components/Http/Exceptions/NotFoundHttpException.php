<?php

class NotFoundHttpException extends HttpException
{
    public function __construct($message)
	{
		parent::__construct(404, $message);
	}
}
