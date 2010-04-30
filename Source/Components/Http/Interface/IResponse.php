<?php

/**
 * Writable response with cookies and headers.
 *
 * @package    BachelorThesis
 * @subpackage Http
 */
interface IResponse
{
	function dispatch();

	function setContent($content);
	function write($content);
	function getContent();
}
