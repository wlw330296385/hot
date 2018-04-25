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

 Date: 25/04/2018 16:15:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for camp_bankcard
-- ----------------------------
DROP TABLE IF EXISTS `camp_bankcard`;
CREATE TABLE `camp_bankcard`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bank` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '开户行名称',
  `bank_branch` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '开户行分支',
  `account` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账户名',
  `bank_card` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `telephone` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '预留电话',
  `status` tinyint(4) NOT NULL COMMENT '1:正常|-1:无效账户',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营银行账户表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
