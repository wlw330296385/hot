/*
Navicat MySQL Data Transfer

Source Server         : 30
Source Server Version : 50554
Source Host           : 192.168.1.30:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50554
File Encoding         : 65001

Date: 2017-09-23 18:50:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `__camp_power`
-- ----------------------------
DROP TABLE IF EXISTS `__camp_power`;
CREATE TABLE `__camp_power` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL COMMENT '角色名称',
  `coach` tinyint(4) NOT NULL DEFAULT '0' COMMENT '有教练权限就是1',
  `admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '管理员',
  `owner` tinyint(4) NOT NULL DEFAULT '0' COMMENT '拥有者',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='会员角色表\r\n暂时废弃';

-- ----------------------------
-- Records of __camp_power
-- ----------------------------
INSERT INTO `__camp_power` VALUES ('7', '1', '0', '0', '0', '0', '0', '0', null);
INSERT INTO `__camp_power` VALUES ('8', '2', '0', '0', '0', '0', '0', '0', null);
INSERT INTO `__camp_power` VALUES ('9', '3', '0', '0', '0', '0', '0', '0', null);
INSERT INTO `__camp_power` VALUES ('10', '4', '0', '0', '0', '0', '0', '0', null);
INSERT INTO `__camp_power` VALUES ('11', '5', '0', '0', '0', '0', '0', '0', null);
INSERT INTO `__camp_power` VALUES ('12', '6', '0', '0', '0', '0', '0', '0', null);

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
-- Table structure for `__schedule_media`
-- ----------------------------
DROP TABLE IF EXISTS `__schedule_media`;
CREATE TABLE `__schedule_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of __schedule_media
-- ----------------------------

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
INSERT INTO `admin` VALUES ('1', 'admin', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', null, null, '/static/default/avatar.png', null, '1', '0', '0', '54', '1505979546', '192.168.1.62', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.79 Safari/537.36');

-- ----------------------------
-- Table structure for `bankcard`
-- ----------------------------
DROP TABLE IF EXISTS `bankcard`;
CREATE TABLE `bankcard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bank` varchar(60) NOT NULL COMMENT '账号类型:支付宝|银行卡',
  `bank_card` varchar(60) NOT NULL COMMENT '账号',
  `bank_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:银行卡|2:支付宝',
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `realname` varchar(60) NOT NULL COMMENT '卡的真实姓名,不是会员的真实姓名',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) DEFAULT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='个人金融账户,支付宝,银行卡';

-- ----------------------------
-- Records of bankcard
-- ----------------------------
INSERT INTO `bankcard` VALUES ('1', '农业银行', '9999999999999999999', '1', '伟霖', '1', '大蠢驴', '0', null, null);
INSERT INTO `bankcard` VALUES ('2', '工商银行', '6541236547987461', '1', 'woo', '2', '大聪明', '0', null, null);
INSERT INTO `bankcard` VALUES ('3', '工商银行', '789654569874563210', '1', '伟霖', '1', '大笨猪', '0', null, null);
INSERT INTO `bankcard` VALUES ('4', '支付宝', 'wsd12342@qq.com', '2', 'woo', '1', '支付宝主人', '0', null, null);

-- ----------------------------
-- Table structure for `bill`
-- ----------------------------
DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bill_order` varchar(20) NOT NULL COMMENT '订单号',
  `goods_id` int(10) NOT NULL COMMENT '1:对应lesson.id;|2:对应goods.id',
  `goods` varchar(210) NOT NULL,
  `total` tinyint(4) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `price` decimal(8,2) NOT NULL COMMENT '每节课的单价',
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `goods_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品类型 1:课程|2:其他',
  `goods_des` varchar(255) NOT NULL COMMENT '商品描述',
  `student_id` int(10) NOT NULL,
  `student` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `balance_pay` decimal(8,2) NOT NULL COMMENT '支付人民币',
  `score_pay` int(10) NOT NULL DEFAULT '0' COMMENT '支付积分',
  `remarks` varchar(240) NOT NULL,
  `pay_type` varchar(60) NOT NULL COMMENT '支付类型 wxpay:微信支付|alipay:支付宝',
  `callback_str` text NOT NULL,
  `is_pay` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:未支付|1:已支付|-1:申请退款|-2:已退款',
  `pay_time` int(10) NOT NULL COMMENT '支付时间',
  `update_time` int(11) NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:有效|0:无效',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bill
-- ----------------------------
INSERT INTO `bill` VALUES ('1', '12017081216085464101', '1', '小学暑期篮球基础', '10', '100.00', '1', '大热伟霖篮球训练营', '1', '刘小霖报名小学暑期篮球基础', '1', '刘小霖', '1', '刘伟霖', '1000.00', '0', '备注', 'wxpay', '', '1', '0', '1502525972', '1502525972', null, '1');
INSERT INTO `bill` VALUES ('2', '12017083011051264101', '1', '小学暑期篮球基础', '10', '100.00', '1', '大热伟霖篮球训练营', '1', '刘小霖报名小学暑期篮球基础', '1', '刘小霖', '1', '刘伟霖', '1000.00', '0', '备注', 'wxpay', 'callback', '1', '1505556848', '1504062355', '1504062355', null, '1');
INSERT INTO `bill` VALUES ('3', '12017083011051264102', '3', '大热woo测试班', '10', '100.00', '1', '大热为邻训练营', '1', '', '3', '吴晓文', '2', 'woo', '1000.00', '0', '', '', 'callback', '1', '1505556328', '1505553476', '1505553476', null, '1');
INSERT INTO `bill` VALUES ('4', '1201709191806365232', '4', '大热wooooo高级班', '20', '9999.99', '1', '大热伟霖篮球训练营', '1', '吴宝宝购买大热wooooo高级班', '6', '吴宝宝', '1', 'weilin', '0.00', '99', '', '', '', '0', '0', '1505815597', '1505815597', null, '1');
INSERT INTO `bill` VALUES ('5', '1201709191806576900', '4', '大热wooooo高级班', '20', '9999.99', '1', '大热伟霖篮球训练营', '1', '吴宝宝购买大热wooooo高级班', '6', '吴宝宝', '1', 'weilin', '0.00', '99', '', '', '', '0', '0', '1505815617', '1505815617', null, '1');
INSERT INTO `bill` VALUES ('6', '1201709191807531458', '4', '大热wooooo高级班', '20', '9999.99', '1', '大热伟霖篮球训练营', '1', '吴宝宝购买大热wooooo高级班', '6', '吴宝宝', '1', 'weilin', '0.00', '99', '', '', '', '0', '0', '1505815673', '1505815673', null, '1');
INSERT INTO `bill` VALUES ('7', '1201709191808437278', '4', '大热wooooo高级班', '20', '9999.99', '1', '大热伟霖篮球训练营', '1', '吴宝宝购买大热wooooo高级班', '6', '吴宝宝', '1', 'weilin', '0.00', '99', '', '', '', '0', '0', '1505815724', '1505815724', null, '1');
INSERT INTO `bill` VALUES ('8', '1201709191809461798', '4', '大热wooooo高级班', '20', '9999.99', '1', '大热伟霖篮球训练营', '1', '吴宝宝购买大热wooooo高级班', '6', '吴宝宝', '1', 'weilin', '0.00', '99', '', '', '', '0', '0', '1505815787', '1505815787', null, '1');
INSERT INTO `bill` VALUES ('9', '1201709191815154742', '4', '大热wooooo高级班', '20', '9999.99', '1', '大热伟霖篮球训练营', '1', '吴宝宝购买大热wooooo高级班', '6', '吴宝宝', '1', 'weilin', '0.00', '99', '', '', '', '0', '0', '1505816116', '1505816116', null, '1');
INSERT INTO `bill` VALUES ('10', '1201709191821367224', '4', '大热wooooo高级班', '20', '9999.99', '1', '大热伟霖篮球训练营', '1', '吴宝宝购买大热wooooo高级班', '6', '吴宝宝', '1', 'weilin', '0.00', '99', '无', 'wxpay', '', '0', '0', '1505816499', '1505816499', null, '1');
INSERT INTO `bill` VALUES ('11', '1201709Wed, 20 Sep 2', '1', 'woo测试版', '1', '8888.00', '1', '大热伟霖篮球训练营', '1', '吴宝宝预约体验woo测试版', '6', '吴宝宝', '1', 'weilin', '0.00', '0', '无', '', '0', '1', '0', '1505890164', '1505890164', null, '1');
INSERT INTO `bill` VALUES ('12', '1201709201450346860', '1', 'woo测试版', '1', '8888.00', '1', '大热伟霖篮球训练营', '1', '吴宝宝预约体验woo测试版', '6', '吴宝宝', '1', 'weilin', '0.00', '0', '无', '', '0', '1', '0', '1505890236', '1505890236', null, '1');
INSERT INTO `bill` VALUES ('13', '1201709201458466772', '1', 'woo测试版', '1', '8888.00', '1', '大热伟霖篮球训练营', '1', '吴宝宝预约体验woo测试版', '6', '吴宝宝', '1', 'weilin', '0.00', '0', '无', '', '0', '1', '0', '1505890845', '1505890845', null, '1');
INSERT INTO `bill` VALUES ('14', '1201709201501222597', '1', 'woo测试版', '1', '8888.00', '1', '大热伟霖篮球训练营', '1', '吴宝宝预约体验woo测试版', '6', '吴宝宝', '1', 'weilin', '0.00', '0', '无', '', '0', '1', '0', '1505890884', '1505890884', null, '1');
INSERT INTO `bill` VALUES ('15', '1201709201503397453', '1', 'woo测试版', '1', '8888.00', '1', '大热伟霖篮球训练营', '1', '吴宝宝预约体验woo测试版', '6', '吴宝宝', '1', 'weilin', '0.00', '0', '无', '', '0', '1', '0', '1505891025', '1505891025', null, '1');

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
  `total_schedule` int(10) NOT NULL DEFAULT '0',
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
  `hot` int(10) NOT NULL DEFAULT '0' COMMENT '热度,越高越热,点击率或者搜索度',
  `camp_introduction` text NOT NULL,
  `balance` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '训练营余额',
  `score` int(10) NOT NULL COMMENT '训练营积分',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态:0 待审核|1 正常|2 关闭|3 重新审核',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of camp
-- ----------------------------
INSERT INTO `camp` VALUES ('1', '大热伟霖篮球训练营', '1', 'WL伟霖', '0', '100', '85', '1000', '688', '126', '75', '4.75', '126', '75', '0', '/uploads/images/lesson/1.jpg', '5', 'mysql 插入测试数据', '', '罗湖区体育馆', '广东省', '深圳市', '罗湖区', '13410599613', '704671079@qq.com', '0', '/uploads/images/lesson/1.jpg', '', '1', '0', '我们希望通过实施“迷你篮球”的活动概念，培养幼儿对篮球运动的兴趣，让孩子在体验篮球乐趣的同时，培养从小爱好运动的习惯', '0.00', '0', '1', '0', '1500965520', null);
INSERT INTO `camp` VALUES ('3', '大热color篮球训练营', '3', '彩铃', '0', '5', '1', '50', '23', '10', '2', '1.25', '6', '2', '0', '/uploads/images/lesson/1.jpg', '1', 'msqyl 插入测试数据', '', '不知道那条村的烂地', '广东省', '深圳市', '南山区', '1358687812', '', '0', '/uploads/images/lesson/1.jpg', '', '0', '0', '我们希望通过实施“迷你篮球”的活动概念，培养幼儿对篮球运动的兴趣，让孩子在体验篮球乐趣的同时，培养从小爱好运动的习惯', '0.00', '0', '1', '0', '1500630595', null);
INSERT INTO `camp` VALUES ('2', '大热woo训练营', '2', 'alice.wu', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '/uploads/images/lesson/1.jpg', '0', '', '', '', '', '', '', '', '', '0', '/uploads/images/lesson/1.jpg', '', '0', '0', '我们希望通过实施“迷你篮球”的活动概念，培养幼儿对篮球运动的兴趣，让孩子在体验篮球乐趣的同时，培养从小爱好运动的习惯', '0.00', '0', '1', '0', '1500965520', null);
INSERT INTO `camp` VALUES ('4', '扩挖2', '1', '吴丽文', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '', '0', '', '', '', '', '', '', '18500000000', '', '0', '', '', '0', '0', '', '0.00', '0', '0', '0', '0', null);
INSERT INTO `camp` VALUES ('11', 'hot心训练营', '35', '刘伟霖', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '', '0', '', '', '京基100', '广东省', '珠海市', '南湾区', '13410599613', '', '0', '/uploads/images/banner/2017/09/59c364c77ef8c.jpg', '', '0', '0', '方式的发送到发送到', '0.00', '0', '1', '0', '1505979628', null);

-- ----------------------------
-- Table structure for `camp_comment`
-- ----------------------------
DROP TABLE IF EXISTS `camp_comment`;
CREATE TABLE `camp_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `comment` text NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of camp_comment
-- ----------------------------
INSERT INTO `camp_comment` VALUES ('1', '1', '大热为邻篮球训练营', '很好,不错', 'woo', '2', '/static/default/avatar.png', '1234567890', '0', null);

-- ----------------------------
-- Table structure for `camp_member`
-- ----------------------------
DROP TABLE IF EXISTS `camp_member`;
CREATE TABLE `camp_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `remarks` varchar(255) NOT NULL DEFAULT '申请加入' COMMENT '备注',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1:粉丝|1:学生|2:教练|3:管理员|4:创建者',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:待审核|1:正常|2:退出|-1:被辞退|3:''已毕业''|-2:被拒绝',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='训练营身份权限表';

-- ----------------------------
-- Records of camp_member
-- ----------------------------
INSERT INTO `camp_member` VALUES ('1', '1', '大热伟霖篮球训练营', '1', 'weilin', '申请加入', '4', '1', '0', null, '0');
INSERT INTO `camp_member` VALUES ('2', '2', '大热woo训练营', '2', 'woo', '申请加入', '1', '1', '0', null, '0');
INSERT INTO `camp_member` VALUES ('3', '2', '大热woo训练营', '1', 'weilin', '申请加入', '1', '1', '0', null, '0');
INSERT INTO `camp_member` VALUES ('4', '1', '大热伟霖篮球训练营', '2', 'woo', '申请加入', '3', '1', '0', null, '0');
INSERT INTO `camp_member` VALUES ('5', '1', '大热伟霖篮球训练营', '3', 'coloring', '申请加入', '1', '1', '0', null, '0');
INSERT INTO `camp_member` VALUES ('6', '1', '大热伟霖篮球训练营', '4', '吴光蔚', '申请加入', '2', '1', '0', null, '0');
INSERT INTO `camp_member` VALUES ('7', '3', '大热color篮球训练营', '1', 'weilin', '申请加入', '2', '1', '0', null, '0');
INSERT INTO `camp_member` VALUES ('12', '11', 'hot心训练营', '35', '刘伟霖', '申请加入', '4', '1', '1505558451', null, '1505558451');
INSERT INTO `camp_member` VALUES ('22', '1', '大热伟霖篮球训练营', '1', 'weilin', '申请加入', '5', '0', '0', null, '0');
INSERT INTO `camp_member` VALUES ('23', '1', '大热伟霖篮球训练营', '1', 'weilin', '申请加入', '2', '0', '0', null, '0');
INSERT INTO `camp_member` VALUES ('24', '1', '大热伟霖篮球训练营', '1', 'weilin', '申请加入', '3', '0', '0', null, '0');
INSERT INTO `camp_member` VALUES ('25', '11', 'hot心训练营', '2', 'woo', '123', '2', '1', '0', null, '0');

-- ----------------------------
-- Table structure for `cert`
-- ----------------------------
DROP TABLE IF EXISTS `cert`;
CREATE TABLE `cert` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL COMMENT '所属训练营id',
  `member_id` int(10) NOT NULL COMMENT '用户id',
  `cert_no` varchar(60) NOT NULL COMMENT '证件号码',
  `cert_type` tinyint(4) NOT NULL COMMENT '1:身份证;2:学生证;3:教练资质证书;4:营业执照|5:银行卡',
  `photo_positive` varchar(255) NOT NULL COMMENT '证件照正面',
  `photo_back` varchar(255) NOT NULL COMMENT '证件照背面',
  `portrait` varchar(255) NOT NULL COMMENT '肖像',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:未审核|1:正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='证件表';

-- ----------------------------
-- Records of cert
-- ----------------------------
INSERT INTO `cert` VALUES ('1', '1', '1', '', '4', '/uploads/images/cert/2017/07/123456.jpg', '/uploads/images/cert/2017/07/123456.jpg', '', '1', '0', '0');
INSERT INTO `cert` VALUES ('2', '0', '1', '', '1', '/uploads/images/cert/2017/07/3242.jpg', '/uploads/images/cert/2017/07/4324.jpg', '', '1', '0', '0');
INSERT INTO `cert` VALUES ('3', '0', '1', '', '3', '/uploads/images/cert/2017/07/4563.jpg', '/uploads/images/cert/2017/07/4324.jpg', '', '1', '0', '0');
INSERT INTO `cert` VALUES ('14', '0', '35', '440301199306022938', '1', '/uploads/images/cert/2017/09/59c5f229cb6c9.jpg', '/uploads/images/cert/2017/09/59c5f12fc0afd.jpg', '', '0', '0', '1506144893');
INSERT INTO `cert` VALUES ('15', '0', '35', '0', '3', '/uploads/images/cert/2017/09/59c5f13449181.jpg', '', '', '0', '0', '1506144893');
INSERT INTO `cert` VALUES ('16', '11', '0', '', '4', '/uploads/images/cert/2017/09/59c36911dc6ab.jpg', '', '', '0', '0', '1505987408');
INSERT INTO `cert` VALUES ('17', '11', '0', '440301199306022938', '1', '', '', '', '0', '0', '1505987409');
INSERT INTO `cert` VALUES ('18', '11', '35', '', '1', '', '', '', '0', '0', '1505987409');
INSERT INTO `cert` VALUES ('19', '11', '0', '', '0', '', '', '', '0', '0', '1505987409');

-- ----------------------------
-- Table structure for `coach`
-- ----------------------------
DROP TABLE IF EXISTS `coach`;
CREATE TABLE `coach` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coach` varchar(60) NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:男:2女',
  `province` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `area` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `student_flow` int(10) NOT NULL COMMENT '学员流量',
  `lesson_flow` int(10) NOT NULL COMMENT '课程流量',
  `star` decimal(3,1) NOT NULL COMMENT '评分',
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
  `introduction` text NOT NULL,
  `remarks` varchar(255) NOT NULL COMMENT 'remarks',
  `sys_remarks` varchar(255) NOT NULL COMMENT '系统备注',
  `portraits` varchar(255) NOT NULL COMMENT '肖像',
  `description` varchar(255) NOT NULL COMMENT '个人宣言',
  `coach_level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '教练等级,按学员流量算',
  `status` tinyint(4) NOT NULL COMMENT '0:未完善信息|1:正常|2:不通过|-1:禁用',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coach
-- ----------------------------
INSERT INTO `coach` VALUES ('1', '韦林', '1', '广东省', '深圳市', '南山区', '1', '120', '30', '5.0', '1500609235', '1502347147', '3', '3', '扩挖2', '', '', '', '', '2', '2016年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '5', '1', null);
INSERT INTO `coach` VALUES ('7', 'wo', '2', '广东省', '深圳市', '龙华区', '2', '0', '0', '0.0', '0', '1501298323', '1', '0', '', '', '', '', '', '1', '2016年-2017年都从事篮球培训', '教练的自我介绍', '', '', '/static/default/avatar.png', '生命在于运动', '0', '1', null);
INSERT INTO `coach` VALUES ('8', '彩铃', '2', '广东省', '深圳市', '龙岗区', '3', '0', '0', '0.0', '0', '1501298316', '1', '0', '', '', '', '', '', '2', '2016年-2017年都从事篮球培训', '自我介绍', '', '', '/static/default/avatar.png', '', '0', '1', null);
INSERT INTO `coach` VALUES ('9', '张三', '2', '广东省', '深圳市', '宝安区', '5', '0', '0', '0.0', '1503559375', '1503559375', '1', '0', '', '', '', '', '', '2', '2016年-2017年都从事篮球培训', '', '', '', '/static/default/avatar.png', '', '1', '1', null);
INSERT INTO `coach` VALUES ('10', '张三', '2', '广东省', '深圳市', '福田区', '4', '0', '0', '0.0', '1503559951', '1503559951', '1', '0', '', '', '', '', '', '3', '2016年-2017年都从事篮球培训', '', '', '', '/static/default/avatar.png', '', '1', '1', null);
INSERT INTO `coach` VALUES ('11', '南南', '1', '广东省', '深圳市', '南山区', '5', '0', '0', '0.0', '1504161676', '1504161676', '1', '0', '', '', '', '', '', '4', '2016年-2017年都从事篮球培训', '', '', '', '/static/default/avatar.png', '', '1', '1', null);
INSERT INTO `coach` VALUES ('19', '一', '2', '广东省', '深圳市', '南山区', '8', '0', '0', '0.0', '1504341900', '1504341900', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('20', '二', '2', '', '', '', '9', '0', '0', '0.0', '1504341900', '1504341900', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('18', '散', '2', '广东省', '深圳市', '罗湖区', '98089', '0', '0', '0.0', '1504341867', '1504341867', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('21', '四', '2', '广东省', '深圳市', '福田区', '8089', '0', '0', '0.0', '1504341901', '1504341901', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('22', '第二页', '1', '广东省', '深圳市', '福田区', '876', '0', '0', '0.0', '1504341901', '1504341901', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('23', '韦林', '1', '广东省', '深圳市', '南山区', '1089089', '120', '30', '5.0', '1500609235', '1502347147', '3', '3', '扩挖2', '', '', '', '', '2', '2016年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '5', '1', null);
INSERT INTO `coach` VALUES ('24', 'wo', '2', '广东省', '深圳市', '罗湖区', '28089', '0', '0', '0.0', '0', '1501298323', '1', '0', '', '', '', '', '', '1', '2016年-2017年都从事篮球培训', '教练的自我介绍', '', '', '/static/default/avatar.png', '生命在于运动', '0', '1', null);
INSERT INTO `coach` VALUES ('25', '彩铃', '2', '广东省', '深圳市', '南山区', '356876', '0', '0', '0.0', '0', '1501298316', '1', '0', '', '', '', '', '', '2', '2016年-2017年都从事篮球培训', '自我介绍', '', '', '/static/default/avatar.png', '', '0', '1', null);
INSERT INTO `coach` VALUES ('26', '张三', '2', '广东省', '深圳市', '南山区', '5789', '0', '0', '0.0', '1503559375', '1503559375', '1', '0', '', '', '', '', '', '2', '2016年-2017年都从事篮球培训', '', '', '', '/static/default/avatar.png', '', '1', '1', null);
INSERT INTO `coach` VALUES ('27', '张三', '2', '广东省', '深圳市', '南山区', '4567', '0', '0', '0.0', '1503559951', '1503559951', '1', '0', '', '', '', '', '', '3', '2016年-2017年都从事篮球培训', '', '', '', '/static/default/avatar.png', '', '1', '1', null);
INSERT INTO `coach` VALUES ('28', '南南', '1', '广东省', '深圳市', '南山区', '50890', '0', '0', '0.0', '1504161676', '1504161676', '1', '0', '', '', '', '', '', '4', '2016年-2017年都从事篮球培训', '', '', '', '/static/default/avatar.png', '', '1', '1', null);
INSERT INTO `coach` VALUES ('29', '一', '2', '广东省', '深圳市', '南山区', '547789', '0', '0', '0.0', '1504341900', '1504341900', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('30', '二', '2', '广东省', '深圳市', '南山区', '468', '0', '0', '0.0', '1504341900', '1504341900', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('31', '散', '2', '广东省', '深圳市', '南山区', '789', '0', '0', '0.0', '1504341867', '1504341867', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('32', '四', '2', '广东省', '深圳市', '南山区', '5789', '0', '0', '0.0', '1504341901', '1504341901', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('33', '第二页', '1', '广东省', '深圳市', '罗湖区', '4234', '0', '0', '0.0', '1504341901', '1504341901', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('34', '刷新1', '1', '广东省', '深圳市', '宝安区', '27978', '120', '30', '3.0', '1500609235', '1502347147', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('35', '刷新2', '1', '广东省', '深圳市', '南山区', '2342', '120', '30', '3.0', '1505357225', '1505357225', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('36', '刷新3', '1', '广东省', '深圳市', '南山区', '124', '120', '30', '3.0', '1505357558', '1505357558', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('37', '刷新4', '1', '广东省', '深圳市', '宝安区', '1234', '120', '30', '3.0', '1505361623', '1505361623', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('38', '刷新5', '1', '广东省', '深圳市', '福田区', '4212', '120', '30', '3.0', '1505369335', '1505369335', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('39', '刷新6', '1', '广东省', '深圳市', '罗湖区', '4534', '120', '30', '3.0', '1505373791', '1505373791', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('40', '刷新7', '1', '广东省', '深圳市', '盐田区', '123', '120', '30', '3.0', '1505373842', '1505373842', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('41', '刷新8', '1', '广东省', '深圳市', '罗湖区', '23', '120', '30', '3.0', '1505373860', '1505373860', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('42', '刷新9', '1', '广东省', '深圳市', '龙岗区', '1423', '120', '30', '3.0', '1505373885', '1505373885', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('43', '刷新10', '2', '广东省', '深圳市', '南山区', '43', '0', '0', '0.0', '1505373908', '1505373908', '1', '0', '', '', '', '', '', '0', '', '', '', '', '', '', '1', '1', null);
INSERT INTO `coach` VALUES ('44', '刷新11', '1', '广东省', '深圳市', '龙华区', '15', '120', '30', '3.0', '1505373940', '1505373940', '3', '3', '扩挖2', '', '', '', '', '3', '2011年-2017年都从事篮球培训', '我技术跟乔丹一样,身高跟姚明一样', '', '', '/static/default/avatar.png', '思想开朗,情绪轻松愉快,是健康的根本。体脑并用,锻炼第一,是我多年的体会。', '3', '1', null);
INSERT INTO `coach` VALUES ('51', '刘伟霖', '1', '广东省', '深圳市', '罗湖区', '35', '0', '0', '0.0', '1506144893', '1506144893', '1', '0', '', '', '', '', '', '1', '防守打法地方', '发斯蒂芬斯蒂芬', '', '', '/uploads/images/cert/2017/09/59c5f13248ee9.jpg', '发送到发送到', '1', '1', null);

-- ----------------------------
-- Table structure for `coach_comment`
-- ----------------------------
DROP TABLE IF EXISTS `coach_comment`;
CREATE TABLE `coach_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `coach_id` int(10) NOT NULL,
  `coach` varchar(60) NOT NULL,
  `comment` varchar(240) NOT NULL COMMENT '评论内容',
  `attitude` decimal(4,1) NOT NULL COMMENT '态度得分,满分5分',
  `profession` decimal(4,1) NOT NULL COMMENT '专业得分',
  `teaching_attitude` decimal(4,1) NOT NULL COMMENT '教学态度得分',
  `teaching_quality` decimal(4,1) NOT NULL COMMENT '教学质量得分',
  `appearance` decimal(4,1) NOT NULL COMMENT '仪容仪表',
  `anonymous` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:匿名|1:实名',
  `delete_time` int(10) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of coach_comment
-- ----------------------------
INSERT INTO `coach_comment` VALUES ('1', '1', 'weilin', '/static/default/avatar.png', '1', '', '很好', '0.0', '0.0', '0.0', '0.0', '0.0', '0', '0', '0', '2017-08-19 18:18:37');
INSERT INTO `coach_comment` VALUES ('2', '2', 'woo', '/static/default/avatar.png', '1', '', '一般', '0.0', '0.0', '0.0', '0.0', '0.0', '0', '0', '0', '2017-08-19 18:18:38');

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
  `camp_id` int(10) NOT NULL DEFAULT '0' COMMENT '0:系统',
  `camp` varchar(10) NOT NULL DEFAULT '系统',
  `location` varchar(255) NOT NULL COMMENT '具体地址',
  `principal` varchar(60) NOT NULL COMMENT '场地负责人',
  `open_time` varchar(255) NOT NULL COMMENT '营业时间',
  `contract` varchar(20) NOT NULL COMMENT '场地联系电话',
  `remarks` varchar(255) NOT NULL,
  `sys_remarks` varchar(255) NOT NULL COMMENT '系统备注',
  `chip_rent` decimal(8,2) NOT NULL COMMENT '散场',
  `full_rent` decimal(8,2) NOT NULL COMMENT '全场租金',
  `half_rent` decimal(8,2) NOT NULL COMMENT '半场',
  `outdoors` tinyint(4) NOT NULL DEFAULT '2' COMMENT '0:室内|1:室外|3:都有',
  `cover` varchar(255) NOT NULL COMMENT '封面',
  `status` int(10) NOT NULL COMMENT '-1:不通过;|0:待审核|1:系统通过',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of court
-- ----------------------------
INSERT INTO `court` VALUES ('1', '广东省', '深圳市', '罗湖区', '滨河小学篮球场', '1', '', '深圳市罗湖区红岭路滨河小学', '曾超全', '周日:7:00-23:00,其他时间:7:00-22:00,其他时间: 8:00-22:00', '1257846983', '', '', '15.00', '100.00', '50.00', '0', '/static/frontend/images/shuijiao.jpg', '1', '0', '0', null);
INSERT INTO `court` VALUES ('2', '广东省', '深圳市', '罗湖区', '罗湖体育馆', '0', '', '深圳市罗湖区经二路48号', '权哥', '', '1546368997', '', '', '12.00', '100.00', '50.00', '2', '/static/frontend/images/shuijiao.jpg', '-1', '0', '0', null);
INSERT INTO `court` VALUES ('3', '广东省', '深圳市', '福田区', '彩田中学篮球场', '1', '', '深圳市福田区莲花支路彩田村', '张老师', '', '1367484561', '', '', '15.00', '100.00', '60.00', '1', '/static/frontend/images/shuijiao.jpg', '1', '0', '0', null);

-- ----------------------------
-- Table structure for `court_media`
-- ----------------------------
DROP TABLE IF EXISTS `court_media`;
CREATE TABLE `court_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `court_id` int(10) NOT NULL,
  `title` varchar(250) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:图片|1:视频',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='场地图片';

-- ----------------------------
-- Records of court_media
-- ----------------------------
INSERT INTO `court_media` VALUES ('1', '1', '场地环境', '/static/default/avatar.png', '0', '0', '0', null);

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
  `exercise_setion` varchar(60) NOT NULL DEFAULT '所有人' COMMENT '适合阶段',
  `exercise_detail` text NOT NULL,
  `media` varchar(255) NOT NULL COMMENT '视频地址',
  `is_open` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:不开放;|1:开放',
  `status` tinyint(4) NOT NULL COMMENT '1:启用|0:待审核|>1 用户自己的',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exercise
-- ----------------------------
INSERT INTO `exercise` VALUES ('1', '0', '平台', '0', '平台', '热身游戏', '0', '', '', '', '0', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('2', '0', '平台', '0', '平台', '投篮', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('3', '0', '平台', '1', '平台', '传球', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('4', '0', '平台', '0', '平台', '上篮', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('5', '0', '平台', '0', '平台', '原地运球', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('6', '0', '平台', '0', '平台', '行进间运球', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('7', '0', '平台', '0', '平台', '基本移动技能', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('8', '0', '平台', '0', '平台', '基本团队配合', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('9', '0', '平台', '1', '平台', '一对一', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('10', '0', '平台', '0', '平台', '进阶团队配合', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('11', '0', '平台', '0', '平台', '其他', '0', '', '', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('12', '0', '平台', '0', '平台', '单人对墙传球', '3', '', '单人对墙传球', '', '1', '1', '1501582131', null, '1501582131');
INSERT INTO `exercise` VALUES ('14', '0', '平台', '0', '平台', '两人原地传接球', '3', '', '两人面对面站立，原地进行双手传接球练习。作用：提高传球的准确度', '', '1', '1', '1501643275', null, '1501747177');
INSERT INTO `exercise` VALUES ('15', '0', '平台', '0', '平台', '三人或多人同时传球练习', '3', '', '每人站一边。成三角型。间距3米。用一球原地互相来回传接球。作用：提高传接球的准确性', '', '1', '1', '1501646362', null, '1501660092');
INSERT INTO `exercise` VALUES ('16', '0', '平台', '0', '平台', '抢尾巴（无球、运球）', '1', '', '游戏规则：每人一条绳子系在腰后当尾巴，游戏开始后，在保护自己尾巴的同时，把别人的尾巴抢走。\r\n练习作用：提高移动和摆脱能力、敏捷性、反应能力。', 'http://ou1z1q8b2.bkt.clouddn.com/2017080350ce85982cb2099a23.mp4', '1', '1', '1501743930', null, '1501747062');
INSERT INTO `exercise` VALUES ('17', '1', '刘伟霖', '1', '大热伟霖篮球训练营', '紧贴防守单打', '9', '', '一对一单防,脚步横向移动', '', '1', '1', '0', null, '0');
INSERT INTO `exercise` VALUES ('18', '1', '刘伟霖', '1', '大热伟霖篮球训练营', '花式传球', '3', '', '就是花式传球啊，懂不懂', '', '1', '0', '0', null, '0');
INSERT INTO `exercise` VALUES ('19', '0', '平台', '0', '平台', '雪糕筒大战（无球 、运球）', '1', '', '游戏规则：两组队员同时进行，A组负责将场地上的雪糕筒推到，B组负责扶起。练习作用：提高团队协作、移动、反应能力。', '', '1', '1', '1502267118', null, '1502267199');

-- ----------------------------
-- Table structure for `grade`
-- ----------------------------
DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson` varchar(60) NOT NULL COMMENT '课程名称',
  `lesson_id` int(10) NOT NULL,
  `gradecate` varchar(60) NOT NULL COMMENT '班级类型',
  `gradecate_id` int(10) NOT NULL,
  `grade` varchar(60) NOT NULL COMMENT '班级名称',
  `camp_id` int(10) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) NOT NULL COMMENT '所属训练营',
  `leader` varchar(60) NOT NULL COMMENT '领队',
  `leader_id` int(10) NOT NULL COMMENT '对应member表,领队id',
  `teacher` varchar(60) NOT NULL COMMENT '班主任',
  `teacher_id` int(10) NOT NULL COMMENT '对应member表id',
  `coach` varchar(255) NOT NULL COMMENT '主教练',
  `coach_id` int(10) NOT NULL COMMENT '对应member.id',
  `coach_salary` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '主教练佣金',
  `assistant_id` varchar(255) NOT NULL COMMENT '副教练id集合,序列化,member.id',
  `assistant` varchar(255) NOT NULL COMMENT '副教练,序列化,对应',
  `assistant_salary` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '助教底薪',
  `salary_base` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '人头基数',
  `students` int(10) NOT NULL COMMENT '学生数量',
  `week` varchar(60) NOT NULL COMMENT '周一,周六',
  `lesson_time` varchar(255) NOT NULL COMMENT '8:00:00,14:00:00',
  `start` int(10) NOT NULL COMMENT '开始上课时间',
  `end` int(10) NOT NULL COMMENT '结束上课时间',
  `province` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `city` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `area` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `location` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL COMMENT '教案',
  `plan_ids` varchar(255) NOT NULL COMMENT '教案id',
  `court` varchar(255) NOT NULL COMMENT '球场',
  `court_id` int(10) NOT NULL COMMENT '场地id',
  `rent` decimal(8,2) NOT NULL COMMENT '场地租金',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:预排;1:正常|2:下架',
  `delete_time` int(10) DEFAULT NULL,
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grade
-- ----------------------------
INSERT INTO `grade` VALUES ('1', '大热篮球训练班', '2', '幼儿兴趣班（月卡）', '2', '3-7儿童班', '2', '大热woo训练营', 'woo', '2', '', '2', 'woo', '2', '100.00', '', '', '80.00', '30.00', '1', '周日', '10:00', '0', '0', '广东省', '深圳市', '福田区', '阳光文体中心', '', '1', '', '0', '0.00', '', '1', null, '0', '0');
INSERT INTO `grade` VALUES ('2', '小学暑期篮球基础', '1', '幼儿兴趣班（月卡）', '2', '小学暑期篮球基础1班', '1', '大热伟霖篮球训练营', '刘伟霖', '1', '刘伟霖', '1', '刘伟霖', '1', '0.00', '', 'a:1:{i:0;s:7:\"教练3\";}', '0.00', '20.00', '2', '周日', '12:25', '0', '0', '广东省', '深圳市', '罗湖区', '滨河小学篮球场', '\n                            高中综合班(16-18岁)教案                        ', '1', '滨河小学篮球场', '1', '180.00', '韦林', '0', null, '0', '1505787720');
INSERT INTO `grade` VALUES ('3', '控球后卫进阶暑假班', '2', '幼儿兴趣班（月卡）', '2', '控球后卫进阶暑假1班', '1', '大热伟霖篮球训练营', '刘伟霖', '1', '刘伟霖', '1', '刘伟霖', '1', '300.00', '', 'a:1:{i:0;s:7:\"教练1\";}', '200.00', '15.00', '1', '周日', '09:52', '0', '0', '广东省', '深圳市', '罗湖区', '滨河小学篮球场', '\n                        7-9岁小学综合班教案222                    ', '1', '滨河小学篮球场', '1', '1500.00', '', '0', null, '0', '1505526752');
INSERT INTO `grade` VALUES ('4', '高中综合篮球暑假课程', '3', '幼儿兴趣班（月卡）', '2', '高中综合篮球暑假-彩玲班', '3', '大热color篮球训练营', '张彩玲', '3', '张彩玲', '3', '张彩玲', '8', '250.00', '', '', '180.00', '10.00', '1', '周五,周六', '09:30,18:30', '0', '0', '广东省', '深圳市', '南山区', '阳光文体中心', '', '1', '彩田中学篮球场', '3', '0.00', '测试数据', '1', null, '0', '0');
INSERT INTO `grade` VALUES ('5', '\n                            woo测试版                        ', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '11:20', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505791225', '1505791225');
INSERT INTO `grade` VALUES ('6', '\n                            woo测试版                        ', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '11:20', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505791245', '1505791245');
INSERT INTO `grade` VALUES ('7', '\n                            woo测试版                        ', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505791917', '1505791917');
INSERT INTO `grade` VALUES ('8', '\n                            woo测试版                        ', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '11:37', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505792236', '1505792236');
INSERT INTO `grade` VALUES ('9', '\n                            woo测试版                        ', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505792504', '1505792504');
INSERT INTO `grade` VALUES ('10', '\n                            woo测试版                        ', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505792618', '1505792618');
INSERT INTO `grade` VALUES ('11', '\n                            woo测试版                        ', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            综合篮球课程                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505794010', '1505794010');
INSERT INTO `grade` VALUES ('12', '\n                            woo测试版                        ', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            综合篮球课程                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505794022', '1505794022');
INSERT INTO `grade` VALUES ('13', '\n                            woo测试版                        ', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            基础篮球课程                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505794529', '1505794529');
INSERT INTO `grade` VALUES ('14', '\n                            woo测试版                        ', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            基础篮球课程                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505794545', '1505794545');
INSERT INTO `grade` VALUES ('15', '\n                            woo测试版                        ', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505795266', '1505795266');
INSERT INTO `grade` VALUES ('16', '\n                            woo测试版                        ', '0', '', '0', '\n                            综合篮球课程                        ', '0', '', '', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505795285', '1505795285');
INSERT INTO `grade` VALUES ('17', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505795700', '1505795700');
INSERT INTO `grade` VALUES ('18', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505796256', '1505796256');
INSERT INTO `grade` VALUES ('19', '\n                            woo测试版                        \n', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505798933', '1505798933');
INSERT INTO `grade` VALUES ('20', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505800381', '1505800381');
INSERT INTO `grade` VALUES ('21', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505800405', '1505800405');
INSERT INTO `grade` VALUES ('22', '\n                            woo测试版                        \n', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505800435', '1505800435');
INSERT INTO `grade` VALUES ('23', '\n                            woo测试版                        \n', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505800454', '1505800454');
INSERT INTO `grade` VALUES ('24', '\n                            woo测试版                        \n', '0', '', '0', '\n                            综合篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505800478', '1505800478');
INSERT INTO `grade` VALUES ('25', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505801237', '1505801237');
INSERT INTO `grade` VALUES ('26', '\n                            woo测试版                        \n', '0', '', '0', '\n                            综合篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505801263', '1505801263');
INSERT INTO `grade` VALUES ('27', '\n                            woo测试版                        \n', '0', '', '0', '\n                            综合篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505801466', '1505801466');
INSERT INTO `grade` VALUES ('28', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505801729', '1505801729');
INSERT INTO `grade` VALUES ('29', '\n                            woo测试版                        \n', '0', '', '0', '\n                            综合篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505802059', '1505802059');
INSERT INTO `grade` VALUES ('30', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505804448', '1505804448');
INSERT INTO `grade` VALUES ('31', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505804462', '1505804462');
INSERT INTO `grade` VALUES ('32', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505804617', '1505804617');
INSERT INTO `grade` VALUES ('33', '\n                            woo测试版                        \n', '0', '', '0', '\n                            特色训练课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505805504', '1505805504');
INSERT INTO `grade` VALUES ('34', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505806426', '1505806426');
INSERT INTO `grade` VALUES ('35', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505806546', '1505806546');
INSERT INTO `grade` VALUES ('36', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505806627', '1505806627');
INSERT INTO `grade` VALUES ('37', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505806633', '1505806633');
INSERT INTO `grade` VALUES ('38', '\n                            woo测试版                        \n', '0', '', '0', '\n                            综合篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505806702', '1505806702');
INSERT INTO `grade` VALUES ('39', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505806727', '1505806727');
INSERT INTO `grade` VALUES ('40', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505806866', '1505806866');
INSERT INTO `grade` VALUES ('41', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505806989', '1505806989');
INSERT INTO `grade` VALUES ('42', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505807012', '1505807012');
INSERT INTO `grade` VALUES ('43', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505807013', '1505807013');
INSERT INTO `grade` VALUES ('44', '\n                            woo测试版                        \n', '0', '', '0', '\n                            特色训练课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505807019', '1505807019');
INSERT INTO `grade` VALUES ('45', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505807405', '1505807405');
INSERT INTO `grade` VALUES ('46', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808186', '1505808186');
INSERT INTO `grade` VALUES ('47', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808326', '1505808326');
INSERT INTO `grade` VALUES ('48', '\n                            woo测试版                        \n', '0', '', '0', '\n                            综合篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808415', '1505808415');
INSERT INTO `grade` VALUES ('49', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808473', '1505808473');
INSERT INTO `grade` VALUES ('50', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808692', '1505808692');
INSERT INTO `grade` VALUES ('51', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808820', '1505808820');
INSERT INTO `grade` VALUES ('52', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808847', '1505808847');
INSERT INTO `grade` VALUES ('53', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808877', '1505808877');
INSERT INTO `grade` VALUES ('54', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808903', '1505808903');
INSERT INTO `grade` VALUES ('55', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808913', '1505808913');
INSERT INTO `grade` VALUES ('56', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808925', '1505808925');
INSERT INTO `grade` VALUES ('57', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808934', '1505808934');
INSERT INTO `grade` VALUES ('58', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505808957', '1505808957');
INSERT INTO `grade` VALUES ('59', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809007', '1505809007');
INSERT INTO `grade` VALUES ('60', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809051', '1505809051');
INSERT INTO `grade` VALUES ('61', '\n                            woo测试版                        \n', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809093', '1505809093');
INSERT INTO `grade` VALUES ('62', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809220', '1505809220');
INSERT INTO `grade` VALUES ('63', '\n                            woo测试版                        \n', '0', '\n                                幼儿兴趣班（季度卡）                 ', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '16:20', '0', '0', '', '', '', '\n                            彩田中学篮球场                        ', '', '', '', '0', '0.00', '', '0', null, '1505809257', '1505809257');
INSERT INTO `grade` VALUES ('64', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809292', '1505809292');
INSERT INTO `grade` VALUES ('65', '\n                            woo测试版                        \n', '0', '', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809315', '1505809315');
INSERT INTO `grade` VALUES ('66', '\n                            woo测试版                        \n', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809345', '1505809345');
INSERT INTO `grade` VALUES ('67', '\n                            woo测试版                        \n', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            基础篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809358', '1505809358');
INSERT INTO `grade` VALUES ('68', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505809714', '1505809714');
INSERT INTO `grade` VALUES ('69', '\n                            woo测试版                        \n', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '\n                            综合篮球课程                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505810211', '1505810211');
INSERT INTO `grade` VALUES ('70', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505810428', '1505810428');
INSERT INTO `grade` VALUES ('71', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505810551', '1505810551');
INSERT INTO `grade` VALUES ('72', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505810944', '1505810944');
INSERT INTO `grade` VALUES ('73', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505810984', '1505810984');
INSERT INTO `grade` VALUES ('74', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505810993', '1505810993');
INSERT INTO `grade` VALUES ('75', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505814054', '1505814054');
INSERT INTO `grade` VALUES ('76', '\n                            woo测试版                        \n', '0', '', '0', '\n                            幼儿篮球兴趣班                        ', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505814918', '1505814918');
INSERT INTO `grade` VALUES ('77', '\n                            woo测试版                        \n', '0', '', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505873501', '1505873501');
INSERT INTO `grade` VALUES ('78', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505873558', '1505873558');
INSERT INTO `grade` VALUES ('79', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '综合篮球课程幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505873573', '1505873573');
INSERT INTO `grade` VALUES ('80', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505873577', '1505873577');
INSERT INTO `grade` VALUES ('81', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505873589', '1505873589');
INSERT INTO `grade` VALUES ('82', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505873724', '1505873724');
INSERT INTO `grade` VALUES ('83', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505873749', '1505873749');
INSERT INTO `grade` VALUES ('84', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505874134', '1505874134');
INSERT INTO `grade` VALUES ('85', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505874860', '1505874860');
INSERT INTO `grade` VALUES ('86', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505874897', '1505874897');
INSERT INTO `grade` VALUES ('87', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505877858', '1505877858');
INSERT INTO `grade` VALUES ('88', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505877876', '1505877876');
INSERT INTO `grade` VALUES ('89', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（4-6岁）                ', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505877921', '1505877921');
INSERT INTO `grade` VALUES ('90', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505877967', '1505877967');
INSERT INTO `grade` VALUES ('91', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505877980', '1505877980');
INSERT INTO `grade` VALUES ('92', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505877996', '1505877996');
INSERT INTO `grade` VALUES ('93', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '基础篮球课程幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505880610', '1505880610');
INSERT INTO `grade` VALUES ('94', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '基础篮球课程幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505880619', '1505880619');
INSERT INTO `grade` VALUES ('95', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '', '0', '基础篮球课程幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    weilin                 ', '0', '', '0', '', '0', '0.00', '', '', '0.00', '0.00', '0', '周日', '', '0', '0', '', '', '', '', '', '', '', '0', '0.00', '', '0', null, '1505880634', '1505880634');
INSERT INTO `grade` VALUES ('96', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    woo                    ', '0', '\n                                    吴光蔚                    ', '0', 'coloring', '0', '123.00', '', 'a:1:{i:0;s:8:\"coloring\";}', '321.00', '22.00', '0', '周日', '12:13', '0', '0', '', '', '', '\n                            滨河小学篮球场                        ', '\n                            7-9岁小学综合班教案                        ', '', '', '0', '120.00', '刚', '0', null, '1505880877', '1505880877');
INSERT INTO `grade` VALUES ('97', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '综合篮球课程幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    吴光蔚                    ', '0', '\n                                    woo                    ', '0', 'woo', '0', '3213.00', '', 'a:1:{i:0;s:8:\"coloring\";}', '221.00', '12.00', '0', '周日', '12:42', '0', '0', '', '', '', '\n                            滨河小学篮球场                        ', '\n                            高中综合班(16-18岁)教案                        ', '', '', '0', '123.00', '阿士大夫撒打发', '0', null, '1505882593', '1505882593');
INSERT INTO `grade` VALUES ('98', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '综合篮球课程幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    吴光蔚                    ', '0', '\n                                    woo                    ', '0', 'woo', '0', '3213.00', '', 'a:1:{i:0;s:8:\"coloring\";}', '221.00', '12.00', '0', '周日', '12:42', '0', '0', '', '', '', '\n                            滨河小学篮球场                        ', '\n                            高中综合班(16-18岁)教案                        ', '', '', '0', '123.00', '阿士大夫撒打发', '0', null, '1505882610', '1505882610');
INSERT INTO `grade` VALUES ('99', 'woo测试版大热wooooo高级班控球后卫进阶暑假班大热wooooo高级班大热xxxx', '0', '\n                                幼儿兴趣班（月卡）                  ', '0', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '0', '', '\n                                    吴光蔚                    ', '0', '\n                                    woo                    ', '0', 'coloring', '0', '0.00', '', 'a:1:{i:0;s:6:\"weilin\";}', '0.00', '0.00', '0', '周日', '12:44', '0', '0', '', '', '', '\n                            彩田中学篮球场                        ', '\n                            7-9岁小学综合班教案222                        ', '', '', '0', '123.00', '啊是的噶十多个', '0', null, '1505882690', '1505882690');

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
  `lesson` varchar(60) NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL COMMENT '所属训练营',
  `student_id` int(10) NOT NULL,
  `student` varchar(60) NOT NULL,
  `member` varchar(60) NOT NULL COMMENT '对应会员表member',
  `member_id` int(10) NOT NULL COMMENT '对应会员表id',
  `rest_schedule` int(10) NOT NULL DEFAULT '0' COMMENT '剩余课时,0时自动毕业',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '2:体验生|1:正式学生',
  `remarks` varchar(255) NOT NULL DEFAULT '之前就买了这个课程,3节课' COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:待审核|1:正常|2:退出|3:被开除|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='班级-会员表\r\n仅仅是班级-会员,不再是训练营-课程-班级-会员了';

-- ----------------------------
-- Records of grade_member
-- ----------------------------
INSERT INTO `grade_member` VALUES ('1', '幼儿篮球兴趣班幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '1', '小学暑期篮球基础', '1', '1', '大热伟霖篮球训练营', '0', '', 'weilin', '1', '0', '', '1', '我要加入你们', '1', '0', null);
INSERT INTO `grade_member` VALUES ('3', '综合篮球课程幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '1', '小学暑期篮球基础', '1', '2', '大热woo训练营', '0', '吴光蔚', 'coloring', '1', '0', '', '1', '我要加入你们', '1', '0', null);
INSERT INTO `grade_member` VALUES ('4', '综合篮球课程幼儿篮球兴趣班基础篮球课程综合篮球课程强化篮球课程篮球队课程特色训练课程其他', '1', '控球后卫进阶暑假班', '2', '2', '大热woo训练营', '0', '吴光蔚', 'woo', '1', '0', '', '1', '申请理由:哈哈哈哈我要加入你们', '1', '0', null);
INSERT INTO `grade_member` VALUES ('5', '小学暑期篮球基础1班', '2', '小学暑期篮球基础', '1', '1', '大热伟霖篮球训练营', '2', '陈烈准', '陈烈准', '2', '0', '', '1', '申请理由:哈哈哈哈我要加入你们', '1', '0', null);
INSERT INTO `grade_member` VALUES ('6', '控球后卫进阶暑假1班', '3', '高中综合篮球暑假课程', '3', '1', '大热伟霖篮球训练营', '3', '陈烈候', '陈烈候', '1', '0', '', '1', '申请理由:哈哈哈哈我要加入你们', '1', '0', null);
INSERT INTO `grade_member` VALUES ('7', '小学暑期篮球基础1班', '2', '控球后卫进阶暑假班', '2', '1', '大热伟霖篮球训练营', '4', '吴光蔚', '吴光蔚', '3', '0', '', '1', '申请理由:哈哈哈哈我要加入你们', '1', '0', null);
INSERT INTO `grade_member` VALUES ('8', '高中综合篮球暑假-彩玲班', '4', '高中综合篮球暑假课程', '3', '2', '大热color篮球训练营', '2', '陈烈准', '陈烈准', '2', '0', '', '1', '申请理由:哈哈哈哈我要加入你们', '1', '0', null);
INSERT INTO `grade_member` VALUES ('53', '', '0', 'woo测试版', '1', '1', '大热伟霖篮球训练营', '6', '吴宝宝', 'weilin', '1', '0', '', '1', '之前就买了这个课程,3节课', '1', '1505891033', null);

-- ----------------------------
-- Table structure for `income`
-- ----------------------------
DROP TABLE IF EXISTS `income`;
CREATE TABLE `income` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson_id` int(10) NOT NULL,
  `lesson` varchar(60) NOT NULL,
  `camp_id` int(10) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) NOT NULL,
  `income` decimal(12,2) NOT NULL COMMENT '训练营收入',
  `member_id` int(10) NOT NULL COMMENT '购买者id',
  `member` varchar(60) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='训练营收入表';

-- ----------------------------
-- Records of income
-- ----------------------------

-- ----------------------------
-- Table structure for `lesson`
-- ----------------------------
DROP TABLE IF EXISTS `lesson`;
CREATE TABLE `lesson` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson` varchar(60) NOT NULL COMMENT '课程名称',
  `member` varchar(60) NOT NULL COMMENT '发布者',
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `leader_id` int(10) NOT NULL COMMENT '负责财务的老大,对应member表id',
  `leader` varchar(60) NOT NULL COMMENT 'leader',
  `gradecate` varchar(60) NOT NULL COMMENT '课程类型',
  `gradecate_id` int(10) NOT NULL COMMENT '选择类型',
  `camp` varchar(60) NOT NULL COMMENT '所属训练营名称',
  `camp_id` int(10) NOT NULL COMMENT '所属训练营id',
  `cost` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '每个课时单价',
  `total` tinyint(10) NOT NULL DEFAULT '1' COMMENT '总课时数量',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '购买课程需要积分',
  `coach` varchar(60) NOT NULL COMMENT '主教练',
  `coach_id` int(10) NOT NULL COMMENT 'zhu教练  对应member表id',
  `assistant` text NOT NULL COMMENT '副教练,序列化',
  `assistant_id` text NOT NULL COMMENT '副教练id集合 序列化',
  `teacher` varchar(60) NOT NULL COMMENT '班主任',
  `teacher_id` int(10) NOT NULL COMMENT '对应member表id',
  `min` int(10) NOT NULL DEFAULT '1' COMMENT '最少开课学生数量',
  `max` int(10) NOT NULL COMMENT '最大开课学生数量',
  `week` varchar(60) NOT NULL COMMENT '周六,周三',
  `start` date NOT NULL COMMENT '开始日期',
  `end` date NOT NULL COMMENT '结束日期',
  `lesson_time` time NOT NULL COMMENT '具体上课时间',
  `dom` varchar(255) NOT NULL COMMENT 'serialize,可以购买的数量',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '推荐排序',
  `hot` int(10) NOT NULL DEFAULT '0' COMMENT '热门课程',
  `hit` int(10) NOT NULL COMMENT '点击量',
  `students` int(10) NOT NULL DEFAULT '0' COMMENT '报名人数,包括预约体验的学生',
  `province` varchar(60) NOT NULL COMMENT '省',
  `city` varchar(60) NOT NULL COMMENT '市',
  `area` varchar(60) NOT NULL COMMENT '区',
  `court_id` int(10) NOT NULL COMMENT '场地id',
  `court` varchar(255) NOT NULL COMMENT '场地名称',
  `location` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `cover` varchar(255) NOT NULL COMMENT '封面',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:未审核;1:正常;-1:下架',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lesson
-- ----------------------------
INSERT INTO `lesson` VALUES ('1', 'woo测试版', 'weilin', '1', '4', 'woo', '特色训练课程', '27', '大热伟霖篮球训练营', '1', '8888.00', '10', '999', '吴光蔚', '4', 'a:1:{i:0;s:9:\"吴光蔚\";}', 'a:1:{i:0;s:1:\"4\";}', '吴光蔚', '0', '8', '66', '周六', '2017-07-29', '2017-08-27', '23:06:00', 'a:2:{i:0;s:1:\"1\";i:1;s:0:\"\";}', '0', '1', '0', '0', '北京市', '北京市', '东城区', '3', '彩田中学篮球场', '桂庙路118号', '18507717466', '/uploads/images/lesson/1.jpg', '测试数据', '1', '0', '0', null);
INSERT INTO `lesson` VALUES ('4', '大热wooooo高级班', 'weilin', '1', '4', 'weilin', '强化篮球课程', '16', '大热伟霖篮球训练营', '1', '9999.99', '1', '99', '吴光蔚', '4', 'a:1:{i:0;s:9:\"吴光蔚\";}', 'a:1:{i:0;s:1:\"4\";}', '吴光蔚', '4', '1', '88', '周三', '0000-00-00', '0000-00-00', '19:14:00', 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"5\";i:2;s:2:\"10\";i:3;s:2:\"15\";i:4;s:2:\"20\";i:5;s:2:\"30\";}', '0', '0', '0', '0', '北京市', '北京市', '东城区', '3', '彩田中学篮球场', '', '', '', '', '1', '0', '0', null);
INSERT INTO `lesson` VALUES ('2', '控球后卫进阶暑假班', '', '1', '1', '刘伟霖', '超级控球手课程', '30', '大热伟霖篮球训练营', '1', '150.00', '5', '0', '刘伟霖', '1', '', '', '', '0', '1', '5', '周六', '2017-07-29', '2017-08-26', '15:00:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"20\";i:2;s:2:\"30\";}', '0', '2', '0', '0', '广东', '广州', '白云', '1', '南山文体中心', '南山路110号', '', '/uploads/images/lesson/2.jpg', '测试数据', '1', '0', '0', null);
INSERT INTO `lesson` VALUES ('3', '高中综合篮球暑假课程', '张彩玲', '3', '3', '张彩玲', '高中 - 综合班（16-18岁）', '15', '大热color篮球训练营', '3', '100.00', '1', '0', '张彩玲', '3', '', '', '', '0', '5', '10', '周五,周六', '2017-07-07', '2017-08-26', '10:00:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"20\";i:2;s:2:\"30\";}', '0', '0', '0', '0', '浙江', '宁波', '江北', '3', '彩田中学篮球场', '彩田路01号', '', '/uploads/images/lesson/3.jpg', '', '1', '0', '0', null);
INSERT INTO `lesson` VALUES ('5', '大热wooooo高级班', 'weilin', '1', '4', 'woo', '强化篮球课程', '16', '大热伟霖篮球训练营', '1', '9999.99', '1', '99', '吴光蔚', '4', 'a:1:{i:0;s:9:\"吴光蔚\";}', 'a:1:{i:0;s:1:\"4\";}', '吴光蔚', '4', '1', '88', '周三', '0000-00-00', '0000-00-00', '19:14:00', 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"5\";i:2;s:2:\"10\";i:3;s:2:\"15\";i:4;s:2:\"20\";i:5;s:2:\"30\";}', '0', '0', '0', '0', '北京市', '北京市', '东城区', '3', '彩田中学篮球场', '', '', '', '', '1', '0', '0', null);
INSERT INTO `lesson` VALUES ('6', '大热xxxx', 'weilin', '1', '4', 'weilin', '综合篮球课程', '11', '大热伟霖篮球训练营', '1', '123.00', '1', '123', '吴光蔚', '4', '', '', '', '0', '123', '999', '周四', '0000-00-00', '0000-00-00', '19:23:00', 'a:2:{i:0;s:1:\"5\";i:1;s:2:\"15\";}', '0', '0', '0', '0', '北京市', '北京市', '东城区', '1', '滨河小学篮球场', '深圳市罗湖区红岭路滨河小学', '', '', '', '1', '0', '0', null);
INSERT INTO `lesson` VALUES ('7', '11', 'weilin', '1', '0', '', '基础篮球课程', '6', '大热伟霖篮球训练营', '1', '111.00', '1', '0', 'woo', '2', '', '', '', '0', '1', '7', '周日', '0000-00-00', '0000-00-00', '18:41:00', 'a:1:{i:0;s:2:\"10\";}', '0', '0', '0', '0', '广东省', '深圳市', '南山区', '1', '滨河小学篮球场', '深圳市罗湖区红岭路滨河小学', '', '', '', '0', '0', '0', null);
INSERT INTO `lesson` VALUES ('8', '222', 'weilin', '1', '0', '', '幼儿篮球兴趣班', '1', '大热伟霖篮球训练营', '1', '2222.00', '1', '0', '吴光蔚', '4', '', '', '', '0', '2', '4', '周日', '0000-00-00', '0000-00-00', '00:00:00', 'a:2:{i:0;s:2:\"10\";i:1;s:2:\"15\";}', '0', '0', '0', '0', '广东省', '深圳市', '南山区', '1', '滨河小学篮球场', '深圳市罗湖区红岭路滨河小学', '', '', '', '0', '0', '0', null);

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
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

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
INSERT INTO `log_admindo` VALUES ('53', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1501559038');
INSERT INTO `log_admindo` VALUES ('54', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1501561754');
INSERT INTO `log_admindo` VALUES ('55', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1501576219');
INSERT INTO `log_admindo` VALUES ('56', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1501642396');
INSERT INTO `log_admindo` VALUES ('57', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742331');
INSERT INTO `log_admindo` VALUES ('58', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742341');
INSERT INTO `log_admindo` VALUES ('59', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742352');
INSERT INTO `log_admindo` VALUES ('60', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742364');
INSERT INTO `log_admindo` VALUES ('61', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742380');
INSERT INTO `log_admindo` VALUES ('62', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742407');
INSERT INTO `log_admindo` VALUES ('63', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742430');
INSERT INTO `log_admindo` VALUES ('64', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742451');
INSERT INTO `log_admindo` VALUES ('65', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742458');
INSERT INTO `log_admindo` VALUES ('66', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742480');
INSERT INTO `log_admindo` VALUES ('67', '0', '', '控制台 登录 失败', '/admin/login/index', '0.0.0.0', '1501742489');
INSERT INTO `log_admindo` VALUES ('68', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1501742691');
INSERT INTO `log_admindo` VALUES ('69', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1501743461');
INSERT INTO `log_admindo` VALUES ('70', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1501925152');
INSERT INTO `log_admindo` VALUES ('71', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1501925800');
INSERT INTO `log_admindo` VALUES ('72', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1502160240');
INSERT INTO `log_admindo` VALUES ('73', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1502161951');
INSERT INTO `log_admindo` VALUES ('74', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1502165981');
INSERT INTO `log_admindo` VALUES ('75', '1', 'admin', '审核前台发布教案 id:4成功', '/admin/plan/audit', '0.0.0.0', '1502264835');
INSERT INTO `log_admindo` VALUES ('76', '1', 'admin', '新增平台教案成功 id:6', '/admin/plan/store', '0.0.0.0', '1502264901');
INSERT INTO `log_admindo` VALUES ('77', '1', 'admin', '新增训练项目成功 id:19', '/admin/exercise/store', '0.0.0.0', '1502267118');
INSERT INTO `log_admindo` VALUES ('78', '1', 'admin', '软删除训练项目 id:19成功', '/admin/exercise/del', '0.0.0.0', '1502267199');
INSERT INTO `log_admindo` VALUES ('79', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1502330856');
INSERT INTO `log_admindo` VALUES ('80', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1502338204');
INSERT INTO `log_admindo` VALUES ('81', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1502338318');
INSERT INTO `log_admindo` VALUES ('82', '1', 'admin', '修改教练id:1教练信息 成功', '/admin/coach/edit', '0.0.0.0', '1502345952');
INSERT INTO `log_admindo` VALUES ('83', '1', 'admin', '审核教练id: 1 审核通过 成功', '/admin/coach/audit', '0.0.0.0', '1502347147');
INSERT INTO `log_admindo` VALUES ('84', '1', 'admin', '修改member_id:1教练会员信息 成功', '/admin/coach/updatemember', '0.0.0.0', '1502349941');
INSERT INTO `log_admindo` VALUES ('85', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1502515604');
INSERT INTO `log_admindo` VALUES ('86', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1502517820');
INSERT INTO `log_admindo` VALUES ('87', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1502518962');
INSERT INTO `log_admindo` VALUES ('88', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1502765602');
INSERT INTO `log_admindo` VALUES ('89', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1502936584');
INSERT INTO `log_admindo` VALUES ('90', '1', 'admin', '系统设置 修改 失败', '/admin/system/setinfo', '0.0.0.0', '1502942705');
INSERT INTO `log_admindo` VALUES ('91', '1', 'admin', '系统设置 修改 成功', '/admin/system/setinfo', '0.0.0.0', '1502942781');
INSERT INTO `log_admindo` VALUES ('92', '1', 'admin', '修改平台banner 失败', '/admin/system/editbanner', '0.0.0.0', '1503026556');
INSERT INTO `log_admindo` VALUES ('93', '1', 'admin', '修改平台banner  成功', '/admin/system/editbanner', '0.0.0.0', '1503026628');
INSERT INTO `log_admindo` VALUES ('94', '1', 'admin', '修改会员积分设置 失败', '/admin/system/editscore', '0.0.0.0', '1503028700');
INSERT INTO `log_admindo` VALUES ('95', '1', 'admin', '修改会员积分设置  成功', '/admin/system/editscore', '0.0.0.0', '1503028734');
INSERT INTO `log_admindo` VALUES ('96', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1503109138');
INSERT INTO `log_admindo` VALUES ('97', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1503126931');
INSERT INTO `log_admindo` VALUES ('98', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1503389140');
INSERT INTO `log_admindo` VALUES ('99', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '127.0.0.1', '1503731861');
INSERT INTO `log_admindo` VALUES ('100', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '0.0.0.0', '1504668845');
INSERT INTO `log_admindo` VALUES ('101', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '192.168.1.57', '1505378415');
INSERT INTO `log_admindo` VALUES ('102', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '192.168.1.62', '1505896280');
INSERT INTO `log_admindo` VALUES ('103', '1', 'admin', '控制台 登录 成功', '/admin/login/index', '192.168.1.62', '1505979546');
INSERT INTO `log_admindo` VALUES ('104', '1', 'admin', '审核训练营id: 11 审核通过 成功', '/admin/camp/audit', '192.168.1.62', '1505979628');

-- ----------------------------
-- Table structure for `log_camp_member`
-- ----------------------------
DROP TABLE IF EXISTS `log_camp_member`;
CREATE TABLE `log_camp_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` int(10) NOT NULL,
  `data` text NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_camp_member
-- ----------------------------

-- ----------------------------
-- Table structure for `log_grade_member`
-- ----------------------------
DROP TABLE IF EXISTS `log_grade_member`;
CREATE TABLE `log_grade_member` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `mmeber` varchar(60) NOT NULL,
  `data` text NOT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_grade_member
-- ----------------------------

-- ----------------------------
-- Table structure for `log_income`
-- ----------------------------
DROP TABLE IF EXISTS `log_income`;
CREATE TABLE `log_income` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `mmeber` varchar(60) NOT NULL,
  `data` text NOT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_income
-- ----------------------------

-- ----------------------------
-- Table structure for `log_pay`
-- ----------------------------
DROP TABLE IF EXISTS `log_pay`;
CREATE TABLE `log_pay` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `mmeber` varchar(60) NOT NULL,
  `data` text NOT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值记录表';

-- ----------------------------
-- Records of log_pay
-- ----------------------------

-- ----------------------------
-- Table structure for `log_rebate`
-- ----------------------------
DROP TABLE IF EXISTS `log_rebate`;
CREATE TABLE `log_rebate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `data` text NOT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='返现记录表';

-- ----------------------------
-- Records of log_rebate
-- ----------------------------

-- ----------------------------
-- Table structure for `log_salary_in`
-- ----------------------------
DROP TABLE IF EXISTS `log_salary_in`;
CREATE TABLE `log_salary_in` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `mmeber` varchar(60) NOT NULL,
  `data` text NOT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_salary_in
-- ----------------------------

-- ----------------------------
-- Table structure for `log_salary_out`
-- ----------------------------
DROP TABLE IF EXISTS `log_salary_out`;
CREATE TABLE `log_salary_out` (
  `id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `mmeber` varchar(60) NOT NULL,
  `data` text NOT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log_salary_out
-- ----------------------------

-- ----------------------------
-- Table structure for `log_sendtemplatemsg`
-- ----------------------------
DROP TABLE IF EXISTS `log_sendtemplatemsg`;
CREATE TABLE `log_sendtemplatemsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wxopenid` varchar(100) NOT NULL COMMENT '接收的openid',
  `member_id` int(11) NOT NULL COMMENT '接收的memberid',
  `url` varchar(255) DEFAULT NULL COMMENT '消息的url地址',
  `content` text COMMENT '消息的内容 seriliaze',
  `status` tinyint(4) DEFAULT '0' COMMENT '发送成功状态:1成功|0失败',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发送模板消息log';

-- ----------------------------
-- Records of log_sendtemplatemsg
-- ----------------------------

-- ----------------------------
-- Table structure for `media`
-- ----------------------------
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of media
-- ----------------------------
INSERT INTO `media` VALUES ('1', '/uploads/images/lesson/1.jpg');

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(64) NOT NULL COMMENT '微信授权即产生',
  `member` varchar(60) NOT NULL COMMENT '用户名',
  `nickname` varchar(60) NOT NULL COMMENT '微信授权即产生',
  `avatar` varchar(60) NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '注册或者微信授权产生',
  `telephone` bigint(11) NOT NULL COMMENT '电话号码',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `email` varchar(60) NOT NULL COMMENT '电子邮箱',
  `realname` varchar(30) NOT NULL COMMENT '真实姓名',
  `province` varchar(60) NOT NULL COMMENT '省',
  `city` varchar(60) NOT NULL COMMENT '市',
  `area` varchar(60) NOT NULL,
  `location` varchar(255) NOT NULL COMMENT '居住地址',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `height` decimal(4,1) NOT NULL COMMENT '身高,单位cm',
  `weight` decimal(4,1) NOT NULL COMMENT '体重,单位cm',
  `charater` varchar(240) NOT NULL,
  `shoe_code` decimal(4,1) NOT NULL COMMENT '鞋码,单位mm',
  `birthday` date NOT NULL COMMENT '生日',
  `create_time` int(10) NOT NULL COMMENT '注册时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `level` tinyint(4) NOT NULL DEFAULT '1' COMMENT '根据流量自动分',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '推荐人',
  `hp` int(10) NOT NULL COMMENT '业绩|经验',
  `cert_id` int(10) NOT NULL COMMENT '证件id',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `flow` int(10) NOT NULL COMMENT '流量,三层关系',
  `balance` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '人民币余额',
  `remarks` varchar(255) NOT NULL COMMENT 'remarks',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('1', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'weilin', 'WL伟霖', '/static/default/avatar.png', '56', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '刘伟霖', '广东省', '深圳市', '', '罗湖区深南东路京基100花园E1栋26C', '1', '192.0', '0.0', '', '44.0', '1993-06-02', '1498842061', '1506157857', '1', '5', '13000', '2', '13000', '0', '0.00', 'mysql 插入测试数据', null);
INSERT INTO `member` VALUES ('2', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'alice.wu', 'woo', '/static/default/avatar.png', '1358687812', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', 'alicewu@hot-basketball.com', '吴丽文', '广东省', '深圳市', '', '南山区不知道那条村x栋xxx号', '2', '165.0', '80.0', '', '38.0', '1992-12-06', '1498842061', '0', '1', '1', '5000', '0', '5000', '0', '179.20', 'mysql 手动插入 测试数据', null);
INSERT INTO `member` VALUES ('3', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'coloring', '彩玲', '/static/default/avatar.png', '12334455334', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '张彩玲', '', '', '', '', '0', '0.0', '0.0', '', '0.0', '0000-00-00', '1498842061', '0', '1', '2', '8000', '0', '8000', '0', '0.38', '', null);
INSERT INTO `member` VALUES ('4', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'legend', '', '/static/default/avatar.png', '1585461234', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '陈烈准', '广东省', '深圳市', '', '', '1', '0.0', '0.0', '', '0.0', '0000-00-00', '1498842061', '0', '1', '2', '0', '0', '0', '0', '0.00', '测试数据', null);
INSERT INTO `member` VALUES ('5', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'ho', '', '/static/default/avatar.png', '1369874512', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '陈烈候', '广东省', '深圳市', '', '', '1', '0.0', '0.0', '', '0.0', '0000-00-00', '1498842061', '0', '1', '3', '13000', '0', '13000', '0', '3.33', '测试数据', null);
INSERT INTO `member` VALUES ('6', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'will', '', '/static/default/avatar.png', '1594561263', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '吴光蔚', '广东省', '深圳市', '', '', '1', '0.0', '0.0', '', '0.0', '0000-00-00', '1498842061', '0', '1', '4', '0', '0', '0', '0', '0.00', '', null);
INSERT INTO `member` VALUES ('25', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'hot123', '', '', '13750088350', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', '0', '0.0', '0.0', '', '0.0', '0000-00-00', '0', '0', '1', '0', '0', '0', '0', '0', '0.00', '', null);
INSERT INTO `member` VALUES ('26', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'qqqqqq', '', '', '13750088350', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', '0', '0.0', '0.0', '', '0.0', '0000-00-00', '0', '0', '1', '0', '0', '0', '0', '0', '0.00', '', null);
INSERT INTO `member` VALUES ('27', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'zwrzwr', '', '/static/default/avatar.png', '13750088827', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', '0', '0.0', '0.0', '', '0.0', '0000-00-00', '0', '0', '1', '0', '0', '0', '0', '0', '0.00', '', null);
INSERT INTO `member` VALUES ('28', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'aaaaaa', '', '/static/default/avatar.png', '13750088888', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', '0', '0.0', '0.0', '', '0.0', '0000-00-00', '0', '0', '1', '0', '0', '0', '0', '0', '0.00', '', null);
INSERT INTO `member` VALUES ('29', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'text', '', '/static/default/avatar.png', '13513513513', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', '0', '0.0', '0.0', '', '0.0', '0000-00-00', '0', '0', '1', '0', '0', '0', '0', '0', '0.00', '', null);
INSERT INTO `member` VALUES ('35', '', 'test111', '', '/static/default/avatar.png', '1341059333', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', '0', '0.0', '0.0', '', '0.0', '0000-00-00', '1505268089', '1505268089', '1', '0', '0', '0', '0', '0', '0.00', '', null);
INSERT INTO `member` VALUES ('36', '', 'weilin23333', '', '/static/default/avatar.png', '13410599613', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', '0', '0.0', '0.0', '', '0.0', '0000-00-00', '1506159203', '1506159203', '1', '0', '0', '0', '0', '0', '0.00', '', null);

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(240) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `is_system` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:系统消息',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:zhengchang|0:guoqi',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message
-- ----------------------------
INSERT INTO `message` VALUES ('1', '韦林大傻逼报名体验xxx', '大傻逼欠费逾期,罚十倍学费', '', '0', '1', '0', '0', null, '1');
INSERT INTO `message` VALUES ('2', '44256', '87905', '', '0', '1', '1505897555', '1505897555', null, '1');
INSERT INTO `message` VALUES ('3', '34381', '52090', '', '0', '1', '1505897565', '1505897565', null, '1');
INSERT INTO `message` VALUES ('4', '21414', '85482', '', '0', '1', '1505897682', '1505897682', null, '1');
INSERT INTO `message` VALUES ('5', '56649', '52703', '', '0', '1', '1505899921', '1505899921', null, '1');
INSERT INTO `message` VALUES ('6', '97824', '96939', '', '0', '1', '1505899964', '1505899964', null, '1');
INSERT INTO `message` VALUES ('7', '43185', '82604', '', '0', '1', '1505899964', '1505899964', null, '1');

-- ----------------------------
-- Table structure for `message_member`
-- ----------------------------
DROP TABLE IF EXISTS `message_member`;
CREATE TABLE `message_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(240) NOT NULL,
  `content` text NOT NULL,
  `member_id` int(10) NOT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT '0' COMMENT ';:未读|1:已读',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of message_member
-- ----------------------------

-- ----------------------------
-- Table structure for `pay`
-- ----------------------------
DROP TABLE IF EXISTS `pay`;
CREATE TABLE `pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `pay_type` varchar(60) NOT NULL DEFAULT '微信支付' COMMENT '支付方式',
  `money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `callback_str` text NOT NULL COMMENT '支付回调',
  `remarks` varchar(240) NOT NULL COMMENT '备注',
  `create_time` int(10) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值记录';

-- ----------------------------
-- Records of pay
-- ----------------------------

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
  `exercise_id` text NOT NULL COMMENT '训练科目集合,序列化',
  `exercise` text NOT NULL COMMENT '训练科目集合,序列化',
  `grade_category_id` int(10) NOT NULL,
  `grade_category` varchar(200) NOT NULL COMMENT '适合阶段(班级分类)',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:平台|1训练营',
  `is_open` int(4) NOT NULL DEFAULT '1' COMMENT '0:不开放|1:开放',
  `status` tinyint(4) NOT NULL COMMENT '0:未审核|1:正常|2:不通过',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL COMMENT '个人备注',
  `sys_remarks` varchar(255) NOT NULL COMMENT '系统备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plan
-- ----------------------------
INSERT INTO `plan` VALUES ('1', '', '0', '0', '平台', '7-9岁小学综合班教案', '7-9岁小学综合班教案', '0', 'a:2:{i:1;a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:12:\"热身游戏\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:16;a:5:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:30:\"抢尾巴（无球、运球）\";s:3:\"pid\";s:1:\"1\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}i:3;a:5:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:6:\"传球\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:12;a:5:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:18:\"单人对墙传球\";s:3:\"pid\";s:1:\"3\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}}', '7', '小学 - 基础班（7-9岁）', '0', '1', '1', '1501922936', '1501922936', null, '', '');
INSERT INTO `plan` VALUES ('2', '', '0', '0', '平台', '7-9岁小学综合班教案222', '7-9岁小学综合班教案3333', '0', 'a:2:{i:1;a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:12:\"热身游戏\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:16;a:5:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:30:\"抢尾巴（无球、运球）\";s:3:\"pid\";s:1:\"1\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}i:3;a:5:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:6:\"传球\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:12;a:5:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:18:\"单人对墙传球\";s:3:\"pid\";s:1:\"3\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}}', '7', '小学 - 基础班（7-9岁）', '0', '1', '1', '1501922936', '1502177673', null, '', '');
INSERT INTO `plan` VALUES ('3', '', '0', '0', '平台', '高中综合班(16-18岁)教案', '高中综合班(16-18岁)教案123456', '0', 'a:1:{i:3;a:5:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:6:\"传球\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:2:{i:12;a:5:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:18:\"单人对墙传球\";s:3:\"pid\";s:1:\"3\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}i:15;a:5:{s:2:\"id\";s:2:\"15\";s:4:\"name\";s:33:\"三人或多人同时传球练习\";s:3:\"pid\";s:1:\"3\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}}', '15', '高中 - 综合班（16-18岁）', '0', '1', '1', '1502175428', '1502176059', null, '', '');
INSERT INTO `plan` VALUES ('4', '刘伟霖', '1', '1', '大热伟霖篮球训练营', '前台发布的教案1', '前台发布的教案1 测试时司法局施蒂利克富家大室六块腹肌倒是来k', '0', 'a:3:{i:0;a:5:{s:2:\"id\";i:1;s:4:\"name\";s:12:\"热身游戏\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:0;a:5:{s:2:\"id\";i:16;s:4:\"name\";s:30:\"抢尾巴（无球、运球）\";s:3:\"pid\";i:1;s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}i:1;a:5:{s:2:\"id\";i:3;s:4:\"name\";s:6:\"传球\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:2:{i:0;a:5:{s:2:\"id\";i:12;s:4:\"name\";s:18:\"单人对墙传球\";s:3:\"pid\";i:3;s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}i:1;a:10:{s:2:\"id\";i:18;s:4:\"name\";s:12:\"花式传球\";s:9:\"member_id\";i:1;s:6:\"member\";s:9:\"刘伟霖\";s:7:\"camp_id\";i:1;s:4:\"camp\";s:27:\"大热伟霖篮球训练营\";s:6:\"status\";i:1;s:3:\"pid\";i:3;s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}i:2;a:5:{s:2:\"id\";i:9;s:4:\"name\";s:9:\"一对一\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:0;a:10:{s:2:\"id\";i:17;s:4:\"name\";s:18:\"紧贴防守单打\";s:9:\"member_id\";i:1;s:6:\"member\";s:9:\"刘伟霖\";s:7:\"camp_id\";i:1;s:4:\"camp\";s:27:\"大热伟霖篮球训练营\";s:6:\"status\";i:1;s:3:\"pid\";i:9;s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}}', '20', '高中 - 强化班（16-18岁）', '1', '1', '1', '1502175428', '1502264835', null, '', '');
INSERT INTO `plan` VALUES ('5', '张彩玲', '3', '3', '大热color篮球训练营', '前台发布教案2', '前台发布的教案2 测试时司法局施蒂利克富家大室六块腹肌倒是来k', '0', 'a:2:{i:1;a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:12:\"热身游戏\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:16;a:5:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:30:\"抢尾巴（无球、运球）\";s:3:\"pid\";s:1:\"1\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}i:3;a:5:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:6:\"传球\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:12;a:5:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:18:\"单人对墙传球\";s:3:\"pid\";s:1:\"3\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}}', '7', '小学 - 基础班（7-9岁）', '1', '0', '0', '1502175428', '1502261042', null, '', '');
INSERT INTO `plan` VALUES ('6', '', '0', '0', '平台', '6-7岁球队教案', '6-7岁球队教案', '0', 'a:2:{i:1;a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:12:\"热身游戏\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:1:{i:16;a:5:{s:2:\"id\";s:2:\"16\";s:4:\"name\";s:30:\"抢尾巴（无球、运球）\";s:3:\"pid\";s:1:\"1\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}i:3;a:5:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:6:\"传球\";s:3:\"pid\";i:0;s:6:\"_level\";i:1;s:5:\"_data\";a:3:{i:12;a:5:{s:2:\"id\";s:2:\"12\";s:4:\"name\";s:18:\"单人对墙传球\";s:3:\"pid\";s:1:\"3\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}i:14;a:5:{s:2:\"id\";s:2:\"14\";s:4:\"name\";s:21:\"两人原地传接球\";s:3:\"pid\";s:1:\"3\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}i:15;a:5:{s:2:\"id\";s:2:\"15\";s:4:\"name\";s:33:\"三人或多人同时传球练习\";s:3:\"pid\";s:1:\"3\";s:6:\"_level\";i:2;s:5:\"_data\";a:0:{}}}}}', '22', '迷你球队（6-7岁）', '0', '1', '1', '1502264901', '1502264901', null, '', '');
INSERT INTO `plan` VALUES ('7', 'weilin', '1', '1', '大热伟霖篮球训练营', '大纲1', '大纲介绍', '0', 'a:2:{i:0;s:33:\"三人或多人同时传球练习\";i:1;s:18:\"紧贴防守单打\";}', '3', '幼儿兴趣班（季度卡）', '1', '1', '0', '1506137003', '1506137003', null, '', '');
INSERT INTO `plan` VALUES ('8', 'weilin', '1', '1', '大热伟霖篮球训练营', '大纲2', '大纲2介绍', 'a:2:{i:0;s:2:\"15\";i:1;s:2:\"17\";}', 'a:2:{i:0;s:33:\"三人或多人同时传球练习\";i:1;s:18:\"紧贴防守单打\";}', '3', '幼儿兴趣班（季度卡）', '1', '1', '0', '1506137095', '1506137095', null, '', '');
INSERT INTO `plan` VALUES ('9', 'weilin', '1', '1', '大热伟霖篮球训练营', '大纲3', '大纲333333', 'a:6:{i:0;s:2:\"12\";i:1;s:2:\"14\";i:2;s:2:\"15\";i:3;s:2:\"17\";i:4;s:2:\"16\";i:5;s:2:\"19\";}', 'a:6:{i:0;s:18:\"单人对墙传球\";i:1;s:21:\"两人原地传接球\";i:2;s:33:\"三人或多人同时传球练习\";i:3;s:18:\"紧贴防守单打\";i:4;s:30:\"抢尾巴（无球、运球）\";i:5;s:37:\"雪糕筒大战（无球 、运球）\";}', '3', '幼儿兴趣班（季度卡）', '1', '0', '0', '1506137759', '1506137759', null, '', '');

-- ----------------------------
-- Table structure for `rebate`
-- ----------------------------
DROP TABLE IF EXISTS `rebate`;
CREATE TABLE `rebate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL COMMENT '获得佣金的人',
  `member` varchar(60) NOT NULL,
  `sid` int(10) NOT NULL COMMENT 'member的下线id',
  `s_member` varchar(60) NOT NULL COMMENT 'member的下线',
  `salary` decimal(8,2) NOT NULL,
  `score` decimal(8,2) NOT NULL,
  `salary_id` int(10) NOT NULL,
  `tier` tinyint(4) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='收入提成';

-- ----------------------------
-- Records of rebate
-- ----------------------------
INSERT INTO `rebate` VALUES ('1', '1', 'weilin', '22', 'alice.wu', '4.48', '0.00', '22', '2', '1504066306', '1504066306', null);
INSERT INTO `rebate` VALUES ('2', '5', 'ho', '1', 'weilin', '2.69', '0.00', '22', '3', '1504066306', '1504066306', null);
INSERT INTO `rebate` VALUES ('3', '5', 'ho', '23', 'weilin', '0.64', '0.00', '23', '2', '1504066306', '1504066306', null);
INSERT INTO `rebate` VALUES ('4', '3', 'coloring', '5', 'ho', '0.38', '0.00', '23', '3', '1504066306', '1504066306', null);
INSERT INTO `rebate` VALUES ('5', '1', 'weilin', '24', 'alice.wu', '0.00', '0.00', '24', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('6', '5', 'ho', '1', 'weilin', '0.00', '0.00', '24', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('7', '5', 'ho', '25', 'weilin', '0.00', '0.00', '25', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('8', '3', 'coloring', '5', 'ho', '0.00', '0.00', '25', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('9', '1', 'weilin', '26', 'alice.wu', '0.00', '0.00', '26', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('10', '5', 'ho', '1', 'weilin', '0.00', '0.00', '26', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('11', '5', 'ho', '27', 'weilin', '0.00', '0.00', '27', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('12', '3', 'coloring', '5', 'ho', '0.00', '0.00', '27', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('13', '1', 'weilin', '28', 'alice.wu', '0.00', '0.00', '28', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('14', '5', 'ho', '1', 'weilin', '0.00', '0.00', '28', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('15', '5', 'ho', '29', 'weilin', '0.00', '0.00', '29', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('16', '3', 'coloring', '5', 'ho', '0.00', '0.00', '29', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('17', '1', 'weilin', '30', 'alice.wu', '0.00', '0.00', '30', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('18', '5', 'ho', '1', 'weilin', '0.00', '0.00', '30', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('19', '5', 'ho', '31', 'weilin', '0.00', '0.00', '31', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('20', '3', 'coloring', '5', 'ho', '0.00', '0.00', '31', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('21', '1', 'weilin', '32', 'alice.wu', '0.00', '0.00', '32', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('22', '5', 'ho', '1', 'weilin', '0.00', '0.00', '32', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('23', '5', 'ho', '33', 'weilin', '0.00', '0.00', '33', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('24', '3', 'coloring', '5', 'ho', '0.00', '0.00', '33', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('25', '1', 'weilin', '34', 'alice.wu', '0.00', '0.00', '34', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('26', '5', 'ho', '1', 'weilin', '0.00', '0.00', '34', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('27', '2', 'alice.wu', '35', 'coloring', '0.00', '0.00', '35', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('28', '1', 'weilin', '2', 'alice.wu', '0.00', '0.00', '35', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('29', '5', 'ho', '36', 'weilin', '0.00', '0.00', '36', '2', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('30', '3', 'coloring', '5', 'ho', '0.00', '0.00', '36', '3', '1504066307', '1504066307', null);
INSERT INTO `rebate` VALUES ('31', '1', 'weilin', '37', 'alice.wu', '0.00', '0.00', '37', '2', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('32', '5', 'ho', '1', 'weilin', '0.00', '0.00', '37', '3', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('33', '2', 'alice.wu', '38', 'coloring', '0.00', '0.00', '38', '2', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('34', '1', 'weilin', '2', 'alice.wu', '0.00', '0.00', '38', '3', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('35', '5', 'ho', '39', 'weilin', '0.00', '0.00', '39', '2', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('36', '3', 'coloring', '5', 'ho', '0.00', '0.00', '39', '3', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('37', '1', 'weilin', '40', 'alice.wu', '0.00', '0.00', '40', '2', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('38', '5', 'ho', '1', 'weilin', '0.00', '0.00', '40', '3', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('39', '2', 'alice.wu', '41', 'coloring', '0.00', '0.00', '41', '2', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('40', '1', 'weilin', '2', 'alice.wu', '0.00', '0.00', '41', '3', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('41', '5', 'ho', '42', 'weilin', '0.00', '0.00', '42', '2', '1504066308', '1504066308', null);
INSERT INTO `rebate` VALUES ('42', '3', 'coloring', '5', 'ho', '0.00', '0.00', '42', '3', '1504066308', '1504066308', null);

-- ----------------------------
-- Table structure for `rebate_hp`
-- ----------------------------
DROP TABLE IF EXISTS `rebate_hp`;
CREATE TABLE `rebate_hp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member` varchar(50) NOT NULL COMMENT '会员',
  `sid` int(11) NOT NULL COMMENT '下线会员id',
  `s_member` varchar(50) NOT NULL COMMENT '下线会员',
  `tier` int(11) NOT NULL COMMENT '下线层级',
  `bill_id` int(11) NOT NULL COMMENT '订单bill_id',
  `bill_order` varchar(50) NOT NULL COMMENT '订单号',
  `rebate_hp` int(11) NOT NULL DEFAULT '0' COMMENT '返利hp数值',
  `paymoney` decimal(8,2) NOT NULL COMMENT '消费金额',
  `status` int(11) NOT NULL COMMENT '状态1:正常|0:无效',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='HP业绩返利';

-- ----------------------------
-- Records of rebate_hp
-- ----------------------------
INSERT INTO `rebate_hp` VALUES ('9', '1', 'weilin', '0', '', '1', '2', '12017083011051264101', '1000', '1000.00', '1', '1504072740', '1504072740');
INSERT INTO `rebate_hp` VALUES ('10', '5', 'ho', '1', 'weilin', '2', '2', '12017083011051264101', '1000', '1000.00', '1', '1504072740', '1504072740');
INSERT INTO `rebate_hp` VALUES ('11', '3', 'coloring', '5', 'ho', '3', '2', '12017083011051264101', '1000', '1000.00', '1', '1504072740', '1504072740');
INSERT INTO `rebate_hp` VALUES ('12', '1', 'weilin', '0', '', '1', '2', '12017083011051264101', '1000', '1000.00', '1', '1504073993', '1504073993');

-- ----------------------------
-- Table structure for `rebate_score`
-- ----------------------------
DROP TABLE IF EXISTS `rebate_score`;
CREATE TABLE `rebate_score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member` varchar(50) NOT NULL COMMENT '会员',
  `sid` int(11) NOT NULL COMMENT '下线会员id',
  `s_member` varchar(50) NOT NULL COMMENT '下线会员',
  `tier` int(11) NOT NULL COMMENT '下线层级',
  `bill_id` int(11) NOT NULL COMMENT '订单bill_id',
  `bill_order` varchar(50) NOT NULL COMMENT '订单号',
  `rebate_score` int(11) NOT NULL DEFAULT '0' COMMENT '返利积分数值',
  `paymoney` decimal(8,2) NOT NULL COMMENT '消费金额',
  `status` int(11) NOT NULL COMMENT '状态1:正常|0:无效',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='积分返利';

-- ----------------------------
-- Records of rebate_score
-- ----------------------------
INSERT INTO `rebate_score` VALUES ('12', '1', 'weilin', '0', '', '1', '2', '12017083011051264101', '1000', '1000.00', '1', '1504074072', '1504074072');
INSERT INTO `rebate_score` VALUES ('13', '5', 'ho', '1', 'weilin', '2', '2', '12017083011051264101', '500', '1000.00', '1', '1504074072', '1504074072');
INSERT INTO `rebate_score` VALUES ('14', '3', 'coloring', '5', 'ho', '3', '2', '12017083011051264101', '300', '1000.00', '1', '1504074072', '1504074072');

-- ----------------------------
-- Table structure for `salary_in`
-- ----------------------------
DROP TABLE IF EXISTS `salary_in`;
CREATE TABLE `salary_in` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salary` decimal(8,2) NOT NULL COMMENT '收入金额',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `realname` varchar(60) NOT NULL,
  `pid` int(10) NOT NULL COMMENT '推荐人member_id',
  `level` tinyint(4) NOT NULL COMMENT '用户当前等级',
  `lesson_id` int(10) NOT NULL,
  `lesson` varchar(60) NOT NULL COMMENT '课程',
  `grade_id` int(10) NOT NULL,
  `grade` varchar(60) NOT NULL,
  `star` decimal(3,1) NOT NULL COMMENT '评分',
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `create_time` int(10) NOT NULL COMMENT '支付时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:  1:成功|0:失败',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '收入类型  1:教学',
  `member_type` int(11) NOT NULL COMMENT '用户身份[教练|班主任|领队|副教练|机构]',
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='系统发放教练佣金';

-- ----------------------------
-- Records of salary_in
-- ----------------------------
INSERT INTO `salary_in` VALUES ('22', '89.60', '2', 'alice.wu', '吴丽文', '1', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('23', '12.80', '1', 'weilin', '刘伟霖', '5', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);
INSERT INTO `salary_in` VALUES ('24', '0.00', '2', 'alice.wu', '吴丽文', '1', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('25', '0.00', '1', 'weilin', '刘伟霖', '5', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);
INSERT INTO `salary_in` VALUES ('26', '0.00', '2', 'alice.wu', '吴丽文', '1', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('27', '0.00', '1', 'weilin', '刘伟霖', '5', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);
INSERT INTO `salary_in` VALUES ('28', '0.00', '2', 'alice.wu', '吴丽文', '1', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('29', '0.00', '1', 'weilin', '刘伟霖', '5', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);
INSERT INTO `salary_in` VALUES ('30', '0.00', '2', 'alice.wu', '吴丽文', '1', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('31', '0.00', '1', 'weilin', '刘伟霖', '5', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);
INSERT INTO `salary_in` VALUES ('32', '0.00', '2', 'alice.wu', '吴丽文', '1', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('33', '0.00', '1', 'weilin', '刘伟霖', '5', '1', '1', '小学暑期篮球基础', '2', '小学暑期篮球基础1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);
INSERT INTO `salary_in` VALUES ('34', '0.00', '2', 'alice.wu', '吴丽文', '1', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('35', '0.00', '3', 'coloring', '张彩玲', '2', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('36', '0.00', '1', 'weilin', '刘伟霖', '5', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);
INSERT INTO `salary_in` VALUES ('37', '0.00', '2', 'alice.wu', '吴丽文', '1', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('38', '0.00', '3', 'coloring', '张彩玲', '2', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('39', '0.00', '1', 'weilin', '刘伟霖', '5', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);
INSERT INTO `salary_in` VALUES ('40', '0.00', '2', 'alice.wu', '吴丽文', '1', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('41', '0.00', '3', 'coloring', '张彩玲', '2', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '4', '1504066267', null);
INSERT INTO `salary_in` VALUES ('42', '0.00', '1', 'weilin', '刘伟霖', '5', '1', '2', '控球后卫进阶暑假班', '3', '控球后卫进阶暑假1班', '0.0', '1', '大热伟霖篮球训练营', '1504066267', '1', '1', '1', '1504066267', null);

-- ----------------------------
-- Table structure for `salary_out`
-- ----------------------------
DROP TABLE IF EXISTS `salary_out`;
CREATE TABLE `salary_out` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salary` decimal(8,2) NOT NULL COMMENT '佣金',
  `tid` bigint(20) NOT NULL COMMENT '交易单号',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `realname` varchar(60) NOT NULL COMMENT '真实姓名',
  `telephone` bigint(11) NOT NULL,
  `ident` bigint(20) NOT NULL COMMENT '身份证号',
  `openid` varchar(64) NOT NULL,
  `bank_card` varchar(64) NOT NULL COMMENT '银行卡号',
  `bank` varchar(30) NOT NULL COMMENT '账号类型,如农业银行|支付宝',
  `fee` decimal(6,2) NOT NULL COMMENT '手续费',
  `pay_time` int(10) NOT NULL,
  `bank_type` tinyint(4) NOT NULL COMMENT '1:银行卡|2:支付宝',
  `is_pay` tinyint(4) NOT NULL DEFAULT '0',
  `callback_str` text NOT NULL COMMENT '支付回调',
  `create_time` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:申请中|1:已支付|2:取消|-1:对冲',
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='佣金提现申请';

-- ----------------------------
-- Records of salary_out
-- ----------------------------
INSERT INTO `salary_out` VALUES ('1', '500.00', '0', '1', 'weilin', '刘伟霖', '13410599613', '440301199306022938', '', '6222980025543612', '平安银行', '2.50', '1502866805', '0', '1', 'callback_str', '1502866805', '1', null);
INSERT INTO `salary_out` VALUES ('2', '30.00', '2017092317533261961', '1', 'weilin', '大笨猪', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', '789654569874563210', '工商银行', '0.00', '0', '1', '0', '', '1506160476', '0', null);
INSERT INTO `salary_out` VALUES ('3', '30.00', '2017092317533261961', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506160500', '0', null);
INSERT INTO `salary_out` VALUES ('4', '30.00', '2017092317533261961', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506160555', '0', null);
INSERT INTO `salary_out` VALUES ('5', '30.00', '2017092317533261961', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506160562', '0', null);
INSERT INTO `salary_out` VALUES ('6', '30.00', '2017092317533261961', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506160626', '0', null);
INSERT INTO `salary_out` VALUES ('7', '30.00', '2017092317533261961', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506160720', '0', null);
INSERT INTO `salary_out` VALUES ('8', '-89.92', '2017092317584210581', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506160730', '0', null);
INSERT INTO `salary_out` VALUES ('9', '-89.92', '2017092317593060101', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506160806', '0', null);
INSERT INTO `salary_out` VALUES ('10', '-89.92', '2017092318003079871', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506160843', '0', null);
INSERT INTO `salary_out` VALUES ('11', '50.00', '2017092318095225071', '1', 'weilin', '大笨猪', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', '789654569874563210', '工商银行', '0.00', '0', '1', '0', '', '1506161399', '0', null);
INSERT INTO `salary_out` VALUES ('12', '10.00', '2017092318161223601', '1', 'weilin', '支付宝主人', '56', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', 'wsd12342@qq.com', '支付宝', '0.00', '0', '2', '0', '', '1506161783', '0', null);

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
  `teacher_id` int(10) NOT NULL COMMENT 'member表id',
  `coach` varchar(60) NOT NULL COMMENT '教练',
  `coach_id` int(10) NOT NULL COMMENT 'member表id',
  `students` int(10) NOT NULL COMMENT '上课学生总数',
  `student_str` text NOT NULL COMMENT '来上课的学生姓名集合,隔开',
  `assistant_id` varchar(255) NOT NULL COMMENT 'id',
  `assistant` varchar(255) NOT NULL COMMENT '助教',
  `coach_salary` decimal(8,2) NOT NULL,
  `assistant_salary` decimal(8,2) NOT NULL,
  `salary_base` decimal(8,2) NOT NULL,
  `leave_ids` varchar(255) NOT NULL COMMENT 'ids',
  `leave` varchar(255) NOT NULL DEFAULT '0' COMMENT '请假人员总数',
  `lesson_date` date NOT NULL COMMENT '训练日期,2017-7-26',
  `plan_id` int(10) NOT NULL COMMENT 'id',
  `plan` varchar(255) NOT NULL COMMENT '教案',
  `lesson_time` int(10) NOT NULL COMMENT '上课时间,17:17:33',
  `cover` varchar(255) NOT NULL COMMENT '课时封面',
  `province` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `city` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `area` varchar(60) NOT NULL COMMENT '默认为课程地址',
  `court_id` int(10) NOT NULL,
  `court` varchar(255) NOT NULL COMMENT '默认为课程地址',
  `location` varchar(255) NOT NULL COMMENT '默认为课程地址',
  `rent` decimal(6,2) NOT NULL COMMENT '场地租金',
  `star` decimal(4,1) NOT NULL DEFAULT '20.0' COMMENT '评价平均分,满分20',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `media_ids` varchar(255) NOT NULL,
  `media_urls` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:正常|0:草稿或未审核|-1:删除',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of schedule
-- ----------------------------
INSERT INTO `schedule` VALUES ('1', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7', '吴丽文', '100.00', '80.00', '30.00', '', '0', '2017-08-23', '0', '', '1501291800', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '14.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('2', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7', '吴丽文', '500.00', '400.00', '10.00', '', '0', '2017-08-23', '0', '', '1501378200', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '0.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('3', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7', '吴丽文', '400.00', '300.00', '20.00', '', '0', '2017-08-23', '0', '', '1501896600', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '0.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('4', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7', '吴丽文', '300.00', '250.00', '15.00', '', '0', '2017-08-23', '0', '', '1501983000', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '0.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('5', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7', '吴丽文', '800.00', '600.00', '5.00', '', '0', '2017-08-23', '0', '', '1502501400', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '0.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('6', '1', '大热伟霖篮球训练营', '小学暑期篮球基础', '1', '小学暑期篮球基础1班', '2', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7', '吴丽文', '400.00', '300.00', '50.00', '', '0', '2017-08-23', '0', '', '1502587800', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '0.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('7', '1', '大热伟霖篮球训练营', '控球后卫进阶暑假班', '2', '控球后卫进阶暑假1班', '3', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7,8', '吴丽文,张彩玲', '750.00', '500.00', '100.00', '', '0', '2017-08-23', '0', '', '1501311600', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '0.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('8', '1', '大热伟霖篮球训练营', '控球后卫进阶暑假班', '2', '控球后卫进阶暑假1班', '3', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7,8', '吴丽文,张彩玲', '1000.00', '100.00', '200.00', '', '0', '2017-08-23', '0', '', '1501916400', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '0.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('9', '1', '大热伟霖篮球训练营', '控球后卫进阶暑假班', '2', '控球后卫进阶暑假1班', '3', '7', '小学 - 基础班（7-9岁）', '刘伟霖', '1', '刘伟霖', '1', '2', '陈烈准,吴光蔚', '7,8', '吴丽文,张彩玲', '500.00', '300.00', '150.00', '', '0', '2017-08-23', '0', '', '1502521200', '', '广东省', '深圳市', '罗湖区', '0', '滨河小学篮球场', '', '0.00', '0.0', '', '', '', '1', '1503814506', null);
INSERT INTO `schedule` VALUES ('10', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '11', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('11', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '10', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('12', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '9', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('13', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '10', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('14', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('15', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('16', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('17', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('18', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('19', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('20', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('21', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('22', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('23', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('24', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('25', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('26', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('27', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('28', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '陈烈准吴光蔚学员2学员3', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('29', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '陈烈准吴光蔚学员3学员4,', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('30', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('31', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '陈烈准吴光蔚学员4,', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('32', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '陈烈准吴光蔚学员2学员3', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('33', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '陈烈准吴光蔚学员1学员2', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('34', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '\n                                主教练\n                       ', '0', '0', '陈烈准吴光蔚', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '19', '', '', '', '', '0', '', 'asfsaf', '0.00', '20.0', '', '', '', '0', '0', null);
INSERT INTO `schedule` VALUES ('35', '1', '', '', '0', '小学暑期篮球基础1班', '2', '0', '', '刘伟霖', '0', '刘伟霖', '0', '0', '陈烈准,吴光蔚,学员1,学员2,学员3', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', '0', '', '12', '', '', '', '', '0', '', '滨河小学篮球场', '0.00', '20.0', '', '', '', '0', '0', null);

-- ----------------------------
-- Table structure for `schedule_comment`
-- ----------------------------
DROP TABLE IF EXISTS `schedule_comment`;
CREATE TABLE `schedule_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule` varchar(60) NOT NULL,
  `schedule_id` int(10) NOT NULL,
  `coach_id` int(10) NOT NULL,
  `coach` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `comment` varchar(240) NOT NULL COMMENT '评论内容',
  `attitude` decimal(2,1) NOT NULL COMMENT '态度得分',
  `profession` decimal(2,1) NOT NULL COMMENT '专业得分',
  `teaching_attitude` decimal(2,1) NOT NULL COMMENT '教学态度得分',
  `teaching_quality` decimal(2,1) NOT NULL COMMENT '教学质量评分',
  `anonymous` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:匿名|1:公开',
  `star` decimal(4,1) NOT NULL COMMENT '评价总分,总满分20',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:主教练|2:助教',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of schedule_comment
-- ----------------------------
INSERT INTO `schedule_comment` VALUES ('1', '小学暑期篮球基础1班', '1', '1', '刘伟林', '2', 'woo', '教的不错', '4.0', '3.0', '2.0', '5.0', '0', '14.0', '1', '2017-08-24 08:28:26', '0', null);
INSERT INTO `schedule_comment` VALUES ('2', '小学暑期篮球基础1班', '1', '1', '刘伟林', '3', 'coloring', '一般般', '3.0', '2.0', '5.0', '1.0', '0', '11.0', '1', '2017-08-24 08:28:40', '0', null);

-- ----------------------------
-- Table structure for `schedule_media`
-- ----------------------------
DROP TABLE IF EXISTS `schedule_media`;
CREATE TABLE `schedule_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL COMMENT '对应student_id或者coach_id或者班主任id',
  `schedule` varchar(240) NOT NULL,
  `url` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of schedule_media
-- ----------------------------
INSERT INTO `schedule_media` VALUES ('1', '1', '小学暑期篮球基础1班', '/static/frontend/images/shuijiao.jpg', '1503391431', '1503391431', null);

-- ----------------------------
-- Table structure for `schedule_member`
-- ----------------------------
DROP TABLE IF EXISTS `schedule_member`;
CREATE TABLE `schedule_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL,
  `schedule` varchar(240) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `user_id` int(10) NOT NULL COMMENT '如果身份是student,则对应student_id,coach->coach_id',
  `user` varchar(60) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:学生|1:教练;如果是0,member_id为student表的id',
  `status` tinyint(4) NOT NULL COMMENT '0:请假|1:正常',
  `schedule_time` int(10) NOT NULL COMMENT '上课时间',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='课时-会员关系';

-- ----------------------------
-- Records of schedule_member
-- ----------------------------
INSERT INTO `schedule_member` VALUES ('1', '1', '小学暑期篮球基础1班', '1', '大热伟霖篮球训练营', '1', '学生1', '1', '1', '1500965520', '1500965520', null);
INSERT INTO `schedule_member` VALUES ('2', '1', '小学暑期篮球基础1班', '1', '大热伟霖篮球训练营', '2', '学生2', '0', '1', '1500965520', '1500965520', null);
INSERT INTO `schedule_member` VALUES ('3', '1', '小学暑期篮球基础1班', '1', '大热伟霖篮球训练营', '3', '学生3', '0', '0', '1500965520', '1500965520', null);

-- ----------------------------
-- Table structure for `score`
-- ----------------------------
DROP TABLE IF EXISTS `score`;
CREATE TABLE `score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `score` int(10) NOT NULL,
  `score_des` varchar(240) NOT NULL COMMENT '积分说明:订单积分|活动积分|xxx赠送积分',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='积分记录表';

-- ----------------------------
-- Records of score
-- ----------------------------
INSERT INTO `score` VALUES ('1', '1000', '消费积分', '1', '伟霖', null, '0', '0');
INSERT INTO `score` VALUES ('2', '200', '人头积分', '1', '伟霖', null, '0', '0');
INSERT INTO `score` VALUES ('3', '500', '消费积分', '2', 'woo', null, '0', '0');
INSERT INTO `score` VALUES ('4', '2000', '奖励积分', '2', 'woo', null, '0', '0');
INSERT INTO `score` VALUES ('5', '10000', '系统奖励积分', '1', '伟霖', null, '0', '0');

-- ----------------------------
-- Table structure for `sells`
-- ----------------------------
DROP TABLE IF EXISTS `sells`;
CREATE TABLE `sells` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salary` decimal(8,2) NOT NULL,
  `score` int(10) NOT NULL,
  `goods_id` int(10) NOT NULL,
  `goods` varchar(255) NOT NULL,
  `goods_quantity` int(10) NOT NULL COMMENT '商品数量',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品销售分红收入';

-- ----------------------------
-- Records of sells
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
  `coachlevel1` int(10) NOT NULL DEFAULT '10' COMMENT '教练等级1所需课流量',
  `coachlevel2` int(10) NOT NULL DEFAULT '50',
  `coachlevel3` int(10) NOT NULL DEFAULT '100',
  `coachlevel4` int(10) NOT NULL DEFAULT '200',
  `coachlevel5` int(10) NOT NULL DEFAULT '350',
  `coachlevel6` int(10) NOT NULL DEFAULT '750',
  `coachlevel7` int(10) NOT NULL DEFAULT '1000',
  `coachlevel8` int(10) NOT NULL DEFAULT '1500',
  `keywords` varchar(255) NOT NULL DEFAULT '关键词',
  `description` varchar(255) NOT NULL DEFAULT '大热篮球',
  `footer` varchar(255) NOT NULL DEFAULT 'copyright@2016,备案111',
  `title` varchar(255) NOT NULL DEFAULT 'HOT',
  `wxappid` varchar(64) NOT NULL,
  `wxsecret` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL DEFAULT 'logo',
  `banner` text NOT NULL COMMENT '序列化  a:3:{i:0;s:3:"url1";i:1;s:5:"url2";i:2;s:5:"url3";}',
  `lrss` int(10) NOT NULL COMMENT '上一节课平台奖励积分',
  `lrcs` int(10) NOT NULL COMMENT 'lesion_return_coach_score',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:不启用|1:启用',
  `coachlevel1award` int(10) NOT NULL COMMENT '升级到等级1给予的奖励,单位:分',
  `coachlevel2award` int(10) NOT NULL,
  `rebate` decimal(6,2) NOT NULL DEFAULT '0.05' COMMENT '每一级用户抽取提成:5%',
  `sysrebate` decimal(6,2) NOT NULL DEFAULT '0.25' COMMENT '平台抽取提成',
  `rebate2` decimal(6,2) NOT NULL DEFAULT '0.03' COMMENT '第二阶级人头佣金',
  `starrebate` decimal(6,2) NOT NULL DEFAULT '0.25' COMMENT '评价分扣减比例,评分满分得到全部佣金0.25,评分满分为100分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of setting
-- ----------------------------
INSERT INTO `setting` VALUES ('1', '大热篮球平台', '10', '30', '50', '50', '100', '150', '0', '0', '0', '0', '0', '大热篮球平台', '大热篮球平台fsdfsdf', '© 2017 1Zstudio. All Rights Reserved.', 'HOT 大热篮球平台', '', '', '/static/default/logo.jpg', 'a:3:{i:0;s:28:\"/uploads/images/banner/1.jpg\";i:1;s:28:\"/uploads/images/banner/2.jpg\";i:2;s:28:\"/uploads/images/banner/3.jpg\";}', '50', '100', '1', '500', '1000', '0.05', '0.30', '0.03', '0.20');

-- ----------------------------
-- Table structure for `smsverify`
-- ----------------------------
DROP TABLE IF EXISTS `smsverify`;
CREATE TABLE `smsverify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` bigint(11) NOT NULL COMMENT '手机号码',
  `smscode` int(10) NOT NULL COMMENT '短信验证码',
  `content` text COMMENT '短信内容',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `use` varchar(50) DEFAULT NULL COMMENT '验证码使用场景,存中文',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态:0未使用|1已使用|2已失效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='发送短信';

-- ----------------------------
-- Records of smsverify
-- ----------------------------
INSERT INTO `smsverify` VALUES ('1', '13410599613', '562849', '{\"code\":\"562849\",\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505268050', '会员注册', '0');
INSERT INTO `smsverify` VALUES ('2', '13410599613', '614809', '{\"code\":\"614809\",\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505268050', '会员注册', '1');
INSERT INTO `smsverify` VALUES ('3', '13410599613', '928476', '{\"code\":\"928476\",\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505461676', '会员注册', '0');
INSERT INTO `smsverify` VALUES ('4', '13410599613', '487206', '{\"code\":\"487206\",\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505548196', '会员注册', '1');
INSERT INTO `smsverify` VALUES ('5', '13410599613', '193752', '{\"code\":\"193752\",\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505548391', '会员注册', '0');
INSERT INTO `smsverify` VALUES ('6', '13410599613', '201965', '{\"code\":\"201965\",\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505548423', '训练营注册', '0');
INSERT INTO `smsverify` VALUES ('7', '18507717466', '928668', '{\"code\":928668,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505805522', '会员注册', '0');
INSERT INTO `smsverify` VALUES ('8', '18507717466', '808512', '{\"code\":808512,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505805753', '会员注册', '1');
INSERT INTO `smsverify` VALUES ('9', '18507717466', '570153', '{\"code\":570153,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1505806564', '会员注册', '1');
INSERT INTO `smsverify` VALUES ('10', '13410599613', '842467', '{\"code\":842467,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', '1506159157', '会员注册', '1');

-- ----------------------------
-- Table structure for `student`
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `member` varchar(60) NOT NULL COMMENT '对应member表的昵称',
  `student` varchar(60) NOT NULL COMMENT '学生姓名',
  `student_sex` int(11) NOT NULL DEFAULT '0' COMMENT '学员性别:1男|0女|2未知',
  `openid` varchar(255) NOT NULL DEFAULT '0',
  `student_birthday` date NOT NULL,
  `parent_id` int(10) NOT NULL COMMENT '父母id',
  `parent` varchar(60) NOT NULL COMMENT '家长姓名',
  `student_avatar` varchar(255) NOT NULL DEFAULT '/static/default/avatar.png',
  `mobile` varchar(20) NOT NULL COMMENT '联系电话',
  `emergency_telephone` bigint(11) NOT NULL COMMENT '紧急电话',
  `school` varchar(255) NOT NULL COMMENT '学校',
  `student_charater` varchar(255) NOT NULL COMMENT '性格特点',
  `student_weight` decimal(8,2) NOT NULL COMMENT '单位kg',
  `student_height` decimal(8,2) NOT NULL COMMENT '学生身高单位cm',
  `student_shoe_code` varchar(60) NOT NULL COMMENT '鞋码',
  `remarks` varchar(250) NOT NULL,
  `total_lesson` int(10) NOT NULL DEFAULT '0' COMMENT '全部课程',
  `finished_total` int(10) NOT NULL COMMENT '已上课程',
  `delete_time` int(10) DEFAULT NULL,
  `student_province` varchar(60) NOT NULL COMMENT '所在地区:省',
  `student_city` varchar(60) NOT NULL COMMENT '所在地区:市',
  `student_area` varchar(60) NOT NULL COMMENT '所在地区:区',
  `create_time` int(10) NOT NULL COMMENT '学员注册时间',
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('1', '2', 'woo', '吴丽文', '2', '0', '0000-00-00', '0', '吴妈妈', '/static/default/avatar.png', '', '18888888888', '阳光小学', '开朗', '55.00', '160.00', '235', '', '1', '0', null, '广东省', '深圳市', '南山区', '1503129226', '2017');
INSERT INTO `student` VALUES ('2', '4', '陈烈准', '陈烈准', '1', '0', '0000-00-00', '0', '陈爸爸', '/static/default/avatar.png', '', '0', '南山小学', '内向', '65.00', '185.00', '222', '', '0', '0', null, '广东省', '深圳市', '南山区', '1503129226', '2017');
INSERT INTO `student` VALUES ('3', '5', '陈烈候', '陈烈候', '1', '0', '0000-00-00', '0', '陈妈妈', '/static/default/avatar.png', '', '0', '南山中学', '活泼', '58.00', '174.00', '200', '', '0', '0', null, '广东省', '广州市', '宝安区', '1503129226', '2017');
INSERT INTO `student` VALUES ('4', '2', '吴光蔚', '吴光蔚', '1', '0', '0000-00-00', '0', '吴爸爸', '/static/default/avatar.png', '', '0', '南山小学', '调皮', '59.20', '160.50', '185', '', '0', '0', null, '广东省', '东莞市', '龙岗区', '1503129226', '2017');
INSERT INTO `student` VALUES ('5', '2', '刘伟霖', '刘小霖', '1', '0', '2010-12-06', '0', '刘爸爸', '/static/default/avatar.png', '', '0', '滨河小学', '喜欢装x', '45.50', '155.50', '170', '', '0', '0', null, '广东省', '深圳市', '罗湖区', '1503129226', '0');
INSERT INTO `student` VALUES ('6', '1', 'weilin', '吴宝宝', '0', '0', '0000-00-00', '0', '吴爸爸', '/static/default/avatar.png', '', '18507717466', '', '', '0.00', '0.00', '', '', '0', '0', null, '', '', '', '0', '0');
INSERT INTO `student` VALUES ('7', '1', 'weilin', '吴宝宝', '0', '0', '0000-00-00', '0', '吴爸爸', '/static/default/avatar.png', '', '18507717466', '', '', '0.00', '0.00', '', '', '0', '0', null, '', '', '', '0', '0');

-- ----------------------------
-- Table structure for `system_award`
-- ----------------------------
DROP TABLE IF EXISTS `system_award`;
CREATE TABLE `system_award` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salary` decimal(8,2) NOT NULL,
  `score` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(10) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '奖励类型:1等级|2:阶衔|3:其他',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统奖励记录表';

-- ----------------------------
-- Records of system_award
-- ----------------------------
