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

 Date: 03/04/2018 16:25:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for article_collect
-- ----------------------------
DROP TABLE IF EXISTS `article_collect`;
CREATE TABLE `article_collect`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `article` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:已收藏|-1:取消收藏',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '收藏文章' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
