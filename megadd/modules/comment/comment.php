<?php
namespace megadd\modules\comment {
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
	class comment {

		static function getInstance() {
			if (!(core::module('auth'))) throw new \megadd\exceptions\modexception(13, "Comment error: module AUTH is not found");
			$conf = core::conf('comment');
			if ($conf['comment_type'] == 'db') {
				if (!(core::module('db'))) {
					throw new \megadd\exceptions\modexception(13, "Comment error: module DB is not found");
				}
				return new classes\db();
			}
		}
	}
}
?>