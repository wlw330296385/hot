/*
Navicat MySQL Data Transfer

Source Server         : 30
Source Server Version : 50554
Source Host           : 192.168.1.30:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50554
File Encoding         : 65001

Date: 2017-07-29 18:44:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `__grade_member`
-- ----------------------------
DROP TABLE IF EXISTS `__grade_member`;
CREATE TABLE `__grade_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grade` varchar(60) NOT NULL,
  `grade_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL COMMENT '会员',
  `member_id` int(10) NOT NULL,
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `type` tinyint(4) NOT NULL COMMENT 'member_id所属类型 1:普通学生|2:管理员|3:创建者|4:教练|5体验生|6领队|7班主任',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:待审核;1:正常;2:退出;3:被开除;',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of __grade_member
-- ----------------------------
INSERT INTO `__grade_member` VALUES ('1', '', '0', 'weilin', '1', '', '4', '1', '0', null);
INSERT INTO `__grade_member` VALUES ('3', '3-7岁儿童班', '1', 'coloring', '3', '', '5', '1', '0', null);
INSERT INTO `__grade_member` VALUES ('4', '8-12岁少年班', '2', 'woo', '1', '', '4', '1', '0', null);

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `truename` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `avatar` varchar(200) NOT NULL COMMENT '头像',
  `telephone` bigint(20) DEFAULT NULL COMMENT '手机号',
  `stats` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1正常|0禁用',
  `created_at` int(11) NOT NULL COMMENT '创建时间戳',
  `updated_at` int(11) NOT NULL COMMENT '更新时间戳',
  `logintime` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `lastlogin_at` int(11) NOT NULL COMMENT '最后登录时间',
  `lastlogin_ip` varchar(20) NOT NULL COMMENT '最后登录ip',
  `lastlogin_ua` varchar(200) NOT NULL DEFAULT '' COMMENT '最后登录ua',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', null, null, '/static/default/avatar.png', null, '1', '0', '0', '27', '1501314190', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');

-- ----------------------------
-- Table structure for `bill`
-- ----------------------------
DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bill_id` bigint(20) NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `lesson` varchar(210) NOT NULL,
  `goods_type` tinyint(4) NOT NULL DEFAULT '1',
  `goods_dec` varchar(255) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `balance_pay` decimal(8,2) NOT NULL,
  `score_pay` int(10) NOT NULL DEFAULT '0',
  `pay_type` varchar(60) CHARACTER SET latin1 NOT NULL,
  `callback_str` text NOT NULL,
  `is_pay` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:未支付|1:已支付',
  `pay_time` int(10) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `create_time` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:有效|0:过期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bill
-- ----------------------------

-- ----------------------------
-- Table structure for `camp`
-- ----------------------------
DROP TABLE IF EXISTS `camp`;
CREATE TABLE `camp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `camp` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL COMMENT 'member表id',
  `realname` varchar(60) NOT NULL COMMENT '负责人真实姓名;member表realname',
  `max_member` int(10) NOT NULL DEFAULT '0' COMMENT '最大会员上限,0不限',
  `total_coach` int(10) NOT NULL DEFAULT '0' COMMENT '历史拥有教练数',
  `act_coach` int(10) NOT NULL DEFAULT '0' COMMENT '活跃教练数',
  `total_member` int(10) NOT NULL DEFAULT '0' COMMENT '历史拥有会员数',
  `act_member` int(10) NOT NULL DEFAULT '0' COMMENT '活跃会员数',
  `total_lessons` int(10) NOT NULL DEFAULT '0' COMMENT '课程数量',
  `finished_lessons` int(10) NOT NULL DEFAULT '0' COMMENT '已完成课程',
  `star` decimal(4,2) NOT NULL DEFAULT '0.00' COMMENT '评分',
  `total_grade` int(10) NOT NULL DEFAULT '0' COMMENT '所有班级数量',
  `act_grade` int(10) NOT NULL DEFAULT '0' COMMENT '当前活跃班级数量',
  `logo` varchar(255) DEFAULT '' COMMENT '训练营LOGO',
  `camp_base` int(10) NOT NULL DEFAULT '0' COMMENT '训练点数量',
  `remarks` varchar(255) DEFAULT '' COMMENT '个人备注',
  `sys_remarks` varchar(255) DEFAULT '' COMMENT '平台备注',
  `location` varchar(255) DEFAULT '' COMMENT '具体地址',
  `province` varchar(60) DEFAULT '' COMMENT '省',
  `city` varchar(60) DEFAULT '' COMMENT '市',
  `area` varchar(60) DEFAULT '' COMMENT '区',
  `camp_telephone` varchar(60) DEFAULT '' COMMENT '电话号码, 默认为负责人电话号码',
  `camp_email` varchar(60) DEFAULT '' COMMENT '邮箱，默认为负责人邮箱',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '训练营类型:0 独立用户|1 机构|2 其他',
  `banner` varchar(255) DEFAULT '' COMMENT '封面图',
  `company` varchar(255) DEFAULT '' COMMENT '所属公司, 个人则为空',
  `cert_id` int(11) DEFAULT '0' COMMENT '证件表id',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态:0 待审核|1 正常|2 关闭|3 重新审核',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of camp
-- ----------------------------
INSERT INTO `camp` VALUES ('1', '大热伟霖篮球训练营', '1', 'WL伟霖', '0', '100', '85', '1000', '688', '126', '75', '4.75', '126', '75', '', '5', 'mysql 插入测试数据', '', '罗湖区体育馆', '广东省', '深圳市', '罗湖区', '13410599613', '704671079@qq.com', '0', '', '', '1', '1', '0', '1500965520', null);
INSERT INTO `camp` VALUES ('3', '大热color篮球训练营', '3', '彩铃', '0', '5', '1', '50', '23', '10', '2', '1.25', '6', '2', '', '1', 'msqyl 插入测试数据', '', '不知道那条村的烂地', '广东省', '深圳市', '南山区', '1358687812', '', '0', '', '', '0', '0', '0', '1500630595', null);
INSERT INTO `camp` VALUES ('2', '大热woo训练营', '2', 'alice.wu', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '', '0', '', '', '', '', '', '', '', '', '0', '', '', '0', '0', '0', '0', null);

-- ----------------------------
-- Table structure for `cert`
-- ----------------------------
DROP TABLE IF EXISTS `cert`;
CREATE TABLE `cert` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `cert_no` varchar(60) NOT NULL COMMENT '证件号码',
  `cert_type` tinyint(4) NOT NULL COMMENT '1:身份证;2:学生证;3:资质证书;4:营业执照',
  `photo_positive` varchar(255) NOT NULL COMMENT '证件照正面',
  `photo_back` varchar(255) NOT NULL COMMENT '证件照背面',
  `portrait` varchar(255) NOT NULL COMMENT '肖像',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:未审核|1:正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='证件表';

-- ----------------------------
-- Records of cert
-- ----------------------------
INSERT INTO `cert` VALUES ('1', '1', '0', '', '4', '/uploads/image/cert/20170720/123456.jpg', '/uploads/image/cert/20170720/123456.jpg', '', '0');
INSERT INTO `cert` VALUES ('2', '0', '1', '440301199306022938', '1', '/uploads/image/cert/20170722/3242.jpg', '/uploads/image/cert/20170722/4324.jpg', '', '1');
INSERT INTO `cert` VALUES ('3', '0', '1', '', '3', '/uploads/image/cert/20170722/4563.jpg', '', '', '1');

-- ----------------------------
-- Table structure for `coach`
-- ----------------------------
DROP TABLE IF EXISTS `coach`;
CREATE TABLE `coach` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `student_flow` int(10) NOT NULL COMMENT '学员流量',
  `lesson_flow` int(10) NOT NULL COMMENT '课程流量',
  `kps` decimal(3,1) NOT NULL COMMENT '评分',
  `create_time` int(11) NOT NULL COMMENT '注册日期',
  `update_time` int(10) NOT NULL,
  `coach_rank` tinyint(4) NOT NULL DEFAULT '1' COMMENT '阶衔',
  `cert_id` int(10) NOT NULL COMMENT '资质证书',
  `tag1` varchar(30) NOT NULL COMMENT '标签',
  `tag2` varchar(30) NOT NULL COMMENT '标签',
  `tag3` varchar(30) NOT NULL COMMENT '标签',
  `tag4` varchar(30) NOT NULL COMMENT '标签',
  `tag5` varchar(30) NOT NULL COMMENT '标签',
  `coach_year` tinyint(4) NOT NULL COMMENT '教龄',
  `experience` varchar(255) NOT NULL COMMENT '教学经验描述',
  `remarks` varchar(255) NOT NULL COMMENT 'remarks',
  `remarks_admin` varchar(255) NOT NULL COMMENT '系统备注',
  `portraits` varchar(255) NOT NULL COMMENT '肖像',
  `description` varchar(255) NOT NULL COMMENT '个人宣言',
  `coach_level` tinyint(4) NOT NULL COMMENT '教练等级,按学员流量算',
  `status` tinyint(4) NOT NULL COMMENT '0:未完善信息|1:正常|2:不通过|-1:禁用',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coach
-- ----------------------------
INSERT INTO `coach` VALUES ('1', '1', '10', '2', '5.0', '1500609235', '1500972942', '1', '3', '扩挖2', '', '', '', '', '1', '', '', '', '', '', '0', '1', null);
INSERT INTO `coach` VALUES ('7', '2', '0', '0', '0.0', '0', '1501298323', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '0', '1', null);
INSERT INTO `coach` VALUES ('8', '3', '0', '0', '0.0', '0', '1501298316', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '0', '1', null);

-- ----------------------------
-- Table structure for `court`
-- ----------------------------
DROP TABLE IF EXISTS `court`;
CREATE TABLE `court` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `province` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `area` varchar(60) NOT NULL,
  `court` varchar(255) NOT NULL COMMENT '场地名称',
  `location` varchar(255) NOT NULL COMMENT '具体地址',
  `principal` varchar(60) NOT NULL COMMENT '场地负责人',
  `contract` varchar(20) NOT NULL COMMENT '场地联系电话',
  `remarks` varchar(255) NOT NULL,
  `sys_remarks` varchar(255) NOT NULL COMMENT '系统备注',
  `chip_rent` decimal(8,2) NOT NULL COMMENT '散场',
  `full_rent` decimal(8,2) NOT NULL COMMENT '全场租金',
  `half_rent` decimal(8,2) NOT NULL COMMENT '半场',
  `status` int(10) NOT NULL COMMENT '-1:不通过;1:系统通过;|会员id:会员自己添加的',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of court
-- ----------------------------
INSERT INTO `court` VALUES ('1', '广东省', '深圳市', '罗湖区', '滨河小学篮球场', '深圳市罗湖区红岭路滨河小学', '曾超全', '1257846983', '', '', '0.00', '100.00', '0.00', '1', '0', '0', null);
INSERT INTO `court` VALUES ('2', '广东省', '深圳市', '罗湖区', '罗湖体育馆', '深圳市罗湖区经二路48号', '权哥', '1546368997', '', '', '12.00', '100.00', '50.00', '-1', '0', '0', null);
INSERT INTO `court` VALUES ('3', '广东省', '深圳市', '福田区', '彩田中学篮球场', '深圳市福田区莲花支路彩田村', '张老师', '1367484561', '', '', '15.00', '100.00', '60.00', '0', '0', '0', null);

-- ----------------------------
-- Table structure for `exercise`
-- ----------------------------
DROP TABLE IF EXISTS `exercise`;
CREATE TABLE `exercise` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL COMMENT '作者',
  `camp_id` int(10) NOT NULL DEFAULT '0' COMMENT '0则为平台',
  `camp` varchar(60) NOT NULL DEFAULT '平台' COMMENT '默认平台',
  `exercise` varchar(60) NOT NULL COMMENT '训练项目',
  `pid` int(10) NOT NULL DEFAULT '0',
  `exercise_detail` text NOT NULL,
  `media` varchar(255) NOT NULL COMMENT '视频地址',
  `is_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:不开放;|1:开放',
  `status` tinyint(4) NOT NULL COMMENT '1:启用|0:待审核|>1 用户自己的',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exercise
-- ----------------------------

-- ----------------------------
-- Table structure for `grade`
-- ----------------------------
DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson` varchar(60) NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `grade` varchar(60) NOT NULL COMMENT '班级名称',
  `camp_id` int(10) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) NOT NULL COMMENT '所属训练营',
  `leader` varchar(60) NOT NULL COMMENT '领队',
  `leader_id` int(10) NOT NULL COMMENT '对应member表,领队id',
  `teacher` varchar(60) NOT NULL COMMENT '班主任',
  `teacher_id` int(10) NOT NULL COMMENT '对应member表id',
  `coach` varchar(255) NOT NULL COMMENT '主教练',
  `coach_id` int(10) NOT NULL COMMENT 'id',
  `assistant_ids` varchar(255) NOT NULL COMMENT '副教练id集合',
  `assistant` varchar(255) NOT NULL COMMENT '副教练',
  `students` int(10) NOT NULL COMMENT '学生数量',
  `week` varchar(60) NOT NULL COMMENT '周一/周六',
  `lesson_time` varchar(60) NOT NULL COMMENT '10:50:40-11:50:48,10:50:40-11:50:48',
  `province` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `city` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `area` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `plan` varchar(255) NOT NULL COMMENT '教案',
  `plan_ids` varchar(255) NOT NULL COMMENT '教案id',
  `court` varchar(255) NOT NULL COMMENT '球场',
  `court_id` int(10) NOT NULL COMMENT '场地id',
  `rent` decimal(8,2) NOT NULL,
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:下架;1:正常',
  `delete_time` int(10) DEFAULT NULL,
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grade
-- ----------------------------
INSERT INTO `grade` VALUES ('1', '', '0', '3-7儿童班', '2', '大热woo训练营', 'woo', '2', '', '0', 'woo', '2', '', '', '1', '', '', '', '', '', '', '', '', '0', '0.00', '', '1', null, '0', '0');
INSERT INTO `grade` VALUES ('2', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '1', '大热伟霖篮球训练营', '刘伟霖', '1', '刘伟霖', '1', '刘伟霖', '1', '2', '吴丽文', '2', '周六,周日', '09:30:00', '广东省', '深圳市', '罗湖区', '', '', '滨河小学篮球场', '1', '0.00', '', '1', null, '0', '0');
INSERT INTO `grade` VALUES ('3', '控球后卫进阶暑假班', '0', '控球后卫进阶暑假1班', '1', '大热伟霖篮球训练营', '刘伟霖', '1', '刘伟霖', '1', '刘伟霖', '1', '2,3', '吴丽文,张彩玲', '1', '周六', '15:00:00', '广东省', '深圳市', '罗湖区', '', '', '滨河小学篮球场', '1', '0.00', '', '1', null, '0', '0');
INSERT INTO `grade` VALUES ('4', '高中综合篮球暑假课程', '3', '高中综合篮球暑假-彩玲班', '3', '大热color篮球训练营', '张彩玲', '3', '张彩玲', '3', '张彩玲', '8', '', '', '1', '周五,周六', '09:30:00', '', '', '', '', '', '彩田中学篮球场', '3', '0.00', '测试数据', '1', null, '0', '0');

-- ----------------------------
-- Table structure for `grade_category`
-- ----------------------------
DROP TABLE IF EXISTS `grade_category`;
CREATE TABLE `grade_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '课程分类名',
  `status` tinyint(4) NOT NULL COMMENT '状态:1正常|-1禁用|0默认',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='课程分类';

-- ----------------------------
-- Records of grade_category
-- ----------------------------
INSERT INTO `grade_category` VALUES ('1', '幼儿篮球兴趣班', '1', '0', '0', '0');
INSERT INTO `grade_category` VALUES ('2', '幼儿兴趣班（月卡）', '1', '0', '0', '1');
INSERT INTO `grade_category` VALUES ('3', '幼儿兴趣班（季度卡）', '1', null, null, '1');
INSERT INTO `grade_category` VALUES ('4', '幼儿兴趣班（半年卡）', '1', null, null, '1');
INSERT INTO `grade_category` VALUES ('5', '幼儿兴趣班（4-6岁）', '1', null, null, '1');
INSERT INTO `grade_category` VALUES ('6', '基础篮球课程', '1', null, null, '0');
INSERT INTO `grade_category` VALUES ('7', '小学 - 基础班（7-9岁）', '1', null, null, '6');
INSERT INTO `grade_category` VALUES ('8', '小学 - 基础班（10-12岁）', '1', null, null, '6');
INSERT INTO `grade_category` VALUES ('9', '初中 - 基础班（13-15岁）', '1', null, null, '6');
INSERT INTO `grade_category` VALUES ('10', '高中 - 基础班（16-18岁）', '1', null, null, '6');
INSERT INTO `grade_category` VALUES ('11', '综合篮球课程', '1', null, null, '0');
INSERT INTO `grade_category` VALUES ('12', '小学 - 综合班（7-9岁）', '1', null, null, '11');
INSERT INTO `grade_category` VALUES ('13', '小学 - 综合班（10-12岁）', '1', null, null, '11');
INSERT INTO `grade_category` VALUES ('14', '初中 - 综合班（13-15岁）', '1', null, null, '11');
INSERT INTO `grade_category` VALUES ('15', '高中 - 综合班（16-18岁）', '1', null, null, '11');
INSERT INTO `grade_category` VALUES ('16', '强化篮球课程', '1', null, null, '0');
INSERT INTO `grade_category` VALUES ('17', '小学 - 强化班（7-9岁）', '1', null, null, '16');
INSERT INTO `grade_category` VALUES ('18', '小学 - 强化班（10-12岁）', '1', null, null, '16');
INSERT INTO `grade_category` VALUES ('19', '初中 - 强化班（13-15岁）', '1', null, null, '16');
INSERT INTO `grade_category` VALUES ('20', '高中 - 强化班（16-18岁）', '1', null, null, '16');
INSERT INTO `grade_category` VALUES ('21', '篮球队课程', '1', null, null, '0');
INSERT INTO `grade_category` VALUES ('22', '迷你球队（6-7岁）', '1', null, null, '21');
INSERT INTO `grade_category` VALUES ('23', '低年组球队（7-9岁）', '1', null, null, '21');
INSERT INTO `grade_category` VALUES ('24', '高年组球队（9-12岁）', '1', null, null, '21');
INSERT INTO `grade_category` VALUES ('25', '小学校队（7-12岁）', '1', null, null, '21');
INSERT INTO `grade_category` VALUES ('26', '初高中球队（13-18岁）', '1', null, null, '21');
INSERT INTO `grade_category` VALUES ('27', '特色训练课程', '1', null, null, '0');
INSERT INTO `grade_category` VALUES ('28', '集训营', '1', null, null, '27');
INSERT INTO `grade_category` VALUES ('29', '超级射手课程（10岁以上）', '1', null, null, '27');
INSERT INTO `grade_category` VALUES ('30', '超级控球手课程', '1', null, null, '27');
INSERT INTO `grade_category` VALUES ('31', '花式篮球班', '1', null, null, '27');
INSERT INTO `grade_category` VALUES ('32', '篮球节拍班', '1', null, null, '27');
INSERT INTO `grade_category` VALUES ('33', '其他', '1', null, null, '0');
INSERT INTO `grade_category` VALUES ('34', '私教（4-18岁）', '1', null, null, '33');
INSERT INTO `grade_category` VALUES ('35', '体验班（4-18岁）', '1', null, null, '33');
INSERT INTO `grade_category` VALUES ('36', '课外活动（4-18岁）', '1', null, null, '33');
INSERT INTO `grade_category` VALUES ('37', '校园兴趣班（4-18岁）', '1', null, null, '33');
INSERT INTO `grade_category` VALUES ('38', '企业（事业单位）', '1', null, null, '33');

-- ----------------------------
-- Table structure for `grade_member`
-- ----------------------------
DROP TABLE IF EXISTS `grade_member`;
CREATE TABLE `grade_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grade` varchar(60) NOT NULL,
  `grade_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL COMMENT '所属训练营',
  `coach_id` int(10) NOT NULL,
  `coach` varchar(60) NOT NULL,
  `member` varchar(60) NOT NULL COMMENT '会员',
  `member_id` int(10) NOT NULL,
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `type` tinyint(4) NOT NULL COMMENT 'member_id所属类型 1:普通学生|2:管理员|3:创建者|4:教练|5体验生|6领队|7班主任',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:待审核;1:正常;2:退出;3:被开除;|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grade_member
-- ----------------------------
INSERT INTO `grade_member` VALUES ('1', '', '0', '1', '大热伟霖篮球训练营', '0', '', 'weilin', '1', '', '4', '1', '0', null);
INSERT INTO `grade_member` VALUES ('3', '3-7岁儿童班', '2', '2', '大热woo训练营', '2', 'woo', 'coloring', '3', '', '5', '1', '0', null);
INSERT INTO `grade_member` VALUES ('4', '8-12岁少年班', '1', '2', '大热woo训练营', '1', 'woo', 'woo', '1', '', '4', '1', '0', null);
INSERT INTO `grade_member` VALUES ('5', '小学暑期篮球基础1班', '2', '1', '大热伟霖篮球训练营', '0', '', '陈烈准', '2', '', '1', '1', '0', null);
INSERT INTO `grade_member` VALUES ('6', '控球后卫进阶暑假1班', '3', '1', '大热伟霖篮球训练营', '0', '', '陈烈候', '3', '', '1', '1', '0', null);
INSERT INTO `grade_member` VALUES ('7', '小学暑期篮球基础1班', '2', '1', '大热伟霖篮球训练营', '0', '', '吴光蔚', '4', '', '5', '1', '0', null);
INSERT INTO `grade_member` VALUES ('8', '高中综合篮球暑假-彩玲班', '4', '2', '大热color篮球训练营', '8', '张彩玲', '陈烈准', '2', '', '1', '1', '0', null);

-- ----------------------------
-- Table structure for `lesson`
-- ----------------------------
DROP TABLE IF EXISTS `lesson`;
CREATE TABLE `lesson` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson` varchar(60) NOT NULL COMMENT '课程名称',
  `member` varchar(60) NOT NULL COMMENT '发布者',
  `member_id` int(10) NOT NULL,
  `leader_id` int(10) NOT NULL COMMENT '负责财务的老大',
  `leader` varchar(60) NOT NULL COMMENT 'leader',
  `gradecate` varchar(60) NOT NULL COMMENT '课程类型',
  `gradecate_id` int(10) NOT NULL COMMENT '选择类型',
  `camp` varchar(60) NOT NULL COMMENT '所属训练营名称',
  `camp_id` int(10) NOT NULL COMMENT '所属训练营id',
  `cost` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '每个课时单价',
  `total` tinyint(10) NOT NULL DEFAULT '1' COMMENT '总课时数量',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '购买课程需要积分',
  `coach` varchar(60) NOT NULL COMMENT '主教练',
  `coach_id` int(10) NOT NULL COMMENT '副教练',
  `assistant` text NOT NULL COMMENT '副教练',
  `assistant_ids` text NOT NULL COMMENT '副教练id集合',
  `min` int(10) NOT NULL DEFAULT '1' COMMENT '最少开课学生数量',
  `max` int(10) NOT NULL COMMENT '最大开课学生数量',
  `week` varchar(60) NOT NULL COMMENT '周六,周三',
  `start` date NOT NULL COMMENT '开始日期',
  `end` date NOT NULL COMMENT '结束日期',
  `lesson_time` time NOT NULL COMMENT '具体上课时间',
  `province` varchar(60) NOT NULL COMMENT '省',
  `city` varchar(60) NOT NULL COMMENT '市',
  `area` varchar(60) NOT NULL COMMENT '区',
  `court_id` int(10) NOT NULL COMMENT '场地id',
  `court` varchar(255) NOT NULL COMMENT '场地名称',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:未审核;1:正常;-1:禁止',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lesson
-- ----------------------------
INSERT INTO `lesson` VALUES ('1', '小学暑期篮球基础', '', '0', '1', '刘伟霖', '小学 - 基础班（7-9岁）', '7', '大热伟霖篮球训练营', '1', '100.00', '10', '0', '刘伟霖', '1', '', '', '1', '10', '周六,周日', '2017-07-29', '2017-08-27', '09:30:00', '', '', '', '0', '', '测试数据', '1', '0', '0', null);
INSERT INTO `lesson` VALUES ('2', '控球后卫进阶暑假班', '', '0', '1', '刘伟霖', '超级控球手课程', '30', '大热伟霖篮球训练营', '1', '150.00', '5', '0', '刘伟霖', '1', '', '', '1', '5', '周六', '2017-07-29', '2017-08-26', '15:00:00', '', '', '', '0', '', '测试数据', '0', '0', '0', null);
INSERT INTO `lesson` VALUES ('3', '高中综合篮球暑假课程', '张彩玲', '3', '3', '张彩玲', '高中 - 综合班（16-18岁）', '15', '大热color篮球训练营', '3', '100.00', '1', '0', '张彩玲', '3', '', '', '5', '10', '周五,周六', '2017-07-07', '2017-08-26', '10:00:00', '', '', '', '3', '彩田中学篮球场', '', '0', '0', '0', null);

-- ----------------------------
-- Table structure for `log_admindo`
-- ----------------------------
DROP TABLE IF EXISTS `log_admindo`;
CREATE TABLE `log_admindo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `username` varchar(100) DEFAULT NULL COMMENT '管理员名字',
  `doing` varchar(255) DEFAULT NULL COMMENT '操作事件',
  `url` varchar(100) DEFAULT NULL COMMENT '操作页面',
  `ip` varchar(50) NOT NULL COMMENT 'ip',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_admindo
-- ----------------------------
INSERT INTO `log_admindo` VALUES ('1', '1', 'admin', '系统设置 修改 失败', '/admin/system/index', '0.0.0.0', '1500361466');
INSERT INTO `log_admindo` VALUES ('2', '1', 'admin', '系统设置 修改 成功', '/admin/system/index', '0.0.0.0', '1500361483');
INSERT INTO `log_admindo` VALUES ('3', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1500437844');
INSERT INTO `log_admindo` VALUES ('4', '1', 'admin', '审核训练营 审核通过 成功', '/admin/camp/detail', '0.0.0.0', '1500455444');
INSERT INTO `log_admindo` VALUES ('5', '1', 'admin', '审核训练营 审核通过 成功', '/admin/camp/detail', '0.0.0.0', '1500455501');
INSERT INTO `log_admindo` VALUES ('6', '1', 'admin', '审核训练营id: 2 审核不通过 成功', '/admin/camp/detail', '0.0.0.0', '1500455602');
INSERT INTO `log_admindo` VALUES ('7', '1', 'admin', '训练营id:1修改平台备注 失败', '/admin/camp/detail', '0.0.0.0', '1500456728');
INSERT INTO `log_admindo` VALUES ('8', '1', 'admin', '训练营id:1 修改平台备注 失败', '/admin/camp/detail', '0.0.0.0', '1500456781');
INSERT INTO `log_admindo` VALUES ('9', '1', 'admin', '训练营id:1 修改平台备注 失败', '/admin/camp/detail', '0.0.0.0', '1500456791');
INSERT INTO `log_admindo` VALUES ('10', '1', 'admin', '训练营id:1 修改平台备注 失败', '/admin/camp/detail', '0.0.0.0', '1500456826');
INSERT INTO `log_admindo` VALUES ('11', '1', 'admin', '训练营id:1 修改平台备注 成功', '/admin/camp/detail', '0.0.0.0', '1500456848');
INSERT INTO `log_admindo` VALUES ('12', '1', 'admin', '训练营id:2 软删除 成功', '/admin/camp/sdel/id/2', '0.0.0.0', '1500457656');
INSERT INTO `log_admindo` VALUES ('13', '1', 'admin', '训练营id:2 软删除 成功', '/admin/camp/sdel/id/2', '0.0.0.0', '1500458003');
INSERT INTO `log_admindo` VALUES ('14', '1', 'admin', '训练营id:1 软删除 成功', '/admin/camp/sdel/id/1', '0.0.0.0', '1500458114');
INSERT INTO `log_admindo` VALUES ('15', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1500524341');
INSERT INTO `log_admindo` VALUES ('16', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1500603051');
INSERT INTO `log_admindo` VALUES ('17', '1', 'admin', '审核训练营id: 1 审核通过 成功', '/admin/camp/audit', '0.0.0.0', '1500606268');
INSERT INTO `log_admindo` VALUES ('18', '1', 'admin', '审核训练营id: 1 审核通过 成功', '/admin/camp/audit', '0.0.0.0', '1500606318');
INSERT INTO `log_admindo` VALUES ('19', '1', 'admin', '训练营id:1 修改平台备注 成功', '/admin/camp/edit', '0.0.0.0', '1500606952');
INSERT INTO `log_admindo` VALUES ('20', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1500607572');
INSERT INTO `log_admindo` VALUES ('21', '1', 'admin', '系统设置 修改 失败', '/admin/system/index', '0.0.0.0', '1500607933');
INSERT INTO `log_admindo` VALUES ('22', '1', 'admin', '系统设置 修改 成功', '/admin/system/index', '0.0.0.0', '1500607942');
INSERT INTO `log_admindo` VALUES ('23', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1500619048');
INSERT INTO `log_admindo` VALUES ('24', '1', 'admin', '审核训练营id: 2 审核通过 成功', '/admin/camp/audit', '0.0.0.0', '1500630595');
INSERT INTO `log_admindo` VALUES ('25', '1', 'admin', '审核训练营id: 1 审核操作 失败', '/admin/coach/audit', '0.0.0.0', '1500698148');
INSERT INTO `log_admindo` VALUES ('26', '1', 'admin', '审核训练营id: 1 审核操作 失败', '/admin/coach/audit', '0.0.0.0', '1500698195');
INSERT INTO `log_admindo` VALUES ('27', '1', 'admin', '审核训练营id: 1 审核操作 失败', '/admin/coach/audit', '0.0.0.0', '1500698212');
INSERT INTO `log_admindo` VALUES ('28', '1', 'admin', '审核训练营id: 1 审核操作 失败', '/admin/coach/audit', '0.0.0.0', '1500698276');
INSERT INTO `log_admindo` VALUES ('29', '1', 'admin', '审核训练营id: 1 审核操作 失败', '/admin/coach/audit', '0.0.0.0', '1500698285');
INSERT INTO `log_admindo` VALUES ('30', '1', 'admin', '审核训练营id: 1 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1500698782');
INSERT INTO `log_admindo` VALUES ('31', '1', 'admin', '审核教练id: 1 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1500698997');
INSERT INTO `log_admindo` VALUES ('32', '1', 'admin', '教练id:1 软删除 成功', '/admin/coach/sdel/id/1', '0.0.0.0', '1500699547');
INSERT INTO `log_admindo` VALUES ('33', '1', 'admin', '教练id:1 软删除 成功', '/admin/coach/sdel/id/1', '0.0.0.0', '1500699689');
INSERT INTO `log_admindo` VALUES ('34', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1500702731');
INSERT INTO `log_admindo` VALUES ('35', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1500706829');
INSERT INTO `log_admindo` VALUES ('36', '1', 'admin', '审核教练id: 1 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1500707190');
INSERT INTO `log_admindo` VALUES ('37', '1', 'admin', '审核教练id: 1 审核不通过 成功', '/admin/coach/audit', '0.0.0.0', '1500707672');
INSERT INTO `log_admindo` VALUES ('38', '1', 'admin', '教练id:1 修改平台备注 成功', '/admin/coach/edit', '0.0.0.0', '1500712997');
INSERT INTO `log_admindo` VALUES ('39', '1', 'admin', '审核训练营id: 1 审核通过 成功', '/admin/camp/audit', '127.0.0.1', '1500715816');
INSERT INTO `log_admindo` VALUES ('40', '1', 'admin', '审核训练营id: 1 审核通过 成功', '/admin/camp/audit', '0.0.0.0', '1500964974');
INSERT INTO `log_admindo` VALUES ('41', '1', 'admin', '审核训练营id: 1 审核通过 成功', '/admin/camp/audit', '0.0.0.0', '1500965520');
INSERT INTO `log_admindo` VALUES ('42', '1', 'admin', '审核教练id: 1 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1500965876');
INSERT INTO `log_admindo` VALUES ('43', '1', 'admin', '审核教练id: 1 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1500972489');
INSERT INTO `log_admindo` VALUES ('44', '1', 'admin', '审核教练id: 1 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1500972942');
INSERT INTO `log_admindo` VALUES ('45', '1', 'admin', '课程id:1 软删除 成功', '/admin/lesson/sdel/id/1', '0.0.0.0', '1501051754');
INSERT INTO `log_admindo` VALUES ('46', '1', 'admin', '审核课程id: 1 审核通过 成功', '/admin/lesson/audit', '0.0.0.0', '1501059315');
INSERT INTO `log_admindo` VALUES ('47', '1', 'admin', '审核教练id: 8 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1501298316');
INSERT INTO `log_admindo` VALUES ('48', '1', 'admin', '审核教练id: 7 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1501298323');
INSERT INTO `log_admindo` VALUES ('49', '1', 'admin', '审核场地id: 1 审核操作 失败', '/admin/court/audit', '0.0.0.0', '1501313613');
INSERT INTO `log_admindo` VALUES ('50', '1', 'admin', '审核场地id: 1 审核通过 成功', '/admin/court/audit', '0.0.0.0', '1501313682');
INSERT INTO `log_admindo` VALUES ('51', '1', 'admin', '审核场地id: 2 审核通过 成功', '/admin/court/audit', '0.0.0.0', '1501313693');
INSERT INTO `log_admindo` VALUES ('52', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1501314190');

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(64) NOT NULL COMMENT '微信授权即产生',
  `member` varchar(60) NOT NULL COMMENT '用户名',
  `nickname` varchar(60) NOT NULL COMMENT '微信授权即产生',
  `avatar` varchar(60) NOT NULL COMMENT '微信授权即产生',
  `telephone` bigint(11) NOT NULL COMMENT '电话号码',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `email` varchar(60) NOT NULL COMMENT '电子邮箱',
  `realname` varchar(30) NOT NULL COMMENT '真实姓名',
  `province` varchar(60) NOT NULL COMMENT '省',
  `city` varchar(60) NOT NULL COMMENT '市',
  `location` varchar(255) NOT NULL COMMENT '居住地址',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `height` decimal(4,1) NOT NULL COMMENT '身高,单位cm',
  `weight` decimal(4,1) NOT NULL COMMENT '体重,单位cm',
  `shoe_code` decimal(4,1) NOT NULL COMMENT '鞋码,单位mm',
  `birthday` date NOT NULL COMMENT '生日',
  `create_time` int(10) NOT NULL COMMENT '注册时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '根据流量自动分',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '推荐人',
  `cert_id` int(10) NOT NULL COMMENT '证件id',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `flow` int(10) NOT NULL COMMENT '流量',
  `balance` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '人民币余额',
  `remarks` varchar(255) NOT NULL COMMENT 'remarks',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('1', '', 'weilin', 'WL伟霖', '/static/default/avatar.png', '13410599613', '', '704671079@qq.com', '刘伟霖', '广东省', '深圳市', '罗湖区深南东路京基100花园E1栋26C', '1', '192.0', '0.0', '44.0', '1993-06-02', '1234567890', '0', '1', '0', '2', '0', '0', '0.00', 'mysql 插入测试数据', null);
INSERT INTO `member` VALUES ('2', '', 'alice.wu', 'woo', '/static/default/avatar.png', '1358687812', '', 'alicewu@hot-basketball.com', '吴丽文', '广东省', '深圳市', '南山区不知道那条村x栋xxx号', '2', '165.0', '80.0', '38.0', '1992-12-06', '1236549875', '0', '1', '0', '0', '0', '0', '0.00', 'mysql 手动插入 测试数据', null);
INSERT INTO `member` VALUES ('3', '', 'coloring', '彩玲', '', '12334455334', '', '', '张彩玲', '', '', '', '0', '0.0', '0.0', '0.0', '0000-00-00', '0', '0', '1', '0', '0', '0', '0', '0.00', '', null);
INSERT INTO `member` VALUES ('4', '', 'legend', '', '/static/default/avatar.png', '1585461234', '', '', '陈烈准', '广东省', '深圳市', '', '1', '0.0', '0.0', '0.0', '0000-00-00', '0', '0', '1', '1', '0', '0', '0', '0.00', '测试数据', null);
INSERT INTO `member` VALUES ('5', '', 'ho', '', '/static/default/avatar.png', '1369874512', '', '', '陈烈候', '广东省', '深圳市', '', '1', '0.0', '0.0', '0.0', '0000-00-00', '0', '0', '1', '1', '0', '0', '0', '0.00', '测试数据', null);
INSERT INTO `member` VALUES ('6', '', 'will', '', '/static/default/avatar.png', '1594561263', '', '', '吴光蔚', '广东省', '深圳市', '', '1', '0.0', '0.0', '0.0', '0000-00-00', '0', '0', '1', '1', '0', '0', '0', '0.00', '', null);

-- ----------------------------
-- Table structure for `membertype`
-- ----------------------------
DROP TABLE IF EXISTS `membertype`;
CREATE TABLE `membertype` (
  `membertype_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '角色名称',
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`membertype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='会员角色表';

-- ----------------------------
-- Records of membertype
-- ----------------------------
INSERT INTO `membertype` VALUES ('1', '训练营负责人', '0', null);
INSERT INTO `membertype` VALUES ('2', '教练', '0', null);
INSERT INTO `membertype` VALUES ('3', '学生', '0', null);
INSERT INTO `membertype` VALUES ('4', '领队', '0', null);
INSERT INTO `membertype` VALUES ('5', '体验生', '0', null);
INSERT INTO `membertype` VALUES ('6', '班主任', '0', null);

-- ----------------------------
-- Table structure for `plan`
-- ----------------------------
DROP TABLE IF EXISTS `plan`;
CREATE TABLE `plan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member` varchar(60) NOT NULL COMMENT '作者',
  `member_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL COMMENT '所属训练营,如果是平台,为0',
  `camp` varchar(60) NOT NULL COMMENT '所属训练营,如果是平台,为0',
  `outline` varchar(250) NOT NULL COMMENT '大纲',
  `outline_detail` text NOT NULL,
  `exercise_id` int(10) NOT NULL,
  `exercise` text NOT NULL,
  `grade_category_id` int(10) NOT NULL,
  `grade_category` varchar(200) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '0:平台|1训练营',
  `is_open` int(4) NOT NULL DEFAULT '1' COMMENT '0:不开放|1:开放',
  `status` tinyint(4) NOT NULL COMMENT '0:未审核|1:正常|2:不通过',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plan
-- ----------------------------
INSERT INTO `plan` VALUES ('1', '', '1', '1', '11', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', null);
INSERT INTO `plan` VALUES ('2', '1', '1', '2', '1', '1', '1', '1', '1', '1', '', '1', '1', '1', '1', '1', null);
INSERT INTO `plan` VALUES ('11', '', '1', '3', '11', '11', '1', '1', '1', '1', '', '0', '1', '1', '1', '1', null);
INSERT INTO `plan` VALUES ('12', '', '1', '2', '2', '2', '2', '2', '2', '2', '', '2', '2', '0', '0', '0', null);

-- ----------------------------
-- Table structure for `salary_in`
-- ----------------------------
DROP TABLE IF EXISTS `salary_in`;
CREATE TABLE `salary_in` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salary` decimal(8,2) NOT NULL COMMENT '佣金',
  `score` int(10) NOT NULL COMMENT '积分',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `realname` varchar(60) NOT NULL,
  `level` tinyint(4) NOT NULL COMMENT '用户当前等级',
  `rank` tinyint(4) NOT NULL COMMENT '用户当前阶衔',
  `lesson_id` int(10) NOT NULL,
  `lesson` varchar(60) NOT NULL COMMENT '课程',
  `star` decimal(3,1) NOT NULL COMMENT '评分',
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `pay_time` int(10) NOT NULL COMMENT '支付时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:  1:成功|0:失败',
  `member_type` varchar(255) NOT NULL COMMENT '用户身份[教练|班主任|领队|副教练|机构]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统发放佣金';

-- ----------------------------
-- Records of salary_in
-- ----------------------------

-- ----------------------------
-- Table structure for `salary_out`
-- ----------------------------
DROP TABLE IF EXISTS `salary_out`;
CREATE TABLE `salary_out` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salary` decimal(8,2) NOT NULL COMMENT '佣金',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `realname` varchar(60) NOT NULL COMMENT '真实姓名',
  `telephone` bigint(11) NOT NULL,
  `ident` bigint(20) NOT NULL COMMENT '身份证号',
  `openid` varchar(64) NOT NULL,
  `alipay` varchar(64) NOT NULL COMMENT '支付宝号',
  `bank_no` varchar(64) NOT NULL COMMENT '银行卡号',
  `bank` varchar(30) NOT NULL COMMENT '银行',
  `fee` decimal(6,2) NOT NULL COMMENT '手续费',
  `pay_time` int(10) NOT NULL,
  `is_pay` tinyint(4) NOT NULL,
  `callback_str` text NOT NULL COMMENT '支付回调',
  `create_time` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态,用于对冲;0:无效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金提现';

-- ----------------------------
-- Records of salary_out
-- ----------------------------

-- ----------------------------
-- Table structure for `schedule`
-- ----------------------------
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL COMMENT '所属训练营',
  `camp` varchar(255) NOT NULL COMMENT '训练营',
  `lesson` varchar(255) NOT NULL COMMENT '课程名称',
  `lesson_id` int(10) NOT NULL COMMENT '课程id',
  `grade` varchar(255) NOT NULL COMMENT '班级',
  `grade_id` int(10) NOT NULL COMMENT '班级id',
  `grade_category_id` int(10) NOT NULL,
  `grade_category` varchar(240) NOT NULL,
  `teacher` varchar(60) NOT NULL COMMENT '班主任',
  `teacher_id` int(10) NOT NULL COMMENT 'id',
  `coach` varchar(60) NOT NULL COMMENT '教练',
  `coach_id` int(10) NOT NULL COMMENT 'member表id',
  `students` int(10) NOT NULL COMMENT '上课学生总数',
  `student_str` text NOT NULL COMMENT '来上课的学生姓名集合,隔开',
  `assistant_ids` varchar(255) NOT NULL COMMENT 'ids',
  `assistant` varchar(255) NOT NULL COMMENT '助教',
  `leave_ids` varchar(255) NOT NULL COMMENT 'ids',
  `leave` varchar(255) NOT NULL COMMENT '请假人员总数',
  `lesson_date` date NOT NULL COMMENT '训练日期,2017-7-26',
  `teacher_plan_id` int(10) NOT NULL COMMENT 'id',
  `teacher_plan` varchar(255) NOT NULL COMMENT '教案',
  `lesson_time` datetime NOT NULL COMMENT '上课时间,17:17:33',
  `province` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `city` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `area` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `court_id` int(10) NOT NULL,
  `court` varchar(255) NOT NULL COMMENT '默认为课程地址',
  `rent` decimal(6,2) NOT NULL COMMENT '场地租金',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:正常|0:草稿|-1:删除',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of schedule
-- ----------------------------
INSERT INTO `schedule` VALUES ('1', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2', '吴丽文', '', '', '2017-07-29', '0', '', '2017-07-29 09:30:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);
INSERT INTO `schedule` VALUES ('2', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2', '吴丽文', '', '', '2017-07-30', '0', '', '2017-07-30 09:30:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);
INSERT INTO `schedule` VALUES ('3', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2', '吴丽文', '', '', '2017-08-05', '0', '', '2017-08-05 09:30:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);
INSERT INTO `schedule` VALUES ('4', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2', '吴丽文', '', '', '2017-08-06', '0', '', '2017-08-06 09:30:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);
INSERT INTO `schedule` VALUES ('5', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2', '吴丽文', '', '', '2017-08-12', '0', '', '2017-08-12 09:30:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);
INSERT INTO `schedule` VALUES ('6', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2', '吴丽文', '', '', '2017-08-13', '0', '', '2017-08-13 09:30:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);
INSERT INTO `schedule` VALUES ('7', '1', '大热伟霖篮球训练营', '控球后卫进阶暑假班', '2', '控球后卫进阶暑假1班', '3', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2,3', '吴丽文,张彩玲', '', '', '2017-07-29', '0', '', '2017-07-29 15:00:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);
INSERT INTO `schedule` VALUES ('8', '1', '大热伟霖篮球训练营', '控球后卫进阶暑假班', '2', '控球后卫进阶暑假1班', '3', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2,3', '吴丽文,张彩玲', '', '', '2017-08-05', '0', '', '2017-08-05 15:00:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);
INSERT INTO `schedule` VALUES ('9', '1', '大热伟霖篮球训练营', '控球后卫进阶暑假班', '2', '控球后卫进阶暑假1班', '3', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '2,3', '吴丽文,张彩玲', '', '', '2017-08-12', '0', '', '2017-08-12 15:00:00', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '0.00', '', '0', null);

-- ----------------------------
-- Table structure for `schedule_member`
-- ----------------------------
DROP TABLE IF EXISTS `schedule_member`;
CREATE TABLE `schedule_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL,
  `schedule` varchar(240) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:学生|1:教练',
  `status` tinyint(4) NOT NULL COMMENT '0:请假|1:正常',
  `schedule_time` int(10) NOT NULL COMMENT '上课时间',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课时-会员关系';

-- ----------------------------
-- Records of schedule_member
-- ----------------------------

-- ----------------------------
-- Table structure for `setting`
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` varchar(255) NOT NULL,
  `memberlevel1` int(10) NOT NULL COMMENT '升级到等级1所需积分',
  `memberlevel2` int(10) NOT NULL COMMENT '升级到等级2所需积分',
  `memberlevel3` int(10) NOT NULL,
  `coachlevel1` int(10) NOT NULL,
  `coachlevel2` int(10) NOT NULL,
  `coachlevel3` int(10) NOT NULL,
  `keywords` varchar(255) NOT NULL DEFAULT '关键词',
  `description` varchar(255) NOT NULL DEFAULT '大热篮球',
  `footer` varchar(255) NOT NULL DEFAULT 'copyright@2016,备案111',
  `title` varchar(255) NOT NULL DEFAULT 'HOT',
  `wxappid` varchar(64) NOT NULL,
  `wxsecret` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL DEFAULT 'logo',
  `lrss` int(10) NOT NULL COMMENT '上一节课平台奖励积分',
  `lrcs` int(10) NOT NULL COMMENT 'lesion_return_coach_score',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:不启用|1:启用',
  `coachlevel1award` int(10) NOT NULL COMMENT '升级到等级1给予的奖励,单位:分',
  `coachlevel2award` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO `setting` VALUES ('1', '大热篮球平台', '1', '0', '0', '0', '0', '0', '大热篮球平台', '大热篮球平台', '© 2017 1Zstudio. All Rights Reserved.', 'HOT 大热篮球平台', '', '', '/static/default/logo.jpg', '5', '3', '1', '0', '0');

-- ----------------------------
-- Table structure for `student`
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `member` varchar(60) NOT NULL COMMENT '对应member表的昵称',
  `student` varchar(60) NOT NULL COMMENT '学生姓名',
  `birthday` date NOT NULL,
  `parent_id` int(10) NOT NULL COMMENT '父母id',
  `parent` varchar(60) NOT NULL COMMENT '家长姓名',
  `emergency_telephone` bigint(11) NOT NULL COMMENT '紧急电话',
  `school` varchar(255) NOT NULL COMMENT '学校',
  `student_cherate` varchar(255) NOT NULL COMMENT '性格特点',
  `student_weight` decimal(8,2) NOT NULL COMMENT '单位kg',
  `student_height` decimal(8,2) NOT NULL COMMENT '学生身高单位cm',
  `student_shoe_code` varchar(60) NOT NULL COMMENT '鞋码',
  `total_lesson` int(10) NOT NULL DEFAULT '0' COMMENT '全部课程',
  `finished_total` int(10) NOT NULL COMMENT '已上课程',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('1', '1', 'woo', '', '0000-00-00', '0', 'alice', '18888888888', '阳光小学', '', '0.00', '0.00', '', '1', '0', null);
INSERT INTO `student` VALUES ('2', '4', '陈烈准', '', '0000-00-00', '0', '', '0', '南山小学', '', '0.00', '0.00', '', '0', '0', null);
INSERT INTO `student` VALUES ('3', '5', '陈烈候', '', '0000-00-00', '0', '', '0', '南山中学', '', '0.00', '0.00', '', '0', '0', null);
INSERT INTO `student` VALUES ('4', '6', '吴光蔚', '', '0000-00-00', '0', '', '0', '南山小学', '', '0.00', '0.00', '', '0', '0', null);
