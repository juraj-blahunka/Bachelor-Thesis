<?php

/**
 * Creates a view from renderable response.
 *
 * @package    BachelorThesis
 * @subpackage Listener
 */
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
		$presenter = $event->getParameter('presenter');
		$route     = $event->getParameter('route');

		$paths = $this->paths->getPaths($route->getPackage() . '.views');
		foreach ($paths as $path)
		{
			$filename = $path . '/' . $presenter->getViewName() . $this->defaultExt;
			if (file_exists($filename))
			{
				$rendered = $presenter->getOriginalResponse();
				$rendered->setContent($this->renderView($filename, $presenter->getVariables()));
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
