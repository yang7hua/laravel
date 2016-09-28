create table if not exists `x_xadmin`(
	`id` int auto_increment,
	`username` varchar(20) not null,
	`password` varchar(32) not null, 
	`aid` smallint unsigned not null default 0 comment '权限id',
	`addtime` int unsigned not null,
	`status` tinyint unsigned not null default 1 comment '状态',
	`login_error_times` tinyint unsigned not null default 0 comment '登录错误次数',
	primary key(`id`),
	key uname(`username`)
)engine=MyISAM auto_increment=1 default charset=utf8 comment '管理员表'; 
