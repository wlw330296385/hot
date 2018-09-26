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

 Date: 25/09/2018 15:26:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for grade_member
-- ----------------------------
DROP TABLE IF EXISTS `grade_member`;
CREATE TABLE `grade_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grade` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `grade_id` int(10) NOT NULL,
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属训练营',
  `student_id` int(10) NOT NULL,
  `student` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对应会员表member',
  `member_id` int(10) NOT NULL COMMENT '对应会员表id',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '头像',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '学生类型:2体验生|1正式学生',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '系统备注',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '-1:离营|0:待审核|1:正常|2:退出|3:被开除|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1747 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '班级-会员关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grade_member
-- ----------------------------
INSERT INTO `grade_member` VALUES (603, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 293, '郑竣丰', '郑竣丰', 333, '/static/default/avatar.png', 1, '', '20180627学员完成课时毕业', 1, 1524481419, NULL, 1530029403);
INSERT INTO `grade_member` VALUES (604, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 292, '郑竣隆', '郑竣隆', 332, '/static/default/avatar.png', 1, '', NULL, 1, 1524481419, NULL, 1524481419);
INSERT INTO `grade_member` VALUES (644, '周日北头高年级初中基础', 29, '周日北头高年级初中班', 13, 9, '大热篮球俱乐部', 5, '张晨儒', '13537781797', 15, '/static/default/avatar.png', 1, '', NULL, 1, 1524536247, NULL, 1524536247);
INSERT INTO `grade_member` VALUES (645, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 195, '牛子儒', '蓝天白云', 233, '/static/default/avatar.png', 1, '', '20180704学员完成课时毕业', 1, 1524536247, NULL, 1530634204);
INSERT INTO `grade_member` VALUES (602, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 294, '郑兆彤', '郑兆彤', 334, '/static/default/avatar.png', 1, '', NULL, 1, 1524481419, NULL, 1524481419);
INSERT INTO `grade_member` VALUES (16, '周六北头前海五年级', 26, '大热高级班', 13, 9, '大热篮球俱乐部', 8, '钟欣志', '钟欣志', 23, '/static/default/avatar.png', 1, '系统插入', '20180418学员完成课时毕业', 4, 1508141658, NULL, 1524042602);
INSERT INTO `grade_member` VALUES (670, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 415, '林炜昇', '林国标', 533, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (21, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 14, '陈承铭', '陈承铭', 26, '/static/default/avatar.png', 1, '系统插入,时间2017年10月18日17:40:19', '20180418学员完成课时毕业', 4, 1508318976, NULL, 1524042591);
INSERT INTO `grade_member` VALUES (601, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 295, '方晋弛', '方晋弛', 335, '/static/default/avatar.png', 1, '', NULL, 1, 1524481419, NULL, 1524481419);
INSERT INTO `grade_member` VALUES (599, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 395, '郑嘉俊', 'Kafai', 508, '/static/default/avatar.png', 1, '', '20180801学员完成课时毕业', 1, 1524481419, NULL, 1533053403);
INSERT INTO `grade_member` VALUES (600, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 340, '汤璨宇', '汤镕章', 329, '/static/default/avatar.png', 1, '', NULL, 1, 1524481419, NULL, 1524481419);
INSERT INTO `grade_member` VALUES (25, '前海小学', 23, '前海小学', 31, 15, '钟声训练营', 15, '陈润宏', '陈润宏', 43, 'https://wx.qlogo.cn/mmopen/vi_32/wCFb3b7CBRJSuXQazfF7N0GIfuhF53JRlkVEq2Z2pUgIMraJI2iaWwCONHk7nkJibrUQiaEyU8yrPxianhMIyuArdg/0', 1, '', '20180504学员完成课时毕业', 4, 1508554704, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (26, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 16, '李润弘', '李润弘', 42, 'https://wx.qlogo.cn/mmopen/vi_32/icD3j8Uhe4xOLJS1zichGLY3rfpJAI4Efd95vMQxlBhSABPWicw4tOHsyY2rnPVAFDbAohTvsMAxoLIo49bA33Z1g/0', 1, '', '20180418学员完成课时毕业', 4, 1508554789, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (27, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 17, '郑肖杰', '郑肖杰', 48, 'https://wx.qlogo.cn/mmopen/vi_32/8B6CScn6mZribr9bTI1RhDEiaQvCtKUKp9BmL1VLoamZWKFF3mHqfOOw2zN5gOIFCBpwsycFWFnr6SulEH2hRLBA/0', 1, '', '20180418学员完成课时毕业', 4, 1508639991, NULL, 1524042592);
INSERT INTO `grade_member` VALUES (1522, '1对1（邓教练）', 83, '1对1私教（邓教练）', 89, 43, '韵动篮球俱乐部', 470, '肖人杰', '肖人杰', 669, '/static/default/avatar.png', 1, '', NULL, 1, 1534846704, NULL, 1534846704);
INSERT INTO `grade_member` VALUES (1523, '1对1（邓教练）', 83, '1对1私教（邓教练）', 89, 43, '韵动篮球俱乐部', 469, '凌文翔', '凌文翔', 670, '/static/default/avatar.png', 1, '', NULL, 1, 1534846704, NULL, 1534846704);
INSERT INTO `grade_member` VALUES (1722, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 474, '肖煜婷', '肖煜婷', 721, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (30, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 20, '唐轩衡', '唐轩衡', 55, 'https://wx.qlogo.cn/mmopen/vi_32/VVyUyM6Q3vHB0kvA47iafepgr2L2vx8nvxzeSIKqJQLGz6qA9RWloXBmvCic1r4pD1chaLOLck0y4r3aibFmEE1YQ/0', 1, '', '20180513学员完成课时毕业', 4, 1508676522, NULL, 1526141403);
INSERT INTO `grade_member` VALUES (31, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 22, '郑皓畅', '郑皓畅', 56, 'https://wx.qlogo.cn/mmopen/vi_32/6zNQeeicR57x1lcicY9mgX2MBCibf3OkicIKIvEcq1Ec7ibFPRFkEtg8nKeBoiaNfrwoGmvu9Wt5BWo9HicxroYqjRZsw/0', 1, '', '20180418学员完成课时毕业', 1, 1508723297, NULL, 1524040985);
INSERT INTO `grade_member` VALUES (32, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 21, '陈高翔', '陈高翔', 59, 'https://wx.qlogo.cn/mmopen/vi_32/yzvxOetibI0IK3Jjwxb8AhFLpiaf8sEqjkhPwXgtr0JRXWJNIVDBvT6QjblpFABBKGCvGryia5xz20zwzEg5BZ6dg/0', 1, '', '20180504学员完成课时毕业', 4, 1508723329, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (33, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 25, '战奕名', '战奕名', 51, 'https://wx.qlogo.cn/mmopen/vi_32/v4IpFsmBcCwGN9D1SzfmfahDia8p8l3saE3DbWnmOY2HCClXCmfibzzw3H3hcnbXAAkcwQH6icJxiabSc03HnXSLlA/0', 1, '', '20180418学员完成课时毕业', 4, 1508724642, NULL, 1524042339);
INSERT INTO `grade_member` VALUES (34, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 26, '李语辰', '李语辰', 46, 'https://wx.qlogo.cn/mmopen/vi_32/JVWE6PQ990A8KoicXXxCEzKP2trTcWSkBsW16ibaYbTZHSTA4mOy410wA2u9uuxUB0FiavLiaBkicKCp9icc9Rgry7HQ/0', 1, '', '20180418学员完成课时毕业', 1, 1508725787, NULL, 1524040986);
INSERT INTO `grade_member` VALUES (1715, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 588, '徐逸宁', '漾儿', 1287, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (1716, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 586, '杨宇航', '杨宇航', 1285, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (36, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 28, '王钰龙', '王钰龙', 60, 'https://wx.qlogo.cn/mmopen/vi_32/mpqiaCLKTSkHXZbs2GqFnjoflrkMib2j49z5yM8VHDmmUSicHZI5iak2Tia6ykX7tXT8TOBYB2v9UaYmnJ99Z0FCO0g/0', 1, '', '20180418学员完成课时毕业', 1, 1508726144, NULL, 1524040986);
INSERT INTO `grade_member` VALUES (37, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 29, '刘宇恒', '刘宇恒', 62, 'https://wx.qlogo.cn/mmopen/vi_32/dg5BzBbk6ialKxBfoWtI9iayIQS6b5pG0QF1ib4YiauZics9fBRksgtWibAcHYEGiaJbjOR4W0jOgGJIb6LAwiapjEkkbg/0', 1, '', '20180513学员完成课时毕业', 4, 1508729343, NULL, 1526141403);
INSERT INTO `grade_member` VALUES (1717, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 585, '凌豪宏', '凌豪宏', 1281, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (1718, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 572, '文天成', '文天成', 1256, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (1719, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 568, '王若舟', '王若舟', 1238, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (1720, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 563, '李旭涵', '李旭涵', 1240, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (1721, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 477, '姚子恒', '姚子恒', 661, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (41, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 35, '万宇宸', '万宇宸', 61, 'https://wx.qlogo.cn/mmopen/vi_32/pnKFC33CDdnArcQ0ONDFVdlQ1yF6aewh99xgKW3G72iaruRr1oGTIwV8gfpfptb4VpBdicrZ9pJLwpib50cYrfVVw/0', 1, '', '20180511学员完成课时毕业', 4, 1508737748, NULL, 1525968603);
INSERT INTO `grade_member` VALUES (42, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 36, '邱仁鹏', 'SZQIUJB', 73, 'https://wx.qlogo.cn/mmopen/vi_32/oBJMukfMx9mAfOFLL6oILN4zz1F39lUDnibK34DTlPq3YUq2P7gWk4muj1cDFKMQLlN5ypREzibVJO4yKSEUK62w/0', 1, '', NULL, 1, 1508766196, NULL, 1508992187);
INSERT INTO `grade_member` VALUES (1696, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 576, '任梓瑞', '任梓瑞', 1261, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1697, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 454, '杜昱乐', '杜昱乐', 657, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (44, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 39, '饶滨', '饶滨', 58, 'https://wx.qlogo.cn/mmopen/vi_32/3q4wOibh9nZPekaEh1mPpULmJARKuuXRphK7Mak1kTjCNNIibNEjNicoEVtmJLT9G7kjoNZ6vllcLteP8vibyXiaj0A/0', 1, '', '20180428学员完成课时毕业', 4, 1508770993, NULL, 1524845402);
INSERT INTO `grade_member` VALUES (46, '周六北头前海五年级', 26, '高年级班', 13, 9, '大热篮球俱乐部', 42, '陈宛杭', 'kiko', 80, 'https://wx.qlogo.cn/mmopen/vi_32/zocbwtq7yDlo6zSBZ0jmSgpaHaFWmAotUTmzHopaB1Vl8DVWP9Gdd7U37xhdUkg30Z6HE6BzIBKGqEJBRDQOLA/0', 1, '', '退费', 2, 1508849731, NULL, 1509422313);
INSERT INTO `grade_member` VALUES (1698, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 575, '谭天瑞', '谭天瑞', 1262, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1699, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 571, '张嘉桓', '华英', 1253, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1700, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 471, '王瑞智', '毛哥', 702, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1701, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 466, '黄奕铭', '周平', 715, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1702, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 566, '周军旭', '周军旭', 1250, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (50, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 57, '梁懿', '梁懿', 83, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIZILv4jZfYyLDTSDRic2TicWv1Lqsy7ibgV1LK3PiaycF11vJQ2Ud4PrDa0XvcQEhdaEAEkb2feNbtCQ/0', 1, '', '20180504学员完成课时毕业', 4, 1508986588, NULL, 1525363805);
INSERT INTO `grade_member` VALUES (1713, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 457, '彭镜舟', 'Loan琼', 705, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1703, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 565, '彭镜舟', '若艳', 1248, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1704, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 562, '唐毅轩', '左边', 1236, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1705, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 560, '史林坤', '茉小茉', 1114, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1706, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 558, '虞蔚泽', '虞蔚泽妈妈', 1195, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1707, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 491, '胡起睿', '一路风景', 1115, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (59, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 71, '李浚睿', 'Jerry', 75, 'https://wx.qlogo.cn/mmopen/vi_32/7g6icshVrInKsnnzvMpm7jBVXywRsKHnITNpDYTVPXYEWaYh1sDHPRU2z5YIIJdMvNM9HWOPMKyiakHiaibM9lY6sA/0', 1, '', '20180511学员完成课时毕业', 4, 1509079444, NULL, 1525968602);
INSERT INTO `grade_member` VALUES (1708, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 466, '黄奕铭', '周平', 715, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1709, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 461, '晏步轩', 'Co可', 711, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1710, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 462, '杨牧林', 'lin', 712, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (1711, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 475, '陈锦峰', '陈锦峰', 722, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (65, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 75, '薛子豪', '薛子豪', 92, 'https://wx.qlogo.cn/mmhead/78EkX665csCzfpNaaBSvfy1JpmicTLfoh2FtiaNSKK6N5PYicTOeK8wjA/0', 1, '', '20180418学员完成课时毕业', 1, 1509180982, NULL, 1524040994);
INSERT INTO `grade_member` VALUES (1694, '室内幼儿班', 44, '大热常规班', 13, 9, '大热篮球俱乐部', 262, '严俊朗', '严俊朗', 294, '/static/default/avatar.png', 1, '', NULL, 1, 1536579667, NULL, 1536579667);
INSERT INTO `grade_member` VALUES (1665, '低年级私教', 85, '1对1私教', 96, 14, 'Ball  is  life', 574, '舒靖煊', '舒靖煊', 1258, '/static/default/avatar.png', 1, '', NULL, 1, 1536396282, NULL, 1536396282);
INSERT INTO `grade_member` VALUES (1677, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 209, '邱智鸿', '邱智鸿', 247, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1678, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 206, '强亦宸', '强亦宸', 244, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1679, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 193, '王国宇', '可心', 231, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1680, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 192, '蒋成栋', '蒋成栋', 230, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1695, '室内幼儿班', 44, '大热常规班', 13, 9, '大热篮球俱乐部', 161, '黄子骞', 'huangzq', 168, '/static/default/avatar.png', 1, '', NULL, 1, 1536579667, NULL, 1536579667);
INSERT INTO `grade_member` VALUES (75, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 84, '王奕唐', 'Miya', 98, 'https://wx.qlogo.cn/mmhead/FrdAUicrPIibfdwVLEWdXjfszf6JtqbichNGmgX52g519jUT3AkWJkF5A/0', 1, '', '20180509学员完成课时毕业', 4, 1509283014, NULL, 1525795809);
INSERT INTO `grade_member` VALUES (1712, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 467, '袁冬祥', '袁冬祥', 665, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (894, '特殊扣课时班级', 64, '大热常规班', 13, 9, '大热篮球俱乐部', 426, '陈志鸿', '陈志鸿', 546, '/static/default/avatar.png', 1, '', NULL, 1, 1529897830, NULL, 1529897830);
INSERT INTO `grade_member` VALUES (820, '私教一对二（初中）', 56, '大热一对二私教班', 56, 9, '大热篮球俱乐部', 354, '魏子健', '张丽芬', 388, '/static/default/avatar.png', 1, '', NULL, 1, 1524797158, NULL, 1524797158);
INSERT INTO `grade_member` VALUES (821, '私教一对二（初中）', 56, '大热一对二私教班', 56, 9, '大热篮球俱乐部', 353, '刘书含', '曼曼红', 381, '/static/default/avatar.png', 1, '', '20180614学员完成课时毕业', 1, 1524797158, NULL, 1528906207);
INSERT INTO `grade_member` VALUES (420, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 369, '朱子玥', '15692453726', 433, '/static/default/avatar.png', 1, '', '20180428学员完成课时毕业', 4, 1516443431, NULL, 1524845401);
INSERT INTO `grade_member` VALUES (419, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 368, '朱子恒', '15692453726', 433, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1516443431, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (100, '测试体', 31, '荣光篮球强化', 25, 5, '荣光训练营', 7, '儿童劫', 'wl', 10, '/static/default/avatar.png', 1, '', NULL, 1, 1510195422, 1510195469, 1510195476);
INSERT INTO `grade_member` VALUES (118, '天才班', 12, '平台示例请勿购买', 37, 4, '准行者训练营', 12, '娟', 'HoChen', 1, '/static/default/avatar.png', 1, '', NULL, 1, 1510383975, NULL, 1510383975);
INSERT INTO `grade_member` VALUES (881, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 194, '王昱泽', '王剑平', 232, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (882, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 140, '覃诗翔', '言覃多多', 146, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (883, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 144, '肖振兴', '中国太保惠霞', 150, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (884, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 173, '柯艾锐', '艾望承', 183, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (885, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 171, '李闻韬', 'liwentao', 178, '/static/default/avatar.png', 1, '', '20180830学员完成课时毕业', 1, 1528858421, NULL, 1535559005);
INSERT INTO `grade_member` VALUES (886, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 169, '吴贻然', 'ൠ杨ྉ子ྉൠ', 176, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (887, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 166, '陈智斌', '????✨Mandy*????', 173, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (888, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 150, '吴宇昊', 'victor', 156, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (889, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 139, '毕宸君', 'Taily', 145, '/static/default/avatar.png', 1, '', '20180704学员完成课时毕业', 1, 1528858421, NULL, 1530634205);
INSERT INTO `grade_member` VALUES (890, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 128, '刘进哲', '刘欣洋', 134, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (891, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 137, '谢睿轩', '谢睿轩Ryan', 143, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (892, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 127, '吴奇朗', '晨曦', 133, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (671, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 414, '张乐淘', '张乐淘', 532, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (672, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 397, '黄之麓', 'JasonHuang', 510, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (673, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 279, '魏信迪', '魏信迪', 319, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (674, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 233, '罗宁', '罗宁', 265, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (675, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 159, '蓝炫皓', '飘', 165, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (676, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 158, '周尹木', 'zhouyinmu', 164, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (677, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 157, '刘秉松', 'yolanda传奇', 163, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (678, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 156, '唐愈翔', '龙船????唐力', 162, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (679, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 154, '赖德瑞', '张春丽＆', 160, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (144, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 151, '刘庭彦', '19782174', 157, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 1, 1511249871, NULL, 1524042348);
INSERT INTO `grade_member` VALUES (145, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 155, '李祖帆', '浪花', 161, '/static/default/avatar.png', 1, '', '20180113学员完成课时毕业', 1, 1511249871, NULL, 1515846761);
INSERT INTO `grade_member` VALUES (683, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 271, '李兆堂', '李兆堂', 303, '/static/default/avatar.png', 1, '', NULL, 1, 1524536298, NULL, 1524536298);
INSERT INTO `grade_member` VALUES (684, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 142, '谢欣桦', 'wiya', 148, '/static/default/avatar.png', 1, '', NULL, 1, 1524536298, NULL, 1524536298);
INSERT INTO `grade_member` VALUES (685, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 143, '方泓锴', 'fanghk', 149, '/static/default/avatar.png', 1, '', NULL, 1, 1524536298, NULL, 1524536298);
INSERT INTO `grade_member` VALUES (686, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 132, '梁思诚', '听海', 138, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 1, 1524536298, NULL, 1525363807);
INSERT INTO `grade_member` VALUES (1735, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 372, '朱星懿', '朱星懿', 457, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (1736, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 387, '郭雨锜', '郭雨锜', 472, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (1737, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 205, '卢星丞', '卢星丞', 243, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (1738, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 179, '杨熙', '杨熙', 207, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (1739, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 146, '林子骞', 'Jack123', 152, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (1740, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 125, '刘政翰', 'Dorothy', 131, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (1741, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 136, '卢宇璠', '卢盛良', 142, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (1742, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 90, '梁浩然', 'LIANG', 101, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (893, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 134, '袁梓钦', '袁梓钦YZQ', 140, '/static/default/avatar.png', 1, '', NULL, 1, 1528858421, NULL, 1528858421);
INSERT INTO `grade_member` VALUES (784, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 429, '关楠潇', '东北小汉', 549, '/static/default/avatar.png', 1, '', NULL, 1, 1524719429, NULL, 1524719429);
INSERT INTO `grade_member` VALUES (785, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 165, '骆九宇', 'luojiuyu', 172, '/static/default/avatar.png', 1, '', NULL, 1, 1524719429, NULL, 1524719429);
INSERT INTO `grade_member` VALUES (786, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 116, '黄俊豪', '黄俊豪', 124, '/static/default/avatar.png', 1, '', NULL, 1, 1524719429, NULL, 1524719429);
INSERT INTO `grade_member` VALUES (787, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 119, '杨涵', '6222024000065498186', 126, '/static/default/avatar.png', 1, '', '20180708学员完成课时毕业', 4, 1524719429, NULL, 1530979803);
INSERT INTO `grade_member` VALUES (788, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 115, '王孝煊', '065385', 123, '/static/default/avatar.png', 1, '', NULL, 1, 1524719429, NULL, 1524719429);
INSERT INTO `grade_member` VALUES (789, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 96, '陈予喆', 'hou1298280', 106, '/static/default/avatar.png', 1, '', NULL, 1, 1524719429, NULL, 1524719429);
INSERT INTO `grade_member` VALUES (790, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 104, '王浩丁', '王浩丁', 113, '/static/default/avatar.png', 1, '', NULL, 1, 1524719429, NULL, 1524719429);
INSERT INTO `grade_member` VALUES (791, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 105, '颜若宸', '颜若宸', 114, '/static/default/avatar.png', 1, '', '20180526学员完成课时毕业', 1, 1524719429, NULL, 1527264603);
INSERT INTO `grade_member` VALUES (792, '龙岗训练营低年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 108, '王瑞翔', '王少华', 117, '/static/default/avatar.png', 1, '', '20180704学员完成课时毕业', 4, 1524719429, NULL, 1530634204);
INSERT INTO `grade_member` VALUES (869, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 107, '曾子航', '13670022780', 116, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (870, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 408, '简福康', '兰俊', 525, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (871, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 407, '李佶', '姜毅', 524, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (872, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 278, '刘浩宏', '冰雪纷飞', 309, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (873, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 152, '刘永锋', '风格独特见解', 158, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (874, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 147, '杨耀斌', 'Yrb801129', 153, '/static/default/avatar.png', 1, '', '20180614学员完成课时毕业', 4, 1526971474, NULL, 1528906206);
INSERT INTO `grade_member` VALUES (875, '龙岗训练营高年级班', 38, '龙岗民警子女篮球课程', 15, 9, '大热篮球俱乐部', 117, '李鸣轩', '13825243733', 125, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (876, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 122, '张旺鹏', '军歌', 128, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (877, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 121, '袁帅', '6222024000065498186', 126, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (878, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 98, '苏祖威', '061683', 108, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (879, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 99, '周子祺', 'lily', 109, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (880, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 109, '黄子杰', '黄子杰', 118, '/static/default/avatar.png', 1, '', NULL, 1, 1526971474, NULL, 1526971474);
INSERT INTO `grade_member` VALUES (187, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 101, '哔哔哔', 'MirandaXian', 14, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1513744563, NULL, 1524042589);
INSERT INTO `grade_member` VALUES (188, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 4, '小霖', 'weilin666', 4, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1513744563, NULL, 1524042589);
INSERT INTO `grade_member` VALUES (189, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 223, '高燕', 'GaoYan', 9, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1513744563, NULL, 1524042589);
INSERT INTO `grade_member` VALUES (190, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 6, '刘嘉', '+*', 5, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1513757343, NULL, 1524042589);
INSERT INTO `grade_member` VALUES (191, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 226, 'GT ', 'willng', 12, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 1, 1513757343, NULL, 1524040981);
INSERT INTO `grade_member` VALUES (192, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 225, 'Bingo', 'Bingo', 21, '/static/default/avatar.png', 1, '', NULL, 1, 1513757343, NULL, 1513757343);
INSERT INTO `grade_member` VALUES (197, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 148, '柏成恩', '小福和小小福和小小小福', 154, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 1, 1513765017, NULL, 1524040996);
INSERT INTO `grade_member` VALUES (198, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 200, '王珑桥', '王珑桥', 238, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 1, 1513765017, NULL, 1524042344);
INSERT INTO `grade_member` VALUES (199, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 149, '谭天笑', 'TAN谭天笑', 155, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1513765017, NULL, 1524042599);
INSERT INTO `grade_member` VALUES (200, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 197, '谭晟中', '谭晟中谭正中', 235, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 1, 1513765017, NULL, 1524040991);
INSERT INTO `grade_member` VALUES (201, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 189, '洪新铠', '洪新铠', 214, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017);
INSERT INTO `grade_member` VALUES (202, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 164, '林弋骁', 'Lynch', 171, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 1, 1513765017, NULL, 1524040994);
INSERT INTO `grade_member` VALUES (203, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 167, '黄川越', 'hcyhcy', 174, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017);
INSERT INTO `grade_member` VALUES (680, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 153, '文经纬', 'Lisa Lee(李建平)', 159, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (681, '周六北头进阶班', 28, '大热高级班', 13, 9, '大热篮球俱乐部', 9, '罗翔宇', '罗翔宇', 25, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (682, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 95, '曾跃阳', '30988232', 105, '/static/default/avatar.png', 1, '', NULL, 1, 1524536283, NULL, 1524536283);
INSERT INTO `grade_member` VALUES (646, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 254, '康正浩', '康正浩', 286, '/static/default/avatar.png', 1, '', '20180427学员完成课时毕业', 1, 1524536247, NULL, 1524759005);
INSERT INTO `grade_member` VALUES (647, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 253, '崔展豪', '崔展豪', 285, '/static/default/avatar.png', 1, '', NULL, 1, 1524536247, NULL, 1524536247);
INSERT INTO `grade_member` VALUES (648, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 252, '洪旭林', '洪旭林', 284, '/static/default/avatar.png', 1, '', NULL, 1, 1524536247, NULL, 1524536247);
INSERT INTO `grade_member` VALUES (649, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 251, '石原炜', '石原炜', 283, '/static/default/avatar.png', 1, '', NULL, 1, 1524536247, NULL, 1524536247);
INSERT INTO `grade_member` VALUES (650, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 250, '王北鲲', '王北鲲', 282, '/static/default/avatar.png', 1, '', NULL, 1, 1524536247, NULL, 1524536247);
INSERT INTO `grade_member` VALUES (651, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 249, '唐佳诺', '唐佳诺', 281, '/static/default/avatar.png', 1, '', NULL, 1, 1524536247, NULL, 1524536247);
INSERT INTO `grade_member` VALUES (652, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 248, '刘炜文', '刘炜文', 280, '/static/default/avatar.png', 1, '', '20180704学员完成课时毕业', 4, 1524536247, NULL, 1530634204);
INSERT INTO `grade_member` VALUES (653, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 247, '罗仕杰', '罗仕杰', 279, '/static/default/avatar.png', 1, '', NULL, 1, 1524536247, NULL, 1524536247);
INSERT INTO `grade_member` VALUES (654, '周日北头高年级初中基础', 29, '大热常规班', 13, 9, '大热篮球俱乐部', 280, '冼峻鞍', '秋雨', 317, '/static/default/avatar.png', 1, '', '20180517学员完成课时毕业', 4, 1524536247, NULL, 1526487003);
INSERT INTO `grade_member` VALUES (1743, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 91, '梁浩峰', 'LIANG', 101, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (687, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 145, '欧阳宇航', '欧阳宇航的外公', 151, '/static/default/avatar.png', 1, '', NULL, 1, 1524536298, NULL, 1524536298);
INSERT INTO `grade_member` VALUES (688, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 138, '钟铭楷', '丹佛儿', 144, '/static/default/avatar.png', 1, '', NULL, 1, 1524536298, NULL, 1524536298);
INSERT INTO `grade_member` VALUES (222, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 222, '谭正中', '谭晟中谭正中', 235, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1513847040, NULL, 1524042601);
INSERT INTO `grade_member` VALUES (223, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 221, '马明道', '马明道', 259, '/static/default/avatar.png', 1, '', NULL, 1, 1513847040, NULL, 1513847040);
INSERT INTO `grade_member` VALUES (225, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 219, '潘乐航', '潘乐航', 257, '/static/default/avatar.png', 1, '', NULL, 1, 1513847040, NULL, 1513847040);
INSERT INTO `grade_member` VALUES (226, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 218, '周一泉', '周一泉', 256, '/static/default/avatar.png', 1, '', NULL, 1, 1513847040, NULL, 1513847040);
INSERT INTO `grade_member` VALUES (227, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 217, '冯镇壕', '冯镇壕', 255, '/static/default/avatar.png', 1, '', NULL, 1, 1513847040, NULL, 1513847040);
INSERT INTO `grade_member` VALUES (228, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 216, '周学谦', '周学谦', 254, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1513847040, NULL, 1524042603);
INSERT INTO `grade_member` VALUES (229, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 124, '江晨', '锦华', 130, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 1, 1513847040, NULL, 1524042347);
INSERT INTO `grade_member` VALUES (230, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 123, '刘俊霖', '红茶????', 129, '/static/default/avatar.png', 1, '', NULL, 1, 1513847040, NULL, 1513847040);
INSERT INTO `grade_member` VALUES (1666, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 581, '钟泽宇', 'zyyz520', 1269, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1667, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 580, '赵家豪', '赵家豪', 1267, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1668, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 579, '廖涵宇', '廖涵宇', 1268, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1669, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 398, '董心宇', 'Dongxinyu', 513, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1670, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 391, '凌奕', '凌奕', 485, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1671, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 227, '柏泓庚', 'M00100895', 188, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1672, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 215, '郭皓晗', '郭皓晗', 253, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1673, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 214, '严振轩', '严振轩', 252, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1674, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 213, '薛若鸿', '薛若鸿', 251, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1675, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 212, '张文瑄', '张文瑄', 250, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (1676, '北头周六五点综合班', 40, '大热常规班', 13, 9, '大热篮球俱乐部', 210, '王炫程', '王炫程', 248, '/static/default/avatar.png', 1, '', NULL, 1, 1536402254, NULL, 1536402254);
INSERT INTO `grade_member` VALUES (734, '北头周日八点高年级初中班', 41, '大热常规班', 13, 9, '大热篮球俱乐部', 229, '阮烨才', '阮烨才', 261, '/static/default/avatar.png', 1, '', NULL, 1, 1524536405, NULL, 1524536405);
INSERT INTO `grade_member` VALUES (735, '北头周日八点高年级初中班', 41, '大热常规班', 13, 9, '大热篮球俱乐部', 230, '陈江函', '陈江函', 262, '/static/default/avatar.png', 1, '', '20180427学员完成课时毕业', 4, 1524536405, NULL, 1524759005);
INSERT INTO `grade_member` VALUES (736, '北头周日八点高年级初中班', 41, '大热常规班', 13, 9, '大热篮球俱乐部', 231, '李俊晔', '李俊晔', 263, '/static/default/avatar.png', 1, '', NULL, 1, 1524536405, NULL, 1524536405);
INSERT INTO `grade_member` VALUES (737, '北头周日八点高年级初中班', 41, '大热常规班', 13, 9, '大热篮球俱乐部', 103, '陈嘉航', 'chenjiahang', 112, '/static/default/avatar.png', 1, '', NULL, 1, 1524536405, NULL, 1524536405);
INSERT INTO `grade_member` VALUES (689, '北头周日八点初中提高班', 42, '大热常规班', 13, 9, '大热篮球俱乐部', 234, '谈朔显', '谈朔显', 266, '/static/default/avatar.png', 1, '', NULL, 1, 1524536323, NULL, 1524536323);
INSERT INTO `grade_member` VALUES (690, '北头周日八点初中提高班', 42, '大热常规班', 13, 9, '大热篮球俱乐部', 235, ' 李承彧', ' 李承彧', 267, '/static/default/avatar.png', 1, '', NULL, 1, 1524536323, NULL, 1524536323);
INSERT INTO `grade_member` VALUES (691, '北头周日八点初中提高班', 42, '大热常规班', 13, 9, '大热篮球俱乐部', 236, '汪子杰', '汪子杰', 268, '/static/default/avatar.png', 1, '', NULL, 1, 1524536323, NULL, 1524536323);
INSERT INTO `grade_member` VALUES (692, '北头周日八点初中提高班', 42, '大热常规班', 13, 9, '大热篮球俱乐部', 237, '杨欣霈', '杨欣霈', 269, '/static/default/avatar.png', 1, '', NULL, 1, 1524536323, NULL, 1524536323);
INSERT INTO `grade_member` VALUES (738, '北头周日十点低年级综合班', 43, '大热常规班', 13, 9, '大热篮球俱乐部', 239, '刘阳', '刘阳', 271, '/static/default/avatar.png', 1, '', NULL, 1, 1524536416, NULL, 1524536416);
INSERT INTO `grade_member` VALUES (739, '北头周日十点低年级综合班', 43, '大热常规班', 13, 9, '大热篮球俱乐部', 240, '郭子阅', '郭子阅', 272, '/static/default/avatar.png', 1, '', NULL, 1, 1524536416, NULL, 1524536416);
INSERT INTO `grade_member` VALUES (740, '北头周日十点低年级综合班', 43, '大热常规班', 13, 9, '大热篮球俱乐部', 241, '郑新浩', '郑新浩', 273, '/static/default/avatar.png', 1, '', NULL, 1, 1524536416, NULL, 1524536416);
INSERT INTO `grade_member` VALUES (741, '北头周日十点低年级综合班', 43, '大热常规班', 13, 9, '大热篮球俱乐部', 242, '任志诚', '任志诚', 274, '/static/default/avatar.png', 1, '', NULL, 1, 1524536416, NULL, 1524536416);
INSERT INTO `grade_member` VALUES (742, '北头周日十点低年级综合班', 43, '大热常规班', 13, 9, '大热篮球俱乐部', 244, '张益畅', '张益畅', 276, '/static/default/avatar.png', 1, '', NULL, 1, 1524536416, NULL, 1524536416);
INSERT INTO `grade_member` VALUES (743, '北头周日十点低年级综合班', 43, '大热常规班', 13, 9, '大热篮球俱乐部', 199, '郭浩麟', '三吉木易', 237, '/static/default/avatar.png', 1, '', NULL, 1, 1524536416, NULL, 1524536416);
INSERT INTO `grade_member` VALUES (744, '北头周日十点低年级综合班', 43, '大热常规班', 13, 9, '大热篮球俱乐部', 131, '吴靖宇', '吴靖宇wjy', 137, '/static/default/avatar.png', 1, '', NULL, 1, 1524536416, NULL, 1524536416);
INSERT INTO `grade_member` VALUES (745, '北头周日十点低年级综合班', 43, '大热常规班', 13, 9, '大热篮球俱乐部', 130, '李正昊', '18923856665', 136, '/static/default/avatar.png', 1, '', NULL, 1, 1524536416, NULL, 1524536416);
INSERT INTO `grade_member` VALUES (1689, '室内幼儿班', 44, '大热常规班', 13, 9, '大热篮球俱乐部', 490, '姚乐成', 'YUYULIU', 1112, '/static/default/avatar.png', 1, '', NULL, 1, 1536579667, NULL, 1536579667);
INSERT INTO `grade_member` VALUES (1690, '室内幼儿班', 44, '大热常规班', 13, 9, '大热篮球俱乐部', 276, '张驰', 'chupa', 307, '/static/default/avatar.png', 1, '', NULL, 1, 1536579667, NULL, 1536579667);
INSERT INTO `grade_member` VALUES (1691, '室内幼儿班', 44, '大热常规班', 13, 9, '大热篮球俱乐部', 275, '张派', 'chupa', 307, '/static/default/avatar.png', 1, '', NULL, 1, 1536579667, NULL, 1536579667);
INSERT INTO `grade_member` VALUES (1692, '室内幼儿班', 44, '大热常规班', 13, 9, '大热篮球俱乐部', 163, '刘凤杰', 'snowy', 170, '/static/default/avatar.png', 1, '', NULL, 1, 1536579667, NULL, 1536579667);
INSERT INTO `grade_member` VALUES (1693, '室内幼儿班', 44, '大热常规班', 13, 9, '大热篮球俱乐部', 257, '欧阳舒轩', '欧阳舒轩', 289, '/static/default/avatar.png', 1, '', NULL, 1, 1536579667, NULL, 1536579667);
INSERT INTO `grade_member` VALUES (1091, '室内周日低年级班', 45, '大热常规班', 13, 9, '大热篮球俱乐部', 263, '秦铭远', '秦铭远', 295, '/static/default/avatar.png', 1, '', NULL, 1, 1533613454, NULL, 1533613454);
INSERT INTO `grade_member` VALUES (857, '鼎太女子班', 46, '大热常规班', 13, 9, '大热篮球俱乐部', 405, '张诗婷', '侯朝歌', 306, '/static/default/avatar.png', 1, '', NULL, 1, 1525764622, NULL, 1525764622);
INSERT INTO `grade_member` VALUES (858, '鼎太女子班', 46, '大热常规班', 13, 9, '大热篮球俱乐部', 406, '辛禹菲', '侯朝歌', 306, '/static/default/avatar.png', 1, '', NULL, 1, 1525764622, NULL, 1525764622);
INSERT INTO `grade_member` VALUES (859, '鼎太女子班', 46, '大热常规班', 13, 9, '大热篮球俱乐部', 274, '侯朝歌', '侯朝歌', 306, '/static/default/avatar.png', 1, '', '20180602学员完成课时毕业', 1, 1525764622, NULL, 1527869408);
INSERT INTO `grade_member` VALUES (860, '鼎太女子班', 46, '大热常规班', 13, 9, '大热篮球俱乐部', 168, '胡宇菲', '休闲的人²⁰¹⁷', 175, '/static/default/avatar.png', 1, '', NULL, 1, 1525764622, NULL, 1525764622);
INSERT INTO `grade_member` VALUES (868, '南小大课间', 65, '430穿梭机', 67, 4, '准行者训练营', 89, '测试1', 'legend', 6, '/static/default/avatar.png', 1, '', NULL, 1, 1526437985, NULL, 1526437985);
INSERT INTO `grade_member` VALUES (1745, '塘朗周六少儿篮球班', 87, '塘朗少儿篮球班', 105, 13, 'AKcross训练营', 598, '吴倍铭', '吴倍鑫', 1301, '/static/default/avatar.png', 1, '', NULL, 1, 1537844784, NULL, 1537844784);
INSERT INTO `grade_member` VALUES (607, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 370, '谢俊棋', 'Icy', 439, '/static/default/avatar.png', 1, '', '20180502学员完成课时毕业', 1, 1524481440, NULL, 1525191008);
INSERT INTO `grade_member` VALUES (608, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 287, ' 潘思达', ' 潘思达', 327, '/static/default/avatar.png', 1, '', '20180602学员完成课时毕业', 1, 1524481440, NULL, 1527869405);
INSERT INTO `grade_member` VALUES (609, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 339, '林城佑', '林城佑', 369, '/static/default/avatar.png', 1, '', NULL, 1, 1524481440, NULL, 1524481440);
INSERT INTO `grade_member` VALUES (610, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 286, '蔡硕勋', '蔡硕勋', 326, '/static/default/avatar.png', 1, '', NULL, 1, 1524481440, NULL, 1524481440);
INSERT INTO `grade_member` VALUES (611, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 202, '陈米洛', '周香香', 240, '/static/default/avatar.png', 1, '', '20180530学员完成课时毕业', 1, 1524481440, NULL, 1527610204);
INSERT INTO `grade_member` VALUES (597, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 290, '郑宏轩', '郑宏轩', 330, '/static/default/avatar.png', 1, '', NULL, 1, 1524481419, NULL, 1524481419);
INSERT INTO `grade_member` VALUES (598, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 411, '郑浩明', '郑浩明', 529, '/static/default/avatar.png', 1, '', NULL, 1, 1524481419, NULL, 1524481419);
INSERT INTO `grade_member` VALUES (297, '松坪小学周日篮球班', 50, '松坪小学', 32, 15, '钟声训练营', 63, '余永康', '余永康', 84, '/static/default/avatar.png', 1, '', NULL, 1, 1514640158, NULL, 1514640158);
INSERT INTO `grade_member` VALUES (298, '松坪小学周日篮球班', 50, '松坪小学', 32, 15, '钟声训练营', 66, '饶宏宇', '饶宏宇', 39, '/static/default/avatar.png', 1, '', NULL, 1, 1514640158, NULL, 1514640158);
INSERT INTO `grade_member` VALUES (299, '松坪小学周日篮球班', 50, '松坪小学', 32, 15, '钟声训练营', 67, '朱涛', '朱涛', 87, '/static/default/avatar.png', 1, '', NULL, 1, 1514640158, NULL, 1514640158);
INSERT INTO `grade_member` VALUES (300, '松坪小学周日篮球班', 50, '松坪小学', 32, 15, '钟声训练营', 76, '张致远', '张致远', 93, '/static/default/avatar.png', 1, '', NULL, 1, 1514640158, NULL, 1514640158);
INSERT INTO `grade_member` VALUES (301, '松坪小学周日篮球班', 50, '松坪小学', 32, 15, '钟声训练营', 77, '王秉政', '王秉政', 94, '/static/default/avatar.png', 1, '', NULL, 1, 1514640158, NULL, 1514640158);
INSERT INTO `grade_member` VALUES (934, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 487, '黄泽坤', '黄泽坤', 1107, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (935, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 460, '罗凯斌', '罗凯斌', 710, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (936, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 427, '孙硕', '行者', 547, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (937, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 396, '刘宇辰', 'lovecheck', 509, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (938, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 305, '唐浩益', '唐浩益', 345, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (939, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 304, '汪昊辰', '汪昊辰', 344, '/static/default/avatar.png', 1, '', '20180913学员完成课时毕业', 4, 1532319419, NULL, 1536768605);
INSERT INTO `grade_member` VALUES (940, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 303, '谢振威', '谢振威', 343, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (322, '塘朗追梦球队班', 47, '塘朗追梦队', 43, 13, 'AKcross训练营', 337, '李炬豪', '李炬豪', 321, '/static/default/avatar.png', 1, '', '20180115学员完成课时毕业', 1, 1515040139, NULL, 1515994163);
INSERT INTO `grade_member` VALUES (323, '塘朗追梦球队班', 47, '塘朗追梦队', 43, 13, 'AKcross训练营', 288, '张梓峰', '张梓峰', 328, '/static/default/avatar.png', 1, '', NULL, 1, 1515040139, NULL, 1515040139);
INSERT INTO `grade_member` VALUES (326, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 312, '郭鑫烨', '郭鑫烨', 352, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515050893, NULL, 1524042592);
INSERT INTO `grade_member` VALUES (327, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 328, '曹俸阁', 'Jim', 37, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515050893, NULL, 1524042592);
INSERT INTO `grade_member` VALUES (328, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 311, '郑楷涛', '郑楷涛', 351, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515050893, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (329, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 310, '黄子轩', '黄子轩', 350, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515050893, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (330, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 309, '李宗杰', '李宗杰', 349, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515050893, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (331, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 308, '周桐圳', '周桐圳', 348, '/static/default/avatar.png', 1, '', NULL, 1, 1515050893, NULL, 1515050893);
INSERT INTO `grade_member` VALUES (332, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 307, '吴子竞', '吴子竞', 347, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515050893, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (333, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 306, '黄逸山', '黄逸山', 346, '/static/default/avatar.png', 1, '', '20180506学员完成课时毕业', 4, 1515050893, NULL, 1525536608);
INSERT INTO `grade_member` VALUES (334, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 94, '赵俊豪', '赵俊豪', 104, '/static/default/avatar.png', 1, '', '20180506学员完成课时毕业', 4, 1515050893, NULL, 1525536608);
INSERT INTO `grade_member` VALUES (335, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 318, '夏宏昆', '夏宏昆', 358, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051149, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (336, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 317, '张帅杰', '张帅杰', 357, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1515051149, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (337, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 316, '李绅楠', '李绅楠', 356, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1515051149, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (338, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 315, '王胜杰', '王胜杰', 355, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1515051149, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (339, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 69, '李泓', 'Li hong', 89, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051149, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (340, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 70, '李小凡', 'lixiaofang', 90, '/static/default/avatar.png', 1, '', '20180506学员完成课时毕业', 4, 1515051149, NULL, 1525536609);
INSERT INTO `grade_member` VALUES (341, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 78, '邓俊伟', '邓俊伟', 95, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1515051149, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (342, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 323, '廖澍堃', '廖澍堃', 363, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051294, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (343, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 322, '凌成', '凌成', 362, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1515051294, NULL, 1525363805);
INSERT INTO `grade_member` VALUES (344, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 321, '孙雨晴', '孙雨晴', 361, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051294, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (345, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 320, '彭鑫', '彭鑫', 360, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051294, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (346, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 319, '徐正庭', '徐正庭', 359, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051294, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (348, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 326, '曹銍轩', '曹銍轩', 366, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1515051631, NULL, 1525363805);
INSERT INTO `grade_member` VALUES (349, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 325, '李弈帆', '李弈帆', 365, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051631, NULL, 1524042592);
INSERT INTO `grade_member` VALUES (350, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 324, '熊昊鹏', '熊昊鹏', 364, '/static/default/avatar.png', 1, '', NULL, 1, 1515051631, NULL, 1515051631);
INSERT INTO `grade_member` VALUES (351, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 329, '李杰', '1234567', 38, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051728, NULL, 1524042592);
INSERT INTO `grade_member` VALUES (352, '南头城小学', 52, '南头城小学', 30, 15, '钟声训练营', 330, '赵俊轩', '赵俊豪', 104, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051728, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (353, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 333, '莫子涵', '莫子涵', 45, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051835, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (354, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 332, '廖文浩', '廖文浩', 44, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051835, NULL, 1524042592);
INSERT INTO `grade_member` VALUES (355, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 63, '余永康', '余永康', 84, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515051957, NULL, 1524040983);
INSERT INTO `grade_member` VALUES (356, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 334, '刘鑫', '2892997867', 85, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515052725, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (357, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 335, '白睿皓', '白睿皓', 99, '/static/default/avatar.png', 1, '', '20180428学员完成课时毕业', 4, 1515053634, NULL, 1524845402);
INSERT INTO `grade_member` VALUES (358, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 331, '吴杰熹', '吴杰熹', 41, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515053634, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (359, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 336, '罗展鹏', 'M00101556', 40, '/static/default/avatar.png', 1, '', '20180428学员完成课时毕业', 4, 1515053754, NULL, 1524845402);
INSERT INTO `grade_member` VALUES (612, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 201, '周润锋', '赵小莉', 239, '/static/default/avatar.png', 1, '', '20180602学员完成课时毕业', 4, 1524481440, NULL, 1527869404);
INSERT INTO `grade_member` VALUES (613, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 198, '孙乐知', '李红', 236, '/static/default/avatar.png', 1, '', NULL, 1, 1524481440, NULL, 1524481440);
INSERT INTO `grade_member` VALUES (614, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 176, '陈逸昕', '昕恩', 191, '/static/default/avatar.png', 1, '', '20180530学员完成课时毕业', 1, 1524481440, NULL, 1527610204);
INSERT INTO `grade_member` VALUES (615, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 175, '陈仕杰', '娟娟', 190, '/static/default/avatar.png', 1, '', NULL, 1, 1524481440, NULL, 1524481440);
INSERT INTO `grade_member` VALUES (616, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 174, '刘羽', '师蓉', 186, '/static/default/avatar.png', 1, '', NULL, 1, 1524481440, NULL, 1524481440);
INSERT INTO `grade_member` VALUES (617, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 160, '田家福', '雪', 166, '/static/default/avatar.png', 1, '', NULL, 1, 1524481440, NULL, 1524481440);
INSERT INTO `grade_member` VALUES (618, '南外周三五班', 36, '南外文华快艇队', 39, 13, 'AKcross训练营', 41, '游逸朗', 'Youboy806', 79, '/static/default/avatar.png', 1, '', NULL, 1, 1524481440, NULL, 1524481440);
INSERT INTO `grade_member` VALUES (572, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 402, '陶承希', '陶承希', 519, '/static/default/avatar.png', 1, '', NULL, 1, 1524481381, NULL, 1524481381);
INSERT INTO `grade_member` VALUES (573, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 338, '朱民皓', 'l朱民皓', 320, '/static/default/avatar.png', 1, '', NULL, 1, 1524481381, NULL, 1524481381);
INSERT INTO `grade_member` VALUES (574, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 290, '郑宏轩', '郑宏轩', 330, '/static/default/avatar.png', 1, '', NULL, 1, 1524481381, NULL, 1524481381);
INSERT INTO `grade_member` VALUES (1744, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 106, '熊天华', '熊天华', 115, '/static/default/avatar.png', 1, '', NULL, 1, 1537512705, NULL, 1537512705);
INSERT INTO `grade_member` VALUES (576, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 288, '张梓峰', '张梓峰', 328, '/static/default/avatar.png', 1, '', NULL, 1, 1524481381, NULL, 1524481381);
INSERT INTO `grade_member` VALUES (577, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 337, '李炬豪', '李炬豪', 321, '/static/default/avatar.png', 1, '', '20180702学员完成课时毕业', 1, 1524481381, NULL, 1530461402);
INSERT INTO `grade_member` VALUES (578, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 281, '彭鼎盛', '金典', 322, '/static/default/avatar.png', 1, '', '20180702学员完成课时毕业', 1, 1524481381, NULL, 1530461403);
INSERT INTO `grade_member` VALUES (579, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 255, '吴浩睿', '吴浩睿', 287, '/static/default/avatar.png', 1, '', '20180702学员完成课时毕业', 4, 1524481381, NULL, 1530461402);
INSERT INTO `grade_member` VALUES (580, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 228, '杜宇轩', '杜宇轩', 260, '/static/default/avatar.png', 1, '', '20180602学员完成课时毕业', 1, 1524481381, NULL, 1527869407);
INSERT INTO `grade_member` VALUES (582, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 190, '何锦宸', '何锦宸', 215, '/static/default/avatar.png', 1, '', NULL, 1, 1524481381, NULL, 1524481381);
INSERT INTO `grade_member` VALUES (605, '塘朗高年级', 49, 'AKcross课程', 38, 13, 'AKcross训练营', 291, '黄得珉', '黄得珉', 331, '/static/default/avatar.png', 1, '', '20180830学员完成课时毕业', 1, 1524481419, NULL, 1535559003);
INSERT INTO `grade_member` VALUES (379, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 314, '陈皇宇', '陈皇宇', 354, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515066580, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (380, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 313, '龙永熙', '龙永熙', 353, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1515066580, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (382, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 13, '邓赖迪', '邓赖迪', 22, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515131136, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (383, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 349, '游简菏', 'M00101482', 68, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515148233, NULL, 1524042339);
INSERT INTO `grade_member` VALUES (384, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 348, '郑梓深', '郑梓深', 47, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515148233, NULL, 1524040986);
INSERT INTO `grade_member` VALUES (385, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 352, '谢梓珊', '谢梓珊', 378, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 1, 1515148233, NULL, 1524042339);
INSERT INTO `grade_member` VALUES (386, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 351, '谢一航', '谢一航', 377, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515148233, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (387, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 350, '凌梓轩', '凌梓轩', 376, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515148233, NULL, 1524042592);
INSERT INTO `grade_member` VALUES (388, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 346, '曾子言', '曾子言曾子瑜', 375, '/static/default/avatar.png', 1, '', '20180428学员完成课时毕业', 4, 1515148233, NULL, 1524845402);
INSERT INTO `grade_member` VALUES (389, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 347, '曾子瑜', '曾子言曾子瑜', 375, '/static/default/avatar.png', 1, '', '20180428学员完成课时毕业', 4, 1515148233, NULL, 1524845402);
INSERT INTO `grade_member` VALUES (390, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 345, '向浚哲', '向浚哲', 374, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515148233, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (391, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 344, '莫钧淇', '莫钧淇', 373, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515148233, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (392, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 342, '杨睿', '杨睿杨馨', 372, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515148233, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (393, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 343, '杨馨', '杨睿杨馨', 372, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515148233, NULL, 1524042593);
INSERT INTO `grade_member` VALUES (394, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 327, '谢诺', '谢诺', 367, '/static/default/avatar.png', 1, '', NULL, 1, 1515171934, NULL, 1515171934);
INSERT INTO `grade_member` VALUES (395, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 66, '饶宏宇', '饶宏宇', 39, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515171934, NULL, 1524042592);
INSERT INTO `grade_member` VALUES (396, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 67, '朱涛', '朱涛', 87, '/static/default/avatar.png', 1, '', '20180418学员完成课时毕业', 4, 1515171934, NULL, 1524040982);
INSERT INTO `grade_member` VALUES (397, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 76, '张致远', '张致远', 93, '/static/default/avatar.png', 1, '', '20180506学员完成课时毕业', 4, 1515171934, NULL, 1525536609);
INSERT INTO `grade_member` VALUES (398, '松坪小学周六班', 53, '松坪小学', 32, 15, '钟声训练营', 77, '王秉政', '王秉政', 94, '/static/default/avatar.png', 1, '', '20180523学员完成课时毕业', 4, 1515171934, NULL, 1527005405);
INSERT INTO `grade_member` VALUES (771, '丽山文体公园高年级班', 55, '大热常规班', 13, 9, '大热篮球俱乐部', 363, '郑德源', '郑宏轩', 330, '/static/default/avatar.png', 1, '', NULL, 1, 1524536476, NULL, 1524536476);
INSERT INTO `grade_member` VALUES (772, '丽山文体公园高年级班', 55, '大热常规班', 13, 9, '大热篮球俱乐部', 361, '许凯瑞', '许凯瑞', 383, '/static/default/avatar.png', 1, '', NULL, 1, 1524536476, NULL, 1524536476);
INSERT INTO `grade_member` VALUES (773, '丽山文体公园高年级班', 55, '大热常规班', 13, 9, '大热篮球俱乐部', 359, '周宇乐', '周宇乐', 395, '/static/default/avatar.png', 1, '', '20180425学员完成课时毕业', 1, 1524536476, NULL, 1524586205);
INSERT INTO `grade_member` VALUES (774, '丽山文体公园高年级班', 55, '大热常规班', 13, 9, '大热篮球俱乐部', 362, '杨宇昊', '杨宇昊', 397, '/static/default/avatar.png', 1, '', '20180425学员完成课时毕业', 1, 1524536476, NULL, 1524586205);
INSERT INTO `grade_member` VALUES (775, '丽山文体公园高年级班', 55, '大热常规班', 13, 9, '大热篮球俱乐部', 364, '刘昊', '刘昊', 398, '/static/default/avatar.png', 1, '', '20180602学员完成课时毕业', 1, 1524536476, NULL, 1527869407);
INSERT INTO `grade_member` VALUES (776, '丽山文体公园高年级班', 55, '大热常规班', 13, 9, '大热篮球俱乐部', 341, '周劲希', '周劲希', 370, '/static/default/avatar.png', 1, '', NULL, 1, 1524536476, NULL, 1524536476);
INSERT INTO `grade_member` VALUES (777, '丽山文体公园高年级班', 55, '大热常规班', 13, 9, '大热篮球俱乐部', 339, '林城佑', '林城佑', 369, '/static/default/avatar.png', 1, '', NULL, 1, 1524536476, NULL, 1524536476);
INSERT INTO `grade_member` VALUES (778, '丽山文体公园高年级班', 55, '大热常规班', 13, 9, '大热篮球俱乐部', 186, '刘子豪', '刘子豪', 211, '/static/default/avatar.png', 1, '', '20180701学员完成课时毕业', 4, 1524536476, NULL, 1530375004);
INSERT INTO `grade_member` VALUES (409, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 365, '邝治嘉', '邝治嘉', 414, '/static/default/avatar.png', 1, '', '20180428学员完成课时毕业', 4, 1515485939, NULL, 1524845402);
INSERT INTO `grade_member` VALUES (410, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 366, '喻梓轩', '喻梓轩', 415, '/static/default/avatar.png', 1, '', '20180504学员完成课时毕业', 4, 1515487083, NULL, 1525363806);
INSERT INTO `grade_member` VALUES (941, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 301, '张正堃', '张正堃', 341, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (1746, '塘朗周六少儿篮球班', 87, '塘朗少儿篮球班', 105, 13, 'AKcross训练营', 597, '吴倍鑫', '吴倍鑫', 1301, '/static/default/avatar.png', 1, '', NULL, 1, 1537844785, NULL, 1537844785);
INSERT INTO `grade_member` VALUES (1083, '周六晚6:30初中班', 59, '大热常规班', 13, 9, '大热篮球俱乐部', 97, '黄嘉荣', 'HANA', 107, '/static/default/avatar.png', 1, '', NULL, 1, 1533613341, NULL, 1533613341);
INSERT INTO `grade_member` VALUES (1084, '周六晚6:30初中班', 59, '大热常规班', 13, 9, '大热篮球俱乐部', 172, '蒙致远', '蒙致远mengzhiyuan', 182, '/static/default/avatar.png', 1, '', NULL, 1, 1533613341, NULL, 1533613341);
INSERT INTO `grade_member` VALUES (1085, '周六晚6:30初中班', 59, '大热常规班', 13, 9, '大热篮球俱乐部', 178, '郑子轩', '13603032922', 201, '/static/default/avatar.png', 1, '', NULL, 1, 1533613341, NULL, 1533613341);
INSERT INTO `grade_member` VALUES (1086, '周六晚6:30初中班', 59, '大热常规班', 13, 9, '大热篮球俱乐部', 220, '汪星辰', '汪星辰', 258, '/static/default/avatar.png', 1, '', NULL, 1, 1533613341, NULL, 1533613341);
INSERT INTO `grade_member` VALUES (1087, '周六晚6:30初中班', 59, '大热常规班', 13, 9, '大热篮球俱乐部', 246, '王廖聪', '王廖聪', 278, '/static/default/avatar.png', 1, '', NULL, 1, 1533613341, NULL, 1533613341);
INSERT INTO `grade_member` VALUES (1714, '初中基础班', 81, '初中基础班', 90, 43, '韵动篮球俱乐部', 442, '叶志弘', '易艳', 667, '/static/default/avatar.png', 1, '', NULL, 1, 1537062242, NULL, 1537062242);
INSERT INTO `grade_member` VALUES (942, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 300, '张鸿宇', '张鸿宇', 340, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (943, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 299, '余浩锋', '余浩锋', 339, '/static/default/avatar.png', 1, '', '20180905学员完成课时毕业', 4, 1532319419, NULL, 1536077402);
INSERT INTO `grade_member` VALUES (944, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 298, '卢新元', '卢新元', 338, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (945, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 297, '叶绍楷 ', '叶绍楷 ', 337, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (1088, '周六晚6:30初中班', 59, '大热常规班', 13, 9, '大热篮球俱乐部', 416, '王禹舒', '王禹舒', 534, '/static/default/avatar.png', 1, '', NULL, 1, 1533613341, NULL, 1533613341);
INSERT INTO `grade_member` VALUES (837, '西丽二小篮球班', 61, 'FIT篮球训练营', 65, 17, 'FIT', 417, '张霆睿', '张霆睿', 538, '/static/default/avatar.png', 1, '', NULL, 1, 1525057030, NULL, 1525057030);
INSERT INTO `grade_member` VALUES (838, '西丽二小篮球班', 61, 'FIT篮球训练营', 65, 17, 'FIT', 418, '刘铠铭', '啊维', 540, '/static/default/avatar.png', 1, '', NULL, 1, 1525057030, NULL, 1525057030);
INSERT INTO `grade_member` VALUES (839, '西丽二小篮球班', 61, 'FIT篮球训练营', 65, 17, 'FIT', 419, '吴钟至永', '吴钟至永', 541, '/static/default/avatar.png', 1, '', NULL, 1, 1525057030, NULL, 1525057030);
INSERT INTO `grade_member` VALUES (840, '西丽二小篮球班', 61, 'FIT篮球训练营', 65, 17, 'FIT', 421, '宋睿杰', '宋睿杰', 542, '/static/default/avatar.png', 1, '', NULL, 1, 1525057030, NULL, 1525057030);
INSERT INTO `grade_member` VALUES (841, '西丽二小篮球班', 61, 'FIT篮球训练营', 65, 17, 'FIT', 422, '庞楷俊', '庞楷俊', 539, '/static/default/avatar.png', 1, '', NULL, 1, 1525057030, NULL, 1525057030);
INSERT INTO `grade_member` VALUES (842, '西丽二小篮球班', 61, 'FIT篮球训练营', 65, 17, 'FIT', 420, '钟旭烜', '吴钟至永', 541, '/static/default/avatar.png', 1, '', NULL, 1, 1525057030, NULL, 1525057030);
INSERT INTO `grade_member` VALUES (843, '西丽二小篮球班', 61, 'FIT篮球训练营', 65, 17, 'FIT', 423, '彭扬', '彭扬', 537, '/static/default/avatar.png', 1, '', NULL, 1, 1525057030, NULL, 1525057030);
INSERT INTO `grade_member` VALUES (1688, '暑期二四六幼儿班', 75, '大热常规班', 13, 9, '大热篮球俱乐部', 481, '张梓奥', '王小小', 735, '/static/default/avatar.png', 1, '', NULL, 1, 1536579620, NULL, 1536579620);
INSERT INTO `grade_member` VALUES (583, '塘朗追梦队', 54, '塘朗追梦队', 43, 13, 'AKcross训练营', 177, '瞿士杰', '梁妹子', 192, '/static/default/avatar.png', 1, '', '20180702学员完成课时毕业', 1, 1524481381, NULL, 1530461403);
INSERT INTO `grade_member` VALUES (863, '20180419测试', 63, '平台示例请勿购买', 37, 4, '准行者训练营', 113, '周鸿一', 'jason', 121, '/static/default/avatar.png', 1, '', NULL, 1, 1526436114, NULL, 1526436114);
INSERT INTO `grade_member` VALUES (864, '20180419测试', 63, '平台示例请勿购买', 37, 4, '准行者训练营', 114, '毛毛', '1234', 122, '/static/default/avatar.png', 1, '', NULL, 1, 1526436114, NULL, 1526436114);
INSERT INTO `grade_member` VALUES (865, '20180419测试', 63, '平台示例请勿购买', 37, 4, '准行者训练营', 183, '大热', 'BINGOZ', 210, '/static/default/avatar.png', 1, '', NULL, 1, 1526436114, NULL, 1526436114);
INSERT INTO `grade_member` VALUES (895, '大课间', 73, '大课间', 87, 9, '大热篮球俱乐部', 409, '测试学员', 'MirandaXian', 14, '/static/default/avatar.png', 1, '', NULL, 1, 1531214089, NULL, 1531214089);
INSERT INTO `grade_member` VALUES (1723, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 452, '王卿宇', '王卿宇', 660, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (1724, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 465, '李鸿宇', '李林', 714, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (1725, '小学基础班', 79, '小学基础班', 92, 43, '韵动篮球俱乐部', 450, '缪雨哲', '缪雨哲', 663, '/static/default/avatar.png', 1, '', NULL, 1, 1537079883, NULL, 1537079883);
INSERT INTO `grade_member` VALUES (1730, '风和日丽幼儿篮球兴趣班', 86, '幼儿篮球兴趣班', 53, 32, '燕子Happy篮球训练营', 595, '马子乔', '笨笨', 1295, '/static/default/avatar.png', 1, '', NULL, 1, 1537164192, NULL, 1537164192);
INSERT INTO `grade_member` VALUES (1731, '风和日丽幼儿篮球兴趣班', 86, '幼儿篮球兴趣班', 53, 32, '燕子Happy篮球训练营', 593, '刘亦遥', '陌上花开', 1293, '/static/default/avatar.png', 1, '', NULL, 1, 1537164192, NULL, 1537164192);
INSERT INTO `grade_member` VALUES (1732, '风和日丽幼儿篮球兴趣班', 86, '幼儿篮球兴趣班', 53, 32, '燕子Happy篮球训练营', 594, '肖骏宇', 'daisy', 1294, '/static/default/avatar.png', 1, '', NULL, 1, 1537164192, NULL, 1537164192);
INSERT INTO `grade_member` VALUES (1733, '风和日丽幼儿篮球兴趣班', 86, '幼儿篮球兴趣班', 53, 32, '燕子Happy篮球训练营', 592, '郑宇轩', '蜗牛', 1291, '/static/default/avatar.png', 1, '', NULL, 1, 1537164192, NULL, 1537164192);
INSERT INTO `grade_member` VALUES (1734, '风和日丽幼儿篮球兴趣班', 86, '幼儿篮球兴趣班', 53, 32, '燕子Happy篮球训练营', 591, '农昊洋', 'Anney', 1292, '/static/default/avatar.png', 1, '', NULL, 1, 1537164192, NULL, 1537164192);
INSERT INTO `grade_member` VALUES (1681, '暑期二四六幼儿班', 75, '大热常规班', 13, 9, '大热篮球俱乐部', 583, '陈傲阳', '枫落长桥', 1273, '/static/default/avatar.png', 1, '', NULL, 1, 1536579620, NULL, 1536579620);
INSERT INTO `grade_member` VALUES (1682, '暑期二四六幼儿班', 75, '大热常规班', 13, 9, '大热篮球俱乐部', 493, '杨宸煦', 'Jenny', 1117, '/static/default/avatar.png', 1, '', NULL, 1, 1536579620, NULL, 1536579620);
INSERT INTO `grade_member` VALUES (1683, '暑期二四六幼儿班', 75, '大热常规班', 13, 9, '大热篮球俱乐部', 11, '陈佳佑', 'yanyan', 33, '/static/default/avatar.png', 1, '', NULL, 1, 1536579620, NULL, 1536579620);
INSERT INTO `grade_member` VALUES (1684, '暑期二四六幼儿班', 75, '大热常规班', 13, 9, '大热篮球俱乐部', 485, '李若竹', 'Jacy', 838, '/static/default/avatar.png', 1, '', NULL, 1, 1536579620, NULL, 1536579620);
INSERT INTO `grade_member` VALUES (1685, '暑期二四六幼儿班', 75, '大热常规班', 13, 9, '大热篮球俱乐部', 484, '黄小龙', 'livermore', 744, '/static/default/avatar.png', 1, '', NULL, 1, 1536579620, NULL, 1536579620);
INSERT INTO `grade_member` VALUES (1686, '暑期二四六幼儿班', 75, '大热常规班', 13, 9, '大热篮球俱乐部', 483, '陆昱成', '敏敏', 740, '/static/default/avatar.png', 1, '', NULL, 1, 1536579620, NULL, 1536579620);
INSERT INTO `grade_member` VALUES (946, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 296, '蒋家轩', '蒋家轩', 336, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (947, '塘朗低年级班', 51, 'AKcross课程', 38, 13, 'AKcross训练营', 187, '孟想', '孟想', 212, '/static/default/avatar.png', 1, '', NULL, 1, 1532319419, NULL, 1532319419);
INSERT INTO `grade_member` VALUES (1687, '暑期二四六幼儿班', 75, '大热常规班', 13, 9, '大热篮球俱乐部', 482, '黄绍航', '小菜', 736, '/static/default/avatar.png', 1, '', NULL, 1, 1536579620, NULL, 1536579620);
INSERT INTO `grade_member` VALUES (978, '一对一私教班', 76, '大热一对一私教班（室内场）', 55, 9, '大热篮球俱乐部', 250, '王北鲲', '王北鲲', 282, '/static/default/avatar.png', 1, '', NULL, 1, 1533026314, NULL, 1533026314);
INSERT INTO `grade_member` VALUES (1291, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 105, '颜若宸', '颜若宸', 114, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1292, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 96, '陈予喆', 'hou1298280', 106, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1293, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 559, '华浩喆', '伍洲', 1132, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1294, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 494, '范相成', '范相成', 1118, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1295, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 495, '赖烨霖', '赖烨霖', 1119, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1296, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 525, '赖煜林', '赖烨霖', 1119, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1297, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 496, '黄梓恒', '黄梓恒', 1120, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1298, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 497, '张勋锴', '张勋锴', 1121, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1299, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 498, '吴煜嵩', '吴煜嵩', 1122, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1300, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 499, '郑乔文', '郑奇峰', 1123, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1301, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 500, '郑乔恩', '郑奇峰', 1123, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1302, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 501, '林炜栋', '林炜栋', 1124, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1303, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 502, '吴昀蔚', '吴昀蔚', 1125, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1304, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 503, '郑佳乐', '郑佳乐', 1126, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1305, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 504, '何小淇', '何小淇', 1127, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1306, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 505, '樊任之', '樊任之', 1128, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1307, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 506, '胡庭瑀', '胡庭瑀', 1129, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1308, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 507, '李晨浠', '李晨浠', 1130, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1309, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 508, '王英杰', '王英杰', 1131, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1310, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 509, '伍洲', '伍洲', 1132, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1311, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 510, '潘品希', '潘品希', 1133, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1312, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 511, '李安', '李安', 1134, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1313, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 512, '蒲于德天', '蒲于德天', 1135, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1314, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 513, '苏渝钧', '苏渝钧', 1136, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1315, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 514, '杨溍濠', '杨溍濠', 1137, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1316, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 515, '寇相坤', '寇相坤', 1138, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1317, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 516, '谭启飏', '谭启飏', 1139, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1318, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 517, '郑梓佳', '郑梓佳', 1140, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1319, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 518, '何沁璇', '何沁璇', 1141, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1320, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 519, '董苇杭', '董苇杭', 1142, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1321, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 520, '李梓杰', '李梓杰', 1143, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1322, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 521, '洪梓涵', '洪梓涵', 1144, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1323, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 522, '张宝木', '张宝木', 1145, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1324, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 523, '范丁夫', '范丁夫', 1146, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1325, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 524, '徐浴莱', '徐浴莱', 1147, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1326, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 526, '杨顺钦', '杨顺钦', 1148, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1327, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 527, '樊锦昊', '樊锦昊', 1149, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1328, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 528, '张皓淏', '张皓淏', 1150, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1329, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 529, '刘思义', '刘思义', 1151, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1330, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 530, '李璟尧', '李璟尧', 1152, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1331, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 531, '崔景棠', '崔景棠', 1153, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1332, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 532, '王璐瑶', '王璐瑶', 1154, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1333, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 533, '程嘉樱', '程嘉樱', 1155, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1334, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 534, '曾子航', '曾子航', 1156, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1335, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 535, '柴懿轩', '柴懿轩', 1157, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1336, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 536, '黎政赫', '黎政赫', 1158, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1337, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 537, '陈力豪', '陈力豪', 1159, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1338, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 538, '朱星宇', '朱星宇', 1160, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1339, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 539, '夏子骞', '夏子骞', 1161, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1340, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 540, '董沛奇', '董沛奇', 1162, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1341, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 541, '杨皓然', '杨皓然', 1163, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1342, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 542, '曹轩瑞', '曹轩瑞', 1164, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1343, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 543, '童文煊', '童文煊', 1165, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1344, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 544, '钟港运', '钟港运', 1166, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1345, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 545, '王思渊', '王思渊', 1167, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1346, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 546, '伍嘉欣', '伍嘉欣', 1168, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1347, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 547, '许正铎', '许正铎', 1169, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1348, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 548, '张奕', '张奕', 1170, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1349, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 549, '肖元颖', '肖元颖', 1171, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1350, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 550, '李佳阳', '李佳阳', 1172, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1351, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 551, '黄冠豪', '黄冠豪', 1173, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1352, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 552, '李米阳', '李米阳', 1174, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1353, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 553, '张想为', '张想为', 1175, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1354, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 554, '关卓熙', '关卓熙', 1176, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1355, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 555, '张津瑞', '张津瑞', 1177, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);
INSERT INTO `grade_member` VALUES (1356, '龙岗民警子女篮球', 77, '龙岗民警子女暑期篮球培训', 88, 9, '大热篮球俱乐部', 556, '罗嘉圳', '罗嘉圳', 1178, '/static/default/avatar.png', 1, '', NULL, 1, 1533893831, NULL, 1533893831);

SET FOREIGN_KEY_CHECKS = 1;
