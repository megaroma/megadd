<?php
namespace megadd\modules\auth {
if (!defined('MEGADD')) die ('Error 404 Not Found');
use megadd\classes\core;
	class auth {
		const ERROR_LOGIN_EXISTS = 1, //login is already taken
			  ERROR_EMAIL_EXISTS = 2, //email is already taken
			  ERROR_PASSWORD_INCORRECT = 3, //login or password is incorrect
			  ERROR_PERMISSION_DENIED = 4, //doesn't have role 'login'
			  ERROR_LOGIN_INCORRECT = 5,
			  ERROR_EMAIL_INCORRECT = 6,
			  ERROR_REG_PASSWORD_INCORRECT = 7,
			  ERROR_PASSWORD_TOO_SHORT = 8,
			  ERROR_REPEATED_PASSWORD = 9,
			  ERROR_DB = 10,
			  ERROR_WAS_NOT_LOGGED_IN = 11,
			  ERROR_MULTI_LOGIN = 12;

		static function getInstance() {
			$conf = core::conf('auth');
			if (!(core::module('db'))) {
				throw new \megadd\exceptions\modexception(13, "Auth error: module DB is not found");
			}
			if ($conf['auth_type'] == 'db') {
				return new classes\db();
			}
		}
	}
}
?>