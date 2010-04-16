<?php

interface IControllerLoader
{
	/**
	 * @var string $name
	 * @return IController instance or false
	 */
	function loadController($name);
}
