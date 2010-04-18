<?php

interface IRenderableResponse
{
	function getOriginalResponse();
	function setViewName($view);
	function getViewName();
	function setVariables(array $variables);
	function getVariables();
}
