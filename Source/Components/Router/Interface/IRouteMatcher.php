<?php

interface IRouteMatcher
{
	function match($url, ICompiledRule $rule, IRoute $route);
}
