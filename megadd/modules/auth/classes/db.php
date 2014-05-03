<?php
namespace megadd\modules\auth\classes	{
use megadd\helpers\cookie;
use megadd\helpers\session;
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
	class db extends \megadd\modules\auth\auth {

		public $error = "";

		private function hash($word) {
			$secret_word = core::conf_val('auth.secret_word');
			return md5($secret_word.'-'.$word.'-ADD');
		}

		private function get_roles($user_id) {
			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');
			$p[':user_id'] = $user_id;
			$sql = "select `u`.`id` as `id`,`r`.`name` as `name` from `{$prefix}user_role` `u`,`{$prefix}roles` `r` 
			                                                    where `r`.`id` = `u`.`role_id` and `user_id` = :user_id ";
			$res = $db->query($sql,$p);
			$roles = array();
			while ($role = $res->fetch()) {
				$roles[$role['id']] = $role['name'];
			}
			return $roles;
		}

		private function create_session_id($length) {
			return str_shuffle(substr(str_repeat(md5(mt_rand()), 2+$length/32), 0, $length));
		}

		private function get_user_by_name($username) {
			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');
			$p[':username'] = $username;
			$sql = "select * from `{$prefix}users`  where `name` = LOWER(REPLACE( :username ,' ','')) ";
			$res = $db->query($sql,$p);
			if($res->count() > 0 ) {
				$data = $res->fetch();
				return $data;
			} else {
				return false;
			}
		}

		private function get_user_by_email($email) {
			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');
			$p[':email'] = $email;
			$sql = "select * from `{$prefix}users`  where `email` = LOWER(TRIM( :email )) ";
			$res = $db->query($sql,$p);
			if($res->count() > 0 ) {
				$data = $res->fetch();
				return $data;
			} else {
				return false;
			}
		}

		private function start_session($user_id,$session_id) {
			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');
			$p[':user_id'] = $user_id;
			$p[':session_id'] = $session_id;
			$sql = "insert into `{$prefix}auth_session` (`user_id`,`session_id`,`dt`) values ( :user_id , :session_id , UNIX_TIMESTAMP() ) ";
			$db->query($sql,$p);
		}

		private function delete_session($user_id) {
			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');
			$p[':user_id'] = $user_id;
			$sql = "delete from `{$prefix}auth_session` where `user_id` = :user_id ";
			$db->query($sql,$p);
		}
	
		private function delete_old_sessions() {
			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');
			$session_max_time = core::conf_val('auth.session_max_time');
			$sql = "delete from `{$prefix}auth_session` where (UNIX_TIMESTAMP() - `dt`) > :max_time ";
			$p[':max_time'] = $session_max_time;
			$db->query($sql,$p);
		}

		public function logout() {
			$this->delete_old_sessions();
			if ($user_id = session::get('auth_user_id',false)) {
				$this->delete_session($user_id);
				session::delete('auth_user_id');
				session::delete('auth_session_id');
				cookie::delete('user_identity');
				cookie::delete('user_code');
				return true;
			} else {
				return false;
			}
		}	

		public function login($identity, $password, $remember_user = false) {
			$db = core::module('db');
			$this->logout();
			$h_pass = $this->hash($password);
			$login_by = core::conf_val('auth.login_by');
			$prefix = core::conf_val('tables_prefix');
			if($login_by == 'email') {
				$sql_w = " `email` = :indentity ";
			} elseif ($login_by == 'username') {
				$sql_w = " `name` = :indentity ";
			} else {
				$sql_w = " (`name` = LOWER(REPLACE( :indentity ,' ','')) or `email` = :indentity ) ";
			}
			$sql = "select * from `{$prefix}users`  where ".$sql_w." and `password` = :hpassword ";
			$p[':indentity'] = $identity;
			$p[':hpassword'] = $h_pass;
			$res = $db->query($sql,$p);
			if($res->count() > 0 ) {
				$data = $res->fetch();
				$roles = $this->get_roles($data['id']);
				if(!in_array("login", $roles)) {
					$this->error = self::ERROR_PERMISSION_DENIED;
					return false;
				}
				$session_id = $this->create_session_id(64);
				session::set('auth_user_id',$data['id']);
				session::set('auth_session_id',$session_id);
				if($remember_user) {
					cookie::set('user_identity',$identity);
					cookie::set('user_code',$password);
				}
				$this->start_session($data['id'],$session_id);
				return true;
			} else {
				$this->error = self::ERROR_PASSWORD_INCORRECT;
				return false;
			}

		}

		public function reg($user_name,$email,$password,$r_password) {
			if (($user_name == '') || ($user_name === null)) {
				$this->error = self::ERROR_LOGIN_INCORRECT;
				return false;				
			}
			if ($this->get_user_by_name($user_name)) {
				$this->error = self::ERROR_LOGIN_EXISTS;
				return false;				
			}
			if (($email == '') || ($email === null)) {
				$this->error = self::ERROR_EMAIL_INCORRECT;
				return false;				
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$this->error = self::ERROR_EMAIL_INCORRECT;
				return false;					
			}
			if ($this->get_user_by_email($email)) {
				$this->error = self::ERROR_EMAIL_EXISTS;
				return false;				
			}
			if (($password == '') || ($password === null)) {
				$this->error = self::ERROR_REG_PASSWORD_INCORRECT;
				return false;				
			}
			$password_min_length = core::conf_val('auth.password_min_length');
			if (mb_strlen($password) < $password_min_length) {
				$this->error = self::ERROR_PASSWORD_TOO_SHORT;
				return false;				
			}
			if ($password != $r_password) {
				$this->error = self::ERROR_REPEATED_PASSWORD;
				return false;				
			}

			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');
			$sql = "insert into `{$prefix}users` (`name`,`disp_name`,`email`,`password`,`created`,`last_login`) values 
			                                     (  LOWER(REPLACE( :name ,' ','')) , :name , LOWER(TRIM( :email )) , :pass , UNIX_TIMESTAMP() , UNIX_TIMESTAMP() ) ";
			$p[':name'] = $user_name;
			$p[':email'] = $email;
			$p[':pass'] = $this->hash($password);
			$res = $db->query($sql,$p);
			if($res->count() > 0 ) {
				$sql = "select LAST_INSERT_ID() as `id` from dual ";
				$res = $db->query($sql);
				$row = $res->fetch();
				return $row['id'];
			} else {
				$this->error = self::ERROR_DB;
				return false;				
			}

		}
	
	}
}
?>