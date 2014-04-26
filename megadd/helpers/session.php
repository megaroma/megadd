<?php
namespace megadd\helpers {
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class session {
		private static $started = false;
		
		public static function start() {
			session_start();
			self::$started = true;
		}
		
		public static function get($key, $default = NULL) {
			if (!self::$started) {
				self::start();
			}
			if ( ! isset($_SESSION[$key])) {
				return $default;
			} else {
				return $_SESSION[$key];
			}
		}

		public static function set($name, $value) {
			if (!self::$started) {
				self::start();
			}
			$_SESSION[$name] = $value;
		}	
		
		public static function delete($name) {
			if (!self::$started) {
				self::start();
			}		
			unset( $_SESSION[$name] );
		}
	}
}
?>