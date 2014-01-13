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

abstract function before();
abstract function after();

}
}


?>