create table `dd_users` 
(
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(50),
`disp_name` varchar(50),
`email` varchar(250),
`password` varchar(32),
`created` int(11) UNSIGNED,
`last_login` int(11) UNSIGNED,
 KEY `user_name_index` (`name`(10)),
 KEY `user_email_index` (`email`(10)),
 PRIMARY KEY (`id`)
 )  ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

create table `dd_roles`
(
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(50),
`description` text, 
PRIMARY KEY (`id`)
 )  ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
 
create table `dd_user_role`
(
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id` int(11) UNSIGNED,
`role_id` int(11) UNSIGNED,
KEY `user_id_index` (`user_id`),
PRIMARY KEY (`id`)
)  ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

create table `dd_auth_session` 
(
`user_id` int(11) UNSIGNED NOT NULL,
`session_id`  varchar(64),
`dt` int(11) UNSIGNED,
PRIMARY KEY (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


insert into `dd_roles` (`id`,`name`,`description`) values (1,'login','login user'),
                                                          (2,'admin','admin user');



------------------------------------------

