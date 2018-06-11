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

 Date: 08/06/2018 18:37:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pool_winner
-- ----------------------------
DROP TABLE IF EXISTS `pool_winner`;
CREATE TABLE `pool_winner`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pool` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pool_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punchs` tinyint(4) NOT NULL DEFAULT 0,
  `winner_bonus` int(11) NOT NULL COMMENT '获得奖金',
  `bonus` int(255) NOT NULL COMMENT '当期奖金',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 70 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
