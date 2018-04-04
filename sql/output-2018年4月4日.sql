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

 Date: 04/04/2018 14:08:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for output
-- ----------------------------
DROP TABLE IF EXISTS `output`;
CREATE TABLE `output`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `output` decimal(12, 2) NOT NULL COMMENT '支出金额',
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `camp_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '操作人员',
  `member_id` int(11) NOT NULL COMMENT '操作人员id',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:赠课|2:课时退费|-1:提现|3:课时教练支出|4:平台分成|-2:其他支出',
  `e_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '产生数据后余额',
  `s_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '产生数据前余额',
  `schedule_time` int(11) NOT NULL COMMENT '上课时间',
  `rebate_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '平台分成类型',
  `f_id` int(11) NOT NULL COMMENT '外键',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态(预留字段)',
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '训练营支出表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of output
-- ----------------------------
INSERT INTO `output` VALUES (1, 200.00, '钟声训练营', 15, '朱涛', 87, '', 2, 86150.00, 86350.00, 0, 1, 74, 1, '', 1521505027, 1521505027, NULL);

SET FOREIGN_KEY_CHECKS = 1;
