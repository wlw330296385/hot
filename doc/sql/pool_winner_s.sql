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

 Date: 31/07/2018 15:28:37
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pool_winner_s
-- ----------------------------
DROP TABLE IF EXISTS `pool_winner_s`;
CREATE TABLE `pool_winner_s`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pool` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pool_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punchs` tinyint(4) NOT NULL DEFAULT 0,
  `winner_bonus` int(11) NOT NULL DEFAULT 0 COMMENT '获得奖金',
  `bonus` int(255) NOT NULL DEFAULT 0 COMMENT '当期奖金',
  `award_id` int(11) NOT NULL DEFAULT 0 COMMENT '奖品id',
  `award` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '奖品名称',
  `ranking` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排名',
  `is_message` tinyint(2) NOT NULL DEFAULT -1 COMMENT '是否已发送消息-1:发送|1已发送',
  `is_prize_giving` tinyint(2) NOT NULL DEFAULT -1 COMMENT '是否已发放奖金/奖品',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 137 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
