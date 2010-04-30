<?php

/**
 * Carries a Response to which the rendered content will be written.
 *
 * @package    BachelorThesis
 * @subpackage Http
 */
class RenderableResponse implements IRenderableResponse
{
	protected
		$response,
		$viewName,
		$variables;

	public function __construct(IResponse $response)
	{
		$this->response  = $response;
		$this->variables = array();
	}

	public function getOriginalResponse()
	{
		return $this->response;
	}

	public function setVariables(array $variables)
	{
		$this->variables = $variables;
	}

	public function getVariables()
	{
		return $this->variables;
	}

	public function addVariables(array $variables)
	{
		$this->variables = array_merge($this->variables, $variables);
	}

	public function setViewName($view)
	{
		$this->viewName = $view;
	}

	public function getViewName()
	{
		return $this->viewName;
	}
}
