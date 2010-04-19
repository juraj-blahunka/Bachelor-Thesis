<?php

interface IControllerLoader
{
	/**
	 * @var IRoute $route
	 * @return IController instance or false
	 */
	function loadController(IRoute $route);
}
