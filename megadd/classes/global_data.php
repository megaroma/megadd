<?php
namespace megadd\classes {
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class global_data {
		private $data = array();

		function __set($name,$value) {
			$this->data[$name] = $value;
		}

		function __get($name) {
			return (isset($this->data[$name]))? $this->data[$name] : '';
		}

		public function get_data() {
			return $this->data;
		}
		
	}
}
?>