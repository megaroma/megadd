<?php
if (!defined('MEGADD')) die ('Error 404 Not Found');
return array (
	'auth_type' => 'db',
	'session_max_time' => 1200, //20 minute 
	'login_by' => 'email', // username,email,both
	'password_min_length' => 4,
	'secret_word' => 'megaDD',
	'multi_login' => true 
);
?>