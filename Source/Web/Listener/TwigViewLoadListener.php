<?php

/**
 * Listener with advanced Templating engine.
 *
 * @package    BachelorThesis
 * @subpackage Listener
 */
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
		$renderable = $event->getParameter('renderable');

		$viewname   = $renderable->getViewName() . $this->defaultExtension;
		$variables  = $renderable->getVariables();
		try
		{
			$template  = $this->twig->loadTemplate($viewname);
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
		$content   = $template->render($renderable->getVariables());

		$response = $renderable->getOriginalResponse();
		$response->write($content);

		$event->setValue($response);
		return true;
	}
}
