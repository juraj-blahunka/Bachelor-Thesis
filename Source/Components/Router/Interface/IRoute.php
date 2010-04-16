<?php

interface IRoute
{
	function setPackage($package);
	function setController($controller);
	function setAction($action);
	function setParameters(array $params);

	function getPackage();
	function getController();
	function getAction();
	function getParameters();
}
