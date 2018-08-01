/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : hot

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 01/08/2018 10:50:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for pool
-- ----------------------------
DROP TABLE IF EXISTS `pool`;
CREATE TABLE `pool`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pool` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '奖金池的名称,如:2018年5月23日周期|2018年5月1日月期',
  `season` tinyint(4) NOT NULL COMMENT '1:周季|2:月季|3:年季(22:00结算)',
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rule` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `times` tinyint(4) NOT NULL DEFAULT 1 COMMENT '每天能打卡多少次,默认1天只能打卡1次',
  `members` int(11) NOT NULL COMMENT '打卡人数',
  `first_scale` tinyint(2) UNSIGNED NOT NULL DEFAULT 10 COMMENT '第一名奖金比例',
  `second_scale` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '第二名奖金比例',
  `third_scale` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '第三名奖金比例',
  `bonus` int(11) NOT NULL COMMENT '奖金池金额',
  `start` int(11) NOT NULL COMMENT '开始时间戳',
  `end` int(11) NOT NULL COMMENT '结束时间戳',
  `end_str` int(11) NOT NULL COMMENT '20180505',
  `stake` decimal(2, 0) NOT NULL COMMENT '每次下注金额',
  `is_donate` tinyint(2) NOT NULL DEFAULT -1 COMMENT '是否捐赠',
  `donate_id` int(11) NOT NULL DEFAULT 0 COMMENT '捐赠id',
  `type` tinyint(4) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1:热币奖|2:奖品|3:热币和奖品',
  `the_first_award_id` int(11) NOT NULL DEFAULT 0 COMMENT '第一名奖品id',
  `the_second_award_id` int(11) NOT NULL DEFAULT 0 COMMENT '第2名奖品id',
  `the_first_award` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `the_third_award_id` int(11) NOT NULL DEFAULT 0 COMMENT '第3名奖品id',
  `the_third_award` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `the_second_award` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `the_third_winners` int(11) NOT NULL COMMENT '第三名奖品数量',
  `the_second_winners` int(11) NOT NULL COMMENT '第二名奖品数量',
  `the_first_winners` int(11) NOT NULL COMMENT '第一名奖品数量',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:未开启|-1:已结束|2:进行中',
  `winner_list` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '获奖数组(奖金品)',
  `winner_list_s` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '获奖数组(奖品)',
  `rate` int(11) NOT NULL DEFAULT 0 COMMENT '比率',
  `mod` tinyint(4) NOT NULL DEFAULT 0 COMMENT '余数',
  `c_f_m` int(11) NOT NULL DEFAULT 0,
  `c_s_m` int(11) NOT NULL DEFAULT 0,
  `c_t_m` int(11) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pool
-- ----------------------------
INSERT INTO `pool` VALUES (3, 'F18 OneSport', 0, 8, 'F18 OneSport', '', 1, 7, 8, 2, 0, 7, 1528819200, 1531663200, 20180715, 1, -1, 0, 1, 0, 0, '', 0, '', '', 3, 2, 1, -1, '[[{\"c_id\":3,\"member_id\":6,\"member\":\"legend\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/f5edb7fdb3aa16a70927cc43c82b4784f707f4b7\",\"pool\":\"F18 OneSport\",\"pool_id\":3,\"group_id\":8,\"group\":\"F18 OneSport\",\"award_id\":\"\",\"ranking\":1,\"bonus\":7,\"punchs\":3}],[{\"c_id\":4,\"member_id\":1,\"member\":\"HoChen\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/47eef542eb24b26b7923772d52aa1b4d9ac412eb\",\"pool\":\"F18 OneSport\",\"pool_id\":3,\"group_id\":8,\"group\":\" F18 OneSport \",\"award_id\":\"\",\"ranking\":2,\"bonus\":7,\"punchs\":4}],[]]', NULL, 0, 7, 1, 1, 0, 1528877681, 1528877681, NULL);
INSERT INTO `pool` VALUES (4, '时代骄子运动一族', 0, 9, '时代骄子运动一族', '五知道', 1, 2, 10, 0, 0, 2, 1529856000, 1531663200, 20180715, 1, -1, 0, 1, 0, 0, '', 0, '', '', 1, 1, 1, -1, '[[{\"c_id\":2,\"member_id\":1,\"member\":\"HoChen\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/47eef542eb24b26b7923772d52aa1b4d9ac412eb\",\"pool\":\"\\u65f6\\u4ee3\\u9a84\\u5b50\\u8fd0\\u52a8\\u4e00\\u65cf\",\"pool_id\":4,\"group_id\":9,\"group\":\"\\u65f6\\u4ee3\\u9a84\\u5b50\\u8fd0\\u52a8\\u4e00\\u65cf\",\"award_id\":\"\",\"ranking\":1,\"bonus\":2,\"punchs\":2}],[],[]]', NULL, 0, 2, 1, 0, 0, 1529901237, 1529901237, NULL);
INSERT INTO `pool` VALUES (5, '燕子运动圈', 0, 10, '燕子运动圈', '每次自我监督，积极运动，上传真实的运动照片哦????', 2, 4, 10, 0, 0, 0, 1530028800, 1531576800, 20180714, 0, -1, 0, 1, 0, 0, '', 0, '', '', 1, 3, 2, -1, '[[{\"c_id\":1,\"member_id\":8,\"member\":\"woo123\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/560cafc1e4fc13031bdd73b48c7821bc22564e76\",\"pool\":\"\\u71d5\\u5b50\\u8fd0\\u52a8\\u5708\",\"pool_id\":5,\"group_id\":10,\"group\":\"\\u71d5\\u5b50\\u8fd0\\u52a8\\u5708\",\"award_id\":\"\",\"ranking\":1,\"bonus\":0,\"punchs\":1},{\"c_id\":3,\"member_id\":9,\"member\":\"GaoYan\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/37888177e4e87437ef5bc4c1be431fe1a09648d3\",\"pool\":\"\\u71d5\\u5b50\\u8fd0\\u52a8\\u5708\",\"pool_id\":5,\"group_id\":10,\"group\":\"\\u71d5\\u5b50\\u8fd0\\u52a8\\u5708\",\"award_id\":\"\",\"ranking\":1,\"bonus\":0,\"punchs\":3}],[],[]]', NULL, 0, 0, 1, 1, 0, 1530072462, 1530072462, NULL);
INSERT INTO `pool` VALUES (6, '钱海行动', 0, 11, '钱海行动', '', 2, 10, 5, 3, 2, 10, 1530028800, 1531490400, 20180713, 1, -1, 0, 1, 0, 0, '', 0, '', '', 3, 2, 1, -1, '[[{\"c_id\":4,\"member_id\":21,\"member\":\"Bingo\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/98e0b71065fe2c1039734ddb24e0be30887b1be4\",\"pool\":\"\\u94b1\\u6d77\\u884c\\u52a8\",\"pool_id\":6,\"group_id\":11,\"group\":\"\\u94b1\\u6d77\\u884c\\u52a8\",\"award_id\":\"\",\"ranking\":1,\"bonus\":10,\"punchs\":4}],[{\"c_id\":3,\"member_id\":9,\"member\":\"GaoYan\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/37888177e4e87437ef5bc4c1be431fe1a09648d3\",\"pool\":\"\\u94b1\\u6d77\\u884c\\u52a8\",\"pool_id\":6,\"group_id\":11,\"group\":\"\\u94b1\\u6d77\\u884c\\u52a8\",\"award_id\":\"\",\"ranking\":2,\"bonus\":10,\"punchs\":3},{\"c_id\":2,\"member_id\":8,\"member\":\"woo123\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/560cafc1e4fc13031bdd73b48c7821bc22564e76\",\"pool\":\"\\u94b1\\u6d77\\u884c\\u52a8\",\"pool_id\":6,\"group_id\":11,\"group\":\"\\u94b1\\u6d77\\u884c\\u52a8\",\"award_id\":\"\",\"ranking\":2,\"bonus\":10,\"punchs\":2}],[{\"c_id\":1,\"member_id\":7,\"member\":\"wayen_z\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/c65ece035fcfc2de5e3c38f7bb70d69834f28f25\",\"pool\":\"\\u94b1\\u6d77\\u884c\\u52a8\",\"pool_id\":6,\"group_id\":11,\"group\":\"\\u94b1\\u6d77\\u884c\\u52a8\",\"award_id\":\"\",\"ranking\":3,\"bonus\":10,\"punchs\":1}]]', NULL, 1, 0, 1, 1, 1, 1530072663, 1530072663, NULL);
INSERT INTO `pool` VALUES (7, 'woo减肥群', 0, 12, 'woo减肥群', '大家每天都要打卡', 12, 5, 7, 2, 1, 5, 1530028800, 1531317600, 20180711, 1, -1, 0, 1, 0, 0, '', 0, '', '', 1, 1, 1, -1, '[[{\"c_id\":1,\"member_id\":9,\"member\":\"GaoYan\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/37888177e4e87437ef5bc4c1be431fe1a09648d3\",\"pool\":\"woo\\u51cf\\u80a5\\u7fa4\",\"pool_id\":7,\"group_id\":12,\"group\":\"woo\\u8fd0\\u52a8\\u7fa4\",\"award_id\":\"\",\"ranking\":1,\"bonus\":5,\"punchs\":1}],[{\"c_id\":2,\"member_id\":8,\"member\":\"woo123\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/560cafc1e4fc13031bdd73b48c7821bc22564e76\",\"pool\":\"woo\\u51cf\\u80a5\\u7fa4\",\"pool_id\":7,\"group_id\":12,\"group\":\"woo\\u8fd0\\u52a8\\u7fa4\",\"award_id\":\"\",\"ranking\":2,\"bonus\":5,\"punchs\":2}],[{\"c_id\":2,\"member_id\":8,\"member\":\"woo123\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/560cafc1e4fc13031bdd73b48c7821bc22564e76\",\"pool\":\"woo\\u51cf\\u80a5\\u7fa4\",\"pool_id\":7,\"group_id\":12,\"group\":\"woo\\u8fd0\\u52a8\\u7fa4\",\"award_id\":\"\",\"ranking\":3,\"bonus\":5,\"punchs\":2}]]', NULL, 0, 5, 2, 1, 0, 1530073306, 1530073306, NULL);
INSERT INTO `pool` VALUES (8, '荣光社', 0, 7, '荣光社', '', 2, 3, 10, 0, 0, 3, 1530028800, 1531404000, 20180712, 1, -1, 0, 1, 0, 0, '', 0, '', '', 3, 1, 2, -1, '[[{\"c_id\":3,\"member_id\":7,\"member\":\"wayen_z\",\"avatar\":\"\\/uploads\\/images\\/avatar\\/c65ece035fcfc2de5e3c38f7bb70d69834f28f25\",\"pool\":\"\\u8363\\u5149\\u793e\",\"pool_id\":8,\"group_id\":7,\"group\":\"\\u8363\\u5149\\u793e\",\"award_id\":\"\",\"ranking\":1,\"bonus\":3,\"punchs\":3}],[],[]]', NULL, 0, 3, 1, 0, 0, 1530105862, 1530105862, NULL);
INSERT INTO `pool` VALUES (9, '打虎英雄群', 0, 13, '打虎英雄群', '', 2, 0, 6, 3, 1, 0, 1531238400, 1532966400, 20180731, 1, -1, 0, 1, 0, 0, '', 0, '', '', 2, 3, 1, -1, NULL, NULL, 0, 0, 0, 0, 0, 1531296659, 1533022277, NULL);

SET FOREIGN_KEY_CHECKS = 1;
