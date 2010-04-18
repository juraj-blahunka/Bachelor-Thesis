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
		$template  = $this->twig->loadTemplate($view);
		$content   = $template->render($response->getVariables());

		$rendered  = $response->getOriginalResponse();
		$rendered->write($content);

		$event->setValue($rendered);
		return true;
	}
}
