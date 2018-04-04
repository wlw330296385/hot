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

 Date: 04/04/2018 10:56:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for daily_member_finance
-- ----------------------------
DROP TABLE IF EXISTS `daily_member_finance`;
CREATE TABLE `daily_member_finance`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `member` int(60) NOT NULL,
  `e_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '结束余额',
  `s_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '开始余额',
  `date_str` int(11) NOT NULL COMMENT '20180204',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 181 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of daily_member_finance
-- ----------------------------
INSERT INTO `daily_member_finance` VALUES (1, 431, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (2, 318, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (3, 316, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (4, 310, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (5, 9, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (6, 184, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (7, 16, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (8, 27, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (9, 36, 0, 3480.00, 3480.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (10, 78, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (11, 24, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (12, 17, 0, 0.00, 0.00, 20180327, 1522080006, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (13, 18, 0, 0.00, 0.00, 20180327, 1522080007, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (14, 19, 0, 57320.00, 57320.00, 20180327, 1522080007, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (15, 7, 0, 0.00, 0.00, 20180327, 1522080007, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (16, 6, 0, 0.00, 0.00, 20180327, 1522080007, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (17, 2, 0, 0.00, 0.00, 20180327, 1522080007, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (18, 1, 0, 0.00, 0.00, 20180327, 1522080007, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (19, 5, 0, 0.00, 0.00, 20180327, 1522080007, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (20, 4, 0, 0.00, 0.00, 20180327, 1522080007, 1522166346, 0);
INSERT INTO `daily_member_finance` VALUES (21, 431, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (22, 318, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (23, 316, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (24, 310, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (25, 9, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (26, 184, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (27, 16, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (28, 27, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (29, 36, 0, 3480.00, 3480.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (30, 78, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (31, 24, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (32, 17, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (33, 18, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (34, 19, 0, 57320.00, 57320.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (35, 7, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (36, 6, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (37, 2, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (38, 1, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (39, 5, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (40, 4, 0, 0.00, 0.00, 20180328, 1522166407, 1522252747, 0);
INSERT INTO `daily_member_finance` VALUES (41, 431, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (42, 318, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (43, 316, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (44, 310, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (45, 9, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (46, 184, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (47, 16, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (48, 27, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (49, 36, 0, 3480.00, 3480.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (50, 78, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (51, 24, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (52, 17, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (53, 18, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (54, 19, 0, 57320.00, 57320.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (55, 7, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (56, 6, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (57, 2, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (58, 1, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (59, 5, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (60, 4, 0, 0.00, 0.00, 20180329, 1522252807, 1522339147, 0);
INSERT INTO `daily_member_finance` VALUES (61, 431, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (62, 318, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (63, 316, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (64, 310, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (65, 9, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (66, 184, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (67, 16, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (68, 27, 0, 1040.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (69, 36, 0, 5620.00, 3480.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (70, 78, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (71, 24, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (72, 17, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (73, 18, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (74, 19, 0, 28660.00, 57320.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (75, 7, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (76, 6, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (77, 2, 0, 0.00, 0.00, 20180330, 1522339206, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (78, 1, 0, 0.00, 0.00, 20180330, 1522339207, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (79, 5, 0, 0.00, 0.00, 20180330, 1522339207, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (80, 4, 0, 0.00, 0.00, 20180330, 1522339207, 1522425547, 0);
INSERT INTO `daily_member_finance` VALUES (81, 431, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (82, 318, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (83, 316, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (84, 310, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (85, 9, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (86, 184, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (87, 16, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (88, 27, 0, 1040.00, 1040.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (89, 36, 0, 5620.00, 5620.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (90, 78, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (91, 24, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (92, 17, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (93, 18, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (94, 19, 0, 28660.00, 28660.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (95, 7, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (96, 6, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (97, 2, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (98, 1, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (99, 5, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (100, 4, 0, 0.00, 0.00, 20180331, 1522425607, 1522511946, 0);
INSERT INTO `daily_member_finance` VALUES (101, 431, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (102, 318, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (103, 316, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (104, 310, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (105, 9, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (106, 184, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (107, 16, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (108, 27, 0, 1040.00, 1040.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (109, 36, 0, 5620.00, 5620.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (110, 78, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (111, 24, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (112, 17, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (113, 18, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (114, 19, 0, 28660.00, 28660.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (115, 7, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (116, 6, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (117, 2, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (118, 1, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (119, 5, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (120, 4, 0, 0.00, 0.00, 20180401, 1522512007, 1522598347, 0);
INSERT INTO `daily_member_finance` VALUES (121, 431, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (122, 318, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (123, 316, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (124, 310, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (125, 9, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (126, 184, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (127, 16, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (128, 27, 0, 1040.00, 1040.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (129, 36, 0, 6560.00, 5620.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (130, 78, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (131, 24, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (132, 17, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (133, 18, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (134, 19, 0, 33240.00, 28660.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (135, 7, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (136, 6, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (137, 2, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (138, 1, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (139, 5, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (140, 4, 0, 0.00, 0.00, 20180402, 1522598407, 1522684747, 0);
INSERT INTO `daily_member_finance` VALUES (141, 431, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (142, 318, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (143, 316, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (144, 310, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (145, 9, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (146, 184, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (147, 16, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (148, 27, 0, 1040.00, 1040.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (149, 36, 0, 6560.00, 6560.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (150, 78, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (151, 24, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (152, 17, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (153, 18, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (154, 19, 0, 33240.00, 33240.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (155, 7, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (156, 6, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (157, 2, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (158, 1, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (159, 5, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (160, 4, 0, 0.00, 0.00, 20180403, 1522684806, 1522771147, 0);
INSERT INTO `daily_member_finance` VALUES (161, 431, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (162, 318, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (163, 316, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (164, 310, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (165, 9, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (166, 184, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (167, 16, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (168, 27, 0, 0.00, 1040.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (169, 36, 0, 0.00, 6560.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (170, 78, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (171, 24, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (172, 17, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (173, 18, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (174, 19, 0, 0.00, 33240.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (175, 7, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (176, 6, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (177, 2, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (178, 1, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (179, 5, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);
INSERT INTO `daily_member_finance` VALUES (180, 4, 0, 0.00, 0.00, 20180404, 1522771212, 0, 0);

SET FOREIGN_KEY_CHECKS = 1;