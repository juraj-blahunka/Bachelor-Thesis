<?php

class BasicViewLoadListener
{
	protected
		$directory,
		$defaultExt;

	public function __construct($directory, $defaultExt = '.html')
	{
		$this->directory  = $directory;
		$this->defaultExt = $defaultExt;
	}

	public function handle(IEvent $event)
	{
		$response = $event->getParameter('response');

		$filename = $this->directory . '/' . $response->getViewName() . $this->defaultExt;
		if (! file_exists($filename))
			return false;

		$rendered = $response->getOriginalResponse();
		$rendered->setContent($this->renderView($filename, $response->getVariables()));

		$event->setValue($rendered);
		return true;
	}

	protected function renderView($filename, $variables)
	{
		ob_start();
		extract($variables);
		include $filename;
		return ob_get_clean();
	}
}
