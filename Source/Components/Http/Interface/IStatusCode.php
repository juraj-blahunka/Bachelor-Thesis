<?php

/**
 * Http status.
 *
 * @package    BachelorThesis
 * @subpackage Http
 */
interface IStatusCode
{
	function setCode($code);
	function getCode();
	function getCodeText();
	function setProtocolVersion($version);
	function getProtocolVersion();
	function getHeaderText();
}
