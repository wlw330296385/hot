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

 Date: 07/06/2018 18:45:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for group_punch
-- ----------------------------
DROP TABLE IF EXISTS `group_punch`;
CREATE TABLE `group_punch`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punch` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punch_id` int(11) NOT NULL,
  `punch_category` tinyint(4) NOT NULL COMMENT '1:训练|2:比赛',
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pool_id` int(11) NOT NULL,
  `pool` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stake` decimal(4, 0) NOT NULL DEFAULT 0 COMMENT '打卡金',
  `month_str` int(11) NOT NULL COMMENT '201805',
  `date_str` int(11) NOT NULL COMMENT '20180505',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 334 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '打卡-群主关系表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of group_punch
-- ----------------------------
INSERT INTO `group_punch` VALUES (1, 2, '', '', 0, 0, 30, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (2, 4, '', '', 0, 0, 77, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (3, 21, '', '', 0, 0, 24, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (4, 7, '', '', 0, 0, 50, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (5, 12, '', '', 0, 0, 11, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (6, 30, '', '', 0, 0, 41, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (7, 9, '', '', 0, 0, 50, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (8, 21, '', '', 0, 0, 96, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (9, 5, '', '', 0, 0, 39, '', 15, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (10, 19, '', '', 0, 0, 97, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (11, 24, '', '', 0, 0, 87, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (12, 14, '', '', 0, 0, 60, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (13, 10, '', '', 0, 0, 23, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (14, 9, '', '', 0, 0, 17, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (15, 1, '', '', 0, 0, 78, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (16, 13, '', '', 0, 0, 65, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (17, 26, '', '', 0, 0, 1, '', 1, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (18, 4, '', '', 0, 0, 24, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (19, 7, '', '', 0, 0, 44, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (20, 16, '', '', 0, 0, 51, '', 15, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (21, 23, '', '', 0, 0, 95, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (22, 15, '', '', 0, 0, 99, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (23, 2, '', '', 0, 0, 62, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (24, 14, '', '', 0, 0, 10, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (25, 5, '', '', 0, 0, 24, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (26, 27, '', '', 0, 0, 60, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (27, 8, '', '', 0, 0, 50, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (28, 10, '', '', 0, 0, 43, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (29, 25, '', '', 0, 0, 47, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (30, 17, '', '', 0, 0, 43, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (31, 29, '', '', 0, 0, 90, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (32, 7, '', '', 0, 0, 85, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (33, 2, '', '', 0, 0, 49, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (34, 1, '', '', 0, 0, 12, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (35, 13, '', '', 0, 0, 73, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (36, 6, '', '', 0, 0, 29, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (37, 1, '', '', 0, 0, 65, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (38, 2, '', '', 0, 0, 88, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (39, 9, '', '', 0, 0, 11, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (40, 3, '', '', 0, 0, 30, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (41, 27, '', '', 0, 0, 52, '', 15, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (42, 14, '', '', 0, 0, 41, '', 15, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (43, 12, '', '', 0, 0, 56, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (44, 10, '', '', 0, 0, 73, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (45, 22, '', '', 0, 0, 60, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (46, 19, '', '', 0, 0, 23, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (47, 28, '', '', 0, 0, 78, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (48, 7, '', '', 0, 0, 90, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (49, 12, '', '', 0, 0, 2, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (50, 17, '', '', 0, 0, 44, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (51, 1, '', '', 0, 0, 7, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (52, 28, '', '', 0, 0, 43, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (53, 26, '', '', 0, 0, 65, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (54, 10, '', '', 0, 0, 48, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (55, 11, '', '', 0, 0, 7, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (56, 10, '', '', 0, 0, 39, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (57, 23, '', '', 0, 0, 64, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (58, 1, '', '', 0, 0, 92, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (59, 8, '', '', 0, 0, 20, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (60, 7, '', '', 0, 0, 50, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (61, 17, '', '', 0, 0, 1, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (62, 14, '', '', 0, 0, 94, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (63, 6, '', '', 0, 0, 66, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (64, 14, '', '', 0, 0, 57, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (65, 9, '', '', 0, 0, 74, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (66, 21, '', '', 0, 0, 29, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (67, 17, '', '', 0, 0, 11, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (68, 1, '', '', 0, 0, 30, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (69, 29, '', '', 0, 0, 45, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (70, 7, '', '', 0, 0, 85, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (71, 28, '', '', 0, 0, 78, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (72, 3, '', '', 0, 0, 92, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (73, 16, '', '', 0, 0, 75, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (74, 13, '', '', 0, 0, 16, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (75, 15, '', '', 0, 0, 63, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (76, 3, '', '', 0, 0, 22, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (77, 5, '', '', 0, 0, 10, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (78, 3, '', '', 0, 0, 93, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (79, 10, '', '', 0, 0, 89, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (80, 29, '', '', 0, 0, 60, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (81, 30, '', '', 0, 0, 7, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (82, 10, '', '', 0, 0, 88, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (83, 12, '', '', 0, 0, 94, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (84, 2, '', '', 0, 0, 75, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (85, 23, '', '', 0, 0, 14, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (86, 2, '', '', 0, 0, 22, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (87, 17, '', '', 0, 0, 82, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (88, 25, '', '', 0, 0, 9, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (89, 13, '', '', 0, 0, 92, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (90, 6, '', '', 0, 0, 23, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (91, 23, '', '', 0, 0, 98, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (92, 19, '', '', 0, 0, 85, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (93, 21, '', '', 0, 0, 69, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (94, 23, '', '', 0, 0, 89, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (95, 18, '', '', 0, 0, 23, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (96, 11, '', '', 0, 0, 33, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (97, 10, '', '', 0, 0, 80, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (98, 10, '', '', 0, 0, 64, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (99, 20, '', '', 0, 0, 23, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (100, 13, '', '', 0, 0, 78, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (101, 19, '', '', 0, 0, 93, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (102, 3, '', '', 0, 0, 59, '', 15, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (103, 9, '', '', 0, 0, 16, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (104, 13, '', '', 0, 0, 55, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (105, 1, '', '', 0, 0, 67, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (106, 1, '', '', 0, 0, 16, '', 1, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (107, 17, '', '', 0, 0, 9, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (108, 20, '', '', 0, 0, 95, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (109, 8, '', '', 0, 0, 53, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (110, 20, '', '', 0, 0, 17, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (111, 18, '', '', 0, 0, 27, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (112, 5, '', '', 0, 0, 84, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (113, 8, '', '', 0, 0, 11, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (114, 20, '', '', 0, 0, 90, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (115, 1, '', '', 0, 0, 51, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (116, 6, '', '', 0, 0, 35, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (117, 12, '', '', 0, 0, 28, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (118, 5, '', '', 0, 0, 20, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (119, 13, '', '', 0, 0, 84, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (120, 7, '', '', 0, 0, 86, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (121, 8, '', '', 0, 0, 43, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (122, 10, '', '', 0, 0, 79, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (123, 14, '', '', 0, 0, 64, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (124, 7, '', '', 0, 0, 10, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (125, 6, '', '', 0, 0, 3, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (126, 5, '', '', 0, 0, 10, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (127, 4, '', '', 0, 0, 33, '', 1, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (128, 13, '', '', 0, 0, 29, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (129, 14, '', '', 0, 0, 52, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (130, 28, '', '', 0, 0, 77, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (131, 2, '', '', 0, 0, 47, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (132, 21, '', '', 0, 0, 2, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (133, 22, '', '', 0, 0, 72, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (134, 30, '', '', 0, 0, 8, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (135, 9, '', '', 0, 0, 99, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (136, 26, '', '', 0, 0, 75, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (137, 16, '', '', 0, 0, 84, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (138, 29, '', '', 0, 0, 7, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (139, 1, '', '', 0, 0, 9, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (140, 19, '', '', 0, 0, 57, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (141, 28, '', '', 0, 0, 13, '', 25, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (142, 17, '', '', 0, 0, 75, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (143, 24, '', '', 0, 0, 68, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (144, 6, '', '', 0, 0, 26, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (145, 12, '', '', 0, 0, 16, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (146, 27, '', '', 0, 0, 83, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (147, 3, '', '', 0, 0, 92, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (148, 27, '', '', 0, 0, 38, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (149, 7, '', '', 0, 0, 41, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (150, 11, '', '', 0, 0, 77, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (151, 3, '', '', 0, 0, 35, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (152, 3, '', '', 0, 0, 62, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (153, 7, '', '', 0, 0, 30, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (154, 16, '', '', 0, 0, 6, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (155, 27, '', '', 0, 0, 41, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (156, 26, '', '', 0, 0, 17, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (157, 19, '', '', 0, 0, 8, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (158, 27, '', '', 0, 0, 52, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (159, 29, '', '', 0, 0, 67, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (160, 29, '', '', 0, 0, 52, '', 25, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (161, 6, '', '', 0, 0, 25, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (162, 15, '', '', 0, 0, 27, '', 25, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (163, 22, '', '', 0, 0, 23, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (164, 20, '', '', 0, 0, 38, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (165, 16, '', '', 0, 0, 86, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (166, 14, '', '', 0, 0, 97, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (167, 23, '', '', 0, 0, 6, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (168, 16, '', '', 0, 0, 10, '', 1, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (169, 6, '', '', 0, 0, 95, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (170, 18, '', '', 0, 0, 39, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (171, 18, '', '', 0, 0, 91, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (172, 9, '', '', 0, 0, 8, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (173, 5, '', '', 0, 0, 97, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (174, 21, '', '', 0, 0, 37, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (175, 1, '', '', 0, 0, 23, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (176, 25, '', '', 0, 0, 75, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (177, 29, '', '', 0, 0, 23, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (178, 6, '', '', 0, 0, 53, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (179, 20, '', '', 0, 0, 94, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (180, 27, '', '', 0, 0, 29, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (181, 18, '', '', 0, 0, 7, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (182, 3, '', '', 0, 0, 47, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (183, 20, '', '', 0, 0, 80, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (184, 28, '', '', 0, 0, 84, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (185, 21, '', '', 0, 0, 18, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (186, 29, '', '', 0, 0, 45, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (187, 30, '', '', 0, 0, 73, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (188, 4, '', '', 0, 0, 31, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (189, 4, '', '', 0, 0, 57, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (190, 2, '', '', 0, 0, 54, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (191, 19, '', '', 0, 0, 48, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (192, 24, '', '', 0, 0, 37, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (193, 18, '', '', 0, 0, 7, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (194, 27, '', '', 0, 0, 63, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (195, 2, '', '', 0, 0, 46, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (196, 24, '', '', 0, 0, 44, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (197, 8, '', '', 0, 0, 31, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (198, 27, '', '', 0, 0, 49, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (199, 24, '', '', 0, 0, 83, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (200, 10, '', '', 0, 0, 60, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (201, 30, '', '', 0, 0, 43, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (202, 22, '', '', 0, 0, 78, '', 1, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (203, 21, '', '', 0, 0, 68, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (204, 28, '', '', 0, 0, 54, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (205, 25, '', '', 0, 0, 12, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (206, 21, '', '', 0, 0, 64, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (207, 9, '', '', 0, 0, 73, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (208, 1, '', '', 0, 0, 35, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (209, 13, '', '', 0, 0, 83, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (210, 15, '', '', 0, 0, 27, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (211, 17, '', '', 0, 0, 67, '', 25, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (212, 12, '', '', 0, 0, 11, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (213, 24, '', '', 0, 0, 3, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (214, 19, '', '', 0, 0, 52, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (215, 26, '', '', 0, 0, 25, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (216, 18, '', '', 0, 0, 64, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (217, 15, '', '', 0, 0, 98, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (218, 1, '', '', 0, 0, 29, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (219, 2, '', '', 0, 0, 22, '', 25, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (220, 7, '', '', 0, 0, 39, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (221, 10, '', '', 0, 0, 52, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (222, 19, '', '', 0, 0, 29, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (223, 23, '', '', 0, 0, 50, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (224, 25, '', '', 0, 0, 42, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (225, 30, '', '', 0, 0, 85, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (226, 25, '', '', 0, 0, 6, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (227, 14, '', '', 0, 0, 5, '', 15, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (228, 14, '', '', 0, 0, 91, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (229, 8, '', '', 0, 0, 79, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (230, 23, '', '', 0, 0, 26, '', 25, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (231, 28, '', '', 0, 0, 55, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (232, 3, '', '', 0, 0, 81, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (233, 11, '', '', 0, 0, 62, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (234, 11, '', '', 0, 0, 88, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (235, 26, '', '', 0, 0, 86, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (236, 1, '', '', 0, 0, 81, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (237, 27, '', '', 0, 0, 17, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (238, 30, '', '', 0, 0, 11, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (239, 21, '', '', 0, 0, 67, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (240, 19, '', '', 0, 0, 33, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (241, 10, '', '', 0, 0, 90, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (242, 16, '', '', 0, 0, 60, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (243, 4, '', '', 0, 0, 59, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (244, 19, '', '', 0, 0, 10, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (245, 7, '', '', 0, 0, 83, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (246, 20, '', '', 0, 0, 79, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (247, 9, '', '', 0, 0, 89, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (248, 5, '', '', 0, 0, 67, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (249, 3, '', '', 0, 0, 92, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (250, 12, '', '', 0, 0, 51, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (251, 3, '', '', 0, 0, 8, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (252, 14, '', '', 0, 0, 61, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (253, 12, '', '', 0, 0, 18, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (254, 27, '', '', 0, 0, 51, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (255, 29, '', '', 0, 0, 29, '', 14, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (256, 2, '', '', 0, 0, 92, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (257, 17, '', '', 0, 0, 81, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (258, 14, '', '', 0, 0, 36, '', 15, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (259, 1, '', '', 0, 0, 86, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (260, 15, '', '', 0, 0, 15, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (261, 11, '', '', 0, 0, 32, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (262, 15, '', '', 0, 0, 88, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (263, 29, '', '', 0, 0, 18, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (264, 27, '', '', 0, 0, 42, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (265, 12, '', '', 0, 0, 97, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (266, 10, '', '', 0, 0, 61, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (267, 22, '', '', 0, 0, 8, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (268, 12, '', '', 0, 0, 76, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (269, 6, '', '', 0, 0, 34, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (270, 23, '', '', 0, 0, 52, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (271, 26, '', '', 0, 0, 36, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (272, 16, '', '', 0, 0, 57, '', 5, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (273, 28, '', '', 0, 0, 53, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (274, 13, '', '', 0, 0, 71, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (275, 18, '', '', 0, 0, 12, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (276, 21, '', '', 0, 0, 68, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (277, 18, '', '', 0, 0, 47, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (278, 9, '', '', 0, 0, 49, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (279, 3, '', '', 0, 0, 33, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (280, 25, '', '', 0, 0, 86, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (281, 25, '', '', 0, 0, 26, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (282, 3, '', '', 0, 0, 92, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (283, 23, '', '', 0, 0, 38, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (284, 17, '', '', 0, 0, 14, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (285, 23, '', '', 0, 0, 72, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (286, 9, '', '', 0, 0, 7, '', 4, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (287, 2, '', '', 0, 0, 35, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (288, 12, '', '', 0, 0, 92, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (289, 6, '', '', 0, 0, 28, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (290, 17, '', '', 0, 0, 78, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (291, 1, '', '', 0, 0, 28, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (292, 18, '', '', 0, 0, 6, '', 29, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (293, 10, '', '', 0, 0, 49, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (294, 15, '', '', 0, 0, 69, '', 7, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (295, 6, '', '', 0, 0, 66, '', 26, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (296, 8, '', '', 0, 0, 93, '', 23, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (297, 4, '', '', 0, 0, 64, '', 8, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (298, 29, '', '', 0, 0, 21, '', 15, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (299, 27, '', '', 0, 0, 55, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (300, 30, '', '', 0, 0, 91, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (301, 22, '', '', 0, 0, 29, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (302, 22, '', '', 0, 0, 85, '', 21, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (303, 27, '', '', 0, 0, 25, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (304, 21, '', '', 0, 0, 43, '', 12, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (305, 5, '', '', 0, 0, 17, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (306, 3, '', '', 0, 0, 8, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (307, 13, '', '', 0, 0, 36, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (308, 24, '', '', 0, 0, 24, '', 1, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (309, 1, '', '', 0, 0, 75, '', 1, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (310, 10, '', '', 0, 0, 42, '', 9, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (311, 5, '', '', 0, 0, 83, '', 27, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (312, 24, '', '', 0, 0, 79, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (313, 22, '', '', 0, 0, 41, '', 17, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (314, 28, '', '', 0, 0, 8, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (315, 2, '', '', 0, 0, 18, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (316, 21, '', '', 0, 0, 67, '', 11, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (317, 8, '', '', 0, 0, 23, '', 22, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (318, 25, '', '', 0, 0, 62, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (319, 26, '', '', 0, 0, 74, '', 19, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (320, 24, '', '', 0, 0, 52, '', 16, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (321, 20, '', '', 0, 0, 21, '', 18, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (322, 2, '', '', 0, 0, 7, '', 25, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (323, 11, '', '', 0, 0, 32, '', 24, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (324, 22, '', '', 0, 0, 18, '', 30, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (325, 15, '', '', 0, 0, 49, '', 28, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (326, 20, '', '', 0, 0, 29, '', 10, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (327, 3, '', '', 0, 0, 1, '', 25, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (328, 29, '', '', 0, 0, 89, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (329, 13, '', '', 0, 0, 76, '', 2, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (330, 18, '', '', 0, 0, 91, '', 20, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (331, 14, '', '', 0, 0, 12, '', 3, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (332, 3, '', '', 0, 0, 63, '', 6, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);
INSERT INTO `group_punch` VALUES (333, 26, '', '', 0, 0, 74, '', 13, '', 0, 0, 0, 1, 1527761327, 1527761327, NULL);

SET FOREIGN_KEY_CHECKS = 1;
