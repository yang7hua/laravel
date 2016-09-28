create table if not exists `x_blog_tag`(
	`id` int auto_increment,
	`name` varchar(20) not null,
	`count` int unsigned not null default 0 comment '文章数',
	primary key(`id`),
	key name(`name`)
)engine=InnoDB auto_increment=1 default charset=utf8 comment='tag表';
