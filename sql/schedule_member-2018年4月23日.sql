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

 Date: 23/04/2018 15:01:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for schedule_member
-- ----------------------------
DROP TABLE IF EXISTS `schedule_member`;
CREATE TABLE `schedule_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL,
  `schedule` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '(班级名称)',
  `camp_id` int(10) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练营',
  `lesson_id` int(11) NOT NULL COMMENT '课程id',
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程名',
  `grade_id` int(11) NOT NULL COMMENT '班级id',
  `grade` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级名称',
  `user_id` int(10) NOT NULL COMMENT '如果身份是student,则对应student_id,coach->coach_id',
  `user` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL COMMENT 'member表id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_transfer` int(11) NOT NULL DEFAULT 0 COMMENT '1拼课学员|0本班级学员',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:学生|2:教练;如果是1,member_id为student表的id',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '-1:无效未结算数据|1:有效已结算数据',
  `schedule_time` int(10) NOT NULL COMMENT '上课时间',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '课时-会员关系' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
