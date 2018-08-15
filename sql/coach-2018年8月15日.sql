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

 Date: 15/08/2018 14:35:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for coach
-- ----------------------------
DROP TABLE IF EXISTS `coach`;
CREATE TABLE `coach`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coach` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:男:2女',
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `student_flow` int(10) NOT NULL DEFAULT 0 COMMENT '学员流量数',
  `schedule_flow` int(10) NOT NULL DEFAULT 0 COMMENT '课时流量数',
  `grade_flow` int(11) NOT NULL DEFAULT 0 COMMENT '班级流量数',
  `lesson_flow` int(11) NOT NULL DEFAULT 0 COMMENT '课程流量数',
  `student_flow_init` int(10) NOT NULL DEFAULT 0 COMMENT '初始历史学员流量数',
  `schedule_flow_init` int(10) NOT NULL DEFAULT 0 COMMENT '初始历史课时流量数',
  `star` int(11) NOT NULL DEFAULT 0 COMMENT '评分总分数',
  `star_num` int(11) NOT NULL DEFAULT 0 COMMENT '评分次数',
  `create_time` int(11) NOT NULL COMMENT '注册日期',
  `update_time` int(10) NOT NULL,
  `coach_rank` tinyint(4) NOT NULL DEFAULT 1 COMMENT '阶衔',
  `coach_year` tinyint(4) NOT NULL COMMENT '教龄',
  `experience` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教学经验描述',
  `introduction` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'remarks',
  `sys_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `portraits` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '肖像',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '个人宣言',
  `coach_level` tinyint(4) NOT NULL DEFAULT 1 COMMENT '教练等级,按学员流量算',
  `is_open` int(11) NOT NULL DEFAULT 1 COMMENT '信息是否公开:1公开|-1不公开',
  `status` tinyint(4) NOT NULL COMMENT '0:未完善信息|1:正常|2:不通过|-1:禁用',
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of coach
-- ----------------------------
INSERT INTO `coach` VALUES (1, '刘伟霖', 1, '广东省', '深圳市', '南山区', 4, 'weilin666', 0, 0, 3, 5, 0, 0, 0, 0, 1506414074, 1523257758, 1, 1, '哈哈哈哈哈哈或或或', '<div class=\"operationDiv\"><p>方式的发送到发送到</p></div>', '', '', '/uploads/images/cert/2017/09/59ca0dd2685f8.jpg', '绕弯儿翁二', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (2, '刘嘉兴', 1, '广东省', '深圳市', '南山区', 5, '+*', 0, 0, 0, 0, 0, 0, 0, 0, 1506414257, 1523257758, 1, 24, '1', '<div class=\"operationDiv\"><p>1</p></div>', '', '', '/uploads/images/cert/2017/09/59ca0e8af1cb1.jpg', '1', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (3, '陈侯', 1, '广东省', '深圳市', '南山区', 1, 'HoChen', 0, 0, 0, 1, 0, 0, 0, 0, 1506667013, 1523257758, 1, 5, '猴塞雷', '<div class=\"operationDiv\"><p>真的猴塞雷</p></div>', '', '', '/uploads/images/cert/2017/10/59d1888c3a6ef.jpg', '????', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (4, '大热篮球', 1, '广东省', '深圳市', '南山区', 2, 'Hot-basketball2', 0, 1, 0, 2, 0, 0, 0, 0, 1506675797, 1523257758, 1, 1, '11', '<div class=\"operationDiv\"><p>11</p></div>', '', '', '/uploads/images/cert/2017/09/59ce0c29d5db2.JPG', '。', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (5, 'legend', 1, '广东省', '深圳市', '南山区', 6, 'legend', 2, 0, 2, 9, 0, 0, 0, 0, 1506759874, 1531454267, 1, 8, '只能说很有经验的', '<div class=\"operationDiv\"><p>迷一样的人</p></div>', '', '', '/uploads/images/cert/2018/04/04e714d7047ac3848afc4dd764ed98cb6af2319f.jpeg', '好好学习天天大热', 1, 1, 2, NULL);
INSERT INTO `coach` VALUES (6, '张伟荣', 1, '广东省', '深圳市', '福田区', 7, 'wayen_z', 0, 0, 5, 7, 0, 0, 0, 0, 1507105159, 1530257622, 1, 5, '暂无', '<div class=\"operationDiv\"><p>无</p></div>', '', '', '/uploads/images/cert/2018/06/e8a6ad1769e47c04be8c04353dbde95de274ecad.jpeg', '全力以赴', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (7, '钟声', 1, '广东省', '深圳市', '南山区', 19, '钟声', 100, 149, 10, 5, 0, 0, 10, 2, 1507804421, 1523257758, 1, 10, '带好每个篮球队的教学需要教练要有颗积极奉献精神，言传身教，把先进教学技能传授学员，培养不同年令段学员对学习篮球兴趣爱好。', '<div class=\"operationDiv\"><p>国家一级运动员，吉林省体工队篮球运动员，国家体育总局篮球二级社会指导员，广州体育学院篮球专业，深圳市体育发展中心篮球职业队运动员。</p></div>', '', '', '/uploads/images/cert/2017/10/59df3c4e3cb4c.jpeg', '带好每一名学员，培养学员团队意识，，，努力拚搏，勇不言败。', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (11, 'Michael Mcgrath', 1, '广东省', '深圳市', '南山区', 24, 'Hot777', 0, 0, 0, 2, 0, 0, 0, 0, 1507971658, 1523257758, 1, 8, '8年体适能从业经验', '<div class=\"operationDiv\"><p>来自澳大利亚</p></div>', '', '', '/uploads/images/cert/2017/10/59e1d08826771.PNG', 'Just believe in yourself ', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (12, '张雅璐', 1, '广东省', '深圳市', '南山区', 78, '张雅璐', 0, 0, 0, 0, 0, 0, 0, 0, 1508830799, 1531454368, 1, 0, '0', '<div class=\"operationDiv\"><p>0</p></div>', '', '', '/uploads/images/cert/2017/10/59eeedd7b6458.jpeg', '0', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (13, '庄贵钦', 1, '广东省', '深圳市', '南山区', 36, 'Gavin.zhuang', 44, 74, 7, 0, 0, 0, 5, 1, 1509006951, 1523257758, 1, 2, '带过小学初中班，校园大课堂', '<div class=\"operationDiv\"><p>\n来自广东阳江，热爱篮球，喜欢篮球</p></div>', '', '', '/uploads/images/cert/2017/10/59f19d3085f3a.JPG', '热爱生活热爱工作', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (9, '安凯翔', 1, '广东省', '深圳市', '南山区', 18, 'AK', 112, 265, 6, 10, 50, 100, 35, 7, 1507951149, 1523257758, 1, 6, '老到九十九,小到刚会走，拿起篮球，就能牛！', '<div class=\"operationDiv\"><p>耐心 爱心 责任心</p></div>', '', '', '/uploads/images/cert/2017/12/5a2a3c815798e.jpeg', '十倍努力，守我初心', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (10, '董硕同', 1, '广东省', '深圳市', '南山区', 17, 'Bruce.Dong', 37, 86, 8, 0, 0, 0, 5, 1, 1507951194, 1523257758, 1, 3, '带领的班级有：幼儿班、小学低年级班、小学高年级班、初中班，私教课，教学经验丰富。', '<div class=\"operationDiv\"><p>国家篮球二级运动员\n国家篮球二级社会体育指导员\n东莞NBA篮球学校中级教练员</p></div>', '', '', '/uploads/images/cert/2017/10/59e18107be68d.jpeg', '不仅传授球技，更想通过篮球传授给学员人生的道理，篮球育人。', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (14, '黄万瑞', 1, '广东省', '深圳市', '南山区', 27, 'coachj', 49, 83, 6, 0, 0, 0, 0, 0, 1509445239, 1523257758, 1, 4, '无', '<div class=\"operationDiv\"><p>无</p></div>', '', '', '/uploads/images/cert/2017/10/59f84e64d460c.jpg', '无', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (15, '林泽铭', 1, '广东省', '深圳市', '罗湖区', 16, 'andy.lin', 9, 13, 1, 3, 0, 0, 20, 4, 1509449035, 1523257758, 1, 3, '3年教龄\n培训上百名学生 训练校队\n带领布心小学女队获得深圳体彩杯第8名\n执教龙岗民警子弟球队\n', '<div class=\"operationDiv\"><h5>国家二级社会指导员（篮球）</h5></div><div class=\"operationDiv\"><p></p></div><div class=\"operationDiv\"><p>耐心的教学 正确的态度 专业的篮球教学 体适能锻炼</p></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/cert/2018/02/thumb_5a9636b74ba7c.jpeg\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div>', '', '', '/uploads/images/cert/2017/10/59f85cf44bbcd.jpg', '你学到的不只有篮球', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (16, '张嘉涵', 1, '广东省', '深圳市', '罗湖区', 184, '涵叔', 13, 13, 1, 0, 0, 0, 0, 0, 1511947695, 1523257758, 1, 2, '.', '<div class=\"operationDiv\"><p>.</p></div>', '', '', '/uploads/images/cert/2017/11/5a1e7c659ffe1.JPG', '.', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (20, '高艳', 1, '广东省', '深圳市', '龙华新区', 9, 'GaoYan', 0, 0, 0, 1, 0, 0, 0, 0, 1513820635, 1523257758, 1, 6, '一直专注于幼儿对篮球兴趣的培养和青少年篮球入门和基础技术的教育。', '<div class=\"operationDiv\"><p>毕业于湖北体育院校，主修体育教育，分别在小学和中学担任过体育老师，对篮球的热爱从15岁至今，从事篮球教育已达8年之久，边教边学不断充实自己，把更多更好的篮球知识传递和教给更多热爱喜欢篮球的孩子们。</p></div>', '', '', '/uploads/images/cert/2017/12/5a3b0f8c1947a.jpeg', '热爱篮球胜过爱自己', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (21, '吴京屏', 1, '湖南省', '张家界市', '永定区', 310, '吴京屏', 0, 0, 0, 0, 0, 0, 0, 0, 1514179699, 1523257758, 1, 1, '能带动小朋友对篮球的热情，熟练运用自己所学基本功知识让小朋友掌握最简单有效的基础篮球', '<div class=\"operationDiv\"><p>热情大方</p></div>', '', '', '/uploads/images/cert/2017/12/5a408b771049e.jpeg', '篮球永不熄', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (22, '高晗彧', 1, '广东省', '深圳市', '南山区', 316, 'hanyu', 0, 0, 0, 0, 0, 0, 0, 0, 1514262667, 1523257758, 1, 1, '1\n', '<div class=\"operationDiv\"><p>1\n</p></div>', '', '', '/uploads/images/cert/2017/12/5a41d035f1374.jpeg', '汗水是检验努力的唯一标准', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (23, '刘嘉豪', 1, '广东省', '深圳市', '其它区', 315, 'star', 0, 0, 0, 0, 0, 0, 0, 0, 1514271658, 1523257758, 1, 2, '两年教学经验', '<div class=\"operationDiv\"><p> </p></div>', '', '请上传合法身份证照！', '/uploads/images/cert/2017/12/5a41dde1ede02.png', ' ', 1, 1, 2, NULL);
INSERT INTO `coach` VALUES (24, '靳虓', 1, '广东省', '深圳市', '南山区', 318, '靳虓', 0, 0, 0, 0, 0, 0, 0, 0, 1514299089, 1523257758, 1, 2, '射手班主教练', '<div class=\"operationDiv\"><p>比赛经验丰富  在投篮训练方面有独特的训练方法</p></div>', '', '', '/uploads/images/cert/2017/12/5a425e5ac04d7.jpeg', '投篮就是准 ', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (25, '林润', 1, '广东省', '深圳市', '南山区', 431, 'Running', 0, 0, 0, 0, 0, 0, 0, 0, 1516115278, 1523257758, 1, 6, '篮球专业毕业，擅长体能专项提升，国际教练认证', '<div class=\"operationDiv\"><p>激情，富有感染力，给你不一样的感觉</p></div>', '', '', '/uploads/images/cert/2018/01/thumb_5a5e14d77d57b.jpeg', '没有付出，没有收获', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (26, '范东烽', 1, '河南省', '安阳市', '龙安区', 535, '范东烽', 0, 0, 0, 0, 0, 0, 0, 0, 1522763935, 1528256514, 1, 1, '在学校进行过篮球教练的实习', '<div class=\"operationDiv\"><h5>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 自我简介</h5></div><div class=\"operationDiv\"><p>您好，我叫范东烽，来自河南安阳，2008年是在安阳市体育运动学校学的篮球，读的中专，2013年毕业于河南教育学院的，学的体育教育，关于篮球的一些基本动作和技巧比较扎实，沟通能力也没有问题，身高185 cm &nbsp;体重95公斤 &nbsp;也熟悉一些常用的办公软件Excel表格 未来的职业规划也是想往篮球方面发展</p></div>', '', '', '', '给每个孩子创造参与篮球运动的机会。 \n不仅仅成为更好的篮球运动员更要努力成为更好的人。 ', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (27, '黄帝送', 1, '广东省', '深圳市', '龙岗区', 558, '倔尼', 0, 0, 0, 0, 0, 0, 0, 0, 1525963349, 1526007313, 1, 1, '东莞篮球学校暑期夏令营', '<div class=\"operationDiv\"><h5>黄帝送</h5></div>', '', '', '/uploads/images/cert/2018/05/a8b3c12001b979374da53648461f0b5796cd1b33.jpeg', '享受篮球', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (28, '文树超', 1, '广东省', '江门市', '江海区', 432, '文sir', 0, 0, 0, 0, 0, 0, 0, 0, 1527641287, 1527647283, 1, 6, '乐阵营篮球训练营创始人', '<div class=\"operationDiv\"><h5>做更好的自己</h5></div><div class=\"operationDiv\"><p>本人专注青少年篮球训练多年，2016年在北京国家体育总局参与全国篮球教练员进修。秉承“专业、认真、用心”的教学理念，坚持以球育人，希望通过篮球教育给孩子们带来欢乐并健全人格，做更好的自己！</p></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/cert/2018/05/thumb_5b0df4ae5460f.jpeg\" style=\"padding-top:5px\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/cert/2018/05/thumb_5b0df244a4c15.jpeg\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div>', '', '', '/uploads/images/cert/2018/05/0d753df5428e9e8cba266f49af5591c7e75791ad.jpeg', '专业、认真、用心！', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (29, '邓波', 1, '湖南省', '株洲市', '芦淞区', 603, '邓波', 0, 0, 0, 0, 0, 0, 0, 0, 1528466915, 1529398821, 1, 15, '湖南省大学生篮球比赛高职高专组男子篮球冠军——主教练（民政学院）\n湖南省高中篮球比赛女子组冠军——主教练（长郡中学）\n新奥燃气篮球比赛全国总决赛冠军——主教练（株洲队）', '<div class=\"operationDiv\"><h5></h5></div>', '', '', '', '效率即价值，用最少的时间完成最大的飞跃！', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (31, '李法宪', 0, '湖南省', '株洲市', '荷塘区', 649, '李法宪', 0, 0, 0, 0, 0, 0, 0, 0, 1530066706, 1530075094, 1, 5, '从事体育教学10多年，从高中到研究生阶段一直从事体育方面的工作', '<div class=\"operationDiv\"><p>李法宪</p></div><div class=\"operationDiv\"><p></p></div>', '', '', '/uploads/images/cert/2018/06/4ebe3669576b41e2f457b822e19636a14ff3af39.jpeg', '终身运动', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (30, '何孔贤', 1, '广东省', '深圳市', '宝安区', 560, '大锤', 0, 0, 0, 0, 0, 0, 0, 0, 1529043161, 1529043683, 1, 2, '主攻 运球 实战进攻 ', '<div class=\"operationDiv\"><h5>#e g b</h5></div><div class=\"operationDiv\"><p></p></div>', '', '', '/uploads/images/cert/2018/06/48827d9a6e1e69b51f02f978e67c036853046db4.jpeg', '坚持不懈', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (32, '吴小波', 0, '湖南省', '株洲市', '荷塘区', 650, 'BOBO55555', 0, 0, 0, 0, 0, 0, 0, 0, 1530066887, 1530075110, 1, 2, '从事篮球运动训练2年时间 ，有较深的体育教育经验，', '<div class=\"operationDiv\"><p>阳光开朗</p></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/cert/2018/06/thumb_5b32f7c0231d4.JPG\" style=\"padding-top:5px\"></div>', '', '', '/uploads/images/cert/2018/06/5f0688f91ced5f5995b4ff574a7e3b58b3482f5d.jpeg', '快乐篮球 永不放弃', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (33, '杨勇', 0, '湖南省', '株洲市', '荷塘区', 651, '楊勇', 0, 0, 0, 0, 0, 0, 0, 0, 1530069095, 1530075135, 1, 8, '毕业于武汉体育学院运动训练系篮球专业，具备良好的理论知识及丰富的教学经验，寓教于乐的教学方式，能让孩子提升篮球技战术水平的同时，也能让孩子体验到篮球带来的快乐！', '<div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/cert/2018/06/thumb_5b32fb9383b78.jpg\" style=\"padding-top:5px\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/cert/2018/06/thumb_5b32ff6a135a6.jpg\" style=\"padding-top:5px\"></div><div class=\"operationDiv\"><p>杨勇，毕业于武汉体育学院运动训练系篮球专业</p></div>', '', '', '/uploads/images/cert/2018/06/5bebcd35225116edb877df9a9e3e767fb24b6002.jpeg', '文明其精神，野蛮其体魄', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (34, '张阳', 0, '湖南省', '株洲市', '荷塘区', 678, '413', 0, 0, 0, 0, 0, 0, 0, 0, 1531285798, 1533282047, 1, 3, '执教三年来掌握各种教学技巧 \n能熟练运用各种教学方法教学具有趣味性', '<p class=\"\" style=\"\">！</p>', '', '', '/uploads/images/cert/2018/07/d9fcedcf80b71a75d47cba6056a9dbcad23e94df.jpeg', '快乐篮球 \n快乐成长', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (35, '刘思东', 0, '湖南省', '株洲市', '芦淞区', 696, '跨步走', 0, 0, 0, 0, 0, 0, 0, 0, 1531305075, 1533786639, 1, 1, '带领学生做规范动作以及矫正', '<p class=\"\" style=\"\">我叫刘思东 今注册为教练一职</p><div>多多关照吧</div><p></p>', '', '', '/uploads/images/cert/2018/07/084be2f97f2516d46134817b53ccc53c19429360.jpeg', '让篮球成为孩子们的动力', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (36, '宋鹏飞', 0, '河南省', '郑州市', '中原区', 720, '大飞', 0, 0, 0, 0, 0, 0, 0, 0, 1531571545, 1533282162, 1, 1, '123', '<p class=\"\" style=\"\">&nbsp; 456</p>', '', '请上传身份证正反面的照片以及相关的资质证书，谢谢。', '/uploads/images/cert/2018/07/db0f29dc03d444b1699baf7db278e7384e5ccc1c.jpeg', '成功源于不懈的努力', 1, -1, 2, NULL);
INSERT INTO `coach` VALUES (37, '黄帝强', 0, '广东省', '深圳市', '龙岗区', 1111, '黄维', 0, 0, 0, 0, 0, 0, 0, 0, 1532694898, 1533005964, 1, 1, '训练经验丰富，多数带2-4年级的孩子，主要培养兴趣爱好，提升身体素质', '<p class=\"\" style=\"\">本人训练经验丰富，多数带2-4年级的孩子，主要培养兴趣爱好，提升身体素质</p>', '', '', '/uploads/images/cert/2018/07/4b00a50cda656118255c3f240a7c071335736885.jpeg', '当拾起篮球的那一刻，自信的出发。', 1, 1, 1, NULL);
INSERT INTO `coach` VALUES (38, '试先生', 0, '广东省', '深圳市', '南山区', 1179, 'HOtext', 0, 0, 0, 0, 0, 0, 0, 0, 1533098513, 1533098513, 1, 5, '有好多经验', '<p class=\"\" style=\"\">厉害</p><img src=\"/uploads/images/cret/2018/08/thumb_5b613967b97fc.jpeg\">', '', '', '/uploads/images/cert/2018/08/e16fb4f955efc22fc20efdbfa9d2794017442d7a.jpeg', 'skr', 1, 1, 0, NULL);
INSERT INTO `coach` VALUES (39, '高春友', 0, '广东省', '深圳市', '南山区', 1241, '春友教练', 0, 0, 0, 0, 0, 0, 0, 0, 1534133714, 1534143915, 1, 5, '教好球', '<img src=\"/uploads/images/cret/2018/08/thumb_5b7105a1614de.jpeg\">', '', '', '/uploads/images/cert/2018/08/d0723fed230171bcca3b86d6f7f9f85419018e2d.jpeg', '建立一个完整的计划表，列出行动的时间检视点，以及所要采取的有效行', 1, 1, 1, NULL);

SET FOREIGN_KEY_CHECKS = 1;
