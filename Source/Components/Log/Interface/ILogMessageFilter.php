<?php

interface ILogMessageFilter
{
	function accept(ILogMessage $log);
}
