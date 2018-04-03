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

 Date: 03/04/2018 16:25:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for article_comment
-- ----------------------------
DROP TABLE IF EXISTS `article_comment`;
CREATE TABLE `article_comment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NULL DEFAULT NULL,
  `article` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '头像',
  `comment` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论内容,最大80个字',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '审核1:正常|-1:拒绝',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of article_comment
-- ----------------------------
INSERT INTO `article_comment` VALUES (1, 545, NULL, 'woo123', 8, '/uploads/images/avatar/560cafc1e4fc13031bdd73b48c7821bc22564e76', '456213416586', 1, 1522736592, 1522736592, NULL);
INSERT INTO `article_comment` VALUES (2, NULL, NULL, 'woo123', 8, '/uploads/images/avatar/560cafc1e4fc13031bdd73b48c7821bc22564e76', '', 1, 1522736947, 1522736947, NULL);

SET FOREIGN_KEY_CHECKS = 1;
