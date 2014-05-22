<?php
namespace megadd\modules\comment\classes	{
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\helpers\cookie;
use megadd\helpers\session;
use megadd\classes\core;
	class db extends \megadd\modules\comment\comment {
		private $mod_name = "",
				$parent_id = "";
		
		public function setup($parent_id,$mod_name) {
			$this->mod_name = $mod_name;
			$this->parent_id = $parent_id;
		}

		public function add($comment,$guest_name = null,$guest_email = null) {
			if (is_array($comment)) {
				$subject = isset($comment['subject']) ? $comment['subject'] : '';
				$text = isset($comment['text']) ? $comment['text'] : '';
			} else {
				$subject = "";
				$text = $comment;
			}

			if(($text == '') || ($this->mod_name == '') || ($this->parent_id == ''))  return false;
			if(!$guest_name || $guest_name == '') $guest_name = 'Anonymous';
			$auth = core::module('auth');
			$db = core::module('db');
			$prefix = core::conf_val('tables_prefix');			
			if($user_id = $auth->logged_in()) {
				$p[':mod_name'] = $this->mod_name;
				$p[':parent_id'] = $this->parent_id;
				$p[':user_id'] = $user_id;
				$p[':subject'] = $subject;
				$p[':text'] = $text;
				$sql = "insert into `{$prefix}comment` (`mod_name`,`parent_id`,`user_id`,`created`,`subject`,`text`) values
													   ( :mod_name , :parent_id , :user_id , UNIX_TIMESTAMP(), :subject , :text )";
			} else {
				$p[':mod_name'] = $this->mod_name;
				$p[':parent_id'] = $this->parent_id;
				$p[':guest_name'] = $guest_name;
				$p[':guest_email'] = $guest_email;
				$p[':subject'] = $subject;
				$p[':text'] = $text;
				$sql = "insert into `{$prefix}comment` (`mod_name`,`parent_id`,`guest_name`,`guest_email`,`created`,`subject`,`text`) values
													   ( :mod_name , :parent_id , :guest_name , :guest_email , UNIX_TIMESTAMP(), :subject , :text )";
			}
			$db->query($sql,$p);
			return true;
		}

		public function get($start = 1,$end = '',$sort = 'asc') {
			$start = (int)$start;
			$end = (int)$end;
			if($sort == 'asc') {$sort = 'asc';} else {$sort = 'desc';} 
			if(($start > $end) || ($this->mod_name == '') || ($this->parent_id == ''))  return array();
			if ($end == '') $end = core::conf_val('comment.messages');
			$sql_limit = 'order by `id` '.$sort.' limit '.($start-1).','.$end;
			$sql = "select * from `{$prefix}comment` where `mod_name` = :mod_name and `parent_id` = :parent_id ".$sql_limit;
			$p[':mod_name'] = $this->mod_name;
			$p[':parent_id'] = $this->parent_id;
			$res = $db->query($sql,$p);
			return $res->rows();
		}

		public function get_page($page,$sort = 'asc') {
			$messages = core::conf_val('comment.messages');
			$page = (int)$page;
			if ($page > 0 ) {
				$start = ($page - 1) * $messages;
				$end = $messages;
				return $this->get($start,$end,$sort);
			} else {
				return array();
			}
		}

		public function count() {
			if(($this->mod_name == '') || ($this->parent_id == ''))  return 0;
			$sql = "select count(*) as `total` from `{$prefix}comment` where `mod_name` = :mod_name and `parent_id` = :parent_id ";
			$p[':mod_name'] = $this->mod_name;
			$p[':parent_id'] = $this->parent_id;
			$res = $db->query($sql,$p);
			$data = $res->fetch();
			return $data['total'];			
		}

		public function pages() {
			$messages = core::conf_val('comment.messages');
			$total = $this->count();
			if ($total > 0) {
				return ceil($total/$messages);
			} else {
				return 1;
			}
		}

	}
}