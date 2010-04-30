<?php

/**
 * Carries a response into which the view will be rendered.
 *
 * @package    BachelorThesis
 * @subpackage Http
 */
interface IRenderableResponse
{
	function getOriginalResponse();
	function setViewName($view);
	function getViewName();
	function setVariables(array $variables);
	function getVariables();
	function addVariables(array $variables);
}
