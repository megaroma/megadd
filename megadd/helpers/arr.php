<?php
namespace megadd\helpers {
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class arr {
		static function get($arr , $name, $default) {
			return isset($arr[$name]) ? $arr[$name] : $default;
		}
	}
}
?>