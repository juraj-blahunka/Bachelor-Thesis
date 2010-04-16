<?php

interface IActionInvoker
{
	function canInvoke($controller, $action, array $parameters);
	function invoke($controller, $action, array $parameters);
}
