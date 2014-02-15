<?php
namespace app\controller
{
use megadv2\classes\controller;
use megadv2\classes\core;
class index extends controller
{

public function before()
{

$mod = core::model('test');
echo $mod->test();
}
public function after()
{
}

function action_index()
{
core::load_module('test');
$main = core::view('main');

$test = core::module('test');

$index = core::view('index');
$index->test = $test->get_str();

$main->content = $index;

$this->respond($main);
}

function action_dd()
{
echo "dd";
}


}
}
?>