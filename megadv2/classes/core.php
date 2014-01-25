<?php
namespace megadv2\classes
{
class core
{
private static $router = false; 

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


}



}
?>