/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-11 12:14:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `schedule_gift_student`
-- ----------------------------
DROP TABLE IF EXISTS `schedule_gift_student`;
CREATE TABLE `schedule_gift_student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `member` varchar(60) NOT NULL COMMENT '会员id',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `student` varchar(60) NOT NULL COMMENT '学生',
  `student_id` int(11) NOT NULL COMMENT '学生id',
  `camp` varchar(60) NOT NULL COMMENT '训练营',
  `camp_id` int(11) NOT NULL COMMENT '训练营id',
  `lesson_id` int(11) NOT NULL COMMENT '课程id',
  `lesson` varchar(11) NOT NULL COMMENT '课程',
  `grade_id` int(11) NOT NULL COMMENT '班级id',
  `grade` varchar(60) NOT NULL COMMENT '班级',
  `gift_schedule` int(11) NOT NULL COMMENT '被赠送数量',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `system_remarks` text NOT NULL COMMENT '系统备注',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态1:成功|0:未操作',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of schedule_gift_student
-- ----------------------------
INSERT INTO `schedule_gift_student` VALUES ('66', 'MirandaXian', '14', '杨灿', '133', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '5', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('67', 'MirandaXian', '14', '吴奇朗', '127', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '5', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('68', 'MirandaXian', '14', '刘进哲', '128', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('69', 'MirandaXian', '14', '吴宇昊', '150', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '2', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('70', 'MirandaXian', '14', '钟铭楷', '138', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '2', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('71', 'MirandaXian', '14', '林嘉豪', '135', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '1', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('72', 'AK', '18', '陈米洛', '202', 'AKcross训练营', '13', '39', '南外文华快艇队', '0', '', '2', '耶耶', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('73', 'AK', '18', '周润锋', '201', 'AKcross训练营', '13', '39', '南外文华快艇队', '0', '', '3', '耶', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('74', 'MirandaXian', '14', '蒋成栋', '192', '大热篮球俱乐部', '9', '13', '大热常规班', '0', '', '1', '续费赠送1课时', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('75', 'Hot Basketball 1', '3', '郭浩麟', '199', '大热篮球俱乐部', '9', '13', '大热常规班', '0', '', '3', '老学员续费赠送3课时', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('76', 'Hot Basketball 1', '3', '王国宇', '193', '大热篮球俱乐部', '9', '13', '大热常规班', '0', '', '5', '特殊赠送八五折', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('77', 'MirandaXian', '14', '强亦宸', '206', '大热篮球俱乐部', '9', '13', '大热常规班', '0', '', '1', '续费赠送1课时', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('78', 'Hot-basketball2', '2', '洪新铠', '189', '大热篮球俱乐部', '9', '13', '大热常规班', '0', '', '12', '补上12课时', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('79', 'MirandaXian', '14', '刘永锋', '152', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '0', '', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('80', 'MirandaXian', '14', '骆九宇', '165', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '0', '', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('81', 'MirandaXian', '14', '杨耀斌', '147', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '0', '', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('82', 'MirandaXian', '14', '饶鹏轩', '129', '大热篮球俱乐部', '9', '13', '大热常规班', '0', '', '1', '续费赠送1课时', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('83', 'Hot-basketball2', '2', '张旺鹏', '122', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('84', 'Hot-basketball2', '2', '李鸣轩', '117', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('85', 'Hot-basketball2', '2', '袁帅', '121', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('86', 'Hot-basketball2', '2', '蔡佳烨', '111', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('87', 'Hot-basketball2', '2', '郭懋增', '110', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('88', 'Hot-basketball2', '2', '黄子杰', '109', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('89', 'Hot-basketball2', '2', '王瑞翔', '108', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('90', 'Hot-basketball2', '2', '曾子航', '107', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('91', 'Hot-basketball2', '2', '颜若宸', '105', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('92', 'Hot-basketball2', '2', '王浩丁', '104', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('93', 'Hot-basketball2', '2', '周子祺', '99', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('51', 'AK', '18', '吴浩睿', '255', 'AKcross训练营', '13', '43', '塘朗追梦队', '0', '', '2', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('52', 'AK', '18', '杜宇轩', '228', 'AKcross训练营', '13', '43', '塘朗追梦队', '0', '', '2', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('53', 'Hot Basketball 1', '3', '毕宸君', '139', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '1', '老学员续费赠送一课时', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('54', 'MirandaXian', '14', '柯艾锐', '173', '大热篮球俱乐部', '9', '13', '大热常规班', '0', '', '2', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('55', 'woo123', '8', 'Bingo', '225', 'woo篮球兴趣训练营', '31', '51', '下午茶篮球课（有赠送课', '39', '下午茶班', '1', '给雅露测试', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('56', 'woo123', '8', 'GT ', '226', 'woo篮球兴趣训练营', '31', '51', '下午茶篮球课（有赠送课', '39', '下午茶班', '1', '给雅露测试', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('57', 'woo123', '8', '刘嘉', '6', 'woo篮球兴趣训练营', '31', '51', '下午茶篮球课（有赠送课', '39', '下午茶班', '1', '给雅露测试', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('58', 'woo123', '8', '高燕', '223', 'woo篮球兴趣训练营', '31', '51', '下午茶篮球课（有赠送课', '39', '下午茶班', '1', '给雅露测试', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('59', 'woo123', '8', '小霖', '4', 'woo篮球兴趣训练营', '31', '51', '下午茶篮球课（有赠送课', '39', '下午茶班', '1', '给雅露测试', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('60', 'woo123', '8', '哔哔哔', '101', 'woo篮球兴趣训练营', '31', '51', '下午茶篮球课（有赠送课', '39', '下午茶班', '1', '给雅露测试', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('61', 'MirandaXian', '14', '陈智斌', '166', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '17', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('62', 'MirandaXian', '14', '谢睿轩', '137', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '15', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('63', 'MirandaXian', '14', '张哲栋', '141', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '14', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('64', 'MirandaXian', '14', '袁梓钦', '134', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '10', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('65', 'MirandaXian', '14', '吴贻然', '169', '大热篮球俱乐部', '9', '13', '大热常规班', '33', '周五北头低年级班', '7', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('94', 'Hot-basketball2', '2', '苏祖威', '98', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('95', 'Hot-basketball2', '2', '陈予喆', '96', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('96', 'Hot-basketball2', '2', '王孝煊', '115', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('97', 'Hot-basketball2', '2', '邵冠霖', '118', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('98', 'Hot-basketball2', '2', '杨涵', '119', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('99', 'Hot-basketball2', '2', '黄俊豪', '116', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
INSERT INTO `schedule_gift_student` VALUES ('100', 'Hot-basketball2', '2', '关楠萧', '120', '大热篮球俱乐部', '9', '15', '龙岗民警子女篮球训练课', '32', '龙岗篮球训练营', '3', '', '', '1', '1514540968', '1514540968', null);
