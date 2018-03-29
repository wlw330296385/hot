/*
 Navicat Premium Data Transfer

 Source Server         : 32
 Source Server Type    : MySQL
 Source Server Version : 100126
 Source Host           : 127.0.0.1:3306
 Source Schema         : hot

 Target Server Type    : MySQL
 Target Server Version : 100126
 File Encoding         : 65001

 Date: 29/03/2018 18:24:12
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for monthly_court_students
-- ----------------------------
DROP TABLE IF EXISTS `monthly_court_students`;
CREATE TABLE `monthly_court_students`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `court` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `court_id` int(11) NOT NULL,
  `students` int(11) NOT NULL COMMENT '学生总数',
  `date_str` datetime(0) NOT NULL COMMENT '201801',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '每月学员训练点分布' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
