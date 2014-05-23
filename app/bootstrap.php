<?php
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
use megadd\helpers\session;
use megadd\helpers\cookie;


date_default_timezone_set("America/New_York");

//sesion
session::start();

//Modules
core::load_module('test');
core::load_module('db');
core::load_module('auth');
core::load_module('comment');

//Dir
core::router()->set_dir('admin/dd');
core::router()->set_dir('admin');
//core::router()->set_action('', 'index', 'main');


?>