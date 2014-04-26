<?php
namespace megadd\classes {
use megadd\helpers\cookie;
use megadd\helpers\session;
if (!defined('MEGADD')) die ('Error 404 Not Found');

	abstract class controller {
		
		const R_POST = 1;
		const R_GET = 2;
		const R_SESSION = 3;
		const R_COOKIE = 4;

		private $id = "";
		private $signals = array();

		public function run ($action,$id) {
			$this->id = $id;
			$method = "action_".$action;
			$this->before();
			$signal_action = $this->run_signal();
			if($signal_action != '') {
				if (method_exists($this,$signal_action)) {
					$this->$signal_action();
				} else {
					throw new \megadd\exceptions\sysexception(11, "System error! Controller: ".get_class($this)." method '".$signal_action."' is not found.");
				}
			} else {
				$this->$method();
			}
			$this->after();
		}

		public function respond($view) {
			if (is_object($view)) {
				echo $view->render();
			} else {
				echo $view;
			}
		}

		public function signal($data) {
			$this->signals[] = $data;
		}

		public function  run_signal() { 
			$true_signal_id = array();
			foreach( $this->signals as $signal_id => $signal_data) {
				$signal_stat = true;
				if (isset($signal_data['id'])) {
					if($signal_data['id'] != $this->id) $signal_stat = false;
				}
				if(isset($signal_data['post'])) { 
					if(is_array($signal_data['post'])) {
						foreach ($signal_data['post'] as $post) {
							if(!$this->check_signal(self::R_POST,$post)) $signal_stat = false;
						} 
					} else {
						if(!$this->check_signal(self::R_POST,$signal_data['post'])) $signal_stat = false;
					}
				}
				if(isset($signal_data['get'])) {
					if(is_array($signal_data['get'])) {
						foreach ($signal_data['get'] as $get) {
							if(!$this->check_signal(self::R_GET,$get)) $signal_stat = false;
						} 
					} else {
						if(!$this->check_signal(self::R_GET,$signal_data['get'])) $signal_stat = false;
					}
				}
				if(isset($signal_data['session'])) {
					if(is_array($signal_data['session'])) {
						foreach ($signal_data['session'] as $session) {
							if(!$this->check_signal(self::R_SESSION,$session)) $signal_stat = false;
						} 
					} else {
						if(!$this->check_signal(self::R_SESSION,$signal_data['session'])) $signal_stat = false;
					}
				}  
				if(isset($signal_data['cookie'])) {
					if(is_array($signal_data['cookie'])) {
						foreach ($signal_data['cookie'] as $cookie) {
							if(!$this->check_signal(self::R_COOKIE,$cookie)) $signal_stat = false;
						} 
					} else {
						if(!$this->check_signal(self::R_COOKIE,$signal_data['cookie'])) $signal_stat = false;
					}
				}  

				if ($signal_stat) {
					$true_signal_id[] = $signal_id;
				}  
			}

			foreach ($true_signal_id as $signal_id) {
				if (isset($this->signals[$signal_id]['slot'])) {
					$method = 'slot_'.$this->signals[$signal_id]['slot'];
					if (method_exists($this,$method)) {
						$this->$method();
					} else {
						throw new \megadd\exceptions\sysexception(11, "System error! Controller: ".get_class($this)." method '".$method."' is not found.");
					}
				}

				if (isset($this->signals[$signal_id]['action'])) {
					$method = 'action_'.$this->signals[$signal_id]['action'];
					return $method;
				}
			}
			return '';
		}

		private function check_signal($type,$data) {
	
			if (strpos($data, '?') === FALSE) {
				$d_name = $data;
				$d_cond = '';
				$d_param = '';			
			} else { 
				list($d_name,$d_cond) = explode('?', $data, 2);
				if (strpos($d_cond, '=') === FALSE) {
					$d_param = '';
				} else { 
					list($d_cond,$d_param) = explode('=', $d_cond, 2);
				}
			}
			
			if(($type == self::R_POST ) && (isset($_POST[$d_name]))) {
			    $item = $_POST[$d_name];
			} elseif(($type == self::R_GET ) && (isset($_GET[$d_name]))) {
			    $item = $_GET[$d_name];
			} elseif(($type == self::R_COOKIE ) && (cookie::get($d_name,false))) {
			    $item = cookie::get($d_name);
			} elseif(($type == self::R_SESSION ) && (session::get($d_name,false))) {
			    $item = session::get($d_name);
			} else {
				return false;
			}

			if (($d_cond == '') && ($item != '')) {
				return true;
			} elseif($d_cond == 'isset') {
				return true;
			} elseif( ($d_cond == 'number') && (is_numeric($item)) && ($d_param == '')) {
				return true;
			} elseif( ($d_cond == 'number') && (is_numeric($item)) && ($d_param != '') && ($item == $d_param ) ) {
				return true;
			}  elseif( ($d_cond == 'string') && ($d_param == '')) {
				return true;
			}  elseif( ($d_cond == 'string') && ($d_param != '') && ($item == $d_param )) {
				return true;
			} else {
				return false;
			}
		}

		abstract function before();
		abstract function after();
	}
}
?>