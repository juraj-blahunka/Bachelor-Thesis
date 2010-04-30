<?php

/**
 * Create a url from routing rule and parameters.
 *
 * @package    BachelorThesis
 * @subpackage Router
 */
interface IUrlCreator
{
	function makeUrl(IRoutingRule $rule, array $parameters = array());
}
