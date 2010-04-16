<?php

interface IController
{
	function setContainer(IDependencyInjectionContainer $container);
	function getContainer();
}
