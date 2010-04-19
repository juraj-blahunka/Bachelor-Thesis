<?php

interface IActionInvoker
{
	function canInvoke($controller, IRoute $route);
	function invoke($controller, IRoute $route);
}
