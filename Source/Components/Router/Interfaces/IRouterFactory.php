<?php

interface IRouterFactory
{
	function createCompiledRule($rule, $regex);
	function createRoute();
}
