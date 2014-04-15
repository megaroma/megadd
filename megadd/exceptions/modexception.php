<?php
namespace megadd\exceptions {
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class modexception extends \Exception {
		public function __construct($errno, $errstr) {
			parent::__construct();
			$this->code = $errno;
			$this->message = $errstr;
		}
	}
}
?>