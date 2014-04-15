<?php
namespace megadd\exceptions {
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class phpexception extends \Exception {
		public function __construct($errno, $errstr, $errfile, $errline) {
			parent::__construct();
			$this->code = $errno;
			$this->message = $errstr;
			$this->file = $errfile;
			$this->line = $errline;
		}
	}
}
?>