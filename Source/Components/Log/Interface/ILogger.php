<?php

/**
 * Creator of Log Messages, each method bears its own level of importance.
 *
 * @package    BachelorThesis
 * @subpackage Log
 */
interface ILogger
{
	function emergency($log, $additional = null);
	function alert($log, $additional = null);
	function critical($log, $additional = null);
	function error($log, $additional = null);
	function warning($log, $additional = null);
	function notice($log, $additional = null);
	function info($log, $additional = null);
	function debug($log, $additional = null);
}
