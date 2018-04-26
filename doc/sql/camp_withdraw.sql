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

 Date: 26/04/2018 18:50:13
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
  `buffer` decimal(12, 2) NOT NULL COMMENT '冻结资金',
  `camp_withdraw_fee` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '手续费',
  `s_balance` decimal(12, 2) NOT NULL COMMENT '训练营余额(开始)',
  `e_balance` decimal(12, 2) NOT NULL COMMENT '训练营余额(结束)',
  `bank_id` int(11) NOT NULL COMMENT '关联的收款账号id',
  `camp_type` tinyint(4) NOT NULL COMMENT '训练营类型',
  `status` tinyint(4) NOT NULL COMMENT '-2:个人取消(解冻)|-1:拒绝(解冻)|1:申请中(冻结)|2:已同意(并解冻)|3:已打款',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营提现详情表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
