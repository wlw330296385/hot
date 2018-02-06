/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-06 11:16:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `referee`
-- ----------------------------
DROP TABLE IF EXISTS `referee`;
CREATE TABLE `referee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referee` varchar(60) NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:男:2女',
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `referee_city` varchar(60) NOT NULL COMMENT '接单城市',
  `referee_province` varchar(60) NOT NULL COMMENT '接单省份',
  `referee_area` varchar(60) NOT NULL DEFAULT '0' COMMENT '接单地区',
  `schedule_flow_init` int(10) NOT NULL DEFAULT '0' COMMENT '初始历史课时数',
  `star` int(11) NOT NULL DEFAULT '0' COMMENT '评分总分数',
  `star_num` int(11) NOT NULL DEFAULT '0' COMMENT '评分次数',
  `create_time` int(11) NOT NULL COMMENT '注册日期',
  `update_time` int(10) NOT NULL,
  `level` varchar(30) NOT NULL DEFAULT '1' COMMENT '等级',
  `total_played` int(10) NOT NULL COMMENT '出场次数',
  `tag1` varchar(30) NOT NULL COMMENT '标签',
  `tag2` varchar(30) NOT NULL COMMENT '标签',
  `tag3` varchar(30) NOT NULL COMMENT '标签',
  `tag4` varchar(30) NOT NULL COMMENT '标签',
  `tag5` varchar(30) NOT NULL COMMENT '标签',
  `referee_year` tinyint(4) NOT NULL COMMENT '执裁经验年数',
  `experience` varchar(255) NOT NULL COMMENT '教学经验描述',
  `introduction` text NOT NULL,
  `remarks` varchar(255) NOT NULL COMMENT 'remarks',
  `sys_remarks` varchar(255) NOT NULL COMMENT '系统备注',
  `portraits` varchar(255) NOT NULL COMMENT '肖像',
  `description` varchar(255) NOT NULL COMMENT '个人宣言',
  `referee_level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '教练等级,按学员流量算',
  `status` tinyint(4) NOT NULL COMMENT '0:未完善信息|1:正常|2:不通过|-1:禁用',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

