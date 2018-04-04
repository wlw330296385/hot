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

 Date: 04/04/2018 10:56:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for monthly_students
-- ----------------------------
DROP TABLE IF EXISTS `monthly_students`;
CREATE TABLE `monthly_students`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `online_students` int(11) NOT NULL COMMENT '再营学生总数',
  `offline_students` int(11) NOT NULL COMMENT '离营学生总数',
  `onlesson_students` int(11) NOT NULL COMMENT '在上课的学生总数',
  `offlesson_students` int(11) NOT NULL COMMENT '结业的学生总数',
  `refund_students` int(11) NOT NULL COMMENT '退费的学生总数',
  `date_str` varbinary(60) NOT NULL COMMENT '201801',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 101 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of monthly_students
-- ----------------------------
INSERT INTO `monthly_students` VALUES (1, 37, '展梦体育', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (2, 36, 'RUN体能训练营', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (3, 35, '顶峰篮球训练营', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (4, 34, 'BALON篮球训练营', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (5, 33, 'B—Ball 篮球训练营', 3, 0, 3, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (6, 32, '燕子Happy篮球训练营', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (7, 31, 'wow篮球兴趣训练营', 7, 0, 1, 6, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (8, 29, '深圳市南山区桃源街道篮球协会', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (9, 19, '17体适能', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (10, 18, '劉嘉興', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (11, 17, 'FIT', 1, 0, 0, 1, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (12, 16, '热风学校', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (13, 15, '钟声训练营', 93, 0, 13, 80, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (14, 14, 'Ball  is  life', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (15, 13, 'AKcross训练营', 44, 0, 10, 34, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (16, 9, '大热篮球俱乐部', 201, 0, 45, 156, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (17, 5, '荣光训练营', 4, 0, 3, 1, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (18, 4, '准行者训练营', 7, 0, 7, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (19, 3, '猴赛雷训练营', 5, 0, 5, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (20, 1, '大热体适能中心', 0, 0, 0, 0, 0, 0x323031383033, 1522305335, 1522305335, NULL);
INSERT INTO `monthly_students` VALUES (21, 37, '展梦体育', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (22, 36, 'RUN体能训练营', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (23, 35, '顶峰篮球训练营', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (24, 34, 'BALON篮球训练营', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (25, 33, 'B—Ball 篮球训练营', 3, 0, 3, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (26, 32, '燕子Happy篮球训练营', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (27, 31, 'wow篮球兴趣训练营', 7, 0, 1, 6, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (28, 29, '深圳市南山区桃源街道篮球协会', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (29, 19, '17体适能', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (30, 18, '劉嘉興', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (31, 17, 'FIT', 1, 0, 0, 1, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (32, 16, '热风学校', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (33, 15, '钟声训练营', 93, 0, 13, 80, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (34, 14, 'Ball  is  life', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (35, 13, 'AKcross训练营', 44, 0, 10, 34, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (36, 9, '大热篮球俱乐部', 201, 0, 45, 156, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (37, 5, '荣光训练营', 4, 0, 3, 1, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (38, 4, '准行者训练营', 7, 0, 7, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (39, 3, '猴赛雷训练营', 5, 0, 5, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (40, 1, '大热体适能中心', 0, 0, 0, 0, 0, 0x323031383034, 1522305469, 1522305469, NULL);
INSERT INTO `monthly_students` VALUES (41, 37, '展梦体育', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (42, 36, 'RUN体能训练营', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (43, 35, '顶峰篮球训练营', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (44, 34, 'BALON篮球训练营', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (45, 33, 'B—Ball 篮球训练营', 3, 0, 3, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (46, 32, '燕子Happy篮球训练营', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (47, 31, 'wow篮球兴趣训练营', 7, 0, 1, 6, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (48, 29, '深圳市南山区桃源街道篮球协会', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (49, 19, '17体适能', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (50, 18, '劉嘉興', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (51, 17, 'FIT', 1, 0, 0, 1, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (52, 16, '热风学校', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (53, 15, '钟声训练营', 93, 0, 10, 83, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (54, 14, 'Ball  is  life', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (55, 13, 'AKcross训练营', 44, 0, 5, 39, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (56, 9, '大热篮球俱乐部', 201, 0, 29, 172, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (57, 5, '荣光训练营', 4, 0, 3, 1, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (58, 4, '准行者训练营', 7, 0, 7, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (59, 3, '猴赛雷训练营', 5, 0, 5, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (60, 1, '大热体适能中心', 0, 0, 0, 0, 0, 0x3230313830343033, 1522725012, 1522725012, NULL);
INSERT INTO `monthly_students` VALUES (61, 37, '展梦体育', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (62, 36, 'RUN体能训练营', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (63, 35, '顶峰篮球训练营', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (64, 34, 'BALON篮球训练营', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (65, 33, 'B—Ball 篮球训练营', 3, 0, 3, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (66, 32, '燕子Happy篮球训练营', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (67, 31, 'wow篮球兴趣训练营', 7, 0, 1, 6, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (68, 29, '深圳市南山区桃源街道篮球协会', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (69, 19, '17体适能', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (70, 18, '劉嘉興', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (71, 17, 'FIT', 1, 0, 0, 1, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (72, 16, '热风学校', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (73, 15, '钟声训练营', 93, 0, 10, 83, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (74, 14, 'Ball  is  life', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (75, 13, 'AKcross训练营', 44, 0, 5, 39, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (76, 9, '大热篮球俱乐部', 201, 0, 29, 172, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (77, 5, '荣光训练营', 4, 0, 3, 1, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (78, 4, '准行者训练营', 7, 0, 7, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (79, 3, '猴赛雷训练营', 5, 0, 5, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (80, 1, '大热体适能中心', 0, 0, 0, 0, 0, 0x323031383033, 1522725103, 1522725103, NULL);
INSERT INTO `monthly_students` VALUES (81, 37, '展梦体育', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (82, 36, 'RUN体能训练营', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (83, 35, '顶峰篮球训练营', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (84, 34, 'BALON篮球训练营', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (85, 33, 'B—Ball 篮球训练营', 3, 0, 3, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (86, 32, '燕子Happy篮球训练营', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (87, 31, 'wow篮球兴趣训练营', 7, 0, 1, 6, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (88, 29, '深圳市南山区桃源街道篮球协会', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (89, 19, '17体适能', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (90, 18, '劉嘉興', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (91, 17, 'FIT', 1, 0, 0, 1, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (92, 16, '热风学校', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (93, 15, '钟声训练营', 93, 0, 10, 83, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (94, 14, 'Ball  is  life', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (95, 13, 'AKcross训练营', 44, 0, 5, 39, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (96, 9, '大热篮球俱乐部', 201, 0, 29, 172, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (97, 5, '荣光训练营', 4, 0, 3, 1, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (98, 4, '准行者训练营', 7, 0, 7, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (99, 3, '猴赛雷训练营', 5, 0, 5, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);
INSERT INTO `monthly_students` VALUES (100, 1, '大热体适能中心', 0, 0, 0, 0, 0, 0x3230313830343034, 1522771506, 1522771506, NULL);

SET FOREIGN_KEY_CHECKS = 1;