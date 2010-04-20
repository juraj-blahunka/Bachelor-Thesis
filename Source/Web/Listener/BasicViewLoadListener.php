<?php

class BasicViewLoadListener
{
	protected
		$paths,
		$defaultExt;

	public function __construct(PathCollection $paths, $defaultExt = '.html')
	{
		$this->paths      = $paths;
		$this->defaultExt = $defaultExt;
	}

	public function handle(IEvent $event)
	{
		$response = $event->getParameter('response');
		$route    = $event->getParameter('route');

		$paths = $this->paths->getPaths($route->getPackage() . '.views');
		foreach ($paths as $path)
		{
			$filename = $path . '/' . $response->getViewName() . $this->defaultExt;
			if (file_exists($filename))
			{
				$rendered = $response->getOriginalResponse();
				$rendered->setContent($this->renderView($filename, $response->getVariables()));
				$event->setValue($rendered);
				return true;
			}
		}
		return false;
	}

	protected function renderView($_filename, $_variables)
	{
		ob_start();
		extract($_variables);
		include $_filename;
		return ob_get_clean();
	}
}
