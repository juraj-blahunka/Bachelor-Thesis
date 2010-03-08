<?php

interface IRoute
{
	function setController($controller);
	function setAction($action);
	function setParameters(array $params);

	function getController();
	function getAction();
	function getParameters();
}