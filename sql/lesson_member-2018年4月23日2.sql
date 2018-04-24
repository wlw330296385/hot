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

 Date: 24/04/2018 18:07:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lesson_member
-- ----------------------------
DROP TABLE IF EXISTS `lesson_member`;
CREATE TABLE `lesson_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属训练营',
  `student_id` int(10) NOT NULL,
  `student` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对应会员表member',
  `member_id` int(10) NOT NULL COMMENT '对应会员表id',
  `rest_schedule` int(10) NOT NULL DEFAULT 0 COMMENT '剩余课时,0时自动毕业',
  `total_schedule` int(11) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '头像',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '2:体验生|1:正式学生',
  `transfer` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否转课生',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '-1:离营|0:待审核|1:正常|2:退出|3:被开除|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 640 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '课程-会员关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lesson_member
-- ----------------------------
INSERT INTO `lesson_member` VALUES (193, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 111, '蔡佳烨', '6222355892320034', 120, 3, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509985530, NULL, 1524042344);
INSERT INTO `lesson_member` VALUES (194, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 110, '郭懋增', '13662248558', 119, 2, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509970166, NULL, 1524042343);
INSERT INTO `lesson_member` VALUES (195, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 109, '黄子杰', '黄子杰', 118, 14, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1509943739, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (196, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 108, '王瑞翔', '王少华', 117, 3, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509943670, NULL, 1524042347);
INSERT INTO `lesson_member` VALUES (197, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 107, '曾子航', '13670022780', 116, 3, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509871789, NULL, 1524042344);
INSERT INTO `lesson_member` VALUES (198, '大热常规班', 13, 9, '大热篮球俱乐部', 106, '熊天华', '熊天华', 115, 2, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509856196, NULL, 1524042346);
INSERT INTO `lesson_member` VALUES (199, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 105, '颜若宸', '颜若宸', 114, 4, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509845658, NULL, 1524042349);
INSERT INTO `lesson_member` VALUES (200, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 104, '王浩丁', '王浩丁', 113, 15, 30, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509844432, NULL, 1524552236);
INSERT INTO `lesson_member` VALUES (201, '大热常规班', 13, 9, '大热篮球俱乐部', 103, '陈嘉航', 'chenjiahang', 112, 20, 30, '/static/default/avatar.png', 1, 0, '', '', 1, 1509787853, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (202, '大热常规班', 13, 9, '大热篮球俱乐部', 102, '张益凯', '张益凯', 111, 1, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509786985, NULL, 1524042344);
INSERT INTO `lesson_member` VALUES (203, '大热常规班', 13, 9, '大热篮球俱乐部', 100, '关乐耀', '关乐耀', 110, 4, 13, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509784965, NULL, 1524040995);
INSERT INTO `lesson_member` VALUES (204, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 99, '周子祺', 'lily', 109, 9, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1509784749, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (205, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 98, '苏祖威', '061683', 108, 0, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1509783379, NULL, 1524042603);
INSERT INTO `lesson_member` VALUES (206, '大热常规班', 13, 9, '大热篮球俱乐部', 97, '黄嘉荣', 'HANA', 107, 3, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509783164, NULL, 1524042346);
INSERT INTO `lesson_member` VALUES (207, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 96, '陈予喆', 'hou1298280', 106, 15, 30, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509782830, NULL, 1524551709);
INSERT INTO `lesson_member` VALUES (208, '大热常规班', 13, 9, '大热篮球俱乐部', 95, '曾跃阳', '30988232', 105, 7, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509720686, NULL, 1524040993);
INSERT INTO `lesson_member` VALUES (209, '南头城小学', 30, 15, '钟声训练营', 94, '赵俊豪', '赵俊豪', 104, 1, 18, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509703640, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (210, '校园兴趣班', 12, 3, '猴赛雷训练营', 89, '测试1', 'legend', 6, 5, 5, '/static/default/avatar.png', 1, 0, '', '', 1, 1509700436, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (211, '北大附小一年级', 36, 15, '钟声训练营', 93, '张腾月', '腾月', 103, 0, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1509697785, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (212, '石厦学校兰球队', 29, 15, '钟声训练营', 92, '张广涵', '张广涵', 102, 4, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509683459, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (213, '大热常规班', 13, 9, '大热篮球俱乐部', 91, '梁浩峰', 'LIANG', 101, 6, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509619941, NULL, 1524040994);
INSERT INTO `lesson_member` VALUES (214, '大热常规班', 13, 9, '大热篮球俱乐部', 90, '梁浩然', 'LIANG', 101, 5, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1509619809, NULL, 1524042349);
INSERT INTO `lesson_member` VALUES (598, 'FIT', 50, 17, 'FIT', 225, 'Bingo', 'Bingo', 21, 0, 0, '/static/default/avatar.png', 2, 0, '', '', 4, 1519720493, NULL, 1519720918);
INSERT INTO `lesson_member` VALUES (216, '南外文华快艇队', 39, 13, 'AKcross训练营', 86, '李李喆', 'Clement Lee', 100, 14, 48, 'https://wx.qlogo.cn/mmhead/WAibKjHvK5nGwOjqMd7aj2uwibgicK2CyeL73tEGSyCAaTtib8piaFODHRg/0', 1, 0, '', '20180119学员完成课时毕业', 1, 1509433128, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (217, '前海小学', 31, 15, '钟声训练营', 84, '王奕唐', 'Miya', 98, 4, 15, 'https://wx.qlogo.cn/mmhead/FrdAUicrPIibfdwVLEWdXjfszf6JtqbichNGmgX52g519jUT3AkWJkF5A/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509283014, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (218, '石厦学校兰球队', 29, 15, '钟声训练营', 83, '周凯炀', '周浩楠、周宇希、周凯炀', 97, 4, 15, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509272180, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (219, '石厦学校兰球队', 29, 15, '钟声训练营', 82, '周宇希', '周浩楠、周宇希、周凯炀', 97, 3, 15, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509272077, NULL, 1524042336);
INSERT INTO `lesson_member` VALUES (220, '石厦学校兰球队', 29, 15, '钟声训练营', 81, '周浩楠', '周浩楠、周宇希、周凯炀', 97, 3, 15, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509271960, NULL, 1524042336);
INSERT INTO `lesson_member` VALUES (221, '石厦学校兰球队', 29, 15, '钟声训练营', 80, '朱喆熙', '朱喆熙', 96, 4, 15, 'https://wx.qlogo.cn/mmhead/ZqDaDiccbgkhqudKfypGjYLEng5P9JSdNc6WfGichTYDY76OFtrtyiaZg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509271845, NULL, 1524042338);
INSERT INTO `lesson_member` VALUES (222, '石厦学校兰球队', 29, 15, '钟声训练营', 79, '方慧妍', 'FANGHUIYAN', 88, 3, 15, 'https://wx.qlogo.cn/mmhead/bVy2VQVTWzbtVlldXFcWqic1ib9ZZa0fHvPloPhBgA6SCicFgUCfqnibWw/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509254479, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (223, '松坪小学', 32, 15, '钟声训练营', 78, '邓俊伟', '邓俊伟', 95, 2, 15, 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM7fLJDnHuiaObafTXdfngPmhmgU8Oibic4DxUWECOq3RZ5TA/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509246244, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (224, '松坪小学', 32, 15, '钟声训练营', 70, '李小凡', 'lixiaofang', 90, 4, 19, 'https://wx.qlogo.cn/mmhead/Ib5852jAyb860z7fQb9L9kCSb5ZU8QicSwlB0MXFXJxAz3Bqib1iaGpsw/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509237476, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (225, '松坪小学', 32, 15, '钟声训练营', 77, '王秉政', '王秉政', 94, 10, 21, 'https://wx.qlogo.cn/mmhead/sTJptKvBQLLibnLPq727HT4qqfl6GE7YibCk1iaJdbBOM7IpfWgIdROVg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509194924, NULL, 1524040986);
INSERT INTO `lesson_member` VALUES (226, '松坪小学', 32, 15, '钟声训练营', 76, '张致远', '张致远', 93, 6, 16, 'https://wx.qlogo.cn/mmhead/C6nnRGnPbvwxhMnBf6aSBRKAcLpoOuhibqOodQsrO0abWLLVkRQrouQ/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509191189, NULL, 1524040984);
INSERT INTO `lesson_member` VALUES (227, '大热常规班', 13, 9, '大热篮球俱乐部', 75, '薛子豪', '薛子豪', 92, 5, 15, 'https://wx.qlogo.cn/mmhead/78EkX665csCzfpNaaBSvfy1JpmicTLfoh2FtiaNSKK6N5PYicTOeK8wjA/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509180982, NULL, 1524040994);
INSERT INTO `lesson_member` VALUES (228, '平台示例请勿购买', 37, 4, '准行者训练营', 51, '荣', 'wayen', 77, 20, 20, '/0', 1, 0, '', '', 1, 1509176780, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (229, '荣光篮球强化', 25, 5, '荣光训练营', 74, '新学生', 'legend', 6, 15, 17, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, 0, '', '', 1, 1509091585, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (230, '北大附小一年级', 36, 15, '钟声训练营', 73, '侯皓轩', '小苹果', 91, 0, 15, 'https://wx.qlogo.cn/mmhead/wbKdib81ny6ibpPLZicROqqicQ7l1PrrmPwJmSpKrKG0FzztjmkibjApnwQ/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1509086650, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (231, '松坪小学', 32, 15, '钟声训练营', 69, '李泓', 'Li hong', 89, 0, 15, '/static/default/avatar.png', 1, 0, '系统插入,时间2017年10月27日14:16:02', '20180418学员完成课时毕业', 4, 1508947200, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (232, '前海小学', 31, 15, '钟声训练营', 71, '李浚睿', 'Jerry', 75, 5, 23, 'https://wx.qlogo.cn/mmopen/vi_32/7g6icshVrInKsnnzvMpm7jBVXywRsKHnITNpDYTVPXYEWaYh1sDHPRU2z5YIIJdMvNM9HWOPMKyiakHiaibM9lY6sA/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1509079444, NULL, 1524042338);
INSERT INTO `lesson_member` VALUES (233, '北大附小一年级', 36, 15, '钟声训练营', 31, '蒋清奕', '蒋清奕', 65, 0, 15, '/static/default/avatar.png', 1, 0, '系统插入,时间2017年10月27日10:58:40', '20180418学员完成课时毕业', 4, 1508774400, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (234, '松坪小学', 32, 15, '钟声训练营', 67, '朱涛', '朱涛', 87, 0, 0, 'https://wx.qlogo.cn/mmhead/uchmtWQh7iaqm9z1QucKESYwDiasve3glVvHvDEEEvZmEBJrp26SDrcA/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1509009392, NULL, 1524040982);
INSERT INTO `lesson_member` VALUES (235, '松坪小学', 32, 15, '钟声训练营', 66, '饶宏宇', '饶宏宇', 39, 0, 15, 'https://wx.qlogo.cn/mmopen/vi_32/QiaJBRJFj5Xt3S5WluEumvf6C68fm3U1NBVpSlicePadW44QHt3aDljkr1iaYYZDH2LlXibQfFIlp2oNaxX6dHAasg/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1509008230, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (236, '松坪小学', 32, 15, '钟声训练营', 63, '余永康', '余永康', 84, 0, 9, 'https://wx.qlogo.cn/mmopen/vi_32/AvTOBqK5D0azFkS8BVibFucZyG9z9rLicQYL7FkBl6QicS6z4mdNejuvU4Qial8z9wOfInP4anVMAK7sAeoX5A1tOg/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1509006276, NULL, 1524040983);
INSERT INTO `lesson_member` VALUES (237, '北大附小一年级', 36, 15, '钟声训练营', 62, '周子杰', 'rebeccazhangly', 81, 0, 15, 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Dribia5ZQu19qPDlO8LQuwYfbEKvkc4np2NicicpECusbLsAYMLtVn4pT8IcyBibvMnjL6w/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1509001966, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (596, '大热常规班', 13, 9, '大热篮球俱乐部', 374, '何明鸿', '何明鸿', 459, 16, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1519716387, NULL, 1519716387);
INSERT INTO `lesson_member` VALUES (597, '大热常规班', 13, 9, '大热篮球俱乐部', 394, '何雨辰', '向蓓', 506, 12, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1519717248, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (239, '石厦学校兰球队', 29, 15, '钟声训练营', 40, '陈昊阳', 'cjwcyc', 76, 4, 15, 'https://wx.qlogo.cn/mmopen/vi_32/GCNUn1n4CPiaMuVncIvb0u3mCyCNIYOQmjMVuSx5SrGOPe94lWMticoCRn3G2qry302FPPTkcichHEpKrzwIb1TrA/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508989728, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (240, '前海小学', 31, 15, '钟声训练营', 57, '梁懿', '梁懿', 83, 2, 15, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIZILv4jZfYyLDTSDRic2TicWv1Lqsy7ibgV1LK3PiaycF11vJQ2Ud4PrDa0XvcQEhdaEAEkb2feNbtCQ/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508986588, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (241, '北大附小一年级', 36, 15, '钟声训练营', 56, '姚定希', '姚定希', 86, 0, 15, 'https://wx.qlogo.cn/mmhead/BfRL3E0G1pdy5s3m2OtzHEbJ0tv6PFPzUu34m3zQ3XzzmlMkMgGMOg/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1508986351, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (242, '荣光篮球强化', 25, 5, '荣光训练营', 52, '苏楠楠', 'legend', 6, 0, 2, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1508985553, NULL, 1524040998);
INSERT INTO `lesson_member` VALUES (243, '北大附小一年级', 36, 15, '钟声训练营', 43, '邓粤天', '13927482132', 82, 0, 15, 'https://wx.qlogo.cn/mmhead/jJSbu4Te5ib9GgS8EBYzj9DGPl5G68qqDVadUWdDKYdNwEibDBUlFaPA/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1508850519, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (244, '高年级班', 13, 9, '大热篮球俱乐部', 42, '陈宛杭', 'kiko', 80, 0, 7, 'https://wx.qlogo.cn/mmopen/vi_32/zocbwtq7yDlo6zSBZ0jmSgpaHaFWmAotUTmzHopaB1Vl8DVWP9Gdd7U37xhdUkg30Z6HE6BzIBKGqEJBRDQOLA/0', 1, 0, '', '', 2, 1508849731, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (245, '南外文华快艇队', 39, 13, 'AKcross训练营', 41, '游逸朗', 'Youboy806', 79, 2, 33, 'https://wx.qlogo.cn/mmopen/vi_32/LMPP1EaHUlWoor4A7ibKMl1XM80TcezRI5GgwThYwOHPybVktqd8QicgtYr8svs4LPxP0bmSpszQtricUuCGPtuFg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508831426, NULL, 1524040989);
INSERT INTO `lesson_member` VALUES (246, '前海小学', 31, 15, '钟声训练营', 39, '饶滨', '饶滨', 58, 1, 15, 'https://wx.qlogo.cn/mmopen/vi_32/3q4wOibh9nZPekaEh1mPpULmJARKuuXRphK7Mak1kTjCNNIibNEjNicoEVtmJLT9G7kjoNZ6vllcLteP8vibyXiaj0A/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508770993, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (247, '北大附小一年级', 36, 15, '钟声训练营', 38, '林需睦', '13823181560', 74, 0, 15, 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqicTFZcNkXiaVqLpNeiapVYiaItQ1hGcic0s9BCKqx2aDYVMSD9KNkhuVmtZyvCXASgk1I6jH9LbMw4HQ/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1508766362, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (248, '前海小学', 31, 15, '钟声训练营', 36, '邱仁鹏', 'SZQIUJB', 73, 24, 41, 'https://wx.qlogo.cn/mmopen/vi_32/oBJMukfMx9mAfOFLL6oILN4zz1F39lUDnibK34DTlPq3YUq2P7gWk4muj1cDFKMQLlN5ypREzibVJO4yKSEUK62w/0', 1, 0, '', '', 1, 1508766196, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (249, '前海小学', 31, 15, '钟声训练营', 35, '万宇宸', '万宇宸', 61, 6, 18, 'https://wx.qlogo.cn/mmopen/vi_32/pnKFC33CDdnArcQ0ONDFVdlQ1yF6aewh99xgKW3G72iaruRr1oGTIwV8gfpfptb4VpBdicrZ9pJLwpib50cYrfVVw/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508737748, NULL, 1524042340);
INSERT INTO `lesson_member` VALUES (250, '北大附小一年级', 36, 15, '钟声训练营', 34, '刘一凡', 'gaojun', 67, 4, 15, 'https://wx.qlogo.cn/mmopen/vi_32/x7dO3qq2JzUkwK79rS0ZmwrnficUG7mB9bAUOQ7lB52dY5uhUMgBFPQoAsY5w1LWrzYwDROVSKrYoqmq6qgYrcg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508735154, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (251, '北大附小一年级', 36, 15, '钟声训练营', 33, '梁峻玮', '20101119', 66, 1, 15, 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Du6wQajIibtJa0SkWurB9LkfK1vR4BQiaZ14GnibibNdUdOG0iaQlVvcthLcx7Qf0mKBBLw/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508732407, NULL, 1524042336);
INSERT INTO `lesson_member` VALUES (252, '北大附小一年级', 36, 15, '钟声训练营', 30, '黄子诺', 'leonhuang', 63, 1, 15, 'https://wx.qlogo.cn/mmopen/vi_32/PH3lR9dDe7o1dzyQIgkpkLhkOchMTwEEqQ3TI2oKPmxGNOKbgicYAV4wORoMLw2NGBaNDjVMv8x38BjJRibThTzg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508730453, NULL, 1524042336);
INSERT INTO `lesson_member` VALUES (253, '前海小学', 31, 15, '钟声训练营', 29, '刘宇恒', '刘宇恒', 62, 8, 21, 'https://wx.qlogo.cn/mmopen/vi_32/dg5BzBbk6ialKxBfoWtI9iayIQS6b5pG0QF1ib4YiauZics9fBRksgtWibAcHYEGiaJbjOR4W0jOgGJIb6LAwiapjEkkbg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508729343, NULL, 1524040985);
INSERT INTO `lesson_member` VALUES (254, '前海小学', 31, 15, '钟声训练营', 28, '王钰龙', '王钰龙', 60, 14, 30, 'https://wx.qlogo.cn/mmopen/vi_32/mpqiaCLKTSkHXZbs2GqFnjoflrkMib2j49z5yM8VHDmmUSicHZI5iak2Tia6ykX7tXT8TOBYB2v9UaYmnJ99Z0FCO0g/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508726144, NULL, 1524040986);
INSERT INTO `lesson_member` VALUES (255, '石厦学校兰球队', 29, 15, '钟声训练营', 27, '张毓楠', '张毓楠', 50, 1, 15, 'https://wx.qlogo.cn/mmopen/vi_32/ywnQfcMqe2uC9KP2fDr6QorLMk8FFkIL3IUpfJn7D8707CEIfcUwLEOLGf85A0C9bY4a29ZkcfkGa3RwSKoMbw/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508726076, NULL, 1524042336);
INSERT INTO `lesson_member` VALUES (256, '前海小学', 31, 15, '钟声训练营', 26, '李语辰', '李语辰', 46, 11, 24, 'https://wx.qlogo.cn/mmopen/vi_32/JVWE6PQ990A8KoicXXxCEzKP2trTcWSkBsW16ibaYbTZHSTA4mOy410wA2u9uuxUB0FiavLiaBkicKCp9icc9Rgry7HQ/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508725787, NULL, 1524040986);
INSERT INTO `lesson_member` VALUES (257, '前海小学', 31, 15, '钟声训练营', 25, '战奕名', '战奕名', 51, 0, -16, 'https://wx.qlogo.cn/mmopen/vi_32/v4IpFsmBcCwGN9D1SzfmfahDia8p8l3saE3DbWnmOY2HCClXCmfibzzw3H3hcnbXAAkcwQH6icJxiabSc03HnXSLlA/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1508724642, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (258, '前海小学', 31, 15, '钟声训练营', 21, '陈高翔', '陈高翔', 59, 3, 15, 'https://wx.qlogo.cn/mmopen/vi_32/yzvxOetibI0IK3Jjwxb8AhFLpiaf8sEqjkhPwXgtr0JRXWJNIVDBvT6QjblpFABBKGCvGryia5xz20zwzEg5BZ6dg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508723329, NULL, 1524042338);
INSERT INTO `lesson_member` VALUES (259, '前海小学', 31, 15, '钟声训练营', 22, '郑皓畅', '郑皓畅', 56, 13, 31, 'https://wx.qlogo.cn/mmopen/vi_32/6zNQeeicR57x1lcicY9mgX2MBCibf3OkicIKIvEcq1Ec7ibFPRFkEtg8nKeBoiaNfrwoGmvu9Wt5BWo9HicxroYqjRZsw/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508723297, NULL, 1524040985);
INSERT INTO `lesson_member` VALUES (260, '前海小学', 31, 15, '钟声训练营', 20, '唐轩衡', '唐轩衡', 55, 7, 21, 'https://wx.qlogo.cn/mmopen/vi_32/VVyUyM6Q3vHB0kvA47iafepgr2L2vx8nvxzeSIKqJQLGz6qA9RWloXBmvCic1r4pD1chaLOLck0y4r3aibFmEE1YQ/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508676522, NULL, 1524040986);
INSERT INTO `lesson_member` VALUES (261, '石厦学校兰球队', 29, 15, '钟声训练营', 19, '吴师隽', '吴师隽', 52, 4, 15, 'https://wx.qlogo.cn/mmopen/vi_32/NYp0qdFEpicQ36DW8ZpibPCSVAf3NSCNJgwbgKerkcXV3wlXwUdn0XfgBf26eIZ4tqibxT5ScU6el8A1bouRwibcJg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508661866, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (262, '石厦学校兰球队', 29, 15, '钟声训练营', 18, '黄浩', '黄浩', 49, 0, 15, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIn1c0h4Xcn8dISicib3c5qRUsmhvibqvQMY7q3qFUSVw36nw1XW7GEQx1nVkkWQyEyGbtr6JMuBOfyg/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1508658059, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (263, '前海小学', 31, 15, '钟声训练营', 17, '郑肖杰', '郑肖杰', 48, 0, 15, 'https://wx.qlogo.cn/mmopen/vi_32/8B6CScn6mZribr9bTI1RhDEiaQvCtKUKp9BmL1VLoamZWKFF3mHqfOOw2zN5gOIFCBpwsycFWFnr6SulEH2hRLBA/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1508639991, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (264, '前海小学', 31, 15, '钟声训练营', 16, '李润弘', '李润弘', 42, 0, 15, 'https://wx.qlogo.cn/mmopen/vi_32/icD3j8Uhe4xOLJS1zichGLY3rfpJAI4Efd95vMQxlBhSABPWicw4tOHsyY2rnPVAFDbAohTvsMAxoLIo49bA33Z1g/0', 1, 0, '', '20180418学员完成课时毕业', 4, 1508554789, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (265, '前海小学', 31, 15, '钟声训练营', 15, '陈润宏', '陈润宏', 43, 2, 19, 'https://wx.qlogo.cn/mmopen/vi_32/wCFb3b7CBRJSuXQazfF7N0GIfuhF53JRlkVEq2Z2pUgIMraJI2iaWwCONHk7nkJibrUQiaEyU8yrPxianhMIyuArdg/0', 1, 0, '', '20180418学员完成课时毕业', 1, 1508554704, NULL, 1524042337);
INSERT INTO `lesson_member` VALUES (266, '校园兴趣班', 12, 3, '猴赛雷训练营', 2, '陈小准', 'legend', 6, 20, 20, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, 0, '', '', 1, 1508489473, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (490, 'AKcross课程', 38, 13, 'AKcross训练营', 296, '蒋家轩', '蒋家轩', 336, 3, 13, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515037430, NULL, 1524042343);
INSERT INTO `lesson_member` VALUES (491, 'AKcross课程', 38, 13, 'AKcross训练营', 297, '叶绍楷 ', '叶绍楷 ', 337, 3, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515037457, NULL, 1524042342);
INSERT INTO `lesson_member` VALUES (489, 'AKcross课程', 38, 13, 'AKcross训练营', 295, '方晋弛', '方晋弛', 335, 2, 2, '/static/default/avatar.png', 1, 0, '', '', 1, 1515037403, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (269, '前海小学', 31, 15, '钟声训练营', 14, '陈承铭', '陈承铭', 26, 0, 15, '/static/default/avatar.png', 1, 0, '系统插入,时间2017年10月18日17:40:19', '20180418学员完成课时毕业', 4, 1508318976, NULL, 1524042591);
INSERT INTO `lesson_member` VALUES (270, '前海小学', 31, 15, '钟声训练营', 13, '邓赖迪', '邓赖迪', 22, 0, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1508242055, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (271, '超级射手班', 6, 4, '准行者训练营', 11, '陈佳佑', 'yanyan', 33, 0, 0, '/static/default/avatar.png', 1, 0, '', '', 4, 1508207328, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (272, '大热高级班', 13, 9, '大热篮球俱乐部', 9, '罗翔宇', '罗翔宇', 25, 17, 30, '/static/default/avatar.png', 1, 0, '系统插入', '', 1, 1508141658, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (273, '大热高级班', 13, 9, '大热篮球俱乐部', 8, '钟欣志', '钟欣志', 23, 0, 15, '/static/default/avatar.png', 1, 0, '系统插入', '20180418学员完成课时毕业', 4, 1508141658, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (488, 'AKcross课程', 38, 13, 'AKcross训练营', 294, '郑兆彤', '郑兆彤', 334, 2, 2, '/static/default/avatar.png', 1, 0, '', '', 1, 1515037011, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (487, 'AKcross课程', 38, 13, 'AKcross训练营', 293, '郑竣丰', '郑竣丰', 333, 10, 21, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515036972, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (277, '周日北头高年级初中班', 13, 9, '大热篮球俱乐部', 5, '张晨儒', '13537781797', 15, 30, 48, '/static/default/avatar.png', 1, 0, '', '', 1, 1507728830, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (278, '校园兴趣班', 12, 3, '猴赛雷训练营', 4, '小霖', 'weilin666', 4, 10, 10, '/static/default/avatar.png', 1, 0, '', '', 1, 1507630199, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (600, 'AKcross课程', 38, 13, 'AKcross训练营', 395, '郑嘉俊', 'Kafai', 508, 10, 17, '/static/default/avatar.png', 1, 0, '', '', 1, 1520060950, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (486, 'AKcross课程', 38, 13, 'AKcross训练营', 292, '郑竣隆', '郑竣隆', 332, 31, 42, '/static/default/avatar.png', 1, 0, '', '', 1, 1515036948, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (485, 'AKcross课程', 38, 13, 'AKcross训练营', 291, '黄得珉', '黄得珉', 331, 7, 18, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515036926, NULL, 1524040989);
INSERT INTO `lesson_member` VALUES (484, '塘朗追梦队', 43, 13, 'AKcross训练营', 290, '郑宏轩', '郑宏轩', 330, 4, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515036903, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (483, '塘朗追梦队', 43, 13, 'AKcross训练营', 289, '汤镕章', '汤镕章', 329, 3, 8, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515036868, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (482, '塘朗追梦队', 43, 13, 'AKcross训练营', 288, '张梓峰', '张梓峰', 328, 21, 36, '/static/default/avatar.png', 1, 0, '', '20180111:总课时购买32节课+4节赠课', 1, 1515036835, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (289, '平台示例请勿购买', 37, 4, '准行者训练营', 113, '周鸿一', 'jason', 121, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1510044582, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (290, '平台示例请勿购买', 37, 4, '准行者训练营', 114, '毛毛', '1234', 122, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1510044746, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (291, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 115, '王孝煊', '065385', 123, 14, 30, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510059638, NULL, 1524040998);
INSERT INTO `lesson_member` VALUES (292, '平台示例请勿购买', 37, 4, '准行者训练营', 12, '娟', 'HoChen', 1, 0, 0, '/static/default/avatar.png', 1, 0, '', '', 4, 1510100359, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (293, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 118, '邵冠霖', '6222024000065498186', 126, 5, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510116547, NULL, 1524042348);
INSERT INTO `lesson_member` VALUES (294, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 119, '杨涵', '6222024000065498186', 126, 3, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510116664, NULL, 1524042344);
INSERT INTO `lesson_member` VALUES (295, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 116, '黄俊豪', '黄俊豪', 124, 11, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1510117401, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (296, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 120, '关楠萧', '王少华', 117, 0, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1510191105, NULL, 1524042604);
INSERT INTO `lesson_member` VALUES (297, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 121, '袁帅', '6222024000065498186', 126, 8, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1510369090, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (298, '荣光篮球强化（测试）', 25, 5, '荣光训练营', 4, '小霖', 'weilin666', 4, 3, 3, '/static/default/avatar.png', 1, 0, '', '', 1, 1510380785, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (299, 'AKcross课程', 38, 13, 'AKcross训练营', 4, '小霖', 'weilin666', 4, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1510388218, 1515050443, 1510388218);
INSERT INTO `lesson_member` VALUES (300, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 122, '张旺鹏', '军歌', 128, 9, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510388668, NULL, 1524040991);
INSERT INTO `lesson_member` VALUES (301, '龙岗民警子女篮球课程', 15, 9, '大热篮球俱乐部', 117, '李鸣轩', '13825243733', 125, -9, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1510388877, NULL, 1524042597);
INSERT INTO `lesson_member` VALUES (302, '超级射手［海岸城站］', 1, 3, '猴赛雷训练营', 1, 'HoChen', 'HoChen', 1, 0, 0, '/static/default/avatar.png', 1, 0, '', '', 4, 1510391569, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (303, '大热常规班', 13, 9, '大热篮球俱乐部', 123, '刘俊霖', '红茶????', 129, 11, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1510393607, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (305, '超级射手［海岸城站］', 1, 3, '猴赛雷训练营', 6, 'legend', 'legend', 6, 0, 0, '/static/default/avatar.png', 1, 0, '', '', 4, 1510653206, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (306, '大热常规班', 13, 9, '大热篮球俱乐部', 124, '江晨', '锦华', 130, 4, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510671523, NULL, 1524042347);
INSERT INTO `lesson_member` VALUES (307, '大热常规班', 13, 9, '大热篮球俱乐部', 129, '饶鹏轩', 'bemyself', 135, 0, 9, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1510819362, NULL, 1524040992);
INSERT INTO `lesson_member` VALUES (308, '大热常规班', 13, 9, '大热篮球俱乐部', 136, '卢宇璠', '卢盛良', 142, 32, 45, '/static/default/avatar.png', 1, 0, '', '20180312学员完成课时毕业', 1, 1510825439, NULL, 1520788203);
INSERT INTO `lesson_member` VALUES (313, '大热常规班', 13, 9, '大热篮球俱乐部', 134, '袁梓钦', '袁梓钦YZQ', 140, 1, 11, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510890307, NULL, 1524042345);
INSERT INTO `lesson_member` VALUES (314, '大热常规班', 13, 9, '大热篮球俱乐部', 135, '林嘉豪', '鲁秋娟¹⁵⁹²⁰⁰⁸⁵⁹⁶⁰', 141, -15, -13, '/static/default/avatar.png', 1, 0, '', '20180108学员完成课时毕业', 4, 1510890324, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (315, '大热常规班', 13, 9, '大热篮球俱乐部', 133, '杨灿', '杨灿13662559960', 139, 2, 4, '/static/default/avatar.png', 1, 0, '', '', 1, 1510890344, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (316, '大热常规班', 13, 9, '大热篮球俱乐部', 127, '吴奇朗', '晨曦', 133, 14, 22, '/static/default/avatar.png', 1, 0, '', '20180330学员完成课时毕业', 1, 1510890357, NULL, 1522343405);
INSERT INTO `lesson_member` VALUES (317, '大热常规班', 13, 9, '大热篮球俱乐部', 141, '张哲栋', '静', 147, 0, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1510890372, NULL, 1524042604);
INSERT INTO `lesson_member` VALUES (318, '大热常规班', 13, 9, '大热篮球俱乐部', 137, '谢睿轩', '谢睿轩Ryan', 143, 10, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1510890389, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (319, '大热常规班', 13, 9, '大热篮球俱乐部', 138, '钟铭楷', '丹佛儿', 144, 13, 19, '/static/default/avatar.png', 1, 0, '', '20180110学员完成课时毕业', 1, 1510890406, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (320, '大热常规班', 13, 9, '大热篮球俱乐部', 128, '刘进哲', '刘欣洋', 134, 12, 20, '/static/default/avatar.png', 1, 0, '', '20180110学员完成课时毕业', 1, 1510891561, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (321, '大热常规班', 13, 9, '大热篮球俱乐部', 139, '毕宸君', 'Taily', 145, 5, 17, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510892291, NULL, 1524042350);
INSERT INTO `lesson_member` VALUES (323, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 147, '杨耀斌', 'Yrb801129', 153, 7, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510919368, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (324, '大热常规班', 13, 9, '大热篮球俱乐部', 153, '文经纬', 'Lisa Lee(李建平)', 159, 2, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1510996699, NULL, 1524042344);
INSERT INTO `lesson_member` VALUES (325, '南外文华快艇队', 39, 13, 'AKcross训练营', 160, '田家福', '雪', 166, -1, 18, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1511073367, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (326, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 165, '骆九宇', 'luojiuyu', 172, 6, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511228103, NULL, 1524040998);
INSERT INTO `lesson_member` VALUES (327, '大热常规班', 13, 9, '大热篮球俱乐部', 145, '欧阳宇航', '欧阳宇航的外公', 151, 7, 19, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511247036, NULL, 1524040995);
INSERT INTO `lesson_member` VALUES (328, '大热常规班', 13, 9, '大热篮球俱乐部', 150, '吴宇昊', 'victor', 156, 2, 3, '/static/default/avatar.png', 1, 0, '', '', 1, 1511247071, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (329, '大热常规班', 13, 9, '大热篮球俱乐部', 130, '李正昊', '18923856665', 136, 36, 43, '/static/default/avatar.png', 1, 0, '', '', 1, 1511247150, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (330, '大热常规班', 13, 9, '大热篮球俱乐部', 131, '吴靖宇', '吴靖宇wjy', 137, 28, 34, '/static/default/avatar.png', 1, 0, '', '20180108学员完成课时毕业', 1, 1511247811, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (331, '大热常规班', 13, 9, '大热篮球俱乐部', 161, '黄子骞', 'huangzq', 168, 7, 19, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511247853, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (332, '大热常规班', 13, 9, '大热篮球俱乐部', 154, '赖德瑞', '张春丽＆', 160, 8, 16, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511247962, NULL, 1524040998);
INSERT INTO `lesson_member` VALUES (333, '大热常规班', 13, 9, '大热篮球俱乐部', 156, '唐愈翔', '龙船????唐力', 162, 14, 14, '/static/default/avatar.png', 1, 0, '', '', 1, 1511247988, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (334, '大热常规班', 13, 9, '大热篮球俱乐部', 157, '刘秉松', 'yolanda传奇', 163, 4, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511248038, NULL, 1524042348);
INSERT INTO `lesson_member` VALUES (335, '大热常规班', 13, 9, '大热篮球俱乐部', 158, '周尹木', 'zhouyinmu', 164, 12, 18, '/static/default/avatar.png', 1, 0, '', '20171227学员完成课时毕业', 1, 1511248068, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (336, '大热常规班', 13, 9, '大热篮球俱乐部', 159, '蓝炫皓', '飘', 165, 10, 10, '/static/default/avatar.png', 1, 0, '', '', 1, 1511248133, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (337, '大热常规班', 13, 9, '大热篮球俱乐部', 155, '李祖帆', '浪花', 161, 15, 20, '/static/default/avatar.png', 1, 0, '', '20180113学员完成课时毕业', 1, 1511248207, NULL, 1515846761);
INSERT INTO `lesson_member` VALUES (338, '大热常规班', 13, 9, '大热篮球俱乐部', 125, '刘政翰', 'Dorothy', 131, 11, 26, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511248240, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (339, '大热常规班', 13, 9, '大热篮球俱乐部', 146, '林子骞', 'Jack123', 152, 32, 44, '/static/default/avatar.png', 1, 0, '', '20180326学员完成课时毕业', 1, 1511248283, NULL, 1521997803);
INSERT INTO `lesson_member` VALUES (340, '大热常规班', 13, 9, '大热篮球俱乐部', 151, '刘庭彦', '19782174', 157, 3, 13, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511248707, NULL, 1524042348);
INSERT INTO `lesson_member` VALUES (341, '大热常规班', 13, 9, '大热篮球俱乐部', 168, '胡宇菲', '休闲的人²⁰¹⁷', 175, 16, 25, '/static/default/avatar.png', 1, 0, '', '', 1, 1511335243, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (342, '大热常规班', 13, 9, '大热篮球俱乐部', 166, '陈智斌', '????✨Mandy*????', 173, 11, 18, '/static/default/avatar.png', 1, 0, '', '', 1, 1511335795, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (343, '大热常规班', 13, 9, '大热篮球俱乐部', 132, '梁思诚', '听海', 138, 2, 9, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511336015, NULL, 1524042345);
INSERT INTO `lesson_member` VALUES (344, '大热常规班', 13, 9, '大热篮球俱乐部', 167, '黄川越', 'hcyhcy', 174, 11, 14, '/static/default/avatar.png', 1, 0, '', '', 1, 1511336112, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (345, '大热常规班', 13, 9, '大热篮球俱乐部', 169, '吴贻然', 'ൠ杨ྉ子ྉൠ', 176, 14, 24, '/static/default/avatar.png', 1, 0, '', '20180330学员完成课时毕业', 1, 1511339255, NULL, 1522343405);
INSERT INTO `lesson_member` VALUES (346, '大热常规班', 13, 9, '大热篮球俱乐部', 170, '黄之麓', '黄之麓666', 177, 0, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1511339402, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (347, '大热常规班', 13, 9, '大热篮球俱乐部', 171, '李闻韬', 'liwentao', 178, 12, 30, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511342456, NULL, 1524040997);
INSERT INTO `lesson_member` VALUES (348, '大热常规班', 13, 9, '大热篮球俱乐部', 164, '林弋骁', 'Lynch', 171, 4, 12, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511343443, NULL, 1524040994);
INSERT INTO `lesson_member` VALUES (349, '荣光篮球强化（测试）', 25, 5, '荣光训练营', 89, '测试1', 'legend', 6, 5, 7, '/static/default/avatar.png', 1, 0, '', '', 1, 1511504768, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (350, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 152, '刘永锋', '风格独特见解', 158, 11, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1511579302, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (351, '大热常规班', 13, 9, '大热篮球俱乐部', 172, '蒙致远', '蒙致远mengzhiyuan', 182, 6, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511678308, NULL, 1524040994);
INSERT INTO `lesson_member` VALUES (352, '大热常规班', 13, 9, '大热篮球俱乐部', 173, '柯艾锐', '艾望承', 183, 24, 36, '/static/default/avatar.png', 1, 0, '', '20180108学员完成课时毕业', 1, 1511921783, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (353, '南外文华快艇队', 39, 13, 'AKcross训练营', 174, '刘羽', '师蓉', 186, 8, 18, '/static/default/avatar.png', 1, 0, '', '', 1, 1511929149, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (354, '南外文华快艇队', 39, 13, 'AKcross训练营', 175, '陈仕杰', '娟娟', 190, 10, 17, '/static/default/avatar.png', 1, 0, '', '', 1, 1511943480, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (355, '南外文华快艇队', 39, 13, 'AKcross训练营', 176, '陈逸昕', '昕恩', 191, 9, 33, '/static/default/avatar.png', 1, 0, '', '20180328学员完成课时毕业', 1, 1511945507, NULL, 1522170603);
INSERT INTO `lesson_member` VALUES (356, '塘朗追梦队', 43, 13, 'AKcross训练营', 177, '瞿士杰', '梁妹子', 192, 14, 32, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1511957794, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (357, '大热常规班', 13, 9, '大热篮球俱乐部', 178, '郑子轩', '13603032922', 201, 9, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1512095904, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (358, '大热常规班', 13, 9, '大热篮球俱乐部', 179, '杨熙', '杨熙', 207, 7, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1512270106, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (480, '塘朗追梦队', 43, 13, 'AKcross训练营', 337, '李炬豪', '李炬豪', 321, 0, 29, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515036750, NULL, 1524042340);
INSERT INTO `lesson_member` VALUES (361, '平台示例请勿购买', 37, 4, '准行者训练营', 183, '大热', 'BINGOZ', 210, 0, 0, '/static/default/avatar.png', 1, 0, '', '', 4, 1512722111, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (362, '平台示例请勿购买', 37, 4, '准行者训练营', 184, '大热1', 'BINGOZ', 210, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1512722588, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (364, '大热常规班', 13, 9, '大热篮球俱乐部', 186, '刘子豪', '刘子豪', 211, 4, 16, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1512734994, NULL, 1524042348);
INSERT INTO `lesson_member` VALUES (365, 'AKcross课程', 38, 13, 'AKcross训练营', 187, '孟想', '孟想', 212, 9, 16, '/static/default/avatar.png', 1, 0, '', '20180124:教练说录课有错信息，人工操作剩余课时+1', 1, 1512887691, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (478, '南外文华快艇队', 39, 13, 'AKcross训练营', 286, '蔡硕勋', '蔡硕勋', 326, 10, 24, '/static/default/avatar.png', 1, 0, '', '20180321学员完成课时毕业', 1, 1515036596, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (477, 'AKcross课程', 38, 13, 'AKcross训练营', 285, '谢俊棋', '谢俊棋', 325, 0, 0, '/static/default/avatar.png', 1, 0, '', '20180124:控制台添加学员手机号输入错误,删除此记录', 4, 1515036042, 1516763329, 1515644533);
INSERT INTO `lesson_member` VALUES (368, '大热常规班', 13, 9, '大热篮球俱乐部', 189, '洪新铠', '洪新铠', 214, 27, 31, '/static/default/avatar.png', 1, 0, '', '', 1, 1513053397, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (369, '塘朗追梦队', 43, 13, 'AKcross训练营', 190, '何锦宸', '何锦宸', 215, 8, 32, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513059123, NULL, 1524042342);
INSERT INTO `lesson_member` VALUES (476, '大热常规班', 13, 9, '大热篮球俱乐部', 284, '朱涛', '黎彬', 324, 12, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1514950903, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (371, '大热常规班', 13, 9, '大热篮球俱乐部', 192, '蒋成栋', '蒋成栋', 230, 13, 17, '/static/default/avatar.png', 1, 0, '', '', 1, 1513399087, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (372, '大热常规班', 13, 9, '大热篮球俱乐部', 193, '王国宇', '可心', 231, 28, 38, '/static/default/avatar.png', 1, 0, '', '', 1, 1513412668, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (373, '大热常规班', 13, 9, '大热篮球俱乐部', 194, '王昱泽', '王剑平', 232, 6, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513495704, NULL, 1524040997);
INSERT INTO `lesson_member` VALUES (374, '大热常规班', 13, 9, '大热篮球俱乐部', 195, '牛子儒', '蓝天白云', 233, 3, 11, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513553778, NULL, 1524042348);
INSERT INTO `lesson_member` VALUES (375, '塘朗追梦队', 43, 13, 'AKcross训练营', 196, '郑明宇', '郑伟军', 234, 14, 38, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513565032, NULL, 1524040989);
INSERT INTO `lesson_member` VALUES (376, '大热常规班', 13, 9, '大热篮球俱乐部', 197, '谭晟中', '谭晟中谭正中', 235, 3, 8, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513567576, NULL, 1524040991);
INSERT INTO `lesson_member` VALUES (377, '大热常规班', 13, 9, '大热篮球俱乐部', 144, '肖振兴', '中国太保惠霞', 150, 15, 21, '/static/default/avatar.png', 1, 0, '', '20180404学员完成课时毕业', 1, 1513570519, NULL, 1522823149);
INSERT INTO `lesson_member` VALUES (378, '大热常规班', 13, 9, '大热篮球俱乐部', 149, '谭天笑', 'TAN谭天笑', 155, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513570637, NULL, 1524042599);
INSERT INTO `lesson_member` VALUES (379, '南外文华快艇队', 39, 13, 'AKcross训练营', 198, '孙乐知', '李红', 236, 11, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1513582724, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (380, '大热常规班', 13, 9, '大热篮球俱乐部', 199, '郭浩麟', '三吉木易', 237, 27, 33, '/static/default/avatar.png', 1, 0, '', '', 1, 1513583423, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (381, '大热常规班', 13, 9, '大热篮球俱乐部', 200, '王珑桥', '王珑桥', 238, 1, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513585395, NULL, 1524042344);
INSERT INTO `lesson_member` VALUES (382, '南外文华快艇队', 39, 13, 'AKcross训练营', 201, '周润锋', '赵小莉', 239, 5, 19, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513585638, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (383, '南外文华快艇队', 39, 13, 'AKcross训练营', 202, '陈米洛', '周香香', 240, 10, 33, '/static/default/avatar.png', 1, 0, '', '20180328学员完成课时毕业', 1, 1513585828, NULL, 1522170602);
INSERT INTO `lesson_member` VALUES (384, '大热常规班', 13, 9, '大热篮球俱乐部', 148, '柏成恩', '小福和小小福和小小小福', 154, 5, 13, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513586377, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (385, '大热常规班', 13, 9, '大热篮球俱乐部', 203, '朱俊亦', '朱俊亦', 241, 0, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513587751, NULL, 1524042598);
INSERT INTO `lesson_member` VALUES (386, '大热常规班', 13, 9, '大热篮球俱乐部', 204, '何思源', '何思源', 242, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513589993, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (387, '大热常规班', 13, 9, '大热篮球俱乐部', 126, '李昊晟', 'Eva', 132, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513590932, NULL, 1524042600);
INSERT INTO `lesson_member` VALUES (388, '大热常规班', 13, 9, '大热篮球俱乐部', 205, '卢星丞', '卢星丞', 243, 7, 7, '/static/default/avatar.png', 1, 0, '', '', 1, 1513591407, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (389, '大热常规班', 13, 9, '大热篮球俱乐部', 206, '强亦宸', '强亦宸', 244, 11, 17, '/static/default/avatar.png', 1, 0, '', '', 1, 1513592024, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (390, '大热常规班', 13, 9, '大热篮球俱乐部', 207, '杨鑫财', '杨鑫财', 245, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513592467, NULL, 1524042599);
INSERT INTO `lesson_member` VALUES (391, '大热常规班', 13, 9, '大热篮球俱乐部', 208, '万博宇', '万博宇', 246, 0, 8, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513664592, NULL, 1524042603);
INSERT INTO `lesson_member` VALUES (392, '大热常规班', 13, 9, '大热篮球俱乐部', 209, '邱智鸿', '邱智鸿', 247, 12, 21, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513664663, NULL, 1524455606);
INSERT INTO `lesson_member` VALUES (393, '大热常规班', 13, 9, '大热篮球俱乐部', 210, '王炫程', '王炫程', 248, 9, 19, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513664789, NULL, 1524040998);
INSERT INTO `lesson_member` VALUES (394, '大热常规班', 13, 9, '大热篮球俱乐部', 211, '刘家琦', '刘家琦', 249, 0, 2, '/static/default/avatar.png', 1, 0, '', '手动毕业2018年4月18日', 4, 1513664823, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (395, '大热常规班', 13, 9, '大热篮球俱乐部', 212, '张文瑄', '张文瑄', 250, 2, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513664857, NULL, 1524042345);
INSERT INTO `lesson_member` VALUES (396, '大热常规班', 13, 9, '大热篮球俱乐部', 213, '薛若鸿', '薛若鸿', 251, 14, 21, '/static/default/avatar.png', 1, 0, '', '20180329学员完成课时毕业', 1, 1513664874, NULL, 1522257008);
INSERT INTO `lesson_member` VALUES (397, '大热常规班', 13, 9, '大热篮球俱乐部', 214, '严振轩', '严振轩', 252, 6, 13, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513664911, NULL, 1524040998);
INSERT INTO `lesson_member` VALUES (398, '大热常规班', 13, 9, '大热篮球俱乐部', 215, '郭皓晗', '郭皓晗', 253, 14, 25, '/static/default/avatar.png', 1, 0, '', '', 1, 1513664988, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (399, '大热常规班', 13, 9, '大热篮球俱乐部', 216, '周学谦', '周学谦', 254, 0, 5, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513665046, NULL, 1524042603);
INSERT INTO `lesson_member` VALUES (400, '大热常规班', 13, 9, '大热篮球俱乐部', 217, '冯镇壕', '冯镇壕', 255, 22, 25, '/static/default/avatar.png', 1, 0, '', '', 1, 1513665184, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (401, '大热常规班', 13, 9, '大热篮球俱乐部', 218, '周一泉', '周一泉', 256, 5, 6, '/static/default/avatar.png', 1, 0, '', '', 1, 1513665213, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (402, '大热常规班', 13, 9, '大热篮球俱乐部', 219, '潘乐航', '潘乐航', 257, 7, 7, '/static/default/avatar.png', 1, 0, '', '', 1, 1513665244, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (403, '大热常规班', 13, 9, '大热篮球俱乐部', 220, '汪星辰', '汪星辰', 258, 3, 5, '/static/default/avatar.png', 1, 0, '', '', 1, 1513665270, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (404, '大热常规班', 13, 9, '大热篮球俱乐部', 221, '马明道', '马明道', 259, 30, 33, '/static/default/avatar.png', 1, 0, '', '', 1, 1513665326, NULL, 1515644534);
INSERT INTO `lesson_member` VALUES (405, '大热常规班', 13, 9, '大热篮球俱乐部', 222, '谭正中', '谭晟中谭正中', 235, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513668761, NULL, 1524042601);
INSERT INTO `lesson_member` VALUES (406, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 223, '高燕', 'GaoYan', 9, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513743469, NULL, 1524042589);
INSERT INTO `lesson_member` VALUES (407, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 4, '小霖', 'weilin666', 4, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513743651, NULL, 1524042589);
INSERT INTO `lesson_member` VALUES (408, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 101, '哔哔哔', 'MirandaXian', 14, -1, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513744412, NULL, 1524042589);
INSERT INTO `lesson_member` VALUES (409, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 225, 'Bingo', 'Bingo', 21, 2, 3, '/static/default/avatar.png', 1, 0, '', '', 1, 1513744678, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (410, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 226, 'GT ', 'willng', 12, 1, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513745162, NULL, 1524040981);
INSERT INTO `lesson_member` VALUES (411, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 6, '刘嘉', '+*', 5, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513746435, NULL, 1524042589);
INSERT INTO `lesson_member` VALUES (412, '大热常规班', 13, 9, '大热篮球俱乐部', 140, '覃诗翔', '言覃多多', 146, 13, 22, '/static/default/avatar.png', 1, 0, '', '', 1, 1513760258, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (413, '大热常规班', 13, 9, '大热篮球俱乐部', 227, '柏泓庚', 'M00100895', 188, 1, 11, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513765513, NULL, 1524042345);
INSERT INTO `lesson_member` VALUES (414, '塘朗追梦队', 43, 13, 'AKcross训练营', 228, '杜宇轩', '杜宇轩', 260, 4, 18, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513768032, NULL, 1524042342);
INSERT INTO `lesson_member` VALUES (416, '大热常规班', 13, 9, '大热篮球俱乐部', 254, '康正浩', '康正浩', 286, 2, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513837922, NULL, 1524042347);
INSERT INTO `lesson_member` VALUES (417, '大热常规班', 13, 9, '大热篮球俱乐部', 253, '崔展豪', '崔展豪', 285, 11, 13, '/static/default/avatar.png', 1, 0, '', '', 1, 1513837954, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (418, '大热常规班', 13, 9, '大热篮球俱乐部', 252, '洪旭林', '洪旭林', 284, 8, 13, '/static/default/avatar.png', 1, 0, '', '', 1, 1513837976, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (419, '大热常规班', 13, 9, '大热篮球俱乐部', 251, '石原炜', '石原炜', 283, 4, 6, '/static/default/avatar.png', 1, 0, '', '', 1, 1513837999, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (420, '大热常规班', 13, 9, '大热篮球俱乐部', 250, '王北鲲', '王北鲲', 282, 26, 28, '/static/default/avatar.png', 1, 0, '', '', 1, 1513838039, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (421, '大热常规班', 13, 9, '大热篮球俱乐部', 249, '唐佳诺', '唐佳诺', 281, 24, 28, '/static/default/avatar.png', 1, 0, '', '', 1, 1513838064, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (422, '大热常规班', 13, 9, '大热篮球俱乐部', 248, '刘炜文', '刘炜文', 280, 10, 25, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513838082, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (423, '大热常规班', 13, 9, '大热篮球俱乐部', 247, '罗仕杰', '罗仕杰', 279, 13, 19, '/static/default/avatar.png', 1, 0, '', '20180123学员完成课时毕业', 1, 1513838112, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (424, '大热常规班', 13, 9, '大热篮球俱乐部', 246, '王廖聪', '王廖聪', 278, 13, 24, '/static/default/avatar.png', 1, 0, '', '20180309学员完成课时毕业', 1, 1513838139, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (425, '大热常规班', 13, 9, '大热篮球俱乐部', 245, '郭栩源', '郭栩源', 277, 0, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513838228, NULL, 1524042603);
INSERT INTO `lesson_member` VALUES (426, '大热常规班', 13, 9, '大热篮球俱乐部', 244, '张益畅', '张益畅', 276, 15, 23, '/static/default/avatar.png', 1, 0, '', '20180330学员完成课时毕业', 1, 1513838258, NULL, 1522343405);
INSERT INTO `lesson_member` VALUES (427, '大热常规班', 13, 9, '大热篮球俱乐部', 243, '彭梓睿', '彭梓睿', 275, 0, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513838283, NULL, 1524042604);
INSERT INTO `lesson_member` VALUES (428, '大热常规班', 13, 9, '大热篮球俱乐部', 242, '任志诚', '任志诚', 274, 1, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513838302, NULL, 1524042348);
INSERT INTO `lesson_member` VALUES (429, '大热常规班', 13, 9, '大热篮球俱乐部', 241, '郑新浩', '郑新浩', 273, 15, 22, '/static/default/avatar.png', 1, 0, '', '20180330学员完成课时毕业', 1, 1513838324, NULL, 1522343405);
INSERT INTO `lesson_member` VALUES (430, '大热常规班', 13, 9, '大热篮球俱乐部', 240, '郭子阅', '郭子阅', 272, 8, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1513838839, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (431, '大热常规班', 13, 9, '大热篮球俱乐部', 239, '刘阳', '刘阳', 271, 5, 12, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513838878, NULL, 1524040997);
INSERT INTO `lesson_member` VALUES (432, '大热常规班', 13, 9, '大热篮球俱乐部', 238, '冯啟桓', '冯啟桓', 270, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513838978, NULL, 1524042598);
INSERT INTO `lesson_member` VALUES (433, '大热常规班', 13, 9, '大热篮球俱乐部', 237, '杨欣霈', '杨欣霈', 269, 3, 3, '/static/default/avatar.png', 1, 0, '', '', 1, 1513838996, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (434, '大热常规班', 13, 9, '大热篮球俱乐部', 236, '汪子杰', '汪子杰', 268, 4, 4, '/static/default/avatar.png', 1, 0, '', '', 1, 1513839010, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (435, '大热常规班', 13, 9, '大热篮球俱乐部', 235, ' 李承彧', ' 李承彧', 267, 3, 4, '/static/default/avatar.png', 1, 0, '', '', 1, 1513839027, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (436, '大热常规班', 13, 9, '大热篮球俱乐部', 234, '谈朔显', '谈朔显', 266, 3, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513839068, NULL, 1524040992);
INSERT INTO `lesson_member` VALUES (437, '大热常规班', 13, 9, '大热篮球俱乐部', 233, '罗宁', '罗宁', 265, 13, 20, '/static/default/avatar.png', 1, 0, '', '', 1, 1513839092, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (438, '大热常规班', 13, 9, '大热篮球俱乐部', 232, '花梓鹏', '花梓鹏', 264, 0, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513839135, NULL, 1524042604);
INSERT INTO `lesson_member` VALUES (439, '大热常规班', 13, 9, '大热篮球俱乐部', 231, '李俊晔', '李俊晔', 263, 13, 21, '/static/default/avatar.png', 1, 0, '', '20180308学员完成课时毕业', 1, 1513839158, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (440, '大热常规班', 13, 9, '大热篮球俱乐部', 230, '陈江函', '陈江函', 262, 1, 8, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513839187, NULL, 1524042344);
INSERT INTO `lesson_member` VALUES (441, '大热常规班', 13, 9, '大热篮球俱乐部', 229, '阮烨才', '阮烨才', 261, 2, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513839217, NULL, 1524042346);
INSERT INTO `lesson_member` VALUES (442, '塘朗追梦队', 43, 13, 'AKcross训练营', 255, '吴浩睿', '吴浩睿', 287, 11, 35, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513840442, NULL, 1524040989);
INSERT INTO `lesson_member` VALUES (443, '大热常规班', 13, 9, '大热篮球俱乐部', 270, '叶子枫', '叶子枫', 302, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513840741, NULL, 1524042601);
INSERT INTO `lesson_member` VALUES (444, '大热常规班', 13, 9, '大热篮球俱乐部', 269, '龚湖宸', '龚湖宸', 301, 0, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513840764, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (445, '大热常规班', 13, 9, '大热篮球俱乐部', 268, '程翰哲', '程翰哲', 300, 10, 18, '/static/default/avatar.png', 1, 0, '', '', 1, 1513840786, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (446, '大热常规班', 13, 9, '大热篮球俱乐部', 267, '周煜轩', '周煜轩', 299, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513840803, NULL, 1524042603);
INSERT INTO `lesson_member` VALUES (447, '大热常规班', 13, 9, '大热篮球俱乐部', 266, ' 戴溪亭', ' 戴溪亭', 298, 6, 15, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513840826, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (448, '大热常规班', 13, 9, '大热篮球俱乐部', 265, '张圣泽', '张圣泽', 297, 0, 8, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513840852, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (449, '大热常规班', 13, 9, '大热篮球俱乐部', 264, '雷卓凡', '雷卓凡', 296, 0, 8, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513840872, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (450, '大热常规班', 13, 9, '大热篮球俱乐部', 263, '秦铭远', '秦铭远', 295, 10, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1513841204, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (451, '大热常规班', 13, 9, '大热篮球俱乐部', 262, '严俊朗', '严俊朗', 294, 31, 32, '/static/default/avatar.png', 1, 0, '', '', 1, 1513841441, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (452, '大热常规班', 13, 9, '大热篮球俱乐部', 261, '许辰镝', '许辰镝', 293, 3, 7, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513841528, NULL, 1524040997);
INSERT INTO `lesson_member` VALUES (453, '大热常规班', 13, 9, '大热篮球俱乐部', 260, '张皓然', '张皓然', 292, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513841558, NULL, 1524042603);
INSERT INTO `lesson_member` VALUES (454, '大热常规班', 13, 9, '大热篮球俱乐部', 259, '蒙卓朗', '蒙卓朗', 291, 0, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513841573, NULL, 1524042599);
INSERT INTO `lesson_member` VALUES (455, '大热常规班', 13, 9, '大热篮球俱乐部', 258, '杜沛霖', '杜沛霖', 290, 0, 9, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513841596, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (456, '大热常规班', 13, 9, '大热篮球俱乐部', 257, '欧阳舒轩', '欧阳舒轩', 289, 4, 17, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513841619, NULL, 1524042347);
INSERT INTO `lesson_member` VALUES (457, '大热常规班', 13, 9, '大热篮球俱乐部', 256, '李卓逸', '李卓逸', 288, 0, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513841640, NULL, 1524042598);
INSERT INTO `lesson_member` VALUES (458, '大热常规班', 13, 9, '大热篮球俱乐部', 163, '刘凤杰', 'snowy', 170, 9, 12, '/static/default/avatar.png', 1, 0, '', '', 1, 1513841728, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (459, '大热常规班', 13, 9, '大热篮球俱乐部', 143, '方泓锴', 'fanghk', 149, 3, 8, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513841811, NULL, 1524040993);
INSERT INTO `lesson_member` VALUES (460, '大热常规班', 13, 9, '大热篮球俱乐部', 142, '谢欣桦', 'wiya', 148, 2, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513841887, NULL, 1524040997);
INSERT INTO `lesson_member` VALUES (461, '大热常规班', 13, 9, '大热篮球俱乐部', 271, '李兆堂', '李兆堂', 303, 14, 19, '/static/default/avatar.png', 1, 0, '', '', 1, 1513841956, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (462, '大热常规班', 13, 9, '大热篮球俱乐部', 274, '侯朝歌', '侯朝歌', 306, 5, 20, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1513848609, NULL, 1524042348);
INSERT INTO `lesson_member` VALUES (463, '大热常规班', 13, 9, '大热篮球俱乐部', 273, '辛禹霏', '辛禹霏', 305, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513848637, NULL, 1524042601);
INSERT INTO `lesson_member` VALUES (464, '大热常规班', 13, 9, '大热篮球俱乐部', 272, '张诗婷', '张诗婷', 304, 0, 5, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1513848653, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (465, '大热常规班', 13, 9, '大热篮球俱乐部', 275, '张派', 'chupa', 307, 9, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1514001123, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (466, '大热常规班', 13, 9, '大热篮球俱乐部', 276, '张驰', 'chupa', 307, 9, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1514001177, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (467, '大热常规班', 13, 9, '大热篮球俱乐部', 277, '敬宇翔', 'Raymond', 308, 9, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1514088220, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (468, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 278, '刘浩宏', '冰雪纷飞', 309, 12, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1514173177, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (469, '大热常规班', 13, 9, '大热篮球俱乐部', 279, '魏信迪', '魏信迪', 319, 12, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1514359601, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (470, '大热常规班', 13, 9, '大热篮球俱乐部', 280, '冼峻鞍', '秋雨', 317, 3, 11, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1514379120, NULL, 1524042348);
INSERT INTO `lesson_member` VALUES (471, '塘朗追梦队', 43, 13, 'AKcross训练营', 281, '彭鼎盛', '金典', 322, 14, 34, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1514691003, NULL, 1524293988);
INSERT INTO `lesson_member` VALUES (472, '大热常规班', 13, 9, '大热篮球俱乐部', 282, '谢佳希', '谢佳希', 323, 17, 21, '/static/default/avatar.png', 1, 0, '', '', 1, 1514697133, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (510, '南头城小学', 30, 15, '钟声训练营', 312, '郭鑫烨', '郭鑫烨', 352, 0, 5, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515050606, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (551, '大热一对二私教班', 56, 9, '大热篮球俱乐部', 354, '魏子健', '张丽芬', 388, 5, 10, '/static/default/avatar.png', 1, 0, '', '', 1, 1515158675, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (599, 'AKcross课程', 38, 13, 'AKcross训练营', 363, '郑德源', '郑宏轩', 330, -13, -13, '/static/default/avatar.png', 1, 0, '', '', 4, 1519729636, NULL, 1519729636);
INSERT INTO `lesson_member` VALUES (595, '大热常规班', 13, 9, '大热篮球俱乐部', 393, '傅晓泷', '傅晓泷', 505, 12, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1519542905, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (492, 'AKcross课程', 38, 13, 'AKcross训练营', 298, '卢新元', '卢新元', 338, 14, 23, '/static/default/avatar.png', 1, 0, '', '', 1, 1515037509, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (493, 'AKcross课程', 38, 13, 'AKcross训练营', 299, '余浩锋', '余浩锋', 339, 11, 21, '/static/default/avatar.png', 1, 0, '', '', 1, 1515037534, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (494, 'AKcross课程', 38, 13, 'AKcross训练营', 300, '张鸿宇', '张鸿宇', 340, 37, 51, '/static/default/avatar.png', 1, 0, '', '20180315学员完成课时毕业', 1, 1515037552, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (495, 'AKcross课程', 38, 13, 'AKcross训练营', 301, '张正堃', '张正堃', 341, 12, 26, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515037574, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (496, 'AKcross课程', 38, 13, 'AKcross训练营', 302, '孙硕', '孙硕', 342, 2, 7, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515037598, NULL, 1524042341);
INSERT INTO `lesson_member` VALUES (497, 'AKcross课程', 38, 13, 'AKcross训练营', 303, '谢振威', '谢振威', 343, 6, 12, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515037619, NULL, 1524040989);
INSERT INTO `lesson_member` VALUES (498, 'AKcross课程', 38, 13, 'AKcross训练营', 304, '汪昊辰', '汪昊辰', 344, 8, 18, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515037667, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (499, 'AKcross课程', 38, 13, 'AKcross训练营', 305, '唐浩益', '唐浩益', 345, 14, 27, '/static/default/avatar.png', 1, 0, '', '20180315学员完成课时毕业', 1, 1515037688, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (500, '南外文华快艇队', 39, 13, 'AKcross训练营', 339, '林城佑', '林城佑', 369, 27, 37, '/static/default/avatar.png', 1, 0, '', '', 1, 1515038415, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (501, '大热常规班', 13, 9, '大热篮球俱乐部', 339, '林城佑', '林城佑', 369, 7, 21, '/static/default/avatar.png', 1, 0, '', '', 1, 1515038453, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (502, 'AKcross课程', 38, 13, 'AKcross训练营', 340, '汤璨宇', '汤镕章', 329, 3, 4, '/static/default/avatar.png', 1, 0, '', '', 1, 1515039031, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (503, '南头城小学', 30, 15, '钟声训练营', 306, '黄逸山', '黄逸山', 346, 1, 9, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515050306, NULL, 1524042338);
INSERT INTO `lesson_member` VALUES (504, '南头城小学', 30, 15, '钟声训练营', 307, '吴子竞', '吴子竞', 347, 0, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515050332, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (505, '南头城小学', 30, 15, '钟声训练营', 308, '周桐圳', '周桐圳', 348, 9, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1515050348, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (506, '南头城小学', 30, 15, '钟声训练营', 309, '李宗杰', '李宗杰', 349, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515050368, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (507, '南头城小学', 30, 15, '钟声训练营', 310, '黄子轩', '黄子轩', 350, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515050387, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (508, '南头城小学', 30, 15, '钟声训练营', 311, '郑楷涛', '郑楷涛', 351, 0, 5, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515050403, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (509, '南头城小学', 30, 15, '钟声训练营', 328, '曹俸阁', 'Jim', 37, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515050506, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (511, '前海小学', 31, 15, '钟声训练营', 313, '龙永熙', '龙永熙', 353, 2, 11, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515050626, NULL, 1524042340);
INSERT INTO `lesson_member` VALUES (512, '前海小学', 31, 15, '钟声训练营', 314, '陈皇宇', '陈皇宇', 354, 0, 9, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515050650, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (513, '松坪小学', 32, 15, '钟声训练营', 315, '王胜杰', '王胜杰', 355, 1, 3, '/static/default/avatar.png', 1, 0, '', '', 1, 1515050817, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (514, '松坪小学', 32, 15, '钟声训练营', 316, '李绅楠', '李绅楠', 356, 1, 3, '/static/default/avatar.png', 1, 0, '', '', 1, 1515050967, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (515, '松坪小学', 32, 15, '钟声训练营', 317, '张帅杰', '张帅杰', 357, 3, 8, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515051007, NULL, 1524040986);
INSERT INTO `lesson_member` VALUES (516, '松坪小学', 32, 15, '钟声训练营', 318, '夏宏昆', '夏宏昆', 358, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051027, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (517, '松坪小学', 32, 15, '钟声训练营', 319, '徐正庭', '徐正庭', 359, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051062, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (518, '松坪小学', 32, 15, '钟声训练营', 320, '彭鑫', '彭鑫', 360, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051085, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (519, '松坪小学', 32, 15, '钟声训练营', 321, '孙雨晴', '孙雨晴', 361, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051101, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (520, '松坪小学', 32, 15, '钟声训练营', 322, '凌成', '凌成', 362, 1, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515051122, NULL, 1524040986);
INSERT INTO `lesson_member` VALUES (521, '松坪小学', 32, 15, '钟声训练营', 323, '廖澍堃', '廖澍堃', 363, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051141, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (522, '前海小学', 31, 15, '钟声训练营', 324, '熊昊鹏', '熊昊鹏', 364, 15, 24, '/static/default/avatar.png', 1, 0, '', '', 1, 1515051182, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (523, '前海小学', 31, 15, '钟声训练营', 325, '李弈帆', '李弈帆', 365, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051201, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (524, '前海小学', 31, 15, '钟声训练营', 326, '曹銍轩', '曹銍轩', 366, 2, 7, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515051240, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (525, '松坪小学', 32, 15, '钟声训练营', 327, '谢诺', '谢诺', 367, -12, -10, '/static/default/avatar.png', 1, 0, '', '', 4, 1515051273, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (526, '南头城小学', 30, 15, '钟声训练营', 330, '赵俊轩', '赵俊豪', 104, 0, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051362, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (527, '南头城小学', 30, 15, '钟声训练营', 329, '李杰', '1234567', 38, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051391, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (528, '前海小学', 31, 15, '钟声训练营', 331, '吴杰熹', '吴杰熹', 41, 0, 9, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051436, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (529, '前海小学', 31, 15, '钟声训练营', 332, '廖文浩', '廖文浩', 44, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051713, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (530, '前海小学', 31, 15, '钟声训练营', 333, '莫子涵', '莫子涵', 45, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515051787, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (531, '松坪小学', 32, 15, '钟声训练营', 334, '刘鑫', '2892997867', 85, 0, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515052684, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (532, '前海小学', 31, 15, '钟声训练营', 335, '白睿皓', '白睿皓', 99, 1, 7, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515053548, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (533, '前海小学', 31, 15, '钟声训练营', 336, '罗展鹏', 'M00101556', 40, 1, 11, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515053675, NULL, 1524042340);
INSERT INTO `lesson_member` VALUES (535, '南外文华快艇队', 39, 13, 'AKcross训练营', 287, ' 潘思达', ' 潘思达', 327, 11, 38, '/static/default/avatar.png', 1, 0, '', '', 1, 1515124810, NULL, 1524040990);
INSERT INTO `lesson_member` VALUES (536, '大热常规班', 13, 9, '大热篮球俱乐部', 341, '周劲希', '周劲希', 370, 9, 22, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515127099, NULL, 1524040995);
INSERT INTO `lesson_member` VALUES (537, 'FIT', 50, 17, 'FIT', 338, '朱民皓', 'l朱民皓', 320, 0, 0, '/static/default/avatar.png', 1, 0, '', '', 2, 1515132076, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (538, '塘朗追梦队', 43, 13, 'AKcross训练营', 338, '朱民皓', 'l朱民皓', 320, 14, 18, '/static/default/avatar.png', 1, 0, '', '', 1, 1515140529, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (539, '前海小学', 31, 15, '钟声训练营', 343, '杨馨', '杨睿杨馨', 372, 0, 5, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515143286, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (540, '前海小学', 31, 15, '钟声训练营', 342, '杨睿', '杨睿杨馨', 372, 0, 5, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515143299, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (541, '前海小学', 31, 15, '钟声训练营', 344, '莫钧淇', '莫钧淇', 373, 0, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515143328, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (542, '前海小学', 31, 15, '钟声训练营', 345, '向浚哲', '向浚哲', 374, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515143350, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (543, '前海小学', 31, 15, '钟声训练营', 347, '曾子瑜', '曾子言曾子瑜', 375, 1, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515143383, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (544, '前海小学', 31, 15, '钟声训练营', 346, '曾子言', '曾子言曾子瑜', 375, 1, 6, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515143541, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (545, '前海小学', 31, 15, '钟声训练营', 350, '凌梓轩', '凌梓轩', 376, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515143574, NULL, 1524042592);
INSERT INTO `lesson_member` VALUES (546, '前海小学', 31, 15, '钟声训练营', 351, '谢一航', '谢一航', 377, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515143595, NULL, 1524042593);
INSERT INTO `lesson_member` VALUES (547, '前海小学', 31, 15, '钟声训练营', 352, '谢梓珊', '谢梓珊', 378, 0, 8, '/static/default/avatar.png', 1, 0, '', '', 2, 1515143613, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (548, '前海小学', 31, 15, '钟声训练营', 348, '郑梓深', '郑梓深', 47, 0, 3, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 2, 1515143660, NULL, 1524040986);
INSERT INTO `lesson_member` VALUES (549, '前海小学', 31, 15, '钟声训练营', 349, '游简菏', 'M00101482', 68, 0, 0, '/static/default/avatar.png', 1, 0, '', '', 2, 1515143681, NULL, 1524042339);
INSERT INTO `lesson_member` VALUES (550, '大热一对二私教班', 56, 9, '大热篮球俱乐部', 353, '刘书含', '曼曼红', 381, 4, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515145318, NULL, 1524040998);
INSERT INTO `lesson_member` VALUES (552, '大热常规班', 13, 9, '大热篮球俱乐部', 355, '张笑宇', '张笑宇', 389, 23, 32, '/static/default/avatar.png', 1, 0, '', '', 1, 1515214193, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (553, 'B—Ball篮球训练课', 54, 33, 'B—Ball 篮球训练营', 356, '阿带', 'shandy', 391, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1515325383, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (554, 'B—Ball篮球训练课', 54, 33, 'B—Ball 篮球训练营', 357, 'Ck', 'CK', 393, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1515330397, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (555, 'B—Ball篮球训练课', 54, 33, 'B—Ball 篮球训练营', 89, '测试1', 'legend', 6, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1515396528, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (556, '大热常规班', 13, 9, '大热篮球俱乐部', 364, '刘昊', '刘昊', 398, 6, 18, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515398371, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (557, '大热常规班', 13, 9, '大热篮球俱乐部', 362, '杨宇昊', '杨宇昊', 397, 1, 9, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515398888, NULL, 1524042345);
INSERT INTO `lesson_member` VALUES (558, '大热常规班', 13, 9, '大热篮球俱乐部', 360, '孙胤麒', '孙胤麒', 396, 0, 6, '/static/default/avatar.png', 1, 0, '', '20180108学员完成课时毕业', 4, 1515398914, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (559, '大热常规班', 13, 9, '大热篮球俱乐部', 359, '周宇乐', '周宇乐', 395, 1, 26, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515398939, NULL, 1524042345);
INSERT INTO `lesson_member` VALUES (560, '大热常规班', 13, 9, '大热篮球俱乐部', 358, '熊英凯', '熊英凯', 394, 0, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1515398956, NULL, 1524042599);
INSERT INTO `lesson_member` VALUES (561, '大热常规班', 13, 9, '大热篮球俱乐部', 361, '许凯瑞', '许凯瑞', 383, 32, 57, '/static/default/avatar.png', 1, 0, '', '20180108学员完成课时毕业', 1, 1515398985, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (562, '大热常规班', 13, 9, '大热篮球俱乐部', 363, '郑德源', '郑宏轩', 330, 15, 21, '/static/default/avatar.png', 1, 0, '', '', 1, 1515399023, NULL, 1515644533);
INSERT INTO `lesson_member` VALUES (563, '前海小学', 31, 15, '钟声训练营', 365, '邝治嘉', '邝治嘉', 414, 1, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515485673, NULL, 1524042340);
INSERT INTO `lesson_member` VALUES (564, '前海小学', 31, 15, '钟声训练营', 366, '喻梓轩', '喻梓轩', 415, 3, 11, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1515486557, NULL, 1524040987);
INSERT INTO `lesson_member` VALUES (565, 'B—Ball篮球训练课', 54, 33, 'B—Ball 篮球训练营', 367, 'Bingo', 'BINGOZ', 427, -1, -1, '/static/default/avatar.png', 1, 0, '', '', 4, 1516162367, NULL, 1516162367);
INSERT INTO `lesson_member` VALUES (566, '前海小学', 31, 15, '钟声训练营', 369, '朱子玥', '15692453726', 433, 1, 11, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1516169536, NULL, 1524042340);
INSERT INTO `lesson_member` VALUES (567, '前海小学', 31, 15, '钟声训练营', 368, '朱子恒', '15692453726', 433, 4, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1516169568, NULL, 1524040986);
INSERT INTO `lesson_member` VALUES (568, '南外文华快艇队', 39, 13, 'AKcross训练营', 370, '谢俊棋', 'Icy', 439, 3, 17, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1516269041, NULL, 1524042342);
INSERT INTO `lesson_member` VALUES (594, '平台示例请勿购买', 37, 4, '准行者训练营', 46, '小woo', 'woo123', 8, 7, 7, '/static/default/avatar.png', 2, 0, '', '', 1, 1519358034, NULL, 1519358034);
INSERT INTO `lesson_member` VALUES (570, '大热常规班', 13, 9, '大热篮球俱乐部', 371, '余鲁文', '余鲁文', 454, 0, 4, '/static/default/avatar.png', 1, 0, '', '20180207学员完成课时毕业', 4, 1516605758, NULL, 1517937007);
INSERT INTO `lesson_member` VALUES (571, '大热常规班', 59, 9, '大热篮球俱乐部', 225, 'Bingo', 'Bingo', 21, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1516617011, NULL, 1516617011);
INSERT INTO `lesson_member` VALUES (572, '大热常规班', 13, 9, '大热篮球俱乐部', 372, '朱星懿', '朱星懿', 457, 0, 5, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1516872943, NULL, 1524042603);
INSERT INTO `lesson_member` VALUES (573, '大热常规班', 13, 9, '大热篮球俱乐部', 373, '范烨', '范烨', 458, 5, 10, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1516873277, NULL, 1524040997);
INSERT INTO `lesson_member` VALUES (574, '大热一对二私教班（室内场）', 56, 9, '大热篮球俱乐部', 374, '何明鸿', '何明鸿', 459, 0, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1516952532, NULL, 1524042601);
INSERT INTO `lesson_member` VALUES (575, '大热一对二私教班（室内场）', 56, 9, '大热篮球俱乐部', 375, '何雨辰', '何雨辰', 460, 0, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1516952621, NULL, 1524042601);
INSERT INTO `lesson_member` VALUES (577, '大热常规班', 13, 9, '大热篮球俱乐部', 376, '程嘉一', '程嘉一', 461, 29, 29, '/static/default/avatar.png', 1, 0, '', '', 1, 1516954464, NULL, 1516954464);
INSERT INTO `lesson_member` VALUES (578, '大热常规班', 13, 9, '大热篮球俱乐部', 377, '苏奕航', '苏奕航', 462, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1516954646, NULL, 1516954646);
INSERT INTO `lesson_member` VALUES (579, '大热常规班', 59, 9, '大热篮球俱乐部', 215, '郭皓晗', '郭皓晗', 253, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1516964061, NULL, 1516964061);
INSERT INTO `lesson_member` VALUES (580, '大热常规班', 13, 9, '大热篮球俱乐部', 378, '陈钧喆', '陈钧喆', 463, 6, 6, '/static/default/avatar.png', 1, 0, '', '', 1, 1516966373, NULL, 1516966373);
INSERT INTO `lesson_member` VALUES (581, '大热常规班', 13, 9, '大热篮球俱乐部', 379, '卢皓文', '卢皓文', 465, 9, 14, '/static/default/avatar.png', 1, 1, '', '20180321学员完成课时毕业', 2, 1517024910, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (582, '大热常规班', 13, 9, '大热篮球俱乐部', 380, '张轩铭', '张轩铭', 466, 16, 18, '/static/default/avatar.png', 1, 0, '', '', 1, 1517199571, NULL, 1517199571);
INSERT INTO `lesson_member` VALUES (583, '大热常规班', 13, 9, '大热篮球俱乐部', 382, '杨璨南', '杨璨南', 467, 1, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1517294320, NULL, 1524040995);
INSERT INTO `lesson_member` VALUES (584, '大热常规班', 13, 9, '大热篮球俱乐部', 383, '徐乐天', '徐乐天', 468, 1, 2, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1517294499, NULL, 1524040995);
INSERT INTO `lesson_member` VALUES (585, '大热常规班', 13, 9, '大热篮球俱乐部', 384, '吴昭睿', 'willng', 12, 3, 4, '/static/default/avatar.png', 1, 0, '', '', 1, 1517294645, NULL, 1517294645);
INSERT INTO `lesson_member` VALUES (586, '大热常规班', 13, 9, '大热篮球俱乐部', 385, '石井泽', '石井泽', 469, 4, 5, '/static/default/avatar.png', 1, 0, '', '', 1, 1517294896, NULL, 1517294896);
INSERT INTO `lesson_member` VALUES (587, '大热常规班', 13, 9, '大热篮球俱乐部', 386, '高杨钊', '高杨钊', 470, 4, 6, '/static/default/avatar.png', 1, 0, '', '', 1, 1517294974, NULL, 1517294974);
INSERT INTO `lesson_member` VALUES (588, '大热常规班', 13, 9, '大热篮球俱乐部', 387, '郭雨锜', '郭雨锜', 472, 14, 26, '/static/default/avatar.png', 1, 0, '', '', 1, 1517480764, NULL, 1517480764);
INSERT INTO `lesson_member` VALUES (589, '大热常规班', 13, 9, '大热篮球俱乐部', 388, '李烨', '李烨', 473, 2, 4, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1517482219, NULL, 1524040996);
INSERT INTO `lesson_member` VALUES (590, '大热常规班', 13, 9, '大热篮球俱乐部', 389, '钱宥丞', '钱宥丞', 483, 5, 8, '/static/default/avatar.png', 1, 0, '', '', 1, 1517540288, NULL, 1517540288);
INSERT INTO `lesson_member` VALUES (591, '大热常规班', 13, 9, '大热篮球俱乐部', 390, '张松海', '张松海', 484, 6, 8, '/static/default/avatar.png', 1, 0, '', '', 1, 1517540418, NULL, 1517540418);
INSERT INTO `lesson_member` VALUES (592, '大热常规班', 13, 9, '大热篮球俱乐部', 391, '凌奕', '凌奕', 485, 4, 5, '/static/default/avatar.png', 1, 0, '', '', 1, 1517541991, NULL, 1517541991);
INSERT INTO `lesson_member` VALUES (593, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 191, '陈易', 'HoChen', 1, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1519308403, NULL, 1519308403);
INSERT INTO `lesson_member` VALUES (601, 'AKcross课程', 38, 13, 'AKcross训练营', 396, '刘宇辰', 'lovecheck', 509, 12, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1520080713, NULL, 1522140025);
INSERT INTO `lesson_member` VALUES (602, '大热常规班', 13, 9, '大热篮球俱乐部', 397, '黄之麓', 'JasonHuang', 510, 13, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1520135179, NULL, 1522140024);
INSERT INTO `lesson_member` VALUES (603, '大热常规班', 13, 9, '大热篮球俱乐部', 398, '董心宇', 'Dongxinyu', 513, 11, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1520305644, NULL, 1520305644);
INSERT INTO `lesson_member` VALUES (607, '大热常规班(无优惠)', 57, 9, '大热篮球俱乐部', 360, '孙胤麒', '孙胤麒', 396, 13, 15, '/static/default/avatar.png', 1, 1, '', '20180418学员完成课时毕业', 1, 1521253826, 123456789, 1524042602);
INSERT INTO `lesson_member` VALUES (604, '大热常规班', 13, 9, '大热篮球俱乐部', 399, '何锦延', 'LL', 514, 0, 0, '/static/default/avatar.png', 1, 1, '', '转课操作', 4, 1520653089, NULL, 1520653165);
INSERT INTO `lesson_member` VALUES (605, '大热常规班', 13, 9, '大热篮球俱乐部', 400, '唐钰钧', '唐钰钧', 515, 12, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1520912033, NULL, 1520912033);
INSERT INTO `lesson_member` VALUES (606, '大热常规班', 13, 9, '大热篮球俱乐部', 401, '郑翰', '郑翰', 516, 0, 0, '/static/default/avatar.png', 2, 0, '', '', 4, 1521012138, NULL, 1521012138);
INSERT INTO `lesson_member` VALUES (608, '塘朗追梦队', 43, 13, 'AKcross训练营', 402, '陶承希', '陶承希', 519, 22, 30, '/static/default/avatar.png', 1, 0, '', '', 1, 1521282850, NULL, 1521282850);
INSERT INTO `lesson_member` VALUES (609, '大热常规班', 13, 9, '大热篮球俱乐部', 403, '张之翼', '翼翼', 520, 32, 32, '/static/default/avatar.png', 1, 0, '', '', 1, 1521354187, NULL, 1521354187);
INSERT INTO `lesson_member` VALUES (610, '大热常规班', 13, 9, '大热篮球俱乐部', 404, '张应淏', 'Hank', 521, 32, 32, '/static/default/avatar.png', 1, 0, '', '', 1, 1521355079, NULL, 1521355079);
INSERT INTO `lesson_member` VALUES (611, '大热常规班', 13, 9, '大热篮球俱乐部', 405, '张诗婷', '侯朝歌', 306, -3, 1, '/static/default/avatar.png', 1, 1, '', '20180418学员完成课时毕业', 4, 1521439274, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (612, '大热常规班', 13, 9, '大热篮球俱乐部', 406, '辛禹菲', '侯朝歌', 306, -5, 1, '/static/default/avatar.png', 1, 1, '', '20180418学员完成课时毕业', 4, 1521439370, NULL, 1524042602);
INSERT INTO `lesson_member` VALUES (613, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 407, '李佶', '姜毅', 524, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1521516345, NULL, 1521516345);
INSERT INTO `lesson_member` VALUES (614, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 408, '简福康', '兰俊', 525, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1521523247, NULL, 1521523247);
INSERT INTO `lesson_member` VALUES (615, '测试', 64, 9, '大热篮球俱乐部', 409, '测试学员', 'MirandaXian', 14, 0, 1, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 4, 1521615704, NULL, 1524042603);
INSERT INTO `lesson_member` VALUES (616, '平台示例请勿购买', 37, 4, '准行者训练营', 11, '陈佳佑', 'yanyan', 33, 1, 1, '/static/default/avatar.png', 1, 0, '', '', 1, 1521946803, NULL, 1521946803);
INSERT INTO `lesson_member` VALUES (618, '大热常规班', 13, 9, '大热篮球俱乐部', 410, '徐瑞阳', '徐瑞阳', 386, 18, 20, '/static/default/avatar.png', 1, 0, '', '20180418学员完成课时毕业', 1, 1522044102, NULL, 1524460096);
INSERT INTO `lesson_member` VALUES (619, 'AKcross课程', 38, 13, 'AKcross训练营', 411, '郑浩明', '郑浩明', 529, 15, 16, '/static/default/avatar.png', 1, 0, '', '', 1, 1522063127, NULL, 1522063127);
INSERT INTO `lesson_member` VALUES (620, '大热常规班', 13, 9, '大热篮球俱乐部', 412, '王佳浩', '王佳浩', 530, 14, 19, '/static/default/avatar.png', 1, 0, '', '', 1, 1522133622, NULL, 1522133622);
INSERT INTO `lesson_member` VALUES (621, '大热常规班', 13, 9, '大热篮球俱乐部', 413, '邓熙康', '邓熙康', 531, 8, 11, '/static/default/avatar.png', 1, 0, '', '', 1, 1522135122, NULL, 1522135122);
INSERT INTO `lesson_member` VALUES (622, '大热常规班', 13, 9, '大热篮球俱乐部', 414, '张乐淘', '张乐淘', 532, 21, 23, '/static/default/avatar.png', 1, 0, '', '', 1, 1522135919, NULL, 1522135919);
INSERT INTO `lesson_member` VALUES (623, '大热常规班', 13, 9, '大热篮球俱乐部', 415, '林炜昇', '林国标', 533, 14, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1522401442, NULL, 1522401442);
INSERT INTO `lesson_member` VALUES (624, '大热常规班', 13, 9, '大热篮球俱乐部', 416, '王禹舒', '王禹舒', 534, 9, 10, '/static/default/avatar.png', 1, 0, '', '', 1, 1522727822, NULL, 1522727822);
INSERT INTO `lesson_member` VALUES (625, '大热常规班', 13, 9, '大热篮球俱乐部', 46, '小woo', 'woo123', 8, 0, 0, '/static/default/avatar.png', 2, 0, '', '', 4, 1522744631, NULL, 1522744631);
INSERT INTO `lesson_member` VALUES (626, 'FIT篮球训练营', 65, 17, 'FIT', 417, '张霆睿', '张霆睿', 538, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1523783893, NULL, 1523783893);
INSERT INTO `lesson_member` VALUES (627, 'FIT篮球训练营', 65, 17, 'FIT', 418, '刘铠铭', '啊维', 540, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1523784442, NULL, 1523784442);
INSERT INTO `lesson_member` VALUES (628, 'FIT篮球训练营', 65, 17, 'FIT', 419, '吴钟至永', '吴钟至永', 541, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1523784955, NULL, 1523784955);
INSERT INTO `lesson_member` VALUES (629, 'FIT篮球训练营', 65, 17, 'FIT', 421, '宋睿杰', '宋睿杰', 542, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1523788649, NULL, 1523788649);
INSERT INTO `lesson_member` VALUES (630, 'FIT篮球训练营', 65, 17, 'FIT', 422, '庞楷俊', '庞楷俊', 539, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1523789187, NULL, 1523789187);
INSERT INTO `lesson_member` VALUES (631, 'FIT篮球训练营', 65, 17, 'FIT', 420, '钟旭烜', '吴钟至永', 541, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1523791260, NULL, 1523791260);
INSERT INTO `lesson_member` VALUES (632, 'FIT篮球训练营', 65, 17, 'FIT', 423, '彭扬', '彭扬', 537, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1523794248, NULL, 1523794248);
INSERT INTO `lesson_member` VALUES (633, 'AKcross课程', 38, 13, 'AKcross训练营', 290, '郑宏轩', '郑宏轩', 330, 17, 17, '/static/default/avatar.png', 1, 0, '', '', 1, 1523846906, NULL, 1523846906);
INSERT INTO `lesson_member` VALUES (634, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 89, '测试1', 'legend', 6, -2, 0, '/static/default/avatar.png', 1, 0, '', '20180416 训练营人员 woo123 操作设为离营，当前学员剩余课时数：1', 4, 1523871190, NULL, 1523872005);
INSERT INTO `lesson_member` VALUES (638, 'AKcross课程', 38, 13, 'AKcross训练营', 427, '孙硕', '行者', 547, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1524461070, NULL, 1524461070);
INSERT INTO `lesson_member` VALUES (637, '大热常规班', 13, 9, '大热篮球俱乐部', 426, '陈志鸿', '陈志鸿', 546, 8, 8, '/static/default/avatar.png', 1, 0, '', '', 1, 1524455137, NULL, 1524455137);
INSERT INTO `lesson_member` VALUES (635, '大热常规班', 13, 9, '大热篮球俱乐部', 424, '向誉诚', '怡轩', 543, 15, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1524125761, NULL, 1524125761);
INSERT INTO `lesson_member` VALUES (636, '南外文华快艇队', 39, 13, 'AKcross训练营', 425, '李佰轩', '李佰轩', 545, 14, 15, '/static/default/avatar.png', 1, 0, '', '', 1, 1524145880, NULL, 1524145880);
INSERT INTO `lesson_member` VALUES (639, '大热常规班（无优惠）', 57, 9, '大热篮球俱乐部', 428, '李权', '水蓝', 548, 10, 10, '/static/default/avatar.png', 1, 0, '', '', 1, 1524474763, NULL, 1524474763);

SET FOREIGN_KEY_CHECKS = 1;
