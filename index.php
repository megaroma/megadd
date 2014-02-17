<?php
namespace {
use megadd\classes\core;
define('MEGADD', true);
include "megadd/classes/autoload.php";
spl_autoload_register('megadd\classes\autoload::load');

core::init();

$route = core::arr($_GET,'route','');
$router = core::router();

$router->set_dir('admin/dd');
$router->set_dir('admin');





$router->route($route);
core::load_conf();
$c = core::controller($router->controller);
$c->run($router->action,$router->id);




}
?>