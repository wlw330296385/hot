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

 Date: 12/06/2018 15:30:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for group_member
-- ----------------------------
DROP TABLE IF EXISTS `group_member`;
CREATE TABLE `group_member`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/static/default/avatar.png',
  `member_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '-2|退出-1:被剔除|1:正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 127 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '社群-会员关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group_member
-- ----------------------------
INSERT INTO `group_member` VALUES (1, '荣光', 1, 'wayen_z', '/static/default/avatar.png', 7, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (2, '荣光', 7, 'wayen_z', '/static/default/avatar.png', 31, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (3, '荣光', 14, 'wayen_z', '/static/default/avatar.png', 88, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (4, '荣光', 17, 'wayen_z', '/static/default/avatar.png', 63, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (5, '荣光', 15, 'wayen_z', '/static/default/avatar.png', 13, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (6, '荣光', 3, 'wayen_z', '/static/default/avatar.png', 79, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (7, '荣光', 23, 'wayen_z', '/static/default/avatar.png', 12, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (8, '荣光', 24, 'wayen_z', '/static/default/avatar.png', 59, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (9, '荣光', 8, 'wayen_z', '/static/default/avatar.png', 84, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (10, '荣光', 7, 'wayen_z', '/static/default/avatar.png', 8, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (11, '荣光', 19, 'wayen_z', '/static/default/avatar.png', 37, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (12, '荣光', 29, 'wayen_z', '/static/default/avatar.png', 31, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (13, '荣光', 16, 'wayen_z', '/static/default/avatar.png', 90, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (14, '荣光', 9, 'wayen_z', '/static/default/avatar.png', 83, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (15, '荣光', 4, 'wayen_z', '/static/default/avatar.png', 21, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (16, '荣光', 5, 'wayen_z', '/static/default/avatar.png', 27, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (17, '荣光', 29, 'wayen_z', '/static/default/avatar.png', 61, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (18, '荣光', 29, 'wayen_z', '/static/default/avatar.png', 58, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (19, '荣光', 28, 'wayen_z', '/static/default/avatar.png', 89, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (20, '荣光', 4, 'wayen_z', '/static/default/avatar.png', 62, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (21, '荣光', 8, 'wayen_z', '/static/default/avatar.png', 57, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (22, '荣光', 22, 'wayen_z', '/static/default/avatar.png', 25, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (23, '荣光', 8, 'wayen_z', '/static/default/avatar.png', 21, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (24, '荣光', 24, 'wayen_z', '/static/default/avatar.png', 94, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (25, '荣光', 22, 'wayen_z', '/static/default/avatar.png', 30, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (26, '荣光', 2, 'wayen_z', '/static/default/avatar.png', 20, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (27, '荣光', 26, 'wayen_z', '/static/default/avatar.png', 92, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (28, '荣光', 6, 'wayen_z', '/static/default/avatar.png', 32, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (29, '荣光', 23, 'wayen_z', '/static/default/avatar.png', 21, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (30, '荣光', 19, 'wayen_z', '/static/default/avatar.png', 57, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (31, '荣光', 25, 'wayen_z', '/static/default/avatar.png', 83, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (32, '荣光', 21, 'wayen_z', '/static/default/avatar.png', 70, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (33, '荣光', 29, 'wayen_z', '/static/default/avatar.png', 44, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (34, '荣光', 15, 'wayen_z', '/static/default/avatar.png', 35, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (35, '荣光', 27, 'wayen_z', '/static/default/avatar.png', 99, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (36, '荣光', 1, 'wayen_z', '/static/default/avatar.png', 62, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (37, '荣光', 19, 'wayen_z', '/static/default/avatar.png', 81, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (38, '荣光', 26, 'wayen_z', '/static/default/avatar.png', 57, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (39, '荣光', 10, 'wayen_z', '/static/default/avatar.png', 51, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (40, '荣光', 30, 'wayen_z', '/static/default/avatar.png', 15, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (41, '荣光', 8, 'wayen_z', '/static/default/avatar.png', 28, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (42, '荣光', 2, 'wayen_z', '/static/default/avatar.png', 40, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (43, '荣光', 30, 'wayen_z', '/static/default/avatar.png', 58, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (44, '荣光', 28, 'wayen_z', '/static/default/avatar.png', 68, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (45, '荣光', 14, 'wayen_z', '/static/default/avatar.png', 10, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (46, '荣光', 4, 'wayen_z', '/static/default/avatar.png', 17, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (47, '荣光', 30, 'wayen_z', '/static/default/avatar.png', 40, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (48, '荣光', 1, 'wayen_z', '/static/default/avatar.png', 6, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (49, '荣光', 12, 'wayen_z', '/static/default/avatar.png', 99, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (50, '荣光', 26, 'wayen_z', '/static/default/avatar.png', 15, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (51, '荣光', 1, 'wayen_z', '/static/default/avatar.png', 86, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (52, '荣光', 7, 'wayen_z', '/static/default/avatar.png', 17, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (53, '荣光', 24, 'wayen_z', '/static/default/avatar.png', 39, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (54, '荣光', 28, 'wayen_z', '/static/default/avatar.png', 36, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (55, '荣光', 3, 'wayen_z', '/static/default/avatar.png', 32, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (56, '荣光', 29, 'wayen_z', '/static/default/avatar.png', 74, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (57, '荣光', 18, 'wayen_z', '/static/default/avatar.png', 89, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (58, '荣光', 24, 'wayen_z', '/static/default/avatar.png', 28, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (59, '荣光', 21, 'wayen_z', '/static/default/avatar.png', 83, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (60, '荣光', 9, 'wayen_z', '/static/default/avatar.png', 91, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (61, '荣光', 30, 'wayen_z', '/static/default/avatar.png', 92, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (62, '荣光', 19, 'wayen_z', '/static/default/avatar.png', 68, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (63, '荣光', 27, 'wayen_z', '/static/default/avatar.png', 12, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (64, '荣光', 9, 'wayen_z', '/static/default/avatar.png', 20, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (65, '荣光', 11, 'wayen_z', '/static/default/avatar.png', 10, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (66, '荣光', 2, 'wayen_z', '/static/default/avatar.png', 29, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (67, '荣光', 1, 'wayen_z', '/static/default/avatar.png', 55, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (68, '荣光', 7, 'wayen_z', '/static/default/avatar.png', 20, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (69, '荣光', 11, 'wayen_z', '/static/default/avatar.png', 12, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (70, '荣光', 12, 'wayen_z', '/static/default/avatar.png', 77, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (71, '荣光', 1, 'wayen_z', '/static/default/avatar.png', 44, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (72, '荣光', 13, 'wayen_z', '/static/default/avatar.png', 30, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (73, '荣光', 13, 'wayen_z', '/static/default/avatar.png', 94, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (74, '荣光', 12, 'wayen_z', '/static/default/avatar.png', 34, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (75, '荣光', 22, 'wayen_z', '/static/default/avatar.png', 50, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (76, '荣光', 30, 'wayen_z', '/static/default/avatar.png', 18, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (77, '荣光', 15, 'wayen_z', '/static/default/avatar.png', 96, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (78, '荣光', 23, 'wayen_z', '/static/default/avatar.png', 39, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (79, '荣光', 5, 'wayen_z', '/static/default/avatar.png', 29, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (80, '荣光', 26, 'wayen_z', '/static/default/avatar.png', 83, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (81, '荣光', 2, 'wayen_z', '/static/default/avatar.png', 99, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (82, '荣光', 13, 'wayen_z', '/static/default/avatar.png', 62, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (83, '荣光', 28, 'wayen_z', '/static/default/avatar.png', 95, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (84, '荣光', 17, 'wayen_z', '/static/default/avatar.png', 96, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (85, '荣光', 4, 'wayen_z', '/static/default/avatar.png', 92, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (86, '荣光', 17, 'wayen_z', '/static/default/avatar.png', 5, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (87, '荣光', 9, 'wayen_z', '/static/default/avatar.png', 30, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (88, '荣光', 14, 'wayen_z', '/static/default/avatar.png', 7, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (89, '荣光', 5, 'wayen_z', '/static/default/avatar.png', 26, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (90, '荣光', 20, 'wayen_z', '/static/default/avatar.png', 29, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (91, '荣光', 23, 'wayen_z', '/static/default/avatar.png', 17, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (92, '荣光', 14, 'wayen_z', '/static/default/avatar.png', 63, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (93, '荣光', 25, 'wayen_z', '/static/default/avatar.png', 19, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (94, '荣光', 5, 'wayen_z', '/static/default/avatar.png', 55, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (95, '荣光', 27, 'wayen_z', '/static/default/avatar.png', 5, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (96, '荣光', 3, 'wayen_z', '/static/default/avatar.png', 32, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (97, '荣光', 27, 'wayen_z', '/static/default/avatar.png', 82, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (98, '荣光', 18, 'wayen_z', '/static/default/avatar.png', 49, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (99, '荣光', 23, 'wayen_z', '/static/default/avatar.png', 43, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (100, '荣光', 15, 'wayen_z', '/static/default/avatar.png', 34, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (101, '荣光', 1, 'wayen_z', '/static/default/avatar.png', 91, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (102, '荣光', 22, 'wayen_z', '/static/default/avatar.png', 46, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (103, '荣光', 17, 'wayen_z', '/static/default/avatar.png', 15, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (104, '荣光', 10, 'wayen_z', '/static/default/avatar.png', 57, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (105, '荣光', 12, 'wayen_z', '/static/default/avatar.png', 56, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (106, '荣光', 20, 'wayen_z', '/static/default/avatar.png', 34, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (107, '荣光', 15, 'wayen_z', '/static/default/avatar.png', 94, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (108, '荣光', 12, 'wayen_z', '/static/default/avatar.png', 21, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (109, '荣光', 26, 'wayen_z', '/static/default/avatar.png', 66, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (110, '荣光', 21, 'wayen_z', '/static/default/avatar.png', 9, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (111, '荣光', 28, 'wayen_z', '/static/default/avatar.png', 17, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (112, '荣光', 24, 'wayen_z', '/static/default/avatar.png', 85, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (113, '荣光', 22, 'wayen_z', '/static/default/avatar.png', 55, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (114, '荣光', 5, 'wayen_z', '/static/default/avatar.png', 69, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (115, '荣光', 19, 'wayen_z', '/static/default/avatar.png', 39, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (116, '荣光', 28, 'wayen_z', '/static/default/avatar.png', 19, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (117, '荣光', 15, 'wayen_z', '/static/default/avatar.png', 56, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (118, '荣光', 16, 'wayen_z', '/static/default/avatar.png', 26, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (119, '荣光', 24, 'wayen_z', '/static/default/avatar.png', 98, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (120, '荣光', 26, 'wayen_z', '/static/default/avatar.png', 62, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (121, '荣光', 27, 'wayen_z', '/static/default/avatar.png', 86, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (122, '荣光', 26, 'wayen_z', '/static/default/avatar.png', 13, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (123, '荣光', 12, 'wayen_z', '/static/default/avatar.png', 56, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (124, '荣光', 8, 'wayen_z', '/static/default/avatar.png', 71, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (125, '荣光', 11, 'wayen_z', '/static/default/avatar.png', 12, 1, 1527247409, 1527247409, NULL);
INSERT INTO `group_member` VALUES (126, 'One Sport', 35, 'HoChen', '/static/default/avatar.png', 1, 1, 1528080856, 1528080856, NULL);

SET FOREIGN_KEY_CHECKS = 1;
