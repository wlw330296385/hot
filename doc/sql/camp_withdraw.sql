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

 Date: 27/04/2018 17:04:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for camp_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `camp_withdraw`;
CREATE TABLE `camp_withdraw`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `withdraw` decimal(12, 2) NOT NULL COMMENT '提现金额',
  `f_id` int(11) NOT NULL COMMENT '关联的output表id',
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `buffer` decimal(12, 2) NOT NULL COMMENT '冻结资金',
  `s_balance` decimal(12, 2) NOT NULL COMMENT '训练营余额(开始)',
  `e_balance` decimal(12, 2) NOT NULL COMMENT '训练营余额(结束)',
  `bank_id` int(11) NOT NULL COMMENT '关联的收款账号id',
  `rebate_type` tinyint(4) NOT NULL COMMENT '训练营结算类型',
  `camp_type` tinyint(4) NOT NULL COMMENT '训练营类型',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '-2:个人取消(解冻)|-1:拒绝(解冻)|1:申请中(冻结)|2:已同意(并解冻)|3:已打款',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营提现详情表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
