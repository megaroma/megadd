<?php
namespace megadd\modules\auth {
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
	class auth {
		static function getInstance() {
			$conf = core::conf('auth');
			if (!(core::module('db'))) {
				throw new \megadd\exceptions\modexception(13, "Auth error: module DB is not found");
			}
			if ($conf['auth_type'] == 'db') {
				return new classes\db();
			}
		}
	}
}
?>