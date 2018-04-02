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

 Date: 30/03/2018 17:41:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for monthly_court_students
-- ----------------------------
DROP TABLE IF EXISTS `monthly_court_students`;
CREATE TABLE `monthly_court_students`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `court` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `court_id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `students` int(11) NOT NULL COMMENT '学生总数',
  `date_str` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '201801',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '每月学员训练点分布' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of monthly_court_students
-- ----------------------------
INSERT INTO `monthly_court_students` VALUES (1, '南山天台兰球场', 12, 15, '钟声训练营', 12, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (2, '松坪小学', 15, 15, '钟声训练营', 28, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (3, '福田体育公园兰球场', 13, 15, '钟声训练营', 10, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (4, '前海小学', 14, 15, '钟声训练营', 53, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (5, '塘朗球场', 20, 13, 'AKcross训练营', 34, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (6, '南外文华球场', 19, 13, 'AKcross训练营', 16, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (7, '丽山文体中心篮球场', 16, 9, '大热篮球俱乐部', 13, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (8, '待定', -1, 9, '大热篮球俱乐部', 4, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (9, '大热前海训练中心', 1, 9, '大热篮球俱乐部', 20, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (10, '龙岗公安分局训练场', 11, 9, '大热篮球俱乐部', 23, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (11, '前海北头运动场', 3, 9, '大热篮球俱乐部', 129, '201803', 1522320871, 1522320871, NULL);
INSERT INTO `monthly_court_students` VALUES (12, '荣光训练场', 10, 5, '荣光训练营', 1, '201803', 1522320871, 1522320871, NULL);

SET FOREIGN_KEY_CHECKS = 1;
