<?php
namespace megadv2\classes {
if (!defined('MEGADV')) die ('401 page not found');
class autoload {
	static function load($class_name) {
		$path=str_replace('\\', '/', $class_name);
		require_once($path.".php");
	}
}
}
?>