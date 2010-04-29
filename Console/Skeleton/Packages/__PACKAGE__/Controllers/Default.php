<?php

class DefaultController extends Controller
{
	public function indexAction()
	{
		return $this->getResponse()
			->setContent('<h1>New project succesfully started!</h1><p>Welcome to Default/Index</p>');
	}
}
