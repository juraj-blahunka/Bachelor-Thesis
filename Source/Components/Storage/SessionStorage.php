<?php

class SessionStorage implements IStorage
{
	static protected
		$started     = false,
		$regenerated = false;

	/**
	 * Constructor.
	 *
	 * @param string $name
	 * @param array $cookieOptions session cookie parameters (lifetime, path, domain, secure, httponly)
	 */
	public function __construct($name = 'DEFAULT_SESSION', array $cookieOptions = array())
	{
		$cookieOptions = array_merge(
			array('httponly' => false),   // httponly defined from PHP 5.2
			session_get_cookie_params(),  // default session cookie settings
			$cookieOptions                // user settings
		);

		$lifetime = $cookieOptions['lifetime'];
		$path     = $cookieOptions['path'];
		$domain   = $cookieOptions['domain'];
		$secure   = $cookieOptions['secure'];
		$httponly = $cookieOptions['httponly'];
		session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);

		session_name($name);
		if (! self::$started)
		{
			session_start();
			self::$started = true;
		}
	}

	public function read($key, $default = null)
	{
		return isset($_SESSION[$key])
			? $_SESSION[$key]
			: $default;
	}

	public function write($key, $data)
	{
		$_SESSION[$key] = $data;
	}

	public function delete($key)
	{
		unset($_SESSION[$key]);
	}

	public function regenerate($destroy = false)
	{
		if (! self::$regenerated)
		{
			session_regenerate_id($destroy);
			self::$regenerated = true;
		}
	}
}
