<?php
namespace megadd\modules\test\classes	{
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class debug extends \megadd\modules\test\test {

		public function get_str() {
			return "from module test , mode debug<br>";
		}
	}
}
?>