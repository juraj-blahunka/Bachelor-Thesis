<?php

/**
 * All a controller needs, is the ability to construct complex classes.
 *
 * @package    BachelorThesis
 * @subpackage Controller
 */
interface IController
{
	function setContainer(IDependencyInjectionContainer $container);
	function getContainer();
}
