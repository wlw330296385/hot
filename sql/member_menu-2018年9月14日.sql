/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : hot

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 14/09/2018 16:37:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for member_menu
-- ----------------------------
DROP TABLE IF EXISTS `member_menu`;
CREATE TABLE `member_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `module` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'management' COMMENT '模块名称',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'fa fa-cog',
  `url_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '链接类型（1：外链|0:模块）',
  `url_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接,比如 admin/lesson/create_lesson',
  `url_target` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '_self' COMMENT '链接打开方式：_blank|_self',
  `online_hide` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1:显示|0:隐藏',
  `sort` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `power` tinyint(2) NOT NULL DEFAULT 0 COMMENT '权限大小,如果这个字段值为3,那么必须power>=3的用户才能显示',
  `power_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:需要锁定训练营的|2:不锁定训练营的比如教练',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 197 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of member_menu
-- ----------------------------
INSERT INTO `member_menu` VALUES (143, 0, 'management', '首页', 'fa fa-home', 0, 'index/index', '_self', 1, 0, 1, 2, 1, 0, 0);
INSERT INTO `member_menu` VALUES (144, 0, 'management', '财务管理', 'fa fa-area-chart', 0, '', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (145, 144, 'management', '资金账单', 'fa fa-genderless', 0, 'StatisticsCamp/campBill', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (146, 144, 'management', '收益统计', 'fa fa-genderless', 0, 'StatisticsCamp/campIncome', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (147, 144, 'management', '营业额统计', 'fa fa-genderless', 0, 'StatisticsCamp/campTurnover', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (148, 144, 'management', '每月图表', 'fa fa-genderless', 0, 'StatisticsCamp/campChart', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (149, 144, 'management', '每月报表', 'fa fa-genderless', 0, 'StatisticsCamp/campStatistics', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (150, 144, 'management', '课时统计', 'fa fa-genderless', 0, 'StatisticsCamp/campScheduleStatistics', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (151, 144, 'management', '课时结算表', 'fa fa-genderless', 0, 'StatisticsCamp/lessonSchedule', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (152, 144, 'management', '赠课记录', 'fa fa-genderless', 0, 'StatisticsCamp/campGift', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (153, 144, 'management', '订单列表', 'fa fa-genderless', 0, 'StatisticsCamp/campBillList', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (154, 144, 'management', '提现列表', 'fa fa-genderless', 0, 'StatisticsCamp/campWithdraw', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (155, 144, 'management', '教练工资月表', 'fa fa-genderless', 0, 'StatisticsCamp/campCoachSalaryMth', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (156, 144, 'management', '教练工资明细', 'fa fa-genderless', 0, 'StatisticsCamp/campCoachSalary', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (157, 0, 'management', '个人财务管理', 'fa fa-cog', 0, '', '_self', 1, 0, 1, 2, 2, 0, 0);
INSERT INTO `member_menu` VALUES (158, 157, 'management', '资金账单', 'fa fa-genderless', 0, 'StatisticsCoach/coachBill', '_self', 1, 0, 1, 2, 2, 0, 0);
INSERT INTO `member_menu` VALUES (159, 157, 'management', '收益统计', 'fa fa-genderless', 0, 'StatisticsCoach/coachIncome', '_self', 1, 0, 1, 2, 2, 0, 0);
INSERT INTO `member_menu` VALUES (160, 157, 'management', '课时收入表', 'fa fa-genderless', 0, 'StatisticsCoach/coachSalary', '_self', 1, 0, 1, 2, 2, 0, 0);
INSERT INTO `member_menu` VALUES (161, 157, 'management', '提现列表', 'fa fa-genderless', 0, 'StatisticsCoach/coachWithdraw', '_self', 1, 0, 1, 2, 2, 0, 0);
INSERT INTO `member_menu` VALUES (162, 0, 'management', '学员管理', 'fa fa-user', 0, '', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (163, 162, 'management', '学员列表', 'fa fa-genderless', 0, 'Student/studentList', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (164, 162, 'management', '学员档案', 'fa fa-genderless', 0, 'Student/studentInfo', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (165, 0, 'management', '首页', 'fa fa-home', 0, 'index/indexOfCoach', '_self', 0, 0, 1, 2, 2, 0, 0);
INSERT INTO `member_menu` VALUES (166, 144, 'management', '退费列表', 'fa fa-genderless', 0, 'StatisticsCamp/refundList', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (167, 144, 'management', '退费处理', 'fa fa-genderless', 0, 'StatisticsCamp/refundDeal', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (168, 0, 'management', '机构管理', 'fa fa-cog', 0, '', '_self', 1, 0, 1, 2, 1, 0, 0);
INSERT INTO `member_menu` VALUES (169, 168, 'management', 'Banner管理', 'fa fa-cog', 0, 'banner/index', '_self', 1, 0, 1, 2, 1, 0, 0);
INSERT INTO `member_menu` VALUES (170, 169, 'management', 'Banner编辑', 'fa fa-cog', 0, 'banner/edit', '_self', 0, 0, 1, 2, 1, 0, 0);
INSERT INTO `member_menu` VALUES (171, 169, 'management', 'Banner删除', 'fa fa-cog', 0, 'banner/delete', '_self', 0, 0, 1, 2, 1, 0, 0);
INSERT INTO `member_menu` VALUES (172, 169, 'management', 'Banner添加', 'fa fa-cog', 0, 'banner/add', '_self', 0, 0, 1, 2, 1, 0, 0);
INSERT INTO `member_menu` VALUES (173, 174, 'management', '特殊活动报名列表', 'fa fa-cog', 0, 'Apps/appsApplyList', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (174, 0, 'management', '活动管理', 'fa fa-cog', 0, '', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (175, 174, 'management', '活动列表', 'fa fa-cog', 0, 'event/eventList', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (176, 174, 'management', '活动详情', 'fa fa-cog', 0, 'event/eventInfo', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (177, 174, 'management', '添加活动', 'fa fa-cog', 0, 'event/createEvent', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (178, 174, 'management', '编辑活动', 'fa fa-cog', 0, 'event/updateEvent', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (179, 0, 'management', '课程管理', 'fa fa-cog', 0, '', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (180, 179, 'management', '课程列表', 'fa fa-cog', 0, 'lesson/lessonList', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (181, 179, 'management', '添加课程', 'fa fa-cog', 0, 'lesson/createLesson', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (182, 179, 'management', '课程详情', 'fa fa-cog', 0, 'lesson/lessonInfo', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (183, 179, 'management', '编辑课程', 'fa fa-cog', 0, 'lesson/updateLesson', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (184, 0, 'management', '课时管理', 'fa fa-cog', 0, '', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (185, 184, 'management', '课时列表', 'fa fa-cog', 0, 'schedule/scheduleList', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (186, 184, 'management', '课时审核', 'fa fa-cog', 0, 'schedule/check', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (187, 184, 'management', '课时详情', 'fa fa-cog', 0, 'schedule/scheduleInfo', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (188, 184, 'management', '课时编辑', 'fa fa-cog', 0, 'schedule/updateSchedule', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (189, 184, 'management', '创建课时', 'fa fa-cog', 0, 'schedule/createSchedule', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (190, 184, 'management', '创建课时', 'fa fa-cog', 0, 'schedule/createSchedule', '_self', 0, 0, 1, 2, 2, 0, 0);
INSERT INTO `member_menu` VALUES (191, 0, 'management', '提现申请', 'fa fa-cog', 0, 'StatisticsCamp/Withdraw', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (192, 0, 'management', '班级管理', 'fa fa-cog', 0, '', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (193, 192, 'management', '班级列表', 'fa fa-cog', 0, 'grade/gradeList', '_self', 1, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (194, 192, 'management', '添加班级', 'fa fa-cog', 0, 'grade/creategrade', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (195, 192, 'management', '班级详情', 'fa fa-cog', 0, 'grade/gradeInfo', '_self', 0, 0, 1, 3, 1, 0, 0);
INSERT INTO `member_menu` VALUES (196, 192, 'management', '编辑班级', 'fa fa-cog', 0, 'grade/updategrade', '_self', 0, 0, 1, 3, 1, 0, 0);

SET FOREIGN_KEY_CHECKS = 1;
