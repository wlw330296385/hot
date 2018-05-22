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

 Date: 22/05/2018 17:55:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for template_platform
-- ----------------------------
DROP TABLE IF EXISTS `template_platform`;
CREATE TABLE `template_platform`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `template` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板名称',
  `template_id` varbinary(200) NOT NULL COMMENT '模板ID',
  `platform` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `platform_id` int(11) NOT NULL,
  `t_id` varbinary(255) NOT NULL COMMENT '对应的模板id,如gXXoLU9ccggzyEgKrvDZoNYNnX71k7-A6gXHRAPU1qs',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板的{{remark.DATA}}',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
