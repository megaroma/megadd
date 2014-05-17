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

$auth = core::module('auth');





$index = core::view('index');

$main->error = "";

if(core::arr($_POST,'logout',false))
{
$auth->logout();
}

if($name = core::arr($_POST,'username',false))
{
$password = core::arr($_POST,'password','');
$auth->login(	$name,$password,false);
$main->error = $auth->error;
}
if ($user_id = $auth->logged_in()) {
$main->logged = true;
$user = $auth->get_user($user_id);
$main->name = $user->get_name();
} else {
$main->logged = false;
$main->name = "";
}


$index->test = $test->get_str();

$main->content = $index;

//-------

$db = core::module('db');

$p[':name'] = "Mega name";
$res = $db->query('select 13 as id, :name as name from dual',$p);
//echo $res->count();exit;
$row = $res->fetch();
//echo $row['name'];exit; 
$this->respond($main);
}

function action_main()
{

$img = core::lib('SimpleImage');
$img->create(120,120,'#FF0000');
$img->smooth(5);
$img->save('public/images/test.jpg');

$main = "page main";
$this->respond($main);
}

function action_dd()
{
$auth = core::module('auth');
$db = core::module('db');

//echo $auth->create_session_id(64);

$user_id = $auth->reg('giga','giga@mega.ru','test','test');
$auth->grant($user_id,'login');

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