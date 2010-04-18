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
		$filename = $this->directory . '/' . $response->getView() . $this->defaultExt;
		if (! file_exists($filename))
			return false;
		ob_start();
		extract($response->getVariables());
		include $filename;
		$content = ob_get_clean();
		$response->setContent($content);

		$event->setValue($response);
		return true;
	}
}
