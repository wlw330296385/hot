/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-03-21 18:19:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `member_menu`;
CREATE TABLE `member_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `module` varchar(16) NOT NULL DEFAULT 'management' COMMENT '模块名称',
  `title` varchar(32) NOT NULL,
  `icon` varchar(64) NOT NULL DEFAULT 'fa fa-cog',
  `url_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '链接类型（1：外链|0:模块）',
  `url_value` varchar(255) NOT NULL DEFAULT '' COMMENT '链接,比如 admin/lesson/create_lesson',
  `url_target` varchar(16) NOT NULL DEFAULT '_self' COMMENT '链接打开方式：_blank|_self',
  `online_hide` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1:显示|0:隐藏',
  `sort` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `power` tinyint(2) NOT NULL DEFAULT '0' COMMENT '权限大小,如果这个字段值为3,那么必须power>=3的用户才能显示',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of admin_menu