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

 Date: 18/04/2018 15:36:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for schedule_giftrecord
-- ----------------------------
DROP TABLE IF EXISTS `schedule_giftrecord`;
CREATE TABLE `schedule_giftrecord`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '操作的会员id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员',
  `camp_id` int(11) NOT NULL DEFAULT 0 COMMENT '训练营id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '训练营',
  `lesson_id` int(11) NOT NULL DEFAULT 0 COMMENT '课程id',
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '课程',
  `grade_id` int(11) NOT NULL DEFAULT 0 COMMENT '班级id',
  `grade` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '班级',
  `student_num` int(11) NOT NULL DEFAULT 0 COMMENT '赠送人数',
  `student_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '赠送学员名单',
  `gift_schedule` int(11) NOT NULL DEFAULT 0 COMMENT '人均赠送课时数',
  `remarks` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注留言',
  `system_remarks` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '系统备注',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态1:成功|0:未操作',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '课时赠送记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of schedule_giftrecord
-- ----------------------------
INSERT INTO `schedule_giftrecord` VALUES (1, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 15, '龙岗民警子女篮球训练课程', 32, '龙岗篮球训练营', 18, '[{\"student\":\"张旺鹏\",\"student_id\":\"122\",\"id\":\"121\"},{\"student\":\"李鸣轩\",\"student_id\":\"117\",\"id\":\"120\"},{\"student\":\"袁帅\",\"student_id\":\"121\",\"id\":\"117\"},{\"student\":\"蔡佳烨\",\"student_id\":\"111\",\"id\":\"116\"},{\"student\":\"郭懋增\",\"student_id\":\"110\",\"id\":\"115\"},{\"student\":\"黄子杰\",\"student_id\":\"109\",\"id\":\"114\"},{\"student\":\"王瑞翔\",\"student_id\":\"108\",\"id\":\"113\"},{\"student\":\"曾子航\",\"student_id\":\"107\",\"id\":\"112\"},{\"student\":\"颜若宸\",\"student_id\":\"105\",\"id\":\"111\"},{\"student\":\"王浩丁\",\"student_id\":\"104\",\"id\":\"110\"},{\"student\":\"周子祺\",\"student_id\":\"99\",\"id\":\"109\"},{\"student\":\"苏祖威\",\"student_id\":\"98\",\"id\":\"108\"},{\"student\":\"陈予喆\",\"student_id\":\"96\",\"id\":\"107\"},{\"student\":\"王孝煊\",\"student_id\":\"115\",\"id\":\"106\"},{\"student\":\"邵冠霖\",\"student_id\":\"118\",\"id\":\"105\"},{\"student\":\"杨涵\",\"student_id\":\"119\",\"id\":\"104\"},{\"student\":\"黄俊豪\",\"student_id\":\"116\",\"id\":\"103\"},{\"student\":\"关楠萧\",\"student_id\":\"120\",\"id\":\"102\"}]', 3, '', NULL, 1, 1510802316, 1510802316, NULL);
INSERT INTO `schedule_giftrecord` VALUES (2, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"饶鹏轩\",\"student_id\":\"129\",\"id\":\"307\"}]', 1, '续费赠送1课时', NULL, 1, 1510819437, 1510819437, NULL);
INSERT INTO `schedule_giftrecord` VALUES (3, 14, 'MirandaXian', 9, '大热篮球俱乐部', 15, '龙岗民警子女篮球训练课程', 0, '', 3, '[{\"student\":\"刘永锋\",\"student_id\":\"152\",\"id\":\"350\"},{\"student\":\"骆九宇\",\"student_id\":\"165\",\"id\":\"326\"},{\"student\":\"杨耀斌\",\"student_id\":\"147\",\"id\":\"323\"}]', 3, '', NULL, 1, 1511592268, 1511592268, NULL);
INSERT INTO `schedule_giftrecord` VALUES (4, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"洪新铠\",\"student_id\":\"189\",\"id\":\"368\"}]', 12, '补上12课时', NULL, 1, 1513324869, 1513324869, NULL);
INSERT INTO `schedule_giftrecord` VALUES (5, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"强亦宸\",\"student_id\":\"206\",\"id\":\"389\"}]', 1, '续费赠送1课时', NULL, 1, 1513651676, 1513651676, NULL);
INSERT INTO `schedule_giftrecord` VALUES (6, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"王国宇\",\"student_id\":\"193\",\"id\":\"372\"}]', 5, '特殊赠送八五折', NULL, 1, 1513652641, 1513652641, NULL);
INSERT INTO `schedule_giftrecord` VALUES (7, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"郭浩麟\",\"student_id\":\"199\",\"id\":\"380\"}]', 3, '老学员续费赠送3课时', NULL, 1, 1513652733, 1513652733, NULL);
INSERT INTO `schedule_giftrecord` VALUES (8, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"蒋成栋\",\"student_id\":\"192\",\"id\":\"371\"}]', 1, '续费赠送1课时', NULL, 1, 1513654565, 1513654565, NULL);
INSERT INTO `schedule_giftrecord` VALUES (9, 18, 'AK', 13, 'AKcross训练营', 39, '南外文华快艇队', 0, '', 1, '[{\"student\":\"周润锋\",\"student_id\":\"201\",\"id\":\"382\"}]', 3, '耶', NULL, 1, 1513752162, 1513752162, NULL);
INSERT INTO `schedule_giftrecord` VALUES (10, 18, 'AK', 13, 'AKcross训练营', 39, '南外文华快艇队', 0, '', 1, '[{\"student\":\"陈米洛\",\"student_id\":\"202\",\"id\":\"383\"}]', 2, '耶耶', NULL, 1, 1513752448, 1513752448, NULL);
INSERT INTO `schedule_giftrecord` VALUES (11, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"林嘉豪\",\"student_id\":\"135\",\"id\":\"124\"}]', 1, '', NULL, 1, 1513753368, 1513753368, NULL);
INSERT INTO `schedule_giftrecord` VALUES (12, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 2, '[{\"student\":\"吴宇昊\",\"student_id\":\"150\",\"id\":\"161\"},{\"student\":\"钟铭楷\",\"student_id\":\"138\",\"id\":\"127\"}]', 2, '', NULL, 1, 1513753419, 1513753419, NULL);
INSERT INTO `schedule_giftrecord` VALUES (13, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"刘进哲\",\"student_id\":\"128\",\"id\":\"126\"}]', 3, '', NULL, 1, 1513753478, 1513753478, NULL);
INSERT INTO `schedule_giftrecord` VALUES (14, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 2, '[{\"student\":\"杨灿\",\"student_id\":\"133\",\"id\":\"131\"},{\"student\":\"吴奇朗\",\"student_id\":\"127\",\"id\":\"130\"}]', 5, '', NULL, 1, 1513753546, 1513753546, NULL);
INSERT INTO `schedule_giftrecord` VALUES (15, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"吴贻然\",\"student_id\":\"169\",\"id\":\"159\"}]', 7, '', NULL, 1, 1513753636, 1513753636, NULL);
INSERT INTO `schedule_giftrecord` VALUES (16, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"袁梓钦\",\"student_id\":\"134\",\"id\":\"132\"}]', 10, '', NULL, 1, 1513753677, 1513753677, NULL);
INSERT INTO `schedule_giftrecord` VALUES (17, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"张哲栋\",\"student_id\":\"141\",\"id\":\"129\"}]', 14, '', NULL, 1, 1513753710, 1513753710, NULL);
INSERT INTO `schedule_giftrecord` VALUES (18, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"谢睿轩\",\"student_id\":\"137\",\"id\":\"128\"}]', 15, '', NULL, 1, 1513753781, 1513753781, NULL);
INSERT INTO `schedule_giftrecord` VALUES (19, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"陈智斌\",\"student_id\":\"166\",\"id\":\"160\"}]', 17, '', NULL, 1, 1513753854, 1513753854, NULL);
INSERT INTO `schedule_giftrecord` VALUES (20, 8, 'woo123', 31, 'woo篮球兴趣训练营', 51, '下午茶篮球课（有赠送课时）', 39, '下午茶班', 6, '[{\"student\":\"Bingo\",\"student_id\":\"225\",\"id\":\"192\"},{\"student\":\"GT \",\"student_id\":\"226\",\"id\":\"191\"},{\"student\":\"刘嘉\",\"student_id\":\"6\",\"id\":\"190\"},{\"student\":\"高燕\",\"student_id\":\"223\",\"id\":\"189\"},{\"student\":\"小霖\",\"student_id\":\"4\",\"id\":\"188\"},{\"student\":\"哔哔哔\",\"student_id\":\"101\",\"id\":\"187\"}]', 1, '给雅露测试', NULL, 1, 1513757437, 1513757437, NULL);
INSERT INTO `schedule_giftrecord` VALUES (21, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"柯艾锐\",\"student_id\":\"173\",\"id\":\"352\"}]', 2, '', NULL, 1, 1513760455, 1513760455, NULL);
INSERT INTO `schedule_giftrecord` VALUES (22, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"毕宸君\",\"student_id\":\"139\",\"id\":\"125\"}]', 1, '老学员续费赠送一课时', NULL, 1, 1513823061, 1513823061, NULL);
INSERT INTO `schedule_giftrecord` VALUES (23, 18, 'AK', 13, 'AKcross训练营', 43, '塘朗追梦队', 0, '', 1, '[{\"student\":\"杜宇轩\",\"student_id\":\"228\",\"id\":\"414\"}]', 2, '', NULL, 1, 1513827101, 1513827101, NULL);
INSERT INTO `schedule_giftrecord` VALUES (24, 18, 'AK', 13, 'AKcross训练营', 43, '塘朗追梦队', 0, '', 1, '[{\"student\":\"吴浩睿\",\"student_id\":\"255\",\"id\":\"442\"}]', 2, '', NULL, 1, 1513840535, 1513840535, NULL);
INSERT INTO `schedule_giftrecord` VALUES (25, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 2, '[{\"student\":\"张驰\",\"student_id\":\"276\",\"id\":\"466\"},{\"student\":\"张派\",\"student_id\":\"275\",\"id\":\"465\"}]', 1, '', '20171225:重复提交产生的异常数据,做delete_time处理', 1, 1514001295, 1514001295, 1514174461);
INSERT INTO `schedule_giftrecord` VALUES (26, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 2, '[{\"student\":\"张驰\",\"student_id\":\"276\",\"id\":\"466\"},{\"student\":\"张派\",\"student_id\":\"275\",\"id\":\"465\"}]', 1, '', NULL, 1, 1514001295, 1514001295, NULL);
INSERT INTO `schedule_giftrecord` VALUES (27, 14, 'MirandaXian', 9, '大热篮球俱乐部', 15, '龙岗民警子女篮球训练课程', 0, '', 1, '[{\"student\":\"刘浩宏\",\"student_id\":\"278\",\"id\":\"468\"}]', 3, '', NULL, 1, 1514173333, 1514173333, NULL);
INSERT INTO `schedule_giftrecord` VALUES (28, 18, 'AK', 13, 'AKcross训练营', 39, 'AKcross课程', 36, '南外周三五班', 5, '[{\"student\":\"刘羽\",\"student_id\":\"174\",\"id\":\"289\"},{\"student\":\"陈逸昕\",\"student_id\":\"176\",\"id\":\"287\"},{\"student\":\"李李喆\",\"student_id\":\"86\",\"id\":\"157\"},{\"student\":\"游逸朗\",\"student_id\":\"41\",\"id\":\"156\"},{\"student\":\"田家福\",\"student_id\":\"160\",\"id\":\"155\"}]', 3, '', NULL, 1, 1514357210, 1514357210, NULL);
INSERT INTO `schedule_giftrecord` VALUES (29, 18, 'AK', 13, 'AKcross训练营', 39, 'AKcross课程', 36, '南外周三五班', 4, '[{\"student\":\"陈逸昕\",\"student_id\":\"176\",\"id\":\"287\"},{\"student\":\"李李喆\",\"student_id\":\"86\",\"id\":\"157\"},{\"student\":\"游逸朗\",\"student_id\":\"41\",\"id\":\"156\"},{\"student\":\"田家福\",\"student_id\":\"160\",\"id\":\"155\"}]', 3, '', NULL, 1, 1514357224, 1514357224, 1514358797);
INSERT INTO `schedule_giftrecord` VALUES (30, 18, 'AK', 13, 'AKcross训练营', 39, 'AKcross课程', 36, '南外周三五班', 4, '[{\"student\":\"陈逸昕\",\"student_id\":\"176\",\"id\":\"287\"},{\"student\":\"李李喆\",\"student_id\":\"86\",\"id\":\"157\"},{\"student\":\"游逸朗\",\"student_id\":\"41\",\"id\":\"156\"},{\"student\":\"田家福\",\"student_id\":\"160\",\"id\":\"155\"}]', 3, '', NULL, 1, 1514357268, 1514357268, 1514358797);
INSERT INTO `schedule_giftrecord` VALUES (31, 18, 'AK', 13, 'AKcross训练营', 43, '塘朗追梦队', 0, '', 1, '[{\"student\":\"郑明宇\",\"student_id\":\"196\",\"id\":\"375\"}]', 2, '', NULL, 1, 1514357713, 1514357713, 1514358797);
INSERT INTO `schedule_giftrecord` VALUES (32, 18, 'AK', 13, 'AKcross训练营', 41, '塘朗追梦队', 48, '塘朗低年级综合班', 1, '[{\"student\":\"孟想\",\"student_id\":\"187\",\"id\":\"293\"}]', 1, '', NULL, 1, 1514358461, 1514358461, NULL);
INSERT INTO `schedule_giftrecord` VALUES (33, 18, 'AK', 13, 'AKcross训练营', 41, '塘朗追梦队', 48, '塘朗低年级综合班', 1, '[{\"student\":\"孟想\",\"student_id\":\"187\",\"id\":\"293\"}]', 1, '', NULL, 1, 1514358467, 1514358467, 1514358797);
INSERT INTO `schedule_giftrecord` VALUES (34, 18, 'AK', 13, 'AKcross训练营', 41, '塘朗追梦队', 48, '塘朗低年级综合班', 1, '[{\"student\":\"孟想\",\"student_id\":\"187\",\"id\":\"293\"}]', 1, '', NULL, 1, 1514358469, 1514358469, 1514358797);
INSERT INTO `schedule_giftrecord` VALUES (35, 18, 'AK', 13, 'AKcross训练营', 39, 'AKcross课程', 36, '南外周三五班', 1, '[{\"student\":\"陈仕杰\",\"student_id\":\"175\",\"id\":\"288\"}]', 2, '', NULL, 1, 1514358671, 1514358671, NULL);
INSERT INTO `schedule_giftrecord` VALUES (36, 18, 'AK', 13, 'AKcross训练营', 39, 'AKcross课程', 36, '南外周三五班', 1, '[{\"student\":\"陈仕杰\",\"student_id\":\"175\",\"id\":\"288\"}]', 2, '', NULL, 1, 1514358685, 1514358685, 1514358797);
INSERT INTO `schedule_giftrecord` VALUES (37, 18, 'AK', 13, 'AKcross训练营', 43, '塘朗追梦队', 0, '', 1, '[{\"student\":\"郑明宇\",\"student_id\":\"196\",\"id\":\"375\"}]', 2, '', NULL, 1, 1514358903, 1514358903, NULL);
INSERT INTO `schedule_giftrecord` VALUES (38, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 2, '[{\"student\":\"何锦宸\",\"student_id\":\"190\",\"id\":\"369\"},{\"student\":\"瞿士杰\",\"student_id\":\"177\",\"id\":\"356\"}]', 2, '', NULL, 1, 1514358933, 1514358933, NULL);
INSERT INTO `schedule_giftrecord` VALUES (39, 18, 'AK', 13, 'AKcross训练营', 43, '塘朗追梦队', 0, '', 1, '[{\"student\":\"彭鼎盛\",\"student_id\":\"281\",\"id\":\"471\"}]', 2, '', NULL, 1, 1514890066, 1514890066, NULL);
INSERT INTO `schedule_giftrecord` VALUES (40, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 36, '南外周三五班', 1, '[{\"student\":\" 潘思达\",\"student_id\":\"287\",\"id\":\"362\"}]', 3, '', NULL, 1, 1515123786, 1515123786, NULL);
INSERT INTO `schedule_giftrecord` VALUES (41, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 36, '南外周三五班', 1, '[{\"student\":\" 张梓峰\",\"student_id\":\"288\",\"id\":\"373\"}]', 4, '', NULL, 1, 1515123887, 1515123887, NULL);
INSERT INTO `schedule_giftrecord` VALUES (42, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"张笑宇\",\"student_id\":\"355\",\"id\":\"552\"}]', 2, '首次报名30课时赠2课时', NULL, 1, 1515401271, 1515401271, NULL);
INSERT INTO `schedule_giftrecord` VALUES (43, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"周劲希\",\"student_id\":\"341\",\"id\":\"536\"}]', 1, '续费赠送1课时', NULL, 1, 1515402300, 1515402300, NULL);
INSERT INTO `schedule_giftrecord` VALUES (44, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 55, '丽山文体公园高年级班', 1, '[{\"student\":\"刘子豪\",\"student_id\":\"186\",\"id\":\"399\"}]', 1, '', NULL, 1, 1515402619, 1515402619, NULL);
INSERT INTO `schedule_giftrecord` VALUES (45, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"柯艾锐\",\"student_id\":\"173\",\"id\":\"352\"}]', 3, '续费30课时赠送3课时', NULL, 1, 1515551789, 1515551789, NULL);
INSERT INTO `schedule_giftrecord` VALUES (46, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"吴靖宇\",\"student_id\":\"131\",\"id\":\"330\"}]', 3, '续费30课时赠送3课时', NULL, 1, 1515561645, 1515561645, NULL);
INSERT INTO `schedule_giftrecord` VALUES (47, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 28, '周六北头进阶班', 1, '[{\"student\":\"周尹木\",\"student_id\":\"158\",\"id\":\"137\"}]', 5, '特殊优惠赠送', NULL, 1, 1516270292, 1516270292, NULL);
INSERT INTO `schedule_giftrecord` VALUES (48, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 35, '周六北头中高年级班', 1, '[{\"student\":\"刘政翰\",\"student_id\":\"125\",\"id\":\"152\"}]', 2, '原本特殊九折优惠，现改为赠送2课时', NULL, 1, 1516270386, 1516270386, NULL);
INSERT INTO `schedule_giftrecord` VALUES (49, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 35, '周六北头中高年级班', 1, '[{\"student\":\"郑子轩\",\"student_id\":\"178\",\"id\":\"418\"}]', 3, '特殊优惠赠送', NULL, 1, 1516270531, 1516270531, NULL);
INSERT INTO `schedule_giftrecord` VALUES (50, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"许凯瑞\",\"student_id\":\"361\",\"id\":\"561\"}]', 1, '续费赠送1课时', NULL, 1, 1516611378, 1516611378, NULL);
INSERT INTO `schedule_giftrecord` VALUES (51, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 29, '周日北头高年级初中基础', 1, '[{\"student\":\"牛子儒\",\"student_id\":\"195\",\"id\":\"215\"}]', 1, '旧课时剩余1课时转移到新平台', NULL, 1, 1516679986, 1516679986, NULL);
INSERT INTO `schedule_giftrecord` VALUES (52, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"李祖帆\",\"student_id\":\"155\",\"id\":\"337\"}]', 1, '续费赠送1课时', NULL, 1, 1516701204, 1516701204, NULL);
INSERT INTO `schedule_giftrecord` VALUES (53, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"魏信迪\",\"student_id\":\"279\",\"id\":\"469\"}]', 1, '', NULL, 1, 1516864773, 1516864773, NULL);
INSERT INTO `schedule_giftrecord` VALUES (54, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"刘进哲\",\"student_id\":\"128\",\"id\":\"126\"}]', 1, '续费15课时赠送1课时', NULL, 1, 1516935411, 1516935411, NULL);
INSERT INTO `schedule_giftrecord` VALUES (55, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"刘昊\",\"student_id\":\"364\",\"id\":\"556\"}]', 1, '续费赠送1课时', NULL, 1, 1517106202, 1517106202, NULL);
INSERT INTO `schedule_giftrecord` VALUES (56, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 55, '丽山文体公园高年级班', 1, '[{\"student\":\"林城佑\",\"student_id\":\"339\",\"id\":\"401\"}]', 1, '续费赠送1课时', NULL, 1, 1517202547, 1517202547, NULL);
INSERT INTO `schedule_giftrecord` VALUES (57, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 35, '周六北头中高年级班', 1, '[{\"student\":\"郭雨锜\",\"student_id\":\"387\",\"id\":\"430\"}]', 1, '续费15课时赠送1课时', NULL, 1, 1519525096, 1519525096, NULL);
INSERT INTO `schedule_giftrecord` VALUES (58, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"张晨儒\",\"student_id\":\"5\",\"id\":\"277\"}]', 3, '购买30课时赠送2课时，续费另外赠送1课时。', NULL, 1, 1519543019, 1519543019, NULL);
INSERT INTO `schedule_giftrecord` VALUES (59, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"傅晓泷\",\"student_id\":\"393\",\"id\":\"595\"}]', 1, '续费赠送1课时', NULL, 1, 1519544003, 1519544003, NULL);
INSERT INTO `schedule_giftrecord` VALUES (60, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 2, '[{\"student\":\"何雨辰\",\"student_id\":\"394\",\"id\":\"597\"},{\"student\":\"何明鸿\",\"student_id\":\"374\",\"id\":\"596\"}]', 1, '续费大热常规班15课时赠送1课时', NULL, 1, 1519717656, 1519717656, NULL);
INSERT INTO `schedule_giftrecord` VALUES (61, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"郑德源\",\"student_id\":\"363\",\"id\":\"599\"}]', 2, '', NULL, 1, 1519731194, 1519731194, NULL);
INSERT INTO `schedule_giftrecord` VALUES (62, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"覃诗翔\",\"student_id\":\"140\",\"id\":\"412\"}]', 1, '续费赠送1课时', NULL, 1, 1519800808, 1519800808, NULL);
INSERT INTO `schedule_giftrecord` VALUES (63, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"郑嘉俊\",\"student_id\":\"395\",\"id\":\"600\"}]', 2, '新生报名优惠，请查收', NULL, 1, 1520063527, 1520063527, NULL);
INSERT INTO `schedule_giftrecord` VALUES (64, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"郑竣隆\",\"student_id\":\"292\",\"id\":\"486\"}]', 4, '', NULL, 1, 1520064250, 1520064250, NULL);
INSERT INTO `schedule_giftrecord` VALUES (65, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"刘宇辰\",\"student_id\":\"396\",\"id\":\"601\"}]', 1, '', NULL, 1, 1520080751, 1520080751, NULL);
INSERT INTO `schedule_giftrecord` VALUES (66, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"黄之麓\",\"student_id\":\"397\",\"id\":\"602\"}]', 1, '续费赠送1课时', NULL, 1, 1520135498, 1520135498, NULL);
INSERT INTO `schedule_giftrecord` VALUES (67, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"郑德源\",\"student_id\":\"363\",\"id\":\"562\"}]', 1, '续费赠送1课时', NULL, 1, 1520239923, 1520239923, NULL);
INSERT INTO `schedule_giftrecord` VALUES (68, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 29, '周日北头高年级初中基础', 1, '[{\"student\":\"刘炜文\",\"student_id\":\"248\",\"id\":\"208\"}]', 1, '续费赠送1课时', NULL, 1, 1520244520, 1520244520, NULL);
INSERT INTO `schedule_giftrecord` VALUES (69, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 29, '周日北头高年级初中基础', 1, '[{\"student\":\"罗仕杰\",\"student_id\":\"247\",\"id\":\"207\"}]', 1, '续费赠送1课时', NULL, 1, 1520392587, 1520392587, NULL);
INSERT INTO `schedule_giftrecord` VALUES (70, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"钟铭楷\",\"student_id\":\"138\",\"id\":\"319\"}]', 1, '续费赠送1课时', NULL, 1, 1520478875, 1520478875, NULL);
INSERT INTO `schedule_giftrecord` VALUES (71, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"卢新元\",\"student_id\":\"298\",\"id\":\"492\"}]', 1, '续报赠课时', NULL, 1, 1520741820, 1520741820, NULL);
INSERT INTO `schedule_giftrecord` VALUES (72, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 29, '周日北头高年级初中基础', 1, '[{\"student\":\"王廖聪\",\"student_id\":\"246\",\"id\":\"206\"}]', 1, '续费赠送1课时', NULL, 1, 1520752203, 1520752203, NULL);
INSERT INTO `schedule_giftrecord` VALUES (73, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 46, '鼎太女子班', 1, '[{\"student\":\"侯朝歌\",\"student_id\":\"274\",\"id\":\"285\"}]', 1, '续费赠送1课时', NULL, 1, 1520835011, 1520835011, NULL);
INSERT INTO `schedule_giftrecord` VALUES (74, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"李俊晔\",\"student_id\":\"231\",\"id\":\"439\"}]', 1, '续费赠送1课时', NULL, 1, 1520845022, 1520845022, NULL);
INSERT INTO `schedule_giftrecord` VALUES (75, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"孙胤麒\",\"student_id\":\"360\",\"id\":\"607\"}]', 1, '续费赠送1课时', NULL, 1, 1521260195, 1521260195, NULL);
INSERT INTO `schedule_giftrecord` VALUES (76, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 55, '丽山文体公园高年级班', 1, '[{\"student\":\"许凯瑞\",\"student_id\":\"361\",\"id\":\"438\"}]', 3, '', NULL, 1, 1521260247, 1521260247, NULL);
INSERT INTO `schedule_giftrecord` VALUES (77, 18, 'AK', 13, 'AKcross训练营', 43, '塘朗追梦队', 0, '', 1, '[{\"student\":\"杜宇轩\",\"student_id\":\"228\",\"id\":\"414\"}]', 1, '', NULL, 1, 1521277008, 1521277008, NULL);
INSERT INTO `schedule_giftrecord` VALUES (78, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 43, '北头周日十点低年级综合班', 1, '[{\"student\":\"李正昊\",\"student_id\":\"130\",\"id\":\"265\"}]', 3, '', NULL, 1, 1521345529, 1521345529, NULL);
INSERT INTO `schedule_giftrecord` VALUES (79, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"张之翼\",\"student_id\":\"403\",\"id\":\"609\"}]', 2, '', NULL, 1, 1521354293, 1521354293, NULL);
INSERT INTO `schedule_giftrecord` VALUES (80, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"张应淏\",\"student_id\":\"404\",\"id\":\"610\"}]', 2, '', NULL, 1, 1521355211, 1521355211, NULL);
INSERT INTO `schedule_giftrecord` VALUES (81, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"张正堃\",\"student_id\":\"301\",\"id\":\"495\"}]', 1, '续报赠课', NULL, 1, 1521361785, 1521361785, NULL);
INSERT INTO `schedule_giftrecord` VALUES (82, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 2, '[{\"student\":\"辛禹菲\",\"student_id\":\"406\",\"id\":\"612\"},{\"student\":\"张诗婷\",\"student_id\":\"405\",\"id\":\"611\"}]', 1, '续费赠送1课时', NULL, 1, 1521439594, 1521439594, NULL);
INSERT INTO `schedule_giftrecord` VALUES (83, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"卢宇璠\",\"student_id\":\"136\",\"id\":\"308\"}]', 3, '续费30节课赠送3课时', NULL, 1, 1521515660, 1521515660, NULL);
INSERT INTO `schedule_giftrecord` VALUES (84, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 15, '龙岗民警子女篮球训练课程', 0, '', 1, '[{\"student\":\"李佶\",\"student_id\":\"407\",\"id\":\"613\"}]', 3, '', NULL, 1, 1521516394, 1521516394, NULL);
INSERT INTO `schedule_giftrecord` VALUES (85, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 15, '龙岗民警子女篮球训练课程', 0, '', 1, '[{\"student\":\"简福康\",\"student_id\":\"408\",\"id\":\"614\"}]', 3, '', NULL, 1, 1521523535, 1521523535, NULL);
INSERT INTO `schedule_giftrecord` VALUES (86, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"唐浩益\",\"student_id\":\"305\",\"id\":\"499\"}]', 1, '续费赠课', NULL, 1, 1522044760, 1522044760, NULL);
INSERT INTO `schedule_giftrecord` VALUES (87, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"张鸿宇\",\"student_id\":\"300\",\"id\":\"494\"}]', 3, '续费赠课', NULL, 1, 1522044798, 1522044798, NULL);
INSERT INTO `schedule_giftrecord` VALUES (88, 18, 'AK', 13, 'AKcross训练营', 38, 'AKcross课程', 0, '', 1, '[{\"student\":\"郑浩明\",\"student_id\":\"411\",\"id\":\"619\"}]', 1, '报名赠课', NULL, 1, 1522063300, 1522063300, NULL);
INSERT INTO `schedule_giftrecord` VALUES (89, 18, 'AK', 13, 'AKcross训练营', 43, '塘朗追梦队', 0, '', 1, '[{\"student\":\"郑明宇\",\"student_id\":\"196\",\"id\":\"375\"}]', 3, '老带新赠课', NULL, 1, 1522295303, 1522295303, NULL);
INSERT INTO `schedule_giftrecord` VALUES (90, 2, 'Hot-basketball2', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"吴贻然\",\"student_id\":\"169\",\"id\":\"345\"}]', 1, '续费赠送1课时', NULL, 1, 1522746094, 1522746094, NULL);
INSERT INTO `schedule_giftrecord` VALUES (91, 14, 'MirandaXian', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"林子骞\",\"student_id\":\"146\",\"id\":\"339\"}]', 3, '续费购买30课时赠送3课时', NULL, 1, 1523155975, 1523155975, NULL);
INSERT INTO `schedule_giftrecord` VALUES (92, 14, 'MirandaXian', 9, '大热篮球俱乐部', 15, '龙岗民警子女篮球训练课程', 0, '', 1, '[{\"student\":\"王孝煊\",\"student_id\":\"115\",\"id\":\"291\"}]', 3, '', NULL, 1, 1523429465, 1523429465, NULL);
INSERT INTO `schedule_giftrecord` VALUES (93, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"吴奇朗\",\"student_id\":\"127\",\"id\":\"130\"}]', 1, '续费15节课赠送1课时', NULL, 1, 1523524302, 1523524302, NULL);
INSERT INTO `schedule_giftrecord` VALUES (94, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 33, '周五北头低年级班', 1, '[{\"student\":\"肖振兴\",\"student_id\":\"144\",\"id\":\"194\"}]', 1, '', NULL, 1, 1523601652, 1523601652, NULL);
INSERT INTO `schedule_giftrecord` VALUES (95, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"郑新浩\",\"student_id\":\"241\",\"id\":\"429\"}]', 1, '', NULL, 1, 1523604981, 1523604981, NULL);
INSERT INTO `schedule_giftrecord` VALUES (96, 3, 'Hot Basketball 1', 9, '大热篮球俱乐部', 13, '大热常规班', 0, '', 1, '[{\"student\":\"张益畅\",\"student_id\":\"244\",\"id\":\"426\"}]', 1, '', NULL, 1, 1523605493, 1523605493, NULL);

SET FOREIGN_KEY_CHECKS = 1;
