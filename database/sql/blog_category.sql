create table if not exists `x_blog_category`(
	`id` int auto_increment,
	`pid` int unsigned not null default 0 comment '父级分类',
	`name` varchar(50) not null comment '分类名称',
	`code` varchar(10) not null comment '分类标识,字母组成',
	`count` int unsigned not null default 0 comment '文章总数',
	primary key(`cid`),
	key pid(`pid`)
)engine=InnoDB default charset=utf8 comment='文章表';
