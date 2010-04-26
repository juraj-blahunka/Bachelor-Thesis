<?php

abstract class BaseController implements IController
{
	protected $container;

	public function setContainer(IDependencyInjectionContainer $container)
	{
		$this->container = $container;
	}

	public function getContainer()
	{
		return $this->container;
	}
}
