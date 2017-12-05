/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-05 17:55:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `module` varchar(16) NOT NULL DEFAULT 'admin' COMMENT '模块名称',
  `title` varchar(32) NOT NULL,
  `icon` varchar(64) NOT NULL DEFAULT 'fa fa-cog',
  `url_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '链接类型（1：外链|0:模块）',
  `url_value` varchar(255) NOT NULL DEFAULT '' COMMENT '链接,比如 admin/lesson/create_lesson',
  `url_target` varchar(16) NOT NULL DEFAULT '_self' COMMENT '链接打开方式：_blank|_self',
  `online_hide` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1:显示|0:隐藏',
  `sort` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('27', '23', 'admin', '平台设置', 'fa fa-cog', '0', 'admin/system/index', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('2', '0', 'admin', '微信管理', 'fa fa-cog', '0', '', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('3', '0', 'admin', '训练营', 'fa fa-group', '0', '', '_self', '1', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('4', '0', 'admin', '财务管理', 'fa fa-flag', '0', '', '_self', '1', '2', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('5', '0', 'admin', '会员管理', 'fa fa-user', '0', '', '_self', '1', '3', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('6', '2', 'admin', '菜单管理', 'fa fa-cog', '0', 'admin/weixin/menu', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('7', '3', 'admin', '训练营管理', 'fa fa-cog', '0', 'admin/camp/index', '_self', '1', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('8', '3', 'admin', '教练管理', 'fa fa-cog', '0', 'admin/coach/index', '_self', '1', '2', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('9', '3', 'admin', '学员管理', 'fa fa-cog', '0', 'admin/student/index', '_self', '1', '3', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('10', '3', 'admin', '班级管理', 'fa fa-cog', '0', 'admin/grade/index', '_self', '1', '4', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('15', '4', 'admin', '支付订单', 'fa fa-cog', '0', 'admin/finance/billlist', '_self', '1', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('11', '3', 'admin', '课程管理', 'fa fa-cog', '0', 'admin/lesson/index', '_self', '1', '5', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('12', '3', 'admin', '课时管理', 'fa fa-cog', '0', 'admin/schedule/index', '_self', '1', '6', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('13', '3', 'admin', '教案管理', 'fa fa-cog', '0', 'admin/plan/index', '_self', '1', '7', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('14', '3', 'admin', '训练项目管理', 'fa fa-cog', '0', 'admin/exercise/index', '_self', '1', '8', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('16', '4', 'admin', '工资收入', 'fa fa-cog', '0', 'admin/finance/salaryinlist', '_self', '1', '2', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('17', '4', 'admin', '提现管理', 'fa fa-cog', '0', 'admin/finance/salaryinlist', '_self', '1', '3', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('18', '4', 'admin', '订单对账', 'fa fa-cog', '0', 'admin/finance/reconciliation', '_self', '1', '4', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('19', '4', 'admin', '缴费统计', 'fa fa-cog', '0', 'admin/finance/tuitionstatis', '_self', '1', '5', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('20', '4', 'admin', '收益统计', 'fa fa-cog', '0', 'admin/finance/earings', '_self', '1', '6', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('21', '5', 'admin', '会员列表', 'fa fa-cog', '0', 'admin/member/memberlist', '_self', '1', '1', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('22', '3', 'admin', '场地管理', 'fa fa-cog', '0', 'admin/court/index', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('23', '0', 'admin', '系统设置', 'fa fa-cog', '0', 'admin/system/index', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('24', '0', 'admin', '管理员', 'fa fa-cog', '0', '', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('25', '24', 'admin', '管理员列表', 'fa fa-cog', '0', 'admin/user/index', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('1', '0', 'admin', '平台首页', 'fa fa-cog', '0', 'admin/index/index', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('28', '24', 'admin', '添加管理员', 'fa fa-cog', '0', 'admin/user/create', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('29', '24', 'admin', '添加管理员接口', 'fa fa-cog', '0', 'admin/user/store', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('30', '24', 'admin', '查看管理员详情', 'fa fa-cog', '0', 'admin/user/edit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('31', '23', 'admin', '平台设置接口', 'fa fa-cog', '0', 'admin/system/editinfo', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('32', '23', 'admin', '平台banner接口', 'fa fa-cog', '0', 'admin/system/editbanner', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('33', '23', 'admin', '会员积分设置接口', 'fa fa-cog', '0', 'admin/system/editscore', '_self', '0', '0', '1', '0', '0');
