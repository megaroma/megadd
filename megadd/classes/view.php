<?php
namespace megadd\classes {
if (!defined('MEGADD')) die ('Error 404 Not Found');
	class view {
		private $template = "";
		private $path = "";
		private $data = array();
		private $global_data;
		

		public function __construct ($template, $path = "app/view/") {
			$this->template = $template;
			$this->path = $path;
			$this->global_data = core::global_data();
		}

		function __set($name,$value) {
			$this->data[$name] = $value;
		}

		function __get($name) {
			return (isset($this->data[$name]))? $this->data[$name] : '';
		}

		public function render() {
			extract($this->global_data->get_data(), EXTR_OVERWRITE);
			foreach ($this->data as $key => $value) {
				if (is_object($value)) {
					$$key = $value->render();
				} else {
					$$key = $value;
				}
			}
			ob_start();
			include $this->path.$this->template.".php";
			$text = ob_get_contents();
			ob_end_clean();
			return $text;
		}
	}
}
?>