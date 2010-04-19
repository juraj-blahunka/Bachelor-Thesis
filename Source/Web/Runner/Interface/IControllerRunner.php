<?php

interface IControllerRunner
{
	function respondTo(IRequest $request);
	function run(IRoute $route);
}
