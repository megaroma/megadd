<?php
namespace megadd\modules\auth\classes	{
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
	class db extends \megadd\modules\auth\auth {

		private function delete_session($user_id) {
			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');

			$p[':user_id'] = $user_id;
			$sql = "delete from `{$prefix}auth_session` where `user_id` = :user_id ";
			$db->query($sql,$p);
		}
	
		private function delete_old_sessions() {
			$db = core::module('db');
			$conf = core::conf();
			$prefix = core::conf_val('tables_prefix');
			$session_max_time = core::conf_val('auth.session_max_time');
			$sql = "delete from `{$prefix}auth_session` where (UNIX_TIMESTAMP() - `dt`) > :max_time ";
			$p[':max_time'] = $session_max_time;
			$db->query($sql,$p);
		}
	
	
	}
}
?>