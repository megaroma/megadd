<?php
namespace {
use megadv2\classes\core;
include "megadv2/classes/autoload.php";
spl_autoload_register('megadv2\classes\autoload::load');

$route = core::arr($_GET,'route','');
$router = core::router();
$router->set_dir('admin/dd');
$router->set_dir('admin');


$router->route($route);
$c = core::controller($router->controller);
$c->run($router->action,$router->id);




}
?>