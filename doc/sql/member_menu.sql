/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-03-23 15:30:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `member_menu`
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
  `power_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:需要锁定训练营的|2:不锁定训练营的比如教练',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of member_menu
-- ----------------------------
INSERT INTO `member_menu` VALUES ('143', '0', 'management', '首页', 'fa fa-cog', '0', 'index/index', '_self', '1', '0', '1', '4', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('144', '0', 'management', '训练营财务管理', 'fa fa-cog', '0', '', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('145', '144', 'management', '资金账单', 'fa fa-cog', '0', 'StatisticsCamp/campBill', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('146', '144', 'management', '收益统计', 'fa fa-cog', '0', 'StatisticsCamp/campIncome', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('147', '144', 'management', '营业额统计', 'fa fa-cog', '0', 'StatisticsCamp/campTurnover', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('148', '144', 'management', '每月图表', 'fa fa-cog', '0', 'StatisticsCamp/campChart', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('149', '144', 'management', '每月报表', 'fa fa-cog', '0', 'StatisticsCamp/campStatistics', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('150', '144', 'management', '课时统计', 'fa fa-cog', '0', 'StatisticsCamp/campScheduleStatistics', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('151', '144', 'management', '课时结算表', 'fa fa-cog', '0', 'StatisticsCamp/lessonSchedule', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('152', '144', 'management', '赠课记录', 'fa fa-cog', '0', 'StatisticsCamp/campGift', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('153', '144', 'management', '订单列表', 'fa fa-cog', '0', 'StatisticsCamp/campBillList', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('154', '144', 'management', '提现列表', 'fa fa-cog', '0', 'StatisticsCamp/campWithdraw', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('155', '144', 'management', '教练工资月表', 'fa fa-cog', '0', 'StatisticsCamp/campCoachSalaryMth', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('156', '144', 'management', '教练工资明细', 'fa fa-cog', '0', 'StatisticsCamp/campCoachSalary', '_self', '1', '0', '1', '3', '1', '0', '0');
INSERT INTO `member_menu` VALUES ('157', '0', 'management', '教练员财务管理', 'fa fa-cog', '0', '', '_self', '1', '0', '1', '2', '2', '0', '0');
INSERT INTO `member_menu` VALUES ('158', '157', 'management', '资金账单', 'fa fa-cog', '0', 'StatisticsCoach/coachBill', '_self', '1', '0', '1', '2', '2', '0', '0');
INSERT INTO `member_menu` VALUES ('159', '157', 'management', '收益统计', 'fa fa-cog', '0', 'StatisticsCoach/coachIncome', '_self', '1', '0', '1', '2', '2', '0', '0');
INSERT INTO `member_menu` VALUES ('160', '157', 'management', '课时收入表', 'fa fa-cog', '0', 'StatisticsCoach/coachSalary', '_self', '1', '0', '1', '2', '2', '0', '0');
INSERT INTO `member_menu` VALUES ('161', '157', 'management', '提现列表', 'fa fa-cog', '0', 'StatisticsCoach/coachWithdraw', '_self', '1', '0', '1', '2', '2', '0', '0');
