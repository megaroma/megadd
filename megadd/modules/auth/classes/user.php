<?php
namespace megadd\modules\auth\classes	{
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
	class user {
		public $id = false;
		public $name = '';
		public $email = '';
		public $roles = array();
		public $online = false;

		public function __construct ($user,$roles,$online) {
			$this->roles = $roles;
			$this->online = $online;
			$this->id = $user['id'];
			$this->email = $user['email'];
			$this->name = $user['disp_name'];
		}

		public function get_id() {
			return $this->id;
		}

		public function get_name() {
			return $this->name;
		}

		public function get_email() {
			return $this->email;
		}

		public function get_roles() {
			return $this->roles;
		}

		public function is_online() {
			return $this->online;
		}

		public function has_role($role) {
			return in_array($role, $this->roles);
		}


	}
}
?>