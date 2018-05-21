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

 Date: 21/05/2018 16:03:55
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
  `camp_withdraw_fee` decimal(8, 2) NOT NULL COMMENT '平台手续费',
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
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营提现详情表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of camp_withdraw
-- ----------------------------
INSERT INTO `camp_withdraw` VALUES (1, 0.00, 0, 4, '准行者训练营', 6, 'legend', 0.00, 0.00, 9.20, 9.20, 1, 2, 0, '', -2, '', 1524825418, 1524826130, NULL);
INSERT INTO `camp_withdraw` VALUES (2, 2.00, 0, 4, '准行者训练营', 6, 'legend', 0.00, 0.00, 9.20, 9.20, 1, 2, 0, '', -2, '', 1524826121, 1524826923, NULL);
INSERT INTO `camp_withdraw` VALUES (3, 2.00, 0, 4, '准行者训练营', 6, 'legend', 2.00, 0.00, 9.20, 9.20, 1, 2, 0, '测试', 1, '', 1524826939, 1524826939, NULL);
INSERT INTO `camp_withdraw` VALUES (4, 3.00, 0, 4, '准行者训练营', 6, 'legend', 3.00, 0.00, 7.20, 7.20, 1, 2, 0, '测试', 1, '', 1524826999, 1524826999, NULL);
INSERT INTO `camp_withdraw` VALUES (5, 3.00, 0, 4, '准行者训练营', 6, 'legend', 0.00, 0.30, 4.20, 4.20, 1, 2, 0, '', -2, '', 1524827359, 1524827394, NULL);
INSERT INTO `camp_withdraw` VALUES (6, 232800.00, 0, 9, '大热篮球俱乐部', 2, 'Hot-basketball2', 256080.00, 23280.00, 273445.00, 273445.00, 3, 2, 1, '', 1, '', 1526031579, 1526031579, NULL);

SET FOREIGN_KEY_CHECKS = 1;
