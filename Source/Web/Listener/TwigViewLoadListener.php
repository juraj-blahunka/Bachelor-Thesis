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
		$view      = $response->getView() . $this->defaultExtension;
		$variables = $response->getVariables();
		$template  = $this->twig->loadTemplate($view);
		$content   = $template->render($response->getVariables());
		$response->write($content);

		$event->setValue($response);
		return true;
	}
}
