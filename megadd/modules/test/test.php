<?php
namespace megadd\modules\test {
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
	class test {
		static function getInstance() {
			$conf = core::conf('test');
			if ($conf['mode'] == 'debug') {
				return new classes\debug();
			}
		}
	}
}
?>