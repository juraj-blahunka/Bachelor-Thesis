<?php

interface IResponse
{
	function dispatch();

	function setContent($content);
	function write($content);
	function getContent();
}
