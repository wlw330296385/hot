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

 Date: 29/03/2018 11:52:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for crontab_record
-- ----------------------------
DROP TABLE IF EXISTS `crontab_record`;
CREATE TABLE `crontab_record`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `crontab` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '定时任务名称',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|0:错误',
  `callback_str` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_str` datetime(0) NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `create_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NULL DEFAULT NULL,
  `update_Time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
