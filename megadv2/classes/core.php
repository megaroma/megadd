<?php
namespace megadv2\classes
{
class core
{
private static $router = false; 
private static $conf = array();

static function arr($arr,$value,$default)
{
if (isset($arr[$value]))
  {
  return $arr[$value];
  } else
  {
  return $default;
  }
}

static function router()
{
if (self::$router) 
  {
  return self::$router;
  } else
  {
  self::$router = new router();
  return self::$router;
  }
}

static function conf($grp = ".")
{
if ($grp == "") $grp = ".";
if (!isset(self::$conf[$grp])) {
self::$conf[$grp] = array();
}

return ($grp == "") ? self::$conf['.'] : self::$conf[$grp];
}

//--------------
static function controller($controller_name)
{
$class_name = 'app\controller\\'.$controller_name;
return new $class_name();
}

static function view($template)
{
return new view($template);
}

static function model($model_name)
{
$class_name = 'app\model\\'.$model_name;
return new $class_name();
}

static function load_conf()
{
if(file_exists( "app/conf/conf.php")) {
self::$conf['.'] = include "app/conf/conf.php";
}

}





}}
?>