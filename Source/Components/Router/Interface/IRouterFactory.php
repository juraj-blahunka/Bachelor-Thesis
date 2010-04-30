<?php

/**
 * A factory.
 *
 * @package    BachelorThesis
 * @subpackage Router
 */
interface IRouterFactory
{
	function createCompiledRule($rule, $regex);
	function createRoute();
}
