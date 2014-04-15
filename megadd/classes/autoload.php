<?php
namespace megadd\classes {
if (!defined('MEGADD')) die ('Error 404 Not Found');
class autoload {
	static function load($class_name) {
		$path=str_replace('\\', '/', strtolower($class_name));
		require_once($path.".php");
	}
}
}
?>