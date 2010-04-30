<?php

/**
 * A factory.
 *
 * @package    BachelorThesis
 * @subpackage Router
 */
class RouterFactory implements IRouterFactory
{
	public function createCompiledRule($rule, $regex)
	{
		return new CompiledRule($rule, $regex);
	}

	public function createRoute()
	{
		return new Route();
	}
}
