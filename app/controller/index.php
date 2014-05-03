<?php
namespace app\controller
{
use \megadd\classes\controller;
use \megadd\classes\core;
class index extends controller
{

public function before()
{

$mod = core::model('test');
$mod->test();

$this->signal( array (
'post' => array('s3?isset','s4?string=13'),
'action' => 'post'

	)
	);

}
public function after()
{
}

function action_index()
{

$main = core::view('main');

$test = core::module('test'); //

$index = core::view('index');
$index->test = $test->get_str();

$main->content = $index;

//-------

$db = core::module('db');
$db->connect();
$p[':name'] = "Mega name";
$res = $db->query('select 13 as id, :name as name from dual',$p);
//echo $res->count();exit;
$row = $res->fetch();
//echo $row['name'];exit; 
$this->respond($main);
}

function action_main()
{
$main = "page main";
$this->respond($main);
}

function action_dd()
{
$auth = core::module('auth');
$db = core::module('db');
$db->connect();
//echo $auth->create_session_id(64);

$user_id = $auth->reg('mega 66 Giga','mega3@mega.ru','password','');

echo 'error:'.$auth->error.' id:'.$user_id;

echo "<br>dd";
}

function action_post()
{
echo "post 13";
}



}
}
?>