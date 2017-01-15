CREATE TABLE `x_comment`(
	`id` int auto_increment,
	`cid` int unsigned not null default 0 comment '评论所属板块id, 默认为博文评论', 
	`bid` int unsigned not null comment '相关博文id',
	`pid` int unsigned not null default 0 comment '父级ID,用于回复',
	`uid` int unsigned not null default 0 comment '用户ID',
	`uname` varchar(50) not null default '' comment '用户名称',
	`email` varchar(50) not null default '' comment 'email',
	`content` varchar(5000) not null comment '评论内容',
	`posttime` int unsigned not null comment '评论时间',
	`uptime` int unsigned not null comment '更新时间',
	`ip` int unsigned not null comment 'IP地址',
	`approve` int unsigned not null default 0 comment '被认同次数',
	`status` tinyint unsigned not null default 1 comment '状态,1-显示,0-待审核,5-已删除',
	primary key(`id`),
	key uid(`uid`),
	key bid(`bid`,`cid`)
)ENGINE=InnoDB default charset=utf8 comment='评论表';
