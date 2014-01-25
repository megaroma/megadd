<?php
namespace megadv2\classes
{
abstract class controller
{
private $id = "";

public function run ($action,$id)
{
$this->id = $id;
$method = "action_".$action;
$this->before();
$this->$method();
$this->after();
}

public function respond($view)
{
if (is_object($view))
  {
  echo $view->render();
  } else
  {
  echo $view;
  }
}

abstract function before();
abstract function after();

}
}


?>