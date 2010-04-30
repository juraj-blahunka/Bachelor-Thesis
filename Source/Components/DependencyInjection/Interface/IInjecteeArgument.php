<?php

/**
 * Resolvable argument.
 *
 * @package    BachelorThesis
 * @subpackage DependencyInjection
 */
interface IInjecteeArgument
{
	function resolve(IDependencyInjectionContainer $container,
		IComponentAdapter $adapter);
}
