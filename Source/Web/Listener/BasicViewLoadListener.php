<?php

class BasicViewLoadListener
{
	protected
		$paths,
		$defaultExt;

	public function __construct(PathCollection $paths, $defaultExt = '.php')
	{
		$this->paths      = $paths;
		$this->defaultExt = $defaultExt;
	}

	public function handle(IEvent $event)
	{
		$renderable = $event->getParameter('renderable');
		$route      = $event->getParameter('route');

		$paths = $this->paths->getPaths($route->getPackage() . '.views');
		foreach ($paths as $path)
		{
			$filename = $path . '/' . $renderable->getViewName() . $this->defaultExt;
			if (file_exists($filename))
			{
				$rendered = $renderable->getOriginalResponse();
				$rendered->setContent($this->renderView($filename, $renderable->getVariables()));
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
