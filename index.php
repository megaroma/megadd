<?php
namespace {
use megadv2\classes\core;
include "megadv2/classes/autoload.php";
spl_autoload_register('megadv2\classes\autoload::load');

$route = core::arr($_GET,'route','');
$router = core::router();
$router->route($route);
$c = core::controller($router->controller);
$c->run($router->action,$router->id);


print_r($p);


}
?>