<?php

interface ILogMessage
{
	function setMessage($log);
	function getMessage();

	function setParameters(array $params);
	function getParameters();
	function addParameters(array $params);
	function setParameter($name, $parameter);
	function getParameter($name, $default = null);
}
