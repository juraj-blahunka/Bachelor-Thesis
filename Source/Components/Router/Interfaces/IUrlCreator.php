<?php

interface IUrlCreator
{
	function makeUrl(array $parameters, IRoutingRule $rule);
}
