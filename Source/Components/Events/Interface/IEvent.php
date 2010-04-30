<?php

/**
 * Interface to define the data required in an Event.
 *
 * @package    BachelorThesis
 * @subpackage Events
 */
interface IEvent
{
	function getSender();
	function getName();
	function getParameters();
	function hasParameter($name);
	function getParameter($name, $default = null);
	function setParameter($name, $value);

	function isHandled();
	function setHandled($bool);

	function setValue($value);
	function getValue();
}
