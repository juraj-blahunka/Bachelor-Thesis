<?php

interface IEvent extends ArrayAccess
{
	function __construct($sender, $name, $args);

	function getSender();
	function getName();
	function getParameters();

	function isHandled();
	function setHandled($bool);

	function setValue($value);
	function getValue();
}