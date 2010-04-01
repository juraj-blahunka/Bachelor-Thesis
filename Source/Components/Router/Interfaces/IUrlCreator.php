<?php

interface IUrlCreator
{
	function makeUrl(IRoutingRule $rule, array $parameters = array());
}
