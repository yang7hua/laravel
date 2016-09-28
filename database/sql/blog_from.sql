create table if not exists `x_blog_from`(
	`id` int auto_increment,
	`name` varchar(20) not null comment '来源网站名称',
	`domain` varchar(50) not null default '' comment '网站域名',
	`count` int unsigned not null default 0 comment '该来源总共收录文章数',
	`status` tinyint unsigned not null default 1 comment '当前来源状态,1-正常,0-关闭',
	primary key(`fid`)
)engine=InnoDB default charset=utf8 comment='文章来源表';

create table if not exists `x_blog_from_config`(
	`id` int auto_increment,
	`fid` int unsigned not null comment 'blog_from_id',
	`cid` int unsigned not null comment '对应的文章分类id',
	`url` varchar(100) not null comment '开始爬取的url地址',
	`daily_count` int not null default 0 comment '每天需要抓取的最大量',
	`last_posttime` int unsigned not null default 0 comment '最后一次文章发表时间',
	`status` tinyint unsigned not null default 0 comment '状态',
	primary key(`id`),
	key fid(`fid`),
	key cid(`cid`)
)engine=InnoDB default charset=utf8 comment='抓取来源对应分类设置';
