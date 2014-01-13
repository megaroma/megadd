<?php
namespace megadv2\classes
{
class autoload
{
static function load($class_name)
{
$path=str_replace('\\', '/', $class_name);
require_once($path.".php");
}
}
}
?>