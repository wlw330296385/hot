/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-25 15:12:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `referee_comment`
-- ----------------------------
DROP TABLE IF EXISTS `referee_comment`;
CREATE TABLE `referee_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `referee_id` int(10) NOT NULL,
  `referee` varchar(60) NOT NULL,
  `comment` varchar(240) NOT NULL COMMENT '评论内容',
  `attitude` decimal(4,1) NOT NULL COMMENT '态度得分,满分5分',
  `profession` decimal(4,1) NOT NULL COMMENT '专业得分',
  `teaching_attitude` decimal(4,1) NOT NULL COMMENT '教学态度得分',
  `teaching_quality` decimal(4,1) NOT NULL COMMENT '教学质量得分',
  `appearance` decimal(4,1) NOT NULL COMMENT '仪容仪表',
  `anonymous` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:匿名|1:实名',
  `delete_time` int(10) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of referee_comment
-- ----------------------------
INSERT INTO `referee_comment` VALUES ('1', '0', '游客', '/static/default/avatar.png', '21', '准', '123123 ', '0.0', '0.0', '0.0', '0.0', '0.0', '1', '0', '1517900295', '0000-00-00 00:00:00');
INSERT INTO `referee_comment` VALUES ('2', '8', 'woo123', 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', '21', 'legend', '123', '0.0', '0.0', '0.0', '0.0', '0.0', '1', '0', '1517911106', '0000-00-00 00:00:00');
