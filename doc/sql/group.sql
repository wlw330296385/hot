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

 Date: 12/06/2018 15:28:36
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
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类型:1:单位、2:球队、3:同学、4:朋友、5家族、-1:其他',
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发起人',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/static/default/avatar.png',
  `member_id` int(11) NOT NULL,
  `members` int(11) NOT NULL DEFAULT 0 COMMENT '会员数',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面\\logo',
  `notice` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告',
  `tenet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '铁尼特,宗旨',
  `rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规则',
  `punchs` int(11) NOT NULL DEFAULT 0 COMMENT '打卡总数',
  `bonus` int(11) NOT NULL DEFAULT 0 COMMENT '奖金总数',
  `season` int(11) NOT NULL DEFAULT 2 COMMENT '1:周季|2:月季|3:年季(22:00结算)',
  `max` int(11) NOT NULL DEFAULT 99 COMMENT '最大人数',
  `stake` decimal(2, 0) NOT NULL DEFAULT 1 COMMENT '每次下注的钱,最大是10元/次',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|-1:解散',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 36 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '社群表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group
-- ----------------------------
INSERT INTO `group` VALUES (1, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 7, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (2, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 40, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (3, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 60, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (4, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 45, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (5, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 20, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (6, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 61, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (7, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 91, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (8, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 43, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (9, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 71, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (10, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 44, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (11, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 84, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (12, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 83, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (13, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 12, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (14, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 83, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (15, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 40, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (16, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 42, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (17, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 26, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (18, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 61, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (19, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 7, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (20, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 79, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (21, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 69, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (22, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 48, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (23, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 84, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (24, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 25, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (25, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 49, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (26, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 53, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (27, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 16, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (28, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 82, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (29, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 66, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (30, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 6, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (31, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 31, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (32, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 64, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (33, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 73, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (34, '荣光', '4', 'wayen_z', '/static/default/avatar.png', 16, 2, '/uploads/images/group/2018/05/thumb_5b0f75ecc3672.jpg', '公告', '宗旨', '', 0, 0, 2, 99, 1, 1, 1527247392, 1527739897, NULL);
INSERT INTO `group` VALUES (35, 'One Sport', '2', 'HoChen', '/static/default/avatar.png', 1, 1, '/uploads/images/cert/2018/06/e3544dbdd43ab801eb02b1264203d5cbfff1cb6e.jpeg', '', '没宗旨', '', 0, 0, 2, 50, 1, 1, 1528080856, 1528080856, NULL);

SET FOREIGN_KEY_CHECKS = 1;
