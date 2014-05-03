<?php
namespace megadd\classes {
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class core {
		private static $router = false; 
		private static $conf = array();
		private static $modules = array();
		private static $models = array();		
		private static $error = false;
		private static $global_data = false;

		static function arr($arr,$value,$default) {
			if (isset($arr[$value])) {
				return $arr[$value];
			} else {
				return $default;
			}
		}

		static function error() {
			if (self::$error) {
				return self::$error;
			} else {
				self::$error = error::getInstance();
				return self::$error;
			}
		}

		static function global_data() {
			if (self::$global_data) {
				return self::$global_data;
			} else {
				self::$global_data = new global_data();
				return self::$global_data;
			}
		}
		
		static function router() {
			if (self::$router) {
				return self::$router;
			} else {
				self::$router = new router();
				return self::$router;
			}
		}

		static function init() {
			self::load_conf();
		}

		static function load_conf($grp = ".") {
			if ($grp == "") $grp = ".";
			if ($grp == '.') {
				if (file_exists('app/config/config.php')) {
					self::$conf['.'] = include('app/config/config.php'); 
				} else return false;
			} else {
				if (file_exists('app/config/'.$grp.'.php')) {
					self::$conf[$grp] = include('app/config/'.$grp.'.php');
				} elseif(file_exists('megadd/modules/'.$grp.'/config/'.$grp.'.php')) {
					self::$conf[$grp] = include('megadd/modules/'.$grp.'/config/'.$grp.'.php');
				} else return false;
			}
			return true;
		}

		static function conf($grp = ".") {
			if ($grp == "") $grp = ".";
			if (!isset(self::$conf[$grp])) {
				self::load_conf($grp);
			}
			return self::$conf[$grp];
		}
		
		static function conf_val($var) {
			if (strpos($var, '.') === false) {
				return self::$conf['.'][$var];
			} else {
				list($grp,$v) = explode(".", $var,2);
				$grp = ($grp == '') ? '.' : $grp;
				if (!isset(self::$conf[$grp])) {
					self::load_conf($grp);
				}				
				return self::$conf[$grp][$v];
			}
		}
		
		static function controller($controller_name) {
			$class_name = 'app\controller\\'.$controller_name;
			return new $class_name();
		}

		static function view($template, $path = "app/view/") {
			return new view($template, $path);
		}

		static function model($model_name) {
			if(isset(self::$models[$model_name])) {
				return self::$models[$model_name];
			} else {
				$class_name = 'app\model\\'.$model_name;
				self::$models[$model_name] = new $class_name();
				return self::$models[$model_name];
			}
		}		

		static function load_module($mod_name) {
			if (!(isset(self::$modules[$mod_name]))) {
				self::load_conf($mod_name);
				$class_name = "\\megadd\\modules\\$mod_name\\".$mod_name;
				self::$modules[$mod_name] = $class_name::getInstance();
			}
		}

		static function module($mod_name) {
			if(isset(self::$modules[$mod_name])) {
				return self::$modules[$mod_name];
			} else {
				return false;
			}
		}

		static function err2exc($errno, $errstr, $errfile, $errline) {
			throw new \megadd\exceptions\phpexception($errno, $errstr, $errfile, $errline);
		}
	}
}
?>