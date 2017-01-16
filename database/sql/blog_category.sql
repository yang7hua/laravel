create table if not exists `x_blog_category`(
	`id` int auto_increment,
	`pid` int unsigned not null default 0 comment '父级分类',
	`name` varchar(50) not null comment '分类名称',
	`code` varchar(10) not null comment '分类标识,字母组成',
	`count` int unsigned not null default 0 comment '文章总数',
	`show_index` tinyint unsigned not null default 0 comment '是否在首页显示',
	`show_detail` tinyint unsigned not null default 0 comment '是否在详情页显示',
	primary key(`cid`),
	key pid(`pid`),
	key name(`name`)
)engine=InnoDB default charset=utf8 comment='文章表';
