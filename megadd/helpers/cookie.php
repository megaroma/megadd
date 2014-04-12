<?php
namespace megadd\helpers
{
if (!defined('MEGADD')) die ('401 page not found');
static class cookie {

public static $salt = NULL;
public static $expiration = 0;

public static function salt($name, $value)
	{
		if (!cookie::$salt) {
			throw new \megadd\exceptions\sysexception(13, "Cookie error: A valid cookie salt is required. Please set 'cookie_salt' in your config file.");
		}
		$agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : 'unknown';
		return sha1($agent.$name.$value.Cookie::$salt);
	}

	public static function get($key, $default = NULL)
	{
		if ( ! isset($_COOKIE[$key]))
		{
			return $default;
		}
		$cookie = $_COOKIE[$key];
		$split = strlen(cookie::salt($key, NULL));
		if (isset($cookie[$split]) && ($cookie[$split] === '~'))
		{
			list ($hash, $value) = explode('~', $cookie, 2);
			if (Cookie::salt($key, $value) === $hash)
			{
				return $value;
			}
			cookie::delete($key);
		}
		return $default;
	}

public static function set($name, $value, $expiration = NULL)
	{
		if ($expiration === NULL)
		{
			$expiration = cookie::$expiration;
		}

		if ($expiration !== 0)
		{
			$expiration += time();
		}
		$value = Cookie::salt($name, $value).'~'.$value;
		return setcookie($name, $value, $expiration);
	}	

public static function delete($name)
	{
		unset($_COOKIE[$name]);
		return setcookie($name, NULL, -86400);
	}
}




}
?>