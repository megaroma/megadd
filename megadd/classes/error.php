<?php
namespace megadd\classes
{
abstract class error
{

static function getInstance() {
	$conf = core::conf();
	if ($conf['debug_mode'] == 'true') {
		return new error\debug();
	}
}

abstract function message($type,\Exception $e);

}
}
?>