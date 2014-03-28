<?php
namespace {
use megadd\classes\core;
define('MEGADD', true);
include "megadd/classes/autoload.php";
spl_autoload_register('megadd\classes\autoload::load');
set_error_handler('megadd\classes\core::err2exc', E_ALL & ~E_NOTICE &~ E_USER_NOTICE | E_STRICT);
error_reporting(E_ALL | E_STRICT);


core::init();

$route = core::arr($_GET,'route','');
$router = core::router();

$router->set_dir('admin/dd');
$router->set_dir('admin');



$error = core::error();


$router->route($route);
core::load_conf();
$c = core::controller($router->controller);

try
{
$c->run($router->action,$router->id);
} catch (\megadd\exceptions\phpexception $e) { 
	$error->message('PHP Error',$e);
} catch (\Exception $e) {
	$error->message('Exception',$e);
}



}
?>