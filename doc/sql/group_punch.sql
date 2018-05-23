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

 Date: 23/05/2018 18:47:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for group_punch
-- ----------------------------
DROP TABLE IF EXISTS `group_punch`;
CREATE TABLE `group_punch`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punch` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punch_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '打卡-群主关系表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
