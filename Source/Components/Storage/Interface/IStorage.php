<?php

/**
 * A Persistent storage interface.
 *
 * @package    BachelorThesis
 * @subpackage Storage
 */
interface IStorage
{
	function read($key, $default = null);
	function write($key, $data);
	function delete($key);
	function regenerate($destroy = false);
}
