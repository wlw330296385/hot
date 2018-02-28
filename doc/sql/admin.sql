/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-28 18:20:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `truename` varchar(50) NOT NULL COMMENT '真实姓名',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `avatar` varchar(200) NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '头像',
  `telephone` bigint(20) NOT NULL COMMENT '手机号',
  `group_id` int(111) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1正常|0禁用',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `logintime` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `lastlogin_at` int(11) NOT NULL COMMENT '最后登录时间',
  `lastlogin_ip` varchar(20) NOT NULL COMMENT '最后登录ip',
  `lastlogin_ua` varchar(200) NOT NULL DEFAULT '' COMMENT '最后登录ua',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'HOT', '7288bc489a5be340d09e0db76f133b9b1856c50e', '大热篮球', '', '/static/default/avatar.png', '0', '1', '1', '0', '1519527191', '135', '1519527191', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36');
INSERT INTO `admin` VALUES ('2', 'yalu', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '/static/default/avatar.png', '0', '9', '1', '0', '1517281649', '46', '1517281649', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36');
INSERT INTO `admin` VALUES ('3', 'xian', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '111', '', '/static/default/avatar.png', '0', '5', '1', '1512456554', '1516678151', '33', '1516678151', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36');
INSERT INTO `admin` VALUES ('4', 'ho', 'a55330a47debc5933ae3a5a079e2537920b5ca20', '陈烈侯', '', '/static/default/avatar.png', '0', '7', '1', '1513053616', '1514088098', '5', '1514088098', '61.141.136.18', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.104 Safari/537.36 Core/1.53.3427.400 QQBrowser/9.6.12513.400');
INSERT INTO `admin` VALUES ('5', 'bingo', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '张文清', '', '/static/default/avatar.png', '0', '6', '1', '1513053730', '1513053730', '0', '0', '', '');
INSERT INTO `admin` VALUES ('6', 'yanzi', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '燕子', '', '/static/default/avatar.png', '0', '6', '1', '1513053901', '1513308206', '1', '1513308206', '116.25.42.196', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36');
INSERT INTO `admin` VALUES ('7', 'admin', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '/static/default/avatar.png', '0', '1', '1', '0', '1519798580', '10', '1519798580', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36');
