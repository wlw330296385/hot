/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-03-09 16:59:34
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `star` int(11) NOT NULL DEFAULT '0' COMMENT '评分总分数',
  `star_num` int(11) NOT NULL DEFAULT '0' COMMENT '评分次数',
  `total_grade` int(10) NOT NULL DEFAULT '0' COMMENT '所有班级数量',
  `act_grade` int(10) NOT NULL DEFAULT '0' COMMENT '当前活跃班级数量',
  `total_events` int(11) NOT NULL DEFAULT '0' COMMENT '活动数量',
  `total_schedule` int(10) NOT NULL DEFAULT '0',
  `logo` varchar(255) DEFAULT '/static/frontend/images/uploadDefault.jpg' COMMENT '训练营LOGO',
  `camp_base` int(10) NOT NULL DEFAULT '0' COMMENT '训练点数量',
  `remarks` text COMMENT '个人备注',
  `system_remarks` text COMMENT '平台备注',
  `location` varchar(255) DEFAULT '' COMMENT '具体地址',
  `province` varchar(60) DEFAULT '' COMMENT '省',
  `city` varchar(60) DEFAULT '' COMMENT '市',
  `area` varchar(60) DEFAULT '' COMMENT '区',
  `camp_telephone` varchar(60) DEFAULT '' COMMENT '电话号码, 默认为负责人电话号码',
  `camp_email` varchar(60) DEFAULT '' COMMENT '邮箱，默认为负责人邮箱',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '训练营类型:0 独立用户|1 机构|2 其他',
  `banner` varchar(255) DEFAULT '/static/frontend/images/uploadDefault.jpg' COMMENT '封面图',
  `company` varchar(255) DEFAULT '' COMMENT '所属公司, 个人则为空',
  `cert_id` int(11) DEFAULT '0' COMMENT '证件表id',
  `hot` int(10) NOT NULL DEFAULT '0' COMMENT '热度,越高越热,点击率或者搜索度',
  `camp_introduction` text NOT NULL,
  `balance` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '训练营营业额',
  `score` int(10) NOT NULL COMMENT '训练营积分',
  `rebate_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:第一种结算方式|2:第二种结算方式',
  `schedule_rebate` decimal(4,2) NOT NULL DEFAULT '0.10',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态:0 待审核|1 正常|2 关闭|3 重新审核',
  `balance_true` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '可提现营业额',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of camp
-- ----------------------------
INSERT INTO `camp` VALUES ('1', '大热体适能中心', '2', '大热篮球2', '0', '0', '0', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/09/59ca092820279.JPG', '2', '', '', '', '广东省', '深圳市', '南山区', '18565717133', '', '2', '/uploads/images/banner/2017/09/59ca0953d9cab.JPG', '大热总部', '0', '1', '大热室内训练', '0.00', '0', '1', '0.10', '1', '0.00', '1506412380', '1506414363', null);
INSERT INTO `camp` VALUES ('2', '大热前海训练营', '3', '大热篮球1', '0', '0', '0', '2', '0', '1', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/09/59ca0937e193b.jpg', '2', '', '', '', '广东省', '深圳市', '南山区', '15820474733', '', '2', '/uploads/images/banner/2017/09/59ca099495b13.jpg', '大热总部', '0', '1', '欢迎加入大热篮球训练营', '0.00', '0', '1', '0.10', '2', '0.00', '1506412380', '1506414356', null);
INSERT INTO `camp` VALUES ('3', '猴赛雷训练营', '1', '陈侯', '0', '0', '0', '19', '0', '1', '0', '0', '0', '2', '0', '2', '2', '/uploads/images/banner/2017/09/59ca09d5916c4.jpg', '3', '', '', '深圳总部', '广东省', '深圳市', '南山区', '13823599611', '', '2', '/uploads/images/banner/2017/10/59d8e043195d6.jpg', '大热总部', '0', '1', '大热猴塞雷', '0.00', '0', '1', '0.10', '1', '0.00', '1506412381', '1507385417', null);
INSERT INTO `camp` VALUES ('4', '准行者训练营', '6', '陈烈准', '0', '0', '0', '24', '0', '8', '0', '0', '0', '4', '0', '3', '3', '/uploads/images/banner/2017/09/59ca142b31f86.JPG', '3', '', '', '', '广东省', '深圳市', '南山区', '13826505160', '', '0', '/uploads/images/banner/2017/09/59ca14360c76b.JPG', '', '0', '1', 'I believe I can fly!', '4.00', '0', '1', '0.10', '1', '0.00', '1506415619', '1506422262', null);
INSERT INTO `camp` VALUES ('5', '荣光训练营', '7', '张伟荣', '0', '0', '0', '102', '0', '1', '0', '0', '0', '7', '0', '1', '9', '/uploads/images/banner/2017/12/5a39e655a8277.jpg', '9', '', '', '', '广东省', '深圳市', '福田区', '15018514302', '', '2', '/uploads/images/banner/2017/12/5a39e6214b56e.jpg', '', '0', '1', '荣光训练营', '0.00', '0', '1', '0.10', '2', '0.00', '1506565273', '1513743966', null);
INSERT INTO `camp` VALUES ('9', '大热篮球俱乐部', '2', '大热篮球', '0', '0', '0', '253', '0', '13', '0', '20', '4', '18', '0', '10', '36', '/uploads/images/banner/2017/09/59ce0f0bb2253.JPG', '3', '', '系统增加balance=3150,2017年10月18日15:37:31,系统增加余额=31920+840,total_member+1', '深圳南山阳光文体中心', '广东省', '深圳市', '南山区', '18565717133', '', '1', '/uploads/images/banner/2017/09/59ce0f1cd8156.JPG', '大热体育文化（深圳）有限公司', '0', '0', '', '84163.00', '0', '1', '0.10', '1', '0.00', '1506676445', '1507628247', null);
INSERT INTO `camp` VALUES ('13', 'AKcross训练营', '18', '安凯翔', '0', '0', '0', '35', '0', '5', '0', '0', '0', '1', '0', '0', '0', '/uploads/images/banner/2017/12/5a39ddf63d709.jpeg', '4', '', '', '', '广东省', '深圳市', '南山区', '18566201712', '', '0', '/uploads/images/banner/2017/12/5a39de1eb74c5.jpeg', '大热篮球', '0', '0', '这一秒不放弃，下一秒就有希望', '39798.00', '0', '1', '0.30', '1', '0.00', '1507951263', '1513742232', null);
INSERT INTO `camp` VALUES ('14', 'Ball  is  life', '17', '董硕同', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/10/59e1839a81d25.jpeg', '0', '', '', '', '广东省', '深圳市', '南山区', '13172659677', '', '0', '/uploads/images/banner/2017/10/59e183b19362c.jpeg', '', '0', '0', '练就对了', '0.00', '0', '1', '0.10', '1', '0.00', '1507951319', '1507966910', null);
INSERT INTO `camp` VALUES ('15', '钟声训练营', '19', '钟声', '0', '0', '0', '45', '0', '5', '0', '0', '0', '6', '0', '0', '33', '/uploads/images/banner/2017/11/5a1457b0a10dc.jpeg', '5', '', '系统增加balance=1050,时间2017年10月18日17:26:30,历史会员+1,余额30450+1050,时间2017年10月27日10:53:10;系统增加历史会员+1,余额32550+1050;系统增加历史会员=52+1,余额=45150+1050,时间2017年11月3日15:08:30', '深圳南山区阳光文体中心一楼', '广东省', '深圳市', '南山区', '15999557852', '', '1', '/uploads/images/banner/2017/11/5a14578d550f9.jpeg', '', '0', '0', '专注校园青少年专业篮球培训，培养青少年专业篮球培训，培训课目幼儿班，7至9岁低年级班，9至12岁高年级班，初中班，校园音乐篮球操班，中考班，企业班等专业篮球教学培训指导。', '41900.00', '0', '1', '0.20', '1', '0.00', '1508037092', '1511307623', null);
INSERT INTO `camp` VALUES ('16', '热风学校', '11', '陈永仁', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/10/59e2d345277ff.JPG', '0', '', '', '深圳湾', '广东省', '深圳市', '南山区', '', '', '1', '/uploads/images/banner/2017/10/59e2d35c3b1d1.JPG', '大热集团', '0', '0', '热风籃球社團', '0.00', '0', '1', '0.10', '1', '0.00', '1508037396', '1508041161', null);
INSERT INTO `camp` VALUES ('17', 'FIT', '16', '林泽铭', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '/static/frontend/images/uploadDefault.jpg', '0', null, '', '', '广东省', '深圳市', '南山区', '13717147667', '', '2', '/uploads/images/banner/2017/12/5a38f8c29bdac.jpeg', '大热篮球', '0', '0', 'do it', '0.00', '0', '1', '0.10', '1', '0.00', '1509449155', '1513683173', null);
INSERT INTO `camp` VALUES ('18', '劉嘉興', '5', '劉嘉興', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/11/5a069d9a6be7c.jpg', '0', null, null, '', '广东省', '深圳市', '南山区', '', '', '1', '/uploads/images/banner/2017/11/5a069dc32f067.jpg', '', '0', '0', '', '0.00', '0', '1', '0.10', '0', '0.00', '1510382967', '1510383060', null);
INSERT INTO `camp` VALUES ('19', '17体适能', '12', '吴光蔚', '0', '0', '0', '0', '0', '4', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/12/5a30c7af9672b.jpeg', '0', null, null, '深圳湾一号', '广东省', '深圳市', '南山区', '13684925727', '', '1', '/uploads/images/banner/2017/12/5a30c7bca3d9d.jpeg', '深圳市壹造文化传播有限公司', '0', '0', '敏捷，力量，速度，反应，柔韧', '2.00', '0', '1', '0.10', '1', '0.00', '1513146153', '1513146748', null);
INSERT INTO `camp` VALUES ('29', '深圳市南山区桃源街道篮球协会', '228', '杨超林', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/12/5a337f0ddd3fe.jpg', '0', null, null, '深圳市南山区学苑大道西段桃源街道文体站三楼', '广东省', '深圳市', '南山区', '18688943424', '', '1', '/uploads/images/banner/2017/12/5a339440e600e.png', '深圳市南山区桃源街道篮球协会', '0', '0', '桃源街道篮球协会以普及和篮球运动为使命，主要和政府部门合作，在全深圳范围开展公益篮球培训，把专业的少儿篮球训练带入各个社区，以篮球运动为媒介，让孩子们养成体育锻炼习惯，增强身体素质，培养意志品质，培育健全人格。', '0.00', '0', '1', '0.10', '1', '0.00', '1513324275', '1513329730', null);
INSERT INTO `camp` VALUES ('30', '大热篮球测试', '229', '张文清', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/12/5a348e0c6631c.jpg', '0', null, null, '', '广东省', '深圳市', '南山区', '13632930429', '', '0', '/uploads/images/banner/2017/12/5a348e17046ff.jpg', '', '0', '0', '经验丰富', '0.00', '0', '1', '0.10', '1', '0.00', '1513393651', '1513394279', null);
INSERT INTO `camp` VALUES ('31', 'woo篮球兴趣训练营', '8', '吴丽文', '0', '0', '0', '10', '0', '1', '0', '0', '0', '2', '0', '0', '12', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', '1', null, null, '', '广东省', '深圳市', '南山区', '18507717466', '', '0', '/uploads/images/banner/2017/12/5a39dcb48112b.jpeg', '', '0', '0', '专注培养幼儿篮球兴趣，发扬体育精神！', '3.00', '0', '1', '0.10', '1', '0.00', '1513741459', '1513741612', null);
INSERT INTO `camp` VALUES ('32', '燕子Happy篮球训练营', '9', '高艳', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '/uploads/images/banner/2017/12/5a3a304600acf.jpeg', '0', null, null, '广东省深圳市南山区桂庙路西阳光文体中心一层B111大热篮球', '广东省', '深圳市', '其它区', '13662270560', '', '1', '/uploads/images/banner/2017/12/5a3a3069a1de5.jpeg', '', '0', '0', '专注于幼儿和青少年篮球兴趣的培养，锻炼身体的同时，提高孩子四肢协调性和篮球基础知识的培养，根据不同年龄段的孩子制定不同的课程，快乐篮球，让孩子爱上篮球，爱上运动。', '0.00', '0', '1', '0.10', '1', '0.00', '1513744809', '1513763340', null);
