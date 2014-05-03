<?php
namespace megadd\classes {
if (!defined('MEGADD')) die ('Error 404 Not Found');
class router {
	public $controller = "";
	public $action = "";
	public $id = "";

	private $def_controller = "index";
	private $def_action = "index";
	private $directories = array();
	
	private $dir_controller = array();
	private $dir_controller_action = array();

	public function set_dir($dir) {
		if (!in_array($dir, $this->directories)) {
			$this->directories[] = $dir;
		}
	}

	public function set_controller($dir, $controller) {
		if($dir == '') $dir = '.';
		$this->dir_controller[$dir] = $controller;
	}

	public function set_action($dir, $controller, $action) {
		if($dir == '') $dir = '.';
		if ($controller != '') {
			$this->dir_controller_action[$dir][$controller] = $action;
		}
	}

	public function set_def_controller($controller) {
		if($controller != '') {
		$this->def_controller = $controller;
		}
	}

	public function set_def_action($action) {
		if($action != '') {
		$this->def_action = $action;
		}
	}

	private function get_controller($dir) {
		if($dir == '') $dir = '.';
		if (isset($this->dir_controller[$dir])) {
			return $this->dir_controller[$dir];
		} else
		{
			return $this->def_controller;
		}
	}

	private function get_action($dir, $controller) {
		if($dir == '') $dir = '.';
		if(isset($this->dir_controller_action[$dir][$controller])) {
			return $this->dir_controller_action[$dir][$controller];
		} else
		{
			return $this->def_action;
		}

	}
	
	public function route($r) { 
		$dir = "";
		foreach ($this->directories as $d) {
			if ($d.'/' == substr($r.'/',0,strlen($d)+1)) {
				$dir = str_replace('/','\\',$d).'\\';
				$r = substr($r,strlen($d)+1);
				break;
			}
		}

		$p = explode("/", $r,3);
		if ($p[0] <> '') {
			$this->controller = $dir.$p[0];
			if ($p[1] <> '') {
				$this->action = $p[1];
				$this->id = isset($p[2]) ? $p[2] : '';
			} else {
				$this->action = $this->get_action($dir,$this->controller);
				$this->id = "";   
			}
			return true;  
		} else {
			$this->controller = $dir.$this->get_controller($dir);
			$this->action = $this->get_action($dir,$this->controller);
			$this->id = "";
			return false;
		}

	}

}
}
?>