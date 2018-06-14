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

 Date: 14/06/2018 10:59:23
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
  `schedule_rebate` decimal(4, 2) NOT NULL,
  `camp_type` tinyint(4) NOT NULL COMMENT '训练营类型',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '-2:个人取消(解冻)|-1:拒绝(解冻)|1:申请中(冻结)|2:已同意(并解冻)|3:已打款',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营提现详情表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of camp_withdraw
-- ----------------------------
INSERT INTO `camp_withdraw` VALUES (1, 0.00, 0, 4, '准行者训练营', 6, 'legend', 0.00, 0.00, 9.20, 9.20, 1, 2, 0.00, 0, '', -2, '', 1524825418, 1524826130, NULL);
INSERT INTO `camp_withdraw` VALUES (2, 2.00, 0, 4, '准行者训练营', 6, 'legend', 0.00, 0.00, 9.20, 9.20, 1, 2, 0.00, 0, '', -2, '', 1524826121, 1524826923, NULL);
INSERT INTO `camp_withdraw` VALUES (3, 2.00, 0, 4, '准行者训练营', 6, 'legend', 0.00, 0.00, 9.20, 6009.20, 1, 2, 0.00, 0, '测试', -1, '就是不给，咋啦？！', 1524826939, 1527479263, NULL);
INSERT INTO `camp_withdraw` VALUES (4, 3.00, 0, 4, '准行者训练营', 6, 'legend', 0.00, 0.00, 7.20, 7.20, 1, 2, 0.00, 0, '', -2, '', 1524826999, 1527475338, NULL);
INSERT INTO `camp_withdraw` VALUES (5, 3.00, 0, 4, '准行者训练营', 6, 'legend', 0.00, 0.30, 4.20, 4.20, 1, 2, 0.00, 0, '', -2, '', 1524827359, 1524827394, NULL);
INSERT INTO `camp_withdraw` VALUES (6, 232800.00, 0, 9, '大热篮球俱乐部', 2, 'Hot-basketball2', 0.00, 23280.00, 273445.00, 273445.00, 3, 2, 0.00, 1, '', 3, '提现申请已同意并已打款', 1526031579, 1528876915, NULL);
INSERT INTO `camp_withdraw` VALUES (7, 2.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 0.00, 0.00, 4.80, 4.80, 4, 1, 0.00, 0, '', 3, '提现申请已同意并已打款', 1526987084, 1526987654, NULL);
INSERT INTO `camp_withdraw` VALUES (8, 1.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 0.00, 0.00, 2.80, 1.00, 4, 1, 0.00, 0, '这个要拒绝', -1, '1', 1526987619, 1526987731, NULL);
INSERT INTO `camp_withdraw` VALUES (9, 1.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 0.00, 0.00, 1.80, 1.80, 4, 1, 0.00, 0, '已打款', 3, '提现申请已同意并已打款', 1526987644, 1526987751, NULL);
INSERT INTO `camp_withdraw` VALUES (10, 45377.60, 0, 13, 'AKcross训练营', 18, 'AK', 0.00, 0.00, 62507.40, 62507.40, 5, 1, 0.00, 0, '4.5月', 3, '提现申请已同意并已打款', 1528271369, 1528876791, NULL);
INSERT INTO `camp_withdraw` VALUES (11, 3480.20, 0, 13, 'AKcross训练营', 18, 'AK', 0.00, 0.00, 17129.80, 17129.80, 5, 1, 0.00, 0, '', 3, '提现申请已同意并已打款', 1528274309, 1528876784, NULL);
INSERT INTO `camp_withdraw` VALUES (12, 154806.00, 0, 9, '大热篮球俱乐部', 2, 'Hot-basketball2', 0.00, 15480.60, 154806.00, 154806.00, 3, 2, 0.00, 1, '', -1, '测试', 1528877300, 1528877515, NULL);
INSERT INTO `camp_withdraw` VALUES (13, 10000.00, 0, 9, '大热篮球俱乐部', 2, 'Hot-basketball2', 0.00, 1000.00, 154806.00, 154806.00, 3, 2, 0.00, 1, '', -1, '测试', 1528877737, 1528877787, NULL);
INSERT INTO `camp_withdraw` VALUES (14, 128059.00, 0, 9, '大热篮球俱乐部', 2, 'Hot-basketball2', 0.00, 12805.90, 154806.00, 154806.00, 3, 2, 0.00, 1, '', 3, '提现申请已同意并已打款', 1528878132, 1528878185, NULL);
INSERT INTO `camp_withdraw` VALUES (15, 9738.20, 0, 13, 'AKcross训练营', 18, 'AK', 0.00, 0.00, 13581.40, 13581.40, 5, 1, 0.00, 0, '5月课时费', 3, '提现申请已同意并已打款', 1528878737, 1528878796, NULL);
INSERT INTO `camp_withdraw` VALUES (22, 1.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 0.00, 0.10, 1.00, 0.00, 4, 2, 0.00, 0, '', 3, '提现申请已同意并已打款', 1528882600, 1528882878, NULL);
INSERT INTO `camp_withdraw` VALUES (23, 8.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 0.00, 0.80, 10.00, 2.00, 4, 2, 0.00, 0, '', 3, '提现申请已同意并已打款', 1528883182, 1528883276, NULL);
INSERT INTO `camp_withdraw` VALUES (24, 2.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 0.00, 0.20, 2.00, 152.00, 4, 2, 0.00, 0, '', -1, '0', 1528883325, 1528945136, NULL);
INSERT INTO `camp_withdraw` VALUES (25, 10.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 2.00, 0.00, 100.00, 90.00, 4, 1, 0.00, 0, '', 3, '提现申请已同意并已打款', 1528883482, 1528885026, NULL);
INSERT INTO `camp_withdraw` VALUES (26, 20.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 0.00, 2.00, 90.00, 70.00, 4, 2, 0.00, 0, '', -2, '', 1528885303, 1528887773, NULL);
INSERT INTO `camp_withdraw` VALUES (27, 20.00, 0, 31, 'wow篮球兴趣训练营', 8, 'woo123', 0.00, 2.00, 70.00, 110.00, 4, 2, 0.00, 0, '', -1, '0', 1528885303, 1528885684, NULL);

SET FOREIGN_KEY_CHECKS = 1;
