<?php

class SayHelloCommand extends Controller
{
	public function execute()
	{
		return $this->render('Default/SayHello');
	}
}
