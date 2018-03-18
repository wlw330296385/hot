/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-05 17:55:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `banner`
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `banner` varchar(60) NOT NULL COMMENT 'banner的名字',
  `organization_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0:系统|1:训练营|2:球队|3:校园',
  `organization` varchar(60) NOT NULL DEFAULT '0',
  `organization_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1:正常',
  `ord` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES ('1', '1', '0', '0', '0', '/uploads/images/banner/1.jpg', '1', '0', '0', null);
INSERT INTO `banner` VALUES ('2', '1', '0', '0', '0', '/uploads/images/banner/2.jpg', '1', '0', '0', null);
INSERT INTO `banner` VALUES ('3', '2', '0', '0', '0', '/uploads/images/banner/3.jpg', '1', '0', '1512464501', null);
