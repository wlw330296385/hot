/*
 Navicat Premium Data Transfer

 Source Server         : 29
 Source Server Type    : MySQL
 Source Server Version : 100123
 Source Host           : localhost:3306
 Source Schema         : hot

 Target Server Type    : MySQL
 Target Server Version : 100123
 File Encoding         : 65001

 Date: 21/05/2018 16:14:11
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
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '开户行名称',
  `bank_branch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '开户行分支',
  `account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '账户名',
  `bank_card` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '账号',
  `telephone` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '预留电话',
  `status` tinyint(4) NOT NULL COMMENT '1:正常|-1:无效账户',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `system_reamrks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '训练营银行账户表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of camp_bankcard
-- ----------------------------
INSERT INTO `camp_bankcard` VALUES (1, 4, '准行者训练营', '兴业银行', '深圳南山支行', '准银行号', '6216654000012345678', '13826505160', 1, '', '', 1524825393, 1524825393, NULL);
INSERT INTO `camp_bankcard` VALUES (2, 40, '乐阵营篮球训练营', '中国工商银行', '中区支行', '文树超', '6212262012001139578', '15113963153', 1, '', '', 1525449324, 1525449324, NULL);
INSERT INTO `camp_bankcard` VALUES (3, 9, '大热篮球俱乐部', '中国工商银行', '南山支行', '大热体育文化（深圳）有限公司', '4000020309200575392', '13026617697', 1, '', '', 1526031348, 1526031348, NULL);

SET FOREIGN_KEY_CHECKS = 1;
