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

 Date: 11/06/2018 14:42:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for __court_media
-- ----------------------------
DROP TABLE IF EXISTS `__court_media`;
CREATE TABLE `__court_media`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `court_id` int(10) NOT NULL,
  `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:图片|1:视频',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '场地图片' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `truename` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '邮箱',
  `avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '头像',
  `telephone` bigint(20) NOT NULL COMMENT '手机号',
  `group_id` int(111) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:1正常|0禁用',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `logintime` int(11) NOT NULL DEFAULT 0 COMMENT '登录次数',
  `lastlogin_at` int(11) NOT NULL COMMENT '最后登录时间',
  `lastlogin_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '最后登录ip',
  `lastlogin_ua` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '最后登录ua',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_group
-- ----------------------------
DROP TABLE IF EXISTS `admin_group`;
CREATE TABLE `admin_group`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `menu_auth` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `module` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'admin' COMMENT '模块名称',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'fa fa-cog',
  `url_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '链接类型（1：外链|0:模块）',
  `url_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接,比如 admin/lesson/create_lesson',
  `url_target` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '_self' COMMENT '链接打开方式：_blank|_self',
  `online_hide` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1:显示|0:隐藏',
  `sort` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 172 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for apply
-- ----------------------------
DROP TABLE IF EXISTS `apply`;
CREATE TABLE `apply`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '申请人|被邀请人',
  `member_id` int(10) NOT NULL COMMENT '申请人id|被邀请人id',
  `member_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '申请人|被邀请人 会员头像',
  `organization_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:训练营|2:team|3:school|4:match|5match_org',
  `organization` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `organization_id` int(10) NOT NULL,
  `organization_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'logo图',
  `type` tinyint(4) NOT NULL COMMENT '申请类型|被邀请类型:  1:?|2:教练|3:管理员|4:?|5:队长|6:主裁判员|7:副裁判|8:记分员',
  `inviter` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '邀请人',
  `inviter_id` int(10) NOT NULL COMMENT '邀请人member_id',
  `inviter_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '邀请人头像',
  `apply_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:申请|2:邀请',
  `reply` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '回复内容',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:申请中或者邀请中|2:已同意|3:已拒绝',
  `isread` tinyint(4) NOT NULL DEFAULT 0 COMMENT '申请|邀请阅读状态:0未读|1已读',
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 74 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for apps_apply
-- ----------------------------
DROP TABLE IF EXISTS `apps_apply`;
CREATE TABLE `apps_apply`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户填写的其他html',
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL COMMENT '关联外键',
  `realname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `telephone` bigint(11) NOT NULL COMMENT '联系电话',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '类型1:活动',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户备注',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:使用手册|2:单独页面|3:新闻',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `abstract` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '摘要',
  `covers` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面图',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `author` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '佚名' COMMENT '作者',
  `member_id` int(11) NOT NULL,
  `member` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布者',
  `organization_id` int(11) NOT NULL DEFAULT 0 COMMENT '0:系统文章|其他:组织文章',
  `organization` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '篮球管家',
  `organization_type` tinyint(11) NOT NULL DEFAULT 1 COMMENT '1:系统文章|2:训练营文章|3:球队文章',
  `hot` tinyint(2) NOT NULL DEFAULT 0 COMMENT '热门排序',
  `hit` int(11) NOT NULL DEFAULT 0 COMMENT '点击率',
  `likes` int(11) NOT NULL COMMENT '点赞数',
  `comments` int(11) NOT NULL DEFAULT 0 COMMENT '评论数',
  `collects` int(11) NOT NULL DEFAULT 0 COMMENT '当前收藏数',
  `status` tinyint(2) NOT NULL DEFAULT -1 COMMENT '1:上架|-1:下架',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for article_collect
-- ----------------------------
DROP TABLE IF EXISTS `article_collect`;
CREATE TABLE `article_collect`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `article` varchar(240) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:已收藏|-1:取消收藏',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '收藏文章' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for article_comment
-- ----------------------------
DROP TABLE IF EXISTS `article_comment`;
CREATE TABLE `article_comment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NULL DEFAULT NULL,
  `article` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '头像',
  `comment` varchar(240) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '评论内容,最大80个字',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '审核1:正常|-1:拒绝',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for article_likes
-- ----------------------------
DROP TABLE IF EXISTS `article_likes`;
CREATE TABLE `article_likes`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `article` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '是否点赞1:点赞|-1:取消点赞',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章点赞表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bankcard
-- ----------------------------
DROP TABLE IF EXISTS `bankcard`;
CREATE TABLE `bankcard`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号类型:支付宝|银行卡',
  `bank_card` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号',
  `bank_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:银行卡|2:支付宝',
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '预留号码',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `realname` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '卡的真实姓名,不是会员的真实姓名',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NULL DEFAULT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '个人金融账户,支付宝,银行卡' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `banner` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'banner的名字',
  `organization_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0:系统|1:训练营|2:球队|3:校园',
  `organization` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '图片地址',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '跳转链接',
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1:正常|-1下架',
  `steward_type` int(10) NOT NULL DEFAULT 1 COMMENT '管家类型:1培训管家|2球队管家',
  `ord` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bill
-- ----------------------------
DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bill_order` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `goods_id` int(10) NOT NULL COMMENT '1:对应lesson.id;|2:对应goods.id',
  `goods` varchar(210) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `total` tinyint(4) NOT NULL DEFAULT 1 COMMENT '购买数量',
  `price` decimal(8, 0) NOT NULL COMMENT '每节课的单价',
  `organization_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '组织类型  1:训练营|2:学校|0:平台',
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `goods_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '商品类型 1:课程|2:活动|0:平台充值',
  `goods_des` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品描述',
  `student_id` int(10) NOT NULL,
  `student` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `balance_pay` decimal(8, 0) NOT NULL DEFAULT 0 COMMENT '支付人民币',
  `score_pay` int(10) NOT NULL DEFAULT 0 COMMENT '支付积分',
  `remarks` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pay_type` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付类型 wxpay:微信支付|alipay:支付宝',
  `callback_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_pay` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:未支付|1:已支付.用来做微信支付的回调修改',
  `pay_time` int(10) NOT NULL COMMENT '支付时间',
  `expire` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `bill_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:正常订单|1:系统生成的订单',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:未支付|1:已支付|-1:申请退款|-2:已退款',
  `refundamount` int(11) NOT NULL DEFAULT 0 COMMENT '申请退款金额',
  `redund_fee` decimal(6, 2) NOT NULL DEFAULT 0.00 COMMENT '退款手续费',
  `refund` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '实际退款金额',
  `fee` decimal(8, 2) NOT NULL COMMENT '手续费',
  `agent_id` int(10) NOT NULL COMMENT '代付人的member_id',
  `agent` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '代付人',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1110 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bonus
-- ----------------------------
DROP TABLE IF EXISTS `bonus`;
CREATE TABLE `bonus`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bonus` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '活动名称',
  `bonus_type` tinyint(4) NOT NULL COMMENT '1:每个会员都送|2:新注册则送',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动标语',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动描述',
  `published` int(11) NOT NULL DEFAULT 0 COMMENT '已发行',
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `admin` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `admin_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bonus_member
-- ----------------------------
DROP TABLE IF EXISTS `bonus_member`;
CREATE TABLE `bonus_member`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bonus_id` int(11) NOT NULL COMMENT '活动id',
  `bonus` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '活动名称',
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '登陆|注册就送的记录' ROW_FORMAT = Compact;

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
  `balance_true` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '可提现营业额(废弃)',
  `schedule_rebate` decimal(6, 4) NOT NULL DEFAULT 0.1000 COMMENT '课时收入平台抽取比例(空值按setting表sysrebate)',
  `refund_rebate` decimal(6, 4) NOT NULL DEFAULT 0.1000 COMMENT '平台收取的退款手续费',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `delete_time` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 44 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for camp_bankcard
-- ----------------------------
DROP TABLE IF EXISTS `camp_bankcard`;
CREATE TABLE `camp_bankcard`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bank` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '开户行名称',
  `bank_branch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '开户行分支',
  `account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '账户名',
  `bank_card` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '账号',
  `telephone` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '预留电话',
  `status` tinyint(4) NOT NULL COMMENT '1:正常|-1:无效账户',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `system_reamrks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '训练营银行账户表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for camp_cancell
-- ----------------------------
DROP TABLE IF EXISTS `camp_cancell`;
CREATE TABLE `camp_cancell`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL DEFAULT 0 COMMENT '训练营id',
  `camp` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练营',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '营主会员id',
  `member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '营主会员',
  `reason` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '注销训练营理由',
  `system_reply` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '控制台回复',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '受理状态:0默认|1已受理|2已拒绝',
  `cancel_time` int(11) NOT NULL COMMENT '注销训练营id时间',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营注销申请' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for camp_comment
-- ----------------------------
DROP TABLE IF EXISTS `camp_comment`;
CREATE TABLE `camp_comment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for camp_finance
-- ----------------------------
DROP TABLE IF EXISTS `camp_finance`;
CREATE TABLE `camp_finance`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练营',
  `rebate_type` tinyint(4) NOT NULL DEFAULT 1,
  `shcedule_rebate` decimal(4, 2) NOT NULL DEFAULT 0.10,
  `money` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '具体金额',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '-4:提现|-3:订单退费|-2:赠课支出|-1:教练工资支出|1:课程订单收入|2:活动订单收入|3:课时收入|4:提现退回',
  `f_id` int(11) NOT NULL COMMENT '外键',
  `s_balance` decimal(14, 2) NOT NULL DEFAULT 0.00 COMMENT '初始余额',
  `e_balance` decimal(14, 2) NOT NULL DEFAULT 0.00 COMMENT '结束余额',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统说明',
  `date_str` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对应数据发生日期',
  `datetime` int(11) NOT NULL COMMENT '对应数据发生日期时间戳',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6590 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营财务收入支出记录(总表)' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for camp_leaveapply
-- ----------------------------
DROP TABLE IF EXISTS `camp_leaveapply`;
CREATE TABLE `camp_leaveapply`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员',
  `camp_id` int(11) NOT NULL DEFAULT 0 COMMENT '训练营id',
  `camp` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '训练营',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '学生id',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '学生名',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '申请状态:1已通过|0未操作',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员申请离营' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for camp_member
-- ----------------------------
DROP TABLE IF EXISTS `camp_member`;
CREATE TABLE `camp_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:学生|2:教练|3:管理员|4:创建者|-1:一份子',
  `level` int(11) NOT NULL DEFAULT 0 COMMENT '角色等级:1兼职教练|2正职教练',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:待审核|1:正常|2:退出|-1:被辞退|3:\'已毕业\'|-2:被拒绝',
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 587 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营身份权限表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for camp_power
-- ----------------------------
DROP TABLE IF EXISTS `camp_power`;
CREATE TABLE `camp_power`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL COMMENT '角色名称',
  `coach` tinyint(4) NOT NULL DEFAULT 0 COMMENT '有教练权限就是1',
  `admin` tinyint(4) NOT NULL DEFAULT 0 COMMENT '管理员',
  `owner` tinyint(4) NOT NULL DEFAULT 0 COMMENT '拥有者',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员角色表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for camp_withdraw
-- ----------------------------
DROP TABLE IF EXISTS `camp_withdraw`;
CREATE TABLE `camp_withdraw`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `withdraw` decimal(12, 2) NOT NULL COMMENT '提现金额',
  `f_id` int(11) NOT NULL COMMENT '关联的output表id',
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `buffer` decimal(12, 2) NOT NULL COMMENT '冻结资金',
  `camp_withdraw_fee` decimal(8, 2) NOT NULL COMMENT '平台手续费',
  `s_balance` decimal(12, 2) NOT NULL COMMENT '训练营余额(开始)',
  `e_balance` decimal(12, 2) NOT NULL COMMENT '训练营余额(结束)',
  `bank_id` int(11) NOT NULL COMMENT '关联的收款账号id',
  `rebate_type` tinyint(4) NOT NULL COMMENT '训练营结算类型',
  `camp_type` tinyint(4) NOT NULL COMMENT '训练营类型',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '-2:个人取消(解冻)|-1:拒绝(解冻)|1:申请中(冻结)|2:已同意(并解冻)|3:已打款',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营提现详情表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cert
-- ----------------------------
DROP TABLE IF EXISTS `cert`;
CREATE TABLE `cert`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL COMMENT '所属训练营id',
  `match_org_id` int(10) NOT NULL DEFAULT 0 COMMENT '所属联赛组织id',
  `member_id` int(10) NOT NULL COMMENT '用户id',
  `cert_no` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '证件号码',
  `cert_type` tinyint(4) NOT NULL COMMENT '1:身份证;2:学生证;3:教练资质证书;4:营业执照|5:裁判员证书',
  `photo_positive` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '证件照正面',
  `photo_back` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '证件照背面',
  `portrait` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '肖像',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:未审核|1:正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 158 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '证件表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for charge
-- ----------------------------
DROP TABLE IF EXISTS `charge`;
CREATE TABLE `charge`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `charge_order` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '充值单号',
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `charge` int(11) NOT NULL COMMENT '充值金额',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:余额充值|2:热币充值|3:训练营余额充值',
  `status` tinyint(4) NOT NULL COMMENT '充值状态-1:充值失败|1:正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '充值记录表' ROW_FORMAT = Compact;

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
) ENGINE = MyISAM AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for coach_comment
-- ----------------------------
DROP TABLE IF EXISTS `coach_comment`;
CREATE TABLE `coach_comment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `coach_id` int(10) NOT NULL,
  `coach` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `comment` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论内容',
  `attitude` decimal(4, 1) NOT NULL COMMENT '态度得分,满分5分',
  `profession` decimal(4, 1) NOT NULL COMMENT '专业得分',
  `teaching_attitude` decimal(4, 1) NOT NULL COMMENT '教学态度得分',
  `teaching_quality` decimal(4, 1) NOT NULL COMMENT '教学质量得分',
  `appearance` decimal(4, 1) NOT NULL COMMENT '仪容仪表',
  `anonymous` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:匿名|1:实名',
  `delete_time` int(10) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for court
-- ----------------------------
DROP TABLE IF EXISTS `court`;
CREATE TABLE `court`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `court` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地名称',
  `camp_id` int(10) NOT NULL DEFAULT 0 COMMENT '0:系统',
  `camp` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '系统',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人',
  `member_id` int(11) NOT NULL COMMENT '创建人id',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '具体地址',
  `principal` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地负责人',
  `open_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '营业时间',
  `contract` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地联系电话',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sys_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `chip_rent` decimal(8, 2) NOT NULL COMMENT '散场',
  `full_rent` decimal(8, 2) NOT NULL COMMENT '全场租金',
  `half_rent` decimal(8, 2) NOT NULL COMMENT '半场',
  `outdoors` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1:室内|2:室外|3:都有',
  `cover` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面',
  `lng` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '113.930476' COMMENT '高德地图lnglatXY',
  `lat` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '22.533013' COMMENT 'lnglatXY',
  `status` int(10) NOT NULL DEFAULT -1 COMMENT '-1:不公开;|1:系统公开',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 65 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for court_camp
-- ----------------------------
DROP TABLE IF EXISTS `court_camp`;
CREATE TABLE `court_camp`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `court` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `court_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '(废弃)是否可用:1公开|-1:不公开',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 73 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for crontab_record
-- ----------------------------
DROP TABLE IF EXISTS `crontab_record`;
CREATE TABLE `crontab_record`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `crontab` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '定时任务名称',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|0:错误',
  `callback_str` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_str` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '当前时间戳',
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 352 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for daily_camp_finance
-- ----------------------------
DROP TABLE IF EXISTS `daily_camp_finance`;
CREATE TABLE `daily_camp_finance`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL,
  `camp` int(60) NOT NULL,
  `e_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '结束余额',
  `s_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '开始余额',
  `schedule_rebate` decimal(4, 2) NOT NULL,
  `rebate_type` tinyint(4) NOT NULL,
  `date_str` int(11) NOT NULL COMMENT '20180204',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 831 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for daily_member_finance
-- ----------------------------
DROP TABLE IF EXISTS `daily_member_finance`;
CREATE TABLE `daily_member_finance`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `member` int(60) NOT NULL,
  `e_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '结束余额',
  `s_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '开始余额',
  `date_str` int(11) NOT NULL COMMENT '20180204',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1589 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for event
-- ----------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动主题',
  `organization_id` int(10) NOT NULL COMMENT '组织id',
  `organization` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '组织名称:训练|校园',
  `organization_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:训练营|2:校园',
  `target_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:不限|2:营内|3:班内',
  `target_id` int(10) NOT NULL DEFAULT 0 COMMENT '具体对象id',
  `target` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '具体对象名称',
  `event_type` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动类型:团队建设balabla',
  `dom` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '套餐',
  `is_free` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:免费|2:收费',
  `price` decimal(8, 0) NOT NULL DEFAULT 0 COMMENT '活动单价',
  `score` int(10) NOT NULL,
  `finance` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动结算人',
  `finance_id` int(10) NOT NULL COMMENT '活动结算人的member_id',
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发布者和最后更新人',
  `member_id` int(10) NOT NULL COMMENT '发布者和最后更新者的member_id',
  `start` int(10) NOT NULL,
  `end` int(10) NOT NULL,
  `event_time` int(10) NOT NULL COMMENT '具体活动时间',
  `participator` int(10) NOT NULL COMMENT '报名数|参与者数量',
  `province` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `area` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动场地',
  `lat` decimal(20, 15) NOT NULL DEFAULT 0.000000000000000 COMMENT '经纬度',
  `lng` decimal(20, 15) NOT NULL DEFAULT 0.000000000000000 COMMENT '经纬度',
  `max` int(11) NOT NULL DEFAULT 99 COMMENT '最大参与数',
  `min` int(11) NOT NULL DEFAULT 2 COMMENT '最小参与数',
  `event_des` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动简介',
  `contact` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '/static/frontend/images/uploadDefault.jpg',
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_max` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:未满人|-1:已满人',
  `apps_des` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '表单背景内容',
  `apps_form` tinyint(4) NOT NULL DEFAULT -1 COMMENT '-1:不需要填表|1:需要填表',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|2:下架',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for event_member
-- ----------------------------
DROP TABLE IF EXISTS `event_member`;
CREATE TABLE `event_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '用户头像',
  `student_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `combo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '套餐',
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系电话',
  `linkman` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系人',
  `total` int(10) NOT NULL DEFAULT 0 COMMENT '报名人数',
  `is_pay` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:已缴费|2:未缴费',
  `is_sign` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否签到 0:未签到|1:已签到',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:已报名|2:已签到|3:以参与|4:中途退出',
  `remarks` varchar(240) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 131 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '活动-会员关系表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for exercise
-- ----------------------------
DROP TABLE IF EXISTS `exercise`;
CREATE TABLE `exercise`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '作者',
  `camp_id` int(10) NOT NULL DEFAULT 0 COMMENT '0则为平台',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '平台' COMMENT '默认平台',
  `exercise` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练项目',
  `exercise_time` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所需训练时间',
  `pid` int(10) NOT NULL DEFAULT 0,
  `exercise_setion` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '所有人' COMMENT '适合阶段',
  `exercise_detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `media` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '视频地址',
  `is_open` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:不开放;|1:开放',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:启用|0:待审核|>1 用户自己的',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 684 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for exp
-- ----------------------------
DROP TABLE IF EXISTS `exp`;
CREATE TABLE `exp`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT ' ',
  `lesson_id` int(11) NOT NULL,
  `lesson` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `camp_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `update_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '体验记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for feedback
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `member` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员名',
  `member_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员头像',
  `thumb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '缩略图',
  `contact` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系方式(手机号|邮箱|qq)',
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '留言内容',
  `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '问题类型(中文)',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for follow
-- ----------------------------
DROP TABLE IF EXISTS `follow`;
CREATE TABLE `follow`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT 2 COMMENT '关注实体:1会员|2训练营|3班级|4球队|5联赛',
  `follow_id` int(11) NOT NULL DEFAULT 0 COMMENT '被关注实体id',
  `follow_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '被关注实体name',
  `follow_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '被关注实体头像',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会员名',
  `member_avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员头像',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:关注|-1取消关注',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 619 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员关注表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for grade
-- ----------------------------
DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `gradecate` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `gradecate_id` int(10) NOT NULL,
  `gradecate_setion` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `gradecate_setion_id` int(10) NOT NULL,
  `grade` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级名称',
  `camp_id` int(10) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属训练营',
  `leader` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '领队',
  `leader_id` int(10) NOT NULL COMMENT '对应member表,领队id',
  `teacher` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班主任',
  `teacher_id` int(10) NOT NULL COMMENT '对应member表id',
  `coach` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主教练',
  `coach_id` int(10) NOT NULL COMMENT '对应member.id',
  `coach_salary` int(8) NOT NULL DEFAULT 0 COMMENT '主教练佣金',
  `assistant_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '副教练id集合,序列化,member.id',
  `assistant` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '副教练,序列化,对应',
  `assistant_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '助教1,助教2,助教3',
  `assistant_salary` int(8) NULL DEFAULT 0 COMMENT '助教底薪',
  `salary_base` int(10) NOT NULL DEFAULT 0 COMMENT '人头基数',
  `students` int(10) NOT NULL COMMENT '学生数量',
  `student_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生1,学生2,学生3,(准哥要求)',
  `week` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '周一,周六',
  `lesson_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '8:00:00,14:00:00',
  `start` int(10) NOT NULL COMMENT '开始上课时间',
  `end` int(10) NOT NULL COMMENT '结束上课时间',
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认为课程地址',
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认为课程地址',
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认为课程地址',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `plan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教案',
  `plan_id` int(10) NOT NULL COMMENT '教案id',
  `court` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球场',
  `court_id` int(10) NOT NULL COMMENT '场地id',
  `rent` decimal(8, 2) NOT NULL COMMENT '场地租金',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '系统备注',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/static/frontend/images/grade_logo.jpg' COMMENT '班级logo',
  `is_school` tinyint(4) NOT NULL DEFAULT -1 COMMENT '-1:非校园班|1:校园课班',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '-1:预排;1:正常|2:下架',
  `delete_time` int(10) NULL DEFAULT NULL,
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 67 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for grade_category
-- ----------------------------
DROP TABLE IF EXISTS `grade_category`;
CREATE TABLE `grade_category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程分类名',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片地址',
  `sort` tinyint(2) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL COMMENT '状态:1正常|-1禁用|0默认',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '父级id',
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 167 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '课程分类' ROW_FORMAT = Dynamic;

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
) ENGINE = MyISAM AUTO_INCREMENT = 882 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '班级-会员关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for group
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '社团名称',
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类型:1:单位、2:球队、3:同学、4:朋友、5家族、-1:其他',
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发起人',
  `member_id` int(11) NOT NULL,
  `members` int(11) NOT NULL DEFAULT 0 COMMENT '会员数',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面\\logo',
  `notice` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公告',
  `tenet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '铁尼特,宗旨',
  `rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规则',
  `punchs` int(11) NOT NULL DEFAULT 0 COMMENT '打卡总数',
  `bonus` int(11) NOT NULL DEFAULT 0 COMMENT '奖金总数',
  `season` int(11) NOT NULL DEFAULT 2 COMMENT '1:周季|2:月季|3:年季(22:00结算)',
  `max` int(11) NOT NULL DEFAULT 99 COMMENT '最大人数',
  `stake` decimal(2, 0) NOT NULL DEFAULT 1 COMMENT '每次下注的钱,最大是10元/次',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|-1:解散',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '社群表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for group_apply
-- ----------------------------
DROP TABLE IF EXISTS `group_apply`;
CREATE TABLE `group_apply`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '已member_id为主,1:自己申请|2:被邀请',
  `invate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `invate_id` int(11) NOT NULL DEFAULT 0,
  `invate_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '申请理由',
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '-1:拒绝|1:申请中|2:已被同意入群',
  `sys_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '回复理由',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for group_member
-- ----------------------------
DROP TABLE IF EXISTS `group_member`;
CREATE TABLE `group_member`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '-2|退出-1:被剔除|1:正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '社群-会员关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for group_punch
-- ----------------------------
DROP TABLE IF EXISTS `group_punch`;
CREATE TABLE `group_punch`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punch` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punch_id` int(11) NOT NULL,
  `punch_category` tinyint(4) NOT NULL COMMENT '1:训练|2:比赛',
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pool_id` int(11) NOT NULL,
  `pool` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stake` decimal(4, 0) NOT NULL DEFAULT 0 COMMENT '打卡金',
  `month_str` int(11) NOT NULL COMMENT '201805',
  `date_str` int(11) NOT NULL COMMENT '20180505',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 334 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '打卡-群主关系表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for hotcoin_finance
-- ----------------------------
DROP TABLE IF EXISTS `hotcoin_finance`;
CREATE TABLE `hotcoin_finance`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hot_coin` int(11) NOT NULL COMMENT '热币流水',
  `type` tinyint(4) NOT NULL COMMENT '1:充值|-1:打卡支出|-2:转出成余额|-3:打赏支出',
  `f_id` int(11) NOT NULL COMMENT '外键',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '热币流水记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for income
-- ----------------------------
DROP TABLE IF EXISTS `income`;
CREATE TABLE `income`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lesson_id` int(10) NOT NULL,
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `goods` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `goods_id` int(11) NOT NULL,
  `camp_id` int(10) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `total` tinyint(4) NOT NULL DEFAULT 1 COMMENT '购买总数',
  `balance_pay` decimal(12, 2) NOT NULL COMMENT '订单总金额',
  `price` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '单价',
  `income` decimal(12, 2) NOT NULL COMMENT '训练营收入',
  `member_id` int(10) NOT NULL COMMENT '购买者id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `student_id` int(11) NOT NULL,
  `student` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:课程订单收入|2:活动订单收入|3:课时收入|4:充值|5:退款收入',
  `f_id` int(11) NOT NULL DEFAULT 0 COMMENT '外键',
  `bill_id` int(11) NOT NULL COMMENT '订单id',
  `bill_order` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `schedule_time` int(11) NOT NULL,
  `schedule_income` decimal(8, 2) NOT NULL COMMENT '课时收入',
  `schedule_id` int(11) NOT NULL COMMENT '课时id',
  `students` tinyint(4) NOT NULL DEFAULT 0 COMMENT '人次',
  `schedule_rebate` decimal(4, 4) NOT NULL DEFAULT 0.1000 COMMENT '平台抽成比例',
  `rebate_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '抽成方式',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `s_balance` decimal(11, 2) NOT NULL DEFAULT 0.00 COMMENT '数据前余额',
  `e_balance` decimal(11, 2) NULL DEFAULT 0.00 COMMENT '数据产生后余额',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '系统修改则不为1',
  `date_str` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '20180101',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4446 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '训练营收入表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for item_coupon
-- ----------------------------
DROP TABLE IF EXISTS `item_coupon`;
CREATE TABLE `item_coupon`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coupon` varchar(69) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '卡券名称',
  `target_type` tinyint(4) NOT NULL DEFAULT -1 COMMENT '-1:活动促销大礼包送|1:购买课程赠送 |2:购买活动赠送 |3:产生订单赠送|4:文章卡券',
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '/uploads/images/coupon/woo.jpg' COMMENT '卡片背景图片',
  `price` decimal(8, 0) NOT NULL COMMENT '价值',
  `target_id` int(11) NOT NULL DEFAULT 0 COMMENT 'id:赠送的 活动|课程 ',
  `target` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '对象名称',
  `coupon_des` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '卡券描述',
  `contact` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '篮球管家' COMMENT '联系人',
  `max` int(10) NOT NULL COMMENT '发布数量',
  `publish` int(11) NOT NULL DEFAULT 0 COMMENT '已发行数量',
  `used` int(11) NOT NULL DEFAULT 0 COMMENT '已使用数量',
  `start` int(11) NOT NULL COMMENT '开始有效期',
  `end` int(11) NOT NULL COMMENT '截止日期',
  `publish_start` int(11) NOT NULL COMMENT '开始发行时间',
  `publish_end` int(11) NOT NULL COMMENT '结束发行时间',
  `organization` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '平台系统',
  `organization_id` int(11) NOT NULL COMMENT '0:平台',
  `organization_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1:平台|2:训练营|3:球队',
  `telephone` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '编辑人|发布人',
  `member_id` int(11) NOT NULL COMMENT '编辑人|发布人',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_max` tinyint(4) NOT NULL DEFAULT 1 COMMENT '是否被领取完   1:未被领取完|2:达到max被领取完',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|-1:删除',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '物品卡券' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for item_coupon_member
-- ----------------------------
DROP TABLE IF EXISTS `item_coupon_member`;
CREATE TABLE `item_coupon_member`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_coupon_id` int(11) NOT NULL,
  `item_coupon` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `coupon_number` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '卡券码',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:未使用|2:已使用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for lesson
-- ----------------------------
DROP TABLE IF EXISTS `lesson`;
CREATE TABLE `lesson`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL DEFAULT -1 COMMENT '0:未审核;1:正常;-1:下架',
  `delete_time` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程名称',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布者',
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `leader_id` int(10) NOT NULL COMMENT '负责财务的老大,对应member表id',
  `leader` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'leader',
  `gradecate` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程类型',
  `gradecate_id` int(10) NOT NULL COMMENT '选择类型',
  `gradecate_setion` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程类型父级',
  `gradecate_setion_id` int(11) NOT NULL COMMENT '课程类型父级id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属训练营名称',
  `camp_id` int(10) NOT NULL COMMENT '所属训练营id',
  `cost` decimal(8, 0) NOT NULL DEFAULT 0 COMMENT '每个课时单价',
  `total` tinyint(10) NOT NULL DEFAULT 1 COMMENT '总课时数量',
  `score` int(10) NOT NULL DEFAULT 0 COMMENT '购买课程需要积分',
  `coach` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主教练',
  `coach_id` int(10) NOT NULL COMMENT 'zhu教练  对应member表id',
  `assistant` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '副教练序列化',
  `assistant_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '副教练id集合 序列化',
  `teacher` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班主任',
  `teacher_id` int(10) NOT NULL COMMENT '对应member表id',
  `min` int(10) NOT NULL DEFAULT 1 COMMENT '最少开课学生数量',
  `max` int(10) NOT NULL COMMENT '最大开课学生数量',
  `week` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '周六,周三',
  `start` date NOT NULL COMMENT '开始日期',
  `end` date NOT NULL COMMENT '结束日期',
  `lesson_time` varchar(255) NOT NULL COMMENT '具体上课时间',
  `dom` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'serialize,可以购买的数量',
  `sort` int(10) NOT NULL DEFAULT 0 COMMENT '推荐排序',
  `hot` int(10) NOT NULL DEFAULT 0 COMMENT '热门课程',
  `hit` int(10) NOT NULL COMMENT '点击量',
  `students` int(10) NOT NULL DEFAULT 0 COMMENT '报名人数,包括预约体验的学生',
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '省',
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '市',
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '区',
  `court_id` int(10) NOT NULL COMMENT '场地id',
  `court` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地名称',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lat` decimal(20, 15) NOT NULL DEFAULT 0.000000000000000 COMMENT '经纬度',
  `lng` decimal(20, 15) NOT NULL DEFAULT 0.000000000000000 COMMENT '经纬度',
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面',
  `total_giftschedule` int(11) NOT NULL DEFAULT 0 COMMENT '历史赠送课时数',
  `resi_giftschedule` int(11) NOT NULL DEFAULT 0 COMMENT '剩余赠送课时数',
  `unbalanced_giftschedule` int(11) NOT NULL DEFAULT 0 COMMENT '未结算赠送课时数',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `isprivate` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:私有课程|0:公开课程',
  `is_school` tinyint(4) NOT NULL DEFAULT -1 COMMENT '1:校园版|-1:正常课程',
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 78 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lesson_assign_member
-- ----------------------------
DROP TABLE IF EXISTS `lesson_assign_member`;
CREATE TABLE `lesson_assign_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lesson_id` int(11) NOT NULL DEFAULT 0,
  `lesson` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL DEFAULT 0,
  `member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态1:正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '私密课程可购买会员关系表' ROW_FORMAT = Compact;

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
  `transfer` tinyint(4) NOT NULL DEFAULT -1 COMMENT '是否转课生',
  `is_school` tinyint(4) NOT NULL DEFAULT -1 COMMENT '1:校园版|-1:正常课程',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '-1:离营|0:待审核|1:正常|2:退出|3:被开除|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 657 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '课程-会员关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for log_admindo
-- ----------------------------
DROP TABLE IF EXISTS `log_admindo`;
CREATE TABLE `log_admindo`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '管理员id',
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '管理员名字',
  `doing` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作事件',
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '操作页面',
  `ip` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ip',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 846 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for log_grade_member
-- ----------------------------
DROP TABLE IF EXISTS `log_grade_member`;
CREATE TABLE `log_grade_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '产生操作的会员',
  `member_id` int(10) NOT NULL COMMENT '产生操作的会员id',
  `action` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '数据操作：insert|update|delete',
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '操作数据(json)',
  `referer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'server[http_referer]',
  `create_time` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '创建时间(日期格式)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_income
-- ----------------------------
DROP TABLE IF EXISTS `log_income`;
CREATE TABLE `log_income`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_lesson_member
-- ----------------------------
DROP TABLE IF EXISTS `log_lesson_member`;
CREATE TABLE `log_lesson_member`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 390 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_match_statistics
-- ----------------------------
DROP TABLE IF EXISTS `log_match_statistics`;
CREATE TABLE `log_match_statistics`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `member` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '会员',
  `action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '数据操作：insert|update|delete',
  `more` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '详细数据(json)',
  `referer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'server[http_referer]',
  `create_time` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '创建时间(日期格式)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_pay
-- ----------------------------
DROP TABLE IF EXISTS `log_pay`;
CREATE TABLE `log_pay`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_rebate
-- ----------------------------
DROP TABLE IF EXISTS `log_rebate`;
CREATE TABLE `log_rebate`  (
  `id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_salary_in
-- ----------------------------
DROP TABLE IF EXISTS `log_salary_in`;
CREATE TABLE `log_salary_in`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_salary_out
-- ----------------------------
DROP TABLE IF EXISTS `log_salary_out`;
CREATE TABLE `log_salary_out`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_sendtemplatemsg
-- ----------------------------
DROP TABLE IF EXISTS `log_sendtemplatemsg`;
CREATE TABLE `log_sendtemplatemsg`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wxopenid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '接收的openid',
  `member_id` int(11) NOT NULL COMMENT '接收的memberid',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '消息的url地址',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '消息的内容 seriliaze',
  `status` tinyint(4) NULL DEFAULT 0 COMMENT '发送成功状态:1成功|0失败',
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7019 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '发送模板消息log' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for log_wxpay
-- ----------------------------
DROP TABLE IF EXISTS `log_wxpay`;
CREATE TABLE `log_wxpay`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `callback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `openid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bill_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time_end` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_fee` int(10) NOT NULL,
  `transaction_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sys_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 660 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match
-- ----------------------------
DROP TABLE IF EXISTS `match`;
CREATE TABLE `match`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '赛事类型:1友谊赛...',
  `match_org_id` int(11) NOT NULL COMMENT '联赛组织id',
  `match_org` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联赛组织',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '赛事名称',
  `member_id` int(10) UNSIGNED NOT NULL COMMENT '创建人会员id',
  `member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人会员',
  `member_avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建人会员头像',
  `charge_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '负责人姓名',
  `team_id` int(11) NOT NULL COMMENT '创建比赛球队id(可无)',
  `team` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建比赛球队(可无)',
  `format` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '赛制(存中文)',
  `match_time` int(10) NULL DEFAULT NULL COMMENT '比赛时间(单次比赛)',
  `start_time` int(11) NULL DEFAULT NULL COMMENT '比赛开始时间(联赛等)',
  `end_time` int(11) NULL DEFAULT NULL COMMENT '比赛结束时间(联赛等)',
  `reg_start_time` int(11) NULL DEFAULT NULL COMMENT '开始报名时间',
  `reg_end_time` int(11) NULL DEFAULT NULL COMMENT '截止报名时间',
  `province` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛所在地区(省)',
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛所在地区(市)',
  `area` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛所在地区(区)',
  `court_id` int(11) NOT NULL COMMENT '场地court_id',
  `court` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地名称',
  `court_lng` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地定位坐标lng',
  `court_lat` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地定位坐标lat',
  `court_cost` int(11) NOT NULL DEFAULT 0 COMMENT '场地费用',
  `court_cost_bear` int(11) NOT NULL DEFAULT 0 COMMENT '场地费用承担:1aa平分|2主队付|3客队付|0无需付费',
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '状态:1正常|-1下架',
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'logo',
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面图',
  `finished_time` int(11) NULL DEFAULT NULL COMMENT '比赛完成时间',
  `is_finished` int(11) NOT NULL DEFAULT -1 COMMENT '比赛是否完成:-1未完成|1已完成',
  `apply_status` int(11) NOT NULL DEFAULT -1 COMMENT '比赛报名状态:1报名中|2结束报名|-1默认',
  `hot` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '热门:1热门|0普通',
  `islive` int(11) NOT NULL DEFAULT -1 COMMENT '是否约战:1是|-1否',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注,温馨提示',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `send_message` tinyint(4) NOT NULL DEFAULT -1 COMMENT '发布通知1:通知|-1不通知',
  `introduce` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图文介绍',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宣言',
  `regulation` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '章程',
  `teams_max` int(10) NOT NULL DEFAULT 0 COMMENT '最多参赛球队数',
  `entry_fees` int(10) NOT NULL DEFAULT 0 COMMENT '参赛费用(元)',
  `deposit` int(10) NOT NULL DEFAULT 0 COMMENT '参赛保证金(元)',
  `is_open` int(10) NOT NULL DEFAULT 0 COMMENT '公开状态:1公开|0非公开',
  `max_teammembers` int(11) NOT NULL DEFAULT 0 COMMENT '参赛球队成员上限数',
  `min_teammembers` int(11) NOT NULL DEFAULT 0 COMMENT '参赛球队成员下限数',
  `teams_count` int(11) NOT NULL DEFAULT 0 COMMENT '参赛球队数',
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '赛事(比赛)主表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_apply
-- ----------------------------
DROP TABLE IF EXISTS `match_apply`;
CREATE TABLE `match_apply`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(10) UNSIGNED NOT NULL COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛name',
  `is_league` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否联赛报名:1是|0',
  `team_id` int(10) UNSIGNED NOT NULL COMMENT '发布申请的球队id',
  `team` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布申请的球队name',
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系人电话',
  `contact` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系人',
  `member_id` int(10) UNSIGNED NOT NULL COMMENT '发送申请的会员id',
  `member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发送申请的会员member',
  `member_avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发送申请的会员avatar',
  `revice_team_id` int(11) NOT NULL DEFAULT 0 COMMENT '收到申请的球队id',
  `revice_team` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '收到申请的球队',
  `remarks` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注信息',
  `reply` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '回复内容',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1:未处理|2:已同意|3:已拒绝',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '球队参加比赛申请' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_group
-- ----------------------------
DROP TABLE IF EXISTS `match_group`;
CREATE TABLE `match_group`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛名',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分组名',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1正常|-1无效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛分组' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_group_team
-- ----------------------------
DROP TABLE IF EXISTS `match_group_team`;
CREATE TABLE `match_group_team`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛名',
  `match_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛logo图',
  `team_id` int(11) NOT NULL COMMENT '球队id',
  `team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球队名',
  `team_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球队logo图',
  `group_id` int(11) NOT NULL COMMENT '分组match_group id',
  `group_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分组名',
  `group_number` int(11) NOT NULL COMMENT '分组内序号',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1正常|-1无效',
  `win_num` int(11) NOT NULL DEFAULT 0 COMMENT '胜场数',
  `lost_num` int(11) NOT NULL COMMENT '输场数',
  `points` int(11) NOT NULL COMMENT '比赛积分',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛分组-球队 关联' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_history_team
-- ----------------------------
DROP TABLE IF EXISTS `match_history_team`;
CREATE TABLE `match_history_team`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(10) UNSIGNED NOT NULL COMMENT '球队team_id',
  `team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球队team_name',
  `opponent_team_id` int(11) NOT NULL COMMENT '对手team_id',
  `opponent_team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '对手team_name',
  `match_num` int(11) NOT NULL DEFAULT 0 COMMENT '对战次数',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛历史对手表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_member
-- ----------------------------
DROP TABLE IF EXISTS `match_member`;
CREATE TABLE `match_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛名称',
  `match_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛logo',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员名',
  `member_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会员头像',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '工作人员角色:10负责人|9管理员|8记分员|7裁判员',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态:1正常|-1无效|0默认',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '联赛-工作人员关系' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_new_comment
-- ----------------------------
DROP TABLE IF EXISTS `match_new_comment`;
CREATE TABLE `match_new_comment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '评论类型:1点赞|2文字评论',
  `match_news_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛动态id',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '发布评论的会员id',
  `member` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发布评论的会员名',
  `member_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发布评论的会员头像',
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文字评论内容',
  `thumbsup` int(11) NOT NULL DEFAULT 0 COMMENT '点赞状态:0无|1已点赞',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛动态评论' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_news
-- ----------------------------
DROP TABLE IF EXISTS `match_news`;
CREATE TABLE `match_news`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛名称',
  `creater_member_id` int(11) NOT NULL COMMENT '创建人会员id',
  `creater_member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '创建人会员名',
  `member_id` int(11) NOT NULL COMMENT '最后操作会员id',
  `member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '最后操作会员名',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '封面图',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '正文内容',
  `newstime` int(11) NOT NULL COMMENT '真实发布时间',
  `status` int(11) NOT NULL,
  `author` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '作者',
  `clicks` int(11) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛动态' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_org_member
-- ----------------------------
DROP TABLE IF EXISTS `match_org_member`;
CREATE TABLE `match_org_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_org_id` int(11) NOT NULL DEFAULT 0 COMMENT '联赛组织id',
  `match_org` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联赛组织',
  `match_org_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员名',
  `member_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员头像',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '工作人员角色:10负责人|9管理员|8记分员|7裁判员',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态:1正常|-1无效|0默认',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '联赛组织-人员关系' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_organization
-- ----------------------------
DROP TABLE IF EXISTS `match_organization`;
CREATE TABLE `match_organization`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '组织名称',
  `type` int(11) NOT NULL COMMENT '组织类型',
  `creater_member_id` int(11) NOT NULL COMMENT '创建人会员id',
  `creater_member` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '创建人会员',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员',
  `province` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '所在地区(省)',
  `city` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '所在地区(市)',
  `area` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '所在地区(区)',
  `address` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '详细地址',
  `company` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '公司单位(可不填)',
  `realname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注册人真实姓名',
  `contact_tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系电话(默认是创建人会员手机)',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'logo图',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '封面图',
  `descri` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宣言',
  `introduce` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图文介绍',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态:0未审核|1正常|2审核不通过|3下线关闭',
  `bankcard_no` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '银行卡号',
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '银行',
  `bankcard_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '持卡人姓名',
  `bankcard_telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '银行卡联系电话',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '系统备注',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '联赛组织信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_record
-- ----------------------------
DROP TABLE IF EXISTS `match_record`;
CREATE TABLE `match_record`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(10) UNSIGNED NOT NULL COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛',
  `match_schedule_id` int(11) NOT NULL DEFAULT 0 COMMENT '联赛日程id',
  `match_time` int(11) NOT NULL COMMENT '具体比赛时间',
  `team_id` int(11) NOT NULL COMMENT '战绩数据所属球队id',
  `home_team_id` int(10) UNSIGNED NOT NULL COMMENT '主队球队id',
  `home_team` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主队球队名',
  `home_team_logo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主队球队logo',
  `home_team_color` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主队球队球服颜色(中文字)',
  `home_team_colorstyle` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主队球队颜色(英文,用于显示样式)',
  `home_score` int(11) NOT NULL DEFAULT 0 COMMENT '主队得分',
  `away_team_id` int(11) NOT NULL COMMENT '客队球队id',
  `away_team` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客队球队名',
  `away_team_logo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客队球队logo',
  `away_team_color` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客队球队球服颜色(中文字)',
  `away_team_colorstyle` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '客队球队颜色(英文,用于显示样式)',
  `away_score` int(11) NOT NULL DEFAULT 0 COMMENT '客队得分',
  `referee_count` int(11) NOT NULL COMMENT '裁判人数',
  `referee1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"referee\":\"\",\"referee_id\":\"\",\"referee_cost\":\"\"}' COMMENT '裁判1信息(json格式)',
  `referee2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"referee\":\"\",\"referee_id\":\"\",\"referee_cost\":\"\"}' COMMENT '裁判2信息(json格式)',
  `referee3` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '{\"referee\":\"\",\"referee_id\":\"\",\"referee_cost\":\"\"}' COMMENT '裁判3信息(json格式)',
  `referee_pricesum` int(11) NOT NULL DEFAULT 0 COMMENT '裁判费用总额',
  `referee_cost_bear` int(10) NOT NULL DEFAULT 0 COMMENT '裁判费用付费方式:1两队平分|2主队负责|3客队负责|0免费',
  `album` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '活动相册(json格式)',
  `win_team_id` int(11) NOT NULL COMMENT '比赛胜方球队id:用于统计球队胜场数',
  `lose_team_id` int(10) NOT NULL DEFAULT 0 COMMENT '比赛输方球队id:用于统计球队胜场数',
  `claim_status` int(10) NOT NULL DEFAULT 0 COMMENT '球队认领比赛数据状态:0未认领|1已认领|2比分不作算',
  `claim_team_id` int(10) NOT NULL DEFAULT 0 COMMENT '认领比赛数据球队id',
  `claim_record_id` int(10) NOT NULL DEFAULT 0 COMMENT '认领比赛数据record_id',
  `has_statics` int(10) NOT NULL DEFAULT 0 COMMENT '有无统计数据:1有|0无',
  `statics_time` int(11) NULL DEFAULT NULL COMMENT '登记技术数据时间',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '比赛战绩记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_record_member
-- ----------------------------
DROP TABLE IF EXISTS `match_record_member`;
CREATE TABLE `match_record_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛名',
  `match_record_id` int(11) NOT NULL COMMENT '比赛战绩id',
  `match_time` int(11) NOT NULL COMMENT '比赛时间',
  `team_id` int(11) NOT NULL COMMENT '球队id',
  `team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球队名',
  `team_member_id` int(10) NOT NULL DEFAULT 0 COMMENT 'team_member表id',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员名',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球员名',
  `number` int(10) NULL DEFAULT NULL COMMENT '球衣号码',
  `avatar` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员头像',
  `contact_tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员电话',
  `student_id` int(11) NOT NULL COMMENT '学生id',
  `student` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '学生名',
  `is_apply` int(11) NOT NULL DEFAULT -1 COMMENT '报名标识:1报名|-1默认',
  `is_attend` int(11) NOT NULL DEFAULT -1 COMMENT '出席标识:1出席|-1默认,判断是否更新队员比赛出场次',
  `is_checkin` int(11) NOT NULL DEFAULT -1 COMMENT '出赛登录标识:1已登录|-1默认',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1有效|-1无效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '比赛出赛会员' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_referee
-- ----------------------------
DROP TABLE IF EXISTS `match_referee`;
CREATE TABLE `match_referee`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL COMMENT '比赛id',
  `match` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `match_record_id` int(255) NOT NULL DEFAULT 0 COMMENT '比赛战绩id',
  `referee_id` int(11) NOT NULL COMMENT '裁判员id',
  `referee` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL COMMENT '裁判员的member_id',
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `referee_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:主裁判|2:副裁判',
  `appearance_fee` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '出场费',
  `is_attend` int(10) NOT NULL DEFAULT 1 COMMENT '出席比赛:1默认|2出席|3缺席',
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '状态:1有效|-1无效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '比赛-裁判信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_referee_apply
-- ----------------------------
DROP TABLE IF EXISTS `match_referee_apply`;
CREATE TABLE `match_referee_apply`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `apply_type` int(11) NOT NULL DEFAULT 1 COMMENT '类型:1申请|2邀请',
  `match_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛',
  `match_record_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛战绩id',
  `team_id` int(10) NOT NULL DEFAULT 0 COMMENT '比赛发起球队id',
  `team` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛发起球队',
  `referee_id` int(11) NOT NULL DEFAULT 0 COMMENT '裁判id',
  `referee` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `referee_cost` int(10) NOT NULL COMMENT '裁判费用',
  `referee_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '裁判员头像',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '发送申请会员id',
  `member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发送申请会员',
  `member_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发送申请会员头像',
  `overtime` int(11) NOT NULL COMMENT '申请|邀请过期时间',
  `remarks` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `system_remarks` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `reply` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '回复内容',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '回复状态:1默认|2同意|3拒绝|-1申请被撤销',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '比赛裁判申请|邀请' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_schedule
-- ----------------------------
DROP TABLE IF EXISTS `match_schedule`;
CREATE TABLE `match_schedule`  (
  `id` int(10) UNSIGNED NOT NULL,
  `match_id` int(11) NOT NULL COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛名',
  `home_team_id` int(11) NOT NULL DEFAULT 0 COMMENT '主球队id',
  `home_team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '主球队名',
  `home_team_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '主球队logo图',
  `away_team_id` int(11) NOT NULL DEFAULT 0 COMMENT '客球队id',
  `away_team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '客球队名',
  `away_team_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '客球队logo图',
  `match_time` int(11) NOT NULL DEFAULT 0 COMMENT '预计比赛时间',
  `match_group` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛分组名',
  `match_group_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛分组id',
  `match_no` int(11) NOT NULL DEFAULT 0 COMMENT '比赛场次序号',
  `match_stage_id` int(11) NOT NULL COMMENT '比赛阶段id',
  `match_stage` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛阶段名',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1正常|-1无效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛赛程' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_stage
-- ----------------------------
DROP TABLE IF EXISTS `match_stage`;
CREATE TABLE `match_stage`  (
  `id` int(10) UNSIGNED NOT NULL,
  `match_id` int(11) NOT NULL,
  `match` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛阶段名称',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '比赛阶段类型:1小组赛|2淘汰赛|3热身赛',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1正常|-1无效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛阶段' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_statistics
-- ----------------------------
DROP TABLE IF EXISTS `match_statistics`;
CREATE TABLE `match_statistics`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛名',
  `match_schedule_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '比赛日程id',
  `match_record_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '比赛战绩id',
  `match_record_member_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛出赛会员id',
  `match_time` int(11) NOT NULL DEFAULT 0 COMMENT '比赛实际具体时间',
  `team_member_id` int(11) NOT NULL DEFAULT 0 COMMENT '球员id(team_member表id)',
  `team_id` int(11) NOT NULL DEFAULT 0 COMMENT '球队id',
  `team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球队名',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球员名',
  `member_id` int(11) NOT NULL COMMENT '球员会员id',
  `member` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球员会员名',
  `number` int(11) NULL DEFAULT NULL COMMENT '球衣号码',
  `position` int(11) NOT NULL COMMENT '场上位置',
  `playing_time` int(11) NOT NULL DEFAULT 0 COMMENT '上场时间(单位:秒)',
  `pts` int(11) NOT NULL DEFAULT 0 COMMENT '得分',
  `ast` int(11) NOT NULL DEFAULT 0 COMMENT '助攻',
  `reb` int(11) NOT NULL DEFAULT 0 COMMENT '篮板',
  `stl` int(11) NOT NULL DEFAULT 0 COMMENT '抢断',
  `blk` int(11) NOT NULL DEFAULT 0 COMMENT '盖帽',
  `turnover` int(11) NOT NULL DEFAULT 0 COMMENT '失误',
  `foul` int(11) NOT NULL DEFAULT 0 COMMENT '犯规',
  `fg` int(11) NOT NULL DEFAULT 0 COMMENT '2分命中数',
  `fga` int(11) NOT NULL DEFAULT 0 COMMENT '2分出手数',
  `threepfg` int(11) NOT NULL DEFAULT 0 COMMENT '3分命中数',
  `threepfga` int(11) NOT NULL DEFAULT 0 COMMENT '3分出手数',
  `off_reb` int(11) NOT NULL DEFAULT 0 COMMENT '前场篮板',
  `def_reb` int(11) NOT NULL DEFAULT 0 COMMENT '后场篮板',
  `ft` int(11) NOT NULL DEFAULT 0 COMMENT '罚球命中数',
  `fta` int(11) NOT NULL DEFAULT 0 COMMENT '罚球数',
  `lineup` int(11) NOT NULL DEFAULT 0 COMMENT '是否首发:1是|0否',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1正常|-1无效',
  `system_remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛技术数据统计' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_team
-- ----------------------------
DROP TABLE IF EXISTS `match_team`;
CREATE TABLE `match_team`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_id` int(10) UNSIGNED NOT NULL COMMENT '比赛match_id',
  `match` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '比赛名称match_name',
  `team_id` int(11) NOT NULL COMMENT '参赛球队team_id',
  `team` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '参赛球队名',
  `team_logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '参赛球队logo',
  `members_num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '球队登记参赛成员数',
  `members` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登记参赛成员名单(json)',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '比赛-球队关联表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for match_team_member
-- ----------------------------
DROP TABLE IF EXISTS `match_team_member`;
CREATE TABLE `match_team_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `match_team_id` int(10) UNSIGNED NOT NULL COMMENT 'match_team表id',
  `match_apply_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'match_apply表id',
  `match_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'match表id',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'team表id',
  `team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `team_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `team_member_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'team_member表id',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球员名(team_member_name)',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '球员member_id',
  `member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球员member',
  `student_id` int(11) NOT NULL DEFAULT 0 COMMENT '球员学生id(team_member_student_id)',
  `student` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球员学生',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球员头像(team_member_avatar)',
  `number` int(11) NULL DEFAULT NULL COMMENT '球衣号码',
  `position` int(11) NULL DEFAULT NULL COMMENT '场上位置(1控球后卫|2得分后卫|3小前锋|4大前锋|5中锋)',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `match_id`(`match_id`) USING BTREE,
  INDEX `team_id`(`team_id`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '比赛球队登记球员名单' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for media
-- ----------------------------
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(10) NULL DEFAULT 0,
  `hot_id` bigint(20) UNSIGNED NOT NULL COMMENT '会员随机ID',
  `openid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信授权即产生',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `nickname` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信授权即产生',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '注册或者微信授权产生',
  `telephone` bigint(11) NOT NULL COMMENT '电话号码',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电子邮箱',
  `realname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名',
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '省',
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '市',
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '居住地址',
  `sex` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1男2女',
  `yearsexp` int(10) NOT NULL DEFAULT 0 COMMENT '开始打球年份(计算球龄)',
  `height` int(11) NOT NULL COMMENT '身高,单位cm',
  `weight` int(11) NOT NULL COMMENT '体重,单位cm',
  `charater` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `shoe_code` int(11) NOT NULL COMMENT '鞋码(欧码)',
  `birthday` date NOT NULL COMMENT '生日',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|2:被锁定|3:禁封',
  `create_time` int(10) NOT NULL COMMENT '注册时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  `level` tinyint(4) NOT NULL DEFAULT 1 COMMENT '根据流量自动分',
  `hp` int(10) NOT NULL COMMENT '业绩|经验',
  `cert_id` int(10) NOT NULL COMMENT '证件id',
  `score` int(10) NOT NULL DEFAULT 0 COMMENT '积分',
  `hot_coin` int(11) NOT NULL COMMENT '热币',
  `flow` int(10) NOT NULL COMMENT '流量,三层关系',
  `balance` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '人民币余额',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'remarks',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descri` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '个人宣言',
  `logintime` int(11) NOT NULL DEFAULT 0 COMMENT '登陆次数',
  `lastlogin_ip` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lastlogin_ua` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lastlogin_at` int(11) NOT NULL DEFAULT 0 COMMENT '上一次登陆时间',
  `ismyself` tinyint(4) NOT NULL DEFAULT 1 COMMENT '是否本人创建的会员数据:1是|0其他人创建',
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 612 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for member_comment
-- ----------------------------
DROP TABLE IF EXISTS `member_comment`;
CREATE TABLE `member_comment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_type` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '评论类型:1会员本人|2会员荣誉',
  `commented` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '被评论的实体名称',
  `commented_id` int(10) NOT NULL COMMENT '被评论的实体id',
  `commented_member_id` int(11) NOT NULL DEFAULT 0 COMMENT '被评论的会员ID',
  `commented_member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '被评论的会员',
  `commented_member_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '被评论的会员头像',
  `member_id` int(10) NOT NULL DEFAULT 0 COMMENT '发布评论的会员id',
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发布评论的会员',
  `member_avatar` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发布评论的会员头像',
  `comment` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文字评论内容',
  `comment_time` int(11) NULL DEFAULT NULL COMMENT '发表文字评论时间',
  `thumbsup` tinyint(4) NOT NULL DEFAULT 0 COMMENT '点赞|1点赞|0无点赞',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE,
  INDEX `commented_member`(`commented_member`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE,
  INDEX `create_time`(`create_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '会员评论点赞记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for member_finance
-- ----------------------------
DROP TABLE IF EXISTS `member_finance`;
CREATE TABLE `member_finance`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `money` decimal(8, 2) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:工资收入(包括人头提成)||2:提现支出',
  `s_balance` decimal(11, 2) NOT NULL COMMENT '当前余额',
  `e_balance` decimal(11, 2) NOT NULL COMMENT '产生数据后余额',
  `f_id` int(11) NOT NULL DEFAULT 0 COMMENT '外键',
  `date_str` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `datetime` int(11) NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2734 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户收支总表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for member_honor
-- ----------------------------
DROP TABLE IF EXISTS `member_honor`;
CREATE TABLE `member_honor`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '荣誉名',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '比赛名',
  `macht_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛信息id',
  `award_org` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '授奖单位(可以是联赛组织)',
  `award_org_id` int(11) NOT NULL DEFAULT 0 COMMENT '授奖单位id',
  `honor_time` int(11) NOT NULL DEFAULT 0 COMMENT '授奖时间',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片',
  `introduction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '图文介绍',
  `member_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '会员id',
  `member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '会员',
  `member_avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '会员头像',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态:1正常|0默认',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE,
  INDEX `create_time`(`create_time`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for member_menu
-- ----------------------------
DROP TABLE IF EXISTS `member_menu`;
CREATE TABLE `member_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `module` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'management' COMMENT '模块名称',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'fa fa-cog',
  `url_type` tinyint(2) NOT NULL DEFAULT 0 COMMENT '链接类型（1：外链|0:模块）',
  `url_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接,比如 admin/lesson/create_lesson',
  `url_target` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '_self' COMMENT '链接打开方式：_blank|_self',
  `online_hide` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1:显示|0:隐藏',
  `sort` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `power` tinyint(2) NOT NULL DEFAULT 0 COMMENT '权限大小,如果这个字段值为3,那么必须power>=3的用户才能显示',
  `power_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:需要锁定训练营的|2:不锁定训练营的比如教练',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 173 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for message
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_system` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:系统消息:2训练营消息',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1未读|0过期|2已读',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for message_member
-- ----------------------------
DROP TABLE IF EXISTS `message_member`;
CREATE TABLE `message_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `steward_type` int(11) NOT NULL DEFAULT 1 COMMENT '管家类型:1培训|2球队',
  `title` varchar(240) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:未读|2:已读',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7293 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for message_read
-- ----------------------------
DROP TABLE IF EXISTS `message_read`;
CREATE TABLE `message_read`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `message_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'message表id',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '接收广播的会员id',
  `isread` int(11) NOT NULL DEFAULT 1 COMMENT '是否已读:1未读|2已读',
  `create_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统广播-会员阅读关联' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for monthly_court_students
-- ----------------------------
DROP TABLE IF EXISTS `monthly_court_students`;
CREATE TABLE `monthly_court_students`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `court` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `court_id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `students` int(11) NOT NULL COMMENT '学生总数',
  `date_str` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '201801',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 79 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '每月学员训练点分布' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for monthly_students
-- ----------------------------
DROP TABLE IF EXISTS `monthly_students`;
CREATE TABLE `monthly_students`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `online_students` int(11) NOT NULL COMMENT '再营学生总数',
  `offline_students` int(11) NOT NULL COMMENT '离营学生总数',
  `onlesson_students` int(11) NOT NULL COMMENT '在上课的学生总数',
  `offlesson_students` int(11) NOT NULL COMMENT '结业的学生总数',
  `refund_students` int(11) NOT NULL COMMENT '退费的学生总数',
  `date_str` varbinary(60) NOT NULL COMMENT '201801',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1596 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for openid
-- ----------------------------
DROP TABLE IF EXISTS `openid`;
CREATE TABLE `openid`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `openid` varbinary(200) NOT NULL,
  `platform_id` int(11) NOT NULL,
  `platform` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '平台对应的openid' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for output
-- ----------------------------
DROP TABLE IF EXISTS `output`;
CREATE TABLE `output`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `output` decimal(12, 2) NOT NULL COMMENT '支出金额',
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `camp_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '操作人员',
  `member_id` int(11) NOT NULL COMMENT '操作人员id',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:赠课|2:课时退费|-1:提现|3:课时教练支出|4:平台分成|-2:其他支出',
  `e_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '产生数据后余额',
  `s_balance` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '产生数据前余额',
  `schedule_time` int(11) NOT NULL COMMENT '上课时间',
  `schedule_rebate` decimal(4, 2) NOT NULL DEFAULT 0.10 COMMENT '抽成比例',
  `rebate_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '平台分成类型',
  `f_id` int(11) NOT NULL COMMENT '外键',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态(预留字段)',
  `date_str` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '20180101',
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3458 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '训练营支出表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for pay
-- ----------------------------
DROP TABLE IF EXISTS `pay`;
CREATE TABLE `pay`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `pay_type` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '微信支付' COMMENT '支付方式',
  `money` decimal(12, 2) NOT NULL DEFAULT 0.00 COMMENT '支付金额',
  `callback_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付回调',
  `remarks` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `create_time` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '充值记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for plan
-- ----------------------------
DROP TABLE IF EXISTS `plan`;
CREATE TABLE `plan`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL DEFAULT 0 COMMENT '对于pid的值,平台教案都为0,自己添加教案的pid为-1,把平台教案挪到自己教案,则pid为平台教案id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '作者',
  `member_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL COMMENT '所属训练营,如果是平台,为0',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所属训练营,如果是平台,为0',
  `outline` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '大纲',
  `outline_detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `exercise_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练科目集合',
  `grade_category_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `grade_category` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '适合阶段(班级分类)',
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:平台|1训练营',
  `is_open` int(4) NOT NULL DEFAULT 1 COMMENT '0:不开放|1:开放',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:未审核|1:正常|2:不通过',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '个人备注',
  `sys_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for platform
-- ----------------------------
DROP TABLE IF EXISTS `platform`;
CREATE TABLE `platform`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `platform` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '微信平台名称',
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '公司名称',
  `camp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '关联的训练营名称',
  `camp_id` int(11) NOT NULL COMMENT '关联的训练营id',
  `appsecret` varbinary(200) NOT NULL,
  `appid` varbinary(200) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '登陆账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '登陆密码',
  `wechat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '授权的微信号(不管存微信账号密码)',
  `encodingaeskey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mchid` int(11) NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注：key为商户平台设置的密钥key',
  `sslcert_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '证书地址',
  `sslkey_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '证书密钥',
  `sms_appid` int(11) NOT NULL COMMENT '短信通道',
  `sms_secret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '短信密钥',
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1:正常|-1:禁用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '平台表(微信)' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for pool
-- ----------------------------
DROP TABLE IF EXISTS `pool`;
CREATE TABLE `pool`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pool` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '奖金池的名称,如:2018年5月23日周期|2018年5月1日月期',
  `season` tinyint(4) NOT NULL COMMENT '1:周季|2:月季|3:年季(22:00结算)',
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `members` int(11) NOT NULL COMMENT '打卡人数',
  `bonus` int(11) NOT NULL COMMENT '奖金池金额',
  `start` int(11) NOT NULL COMMENT '开始时间戳',
  `end` int(11) NOT NULL COMMENT '结束时间戳',
  `end_str` int(11) NOT NULL COMMENT '20180505',
  `stake` decimal(2, 0) NOT NULL COMMENT '每次下注金额',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:未开启|-1:已结束|2:进行中',
  `winner_list` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for pool_winner
-- ----------------------------
DROP TABLE IF EXISTS `pool_winner`;
CREATE TABLE `pool_winner`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pool` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pool_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `group` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `punchs` tinyint(4) NOT NULL DEFAULT 0,
  `winner_bonus` int(11) NOT NULL COMMENT '获得奖金',
  `bonus` int(255) NOT NULL COMMENT '当期奖金',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 70 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for punch
-- ----------------------------
DROP TABLE IF EXISTS `punch`;
CREATE TABLE `punch`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `punch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '打卡名称',
  `punch_time` date NOT NULL,
  `punch_category` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '1:训练|2:比赛',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '训练项目|比赛名称',
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户头像',
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_anonymous` tinyint(4) NOT NULL COMMENT '1:不匿名|-1:匿名',
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '照片地址',
  `rewards` int(11) NOT NULL DEFAULT 0 COMMENT '被打赏次数',
  `rewards_money` int(11) NOT NULL COMMENT '被打赏总金额',
  `comments` int(11) NOT NULL DEFAULT 0 COMMENT '被评论次数',
  `likes` int(11) NOT NULL DEFAULT 0 COMMENT '被点赞次数',
  `stakes` decimal(4, 0) NOT NULL DEFAULT 0 COMMENT '总打金额',
  `status` tinyint(4) NOT NULL COMMENT '0:未支付|1:正常',
  `month_str` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '201805',
  `date_str` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '20180503',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '打卡表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for punch_comment
-- ----------------------------
DROP TABLE IF EXISTS `punch_comment`;
CREATE TABLE `punch_comment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT ' ',
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `punch_id` int(11) NOT NULL,
  `punch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常评论|-1:被删除',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_Time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '打卡评论表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for punch_likes
-- ----------------------------
DROP TABLE IF EXISTS `punch_likes`;
CREATE TABLE `punch_likes`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `article` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '是否点赞1:点赞|-1:取消点赞',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '打卡点赞表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rebate
-- ----------------------------
DROP TABLE IF EXISTS `rebate`;
CREATE TABLE `rebate`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL COMMENT '获得佣金的人',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sid` int(10) NOT NULL COMMENT 'member的下线id',
  `s_member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'member的下线',
  `salary` decimal(8, 2) NOT NULL COMMENT '分成金额',
  `score` decimal(8, 2) NOT NULL,
  `salary_id` int(10) NOT NULL,
  `tier` tinyint(4) NOT NULL COMMENT '第几层级下线分成',
  `datemonth` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '结算年月',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 84 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '收入提成' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rebate_hp
-- ----------------------------
DROP TABLE IF EXISTS `rebate_hp`;
CREATE TABLE `rebate_hp`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会员',
  `sid` int(11) NOT NULL COMMENT '下线会员id',
  `s_member` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '下线会员',
  `tier` int(11) NOT NULL COMMENT '下线层级',
  `bill_id` int(11) NOT NULL COMMENT '订单bill_id',
  `bill_order` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `rebate_hp` int(11) NOT NULL DEFAULT 0 COMMENT '返利hp数值',
  `paymoney` decimal(8, 2) NOT NULL COMMENT '消费金额',
  `status` int(11) NOT NULL COMMENT '状态1:正常|0:无效',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'HP业绩返利' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for rebate_score
-- ----------------------------
DROP TABLE IF EXISTS `rebate_score`;
CREATE TABLE `rebate_score`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会员',
  `sid` int(11) NOT NULL COMMENT '下线会员id',
  `s_member` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '下线会员',
  `tier` int(11) NOT NULL COMMENT '下线层级',
  `bill_id` int(11) NOT NULL COMMENT '订单bill_id',
  `bill_order` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `rebate_score` int(11) NOT NULL DEFAULT 0 COMMENT '返利积分数值',
  `paymoney` decimal(8, 2) NOT NULL COMMENT '消费金额',
  `status` int(11) NOT NULL COMMENT '状态1:正常|0:无效',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '积分返利' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for recruitment
-- ----------------------------
DROP TABLE IF EXISTS `recruitment`;
CREATE TABLE `recruitment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `recruitment` varchar(240) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `recruitment_type` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '招募类型',
  `recruit_number` tinyint(4) NOT NULL DEFAULT 1 COMMENT '招募人数',
  `recruitment_des` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '招募简介',
  `requirement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '招募要求',
  `organization_type` tinyint(4) NOT NULL COMMENT '1:训练营|2:校园|3:球队',
  `organization_id` int(10) NOT NULL,
  `organization` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `min` int(10) NOT NULL DEFAULT 0 COMMENT '最小薪酬',
  `max` int(10) NOT NULL DEFAULT 0 COMMENT '最大薪酬',
  `deadline` int(10) NOT NULL,
  `province` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `area` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `contact` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系人',
  `contact_id` int(10) NOT NULL COMMENT '联系人的member_id',
  `telephone` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系电话',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `participator` tinyint(4) NOT NULL COMMENT '报名人数',
  `is_max` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|-1:满人',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:上架',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for recruitment_member
-- ----------------------------
DROP TABLE IF EXISTS `recruitment_member`;
CREATE TABLE `recruitment_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `recruitment` varchar(240) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `recruitment_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `linkman` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系人',
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系电话',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:正常|2:申请加入|3:拒绝',
  `remarks` varchar(240) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for referee
-- ----------------------------
DROP TABLE IF EXISTS `referee`;
CREATE TABLE `referee`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `referee` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '裁判名称',
  `sex` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:男:2女',
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'member名',
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接单城市',
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接单省份',
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '接单地区',
  `appearance_fee` int(11) NOT NULL DEFAULT 0 COMMENT '出场费',
  `star` int(11) NOT NULL DEFAULT 0 COMMENT '评分总分数',
  `star_num` int(11) NOT NULL DEFAULT 0 COMMENT '评分次数',
  `level` int(10) NOT NULL DEFAULT 0 COMMENT '等级',
  `total_played` int(10) NOT NULL COMMENT '出场次数',
  `referee_year` int(11) NOT NULL DEFAULT 0 COMMENT '执裁经验年数',
  `experience` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '经验描述',
  `introduction` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图文介绍',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'remarks',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `portraits` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '肖像',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '个人宣言',
  `accept_rand_match` int(11) NOT NULL DEFAULT 0 COMMENT '接受系统安排比赛',
  `status` tinyint(4) NOT NULL COMMENT '0:未完善信息|1:正常|2:不通过|-1:禁用',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '裁判员' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for referee_comment
-- ----------------------------
DROP TABLE IF EXISTS `referee_comment`;
CREATE TABLE `referee_comment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `referee_id` int(10) NOT NULL,
  `referee` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `comment` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评论内容',
  `attitude` decimal(4, 1) NOT NULL COMMENT '态度得分,满分5分',
  `profession` decimal(4, 1) NOT NULL COMMENT '专业得分',
  `teaching_attitude` decimal(4, 1) NOT NULL COMMENT '教学态度得分',
  `teaching_quality` decimal(4, 1) NOT NULL COMMENT '教学质量得分',
  `appearance` decimal(4, 1) NOT NULL COMMENT '仪容仪表',
  `anonymous` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:匿名|1:实名',
  `delete_time` int(10) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for refund
-- ----------------------------
DROP TABLE IF EXISTS `refund`;
CREATE TABLE `refund`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `bill_order` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rebate_type` tinyint(4) NOT NULL DEFAULT 2 COMMENT '训练营的类型',
  `refund_rebate` decimal(6, 4) NOT NULL DEFAULT 0.1000 COMMENT '训练营的退款手续费',
  `total` tinyint(4) NOT NULL DEFAULT 0 COMMENT '退款的商品数量',
  `refund_fee` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '退款手续费',
  `refundamount` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '申请退款金额',
  `refund` decimal(8, 2) NOT NULL COMMENT '实际退款金额',
  `refund_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '退款方式:1平台原路退回|2:银行转账|3:现金退回|4:支付宝退款|5:微信退款|6:其他',
  `reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '退款理由',
  `student_id` int(11) NOT NULL COMMENT '退款学生的id',
  `student` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `process_id` int(11) NOT NULL COMMENT '操作人id',
  `process` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作人',
  `process_time` int(11) NOT NULL COMMENT '操作时间',
  `cancel_time` int(11) NOT NULL COMMENT '撤销时间',
  `reject_time` int(11) NOT NULL COMMENT '拒绝时间',
  `agree_time` int(11) NOT NULL COMMENT '同意时间',
  `finish_time` int(11) NOT NULL COMMENT '到账时间',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态:-2:已撤销|-1:已拒绝|1:申请中|2:已同意|3:已打款',
  `remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `image_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '退款凭证图片路径',
  `recipient_account_number` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收款人账号',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_Time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for salary_buffer
-- ----------------------------
DROP TABLE IF EXISTS `salary_buffer`;
CREATE TABLE `salary_buffer`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for salary_in
-- ----------------------------
DROP TABLE IF EXISTS `salary_in`;
CREATE TABLE `salary_in`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary` int(11) NOT NULL COMMENT '收入金额',
  `push_salary` int(11) NOT NULL DEFAULT 0 COMMENT '收入提成',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `realname` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_type` int(11) NOT NULL COMMENT '会员身份5:营主|4主教练|3助教',
  `pid` int(10) NOT NULL COMMENT '推荐人member_id',
  `level` tinyint(4) NOT NULL COMMENT '用户当前等级',
  `schedule_id` int(11) NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程',
  `grade_id` int(10) NOT NULL,
  `grade` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `students` tinyint(4) NOT NULL DEFAULT 0 COMMENT '学生总数',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态1:成功|0:失败',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '系统备注',
  `has_rebate` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否已会员分成',
  `schedule_time` int(11) NOT NULL COMMENT '课时上课时间',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '收入类型1:教学',
  `create_time` int(10) NOT NULL COMMENT '支付时间',
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3778 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统发放教练佣金' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for salary_out
-- ----------------------------
DROP TABLE IF EXISTS `salary_out`;
CREATE TABLE `salary_out`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary` decimal(8, 2) NOT NULL COMMENT '佣金',
  `tid` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '交易单号',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `realname` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名',
  `telephone` bigint(11) NOT NULL,
  `ident` bigint(20) NOT NULL COMMENT '身份证号',
  `openid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bank_card` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '银行卡号',
  `bank` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号类型,如农业银行|支付宝',
  `fee` decimal(6, 2) NOT NULL COMMENT '手续费',
  `pay_time` int(10) NOT NULL COMMENT '支付时间',
  `bank_type` tinyint(4) NOT NULL COMMENT '1:银行卡|2:支付宝',
  `is_pay` tinyint(4) NOT NULL DEFAULT 0,
  `buffer` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '冻结资金',
  `s_balance` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '当前余额',
  `e_balance` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '数据后余额',
  `callback_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付回调',
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:申请中|1:已支付|2:取消|-1:对冲',
  `update_time` int(11) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '佣金提现申请' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for schedule
-- ----------------------------
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL COMMENT '所属训练营',
  `camp` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练营',
  `lesson` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程名称',
  `lesson_id` int(10) NOT NULL COMMENT '课程id',
  `grade` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级',
  `grade_id` int(10) NOT NULL COMMENT '班级id',
  `grade_category_id` int(10) NOT NULL,
  `grade_category` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `teacher` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班主任',
  `teacher_id` int(10) NOT NULL COMMENT 'member表id',
  `leader_id` int(11) NOT NULL COMMENT '对应member表,领队id',
  `leader` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '领队',
  `coach` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教练',
  `coach_id` int(10) NOT NULL COMMENT 'member表id',
  `students` int(10) NOT NULL COMMENT '上课学生总数',
  `expstudent_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '序列化体验生集合',
  `student_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '序列化学生名字集合',
  `assistant_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '序列化',
  `assistant` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '助教,序列化',
  `cost` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '课程单价',
  `coach_salary` int(11) NOT NULL DEFAULT 0 COMMENT '主教练底薪',
  `s_coach_salary` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '教练总薪资',
  `assistant_salary` int(11) NOT NULL DEFAULT 0 COMMENT '助教底薪',
  `s_assistant_salary` decimal(10, 2) NOT NULL DEFAULT 0.00 COMMENT '助教总薪资',
  `salary_base` int(11) NOT NULL DEFAULT 0,
  `leave_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ids',
  `leave` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '请假人员总数',
  `plan_id` int(10) NOT NULL COMMENT 'id',
  `plan` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '教案',
  `exercise` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lesson_time` int(10) NOT NULL COMMENT '上课时间,2017-10-12 18:53:16的时间戳',
  `cover` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课时封面',
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认为课程地址',
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认为课程地址',
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认为课程地址',
  `court_id` int(10) NOT NULL,
  `court` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认为课程地址',
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认为课程地址',
  `rent` decimal(6, 2) NOT NULL COMMENT '场地租金',
  `star` decimal(4, 1) NOT NULL DEFAULT 20.0 COMMENT '评价平均分,满分20',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `media_ids` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `media_urls` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_school` tinyint(4) NOT NULL DEFAULT -1 COMMENT '1:校园版|-1:正常课程',
  `status` int(11) NOT NULL DEFAULT -1 COMMENT '1:正常|-1:草稿或未审核',
  `is_settle` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:已结算收入|0:未结算',
  `schedule_income` int(11) NOT NULL DEFAULT 0 COMMENT '课时总价',
  `questions` int(11) NOT NULL DEFAULT 0 COMMENT '课时疑问反馈数,有值不能进入课时结算',
  `can_settle_date` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '默认可结算日期(审核课时时间相隔1天后)',
  `finish_settle_time` int(11) NULL DEFAULT NULL COMMENT '完成结算时间戳',
  `rebate_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:第一种结算方式|2:第二种结算方式',
  `schedule_rebate` decimal(4, 2) NOT NULL DEFAULT 0.10 COMMENT '平台分成,跟camp表一致',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 854 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for schedule_comment
-- ----------------------------
DROP TABLE IF EXISTS `schedule_comment`;
CREATE TABLE `schedule_comment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `schedule_id` int(10) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `camp_id` int(11) NOT NULL DEFAULT 0,
  `coach_id` int(10) NOT NULL,
  `coach` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会员头像',
  `comment` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '评价内容',
  `score_item1` int(11) NOT NULL DEFAULT 5 COMMENT '评价项目1得分',
  `score_item2` int(11) NOT NULL DEFAULT 5 COMMENT '评价项目2得分',
  `score_item3` int(11) NOT NULL DEFAULT 5 COMMENT '评价项目3得分',
  `score_item4` int(11) NOT NULL DEFAULT 5 COMMENT '评价项目4得分',
  `anonymous` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0:匿名|1:公开',
  `star` int(11) NOT NULL DEFAULT 20 COMMENT '评价总分,总满分20',
  `avg_star` int(11) NOT NULL DEFAULT 0 COMMENT '评价均分:评价总分/4',
  `update_time` int(11) NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for schedule_gift_student
-- ----------------------------
DROP TABLE IF EXISTS `schedule_gift_student`;
CREATE TABLE `schedule_gift_student`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会员id',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `student` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生',
  `student_id` int(11) NOT NULL COMMENT '学生id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练营',
  `camp_id` int(11) NOT NULL COMMENT '训练营id',
  `lesson_id` int(11) NOT NULL COMMENT '课程id',
  `lesson` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程',
  `grade_id` int(11) NOT NULL COMMENT '班级id',
  `grade` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级',
  `gift_schedule` int(11) NOT NULL COMMENT '被赠送数量',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '状态1:成功|0:未操作',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 161 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for schedule_giftbuy
-- ----------------------------
DROP TABLE IF EXISTS `schedule_giftbuy`;
CREATE TABLE `schedule_giftbuy`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL DEFAULT 0 COMMENT '训练营id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '训练营',
  `lesson_id` int(11) NOT NULL DEFAULT 0 COMMENT '课程id',
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '课程',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员',
  `quantity` int(11) NOT NULL DEFAULT 0 COMMENT '购买数量',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '赠送课时购买记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for schedule_giftrecord
-- ----------------------------
DROP TABLE IF EXISTS `schedule_giftrecord`;
CREATE TABLE `schedule_giftrecord`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '操作的会员id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员',
  `camp_id` int(11) NOT NULL DEFAULT 0 COMMENT '训练营id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '训练营',
  `lesson_id` int(11) NOT NULL DEFAULT 0 COMMENT '课程id',
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '课程',
  `grade_id` int(11) NOT NULL DEFAULT 0 COMMENT '班级id',
  `grade` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '班级',
  `student_num` int(11) NOT NULL DEFAULT 0 COMMENT '赠送人数',
  `student_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '赠送学员名单',
  `gift_schedule` int(11) NOT NULL DEFAULT 0 COMMENT '人均赠送课时数',
  `remarks` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注留言',
  `system_remarks` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '系统备注',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态1:成功|0:未操作',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 120 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '课时赠送记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for schedule_media
-- ----------------------------
DROP TABLE IF EXISTS `schedule_media`;
CREATE TABLE `schedule_media`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL COMMENT '对应student_id或者coach_id或者班主任id',
  `schedule` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for schedule_member
-- ----------------------------
DROP TABLE IF EXISTS `schedule_member`;
CREATE TABLE `schedule_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL,
  `schedule` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '(班级名称)',
  `camp_id` int(10) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '训练营',
  `lesson_id` int(11) NOT NULL COMMENT '课程id',
  `lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程名',
  `grade_id` int(11) NOT NULL COMMENT '班级id',
  `grade` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级名称',
  `user_id` int(10) NOT NULL COMMENT '如果身份是student,则对应student_id,coach->coach_id',
  `user` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL COMMENT 'member表id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_school` tinyint(4) NOT NULL DEFAULT -1 COMMENT '1:校园版|-1:正常课程',
  `is_transfer` int(11) NOT NULL DEFAULT 0 COMMENT '1拼课学员|0本班级学员',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:学生|2:教练;如果是1,member_id为student表的id',
  `status` int(11) NOT NULL DEFAULT -1 COMMENT '-1:无效未结算数据|1:有效已结算数据',
  `schedule_time` int(10) NOT NULL COMMENT '上课时间',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5348 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '课时-会员关系' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for score
-- ----------------------------
DROP TABLE IF EXISTS `score`;
CREATE TABLE `score`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `score` int(10) NOT NULL,
  `score_des` varchar(240) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '积分说明:订单积分|活动积分|xxx赠送积分',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '积分记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sells
-- ----------------------------
DROP TABLE IF EXISTS `sells`;
CREATE TABLE `sells`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary` decimal(8, 2) NOT NULL,
  `score` int(10) NOT NULL,
  `goods_id` int(10) NOT NULL,
  `goods` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `goods_quantity` int(10) NOT NULL COMMENT '商品数量',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商品销售分红收入' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for setting
-- ----------------------------
DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sitename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `memberlevel1` int(10) NOT NULL COMMENT '升级到等级1所需积分',
  `memberlevel2` int(10) NOT NULL COMMENT '升级到等级2所需积分',
  `memberlevel3` int(10) NOT NULL,
  `coachlevel1` int(10) NOT NULL DEFAULT 10 COMMENT '教练等级1所需课流量',
  `coachlevel2` int(10) NOT NULL DEFAULT 50,
  `coachlevel3` int(10) NOT NULL DEFAULT 100,
  `coachlevel4` int(10) NOT NULL DEFAULT 200,
  `coachlevel5` int(10) NOT NULL DEFAULT 350,
  `coachlevel6` int(10) NOT NULL DEFAULT 750,
  `coachlevel7` int(10) NOT NULL DEFAULT 1000,
  `coachlevel8` int(10) NOT NULL DEFAULT 1500,
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '关键词',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '大热篮球',
  `footer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'copyright@2016,备案111',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'HOT',
  `wxappid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wxsecret` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'logo',
  `banner` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '序列化  a:3:{i:0;s:3:\"url1\";i:1;s:5:\"url2\";i:2;s:5:\"url3\";}',
  `lrss` int(10) NOT NULL COMMENT '上一节课平台奖励积分',
  `lrcs` int(10) NOT NULL COMMENT 'lesion_return_coach_score',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:不启用|1:启用',
  `coachlevel1award` int(10) NOT NULL COMMENT '升级到等级1给予的奖励,单位:分',
  `coachlevel2award` int(10) NOT NULL,
  `rebate` decimal(6, 2) NOT NULL DEFAULT 0.05 COMMENT '每一级用户抽取提成:5%',
  `sysrebate` decimal(6, 2) NOT NULL DEFAULT 0.25 COMMENT '平台抽取提成',
  `rebate2` decimal(6, 2) NOT NULL DEFAULT 0.03 COMMENT '第二阶级人头佣金',
  `starrebate` decimal(6, 2) NOT NULL DEFAULT 0.25 COMMENT '评价分扣减比例,评分满分得到全部佣金0.25,评分满分为100分',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for smsverify
-- ----------------------------
DROP TABLE IF EXISTS `smsverify`;
CREATE TABLE `smsverify`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `phone` bigint(11) NOT NULL COMMENT '手机号码',
  `smscode` int(10) NOT NULL COMMENT '短信验证码',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '短信内容',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `use` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '验证码使用场景,存中文',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态:0未使用|1已使用|2已失效',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 988 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '发送短信' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对应member表的昵称',
  `student` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学生姓名',
  `student_sex` int(11) NOT NULL DEFAULT 1 COMMENT '学员性别:1男|2女|3未知',
  `openid` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `yearsexp` int(11) NOT NULL DEFAULT 0 COMMENT '学生球龄',
  `student_birthday` date NOT NULL,
  `parent_id` int(10) NOT NULL COMMENT '父母id',
  `parent` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '家长姓名',
  `student_avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/static/default/avatar.png',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系电话',
  `emergency_telephone` bigint(11) NOT NULL COMMENT '紧急电话',
  `color` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `school` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学校',
  `student_charater` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '性格特点',
  `student_weight` decimal(8, 2) NOT NULL COMMENT '单位kg',
  `student_height` decimal(8, 2) NOT NULL COMMENT '学生身高单位cm',
  `student_shoe_code` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '鞋码',
  `remarks` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `total_lesson` int(10) NOT NULL DEFAULT 0 COMMENT '全部课程',
  `finished_lesson` int(10) NOT NULL DEFAULT 0 COMMENT '已上课程',
  `total_schedule` int(10) NOT NULL DEFAULT 0,
  `finished_schedule` int(10) NOT NULL DEFAULT 0,
  `delete_time` int(10) NULL DEFAULT NULL,
  `student_province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所在地区:省',
  `student_city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所在地区:市',
  `student_area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所在地区:区',
  `create_time` int(10) NOT NULL COMMENT '学员注册时间',
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 440 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for study_interion
-- ----------------------------
DROP TABLE IF EXISTS `study_interion`;
CREATE TABLE `study_interion`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录信息的会员id',
  `member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `age` int(11) NOT NULL DEFAULT 0 COMMENT '年龄',
  `school` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学校',
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '具体地址',
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系电话',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '系统备注',
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `member_id`(`member_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '学习意向登记' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sys_income
-- ----------------------------
DROP TABLE IF EXISTS `sys_income`;
CREATE TABLE `sys_income`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `income` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `f_id` int(11) NOT NULL DEFAULT 1 COMMENT '外键id,比如output.id或者bill.id',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:订单收入|2:训练营提成收入',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `deelte_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for sys_output
-- ----------------------------
DROP TABLE IF EXISTS `sys_output`;
CREATE TABLE `sys_output`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `output` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `f_id` int(11) NOT NULL DEFAULT 1 COMMENT '外键id,比如income.id或者salary_in.id或者refund.id',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:训练营工资支出|2:训练营收入|3:课时版退费',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for system_award
-- ----------------------------
DROP TABLE IF EXISTS `system_award`;
CREATE TABLE `system_award`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary` decimal(8, 2) NOT NULL,
  `score` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '奖励类型:1等级|2:阶衔|3:其他',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统奖励记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tag
-- ----------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标签内容',
  `comment_type` int(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '使用评价类型:1球队|2会员|3教练|4训练营|5裁判员',
  `comment_num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'tag被评价次数统计',
  `last_recorder_id` int(11) NOT NULL DEFAULT 0 COMMENT '最后操作的平台管理员id',
  `last_recorder` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '最后操作的平台管理员',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态1:正常|-1下架',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '评论标签表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tag_comment
-- ----------------------------
DROP TABLE IF EXISTS `tag_comment`;
CREATE TABLE `tag_comment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_type` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '评论类型:1会员|2球队|3教练|4训练营|5裁判员',
  `commented` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '被评论的实体名称',
  `commented_id` int(10) NOT NULL DEFAULT 0 COMMENT '被评论的实体id',
  `commented_member_id` int(11) NOT NULL DEFAULT 0 COMMENT '被评论的会员id',
  `commented_member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '被评论的会员',
  `member_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发布评论的会员id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布评论的会员',
  `member_avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布评论的会员头像',
  `tag_id` int(11) NOT NULL COMMENT '提交评论标签id',
  `tag` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '提交评论标签名',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '评论标签记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team
-- ----------------------------
DROP TABLE IF EXISTS `team`;
CREATE TABLE `team`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(10) UNSIGNED NOT NULL COMMENT '创建者会员id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建者会员',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球队名称',
  `type` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '球队类型(具体内容看model文件)',
  `camp_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '训练营id type=1即青少年训练营才有值',
  `camp` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '训练营',
  `province` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球队所在地区-省',
  `city` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球队所在地区-市',
  `area` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球队所在地区-区',
  `court_id` int(11) NOT NULL COMMENT '场地id',
  `court` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地名称',
  `court_lng` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地定位坐标lng',
  `court_lat` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '场地定位坐标lat',
  `home_color` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '主场颜色(中文字)',
  `home_color_style` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '主场颜色(英文,用于显示样式)',
  `away_color` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '客场颜色(中文字)',
  `away_color_style` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '客场颜色(英文,用于显示样式)',
  `colors` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '球衣颜色(json格式:color中文字,color_style颜色样式英文)',
  `leader_id` int(10) NOT NULL DEFAULT 0 COMMENT '领队会员id',
  `leader` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '领队会员',
  `manager_id` int(11) NOT NULL DEFAULT 0 COMMENT '经理会员id',
  `manager` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '经理会员',
  `captain_id` int(10) NOT NULL DEFAULT 0 COMMENT '队长会员id',
  `captain` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '队长会员',
  `vice_captain_id` int(11) NOT NULL DEFAULT 0 COMMENT '副队长会员id',
  `vice_captain` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '副队长会员',
  `charater` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '球队特点',
  `avg_age` int(11) NOT NULL DEFAULT 0 COMMENT '平均年龄',
  `avg_height` int(11) NOT NULL DEFAULT 0 COMMENT '平均身高(cm)',
  `avg_weight` int(11) NOT NULL DEFAULT 0 COMMENT '平均体重(kg)',
  `descri` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球队简介',
  `introduce` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '球队介绍',
  `cover` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '球队封面图',
  `logo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '球队logo',
  `member_num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '队员数',
  `match_num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '参加比赛场次数',
  `match_win` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '比赛胜场次数',
  `match_lose` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '比赛输场次数',
  `event_num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '球队活动数',
  `fans_num` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '粉丝数',
  `statis_num` int(11) NOT NULL DEFAULT 0 COMMENT '录入比赛统计数据次数',
  `honor_num` int(11) NOT NULL DEFAULT 0 COMMENT '球队荣誉数',
  `regulation` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球队章程',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1正常(上架)|-1下架',
  `integral` int(11) NOT NULL DEFAULT 0 COMMENT '球队积分',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '最后一次更新时间',
  `delete_time` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '球队表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_comment
-- ----------------------------
DROP TABLE IF EXISTS `team_comment`;
CREATE TABLE `team_comment`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_type` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '评论类型:1球队|2球队活动|3球队比赛|4球员|5球队荣誉',
  `commented` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '被评论的实体名称',
  `commented_id` int(10) NOT NULL COMMENT '被评论的实体id',
  `commented_member_id` int(11) NOT NULL DEFAULT 0 COMMENT '被评论的会员ID',
  `commented_member` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '被评论的会员',
  `team_id` int(11) NOT NULL COMMENT '被评论实体所属team_id',
  `member_id` int(10) NOT NULL DEFAULT 0 COMMENT '发布评论的会员id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布评论的会员',
  `member_avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布评论的会员头像',
  `comment` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文字评论内容',
  `comment_time` int(11) NULL DEFAULT NULL COMMENT '发表文字评论时间',
  `thumbsup` tinyint(4) NOT NULL DEFAULT 0 COMMENT '点赞|1点赞|0无点赞',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '球队模块评论记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_event
-- ----------------------------
DROP TABLE IF EXISTS `team_event`;
CREATE TABLE `team_event`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(10) UNSIGNED NOT NULL COMMENT '球队id',
  `team` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球队名',
  `member_id` int(11) NOT NULL COMMENT '活动发布会员id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '活动发布会员',
  `event` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '活动标题',
  `event_type` int(11) NOT NULL COMMENT '活动类型:内容看model',
  `is_free` int(11) NOT NULL DEFAULT 1 COMMENT '1免费|2收费',
  `price` int(11) NOT NULL DEFAULT 0 COMMENT '活动价格',
  `score` int(11) NOT NULL DEFAULT 0 COMMENT '活动花费积分',
  `finance` int(11) NOT NULL COMMENT '收费结算人',
  `finance_id` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收费结算人会员id',
  `start_time` int(11) NULL DEFAULT NULL COMMENT '活动开始时间',
  `end_time` int(11) NULL DEFAULT NULL COMMENT '活动截止时间',
  `event_time` int(11) NULL DEFAULT NULL COMMENT '活动举行时间',
  `reg_number` int(11) NOT NULL DEFAULT 0 COMMENT '报名人数',
  `province` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所在地区-省',
  `city` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所在地区-市',
  `area` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '所在地区-区',
  `location` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '具体地址',
  `max` int(11) NOT NULL DEFAULT 1 COMMENT '最大参与数',
  `min` int(11) NOT NULL DEFAULT 1 COMMENT '最小参与数',
  `event_des` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '活动简介',
  `contact` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系人名字',
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '联系电话',
  `cover` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面图',
  `remarks` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注信息',
  `is_max` int(11) NOT NULL DEFAULT 1 COMMENT '1未满人|-1已满人',
  `is_finished` int(11) NOT NULL DEFAULT -1 COMMENT '-1未完成|1已完成',
  `send_message` tinyint(4) NOT NULL DEFAULT 0 COMMENT '发布通知1:通知|0不通知',
  `album` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '活动相册(json格式)',
  `hot` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '热门:1热门|0普通',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1正常|-1下架',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '球队活动表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_event_member
-- ----------------------------
DROP TABLE IF EXISTS `team_event_member`;
CREATE TABLE `team_event_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL COMMENT '活动id',
  `event` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员名',
  `student_id` int(11) NOT NULL COMMENT '会员学生id',
  `student` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员学生名',
  `avatar` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员/学生头像',
  `contact_tel` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系人电话',
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系人',
  `is_pay` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1已缴费(报名免费活动也是1)|2未缴费',
  `is_sign` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0未签到|1已签到',
  `is_apply` int(11) NULL DEFAULT 0 COMMENT '报名标识:1报名|0默认',
  `is_attend` int(11) NULL DEFAULT 0 COMMENT '出席标识:1出席|0默认',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1已报名2已签到|3已参与|-1退出',
  `remarks` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NULL DEFAULT NULL COMMENT '软删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '球队活动-会员关联' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_honor
-- ----------------------------
DROP TABLE IF EXISTS `team_honor`;
CREATE TABLE `team_honor`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '奖项名称',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '奖项赛事名称',
  `match_id` int(11) NOT NULL DEFAULT 0 COMMENT '奖项赛事id(赛事名称非系统数据,值为-1)',
  `award_org` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '授奖单位(可以是联赛组织)',
  `award_org_id` int(11) NOT NULL DEFAULT 0 COMMENT '授奖单位id(授奖单位非系统数据,值为-1)',
  `honor_time` int(11) NOT NULL COMMENT '授奖时间(时间戳)',
  `author_team_id` int(11) NOT NULL DEFAULT 0 COMMENT '荣誉记录发布球队id',
  `author_team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '荣誉记录发布球队',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '操作数据的会员id',
  `member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '操作数据的会员名',
  `prize_team_id` int(11) NOT NULL DEFAULT 0 COMMENT '授奖球队id',
  `prize_team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '授奖球队',
  `prize_team_member` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '授奖球员名单json(可多个)',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '图片',
  `introduction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '图文介绍',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '球队荣誉奖项记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_honor_member
-- ----------------------------
DROP TABLE IF EXISTS `team_honor_member`;
CREATE TABLE `team_honor_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_honor_id` int(11) NOT NULL COMMENT '球队荣誉id',
  `team_honor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球队荣誉名',
  `match` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '比赛名',
  `match_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛id',
  `award_org` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '授奖单位',
  `award_org_id` int(11) NOT NULL DEFAULT 0 COMMENT '授奖单位id',
  `honor_time` int(11) NOT NULL DEFAULT 0 COMMENT '授奖时间',
  `team_id` int(11) NOT NULL COMMENT '球员所在球队id',
  `team` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球队所在球队',
  `team_member_id` int(11) NOT NULL COMMENT '球队成员team_member_id',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '球员名',
  `member_id` int(11) NOT NULL COMMENT '会员id(跟team_member的member_id)',
  `member` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '会员(跟team_member的member)',
  `status` int(11) NOT NULL COMMENT '状态:1正常|-1无效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_UNIQUE`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '球队荣誉-会员关系' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_member
-- ----------------------------
DROP TABLE IF EXISTS `team_member`;
CREATE TABLE `team_member`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(10) UNSIGNED NOT NULL COMMENT '球队id',
  `team` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球队名',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球员名字',
  `member_id` int(10) NOT NULL COMMENT '队员会员id',
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '队员会员',
  `student_id` int(11) NOT NULL COMMENT '队员会员学生id',
  `student` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '队员会员学生',
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '队员手机号',
  `sex` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '队员性别',
  `avatar` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '队员头像',
  `yearsexp` int(10) NULL DEFAULT NULL COMMENT '开始打球年份(计算球龄)',
  `birthday` date NOT NULL COMMENT '队员生日',
  `age` int(11) NOT NULL COMMENT '队员年龄',
  `height` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '队员身高',
  `weight` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '队员体重',
  `shoe_size` int(11) NOT NULL COMMENT '鞋码(欧队员码)',
  `position` int(11) NOT NULL DEFAULT 0 COMMENT '场上位置(控球后卫等)',
  `number` int(10) NULL DEFAULT NULL COMMENT '球衣号码',
  `match_num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '比赛出场次数',
  `introduction` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '图文介绍',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '个人宣言',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1在队|-1离队|0加入申请未通过|-2会员未关联',
  `leave_time` int(11) NULL DEFAULT NULL COMMENT '离队时间',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 90 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '球队-会员关系' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_member_role
-- ----------------------------
DROP TABLE IF EXISTS `team_member_role`;
CREATE TABLE `team_member_role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(10) UNSIGNED NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '会员名',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '球员名',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '球队角色:1后勤|2副队长|3队长|4教练|5经理|6领队',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态:1正常|-1失效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '会员-球队角色一对多关联' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_message
-- ----------------------------
DROP TABLE IF EXISTS `team_message`;
CREATE TABLE `team_message`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(10) UNSIGNED NOT NULL COMMENT '球队id',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '信息标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '信息内容',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '球队公告消息' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for team_rank
-- ----------------------------
DROP TABLE IF EXISTS `team_rank`;
CREATE TABLE `team_rank`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL DEFAULT 0 COMMENT '球队id',
  `team` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '球队名',
  `match_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛id',
  `match` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '比赛名',
  `match_type` int(11) NOT NULL COMMENT '比赛类型',
  `match_record_id` int(11) NOT NULL DEFAULT 0 COMMENT '比赛战机id',
  `score` int(11) NOT NULL DEFAULT 0 COMMENT '获取积分数',
  `system_remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '系统备注',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '球队-比赛积分' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for template_platform
-- ----------------------------
DROP TABLE IF EXISTS `template_platform`;
CREATE TABLE `template_platform`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `template` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板名称',
  `template_id` int(11) NOT NULL COMMENT '模板ID',
  `platform` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `platform_id` int(11) NOT NULL,
  `t_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对应的模板id,如gXXoLU9ccggzyEgKrvDZoNYNnX71k7-A6gXHRAPU1qs',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板的{{remark.DATA}}',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课程分类名',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图片地址',
  `sort` tinyint(2) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL COMMENT '状态:1正常|-1禁用|0默认',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '父级id',
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 152 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '课程分类' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for transfer_lesson
-- ----------------------------
DROP TABLE IF EXISTS `transfer_lesson`;
CREATE TABLE `transfer_lesson`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `original_lesson_id` int(60) NOT NULL COMMENT '旧课程_id',
  `original_lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '旧课程',
  `new_lesson_id` int(11) NOT NULL,
  `new_lesson` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '新课程',
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `camp_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rest_schedule` tinyint(4) NOT NULL,
  `total_schedule` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1,
  `sys_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hamal` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '操作人',
  `hamal_id` int(11) NOT NULL COMMENT '操作人 member_id',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '转课关系表' ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
