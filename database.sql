CREATE database micro;

use micro;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
--

-- 表的结构 `micro_user`      用户信息表

--

CREATE TABLE `micro_user` (
  `uid` int(11) NOT NULL auto_increment,
  `utel` CHAR(12) NOT NULL UNIQUE ,
  `uname` VARCHAR(60) DEFAULT '',
  `upwd` VARCHAR(50) NOT NULL,
  `vcode` VARCHAR(10) DEFAULT '' COMMENT '验证码',
  `utype` TINYINT(2) NOT NULL COMMENT '用户类型',
  `create_time` DATETIME NOT NULL COMMENT '注册时间',
  `update_time` DATETIME NOT NULL COMMENT '',
  PRIMARY KEY(`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
--de9789254b9f6fd0854aed48abb587633555a0c9
--测试数据
INSERT INTO `micro_user` (`utel`,`uname`,`upwd`,`utype`,`create_time`,`update_time`) VALUES('18811708041','许小平','de9789254b9f6fd0854aed48abb587633555a0c9',1,'2016-09-04 10:00:00','2016-09-04 10:00:00');
INSERT INTO `micro_user` (`utel`,`uname`,`upwd`,`utype`,`create_time`,`update_time`) VALUES('18811708042','许小平','de9789254b9f6fd0854aed48abb587633555a0c9',2,'2016-09-04 10:00:00','2016-09-04 10:00:00');
INSERT INTO `micro_user` (`utel`,`uname`,`upwd`,`utype`,`create_time`,`update_time`) VALUES('18811708043','许小平','de9789254b9f6fd0854aed48abb587633555a0c9',3,'2016-09-04 10:00:00','2016-09-04 10:00:00');


--

-- 表的结构 `micro_activities`      活动表

--
CREATE TABLE `micro_activities`(
     `id` int(11) NOT NULL auto_increment,
     `uid` int(11) NOT NULL COMMENT '发布人id',
     `active_id` char(40) NOT NULL COMMENT '活动id',
     `name` varchar(60) NOT NULL COMMENT '发布人姓名',
     `tel` CHAR(12) NOT NULL COMMENT '联系方式',
     `title` varchar(255) NOT NULL COMMENT '标题',
     `content` LONGTEXT NOT NULL COMMENT '内容',
     `needs` LONGTEXT NOT NULL COMMENT '需求',
     `address` varchar(255) NOT NULL COMMENT '活动地址',
     `picture_url` varchar(255) DEFAULT '' COMMENT '图片地址',
     `star` int(3) DEFAULT 5 COMMENT '热门度',
     `money` int(11) DEFAULT 0 COMMENT '活动经费',
     `active_type` int(3) NOT NULL COMMENT '活动类型',
     `status` int(3) DEFAULT 1 COMMENT '活动状态',
     `join_num` int(11) DEFAULT 1 COMMENT '参与人数',
     `apply_num` int(11) DEFAULT 1 COMMENT '申请人数',
     `create_time` DATETIME NOT NULL,
     `end_time` DATETIME NOT NULL,
     PRIMARY KEY(`id`),
     CONSTRAINT `FK__ACT_UID` FOREIGN KEY (`uid`) REFERENCES `micro_user` (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



--

-- 表的结构 `micro_activities_apply`      活动申请表

--  Duplicate key on write or update"外键的名字不能重复
--
CREATE TABLE `micro_activities_apply`(
     `id` int(11) NOT NULL auto_increment,
     `uid` int(11) NOT NULL COMMENT '发布人id',
     `name` varchar(60) NOT NULL COMMENT '发布人姓名',
     `tel` CHAR(12) NOT NULL COMMENT '联系方式',
     `email` varchar(60)  NOT NULL COMMENT '通知邮箱',
     `material` varchar(255) NOT NULL COMMENT 'word链接',
     `msg` varchar(255) NOT NULL COMMENT '审核后留言',
     `manager` varchar(60) NOT NULL  COMMENT '审核人',
     `create_time` DATETIME NOT NULL,
     `end_time` DATETIME NOT NULL,
     `status` int(3) DEFAULT 1 COMMENT '状态',
     PRIMARY KEY(`id`),
     CONSTRAINT `APPLY_UID` FOREIGN KEY (`uid`) REFERENCES `micro_user` (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



--

-- 表的结构 `micro_ general_user_info`      普通用户表
--

CREATE TABLE `micro_ general_user_info`(
     `id` int(11) NOT NULL auto_increment,
     `uid` int(11) NOT NULL COMMENT '发布人id',
     `tel` char(12) NOT NULL COMMENT '联系方式',
     `email` varchar(60) NOT NULL COMMENT '邮箱',
     `name` varchar(60) NOT NULL COMMENT '姓名',
     `school` varchar(100) DEFAULT '' COMMENT '学校',
     `imgurl` varchar(255) DEFAULT '' COMMENT '头像',
     `integral` int(11) DEFAULT 0 COMMENT  '积分',
     `status` int(3) DEFAULT 1 COMMENT '状态',
     PRIMARY KEY(`id`),
     CONSTRAINT `FK_GENENAL_UID` FOREIGN KEY (`uid`) REFERENCES `micro_user` (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;




--

-- 表的结构 `micro_user_orginise`      用户组织表
--

CREATE TABLE `micro_user_orginise`(
     `id` int(11) NOT NULL auto_increment,
     `uid` int(11) NOT NULL COMMENT '发布人id',
     `og_id` char(40) NOT NULL COMMENT '组织id',
     `create_time` DATETIME NOT NULL COMMENT '加入时间',
     `back_time` DATETIME NOT NULL COMMENT '退出时间',
     `status` int(3) DEFAULT 1 COMMENT  '启动状态',
     PRIMARY KEY(`id`),
     CONSTRAINT `FK_USER_OGGINISE_UUID` FOREIGN KEY (`uid`) REFERENCES `micro_user` (`uid`),
     CONSTRAINT `FK_USER_OGGINISE_ID` FOREIGN KEY (`og_id`) REFERENCES `micro_orginise` (`og_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



--

-- 表的结构 `micro_orginise`      社团公司表
--

CREATE TABLE `micro_orginise`(
     `id` int(11) NOT NULL auto_increment,
     `uid` int(11) NOT NULL COMMENT '创建人id',
     `og_id` char(40) NOT NULL UNIQUE COMMENT '组织id',
     `name` varchar(100) NOT NULL COMMENT '组织名称',
     `manager` VARCHAR(40) NOT NULL COMMENT '负责人',
     `address` VARCHAR(255) NOT NULL  COMMENT '地址',
     `school` varchar(100) DEFAULT '' COMMENT '学校',
     `tel` char(12) NOT NULL COMMENT '联系方式',
     `email` VARCHAR(60) NOT NULL COMMENT '邮箱',
     `type` int(3) NOT NULL COMMENT '组织类型',
     `logo_url` VARCHAR(255) DEFAULT '' COMMENT '头像地址',
     `renzhen_url` VARCHAR(255) DEFAULT '' COMMENT '认证图片',
     `integral` int(11) DEFAULT 0 COMMENT '积分',
     `create_time` DATETIME NOT NULL COMMENT '创建时间',
      `update_time` DATETIME NOT NULL COMMENT '更新时间',
      `status` int(3) DEFAULT 1 COMMENT  '启用状态',
     PRIMARY KEY(`id`),
     CONSTRAINT `FK_USER_OGGINISE_UID` FOREIGN KEY (`uid`) REFERENCES `micro_user` (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--

-- 表的结构 `micro_orginise`      组织申请表
--

CREATE TABLE `micro_orginise_apply`(
     `id` int(11) NOT NULL auto_increment,
     `uid` int(11) NOT NULL COMMENT '发布人id',
     `name` varchar(60) NOT NULL COMMENT '发布人姓名',
     `tel` CHAR(12) NOT NULL COMMENT '联系方式',
     `email` varchar(60)  NOT NULL COMMENT '通知邮箱',
     `renzhen_url` VARCHAR(255) DEFAULT '' COMMENT '认证图片',
     `msg` varchar(255) NOT NULL COMMENT '审核后留言',
     `manager` varchar(60) NOT NULL  COMMENT '审核人',
     `create_time` DATETIME NOT NULL,
     `end_time` DATETIME NOT NULL,
     `status` int(3) DEFAULT 1 COMMENT '状态',
     `og_name` varchar(100) NOT NULL COMMENT '组织名称',
     `type` int(3) NOT NULL COMMENT '类型',
     PRIMARY KEY(`id`),
     CONSTRAINT `FK_ORGINISE_APPLY_UID` FOREIGN KEY (`uid`) REFERENCES `micro_user` (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

