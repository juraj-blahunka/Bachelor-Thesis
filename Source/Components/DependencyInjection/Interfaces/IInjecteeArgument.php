<?php

interface IInjecteeArgument
{
	function resolve(IDependencyInjectionContainer $container,
		IComponentAdapter $adapter, $expectedType);
}