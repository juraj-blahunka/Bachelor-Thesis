<?php

class RenderableResponse implements IRenderableResponse
{
	protected
		$response,
		$viewName,
		$variables;

	public function __construct(IResponse $response)
	{
		$this->response = $response;
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

	public function setViewName($view)
	{
		$this->viewName = $view;
	}

	public function getViewName()
	{
		return $this->viewName;
	}
}