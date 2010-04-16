<?php

interface IRequest
{
	function hasParameter($parameterKey);
	function getParameter($parameterKey, $defaultValue = null);
	function setParameter($parameterKey, $parameterValue);

	function hasCookie($cookieKey);
	function getCookie($cookieKey, $defaultValue = null);

	function hasServer($serverKey);
	function getServer($serverKey, $defaultValue = null);

	function isXmlHttpRequest();
}
