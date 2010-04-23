<?php

class TwigViewLoadListener
{
	protected
		$twig,
		$defaultExtension;

	public function __construct(Twig_Environment $twig, $defaultExtension = '.html')
	{
		$this->twig             = $twig;
		$this->defaultExtension = $defaultExtension;
	}

	public function handle(IEvent $event)
	{
		$response  = $event->getParameter('response');

		$view      = $response->getViewName() . $this->defaultExtension;
		$variables = $response->getVariables();
		try
		{
			$template  = $this->twig->loadTemplate($view);
		}
		catch (RuntimeException $e)
		{
			// do not fail when template couldn't be found
			if (strpos($e->getMessage(), 'Unable to find template') === 0)
			{
				return false;
			}

			throw $e;
		}
		$content   = $template->render($response->getVariables());

		$rendered  = $response->getOriginalResponse();
		$rendered->write($content);

		$event->setValue($rendered);
		return true;
	}
}
