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

 Date: 04/04/2018 14:10:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for member_finance
-- ----------------------------
DROP TABLE IF EXISTS `member_finance`;
CREATE TABLE `member_finance`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `money` decimal(8, 2) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:工资收入(包括人头提成)||2:提现支出',
  `s_balance` decimal(11, 2) NOT NULL COMMENT '当前余额',
  `e_balance` decimal(11, 2) NOT NULL COMMENT '产生数据后余额',
  `f_id` int(11) NOT NULL DEFAULT 0 COMMENT '外键',
  `date_str` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `datetime` int(11) NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 94 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户收支总表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of member_finance
-- ----------------------------
INSERT INTO `member_finance` VALUES (1, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 474, '', 0, '', '课时主教练总薪资收入', 1521082433, 1521082433, NULL);
INSERT INTO `member_finance` VALUES (2, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 474, '', 0, '', '课时主教练总薪资收入', 1521082440, 1521082440, NULL);
INSERT INTO `member_finance` VALUES (3, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 474, '', 0, '', '课时主教练总薪资收入', 1521082498, 1521082498, NULL);
INSERT INTO `member_finance` VALUES (4, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 474, '', 0, '', '课时主教练总薪资收入', 1521082594, 1521082594, NULL);
INSERT INTO `member_finance` VALUES (5, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 474, '', 0, '', '课时主教练总薪资收入', 1521082623, 1521082623, NULL);
INSERT INTO `member_finance` VALUES (6, 'Bruce.Dong', 17, 75.00, 1, 11456.00, 11531.00, 480, '', 0, '', '课时主教练总薪资收入', 1521082624, 1521082624, NULL);
INSERT INTO `member_finance` VALUES (7, 'Bruce.Dong', 17, 75.00, 1, 11531.00, 11606.00, 485, '', 0, '', '课时主教练总薪资收入', 1521082624, 1521082624, NULL);
INSERT INTO `member_finance` VALUES (8, 'Bruce.Dong', 17, 225.00, 1, 11606.00, 11831.00, 491, '', 0, '', '课时主教练总薪资收入', 1521082624, 1521082624, NULL);
INSERT INTO `member_finance` VALUES (9, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 496, '', 0, '', '课时主教练总薪资收入', 1521082624, 1521082624, NULL);
INSERT INTO `member_finance` VALUES (10, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 497, '', 0, '', '课时主教练总薪资收入', 1521082625, 1521082625, NULL);
INSERT INTO `member_finance` VALUES (11, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 498, '', 0, '', '课时主教练总薪资收入', 1521082625, 1521082625, NULL);
INSERT INTO `member_finance` VALUES (12, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 499, '', 0, '', '课时主教练总薪资收入', 1521082625, 1521082625, NULL);
INSERT INTO `member_finance` VALUES (13, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 500, '', 0, '', '课时主教练总薪资收入', 1521082625, 1521082625, NULL);
INSERT INTO `member_finance` VALUES (14, 'AK', 18, 0.00, 1, 13766.00, 13766.00, 501, '', 0, '', '课时主教练总薪资收入', 1521082625, 1521082625, NULL);
INSERT INTO `member_finance` VALUES (15, 'AK', 18, 275.00, 1, 13766.00, 14041.00, 503, '', 0, '', '课时主教练总薪资收入', 1521082625, 1521082625, NULL);
INSERT INTO `member_finance` VALUES (16, 'AK', 18, 225.00, 1, 14041.00, 14266.00, 504, '', 0, '', '课时主教练总薪资收入', 1521082625, 1521082625, NULL);
INSERT INTO `member_finance` VALUES (17, 'Bruce.Dong', 17, 375.00, 1, 11831.00, 12206.00, 505, '', 0, '', '课时主教练总薪资收入', 1521082625, 1521082625, NULL);
INSERT INTO `member_finance` VALUES (18, 'coachj', 27, 125.00, 1, 12075.00, 12200.00, 507, '', 0, '', '课时主教练总薪资收入', 1521133804, 1521133804, NULL);
INSERT INTO `member_finance` VALUES (19, 'coachj', 27, 125.00, 1, 12200.00, 12325.00, 508, '', 0, '', '课时主教练总薪资收入', 1521133805, 1521133805, NULL);
INSERT INTO `member_finance` VALUES (20, '钟声', 19, 250.00, 1, 9975.00, 10225.00, 463, '', 0, '', '课时主教练总薪资收入', 1521306605, 1521306605, NULL);
INSERT INTO `member_finance` VALUES (21, 'AK', 18, 250.00, 1, 14266.00, 14516.00, 478, '', 0, '', '课时主教练总薪资收入', 1521306605, 1521306605, NULL);
INSERT INTO `member_finance` VALUES (22, '涵叔', 184, 300.00, 1, 300.00, 600.00, 510, '', 0, '', '课时主教练总薪资收入', 1521306606, 1521306606, NULL);
INSERT INTO `member_finance` VALUES (23, 'AK', 18, 225.00, 1, 14516.00, 14741.00, 511, '', 0, '', '课时主教练总薪资收入', 1521393003, 1521393003, NULL);
INSERT INTO `member_finance` VALUES (24, 'AK', 18, 200.00, 1, 14741.00, 14941.00, 512, '', 0, '', '课时主教练总薪资收入', 1521393004, 1521393004, NULL);
INSERT INTO `member_finance` VALUES (25, 'Bruce.Dong', 17, 100.00, 1, 12206.00, 12306.00, 506, '', 0, '', '课时主教练总薪资收入', 1521565801, 1521565801, NULL);
INSERT INTO `member_finance` VALUES (26, 'Bruce.Dong', 17, 75.00, 1, 12306.00, 12381.00, 509, '', 0, '', '课时主教练总薪资收入', 1521565802, 1521565802, NULL);
INSERT INTO `member_finance` VALUES (27, 'Bruce.Dong', 17, 275.00, 1, 12381.00, 12656.00, 513, '', 0, '', '课时主教练总薪资收入', 1521565802, 1521565802, NULL);
INSERT INTO `member_finance` VALUES (28, 'Bruce.Dong', 17, 200.00, 1, 12656.00, 12856.00, 514, '', 0, '', '课时主教练总薪资收入', 1521565802, 1521565802, NULL);
INSERT INTO `member_finance` VALUES (29, 'AK', 18, 0.00, 1, 14941.00, 14941.00, 515, '', 0, '', '课时主教练总薪资收入', 1521565802, 1521565802, NULL);
INSERT INTO `member_finance` VALUES (30, 'AK', 18, 0.00, 1, 14941.00, 14941.00, 516, '', 0, '', '课时主教练总薪资收入', 1521565802, 1521565802, NULL);
INSERT INTO `member_finance` VALUES (31, 'AK', 18, 0.00, 1, 14941.00, 14941.00, 517, '', 0, '', '课时主教练总薪资收入', 1521565802, 1521565802, NULL);
INSERT INTO `member_finance` VALUES (32, 'AK', 18, 0.00, 1, 14941.00, 14941.00, 518, '', 0, '', '课时主教练总薪资收入', 1521565803, 1521565803, NULL);
INSERT INTO `member_finance` VALUES (33, 'AK', 18, 0.00, 1, 14941.00, 14941.00, 519, '', 0, '', '课时主教练总薪资收入', 1521565803, 1521565803, NULL);
INSERT INTO `member_finance` VALUES (34, 'AK', 18, 0.00, 1, 14941.00, 14941.00, 520, '', 0, '', '课时主教练总薪资收入', 1521565803, 1521565803, NULL);
INSERT INTO `member_finance` VALUES (35, 'AK', 18, 225.00, 1, 14941.00, 15166.00, 521, '', 0, '', '课时主教练总薪资收入', 1521565803, 1521565803, NULL);
INSERT INTO `member_finance` VALUES (36, 'AK', 18, 225.00, 1, 15166.00, 15391.00, 522, '', 0, '', '课时主教练总薪资收入', 1521565803, 1521565803, NULL);
INSERT INTO `member_finance` VALUES (37, 'Bruce.Dong', 17, 250.00, 1, 12856.00, 13106.00, 524, '', 0, '', '课时主教练总薪资收入', 1521565803, 1521565803, NULL);
INSERT INTO `member_finance` VALUES (38, 'Bruce.Dong', 17, 250.00, 1, 13106.00, 13356.00, 525, '', 0, '', '课时主教练总薪资收入', 1521565803, 1521565803, NULL);
INSERT INTO `member_finance` VALUES (39, 'Bruce.Dong', 17, 175.00, 1, 13356.00, 13531.00, 526, '', 0, '', '课时主教练总薪资收入', 1521565803, 1521565803, NULL);
INSERT INTO `member_finance` VALUES (40, 'Bruce.Dong', 17, 175.00, 1, 13531.00, 13706.00, 527, '', 0, '', '课时主教练总薪资收入', 1521652203, 1521652203, NULL);
INSERT INTO `member_finance` VALUES (41, '钟声', 19, 320.00, 1, 10225.00, 10545.00, 528, '', 0, '', '课时主教练总薪资收入', 1521738603, 1521738603, NULL);
INSERT INTO `member_finance` VALUES (42, '钟声', 19, 200.00, 1, 10545.00, 10745.00, 529, '', 0, '', '课时主教练总薪资收入', 1521738604, 1521738604, NULL);
INSERT INTO `member_finance` VALUES (43, 'Bruce.Dong', 17, 177.00, 1, 13706.00, 13883.00, 536, '', 0, '', '课时主教练总薪资收入', 1521911403, 1521911403, NULL);
INSERT INTO `member_finance` VALUES (44, '钟声', 19, 200.00, 1, 10745.00, 10945.00, 537, '', 0, '', '课时主教练总薪资收入', 1521911404, 1521911404, NULL);
INSERT INTO `member_finance` VALUES (45, 'Bruce.Dong', 17, 350.00, 1, 13883.00, 14233.00, 542, '', 0, '', '课时主教练总薪资收入', 1521997805, 1521997805, NULL);
INSERT INTO `member_finance` VALUES (46, '钟声', 19, 200.00, 1, 10945.00, 11145.00, 543, '', 0, '', '课时主教练总薪资收入', 1521997806, 1521997806, NULL);
INSERT INTO `member_finance` VALUES (47, '钟声', 19, 200.00, 1, 11145.00, 11345.00, 544, '', 0, '', '课时主教练总薪资收入', 1521997806, 1521997806, NULL);
INSERT INTO `member_finance` VALUES (48, 'Bruce.Dong', 17, 177.00, 1, 14233.00, 14410.00, 546, '', 0, '', '课时主教练总薪资收入', 1521997806, 1521997806, NULL);
INSERT INTO `member_finance` VALUES (49, 'Bruce.Dong', 17, 250.00, 1, 14410.00, 14660.00, 547, '', 0, '', '课时主教练总薪资收入', 1522084202, 1522084202, NULL);
INSERT INTO `member_finance` VALUES (50, 'Bruce.Dong', 17, 200.00, 1, 14660.00, 14860.00, 548, '', 0, '', '课时主教练总薪资收入', 1522084202, 1522084202, NULL);
INSERT INTO `member_finance` VALUES (51, 'Bruce.Dong', 17, 375.00, 1, 14860.00, 15235.00, 549, '', 0, '', '课时主教练总薪资收入', 1522084203, 1522084203, NULL);
INSERT INTO `member_finance` VALUES (52, 'AK', 18, 0.00, 1, 15391.00, 15391.00, 554, '', 0, '', '课时主教练总薪资收入', 1522170603, 1522170603, NULL);
INSERT INTO `member_finance` VALUES (53, 'AK', 18, 0.00, 1, 15391.00, 15391.00, 555, '', 0, '', '课时主教练总薪资收入', 1522170604, 1522170604, NULL);
INSERT INTO `member_finance` VALUES (54, 'AK', 18, 0.00, 1, 15391.00, 15391.00, 556, '', 0, '', '课时主教练总薪资收入', 1522170604, 1522170604, NULL);
INSERT INTO `member_finance` VALUES (55, 'AK', 18, 0.00, 1, 15391.00, 15391.00, 557, '', 0, '', '课时主教练总薪资收入', 1522170604, 1522170604, NULL);
INSERT INTO `member_finance` VALUES (56, 'AK', 18, 0.00, 1, 15391.00, 15391.00, 559, '', 0, '', '课时主教练总薪资收入', 1522170604, 1522170604, NULL);
INSERT INTO `member_finance` VALUES (57, 'AK', 18, 0.00, 1, 15391.00, 15391.00, 560, '', 0, '', '课时主教练总薪资收入', 1522170604, 1522170604, NULL);
INSERT INTO `member_finance` VALUES (58, 'AK', 18, 200.00, 1, 15391.00, 15591.00, 562, '', 0, '', '课时主教练总薪资收入', 1522170604, 1522170604, NULL);
INSERT INTO `member_finance` VALUES (59, 'AK', 18, 250.00, 1, 15591.00, 15841.00, 564, '', 0, '', '课时主教练总薪资收入', 1522170604, 1522170604, NULL);
INSERT INTO `member_finance` VALUES (60, 'Bruce.Dong', 17, 175.00, 1, 15235.00, 15410.00, 565, '', 0, '', '课时主教练总薪资收入', 1522170605, 1522170605, NULL);
INSERT INTO `member_finance` VALUES (61, 'coachj', 27, 300.00, 1, 12325.00, 12625.00, 552, '', 0, '', '课时主教练总薪资收入', 1522257004, 1522257004, NULL);
INSERT INTO `member_finance` VALUES (62, 'AK', 18, 150.00, 1, 15841.00, 15991.00, 563, '', 0, '', '课时主教练总薪资收入', 1522257006, 1522257006, NULL);
INSERT INTO `member_finance` VALUES (63, 'coachj', 27, 250.00, 1, 12625.00, 12875.00, 566, '', 0, '', '课时主教练总薪资收入', 1522257006, 1522257006, NULL);
INSERT INTO `member_finance` VALUES (64, 'coachj', 27, 175.00, 1, 12875.00, 13050.00, 567, '', 0, '', '课时主教练总薪资收入', 1522257006, 1522257006, NULL);
INSERT INTO `member_finance` VALUES (65, 'coachj', 27, 275.00, 1, 13050.00, 13325.00, 568, '', 0, '', '课时主教练总薪资收入', 1522257006, 1522257006, NULL);
INSERT INTO `member_finance` VALUES (66, 'coachj', 27, 250.00, 1, 13325.00, 13575.00, 569, '', 0, '', '课时主教练总薪资收入', 1522257007, 1522257007, NULL);
INSERT INTO `member_finance` VALUES (67, 'coachj', 27, 350.00, 1, 13575.00, 13925.00, 574, '', 0, '', '课时主教练总薪资收入', 1522257007, 1522257007, NULL);
INSERT INTO `member_finance` VALUES (68, 'coachj', 27, 350.00, 1, 13925.00, 14275.00, 575, '', 0, '', '课时主教练总薪资收入', 1522257007, 1522257007, NULL);
INSERT INTO `member_finance` VALUES (69, 'coachj', 27, 300.00, 1, 14275.00, 14575.00, 576, '', 0, '', '课时主教练总薪资收入', 1522257007, 1522257007, NULL);
INSERT INTO `member_finance` VALUES (70, 'coachj', 27, 250.00, 1, 14575.00, 14825.00, 577, '', 0, '', '课时主教练总薪资收入', 1522257007, 1522257007, NULL);
INSERT INTO `member_finance` VALUES (71, 'coachj', 27, 275.00, 1, 14825.00, 15100.00, 578, '', 0, '', '课时主教练总薪资收入', 1522257008, 1522257008, NULL);
INSERT INTO `member_finance` VALUES (72, '钟声', 19, 920.00, 1, 11345.00, 12265.00, 579, '', 0, '', '课时主教练总薪资收入', 1522257008, 1522257008, NULL);
INSERT INTO `member_finance` VALUES (73, '钟声', 19, 400.00, 1, 12265.00, 12665.00, 581, '', 0, '', '课时主教练总薪资收入', 1522257008, 1522257008, NULL);
INSERT INTO `member_finance` VALUES (74, 'coachj', 27, 250.00, 1, 15100.00, 15350.00, 550, '', 0, '', '课时主教练总薪资收入', 1522343404, 1522343404, NULL);
INSERT INTO `member_finance` VALUES (75, 'coachj', 27, 350.00, 1, 15350.00, 15700.00, 553, '', 0, '', '课时主教练总薪资收入', 1522343405, 1522343405, NULL);
INSERT INTO `member_finance` VALUES (76, 'coachj', 27, 450.00, 1, 15700.00, 16150.00, 572, '', 0, '', '课时主教练总薪资收入', 1522343405, 1522343405, NULL);
INSERT INTO `member_finance` VALUES (77, 'coachj', 27, 475.00, 1, 16150.00, 16625.00, 573, '', 0, '', '课时主教练总薪资收入', 1522343405, 1522343405, NULL);
INSERT INTO `member_finance` VALUES (78, 'AK', 18, 0.00, 1, 15991.00, 15991.00, 561, '', 0, '', '课时主教练总薪资收入', 1522429803, 1522429803, NULL);
INSERT INTO `member_finance` VALUES (79, 'Hot-basketball2', 2, 0.00, 1, 48780.55, 48780.55, 583, '', 0, '', '课时主教练总薪资收入', 1522429805, 1522429805, NULL);
INSERT INTO `member_finance` VALUES (80, 'AK', 18, 0.00, 1, 15991.00, 15991.00, 582, '', 0, '', '课时主教练总薪资收入', 1522602603, 1522602603, NULL);
INSERT INTO `member_finance` VALUES (81, 'AK', 18, 0.00, 1, 15991.00, 15991.00, 589, '', 0, '', '课时主教练总薪资收入', 1522602604, 1522602604, NULL);
INSERT INTO `member_finance` VALUES (82, 'AK', 18, 225.00, 1, 15991.00, 16216.00, 590, '', 0, '', '课时主教练总薪资收入', 1522602605, 1522602605, NULL);
INSERT INTO `member_finance` VALUES (83, 'AK', 18, 300.00, 1, 16216.00, 16516.00, 591, '', 0, '', '课时主教练总薪资收入', 1522602605, 1522602605, NULL);
INSERT INTO `member_finance` VALUES (84, 'AK', 18, 0.00, 1, 16516.00, 16516.00, 592, '', 0, '', '课时主教练总薪资收入', 1522602605, 1522602605, NULL);
INSERT INTO `member_finance` VALUES (85, '钟声', 19, 200.00, 1, 12665.00, 12865.00, 593, '', 0, '', '课时主教练总薪资收入', 1522602605, 1522602605, NULL);
INSERT INTO `member_finance` VALUES (86, '钟声', 19, 280.00, 1, 12865.00, 13145.00, 594, '', 0, '', '课时主教练总薪资收入', 1522602605, 1522602605, NULL);
INSERT INTO `member_finance` VALUES (87, 'Bruce.Dong', 17, 275.00, 1, 15410.00, 15685.00, 598, '', 0, '', '课时主教练总薪资收入', 1522689004, 1522689004, NULL);
INSERT INTO `member_finance` VALUES (88, 'Bruce.Dong', 17, 100.00, 1, 15685.00, 15785.00, 523, '', 0, '', '课时主教练总薪资收入', 1522775403, 1522775403, NULL);
INSERT INTO `member_finance` VALUES (89, '涵叔', 184, 300.00, 1, 600.00, 900.00, 585, '', 0, '', '课时主教练总薪资收入', 1522775404, 1522775404, NULL);
INSERT INTO `member_finance` VALUES (90, 'andy.lin', 16, 300.00, 1, 630.00, 930.00, 586, '', 0, '', '课时主教练总薪资收入', 1522775405, 1522775405, NULL);
INSERT INTO `member_finance` VALUES (91, 'andy.lin', 16, 300.00, 1, 930.00, 1230.00, 587, '', 0, '', '课时主教练总薪资收入', 1522775405, 1522775405, NULL);
INSERT INTO `member_finance` VALUES (92, 'andy.lin', 16, 300.00, 1, 1230.00, 1530.00, 588, '', 0, '', '课时主教练总薪资收入', 1522775405, 1522775405, NULL);
INSERT INTO `member_finance` VALUES (93, 'Bruce.Dong', 17, 177.00, 1, 15785.00, 15962.00, 606, '', 0, '', '课时主教练总薪资收入', 1522775405, 1522775405, NULL);

SET FOREIGN_KEY_CHECKS = 1;
