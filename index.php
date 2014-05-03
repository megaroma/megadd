<?php
namespace {
use megadd\classes\core;
use megadd\helpers\cookie;
define('MEGADD', true);
header('Content-Type: text/html;charset=UTF-8');
mb_internal_encoding("UTF-8");
include "megadd/classes/autoload.php";
spl_autoload_register('megadd\classes\autoload::load');
set_error_handler('megadd\classes\core::err2exc', E_ALL & ~E_NOTICE &~ E_USER_NOTICE | E_STRICT);
error_reporting(E_ALL | E_STRICT);

core::init();

$route = core::arr($_GET,'route','');
$router = core::router();

$conf = core::conf();
cookie::$salt = core::arr($conf,'cookie_salt',null);

$db = false;
if ($db = core::module('db'))
{
$db->set_charset("utf8");
}

include "app/bootstrap.php";

$error = core::error();
$router->route($route);
core::load_conf();
$c = core::controller($router->controller);

try
{
$c->run($router->action,$router->id);
} catch (\megadd\exceptions\phpexception $e) { 
	$error->message('PHP Error',$e);
} catch (\megadd\exceptions\sysexception $e) { 
	$error->message('System Exception',$e);
} catch (\megadd\exceptions\modexception $e) { 
	$error->message('Module Exception',$e);
} catch (\Exception $e) {
	$error->message('Exception',$e);
}

if ($db) {
$db->close();
}

}
?>