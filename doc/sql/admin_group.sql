/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-15 11:17:56
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_group
-- ----------------------------
INSERT INTO `admin_group` VALUES ('1', '0', '超级管理员', 'woo', '0', '0', '1', '0', '0');
INSERT INTO `admin_group` VALUES ('2', '0', '财务部', '财务部', '1', '[1,4,15,16,17,18,19,20,64,65,66,67,68,69,70,71]', '1', '0', '0');
INSERT INTO `admin_group` VALUES ('3', '2', '出纳', '财务部的出纳', '1', '[1,4,15,16,17,18,19,20,64,65,66,67,68,69,70,71]', '1', '0', '0');
INSERT INTO `admin_group` VALUES ('4', '0', '行政部', '行政部', '2', '[1,3,7,8,9,10,11,12,12,13,14,22,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,72,73,74,75,76,77,78,81,5,21,82,83]', '1', '0', '0');
INSERT INTO `admin_group` VALUES ('5', '4', '行政专员', '行政专员', '1', '[1,3,7,8,9,10,11,12,12,13,14,22,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,72,73,74,75,76,77,78,81,5,21,83,82]', '1', '0', '0');
INSERT INTO `admin_group` VALUES ('6', '4', '客服专员', '客服专员', '2', '[1,3,7,8,9,10,11,12,12,13,14,22,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,72,73,74,75,76,77,78,81,5,21,83,82]', '1', '0', '0');
