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

 Date: 10/05/2018 16:33:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for event_member
-- ----------------------------
DROP TABLE IF EXISTS `event_member`;
CREATE TABLE `event_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '用户头像',
  `student_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `combo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '套餐',
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系电话',
  `linkman` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系人',
  `total` int(10) NOT NULL DEFAULT 0 COMMENT '报名人数',
  `is_pay` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:已缴费|2:未缴费',
  `is_sign` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否签到 0:未签到|1:已签到',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:已报名|2:已签到|3:以参与|4:中途退出',
  `remarks` varchar(240) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 96 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '活动-会员关系表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of event_member
-- ----------------------------
INSERT INTO `event_member` VALUES (1, 1, '六月生日会', 'legend', 6, '/static/default/avatar.png', '0', '', '', '', '', 1, 1, 0, 1, '', 1510217706, 1510217706, NULL);
INSERT INTO `event_member` VALUES (2, 1, '超级射手［海岸城站］', 'HoChen', 1, '/static/default/avatar.png', '0', '', '', '', '', 2, 1, 0, 1, '', 1510225279, 1510225279, NULL);
INSERT INTO `event_member` VALUES (3, 1, '超级射手［海岸城站］', 'HoChen', 1, '/static/default/avatar.png', '0', '', '', '', '', 2, 1, 0, 1, '', 1510225287, 1510225287, NULL);
INSERT INTO `event_member` VALUES (4, 1, '超级射手［海岸城站］', 'HoChen', 1, '/static/default/avatar.png', '0', '', '', '', '', 2, 1, 0, 1, '', 1510225313, 1510225313, NULL);
INSERT INTO `event_member` VALUES (5, 1, '超级射手［海岸城站］', 'HoChen', 1, '/static/default/avatar.png', '0', '', '', '', '', 2, 1, 0, 1, '', 1510278870, 1510278870, NULL);
INSERT INTO `event_member` VALUES (6, 1, '超级射手［海岸城站］', 'HoChen', 1, '/static/default/avatar.png', '0', '', '', '', '', 2, 1, 0, 1, '', 1510285527, 1510285527, NULL);
INSERT INTO `event_member` VALUES (7, 1, '超级射手［海岸城站］', 'HoChen', 1, '/static/default/avatar.png', '0', '', '', '', '', 2, 1, 0, 1, '', 1510285564, 1510285564, NULL);
INSERT INTO `event_member` VALUES (8, 1, '超级射手［海岸城站］', 'Hot-basketball2', 2, '/static/default/avatar.png', '0', '', '', '', '', 0, 1, 0, 1, '', 1510287844, 1510287844, NULL);
INSERT INTO `event_member` VALUES (9, 3, '1110', 'wayen_z', 7, '/static/default/avatar.png', '0', '', '', '', '', 0, 1, 0, 1, '', 1510289913, 1510289913, NULL);
INSERT INTO `event_member` VALUES (16, 1, '超级射手［海岸城站］', 'woo123', 8, '/static/default/avatar.png', '0', 'woo123', '', '18507717466', 'woo123', 1, 1, 0, 1, '', 1510646095, 1510646095, NULL);
INSERT INTO `event_member` VALUES (17, 1, '超级射手［海岸城站］', 'woo123', 8, '/static/default/avatar.png', '46', '小woo', '', '18507717466', 'woo123', 1, 1, 0, 1, '', 1510646221, 1510646221, NULL);
INSERT INTO `event_member` VALUES (18, 1, '超级射手［海岸城站］', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 1, 1, 0, 1, '', 1510653208, 1510653208, NULL);
INSERT INTO `event_member` VALUES (19, 1, '超级射手［海岸城站］', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 1, 1, 0, 1, '', 1510653449, 1510653449, NULL);
INSERT INTO `event_member` VALUES (20, 1, '超级射手［海岸城站］', 'legend', 6, '/static/default/avatar.png', '74', '新学生', '', '13826505160', 'legend', 1, 1, 0, 1, '', 1510653449, 1510653449, NULL);
INSERT INTO `event_member` VALUES (21, 1, '超级射手［海岸城站］', 'woo123', 8, '/static/default/avatar.png', '0', 'woo123', '', '18507717466', 'woo123', 1, 1, 0, 1, '', 1510653857, 1510653857, NULL);
INSERT INTO `event_member` VALUES (22, 1, '超级射手［海岸城站］', 'HoChen', 1, '/static/default/avatar.png', '0', 'HoChen', '', '13823599611', 'HoChen', 2, 1, 0, 1, '', 1510654000, 1510654000, NULL);
INSERT INTO `event_member` VALUES (23, 1, '超级射手［海岸城站］', 'woo123', 8, '/static/default/avatar.png', '0', 'woo123', '', '18507717466', 'woo123', 1, 1, 0, 1, '', 1510654018, 1510654018, NULL);
INSERT INTO `event_member` VALUES (24, 1, '超级射手［海岸城站］', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 1, 1, 0, 1, '', 1510654219, 1510654219, NULL);
INSERT INTO `event_member` VALUES (25, 1, '超级射手［海岸城站］', 'legend', 6, '/static/default/avatar.png', '61', '曹操', '', '13826505160', 'legend', 1, 1, 0, 1, '', 1510654548, 1510654548, NULL);
INSERT INTO `event_member` VALUES (26, 2, '大热篮球嘉年华', 'HoChen', 1, '/static/default/avatar.png', '0', 'HoChen', '', '13823599611', 'HoChen', 0, 1, 0, 1, '', 1510657888, 1510657888, NULL);
INSERT INTO `event_member` VALUES (27, 6, '免费活动', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 0, 1, 0, 1, '', 1511509660, 1511509660, NULL);
INSERT INTO `event_member` VALUES (28, 6, '免费活动', 'legend', 6, '/static/default/avatar.png', '89', '测试1', '', '13826505160', 'legend', 0, 1, 0, 1, '', 1511509751, 1511509751, NULL);
INSERT INTO `event_member` VALUES (29, 6, '免费活动', 'legend', 6, '/static/default/avatar.png', '74', '新学生', '', '13826505160', 'legend', 0, 1, 0, 1, '', 1511509751, 1511509751, NULL);
INSERT INTO `event_member` VALUES (30, 6, '免费活动', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 0, 1, 0, 1, '', 1511511756, 1511511756, NULL);
INSERT INTO `event_member` VALUES (31, 6, '免费活动', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 0, 1, 0, 3, '', 1511512004, 1511512748, NULL);
INSERT INTO `event_member` VALUES (32, 1, '超级射手［海岸城站］', 'woo123', 8, '/static/default/avatar.png', '0', 'woo123', '', '18507717466', 'woo123', 1, 1, 0, 1, '', 1511602995, 1511602995, NULL);
INSERT INTO `event_member` VALUES (33, 1, '超级射手［海岸城站］', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 1, 1, 0, 1, '', 1511603655, 1511603655, NULL);
INSERT INTO `event_member` VALUES (34, 5, '大热测试活动', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 2, 1, 0, 1, '', 1511603892, 1511603892, NULL);
INSERT INTO `event_member` VALUES (35, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '听海', 138, '/static/default/avatar.png', '0', '听海', '', '13699757076', '听海', 0, 1, 0, 4, '', 1511927838, 1512375047, NULL);
INSERT INTO `event_member` VALUES (36, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', 'Hot Basketball 1', 3, '/static/default/avatar.png', '0', 'Hot Basketball 1', '', '15820474733', 'Hot Basketball 1', 0, 1, 0, 4, '', 1511929088, 1512375047, NULL);
INSERT INTO `event_member` VALUES (37, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', 'GaoYan', 9, '/static/default/avatar.png', '0', 'GaoYan', '', '13662270560', 'GaoYan', 0, 1, 0, 4, '', 1511929227, 1512375047, NULL);
INSERT INTO `event_member` VALUES (38, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', 'HoChen', 1, '/static/default/avatar.png', '0', 'HoChen', '', '13823599611', 'HoChen', 0, 1, 0, 4, '', 1511929705, 1512375047, NULL);
INSERT INTO `event_member` VALUES (39, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', 'Amber', 187, '/static/default/avatar.png', '0', 'Amber', '', '15107642040', 'Amber', 0, 1, 0, 4, '', 1511930168, 1512375047, NULL);
INSERT INTO `event_member` VALUES (40, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', 'M00100895', 188, '/static/default/avatar.png', '0', 'M00100895', '', '18820259586', 'M00100895', 0, 1, 0, 4, '', 1511937293, 1512375047, NULL);
INSERT INTO `event_member` VALUES (41, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', '李芳', 189, '/static/default/avatar.png', '0', '李芳', '', '13751007132', '李芳', 0, 1, 0, 1, '', 1511938259, 1511938259, NULL);
INSERT INTO `event_member` VALUES (42, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', '黄之麓666', 177, '/static/default/avatar.png', '0', '黄之麓666', '', '13502866979', '黄之麓666', 0, 1, 0, 1, '', 1512002749, 1512002749, NULL);
INSERT INTO `event_member` VALUES (43, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '饶宏宇', 39, '/static/default/avatar.png', '0', '饶宏宇', '', '13640904690', '饶宏宇', 0, 1, 0, 1, '', 1512016985, 1512016985, NULL);
INSERT INTO `event_member` VALUES (44, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', '饶宏宇', 39, '/static/default/avatar.png', '0', '饶宏宇', '', '13640904690', '饶宏宇', 0, 1, 0, 1, '', 1512017120, 1512017120, NULL);
INSERT INTO `event_member` VALUES (45, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', 'HoChen', 1, '/static/default/avatar.png', '0', 'HoChen', '', '13823599611', 'HoChen', 0, 1, 0, 1, '', 1512039832, 1512039832, NULL);
INSERT INTO `event_member` VALUES (46, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '婷仔仔', 197, '/static/default/avatar.png', '0', '婷仔仔', '', '18218171943', '婷仔仔', 0, 1, 0, 1, '', 1512090351, 1512090351, NULL);
INSERT INTO `event_member` VALUES (47, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '婷仔仔', 197, '/static/default/avatar.png', '0', '婷仔仔', '', '18218171943', '婷仔仔', 0, 1, 0, 1, '', 1512090394, 1512090394, NULL);
INSERT INTO `event_member` VALUES (48, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '陈小样', 198, '/static/default/avatar.png', '0', '陈小样', '', '18750918160', '陈小样', 0, 1, 0, 1, '', 1512091365, 1512091365, NULL);
INSERT INTO `event_member` VALUES (49, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', 'Hot Basketball 1', 3, '/static/default/avatar.png', '0', 'Hot Basketball 1', '', '15820474733', 'Hot Basketball 1', 0, 1, 0, 1, '', 1512095332, 1512095332, NULL);
INSERT INTO `event_member` VALUES (50, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '雷xing', 199, '/static/default/avatar.png', '0', '雷xing', '', '18502077839', '雷xing', 0, 1, 0, 1, '', 1512095546, 1512095546, NULL);
INSERT INTO `event_member` VALUES (51, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', '阿吉仔', 200, '/static/default/avatar.png', '0', '阿吉仔', '', '17507559906', '阿吉仔', 0, 1, 0, 1, '', 1512095842, 1512095842, NULL);
INSERT INTO `event_member` VALUES (52, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '阿吉仔', 200, '/static/default/avatar.png', '0', '阿吉仔', '', '17507559906', '阿吉仔', 0, 1, 0, 1, '', 1512095858, 1512095858, NULL);
INSERT INTO `event_member` VALUES (53, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', 'wbl6621', 202, '/static/default/avatar.png', '0', 'wbl6621', '', '13410361295', 'wbl6621', 0, 1, 0, 1, '', 1512095950, 1512095950, NULL);
INSERT INTO `event_member` VALUES (54, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '辉', 203, '/static/default/avatar.png', '0', '辉', '', '13544001197', '辉', 0, 1, 0, 1, '', 1512096144, 1512096144, NULL);
INSERT INTO `event_member` VALUES (55, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', '拾忆', 204, '/static/default/avatar.png', '0', '拾忆', '', '18473823905', '拾忆', 0, 1, 0, 1, '', 1512103059, 1512103059, NULL);
INSERT INTO `event_member` VALUES (56, 8, 'KHOT世界花式篮球挑战赛、扣篮大赛总决赛', '马小茜', 205, '/static/default/avatar.png', '0', '马小茜', '', '18300005549', '马小茜', 0, 1, 0, 1, '', 1512107162, 1512107162, NULL);
INSERT INTO `event_member` VALUES (57, 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', '无语', 206, '/static/default/avatar.png', '0', '无语', '', '13421342275', '无语', 0, 1, 0, 1, '', 1512121866, 1512121866, NULL);
INSERT INTO `event_member` VALUES (58, 11, '周末打篮球', 'legend', 6, '/static/default/avatar.png', '0', 'legend', '', '13826505160', 'legend', 1, 1, 0, 1, '', 1513675534, 1513675534, NULL);
INSERT INTO `event_member` VALUES (59, 1, '超级射手［测试］', 'woo123', 8, '/static/default/avatar.png', '0', 'woo123', '', '18507717466', 'woo123', 1, 1, 0, 1, '', 1514444520, 1514444520, NULL);
INSERT INTO `event_member` VALUES (60, 1, '超级射手［测试］', 'HoChen', 1, '/static/default/avatar.png', '0', 'HoChen', '', '13823599611', 'HoChen', 2, 1, 0, 1, '', 1514444711, 1514444711, NULL);
INSERT INTO `event_member` VALUES (61, 1, '超级射手［测试］', '+*', 5, '/static/default/avatar.png', '0', '+*', '', '13418931599', '+*', 1, 1, 0, 1, '', 1514449043, 1514449043, NULL);
INSERT INTO `event_member` VALUES (62, 21, '测试', 'Hot Basketball 1', 3, '/static/default/avatar.png', '0', 'Hot Basketball 1', '', '15820474733', 'Hot Basketball 1', 0, 1, 0, 1, '', 1516437283, 1516437283, NULL);
INSERT INTO `event_member` VALUES (63, 22, '测试', 'Bingo', 21, '/static/default/avatar.png', '0', 'Bingo', '', '13692692153', 'Bingo', 1, 1, 0, 1, '', 1516437810, 1516437810, NULL);
INSERT INTO `event_member` VALUES (64, 23, '亲子体适能趣味活动', 'RacHeL', 455, '/static/default/avatar.png', '0', 'RacHeL', '', '13530938671', 'RacHeL', 2, 1, 0, 1, '', 1516717033, 1516717033, NULL);
INSERT INTO `event_member` VALUES (65, 19, '测试', 'wayen_z', 7, '/static/default/avatar.png', '0', 'wayen_z', '', '15018514302', 'wayen_z', 0, 1, 0, 3, '', 1516978988, 1516979079, NULL);
INSERT INTO `event_member` VALUES (66, 24, '1元抢大热利是封', 'HoChen', 1, '/static/default/avatar.png', '0', 'HoChen', '', '13823599611', 'HoChen', 1, 1, 0, 1, '', 1517484299, 1517484299, NULL);
INSERT INTO `event_member` VALUES (67, 24, '1元抢大热利是封', '笑待生活', 474, '/static/default/avatar.png', '0', '笑待生活', '', '18676676537', '笑待生活', 1, 1, 0, 1, '', 1517494363, 1517494363, NULL);
INSERT INTO `event_member` VALUES (68, 24, '1元抢大热利是封', '刘颖', 475, '/static/default/avatar.png', '0', '刘颖', '', '13924616919', '刘颖', 1, 1, 0, 1, '', 1517494397, 1517494397, NULL);
INSERT INTO `event_member` VALUES (69, 24, '1元抢大热利是封', 'willng', 12, '/static/default/avatar.png', '0', 'willng', '', '13684925727', 'willng', 1, 1, 0, 1, '', 1517494465, 1517494465, NULL);
INSERT INTO `event_member` VALUES (70, 24, '1元抢大热利是封', 'AK', 18, '/static/default/avatar.png', '0', 'AK', '', '18566201712', 'AK', 1, 1, 0, 1, '', 1517494513, 1517494513, NULL);
INSERT INTO `event_member` VALUES (71, 24, '1元抢大热利是封', '+*', 5, '/static/default/avatar.png', '0', '+*', '', '13418931599', '+*', 1, 1, 0, 1, '劉嘉興', 1517495281, 1517495281, NULL);
INSERT INTO `event_member` VALUES (72, 24, '1元抢大热利是封', '风情小子', 440, '/static/default/avatar.png', '0', '风情小子', '', '18718389148', '风情小子', 1, 1, 0, 1, '', 1517495524, 1517495524, NULL);
INSERT INTO `event_member` VALUES (73, 24, '1元抢大热利是封', '秋雨', 317, '/static/default/avatar.png', '0', '秋雨', '', '18925269368', '秋雨', 1, 1, 0, 1, '', 1517495615, 1517495615, NULL);
INSERT INTO `event_member` VALUES (74, 24, '1元抢大热利是封', '大芝', 441, '/static/default/avatar.png', '0', '大芝', '', '15113990278', '大芝', 1, 1, 0, 1, '', 1517495761, 1517495761, NULL);
INSERT INTO `event_member` VALUES (75, 24, '1元抢大热利是封', '5aaaaa', 476, '/static/default/avatar.png', '0', '5aaaaa', '', '13794818581', '5aaaaa', 1, 1, 0, 1, '', 1517496086, 1517496086, NULL);
INSERT INTO `event_member` VALUES (76, 24, '1元抢大热利是封', '帅气的蝈蝈', 477, '/static/default/avatar.png', '0', '帅气的蝈蝈', '', '13266592803', '帅气的蝈蝈', 1, 1, 0, 1, '', 1517496154, 1517496154, NULL);
INSERT INTO `event_member` VALUES (77, 24, '1元抢大热利是封', 'weilin666', 4, '/static/default/avatar.png', '0', 'weilin666', '', '13410599612', 'weilin666', 1, 1, 0, 1, '', 1517497412, 1517497412, NULL);
INSERT INTO `event_member` VALUES (78, 24, '1元抢大热利是封', '珊珊', 478, '/static/default/avatar.png', '0', '珊珊', '', '13790936515', '珊珊', 1, 1, 0, 1, '', 1517500061, 1517500061, NULL);
INSERT INTO `event_member` VALUES (79, 24, '1元抢大热利是封', 'woo123', 8, '/static/default/avatar.png', '0', 'woo123', '', '18507717466', 'woo123', 1, 1, 0, 1, '', 1517500725, 1517500725, NULL);
INSERT INTO `event_member` VALUES (80, 24, '1元抢大热利是封', 'wayen_z', 7, '/static/default/avatar.png', '0', 'wayen_z', '', '15018514302', 'wayen_z', 1, 1, 0, 1, '', 1517500823, 1517500823, NULL);
INSERT INTO `event_member` VALUES (81, 24, '1元抢大热利是封', '番番最标致', 442, '/static/default/avatar.png', '0', '番番最标致', '', '18819877560', '番番最标致', 1, 1, 0, 1, '', 1517500840, 1517500840, NULL);
INSERT INTO `event_member` VALUES (82, 24, '1元抢大热利是封', 'luoruibao', 185, '/static/default/avatar.png', '0', 'luoruibao', '', '18825207520', 'luoruibao', 1, 1, 0, 1, '', 1517514511, 1517514511, NULL);
INSERT INTO `event_member` VALUES (83, 24, '1元抢大热利是封', 'GaoYan', 9, '/static/default/avatar.png', '0', 'GaoYan', '', '13662270560', 'GaoYan', 1, 1, 0, 1, '', 1517515309, 1517515309, NULL);
INSERT INTO `event_member` VALUES (84, 24, '1元抢大热利是封', '叶志坚', 479, '/static/default/avatar.png', '0', '叶志坚', '', '13510088998', '叶志坚', 1, 1, 0, 1, '', 1517523696, 1517523696, NULL);
INSERT INTO `event_member` VALUES (85, 24, '1元抢大热利是封', '幼稚园杀手', 482, '/static/default/avatar.png', '0', '幼稚园杀手', '', '13682397007', '幼稚园杀手', 1, 1, 0, 1, '', 1517539025, 1517539025, NULL);
INSERT INTO `event_member` VALUES (86, 24, '1元抢大热利是封', '雨', 169, '/static/default/avatar.png', '0', '雨', '', '13302933960', '雨', 1, 1, 0, 1, '', 1517539339, 1517539339, NULL);
INSERT INTO `event_member` VALUES (87, 24, '1元抢大热利是封', 'l朱民皓', 320, '/static/default/avatar.png', '0', 'l朱民皓', '', '13360093862', 'l朱民皓', 1, 1, 0, 1, '', 1517542226, 1517542226, NULL);
INSERT INTO `event_member` VALUES (88, 24, '1元抢大热利是封', '静', 147, '/static/default/avatar.png', '0', '静', '', '13530943120', '静', 1, 1, 0, 1, '', 1517542450, 1517542450, NULL);
INSERT INTO `event_member` VALUES (89, 24, '1元抢大热利是封', 'Greeny', 13, '/static/default/avatar.png', '0', 'Greeny', '', '13828880254', 'Greeny', 10, 1, 0, 1, '', 1517551437, 1517551437, NULL);
INSERT INTO `event_member` VALUES (90, 24, '1元抢大热利是封', '黄之麓666', 177, '/static/default/avatar.png', '0', '黄之麓666', '', '13502866979', '黄之麓666', 1, 1, 0, 1, '', 1517556088, 1517556088, NULL);
INSERT INTO `event_member` VALUES (91, 24, '1元抢大热利是封', '三吉木易', 237, '/static/default/avatar.png', '0', '三吉木易', '', '13922807565', '三吉木易', 1, 1, 0, 1, '', 1517568802, 1517568802, NULL);
INSERT INTO `event_member` VALUES (92, 24, '1元抢大热利是封', '鹿鸣', 486, '/static/default/avatar.png', '0', '鹿鸣', '', '13631692271', '鹿鸣', 1, 1, 0, 1, '', 1517671245, 1517671245, NULL);
INSERT INTO `event_member` VALUES (93, 24, '1元抢大热利是封', 'banana', 487, '/static/default/avatar.png', '0', 'banana', '', '13450108445', 'banana', 1, 1, 0, 1, '', 1517724147, 1517724147, NULL);
INSERT INTO `event_member` VALUES (94, 24, '1元抢大热利是封', 'legend', 6, '/static/default/avatar.png', '0,2', 'legend,陈小准', '', '13826505160', 'legend', 2, 1, 0, 1, '', 1517803969, 1517803969, NULL);
INSERT INTO `event_member` VALUES (95, 20, '主题', 'woo123', 8, '/static/default/avatar.png', '0', 'woo123', '', '18507717466', 'woo123', 0, 1, 0, 1, '', 1518172339, 1518172339, NULL);

SET FOREIGN_KEY_CHECKS = 1;
