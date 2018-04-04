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

 Date: 04/04/2018 14:08:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for camp
-- ----------------------------
DROP TABLE IF EXISTS `camp`;
CREATE TABLE `camp`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(10) NOT NULL COMMENT 'member表id',
  `realname` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '负责人真实姓名;member表realname',
  `max_member` int(10) NOT NULL DEFAULT 0 COMMENT '最大会员上限,0不限',
  `total_coach` int(10) NOT NULL DEFAULT 0 COMMENT '历史拥有教练数',
  `act_coach` int(10) NOT NULL DEFAULT 0 COMMENT '活跃教练数',
  `total_member` int(10) NOT NULL DEFAULT 0 COMMENT '历史拥有会员数',
  `act_member` int(10) NOT NULL DEFAULT 0 COMMENT '活跃会员数',
  `total_lessons` int(10) NOT NULL DEFAULT 0 COMMENT '课程数量',
  `finished_lessons` int(10) NOT NULL DEFAULT 0 COMMENT '已完成课程',
  `star` int(11) NOT NULL DEFAULT 0 COMMENT '评分总分数',
  `star_num` int(11) NOT NULL DEFAULT 0 COMMENT '评分次数',
  `total_grade` int(10) NOT NULL DEFAULT 0 COMMENT '所有班级数量',
  `act_grade` int(10) NOT NULL DEFAULT 0 COMMENT '当前活跃班级数量',
  `total_events` int(11) NOT NULL DEFAULT 0 COMMENT '活动数量',
  `total_schedule` int(10) NOT NULL DEFAULT 0,
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '/static/frontend/images/uploadDefault.jpg' COMMENT '训练营LOGO',
  `camp_base` int(10) NOT NULL DEFAULT 0 COMMENT '训练点数量',
  `remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '个人备注',
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '平台备注',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '具体地址',
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '省',
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '市',
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '区',
  `camp_telephone` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '电话号码, 默认为负责人电话号码',
  `camp_email` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '邮箱，默认为负责人邮箱',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '训练营类型:0 独立用户|1 机构|2 其他',
  `banner` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '/static/frontend/images/uploadDefault.jpg' COMMENT '封面图',
  `company` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '所属公司, 个人则为空',
  `cert_id` int(11) NULL DEFAULT 0 COMMENT '证件表id',
  `hot` int(10) NOT NULL DEFAULT 0 COMMENT '热度,越高越热,点击率或者搜索度',
  `camp_introduction` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `camp_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练营宣言',
  `balance` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '训练营营业额',
  `score` int(10) NOT NULL COMMENT '训练营积分',
  `rebate_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:第一种结算方式|2:第二种结算方式',
  `status` tinyint(4) NULL DEFAULT 0 COMMENT '状态:0 待审核|1 正常|2 关闭|3 重新审核',
  `balance_true` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '可提现营业额',
  `schedule_rebate` decimal(6, 2) NOT NULL DEFAULT 0.10 COMMENT '课时收入平台抽取比例(空值按setting表sysrebate)',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `delete_time` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of camp
-- ----------------------------
INSERT INTO `camp` VALUES (1, '大热体适能中心', 2, '大热篮球2', 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2017/09/59ca092820279.JPG', 2, '', '', '', '广东省', '深圳市', '南山区', '18565717133', '', 2, '/uploads/images/banner/2017/09/59ca0953d9cab.JPG', '大热总部', 0, 1, '<div class=\"operationDiv\"><p>大热室内训练</p></div>', '大热室内训练', 0.00, 0, 1, 2, 0.00, 0.10, 1506412380, 1516271307, NULL);
INSERT INTO `camp` VALUES (2, '大热前海训练营', 3, '大热篮球1', 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2017/09/59ca0937e193b.jpg', 2, '', '', '', '广东省', '深圳市', '南山区', '15820474733', '', 2, '/uploads/images/banner/2017/09/59ca099495b13.jpg', '大热总部', 0, 1, '<div class=\"operationDiv\"><p>欢迎加入大热篮球训练营</p></div>', '欢迎加入大热篮球训练营', 1050.00, 0, 1, 2, 0.00, 0.10, 1506412380, 1506414356, 20180124);
INSERT INTO `camp` VALUES (3, '猴赛雷训练营', 1, '陈侯', 0, 0, 0, 19, 0, 1, 0, 0, 0, 2, 0, 2, 2, '/uploads/images/banner/2017/09/59ca09d5916c4.jpg', 3, '', '', '深圳总部', '广东省', '深圳市', '南山区', '13823599611', '', 2, '/uploads/images/banner/2017/10/59d8e043195d6.jpg', '大热总部', 0, 1, '<div class=\"operationDiv\"><p>大热猴塞雷</p></div>', '大热猴塞雷', 108.50, 0, 1, 1, 0.00, 0.10, 1506412381, 1507385417, NULL);
INSERT INTO `camp` VALUES (4, '准行者训练营', 6, '陈烈准', 0, 0, 0, 26, 0, 8, 0, 0, 0, 4, 0, 3, 3, '/uploads/images/banner/2018/01/thumb_5a683919c996e.jpeg', 9, '', '', '', '广东省', '深圳市', '南山区', '13826505160', '', 0, '/uploads/images/banner/2017/09/59ca14360c76b.JPG', '', 0, 1, '<div class=\"operationDiv\"><p>I believe I can fly!</p></div>', 'I believe I can fly!', 18.10, 0, 1, 1, 0.00, 0.10, 1506415619, 1516779807, NULL);
INSERT INTO `camp` VALUES (5, '荣光训练营', 7, '张伟荣', 0, 0, 0, 102, 0, 1, 0, 0, 0, 7, 0, 2, 11, '/uploads/images/banner/2017/12/5a39e655a8277.jpg', 11, '', '', '', '广东省', '深圳市', '福田区', '15018514302', '', 2, '/uploads/images/banner/2017/12/5a39e6214b56e.jpg', '', 0, 1, '<div class=\"operationDiv\"><p>荣光训练营</p></div>', '荣光训练营', 81.90, 0, 1, 2, 0.00, 0.10, 1506565273, 1513743966, NULL);
INSERT INTO `camp` VALUES (9, '大热篮球俱乐部', 2, '大热篮球', 0, 0, 0, 351, 0, 20, 0, 20, 4, 22, 0, 16, 313, '/uploads/images/banner/2017/09/59ce0f0bb2253.JPG', 5, '', '系统增加balance=3150,2017年10月18日15:37:31,系统增加余额=31920+840,total_member+1; 2017年12月22日:woo减少余额5130,196600-5310=191290; 2018年1月2日 系统增加balance = 202360.00+1350 = 203710  2018年1月19日balance = 223870-990 = 222880;2018年1月22日系统减少余额balance = 261670.00-36990 = 224680 2018年1月23日blance=263020.90 -450 = 262570.9', '深圳南山阳光文体中心', '广东省', '深圳市', '南山区', '15820474733', '', 1, '/uploads/images/banner/2018/01/thumb_5a67e9b7b9c8a.JPG', '大热体育文化（深圳）有限公司', 0, 0, '<div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/banner/2018/02/thumb_5a8d812888f6b.JPG\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div><div class=\"operationDiv\"><p>&nbsp;\"大热篮球\"是一个专门从事青少年篮球发展的教育品牌，自2011年，“大热篮球”融合了国内外先进的训练及管理方法，根据青少年篮球爱好者的年龄特征，设计了多种既符合其身心发展需要，又顾及兴趣需求的活动形式。孩子们在教练员启发与带领下通过创新和科学的锻炼方法，增强了体质，提高了动作的协调性、灵活性，而且培养了勇敢、坚韧的精神品质和乐于分享和协作的团队精神。</p></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/banner/2018/02/thumb_5a8d812818852.JPG\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/banner/2018/02/thumb_5a8d81285ce1a.JPG\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div><div class=\"operationDiv\"><p></p></div><div class=\"operationDiv\"><p></p></div><div class=\"operationDiv\"><p></p></div>', '全面推广青少年篮球运动，培养幼儿对篮球运动的兴趣，让孩子在体验篮球乐趣的同时，培养从小爱好运动的习惯，从而增强体质，健康成长。', 336270.70, 0, 1, 1, 17499.00, 0.10, 1506676445, 1519223138, NULL);
INSERT INTO `camp` VALUES (13, 'AKcross训练营', 18, '安凯翔', 0, 0, 0, 96, 0, 5, 0, 5, 1, 6, 0, 0, 121, '/uploads/images/banner/2017/12/5a39ddf63d709.jpeg', 7, '', '系统修改balance = 24295-1350 = 22945', '', '广东省', '深圳市', '南山区', '18566201712', '', 0, '/uploads/images/banner/2017/12/5a39de1eb74c5.jpeg', '大热篮球', 0, 0, '<div class=\"operationDiv\"><p>这一秒不放弃，下一秒就有希望</p></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/banner/2018/03/thumb_5aa9ee88e8046.png\" style=\"padding-top:5px\"></div>', '这一秒不放弃，下一秒就有希望', 86924.40, 0, 1, 1, 13299.00, 0.10, 1507951263, 1521086095, NULL);
INSERT INTO `camp` VALUES (14, 'Ball  is  life', 17, '董硕同', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2017/10/59e1839a81d25.jpeg', 0, '', '', '', '广东省', '深圳市', '南山区', '13172659677', '', 0, '/uploads/images/banner/2017/10/59e183b19362c.jpeg', '', 0, 0, '<div class=\"operationDiv\"><p>练就对了</p></div>', '练就对了', 0.00, 0, 1, 1, 0.00, 0.10, 1507951319, 1507966910, NULL);
INSERT INTO `camp` VALUES (15, '钟声训练营', 19, '钟声', 0, 0, 0, 108, 0, 5, 0, 10, 2, 8, 0, 0, 149, '/uploads/images/banner/2018/01/5a4b65ee091ec.jpeg', 5, '', '系统增加balance=1050,时间2017年10月18日17:26:30,历史会员+1,余额30450+1050,时间2017年10月27日10:53:10;系统增加历史会员+1,余额32550+1050;系统增加历史会员=52+1,余额=45150+1050,时间2017年11月3日15:08:30，时间2018年1月5日11:15:30,历史会员+1,余额76020+1500;2018年1月10日营业额 = 85960+200 = 86160', '深圳南山前海花园三期会所', '广东省', '深圳市', '南山区', '15999557852', '', 1, '/uploads/images/banner/2018/01/5a4b65f7a2c5a.jpeg', '钟声篮球训练营', 0, 0, '<div class=\"operationDiv\"><p>专注校园青少年专业篮球培训，培养青少年专业篮球培训，培训课目幼儿班，7至9岁低年级班，9至12岁高年级班，初中班，校园音乐篮球操班，中考班，企业班等专业篮球教学培训指导。</p></div>', '专注校园青少年专业篮球培训，培养青少年专业篮球培训', 86150.00, 0, 1, 1, 4180.00, 0.10, 1508037092, 1522703350, NULL);
INSERT INTO `camp` VALUES (16, '热风学校', 11, '陈永仁', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2017/10/59e2d345277ff.JPG', 2, '', '', '深圳湾', '广东省', '深圳市', '南山区', '', '', 1, '/uploads/images/banner/2017/10/59e2d35c3b1d1.JPG', '大热集团', 0, 0, '<div class=\"operationDiv\"><p>热风籃球社團</p></div>', '', 0.00, 0, 1, 1, 0.00, 0.10, 1508037396, 1508041161, NULL);
INSERT INTO `camp` VALUES (17, 'FIT', 16, '林泽铭', 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, '/static/frontend/images/uploadDefault.jpg', 0, NULL, '', '', '广东省', '深圳市', '南山区', '13717147667', '', 2, '/uploads/images/banner/2017/12/5a38f8c29bdac.jpeg', '大热篮球', 0, 0, '<div class=\"operationDiv\"><p>do it</p></div>', 'do it', 900.00, 0, 1, 1, 0.00, 0.10, 1509449155, 1513683173, NULL);
INSERT INTO `camp` VALUES (18, '劉嘉興', 5, '劉嘉興', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2017/11/5a069d9a6be7c.jpg', 0, NULL, NULL, '', '广东省', '深圳市', '南山区', '', '', 1, '/uploads/images/banner/2017/11/5a069dc32f067.jpg', '', 0, 0, '', '', 0.00, 0, 1, 0, 0.00, 0.10, 1510382967, 1510383060, NULL);
INSERT INTO `camp` VALUES (19, '17体适能', 12, '吴光蔚', 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 2, 0, '/uploads/images/banner/2018/01/thumb_5a675e8b2f894.jpeg', 0, NULL, NULL, '深圳湾一号', '广东省', '深圳市', '南山区', '13684925727', '', 1, '/uploads/images/banner/2018/01/thumb_5a6759205db7c.jpeg', '深圳市壹造文化传播有限公司', 0, 0, '<div class=\"operationDiv\"><p>敏捷，力量，速度，反应，柔韧</p></div>', '敏捷，力量，速度，反应，柔韧', 0.00, 0, 1, 1, 0.00, 0.10, 1513146153, 1516723852, NULL);
INSERT INTO `camp` VALUES (29, '深圳市南山区桃源街道篮球协会', 228, '杨超林', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2017/12/5a337f0ddd3fe.jpg', 0, NULL, NULL, '深圳市南山区学苑大道西段桃源街道文体站三楼', '广东省', '深圳市', '南山区', '18688943424', '', 1, '/uploads/images/banner/2017/12/5a339440e600e.png', '深圳市南山区桃源街道篮球协会', 0, 0, '<div class=\"operationDiv\"><p>桃源街道篮球协会以普及和篮球运动为使命，主要和政府部门合作，在全深圳范围开展公益篮球培训，把专业的少儿篮球训练带入各个社区，以篮球运动为媒介，让孩子们养成体育锻炼习惯，增强身体素质，培养意志品质，培育健全人格。</p></div>', '让孩子们养成体育锻炼习惯，增强身体素质，培养意志品质，培育健全人格。', 0.00, 0, 1, 1, 0.00, 0.10, 1513324275, 1513329730, NULL);
INSERT INTO `camp` VALUES (36, 'RUN体能训练营', 431, '林润', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2018/01/thumb_5a5e15e36a603.jpeg', 0, NULL, NULL, '', '广东省', '深圳市', '南山区', '13559152812', '', 0, '/uploads/images/banner/2018/01/thumb_5a5e15ebbd75f.jpeg', '', 0, 0, '<div class=\"operationDiv\"><p>力量，耐力，爆发力，体能提升</p></div>', '力量，耐力，爆发力，体能提升', 0.00, 0, 1, 1, 0.00, 0.10, 1516115357, 1516183116, NULL);
INSERT INTO `camp` VALUES (31, 'wow篮球兴趣训练营', 8, '吴丽文', 0, 0, 0, 10, 0, 1, 0, 5, 1, 1, 0, 1, 2, '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 1, NULL, NULL, '', '广东省', '深圳市', '南山区', '18507717466', '', 0, '/uploads/images/banner/2017/12/5a39dcb48112b.jpeg', '', 0, 0, '<div class=\"operationDiv\"><p>专注培养幼儿篮球兴趣，发扬体育精神！</p></div>', '专注培养幼儿篮球兴趣，发扬体育精神！', 8.90, 0, 1, 1, 0.00, 0.10, 1513741459, 1513741612, NULL);
INSERT INTO `camp` VALUES (32, '燕子Happy篮球训练营', 9, '高艳', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2017/12/5a3a304600acf.jpeg', 16, NULL, NULL, '广东省深圳市南山区桂庙路西阳光文体中心一层B111大热篮球', '广东省', '深圳市', '龙华新区', '13662270560', '', 1, '/uploads/images/banner/2017/12/5a3a3069a1de5.jpeg', '', 0, 0, '<div class=\"operationDiv\"><p>专注于幼儿和青少年篮球兴趣的培养，锻炼身体的同时，提高孩子四肢协调性和篮球基础知识的培养，根据不同年龄段的孩子制定不同的课程，快乐篮球，让孩子爱上篮球，爱上运动。</p></div>', '快乐篮球，让孩子爱上篮球，爱上运动。', 0.00, 0, 1, 1, 0.00, 0.10, 1513744809, 1514174678, NULL);
INSERT INTO `camp` VALUES (33, 'B—Ball 篮球训练营', 21, '张文清', 0, 0, 0, 10, 0, 2, 0, 0, 0, 1, 0, 0, 0, '/uploads/images/banner/2018/03/thumb_5aa1f8a2e0a3a.jpg', 6, NULL, NULL, '', '广东省', '深圳市', '南山区', '13692692153', '', 0, '/uploads/images/banner/2018/03/thumb_5aa1f8a8b14b9.jpg', '', 0, 0, '<div class=\"operationDiv\"><p>专业</p></div>', '汗水', 7.00, 0, 1, 1, 0.00, 0.10, 1514256932, 1520564416, NULL);
INSERT INTO `camp` VALUES (34, 'BALON篮球训练营', 14, '冼玉华', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/static/frontend/images/uploadDefault.jpg', 0, NULL, NULL, '', '广东省', '深圳市', '南山区', '13480839509', '', 0, '/uploads/images/banner/2017/12/5a41bd9c5042f.jpg', '', 0, 0, '<div class=\"operationDiv\"><p>提倡健康篮球，增强体魄</p></div>', '提倡健康篮球，增强体魄', 0.00, 0, 1, 1, 0.00, 0.10, 1514257427, 1514257836, NULL);
INSERT INTO `camp` VALUES (35, '顶峰篮球训练营', 385, '任杰', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2018/01/5a52f000777e8.jpg', 1, NULL, NULL, '龙华区田茜路3号隆丰体育中心11栋', '广东省', '深圳市', '龙华新区', '18928492948', '', 1, '/uploads/images/banner/2018/01/5a52f02b1257e.jpg', '深圳市顶峰体育发展有限公司', 0, 0, '<div class=\"operationDiv\"><p>顶峰课程以“篮球育人”为理念，综合吸收ＮＢＡ、ＣＢＡ先进训练理念和方法并提炼国内外成功教育科研成果，而形成的一套独特的“专业篮球训练”和“篮球育人”理论体系和方法课程。不仅让孩子提高篮球技术、强健体魄，而且会让孩子通过篮球运动体验，培养参加篮球运动的兴趣，增强自信，享受运动的快乐及对其人生的启迪与思考，学会如何做人做事等综合素质，终达到高格局高定位的超级青少年的育人目的，成为社会的栋梁。位于龙华区隆丰体育中心的顶峰篮球俱乐部是深圳市顶峰体育发展有限公司投资200多万打造的一个集篮球培训、赛事运营、篮球运动于一体高档篮球综合性会所。</p></div>', '“专业篮球训练”、“篮球育人”', 0.00, 0, 1, 0, 0.00, 0.10, 1515150518, 1516271154, NULL);
INSERT INTO `camp` VALUES (37, '展梦体育', 456, '汪楚丰', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2018/01/thumb_5a682a162da7b.jpg', 0, NULL, NULL, '', '广东省', '深圳市', '南山区', '18948322626', '', 1, '/uploads/images/banner/2018/01/thumb_5a682a2a9d8bd.jpg', '', 0, 0, '<div class=\"operationDiv\"><p>篮球培训</p></div>', '篮球培训', 0.00, 0, 1, 1, 0.00, 0.10, 1516775444, 1516868441, NULL);
INSERT INTO `camp` VALUES (38, '大热篮球前海分部', 3, '张文清', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2018/03/thumb_5a98f0e982d1f.jpg', 0, NULL, NULL, '', '广东省', '深圳市', '福田区', '15820474733', '', 1, '/uploads/images/banner/2018/03/thumb_5a98f10fb3605.JPG', '', 0, 0, '<div class=\"operationDiv\"><h5>共产党几乎都会疯狂更加繁荣</h5></div>', '抵用券扔了两个功能空间', 0.00, 0, 1, 0, 0.00, 0.10, 1519972414, 1520326396, 1520326396);
INSERT INTO `camp` VALUES (39, '伟霖训练营', 4, '刘伟霖', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '/uploads/images/banner/2018/03/thumb_5a9e5622b7874.jpg', 0, NULL, NULL, '', '广东省', '深圳市', '南山区', '13410599613', '', 0, '/uploads/images/banner/2018/03/thumb_5a9e56243cfa1.jpg', '', 0, 0, '<div class=\"operationDiv\"><p>感刚刚</p></div>', '我很帅', 0.00, 0, 1, 0, 0.00, 0.10, 1520326172, 1520326286, 1520326286);

SET FOREIGN_KEY_CHECKS = 1;
