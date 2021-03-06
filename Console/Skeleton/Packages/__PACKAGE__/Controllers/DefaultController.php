<?php

class DefaultController extends Controller
{
	public function getCommands()
	{
		return array(
			'sayHelloAction' => 'Welcome/SayHello',
		);
	}

	public function indexAction()
	{
		return $this->render('Default/Index', array(
			'hello_url' => $this->generateUrl('controller-action', array(
				'controller' => 'default',
				'action'     => 'say-hello',
			))
		));
	}
}
