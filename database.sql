CREATE database micro;

use micro;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
--

-- 表的结构 `micro_user`      用户信息表

--

CREATE TABLE `micro_user` (
  `uid` int(11) NOT NULL auto_increment,
  `utel` CHAR(12) NOT NULL UNIQUE ,
  `uname` VARCHAR(60) NOT NULL,
  `upwd` VARCHAR(50) NOT NULL,
  `vcode` VARCHAR(10) DEFAULT NULL COMMENT '验证码',
  `utype` TINYINT(2) NOT NULL COMMENT '用户类型',
  `create_time` DATETIME NOT NULL COMMENT '注册时间',
  `update_time` DATETIME NOT NULL COMMENT '',
  PRIMARY KEY(`uid`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--测试数据
INSERT INTO `micro_user` VALUES();








