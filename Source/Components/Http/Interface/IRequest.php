<?php

/**
 * Access to _GET, _POST, _COOKIE, _SERVER variables with added functionality.
 *
 * @package    BachelorThesis
 * @subpackage Http
 */
interface IRequest
{
	function hasParameter($parameterKey);
	function getParameter($parameterKey, $defaultValue = null);
	function setParameter($parameterKey, $parameterValue);
	function getParameters();

	function hasCookie($cookieKey);
	function getCookie($cookieKey, $defaultValue = null);

	function hasServer($serverKey);
	function getServer($serverKey, $defaultValue = null);


	function isSecure();
	function getProtocol();
	function getHost();
	function getHttpHost();
	function getMethod();

	function getBasePath();
	function getBaseUrl();
	function getRequestUri();
	function getPathInfo();

	function isXmlHttpRequest();
}
