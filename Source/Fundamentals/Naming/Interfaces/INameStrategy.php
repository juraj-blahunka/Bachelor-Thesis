<?php

interface INameStrategy extends ISimpleNameStrategy
{
	function getClassName($name);
	function getFileName($name);
}
