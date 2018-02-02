/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-02 15:48:31
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
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

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
INSERT INTO `admin_menu` VALUES ('34', '3', 'admin', '训练营详情', 'fa fa-cog', '0', 'admin/camp/show', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('35', '3', 'admin', '修改训练营信息', 'fa fa-cog', '0', 'admin/camp/edit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('36', '3', 'admin', '审核训练营申请', 'fa fa-cog', '0', 'admin/camp/audit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('37', '3', 'admin', '软删除', 'fa fa-cog', '0', 'admin/camp/sdel', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('38', '3', 'admin', '设置当前查看训练营', 'fa fa-cog', '0', 'admin/camp/setcur', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('39', '3', 'admin', '清理缓存', 'fa fa-cog', '0', 'admin/camp/clearcur', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('40', '3', 'admin', '修改训练营状态', 'fa fa-cog', '0', 'admin/camp/editstatus', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('41', '3', 'admin', '教练详情', 'fa fa-cog', '0', 'admin/coach/show', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('42', '3', 'admin', '教练审核', 'fa fa-cog', '0', 'admin/coach/edit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('43', '3', 'admin', '软删除教练', 'fa fa-cog', '0', 'admin/coach/sdel', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('44', '3', 'admin', '修改教练信息', 'fa fa-cog', '0', 'admin/camp/edit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('45', '3', 'admin', '场地详情', 'fa fa-cog', '0', 'admin/court/detail', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('46', '3', 'admin', '场地审核', 'fa fa-cog', '0', 'admin/court/audit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('47', '3', 'admin', ' 管理 训练营/教练发布 训练项目', 'fa fa-cog', '0', 'admin/exercise/lists', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('48', '3', 'admin', '创建项目视图', 'fa fa-cog', '0', 'admin/exercise/create', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('49', '3', 'admin', '项目详情视图', 'fa fa-cog', '0', 'admin/exercise/show', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('50', '3', 'admin', '储存项目数据', 'fa fa-cog', '0', 'admin/exercise/store', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('51', '3', 'admin', '更新项目', 'fa fa-cog', '0', 'admin/exercise/update', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('52', '3', 'admin', '(软)删除项目数据', 'fa fa-cog', '0', 'admin/exercise/del', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('53', '3', 'admin', '审核训练项目(不单独)', 'fa fa-cog', '0', 'admin/exercise/audit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('54', '3', 'admin', '教案训练项目列表', 'fa fa-cog', '0', 'admin/plan/exerciseList', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('55', '3', 'admin', '创建教案', 'fa fa-cog', '0', 'admin/plan/create', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('56', '3', 'admin', '教案发布列表', 'fa fa-cog', '0', 'admin/plan/manage', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('57', '3', 'admin', '训练项目html', 'fa fa-cog', '0', 'admin/plan/exercise_setected_html', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('58', '3', 'admin', '处理组合所选项目', 'fa fa-cog', '0', 'admin/plan/headleselected', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('59', '3', 'admin', 'ajax训练项目', 'fa fa-cog', '0', 'admin/plan/ajaxselected', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('60', '3', 'admin', '存储教案', 'fa fa-cog', '0', 'admin/plan/store', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('61', '3', 'admin', '教案详情', 'fa fa-cog', '0', 'admin/plan/show', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('62', '3', 'admin', '教案更新', 'fa fa-cog', '0', 'admin/plan/update', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('63', '3', 'admin', '教案审核', 'fa fa-cog', '0', 'admin/plan/audit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('64', '4', 'admin', '订单详情', 'fa fa-cog', '0', 'admin/finance/bill', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('65', '4', 'admin', '收入记录列表', 'fa fa-cog', '0', 'admin/finance/salaryinlist', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('66', '4', 'admin', '收入详情记录', 'fa fa-cog', '0', 'admin/finance/salaryin', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('67', '4', 'admin', '提现记录列表', 'fa fa-cog', '0', 'admin/finance/salaryoutlist', '_self', '1', '99', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('68', '4', 'admin', '提现详情', 'fa fa-cog', '0', 'admin/finance/salaryout', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('69', '4', 'admin', '订单对账', 'fa fa-cog', '0', 'admin/finance/reconciliation', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('70', '4', 'admin', '缴费统计', 'fa fa-cog', '0', 'admin/finance/tuitionstatis', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('71', '4', 'admin', '收益统计', 'fa fa-cog', '0', 'admin/finance/earings', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('72', '3', 'admin', '班级详情', 'fa fa-cog', '0', 'admin/grade/show', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('73', '3', 'admin', '课程详情', 'fa fa-cog', '0', 'admin/lesson/detail', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('74', '3', 'admin', '课程审核', 'fa fa-cog', '0', 'admin/lesson/audit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('75', '3', 'admin', '课程软删除', 'fa fa-cog', '0', 'admin/lesson/del', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('76', '3', 'admin', 'acalendar', 'fa fa-cog', '0', 'admin/schedule/calendar', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('77', '3', 'admin', '课时详情', 'fa fa-cog', '0', 'admin/schedule/detail', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('78', '3', 'admin', '学生详情', 'fa fa-cog', '0', 'admin/student/show', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('79', '2', 'admin', 'menu', 'fa fa-cog', '0', 'admin/wechat/menu', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('80', '24', 'admin', '修改管理员', 'fa fa-cog', '0', 'admin/user/update', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('81', '3', 'admin', '购买课程', 'fa fa-cog', '0', 'admin/lesson/buyLesson', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('82', '5', 'admin', '创建会员', 'fa fa-cog', '0', 'admin/member/createMember', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('83', '3', 'admin', '班级类型管理', 'fa fa-cog', '0', 'admin/GradeCategory/gradeCategoryList', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('84', '3', 'admin', '班级类型详情', 'fa fa-cog', '0', 'admin/GradeCategory/gradeCategory', '_self', '0', '0', '0', '0', '0');
INSERT INTO `admin_menu` VALUES ('85', '3', 'admin', '添加/修改班级类型', 'fa fa-cog', '0', 'admin/GradeCategory/updateGradeCategory', '_self', '0', '0', '0', '0', '0');
INSERT INTO `admin_menu` VALUES ('86', '3', 'admin', '更新父类', 'fa fa-cog', '0', 'admin/GradeCategory/updateGradeCategoryP', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('87', '3', 'admin', '删除课程类型', 'fa fa-cog', '0', 'admin/Gradecategory/del', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('88', '3', 'admin', '课程编辑', 'fa fa-cog', '0', 'admin/lesson/edit', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('89', '3', 'admin', '编辑学生', 'fa fa-cog', '0', 'admin/student/updateStudent', '_self', '0', '6', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('90', '3', 'admin', '教练审核', 'fa fa-cog', '0', 'admin/coach/audit', '_self', '0', '9', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('91', '4', 'admin', '提现列表', 'fa fa-cog', '0', 'admin/finance/salaryOutList', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('92', '4', 'admin', '提现详情', 'fa fa-cog', '0', 'admin/finance/salaryOutInfo', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('93', '4', 'admin', '手动新增提现', 'fa fa-cog', '0', 'admin/finance/createSalaryOut', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('94', '4', 'admin', '操作提现申请', 'fa fa-cog', '0', 'admin/finance/updateSalaryOut', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('95', '0', 'admin', '卡券管理', 'fa fa-cog', '0', '', '_self', '1', '4', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('96', '95', 'admin', '卡券列表', 'fa fa-cog', '0', 'admin/Coupon/itemCouponList', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('97', '95', 'admin', '添加卡券', 'fa fa-cog', '0', 'admin/Coupon/createitemCoupon', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('98', '1', 'admin', '首页api接口', 'fa fa-cog', '0', 'api/wx/getgroups', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('99', '5', 'admin', '会员详情', 'fa fa-cog', '0', 'admin/member/memberInfo', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('100', '5', 'admin', '添加推荐人', 'fa fa-cog', '0', 'admin/member/addReferer', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('101', '0', 'admin', '文章管理', 'fa fa-cog', '0', 'admin/Article/articleList', '_self', '1', '90', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('102', '101', 'admin', '添加文章', 'fa fa-cog', '0', 'admin/Article/createArticle', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('103', '101', 'admin', '文章详情', 'fa fa-cog', '0', 'admin/Article/articleInfo', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('104', '101', 'admin', '编辑文章', 'fa fa-cog', '0', 'admin/Article/updateArticle', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('105', '101', 'admin', '文章列表', 'fa fa-cog', '0', 'admin/Article/articleList', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('106', '0', 'admin', '平台礼包', 'fa fa-cog', '0', '', '_self', '1', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('107', '106', 'admin', '礼包列表', 'fa fa-cog', '0', 'admin/Bonus/bonusList', '_self', '1', '89', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('108', '106', 'admin', '添加礼包', 'fa fa-cog', '0', 'admin/bonus/createBonus', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('109', '106', 'admin', '礼包详情', 'fa fa-cog', '0', 'admin/bonus/bonusInfo', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('110', '106', 'admin', '编辑礼包', 'fa fa-cog', '0', 'admin/bonus/updateBonus', '_self', '0', '0', '1', '0', '0');
INSERT INTO `admin_menu` VALUES ('111', '95', 'admin', '编辑卡券', 'fa fa-cog', '0', 'admin/Coupon/updateitemCoupon', '_self', '0', '0', '1', '0', '0');
