<?php

interface IStorage
{
	function read($key, $default = null);
	function write($key, $data);
	function delete($key);
	function regenerate($destroy = false);
}
