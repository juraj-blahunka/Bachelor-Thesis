<?php

class Route implements IRoute
{
	private
		$controller,
		$action,
		$parameters = array();

	public function getAction()
	{
		return $this->action;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function setAction($action)
	{
		$this->action = $action;
		return $this;
	}

	public function setController($controller)
	{
		$this->controller = $controller;
		return $this;
	}

	public function setParameters(array $params)
	{
		$this->parameters = $params;
		return $this;
	}
}
