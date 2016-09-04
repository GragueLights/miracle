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








