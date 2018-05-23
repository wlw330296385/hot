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

 Date: 23/05/2018 17:30:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for group
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '社团名称',
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发起人',
  `member_id` int(11) NOT NULL,
  `members` int(11) NOT NULL DEFAULT 1 COMMENT '会员数',
  `rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规则',
  `punchs` int(11) NOT NULL COMMENT '打卡总数',
  `bonus` int(11) NOT NULL COMMENT '奖金总数',
  `season` int(11) NOT NULL DEFAULT 2 COMMENT '1:周季|2:月季|3:年季(22:00结算)',
  `stake` decimal(2, 0) NOT NULL DEFAULT 1 COMMENT '每次下注的钱,最大是10元/次',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|-1:解散',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '社群表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
