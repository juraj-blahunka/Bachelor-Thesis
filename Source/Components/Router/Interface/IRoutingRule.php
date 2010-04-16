<?php

interface IRoutingRule
{
	function getName();
	function getPattern();
	function getParameters();
	function getRequirements();
}
