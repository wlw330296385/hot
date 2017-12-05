/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-05 17:55:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_group`
-- ----------------------------
DROP TABLE IF EXISTS `admin_group`;
CREATE TABLE `admin_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `menu_auth` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_group
-- ----------------------------
INSERT INTO `admin_group` VALUES ('1', '0', '超级管理员', 'woo', '0', '0', '1', '0', '0');
INSERT INTO `admin_group` VALUES ('2', '0', '财务部', '财务部', '1', '[1,2,3,4,5,6,7,8,9,10]', '1', '0', '0');
INSERT INTO `admin_group` VALUES ('3', '2', '出纳', '财务部的出纳', '1', '[1,2,3,5,6,7,8,9,10,12,13,14,15,16,17,18,19,20,22,21]', '1', '0', '0');
