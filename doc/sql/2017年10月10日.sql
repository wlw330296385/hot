-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-10-10 16:29:47
-- 服务器版本： 10.1.23-MariaDB-9+deb9u1
-- PHP Version: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hot`
--
CREATE DATABASE IF NOT EXISTS `hot` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hot`;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `truename` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `avatar` varchar(200) NOT NULL COMMENT '头像',
  `telephone` bigint(20) DEFAULT NULL COMMENT '手机号',
  `stats` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1正常|0禁用',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `logintime` int(11) NOT NULL DEFAULT '0' COMMENT '登录次数',
  `lastlogin_at` int(11) NOT NULL COMMENT '最后登录时间',
  `lastlogin_ip` varchar(20) NOT NULL COMMENT '最后登录ip',
  `lastlogin_ua` varchar(200) NOT NULL DEFAULT '' COMMENT '最后登录ua',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `truename`, `email`, `avatar`, `telephone`, `stats`, `create_time`, `update_time`, `logintime`, `lastlogin_at`, `lastlogin_ip`, `lastlogin_ua`) VALUES
(1, 'admin', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', NULL, NULL, '/static/default/avatar.png', NULL, 1, 0, 0, 70, 1507184092, '58.60.127.150', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36');

-- --------------------------------------------------------

--
-- 表的结构 `bankcard`
--

DROP TABLE IF EXISTS `bankcard`;
CREATE TABLE IF NOT EXISTS `bankcard` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='个人金融账户,支付宝,银行卡';

-- --------------------------------------------------------

--
-- 表的结构 `bill`
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bill_order` varchar(20) NOT NULL COMMENT '订单号',
  `goods_id` int(10) NOT NULL COMMENT '1:对应lesson.id;|2:对应goods.id',
  `goods` varchar(210) NOT NULL,
  `total` tinyint(4) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `price` decimal(8,0) NOT NULL COMMENT '每节课的单价',
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `goods_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '商品类型 1:课程|2:活动',
  `goods_des` varchar(255) NOT NULL COMMENT '商品描述',
  `student_id` int(10) NOT NULL,
  `student` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `balance_pay` decimal(8,0) NOT NULL COMMENT '支付人民币',
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
  `refundamount` int(11) DEFAULT '0' COMMENT '申请退款金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `bill`
--

INSERT INTO `bill` (`id`, `bill_order`, `goods_id`, `goods`, `total`, `price`, `camp_id`, `camp`, `goods_type`, `goods_des`, `student_id`, `student`, `member_id`, `member`, `balance_pay`, `score_pay`, `remarks`, `pay_type`, `callback_str`, `is_pay`, `pay_time`, `update_time`, `create_time`, `delete_time`, `status`, `refundamount`) VALUES
(1, '1201709281131356649', 4, '周六上午十点低年级班', 15, '100', 2, '大热前海训练营', 1, '陈小准预约体验周六上午十点低年级班', 2, '陈小准', 6, 'legend', '0', 0, '无', '', '0', 1, 0, 1506569500, 1506569500, NULL, 1, 0),
(2, '1201709281132289231', 4, '周六上午十点低年级班', 15, '100', 2, '大热前海训练营', 1, '陈小准预约体验周六上午十点低年级班', 2, '陈小准', 6, 'legend', '0', 0, '无', '', '0', 1, 0, 1506569572, 1506569572, NULL, 1, 0),
(3, '1201710071347056265', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, 'Easychen 预约体验猴塞雷课程', 3, 'Easychen ', 13, 'Greeny', '0', 0, '无', '', '0', 1, 0, 1507355231, 1507355231, NULL, 1, 0),
(4, '1201710071349275266', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, 'Easychen 购买猴塞雷课程', 3, 'Easychen ', 13, 'Greeny', '100', 0, '无', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1507355398, 1507355398, NULL, 1, 0),
(5, '1201710091106464244', 4, '周六上午十点低年级班', 1, '100', 2, '大热前海训练营', 1, '123预约体验周六上午十点低年级班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507518508, 1507518508, NULL, 1, 0),
(6, '1201710091111163910', 4, '周六上午十点低年级班', 1, '100', 2, '大热前海训练营', 1, '123预约体验周六上午十点低年级班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507518677, 1507518677, NULL, 1, 0),
(7, '1201710091112263513', 4, '周六上午十点低年级班', 1, '100', 2, '大热前海训练营', 1, '123预约体验周六上午十点低年级班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507518749, 1507518749, NULL, 1, 0),
(8, '1201710091632015853', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507537926, 1507537926, NULL, 1, 0),
(9, '1201710091632015853', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507538100, 1507538100, NULL, 1, 0),
(10, '1201710091632015853', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507538154, 1507538154, NULL, 1, 0),
(11, '1201710091632015853', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507539082, 1507539082, NULL, 1, 0),
(12, '1201710091655298358', 6, '超级射手班', 1, '120', 4, '准行者训练营', 1, '123预约体验超级射手班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507539335, 1507539335, NULL, 1, 0),
(13, '1201710091659136879', 4, '周六上午十点低年级班', 1, '100', 2, '大热前海训练营', 1, '123预约体验周六上午十点低年级班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507539555, 1507539555, NULL, 1, 0),
(14, '1201710091720145464', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, '123预约体验猴塞雷课程', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507540816, 1507540816, NULL, 1, 0),
(15, '1201710091741026501', 2, '小学低年级初级班', 10, '1', 3, '齐天大热', 1, '123购买小学低年级初级班', 1, '123', 8, 'woo123', '10', 0, '无', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1507542080, 1507542080, NULL, 1, 0),
(16, '1201710091825539450', 6, '超级射手班', 1, '120', 4, '准行者训练营', 1, '123预约体验超级射手班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507544755, 1507544755, NULL, 1, 0),
(17, '1201710091826474260', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507544809, 1507544809, NULL, 1, 0),
(18, '1201710091830393947', 3, '超级控球手', 1, '120', 4, '准行者训练营', 1, '123预约体验超级控球手', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507545041, 1507545041, NULL, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `camp`
--

DROP TABLE IF EXISTS `camp`;
CREATE TABLE IF NOT EXISTS `camp` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `camp`
--

INSERT INTO `camp` (`id`, `camp`, `member_id`, `realname`, `max_member`, `total_coach`, `act_coach`, `total_member`, `act_member`, `total_lessons`, `finished_lessons`, `star`, `total_grade`, `act_grade`, `total_schedule`, `logo`, `camp_base`, `remarks`, `sys_remarks`, `location`, `province`, `city`, `area`, `camp_telephone`, `camp_email`, `type`, `banner`, `company`, `cert_id`, `hot`, `camp_introduction`, `balance`, `score`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '大热体适能中心', 2, '大热篮球2', 0, 0, 0, 2, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/09/59ca092820279.JPG', 0, '', '', '', '广东省', '深圳市', '南山区', '18565717133', '', 2, '/uploads/images/banner/2017/09/59ca0953d9cab.JPG', '大热总部', 0, 1, '大热室内训练', '0.00', 0, 1, 1506412380, 1506414363, NULL),
(2, '大热前海训练营', 3, '大热篮球1', 0, 0, 0, 1, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/09/59ca0937e193b.jpg', 0, '', '', '', '广东省', '深圳市', '南山区', '15820474733', '', 2, '/uploads/images/banner/2017/09/59ca099495b13.jpg', '大热总部', 0, 1, '欢迎加入大热篮球训练营', '0.00', 0, 1, 1506412380, 1506414356, NULL),
(3, '齐天大热', 1, '陈侯', 0, 0, 0, 2, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/09/59ca09d5916c4.jpg', 0, '', '', '深圳总部', '广东省', '深圳市', '南山区', '13823599611', '', 2, '/uploads/images/banner/2017/10/59d8e043195d6.jpg', '大热总部', 0, 1, '大热猴塞雷', '77.00', 0, 1, 1506412381, 1507385417, NULL),
(4, '准行者训练营', 6, '陈烈准', 0, 0, 0, 3, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/09/59ca142b31f86.JPG', 0, '', '', '', '广东省', '深圳市', '南山区', '13826505160', '', 0, '/uploads/images/banner/2017/09/59ca14360c76b.JPG', '', 0, 1, 'I believe I can fly!', '0.00', 0, 1, 1506415619, 1506422262, NULL),
(5, '荣光训练营', 7, '张伟荣', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/09/59cc5d0d7ab73.jpg', 0, '', '', '', '广东省', '深圳市', '福田区', '15018514302', '', 2, '/uploads/images/banner/2017/09/59cc5d126da55.jpg', '', 0, 1, '暂时没有', '0.00', 0, 1, 1506565273, 1507105258, NULL),
(6, '小丸子训练营', 9, '高艳', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 0, 0, '', 0, '', '', '', '广东省', '深圳市', '其它区', '13662270560', '', 2, '', '', 0, 1, '', '0.00', 0, 0, 1506577042, 1506577293, NULL),
(12, '伟霖训练营', 10, '刘伟霖', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/10/59d4b7cb82e85.png', 0, '', '', '', '广东省', '深圳市', '罗湖区', '13410599613', '', 0, '/uploads/images/banner/2017/10/59d4b7d9bbce2.png', '', 0, 0, '伟霖的训练营...', '0.00', 0, 1, 1507112718, 1507113352, NULL),
(9, '大热篮球俱乐部', 2, '大热篮球', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/09/59ce0f0bb2253.JPG', 0, '', '', '深圳南山阳光文体中心', '广东省', '深圳市', '南山区', '18565717133', '', 1, '/uploads/images/banner/2017/09/59ce0f1cd8156.JPG', '大热体育文化（深圳）有限公司', 0, 0, '', '0.00', 0, 0, 1506676445, 1506676631, NULL),
(10, '金刚狼训练营', 12, '吴光蔚', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/09/59ce29e07c91d.PNG', 0, '', '', '', '广东省', '深圳市', '南山区', '13684925727', '', 2, '/uploads/images/banner/2017/09/59ce29e6f06c0.PNG', '', 0, 0, '提升自己', '0.00', 0, 1, 1506683299, 1506685845, NULL),
(11, '+*', 5, '劉嘉興', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 0, 0, '/uploads/images/banner/2017/09/59ce4f91b3489.png', 0, '', '', '', '广东省', '深圳市', '南山区', '13418931599', '', 0, '', '', 0, 0, '', '0.00', 0, 0, 1506692995, 1506693042, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `camp_comment`
--

DROP TABLE IF EXISTS `camp_comment`;
CREATE TABLE IF NOT EXISTS `camp_comment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `camp_comment`
--

INSERT INTO `camp_comment` (`id`, `camp_id`, `camp`, `comment`, `member`, `member_id`, `avatar`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 4, '准行者训练营', '', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1506508653, 1506508653, NULL),
(2, 4, '准行者训练营', '', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1506508678, 1506508678, NULL),
(3, 4, '准行者训练营', '', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1506508880, 1506508880, NULL),
(4, 4, '准行者训练营', '', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1506508971, 1506508971, NULL),
(5, 4, '准行者训练营', '', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1506509103, 1506509103, NULL),
(6, 4, '准行者训练营', '234', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1506509243, 1506509243, NULL),
(7, 4, '准行者训练营', '试试', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1506509294, 1506509294, NULL),
(8, 3, '齐天大热', '很好,很好!!', 'woo123', 8, 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1506566435, 1506566435, NULL),
(9, 1, '大热体适能中心', '非常厉害的训练营!', 'woo123', 8, 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1506566466, 1506566466, NULL),
(10, 4, '准行者训练营', '我喜欢这个训练营', 'woo123', 8, 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1506566493, 1506566493, NULL),
(11, 2, '大热前海训练营', '我我我我我我我我...我了个去', 'woo123', 8, 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1506566511, 1506566511, NULL),
(12, 2, '大热前海训练营', '你你你', 'HoChen', 1, 'https://wx.qlogo.cn/mmopen/vi_32/SibkSPyDCsQgsldCSicKXvqPNPvb17ibRBGl7sEWGx9ZUXYjuIRavp1UDiaMGRyC0J57ulsAOxQCvn0eBhP8UXp4UA/0', 1506655726, 1506655726, NULL),
(13, 2, '大热前海训练营', '你你你', 'HoChen', 1, 'https://wx.qlogo.cn/mmopen/vi_32/SibkSPyDCsQgsldCSicKXvqPNPvb17ibRBGl7sEWGx9ZUXYjuIRavp1UDiaMGRyC0J57ulsAOxQCvn0eBhP8UXp4UA/0', 1506655778, 1506655778, NULL),
(15, 10, '金刚狼训练营', '你真帅', 'weilin666', 4, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJXZOE1LAocibpESZQmicYIiaV9xNgKdLRgdL4Hn7omXHdFTwqJTphdHFhGMKujX46B6icUJlfibOKx5pw/0', 1506739206, 1506739206, NULL),
(16, 5, '荣光训练营', '不错哦', 'wayen_z', 7, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJsb6yF8nF3I5eGmQT8zoRicAaF9QjfTbHwBofiaa5tIHUpRqMicicth5SW0I4L6pTbr6UDbGnqSZWPpQ/0', 1506740944, 1506740944, NULL),
(17, 3, '齐天大热', '哪里哪里', 'HoChen', 1, 'https://wx.qlogo.cn/mmopen/vi_32/SibkSPyDCsQgsldCSicKXvqPNPvb17ibRBGl7sEWGx9ZUXYjuIRavp1UDiaMGRyC0J57ulsAOxQCvn0eBhP8UXp4UA/0', 1507307147, 1507307147, NULL),
(18, 3, '齐天大热', 'cool', 'hot111', 11, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKJwIOoK7eq3g5cId6ic0tY0CjlYvib95yq8fOurvnGL5FqtEB1FIub1ygjHQ5DetTaYwExnaibudnFA/0', 1507350936, 1507350936, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `camp_member`
--

DROP TABLE IF EXISTS `camp_member`;
CREATE TABLE IF NOT EXISTS `camp_member` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:学生|2:教练|3:管理员|4:创建者|-1:粉丝',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:待审核|1:正常|2:退出|-1:被辞退|3:''已毕业''|-2:被拒绝',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='训练营身份权限表';

--
-- 转存表中的数据 `camp_member`
--

INSERT INTO `camp_member` (`id`, `camp_id`, `camp`, `member_id`, `member`, `remarks`, `type`, `status`, `create_time`, `delete_time`, `update_time`) VALUES
(1, 1, '大热体适能中心', 2, '大热篮球2', '创建训练营', 4, 1, 1506412380, NULL, 1506412380),
(2, 2, '大热前海训练营', 3, '大热篮球1', '创建训练营', 4, 1, 1506412380, NULL, 1506412380),
(3, 3, '齐天大热', 1, '陈侯', '创建训练营', 4, 1, 1506412381, NULL, 1506412381),
(4, 1, '大热体适能中心', 1, 'HoChen', '你好', -1, 1, 1506414072, NULL, 0),
(5, 2, '大热前海训练营', 2, 'Hot-basketball2', '粉丝', -1, 1, 1506414094, NULL, 0),
(6, 1, '大热体适能中心', 3, 'Hot Basketball 1', 'ho t', -1, 1, 1506414141, NULL, 0),
(7, 3, '齐天大热', 4, 'weilin666', '加入做教练', 2, 1, 1506414192, NULL, 1506414359),
(8, 2, '大热前海训练营', 4, 'weilin666', '加入做教练', 2, 1, 1506414206, NULL, 1506414379),
(9, 1, '大热体适能中心', 4, 'weilin666', '加入教练', 2, 1, 1506414220, NULL, 1506414603),
(10, 3, '齐天大热', 5, '123abc', '江河湖海', 2, 1, 1506414545, NULL, 0),
(11, 2, '大热前海训练营', 5, '123abc', '嘉兴', 2, 1, 1506414561, NULL, 0),
(12, 1, '大热体适能中心', 5, '123abc', '嘉兴', 2, 1, 1506414573, NULL, 0),
(13, 4, '准行者训练营', 6, '陈烈准', '创建训练营', 4, 1, 1506415619, NULL, 1506415619),
(14, 4, '准行者训练营', 4, 'weilin666', '加入教练', 2, 1, 1506422275, NULL, 1506572862),
(15, 4, '准行者训练营', 1, 'HoChen', '我', 3, 0, 1506502597, NULL, 0),
(16, 5, '荣光训练营', 7, '张伟荣', '创建训练营', 4, 1, 1506565273, NULL, 1506565273),
(17, 4, '准行者训练营', 8, 'woo123', '我要成为管理员', 3, 1, 1506566640, NULL, 0),
(18, 2, '大热前海训练营', 6, 'legend', '', 1, 1, 1506569500, NULL, 1506569500),
(19, 6, '小丸子训练营', 9, '高艳', '创建训练营', 4, 1, 1506577042, NULL, 1506577042),
(20, 2, '大热前海训练营', 1, 'HoChen', '我', 3, 1, 1506655861, NULL, 0),
(25, 9, '大热篮球俱乐部', 2, '大热篮球', '创建训练营', 4, 1, 1506676445, NULL, 1506676445),
(26, 10, '金刚狼训练营', 12, '吴光蔚', '创建训练营', 4, 1, 1506683299, NULL, 1506683299),
(27, 11, '+*', 5, '劉嘉興', '创建训练营', 4, 1, 1506692995, NULL, 1506692995),
(28, 10, '金刚狼训练营', 4, 'weilin666', '给我加入做教练吧', 2, 0, 1506739180, NULL, 0),
(29, 4, '准行者训练营', 7, 'wayen_z', '我要成为粉丝', -1, 1, 1506754252, NULL, 0),
(30, 12, '伟霖训练营', 10, '刘伟霖', '创建训练营', 4, 1, 1507112718, NULL, 1507112718),
(31, 3, '齐天大热', 11, 'hot111', 'Hi', 2, 0, 1507350804, NULL, 0),
(32, 3, '齐天大热', 13, 'Greeny', '', 1, 1, 1507355231, NULL, 1507355231),
(33, 2, '大热前海训练营', 8, 'woo123', '', 1, 1, 1507518508, NULL, 1507518508),
(34, 1, '大热体适能中心', 8, 'woo123', '', 1, 1, 1507538155, NULL, 1507538155),
(35, 4, '准行者训练营', 8, 'woo123', '', 1, 1, 1507539336, NULL, 1507539336),
(36, 3, '齐天大热', 8, 'woo123', '', 1, 1, 1507540817, NULL, 1507540817);

-- --------------------------------------------------------

--
-- 表的结构 `camp_power`
--

DROP TABLE IF EXISTS `camp_power`;
CREATE TABLE IF NOT EXISTS `camp_power` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `camp_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL COMMENT '角色名称',
  `coach` tinyint(4) NOT NULL DEFAULT '0' COMMENT '有教练权限就是1',
  `admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '管理员',
  `owner` tinyint(4) NOT NULL DEFAULT '0' COMMENT '拥有者',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员角色表';

-- --------------------------------------------------------

--
-- 表的结构 `cert`
--

DROP TABLE IF EXISTS `cert`;
CREATE TABLE IF NOT EXISTS `cert` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='证件表';

--
-- 转存表中的数据 `cert`
--

INSERT INTO `cert` (`id`, `camp_id`, `member_id`, `cert_no`, `cert_type`, `photo_positive`, `photo_back`, `portrait`, `status`, `create_time`, `update_time`) VALUES
(1, 0, 4, '440301199306022938', 1, '/uploads/images/cert/2017/09/59ca0dc87328d.jpg', '/uploads/images/cert/2017/09/59ca0dce39ce7.jpg', '', 0, 1506414074, 1506414074),
(2, 0, 4, '0', 3, '/uploads/images/cert/2017/09/59ca0dd4d4eec.jpg', '', '', 0, 1506414074, 1506414074),
(3, 3, 0, '', 4, '/uploads/images/cert/2017/09/59ca0e3ab8c92.jpg', '', '', 0, 1506414203, 1506414203),
(4, 3, 0, '1234567890', 1, '/uploads/images/cert/2017/09/59ca0e40d7a8e.jpg', '', '', 0, 1506414203, 1506414203),
(5, 3, 1, '1234567890', 1, '/uploads/images/cert/2017/09/59ca0e46a3505.jpg', '', '', 0, 1506414203, 1506414203),
(6, 3, 0, '', 0, '/uploads/images/cert/2017/09/59ca0e769ef9d.jpg', '', '', 0, 1506414203, 1506414203),
(7, 0, 5, '123456789123456789', 1, '/uploads/images/cert/2017/09/59ca0e79b8fe2.jpg', '/uploads/images/cert/2017/09/59ca0e859d4f1.jpg', '', 0, 1506414257, 1506414257),
(8, 0, 5, '0', 3, '/uploads/images/cert/2017/09/59ca0e9356cdf.jpg', '', '', 0, 1506414257, 1506414257),
(9, 1, 0, '', 4, '/uploads/images/cert/2017/09/59ca0e55f2c44.JPG', '', '', 0, 1506414275, 1506414275),
(10, 1, 0, '1', 1, '/uploads/images/cert/2017/09/59ca0e61391cd.JPG', '', '', 0, 1506414275, 1506414275),
(11, 1, 2, '1', 1, '/uploads/images/cert/2017/09/59ca0e805bff3.JPG', '', '', 0, 1506414275, 1506414275),
(12, 1, 0, '', 0, '/uploads/images/cert/2017/09/59ca0e9292f39.JPG', '', '', 0, 1506414275, 1506414275),
(13, 2, 0, '', 4, '/uploads/images/cert/2017/09/59ca0ea2530b3.jpg', '', '', 0, 1506414314, 1506414314),
(14, 2, 0, '111111', 1, '/uploads/images/cert/2017/09/59ca0eb16c6e6.jpg', '', '', 0, 1506414314, 1506414314),
(15, 2, 3, '111111', 1, '/uploads/images/cert/2017/09/59ca0ed38407d.jpg', '', '', 0, 1506414314, 1506414314),
(16, 2, 0, '', 0, '', '', '', 0, 1506414314, 1506414314),
(17, 4, 0, '', 4, '/uploads/images/cert/2017/09/59ca14876ff7c.JPG', '', '', 0, 1506415804, 1506415804),
(18, 4, 0, '440301198401026422', 1, '/uploads/images/cert/2017/09/59ca149245738.JPG', '', '', 0, 1506415804, 1506415804),
(19, 4, 6, '440301198401026422', 1, '/uploads/images/cert/2017/09/59ca14985e284.JPG', '', '', 0, 1506415804, 1506415804),
(20, 4, 0, '', 0, '/uploads/images/cert/2017/09/59ca149dc4925.JPG', '', '', 0, 1506415804, 1506415804),
(21, 0, 1, '  123456789', 1, '/uploads/images/cert/2017/09/59cde911d154f.jpg', '/uploads/images/cert/2017/09/59cde91c8500d.jpg', '', 0, 1506667013, 1506904225),
(22, 0, 1, '', 3, '/uploads/images/cert/2017/09/59cde97f2a8d0.JPG', '', '', 0, 1506667013, 1506904225),
(23, 0, 2, '111', 1, '/uploads/images/cert/2017/09/59ce0c158deb3.JPG', '/uploads/images/cert/2017/09/59ce0c1f94d6a.JPG', '', 0, 1506675797, 1506675797),
(24, 0, 2, '0', 3, '/uploads/images/cert/2017/09/59ce0c0bc3448.JPG', '', '', 0, 1506675797, 1506675797),
(25, 10, 0, '', 4, '/uploads/images/cert/2017/09/59ce2a28666db.PNG', '', '', 0, 1506683471, 1506683471),
(26, 10, 0, '123456789012345678', 1, '/uploads/images/cert/2017/09/59ce2a2dc3314.PNG', '', '', 0, 1506683472, 1506683472),
(27, 10, 12, '123456789012345678', 1, '/uploads/images/cert/2017/09/59ce2a3f4b749.PNG', '', '', 0, 1506683472, 1506683472),
(28, 10, 0, '', 0, '/uploads/images/cert/2017/09/59ce2a4ea705e.PNG', '', '', 0, 1506683472, 1506683472),
(29, 0, 6, '440301198802036238', 1, '/uploads/images/cert/2017/09/59cf545a4a34c.JPG', '/uploads/images/cert/2017/09/59cf5447201b7.JPG', '', 0, 1506759874, 1506759874),
(30, 0, 6, '0', 3, '/uploads/images/cert/2017/09/59cf545468779.JPG', '', '', 0, 1506759874, 1506759874),
(31, 5, 0, '', 4, '', '', '', 0, 1507104951, 1507104951),
(32, 5, 0, '', 1, '', '', '', 0, 1507104951, 1507104951),
(33, 5, 7, '', 1, '', '', '', 0, 1507104951, 1507104951),
(34, 5, 0, '', 0, '', '', '', 0, 1507104951, 1507104951),
(35, 0, 7, '441422199308259684', 1, '/uploads/images/cert/2017/10/59d49944c0cd6.jpg', '/uploads/images/cert/2017/10/59d499315543b.jpg', '', 0, 1507105159, 1507105159),
(36, 0, 7, '0', 3, '/uploads/images/cert/2017/10/59d49958a571d.jpg', '', '', 0, 1507105159, 1507105159),
(37, 12, 0, '', 4, '/uploads/images/cert/2017/10/59d4b86b8a90a.jpg', '', '', 0, 1507113103, 1507113103),
(38, 12, 0, '440301199306022938', 1, '/uploads/images/cert/2017/10/59d4b86e6c378.jpg', '', '', 0, 1507113103, 1507113103),
(39, 12, 10, '4403199306022938', 1, '/uploads/images/cert/2017/10/59d4b870ceffd.jpg', '', '', 0, 1507113103, 1507113103),
(40, 12, 0, '', 0, '/uploads/images/cert/2017/10/59d4b88d51d9c.jpg', '', '', 0, 1507113103, 1507113103);

-- --------------------------------------------------------

--
-- 表的结构 `coach`
--

DROP TABLE IF EXISTS `coach`;
CREATE TABLE IF NOT EXISTS `coach` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `coach` varchar(60) NOT NULL,
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:男:2女',
  `province` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `area` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `student_flow` int(10) NOT NULL COMMENT '学员流量',
  `schedule_flow` int(10) NOT NULL COMMENT '课程流量',
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `coach`
--

INSERT INTO `coach` (`id`, `coach`, `sex`, `province`, `city`, `area`, `member_id`, `student_flow`, `schedule_flow`, `star`, `create_time`, `update_time`, `coach_rank`, `cert_id`, `tag1`, `tag2`, `tag3`, `tag4`, `tag5`, `coach_year`, `experience`, `introduction`, `remarks`, `sys_remarks`, `portraits`, `description`, `coach_level`, `status`, `delete_time`) VALUES
(1, '刘伟霖', 1, '广东省', '深圳市', '南山区', 4, 0, 0, '0.0', 1506414074, 1507184567, 1, 0, '', '', '', '', '', 1, '哈哈哈哈哈哈或或或', '方式的发送到发送到', '', '', '/uploads/images/cert/2017/09/59ca0dd2685f8.jpg', '绕弯儿翁二', 1, 1, NULL),
(2, '刘嘉兴', 1, '广东省', '深圳市', '南山区', 5, 0, 0, '0.0', 1506414257, 1506414481, 1, 0, '', '', '', '', '', 24, '1', '1', '', '', '/uploads/images/cert/2017/09/59ca0e8af1cb1.jpg', '1', 1, 1, NULL),
(3, '陈侯', 1, '广东省', '深圳市', '南山区', 1, 0, 0, '0.0', 1506667013, 1506904225, 1, 0, '', '', '', '', '', 5, '猴塞雷', '真的猴塞雷', '', '', '/uploads/images/cert/2017/10/59d1888c3a6ef.jpg', '????', 1, 1, NULL),
(4, '冼玉华', 1, '广东省', '深圳市', '龙岗区', 2, 0, 0, '0.0', 1506675797, 1506675797, 1, 0, '', '', '', '', '', 1, '11', '11', '', '', '/uploads/images/cert/2017/09/59ce0c29d5db2.JPG', '。', 1, 0, NULL),
(5, '陈准', 1, '广东省', '深圳市', '南山区', 6, 0, 0, '0.0', 1506759874, 1506759874, 1, 0, '', '', '', '', '', 8, '只能说很有经验', '迷一样的人', '', '', '/uploads/images/cert/2017/09/59cf544ea3c59.JPG', '好好学习天天大热', 1, 0, NULL),
(6, '张伟荣', 1, '广东省', '深圳市', '福田区', 7, 0, 0, '0.0', 1507105159, 1507105159, 1, 0, '', '', '', '', '', 5, '暂无', '无', '', '', '/uploads/images/cert/2017/10/59d499501334c.jpg', '全力以赴', 1, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `coach_comment`
--

DROP TABLE IF EXISTS `coach_comment`;
CREATE TABLE IF NOT EXISTS `coach_comment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `court`
--

DROP TABLE IF EXISTS `court`;
CREATE TABLE IF NOT EXISTS `court` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `cover` varchar(255) NOT NULL DEFAULT 'a:3:{i:0;s:41:"/static/frontend/images/uploadDefault.jpg";i:1;s:41:"/static/frontend/images/uploadDefault.jpg";i:2;s:41:"/static/frontend/images/uploadDefault.jpg";}' COMMENT '封面',
  `status` int(10) NOT NULL COMMENT '-1:不通过;|0:待审核|1:系统通过',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `court`
--

INSERT INTO `court` (`id`, `province`, `city`, `area`, `court`, `camp_id`, `camp`, `location`, `principal`, `open_time`, `contract`, `remarks`, `sys_remarks`, `chip_rent`, `full_rent`, `half_rent`, `outdoors`, `cover`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '广东省', '深圳市', '南山区', '大热前海训练中心', 0, '系统', '', '陈侯', '8:00-20:00', '0755-22222222', '', '系统场地', '0.00', '0.00', '0.00', 0, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 1, 1506410999, 1506410999, NULL),
(3, '广东省', '深圳市', '南山区', '前海北头运动场', 0, '系统', '', '', '', '', '', '', '0.00', '0.00', '0.00', 1, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 1, 0, 0, NULL),
(5, '广东省', '深圳市', '南山区', '阳光文体中心迷你场', 4, '准行者训练营', '桂庙路口116号', '陈准', '09:00-22:00', '26650516', '一个迷你综合小球场', '', '20.00', '200.00', '100.00', 2, 'a:2:{i:0;s:47:\"/uploads/images/court/2017/09/59cc9f61b14d0.JPG\";i:1;s:47:\"/uploads/images/court/2017/09/59cc9f89dbbb9.JPG\";}', 0, 0, 0, NULL),
(7, '广东省', '深圳市', '南山区', '阳光迷你场', 4, '准行者训练营', '哪里', '准的', '1213', '13826505160', '测试', '', '10.00', '200.00', '100.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/09/59cf722b2d8e8.JPG\";}', 0, 1506767406, 1506767406, NULL),
(8, '广东省', '深圳市', '福田区', '荣光场', 5, '荣光训练营', '福田', '张伟荣', '9:00-18:00', '15018514302', '暂时没有', '', '30.00', '300.00', '150.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/10/59d1c4e76cf4c.jpg\";}', 0, 1506919679, 1506919679, NULL),
(9, '广东省', '深圳市', '南山区', '海滨实验小学篮球场', 3, '齐天大热', '学府路', '无名', '0', '0', '仅周末使用', '', '0.00', '0.00', '0.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/10/59d1ce09eeccd.JPG\";}', 0, 1506921998, 1506921998, NULL),
(10, '广东省', '深圳市', '福田区', '荣光训练场', 5, '荣光训练营', '福田车公庙', '张伟荣', '上午9点～下午18:00', '15018514302', '没有', '', '20.00', '200.00', '100.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/10/59d49a910409d.jpg\";}', 0, 1507105426, 1507105426, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `court_camp`
--

DROP TABLE IF EXISTS `court_camp`;
CREATE TABLE IF NOT EXISTS `court_camp` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `court` varchar(255) NOT NULL,
  `court_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '是否可用:1可用|-1:不可用',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `court_camp`
--

INSERT INTO `court_camp` (`id`, `court`, `court_id`, `camp_id`, `camp`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '大热前海训练中心', 1, 2, '大热前海训练营', 1, 0, 0, NULL),
(2, '大热前海训练中心', 1, 1, '大热体适能中心', 1, 0, 0, NULL),
(3, '前海北投运动场', 3, 2, '大热前海训练营', 1, 0, 0, NULL),
(4, '前海北投运动场', 3, 1, '大热体适能中心', 1, 0, 0, NULL),
(5, '大热前海训练中心', 1, 3, '齐天大热', 1, 0, 0, NULL),
(6, '前海北投运动场', 3, 3, '齐天大热', 1, 0, 0, NULL),
(7, '前海北头运动场', 3, 4, '准行者训练营', 1, 1506588291, 1506777935, 1506777935),
(8, '大热前海训练中心', 1, 4, '准行者训练营', 1, 1506591412, 1506591412, NULL),
(10, '阳光迷你场', 7, 4, '准行者训练营', 1, 1506767406, 1506767406, NULL),
(11, '荣光场', 8, 5, '荣光训练营', 1, 1506919679, 1506919679, NULL),
(12, '海滨实验小学篮球场', 9, 3, '齐天大热', 1, 1506921998, 1506921998, NULL),
(13, '荣光训练场', 10, 5, '荣光训练营', 1, 1507105426, 1507105426, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `exercise`
--

DROP TABLE IF EXISTS `exercise`;
CREATE TABLE IF NOT EXISTS `exercise` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `exercise`
--

INSERT INTO `exercise` (`id`, `member_id`, `member`, `camp_id`, `camp`, `exercise`, `pid`, `exercise_setion`, `exercise_detail`, `media`, `is_open`, `status`, `create_time`, `delete_time`, `update_time`) VALUES
(1, 0, '平台', 0, '平台', '热身游戏', 0, '', '', '', 0, 1, 0, NULL, 0),
(2, 0, '平台', 0, '平台', '投篮', 0, '', '', '', 1, 1, 0, NULL, 0),
(3, 0, '平台', 0, '平台', '传球', 0, '', '', '', 1, 1, 0, NULL, 0),
(4, 0, '平台', 0, '平台', '上篮', 0, '', '', '', 1, 1, 0, NULL, 0),
(5, 0, '平台', 0, '平台', '原地运球', 0, '', '', '', 1, 1, 0, NULL, 0),
(6, 0, '平台', 0, '平台', '行进间运球', 0, '', '', '', 1, 1, 0, NULL, 0),
(7, 0, '平台', 0, '平台', '基本移动技能', 0, '', '', '', 1, 1, 0, NULL, 0),
(8, 0, '平台', 0, '平台', '基本团队配合', 0, '', '', '', 1, 1, 0, NULL, 0),
(9, 0, '平台', 0, '平台', '一对一', 0, '', '', '', 1, 1, 0, NULL, 0),
(10, 0, '平台', 0, '平台', '进阶团队配合', 0, '', '', '', 1, 1, 0, NULL, 0),
(11, 0, '平台', 0, '平台', '其他', 0, '', '', '', 1, 1, 0, NULL, 0),
(12, 0, '平台', 0, '平台', '单人对墙传球', 3, '', '单人对墙传球', '', 1, 1, 1501582131, NULL, 1501582131),
(14, 0, '平台', 0, '平台', '两人原地传接球', 3, '', '两人面对面站立，原地进行双手传接球练习。作用：提高传球的准确度', '', 1, 1, 1501643275, NULL, 1501747177),
(15, 0, '平台', 0, '平台', '三人或多人同时传球练习', 3, '', '每人站一边。成三角型。间距3米。用一球原地互相来回传接球。作用：提高传接球的准确性', '', 1, 1, 1501646362, NULL, 1501660092),
(16, 0, '平台', 0, '平台', '抢尾巴（无球、运球）', 1, '', '游戏规则：每人一条绳子系在腰后当尾巴，游戏开始后，在保护自己尾巴的同时，把别人的尾巴抢走。\r\n练习作用：提高移动和摆脱能力、敏捷性、反应能力。', 'http://ou1z1q8b2.bkt.clouddn.com/2017080350ce85982cb2099a23.mp4', 1, 1, 1501743930, NULL, 1501747062),
(17, 0, '平台', 0, '平台', '雪糕筒大战（无球 、运球）', 1, '', '游戏规则：两组队员同时进行，A组负责将场地上的雪糕筒推到，B组负责扶起。练习作用：提高团队协作、移动、反应能力。', '', 1, 1, 1502267118, NULL, 1502267199);

-- --------------------------------------------------------

--
-- 表的结构 `grade`
--

DROP TABLE IF EXISTS `grade`;
CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lesson` varchar(60) NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `gradecate` varchar(60) NOT NULL,
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
  `plan_id` int(10) NOT NULL COMMENT '教案id',
  `court` varchar(255) NOT NULL COMMENT '球场',
  `court_id` int(10) NOT NULL COMMENT '场地id',
  `rent` decimal(8,2) NOT NULL COMMENT '场地租金',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:预排;1:正常|2:下架',
  `delete_time` int(10) DEFAULT NULL,
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `grade`
--

INSERT INTO `grade` (`id`, `lesson`, `lesson_id`, `gradecate`, `gradecate_id`, `grade`, `camp_id`, `camp`, `leader`, `leader_id`, `teacher`, `teacher_id`, `coach`, `coach_id`, `coach_salary`, `assistant_id`, `assistant`, `assistant_salary`, `salary_base`, `students`, `week`, `lesson_time`, `start`, `end`, `province`, `city`, `area`, `location`, `plan`, `plan_id`, `court`, `court_id`, `rent`, `remarks`, `status`, `delete_time`, `create_time`, `update_time`) VALUES
(1, '小学低年级初级班', 2, '幼儿兴趣班（4-6岁）', 5, '陈班豆丁', 3, '齐天大热', '陈侯', 1, '陈侯', 1, '123abc', 5, '100.00', '', 'a:1:{i:0;s:9:\"weilin666\";}', '0.00', '10.00', 0, '周日', '17:00', 0, 0, '', '', '', '', '', 0, '大热前海训练中心', 2, '50.00', '', 0, 1507361630, 1506936198, 1507361630),
(2, '小学低年级初级班', 2, '幼儿兴趣班（4-6岁）', 5, '陈班豆丁', 3, '齐天大热', '陈侯', 1, '陈侯', 1, '123abc', 5, '100.00', '', 'a:1:{i:0;s:9:\"weilin666\";}', '0.00', '10.00', 0, '周日', '17:00', 0, 0, '', '', '', '', '', 0, '大热前海训练中心', 2, '50.00', '', 1, NULL, 1506936199, 1506936199),
(3, '猴塞雷课程', 11, '私教（4-18岁）', 34, '猴塞雷私教班', 3, '齐天大热', '', 0, '', 0, 'weilin666', 4, '20.00', '', '', '0.00', '10.00', 0, '周六', '15:00', 0, 0, '', '', '', '', '', 0, '大热前海训练中心', 2, '0.00', '', 1, NULL, 1507361617, 1507361617);

-- --------------------------------------------------------

--
-- 表的结构 `grade_category`
--

DROP TABLE IF EXISTS `grade_category`;
CREATE TABLE IF NOT EXISTS `grade_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '课程分类名',
  `status` tinyint(4) NOT NULL COMMENT '状态:1正常|-1禁用|0默认',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='课程分类';

--
-- 转存表中的数据 `grade_category`
--

INSERT INTO `grade_category` (`id`, `name`, `status`, `create_time`, `update_time`, `pid`) VALUES
(1, '幼儿篮球兴趣班', 1, 0, 0, 0),
(2, '幼儿兴趣班（月卡）', 1, 0, 0, 1),
(3, '幼儿兴趣班（季度卡）', 1, NULL, NULL, 1),
(4, '幼儿兴趣班（半年卡）', 1, NULL, NULL, 1),
(5, '幼儿兴趣班（4-6岁）', 1, NULL, NULL, 1),
(6, '基础篮球课程', 1, NULL, NULL, 0),
(7, '小学 - 基础班（7-9岁）', 1, NULL, NULL, 6),
(8, '小学 - 基础班（10-12岁）', 1, NULL, NULL, 6),
(9, '初中 - 基础班（13-15岁）', 1, NULL, NULL, 6),
(10, '高中 - 基础班（16-18岁）', 1, NULL, NULL, 6),
(11, '综合篮球课程', 1, NULL, NULL, 0),
(12, '小学 - 综合班（7-9岁）', 1, NULL, NULL, 11),
(13, '小学 - 综合班（10-12岁）', 1, NULL, NULL, 11),
(14, '初中 - 综合班（13-15岁）', 1, NULL, NULL, 11),
(15, '高中 - 综合班（16-18岁）', 1, NULL, NULL, 11),
(16, '强化篮球课程', 1, NULL, NULL, 0),
(17, '小学 - 强化班（7-9岁）', 1, NULL, NULL, 16),
(18, '小学 - 强化班（10-12岁）', 1, NULL, NULL, 16),
(19, '初中 - 强化班（13-15岁）', 1, NULL, NULL, 16),
(20, '高中 - 强化班（16-18岁）', 1, NULL, NULL, 16),
(21, '篮球队课程', 1, NULL, NULL, 0),
(22, '迷你球队（6-7岁）', 1, NULL, NULL, 21),
(23, '低年组球队（7-9岁）', 1, NULL, NULL, 21),
(24, '高年组球队（9-12岁）', 1, NULL, NULL, 21),
(25, '小学校队（7-12岁）', 1, NULL, NULL, 21),
(26, '初高中球队（13-18岁）', 1, NULL, NULL, 21),
(27, '特色训练课程', 1, NULL, NULL, 0),
(28, '集训营', 1, NULL, NULL, 27),
(29, '超级射手课程（10岁以上）', 1, NULL, NULL, 27),
(30, '超级控球手课程', 1, NULL, NULL, 27),
(31, '花式篮球班', 1, NULL, NULL, 27),
(32, '篮球节拍班', 1, NULL, NULL, 27),
(33, '其他', 1, NULL, NULL, 0),
(34, '私教（4-18岁）', 1, NULL, NULL, 33),
(35, '体验班（4-18岁）', 1, NULL, NULL, 33),
(36, '课外活动（4-18岁）', 1, NULL, NULL, 33),
(37, '校园兴趣班（4-18岁）', 1, NULL, NULL, 33),
(38, '企业（事业单位）', 1, NULL, NULL, 33);

-- --------------------------------------------------------

--
-- 表的结构 `grade_member`
--

DROP TABLE IF EXISTS `grade_member`;
CREATE TABLE IF NOT EXISTS `grade_member` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:待审核|1:正常|2:退出|3:被开除|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='班级-会员关联表';

--
-- 转存表中的数据 `grade_member`
--

INSERT INTO `grade_member` (`id`, `grade`, `grade_id`, `lesson`, `lesson_id`, `camp_id`, `camp`, `student_id`, `student`, `member`, `member_id`, `rest_schedule`, `avatar`, `type`, `remarks`, `status`, `create_time`, `delete_time`, `update_time`) VALUES
(1, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 2, '陈小准', 'legend', 6, 15, '', 2, '', 1, 1506569500, NULL, 0),
(2, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 2, '陈小准', 'legend', 6, 15, '', 2, '', 1, 1506569572, NULL, 0),
(3, '猴塞雷私教班', 3, '猴塞雷课程', 11, 3, '齐天大热', 3, 'Easychen ', 'Greeny', 13, 2, '', 2, '', 1, 1507355231, NULL, 1507361617),
(4, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 1, '123', 'woo123', 8, 4, '', 2, '', 1, 1507518508, NULL, 1507518508),
(5, '', 0, '大热幼儿班', 1, 1, '大热体适能中心', 1, '123', 'woo123', 8, 5, '', 2, '', 1, 1507537926, NULL, 1507537926),
(6, '', 0, '超级射手班', 6, 4, '准行者训练营', 1, '123', 'woo123', 8, 2, '', 2, '', 1, 1507539335, NULL, 1507539335),
(7, '', 0, '猴塞雷课程', 11, 3, '齐天大热', 1, '123', 'woo123', 8, 1, '', 2, '', 1, 1507540816, NULL, 1507540816),
(8, '', 0, '小学低年级初级班', 2, 3, '齐天大热', 1, '123', 'woo123', 8, 10, '', 1, '', 1, 1507542080, NULL, 1507542080),
(9, '', 0, '超级控球手', 3, 4, '准行者训练营', 1, '123', 'woo123', 8, 1, '', 2, '', 1, 1507545041, NULL, 1507545041);

-- --------------------------------------------------------

--
-- 表的结构 `income`
--

DROP TABLE IF EXISTS `income`;
CREATE TABLE IF NOT EXISTS `income` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='训练营收入表';

--
-- 转存表中的数据 `income`
--

INSERT INTO `income` (`id`, `lesson_id`, `lesson`, `camp_id`, `camp`, `income`, `member_id`, `member`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 11, '猴塞雷课程', 3, '3', '70.00', 13, 'Greeny', 1507355398, 0, NULL),
(2, 2, '小学低年级初级班', 3, '3', '7.00', 8, 'woo123', 1507542080, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `lesson`
--

DROP TABLE IF EXISTS `lesson`;
CREATE TABLE IF NOT EXISTS `lesson` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lesson` varchar(60) NOT NULL COMMENT '课程名称',
  `member` varchar(60) NOT NULL COMMENT '发布者',
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `leader_id` int(10) NOT NULL COMMENT '负责财务的老大,对应member表id',
  `leader` varchar(60) NOT NULL COMMENT 'leader',
  `gradecate` varchar(60) NOT NULL COMMENT '课程类型',
  `gradecate_id` int(10) NOT NULL COMMENT '选择类型',
  `camp` varchar(60) NOT NULL COMMENT '所属训练营名称',
  `camp_id` int(10) NOT NULL COMMENT '所属训练营id',
  `cost` decimal(8,0) NOT NULL DEFAULT '0' COMMENT '每个课时单价',
  `total` tinyint(10) NOT NULL DEFAULT '1' COMMENT '总课时数量',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '购买课程需要积分',
  `coach` varchar(60) NOT NULL COMMENT '主教练',
  `coach_id` int(10) NOT NULL COMMENT 'zhu教练  对应member表id',
  `assistant` text NOT NULL COMMENT '副教练序列化',
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lesson`
--

INSERT INTO `lesson` (`id`, `lesson`, `member`, `member_id`, `leader_id`, `leader`, `gradecate`, `gradecate_id`, `camp`, `camp_id`, `cost`, `total`, `score`, `coach`, `coach_id`, `assistant`, `assistant_id`, `teacher`, `teacher_id`, `min`, `max`, `week`, `start`, `end`, `lesson_time`, `dom`, `sort`, `hot`, `hit`, `students`, `province`, `city`, `area`, `court_id`, `court`, `location`, `telephone`, `cover`, `remarks`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '大热幼儿班', 'Hot-basketball2', 2, 0, '选填', '幼儿篮球兴趣班', 1, '大热体适能中心', 1, '100', 1, 0, '刘伟霖', 4, '', '', '选填', 0, 4, 10, '周日', '0000-00-00', '0000-00-00', '10:30:00', 'a:1:{i:0;s:2:\"15\";}', 0, 1, 0, 5, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/lesson/5.jpg', '', 1, 0, 0, NULL),
(2, '小学低年级初级班', 'HoChen', 1, 0, '选填', '基础篮球课程', 6, '齐天大热', 3, '120', 1, 0, '刘伟霖', 4, '', '', '选填', 0, 1, 15, '周日', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"10\";}', 0, 1, 0, 1, '广东省', '深圳市', '南山区', 3, '前海北投运动场', '', '', '/uploads/images/lesson/6.jpg', '', 1, 0, 0, NULL),
(3, '超级控球手', 'legend', 6, 0, '选填', '强化篮球课程', 16, '准行者训练营', 4, '120', 1, 0, '陈烈准', 6, 'a:1:{i:0;s:9:\"weilin666\";}', 'a:1:{i:0;s:1:\"4\";}', '选填', 0, 5, 10, '周日', '0000-00-00', '0000-00-00', '18:40:00', 'a:3:{i:0;s:1:\"5\";i:1;s:2:\"10\";i:2;s:0:\"\";}', 0, 1, 0, 1, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/lesson/7.jpg', '', 1, 0, 1506704238, NULL),
(4, '周六上午十点低年级班', 'Hot Basketball 1', 3, 0, '选填', '基础篮球课程', 6, '大热前海训练营', 2, '100', 1, 0, '刘嘉兴', 5, 'a:1:{i:0;s:9:\"刘伟霖\";}', 'a:1:{i:0;s:1:\"4\";}', '选填', 0, 4, 10, '周六', '0000-00-00', '0000-00-00', '10:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 1, 0, 6, '广东省', '深圳市', '南山区', 3, '前海北投运动场', '', '', '/uploads/images/lesson/8.jpg', '', 1, 0, 0, NULL),
(5, '射手特训班', 'HoChen', 1, 5, '刘嘉兴', '强化篮球课程', 16, '齐天大热', 3, '200', 1, 0, '刘伟霖', 4, '', '', '选填', 0, 1, 4, '周日', '0000-00-00', '0000-00-00', '18:43:00', 'a:2:{i:0;s:2:\"10\";i:1;s:2:\"20\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '', '', 0, 0, 0, NULL),
(6, '超级射手班', 'legend', 6, 0, '选填', '特色训练课程', 27, '准行者训练营', 4, '120', 1, 0, '刘伟霖', 4, '', '', '选填', 0, 5, 10, '周日', '0000-00-00', '0000-00-00', '09:50:00', 'a:1:{i:0;s:1:\"5\";}', 0, 1, 0, 2, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/09/59ca41677c295.jpg', '想成为三井寿吗？', 1, 0, 1506617178, NULL),
(7, '超级防守班', 'legend', 6, 0, '', '特色训练课程', 27, '准行者训练营', 4, '120', 1, 0, '刘伟霖', 4, '', '', '', 0, 5, 10, '周日', '0000-00-00', '0000-00-00', '20:15:00', 'a:2:{i:0;s:1:\"5\";i:1;s:2:\"10\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/09/59ca458351901.JPG', '', 0, 0, 0, NULL),
(8, '超级飞侠', 'legend', 6, 0, '', '基础篮球课程', 6, '准行者训练营', 4, '100', 1, 0, '刘伟霖', 4, '', '', '', 0, 5, 10, '周日', '0000-00-00', '0000-00-00', '23:55:00', 'a:2:{i:0;s:1:\"5\";i:1;s:2:\"10\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/09/59ca78f278870.JPG', '测试', 0, 0, 0, NULL),
(11, '猴塞雷课程', 'HoChen', 1, 0, '', '特色训练课程', 27, '齐天大热', 3, '100', 1, 0, '陈侯', 1, '', '', '', 0, 1, 2, '周日', '0000-00-00', '0000-00-00', '15:00:00', 'a:1:{i:0;s:1:\"1\";}', 0, 0, 0, 3, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/10/59d8686eb9fa4.jpg', '', 1, 1507354740, 1507354859, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `log_admindo`
--

DROP TABLE IF EXISTS `log_admindo`;
CREATE TABLE IF NOT EXISTS `log_admindo` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `username` varchar(100) DEFAULT NULL COMMENT '管理员名字',
  `doing` varchar(255) DEFAULT NULL COMMENT '操作事件',
  `url` varchar(100) DEFAULT NULL COMMENT '操作页面',
  `ip` varchar(50) NOT NULL COMMENT 'ip',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `log_admindo`
--

INSERT INTO `log_admindo` (`id`, `uid`, `username`, `doing`, `url`, `ip`, `created_at`) VALUES
(1, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.14.172.183', 1506047575),
(2, 1, 'admin', '审核教练id: 2 审核通过 成功', '/admin/coach/audit', '183.14.172.183', 1506047593),
(3, 1, 'admin', '审核训练营id: 2 审核通过 成功', '/admin/camp/audit', '183.14.172.183', 1506047984),
(4, 1, 'admin', '审核训练营id: 1 审核通过 成功', '/admin/camp/audit', '183.14.172.183', 1506047989),
(5, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.14.172.183', 1506055909),
(6, 1, 'admin', '审核训练营id: 3 审核通过 成功', '/admin/camp/audit', '183.14.172.183', 1506062410),
(7, 1, 'admin', '审核训练营id: 5 审核通过 成功', '/admin/camp/audit', '183.14.172.183', 1506067570),
(8, 1, 'admin', '审核教练id: 11 审核通过 成功', '/admin/coach/audit', '183.14.172.183', 1506068831),
(9, 1, 'admin', '审核教练id: 12 审核通过 成功', '/admin/coach/audit', '183.14.172.183', 1506068931),
(10, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.13.96.9', 1506411055),
(11, 1, 'admin', '审核训练营id: 1 审核通过 成功', '/admin/camp/audit', '183.13.96.9', 1506413133),
(12, 1, 'admin', '审核训练营id: 2 审核通过 成功', '/admin/camp/audit', '183.13.96.9', 1506413138),
(13, 1, 'admin', '审核训练营id: 3 审核通过 成功', '/admin/camp/audit', '183.13.96.9', 1506413143),
(14, 1, 'admin', '审核教练id: 1 审核通过 成功', '/admin/coach/audit', '183.13.96.9', 1506414088),
(15, 1, 'admin', '审核训练营id: 3 审核通过 成功', '/admin/camp/audit', '183.13.96.9', 1506414242),
(16, 1, 'admin', '审核训练营id: 2 审核通过 成功', '/admin/camp/audit', '183.13.96.9', 1506414356),
(17, 1, 'admin', '审核训练营id: 1 审核通过 成功', '/admin/camp/audit', '183.13.96.9', 1506414363),
(18, 1, 'admin', '审核教练id: 2 审核通过 成功', '/admin/coach/audit', '183.13.96.9', 1506414481),
(19, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.13.96.9', 1506422246),
(20, 1, 'admin', '审核训练营id: 4 审核通过 成功', '/admin/camp/audit', '183.13.96.9', 1506422262),
(21, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.12.197.107', 1506436782),
(22, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.13.96.9', 1506478240),
(23, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.12.197.107', 1506520721),
(24, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '113.92.38.70', 1506525064),
(25, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.13.101.2', 1506575023),
(26, 1, 'admin', '审核训练营id: 5 审核通过 成功', '/admin/camp/audit', '183.13.101.2', 1506575038),
(27, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '183.13.100.43', 1506665242),
(28, 1, 'admin', '审核训练营id: 7 审核通过 成功', '/admin/camp/audit', '183.13.100.43', 1506665258),
(29, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '122.97.172.20', 1506685811),
(30, 1, 'admin', '审核训练营id: 10 审核通过 成功', '/admin/camp/audit', '122.97.172.20', 1506685845),
(31, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '14.30.184.231', 1507105198),
(32, 1, 'admin', '审核训练营id: 5 审核通过 成功', '/admin/camp/audit', '14.30.184.231', 1507105258),
(33, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '14.30.184.231', 1507109317),
(34, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '58.60.126.202', 1507113240),
(35, 1, 'admin', '审核训练营id: 12审核操作:审核已通过成功', '/admin/camp/audit', '58.60.126.202', 1507113353),
(36, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '58.60.127.150', 1507184092),
(37, 1, 'admin', '审核教练id: 1审核操作:审核已通过成功', '/admin/coach/audit', '58.60.127.150', 1507184126),
(38, 1, 'admin', '审核教练id: 1审核操作:审核已通过成功', '/admin/coach/audit', '58.60.127.150', 1507184296),
(39, 1, 'admin', '审核教练id: 1审核操作:审核未通过成功', '/admin/coach/audit', '58.60.127.150', 1507184521),
(40, 1, 'admin', '审核教练id: 1审核操作:审核已通过成功', '/admin/coach/audit', '58.60.127.150', 1507184567);

-- --------------------------------------------------------

--
-- 表的结构 `log_camp_member`
--

DROP TABLE IF EXISTS `log_camp_member`;
CREATE TABLE IF NOT EXISTS `log_camp_member` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_grade_member`
--

DROP TABLE IF EXISTS `log_grade_member`;
CREATE TABLE IF NOT EXISTS `log_grade_member` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_income`
--

DROP TABLE IF EXISTS `log_income`;
CREATE TABLE IF NOT EXISTS `log_income` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_pay`
--

DROP TABLE IF EXISTS `log_pay`;
CREATE TABLE IF NOT EXISTS `log_pay` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_rebate`
--

DROP TABLE IF EXISTS `log_rebate`;
CREATE TABLE IF NOT EXISTS `log_rebate` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_salary_in`
--

DROP TABLE IF EXISTS `log_salary_in`;
CREATE TABLE IF NOT EXISTS `log_salary_in` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_salary_out`
--

DROP TABLE IF EXISTS `log_salary_out`;
CREATE TABLE IF NOT EXISTS `log_salary_out` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_sendtemplatemsg`
--

DROP TABLE IF EXISTS `log_sendtemplatemsg`;
CREATE TABLE IF NOT EXISTS `log_sendtemplatemsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wxopenid` varchar(100) NOT NULL COMMENT '接收的openid',
  `member_id` int(11) NOT NULL COMMENT '接收的memberid',
  `url` varchar(255) DEFAULT NULL COMMENT '消息的url地址',
  `content` text COMMENT '消息的内容 seriliaze',
  `status` tinyint(4) DEFAULT '0' COMMENT '发送成功状态:1成功|0失败',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='发送模板消息log';

--
-- 转存表中的数据 `log_sendtemplatemsg`
--

INSERT INTO `log_sendtemplatemsg` (`id`, `wxopenid`, `member_id`, `url`, `content`, `status`, `create_time`, `update_time`) VALUES
(1, 'o83291Ic0nyfFcuRrhsu2s4sBYxQ', 10, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/12/openid/o83291Ic0nyfFcuRrhsu2s4sBYxQ', 'a:4:{s:6:\"touser\";s:28:\"o83291Ic0nyfFcuRrhsu2s4sBYxQ\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:99:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/12/openid/o83291Ic0nyfFcuRrhsu2s4sBYxQ\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的训练营注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月04日 18时35分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:36:\"点击进入训练营进行操作吧\";}}}', 0, 1507113353, NULL),
(2, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月05日 14时15分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 0, 1507184126, NULL),
(3, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月05日 14时18分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507184296, NULL),
(4, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/coach/updatecoach/openid/o83291Nf-U88M3FV7KRiu_0czrSg', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:91:\"https://m.hot-basketball.com/frontend/coach/updatecoach/openid/o83291Nf-U88M3FV7KRiu_0czrSg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核未通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核未通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月05日 14时22分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:30:\"点击进入修改完善资料\";}}}', 1, 1507184521, NULL),
(5, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月05日 14时22分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507184567, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hot_id` bigint(20) UNSIGNED NOT NULL COMMENT '会员随机ID',
  `openid` varchar(64) NOT NULL COMMENT '微信授权即产生',
  `member` varchar(60) NOT NULL COMMENT '用户名',
  `nickname` varchar(60) NOT NULL COMMENT '微信授权即产生',
  `avatar` varchar(255) NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '注册或者微信授权产生',
  `telephone` bigint(11) NOT NULL COMMENT '电话号码',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `email` varchar(60) NOT NULL COMMENT '电子邮箱',
  `realname` varchar(30) NOT NULL COMMENT '真实姓名',
  `province` varchar(60) NOT NULL COMMENT '省',
  `city` varchar(60) NOT NULL COMMENT '市',
  `area` varchar(60) NOT NULL,
  `location` varchar(255) NOT NULL COMMENT '居住地址',
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1男2女',
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`id`, `hot_id`, `openid`, `member`, `nickname`, `avatar`, `telephone`, `password`, `email`, `realname`, `province`, `city`, `area`, `location`, `sex`, `height`, `weight`, `charater`, `shoe_code`, `birthday`, `create_time`, `update_time`, `level`, `pid`, `hp`, `cert_id`, `score`, `flow`, `balance`, `remarks`, `delete_time`) VALUES
(1, 12345678, 'o83291IEM6JPXsCe5bIT_XRt2oes', 'HoChen', 'HO', 'https://wx.qlogo.cn/mmopen/vi_32/SibkSPyDCsQgsldCSicKXvqPNPvb17ibRBGl7sEWGx9ZUXYjuIRavp1UDiaMGRyC0J57ulsAOxQCvn0eBhP8UXp4UA/0', 13823599611, '872d593b8b25ae4d55984b076e4736021a0cd211', '37272343@QQ.com', '', '广东省', '深圳市', '南山区', '', 1, '173.0', '70.0', '', '0.0', '1980-09-28', 1506411866, 1506936429, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(2, 22222222, 'o83291FaVoul_quMxTYAOHt-NmHg', 'Hot-basketball2', '大热篮球俱乐部2', 'https://wx.qlogo.cn/mmopen/vi_32/hRnMzjwHkMNhoQiaP1tATWgTvEvsNTQibWEysfJnEQ9hS50ZiatuR7XkPjdCzIib5ZjE4CxXUXo7eAwnnWZZhqGTJQ/0', 18565717133, 'c0bcae4cbde0304dd6e0df40d02ba9d00bd7714f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506411868, 1506411868, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(3, 11111111, 'o83291PIWaWsfNat_XkflwCO5sX0', 'Hot Basketball 1', '大热篮球俱乐部1', 'https://wx.qlogo.cn/mmopen/vi_32/vJYBxqAI4qV7pRBsbHSBUw83PrV2BH8hkY1vV4LebwTKe2GRPvwRDF8LlpjuRS5rBBgicdVUk5W1m6icwphlNIzw/0', 15820474733, 'c0bcae4cbde0304dd6e0df40d02ba9d00bd7714f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506411921, 1506411921, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(4, 66666666, 'o83291Nf-U88M3FV7KRiu_0czrSg', 'weilin666', 'WL伟霖', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJXZOE1LAocibpESZQmicYIiaV9xNgKdLRgdL4Hn7omXHdFTwqJTphdHFhGMKujX46B6icUJlfibOKx5pw/0', 13410599613, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506413991, 1506413991, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(5, 33034200, 'o83291HVzrqZlYFdSeK1OBx6sX_E', '123abc', '劉嘉興', 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYIDwRM5lic1WWW9mKWFS1a1fYeA/0', 13418931599, '0ec86335375000549a1f41c771049e206cb0c77f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506414131, 1506414131, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(6, 39462845, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 'legend', '© iamLegend', 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 13826505160, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', 'lekzoom@163.com', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506415529, 1506609191, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(7, 45886966, 'o83291GqxP1FCqmfVncltkGVWPaY', 'wayen_z', 'Wayen', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJsb6yF8nF3I5eGmQT8zoRicAaF9QjfTbHwBofiaa5tIHUpRqMicicth5SW0I4L6pTbr6UDbGnqSZWPpQ/0', 15018514302, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '185918240@qq.com', '', '', '', '', '', 1, '170.0', '52.0', '', '0.0', '1993-10-01', 1506439301, 1506878266, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(8, 90306367, 'o83291CzkRqonKdTVSJLGhYoU98Q', 'woo123', 'WOO', 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 18507717466, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506565743, 1506565743, 1, 0, 0, 0, 0, 0, '100.00', '', NULL),
(9, 26233702, 'o83291I75hoZy8HuDN6nfM6c7qZM', 'GaoYan', '燕子', 'https://wx.qlogo.cn/mmopen/vi_32/ctgjGIoTXvGgGdMuicTg0JJ06laxfIjySYQxxibQdj62ORwYuBOA5dJJMJ1XDmVTyzghmTNEicxveUsMCaqfvicSKA/0', 13662270560, '17f4e70a33cfa503f9cd6098ee67e7e9b49cb995', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506576907, 1506576907, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(10, 22126687, 'o83291Ic0nyfFcuRrhsu2s4sBYxQ', 'wl', 'wlsmall', 'https://wx.qlogo.cn/mmopen/vi_32/CED6Q8VjibXYAa7PaFUib9ZLINjK5MdCrCKiaAeAR9V0icYLRqfWwkt6mv81a0Fmx7HhZvDic0A7ia87CdZz2c41JurA/0', 13902925499, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506602372, 1506602372, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(11, 79986624, 'o83291CbcwZsw60mUhBqCGfpFDbM', 'hot111', '大热 赛事部', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKJwIOoK7eq3g5cId6ic0tY0CjlYvib95yq8fOurvnGL5FqtEB1FIub1ygjHQ5DetTaYwExnaibudnFA/0', 18126211925, '90a66b83f55b773baeba20cb41608d442cf1bb2d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506659842, 1506659842, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(12, 70124881, 'o83291E81bVr-WDGRTcybW1P2jOw', 'willng', 'WILL', 'https://wx.qlogo.cn/mmopen/vi_32/u0hn2SHI1D1dbhYlZibicIjWzySCmtmiaaW5ta7PLc3DsDV6Ks90OBGUtMKbwTnZ2Av2iaDIEkelQqniaIVzoaqC7xA/0', 13684925727, '1755de0f1d6eaa4ae7b78b70972b672f97cbcc5c', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506683191, 1506683191, 1, 0, 0, 0, 0, 0, '0.00', '', NULL),
(13, 104930775, 'o83291FVItqsEfwQSDEqNlzyuHks', 'Greeny', '彩彩', 'https://wx.qlogo.cn/mmopen/vi_32/Zv8ZEHKjZyjrTMFWe6HdRGyzZzBqsBMABVOsfzchrMqZ0tCbl9RXXSibChjOX8whWsORxvbZQ7xsp2z1Nuf8Fag/0', 13828880254, 'f0410bf59c30e4b49c8461891521b8f8a7c33c59', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507355136, 1507355136, 1, 0, 0, 0, 0, 0, '0.00', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(240) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `is_system` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:系统消息:2训练营消息',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:zhengchang|0:guoqi',
  PRIMARY KEY (`id`),
  KEY `camp_id` (`camp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`id`, `title`, `content`, `url`, `camp_id`, `is_system`, `create_time`, `update_time`, `delete_time`, `status`) VALUES
(1, '课程大热幼儿班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091826474260<br /> 金额:0<br /> 商品信息:123预约体验大热幼儿班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/17', 1, 2, 1507544809, 1507544809, NULL, 1),
(2, '课程超级控球手已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091830393947<br /> 金额:0<br /> 商品信息:123预约体验超级控球手', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/18', 4, 2, 1507545041, 1507545041, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `message_member`
--

DROP TABLE IF EXISTS `message_member`;
CREATE TABLE IF NOT EXISTS `message_member` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(240) NOT NULL,
  `content` text NOT NULL,
  `member_id` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:未读|2:已读',
  `url` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `message_member`
--

INSERT INTO `message_member` (`id`, `title`, `content`, `member_id`, `status`, `url`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '您已购买了课程大热幼儿班', '用户名123\\n 订单编号1201710091632015853\\n 金额0\\n 商品信息123预约体验大热幼儿班\\n 订单编号', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/10', 1507538154, 1507538154, NULL),
(2, '', '用户名123\\n 订单编号1201710091632015853\\n 金额0\\n 商品信息123预约体验大热幼儿班\\n 订单编号', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/10', 1507538155, 1507538155, NULL),
(3, '您已购买了课程大热幼儿班', '用户名123\\n 订单编号1201710091632015853\\n 金额0\\n 商品信息123预约体验大热幼儿班\\n 订单编号', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/11', 1507539082, 1507539082, NULL),
(4, '', '用户名123<br /> 订单编号1201710091632015853<br />金额0<br /> 商品信息123预约体验大热幼儿班<br /> 订单编号', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/11', 1507539083, 1507539083, NULL),
(5, '您已购买了课程超级射手班', '用户名:123<br /> 订单编号:1201710091655298358<br /> 金额:0<br />商品信息:123预约体验超级射手班<br />订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/12', 1507539335, 1507539335, NULL),
(6, '课程超级射手班已被申请体验,请及时处理', '用户名:123<br />订单编号:1201710091655298358<br />金额:0<br />商品信息:123预约体验超级射手班<br /> 订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/12', 1507539336, 1507539336, NULL),
(7, '课程超级射手班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091655298358<br /> 金额:0<br /> 商品信息:123预约体验超级射手班<br /> 订单编号:', 6, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/12', 1507539336, 1507539336, NULL),
(8, '您已购买了课程周六上午十点低年级班', '用户名:123\\n 订单编号:1201710091659136879\\n 金额:0\\n 商品信息:123预约体验周六上午十点低年级班\\n 订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/13', 1507539555, 1507539555, NULL),
(9, '课程周六上午十点低年级班已被申请体验,请及时处理', '用户名:123\\n 订单编号:1201710091659136879\\n 金额:0\\n 商品信息:123预约体验周六上午十点低年级班\\n 订单编号:', 3, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/13', 1507539556, 1507539556, NULL),
(10, '课程周六上午十点低年级班已被申请体验,请及时处理', '用户名:123\\n 订单编号:1201710091659136879\\n 金额:0\\n 商品信息:123预约体验周六上午十点低年级班\\n 订单编号:', 1, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/13', 1507539556, 1507539556, NULL),
(11, '您已购买了课程猴塞雷课程', '用户名:123<br /> 订单编号:1201710091720145464<br /> 金额:0<br /> 商品信息:123预约体验猴塞雷课程<br /> 订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/14', 1507540816, 1507540816, NULL),
(12, '课程猴塞雷课程已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091720145464<br /> 金额:0<br /> 商品信息:123预约体验猴塞雷课程<br /> 订单编号:', 1, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/14', 1507540817, 1507540817, NULL),
(13, '您已购买了课程小学低年级初级班', '用户名:123<br /> 订单编号:1201710091741026501<br /> 金额:10<br /> 商品信息:123购买小学低年级初级班<br /> 订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/15', 1507542080, 1507542080, NULL),
(14, '课程小学低年级初级班已被购买,请及时处理', '用户名:123<br /> 订单编号:1201710091741026501<br /> 金额:10<br /> 商品信息:123购买小学低年级初级班<br /> 订单编号:', 1, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/15', 1507542080, 1507542080, NULL),
(15, '您已购买了课程超级射手班', '用户名:123<br /> 订单编号:1201710091825539450<br /> 金额:0<br /> 商品信息:123预约体验超级射手班', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/16', 1507544755, 1507544755, NULL),
(16, '课程超级射手班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091825539450<br /> 金额:0<br /> 商品信息:123预约体验超级射手班', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/16', 1507544756, 1507544756, NULL),
(17, '课程超级射手班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091825539450<br /> 金额:0<br /> 商品信息:123预约体验超级射手班', 6, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/16', 1507544756, 1507544756, NULL),
(18, '您已购买了课程大热幼儿班', '用户名:123<br /> 订单编号:1201710091826474260<br /> 金额:0<br /> 商品信息:123预约体验大热幼儿班', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/17', 1507544809, 1507544809, NULL),
(19, '您已购买了课程超级控球手', '用户名:123<br /> 订单编号:1201710091830393947<br /> 金额:0<br /> 商品信息:123预约体验超级控球手', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/18', 1507545041, 1507545041, NULL),
(20, '发给嘉兴的测试信息', '发给嘉兴的测试信息发给嘉兴的测试信息发给嘉兴的测试信息发给嘉兴的测试信息发给嘉兴的测试信息发给嘉兴的测试信息', 5, 1, 'https://m.hot-basketball.com/frontend', 0, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `pay`
--

DROP TABLE IF EXISTS `pay`;
CREATE TABLE IF NOT EXISTS `pay` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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

-- --------------------------------------------------------

--
-- 表的结构 `plan`
--

DROP TABLE IF EXISTS `plan`;
CREATE TABLE IF NOT EXISTS `plan` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member` varchar(60) NOT NULL COMMENT '作者',
  `member_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL COMMENT '所属训练营,如果是平台,为0',
  `camp` varchar(60) NOT NULL COMMENT '所属训练营,如果是平台,为0',
  `outline` varchar(250) NOT NULL COMMENT '大纲',
  `outline_detail` text NOT NULL,
  `exercise_id` int(10) NOT NULL,
  `exercise` text NOT NULL COMMENT '训练科目集合',
  `grade_category_id` text NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `rebate`
--

DROP TABLE IF EXISTS `rebate`;
CREATE TABLE IF NOT EXISTS `rebate` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收入提成';

-- --------------------------------------------------------

--
-- 表的结构 `rebate_hp`
--

DROP TABLE IF EXISTS `rebate_hp`;
CREATE TABLE IF NOT EXISTS `rebate_hp` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='HP业绩返利';

-- --------------------------------------------------------

--
-- 表的结构 `rebate_score`
--

DROP TABLE IF EXISTS `rebate_score`;
CREATE TABLE IF NOT EXISTS `rebate_score` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分返利';

-- --------------------------------------------------------

--
-- 表的结构 `salary_in`
--

DROP TABLE IF EXISTS `salary_in`;
CREATE TABLE IF NOT EXISTS `salary_in` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统发放教练佣金';

-- --------------------------------------------------------

--
-- 表的结构 `salary_out`
--

DROP TABLE IF EXISTS `salary_out`;
CREATE TABLE IF NOT EXISTS `salary_out` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金提现申请';

-- --------------------------------------------------------

--
-- 表的结构 `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `assistant_id` varchar(255) NOT NULL COMMENT '序列化',
  `assistant` varchar(255) NOT NULL COMMENT '助教,序列化',
  `coach_salary` decimal(8,2) NOT NULL,
  `assistant_salary` decimal(8,2) NOT NULL,
  `salary_base` decimal(8,2) NOT NULL,
  `leave_ids` varchar(255) NOT NULL COMMENT 'ids',
  `leave` varchar(255) NOT NULL DEFAULT '0' COMMENT '请假人员总数',
  `lesson_date` date NOT NULL COMMENT '训练日期,2017-7-26',
  `plan_id` int(10) NOT NULL COMMENT 'id',
  `plan` varchar(255) NOT NULL COMMENT '教案',
  `exercise` varchar(255) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `schedule`
--

INSERT INTO `schedule` (`id`, `camp_id`, `camp`, `lesson`, `lesson_id`, `grade`, `grade_id`, `grade_category_id`, `grade_category`, `teacher`, `teacher_id`, `coach`, `coach_id`, `students`, `student_str`, `assistant_id`, `assistant`, `coach_salary`, `assistant_salary`, `salary_base`, `leave_ids`, `leave`, `lesson_date`, `plan_id`, `plan`, `exercise`, `lesson_time`, `cover`, `province`, `city`, `area`, `court_id`, `court`, `location`, `rent`, `star`, `remarks`, `media_ids`, `media_urls`, `status`, `create_time`, `delete_time`) VALUES
(1, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 0, '', '陈侯', 0, '123abc', 5, 0, '请添加学员', '', 'weilin666', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 17, '/uploads/images/cert/2017/10/59d2320379719.JPG', '', '', '', 0, '大热前海训练中心', '', '50.00', '20.0', '', '', '', 0, 0, NULL),
(2, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 0, '', '陈侯', 0, '123abc', 5, 0, '请添加学员', '', 'weilin666', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 17, '/uploads/images/cert/2017/10/59d2320379719.JPG', '', '', '', 0, '大热前海训练中心', '', '50.00', '20.0', '', '', '', 0, 0, NULL),
(3, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 0, '', '陈侯', 0, '123abc', 5, 0, '请添加学员', '', 'weilin666', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 17, '/uploads/images/cert/2017/10/59d2320379719.JPG', '', '', '', 0, '大热前海训练中心', '', '50.00', '20.0', '', '', '', 0, 0, NULL),
(4, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 0, '', '陈侯', 0, '123abc', 5, 0, '请添加学员', '', 'weilin666', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 17, '/uploads/images/cert/2017/10/59d2320379719.JPG', '', '', '', 0, '大热前海训练中心', '', '50.00', '20.0', '', '', '', 0, 0, NULL),
(5, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 0, '', '陈侯', 0, '123abc', 5, 0, '请添加学员', '', 'weilin666', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 17, '/uploads/images/cert/2017/10/59d2320379719.JPG', '', '', '', 0, '大热前海训练中心', '', '50.00', '20.0', '', '', '', 0, 0, NULL),
(6, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 0, '', '陈侯', 0, '123abc', 5, 0, '请添加学员', '', 'weilin666', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 17, '/uploads/images/cert/2017/10/59d2320379719.JPG', '', '', '', 0, '大热前海训练中心', '', '50.00', '20.0', '', '', '', 0, 0, NULL),
(7, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(8, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(9, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(10, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(11, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(12, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(13, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(14, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(15, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(16, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL),
(17, 3, '齐天大热', '猴塞雷课程', 11, '猴塞雷私教班', 3, 0, '', '', 0, 'weilin666', 4, 0, '请添加学员', '', '', '0.00', '0.00', '0.00', '', '0', '0000-00-00', 0, '', '', 15, '/uploads/images/cert/2017/10/59d8850a7c643.JPG', '广东省', '深圳市', '南山区', 0, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `schedule_comment`
--

DROP TABLE IF EXISTS `schedule_comment`;
CREATE TABLE IF NOT EXISTS `schedule_comment` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `schedule_media`
--

DROP TABLE IF EXISTS `schedule_media`;
CREATE TABLE IF NOT EXISTS `schedule_media` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL COMMENT '对应student_id或者coach_id或者班主任id',
  `schedule` varchar(240) NOT NULL,
  `url` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `schedule_member`
--

DROP TABLE IF EXISTS `schedule_member`;
CREATE TABLE IF NOT EXISTS `schedule_member` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` int(10) NOT NULL,
  `schedule` varchar(240) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `user_id` int(10) NOT NULL COMMENT '如果身份是student,则对应student_id,coach->coach_id',
  `user` varchar(60) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:学生|2:教练;如果是1,member_id为student表的id',
  `status` tinyint(4) NOT NULL COMMENT '0:请假|1:正常',
  `schedule_time` int(10) NOT NULL COMMENT '上课时间',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课时-会员关系';

-- --------------------------------------------------------

--
-- 表的结构 `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE IF NOT EXISTS `score` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `score` int(10) NOT NULL,
  `score_des` varchar(240) NOT NULL COMMENT '积分说明:订单积分|活动积分|xxx赠送积分',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分记录表';

-- --------------------------------------------------------

--
-- 表的结构 `sells`
--

DROP TABLE IF EXISTS `sells`;
CREATE TABLE IF NOT EXISTS `sells` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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

-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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

--
-- 转存表中的数据 `setting`
--

INSERT INTO `setting` (`id`, `sitename`, `memberlevel1`, `memberlevel2`, `memberlevel3`, `coachlevel1`, `coachlevel2`, `coachlevel3`, `coachlevel4`, `coachlevel5`, `coachlevel6`, `coachlevel7`, `coachlevel8`, `keywords`, `description`, `footer`, `title`, `wxappid`, `wxsecret`, `logo`, `banner`, `lrss`, `lrcs`, `status`, `coachlevel1award`, `coachlevel2award`, `rebate`, `sysrebate`, `rebate2`, `starrebate`) VALUES
(1, '大热篮球平台', 10, 30, 50, 50, 100, 150, 0, 0, 0, 0, 0, '大热篮球平台', '大热篮球平台fsdfsdf', '© 2017 1Zstudio. All Rights Reserved.', 'HOT 大热篮球平台', '', '', '/static/default/logo.jpg', 'a:3:{i:0;s:28:\"/uploads/images/banner/1.jpg\";i:1;s:28:\"/uploads/images/banner/2.jpg\";i:2;s:28:\"/uploads/images/banner/3.jpg\";}', 50, 100, 1, 500, 1000, '0.05', '0.30', '0.03', '0.20');

-- --------------------------------------------------------

--
-- 表的结构 `smsverify`
--

DROP TABLE IF EXISTS `smsverify`;
CREATE TABLE IF NOT EXISTS `smsverify` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `phone` bigint(11) NOT NULL COMMENT '手机号码',
  `smscode` int(10) NOT NULL COMMENT '短信验证码',
  `content` text COMMENT '短信内容',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `use` varchar(50) DEFAULT NULL COMMENT '验证码使用场景,存中文',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态:0未使用|1已使用|2已失效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='发送短信';

--
-- 转存表中的数据 `smsverify`
--

INSERT INTO `smsverify` (`id`, `phone`, `smscode`, `content`, `create_time`, `use`, `status`) VALUES
(1, 13410599613, 256886, '{\"code\":256886,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506046902, '会员注册', 1),
(2, 13410599613, 491399, '{\"code\":491399,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506047215, '会员注册', 1),
(3, 18507717466, 863459, '{\"code\":863459,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506047228, '会员注册', 1),
(4, 13410599613, 638679, '{\"code\":638679,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506047344, '教练员注册', 1),
(5, 13410599613, 904975, '{\"code\":904975,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506047726, '训练营注册', 1),
(6, 15018514302, 253421, '{\"code\":253421,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506048544, '会员注册', 1),
(7, 13823599611, 547012, '{\"code\":547012,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506050381, '会员注册', 1),
(8, 13823599611, 433441, '{\"code\":433441,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506052570, '会员注册', 1),
(9, 13823559611, 855753, '{\"code\":855753,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506056146, '会员注册', 0),
(10, 13823559611, 746864, '{\"code\":746864,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506056214, '会员注册', 0),
(11, 13823599611, 487759, '{\"code\":487759,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506056275, '会员注册', 1),
(12, 15018514302, 404036, '{\"code\":404036,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506062215, '训练营注册', 1),
(13, 13410599613, 285552, '{\"code\":285552,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506062773, '会员注册', 1),
(14, 13826505160, 550853, '{\"code\":550853,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506063038, '会员注册', 1),
(15, 13826505160, 873179, '{\"code\":873179,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506063611, '训练营注册', 1),
(16, 13823599611, 473004, '{\"code\":473004,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506063718, '训练营注册', 1),
(17, 13826505160, 740730, '{\"code\":740730,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506064044, '会员注册', 1),
(18, 13826505160, 978308, '{\"code\":978308,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506065853, '训练营注册', 1),
(19, 13826505160, 186991, '{\"code\":186991,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506076199, '训练营注册', 1),
(20, 13826505160, 283654, '{\"code\":283654,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506151721, '会员注册', 1),
(21, 13684925727, 826229, '{\"code\":826229,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506169382, '会员注册', 1),
(22, 13826505160, 704293, '{\"code\":704293,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506171502, '会员注册', 1),
(23, 13826505160, 357105, '{\"code\":357105,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506171872, '会员注册', 1),
(24, 13826505160, 576532, '{\"code\":576532,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506312176, '训练营注册', 1),
(25, 18206645347, 620249, '{\"code\":620249,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506411807, '会员注册', 0),
(26, 13823599611, 660981, '{\"code\":660981,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506411817, '会员注册', 1),
(27, 18565717133, 815358, '{\"code\":815358,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506411819, '会员注册', 1),
(28, 15820474733, 300491, '{\"code\":300491,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506411908, '会员注册', 1),
(29, 13410599613, 161587, '{\"code\":161587,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506413971, '会员注册', 1),
(30, 13418931599, 225742, '{\"code\":225742,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506414102, '会员注册', 1),
(31, 13826505160, 241004, '{\"code\":241004,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506415085, '会员注册', 0),
(32, 13826505160, 166551, '{\"code\":166551,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506415156, '会员注册', 0),
(33, 13826505160, 902298, '{\"code\":902298,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506415263, '会员注册', 0),
(34, 13826505160, 132168, '{\"code\":132168,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506415490, '会员注册', 1),
(35, 15018514302, 165570, '{\"code\":165570,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506439284, '会员注册', 1),
(36, 15018514302, 663954, '{\"code\":663954,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506565190, '训练营注册', 1),
(37, 18507717466, 441088, '{\"code\":441088,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506565727, '会员注册', 1),
(38, 13662270560, 184913, '{\"code\":184913,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506576843, '会员注册', 1),
(39, 13902925499, 251065, '{\"code\":251065,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506602336, '会员注册', 1),
(40, 15018514302, 491903, '{\"code\":491903,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506606859, '会员注册', 0),
(41, 18126211925, 325568, '{\"code\":325568,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506659619, '会员注册', 1),
(42, 13684925727, 750996, '{\"code\":750996,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506683174, '会员注册', 1),
(43, 13418931599, 913122, '{\"code\":913122,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1506692984, '训练营注册', 1),
(44, 13410599613, 333604, '{\"code\":333604,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507112701, '训练营注册', 1),
(45, 18126211925, 969693, '{\"code\":969693,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507339623, '会员注册', 0),
(46, 13828880254, 152169, '{\"code\":152169,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507355122, '会员注册', 1);

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL COMMENT '对应member表id',
  `member` varchar(60) NOT NULL COMMENT '对应member表的昵称',
  `student` varchar(60) NOT NULL COMMENT '学生姓名',
  `student_sex` int(11) NOT NULL DEFAULT '1' COMMENT '学员性别:1男|2女|3未知',
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
  `total_schedule` int(10) NOT NULL DEFAULT '0',
  `finished_schedule` int(10) NOT NULL DEFAULT '0',
  `delete_time` int(10) DEFAULT NULL,
  `student_province` varchar(60) NOT NULL COMMENT '所在地区:省',
  `student_city` varchar(60) NOT NULL COMMENT '所在地区:市',
  `student_area` varchar(60) NOT NULL COMMENT '所在地区:区',
  `create_time` int(10) NOT NULL COMMENT '学员注册时间',
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`id`, `member_id`, `member`, `student`, `student_sex`, `openid`, `student_birthday`, `parent_id`, `parent`, `student_avatar`, `mobile`, `emergency_telephone`, `school`, `student_charater`, `student_weight`, `student_height`, `student_shoe_code`, `remarks`, `total_lesson`, `finished_total`, `total_schedule`, `finished_schedule`, `delete_time`, `student_province`, `student_city`, `student_area`, `create_time`, `update_time`) VALUES
(1, 8, 'woo123', '123', 1, '0', '0000-00-00', 0, '345', '/static/default/avatar.png', '', 18507717466, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 0, 0),
(2, 6, 'legend', '陈小准', 1, '0', '0000-00-00', 0, '陈烈准', '/static/default/avatar.png', '', 13826505160, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 0, 0),
(3, 13, 'Greeny', 'Easychen ', 1, '0', '0000-00-00', 0, 'Greeny', '/static/default/avatar.png', '', 13828880254, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `system_award`
--

DROP TABLE IF EXISTS `system_award`;
CREATE TABLE IF NOT EXISTS `system_award` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary` decimal(8,2) NOT NULL,
  `score` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(10) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '奖励类型:1等级|2:阶衔|3:其他',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统奖励记录表';

-- --------------------------------------------------------

--
-- 表的结构 `__court_media`
--

DROP TABLE IF EXISTS `__court_media`;
CREATE TABLE IF NOT EXISTS `__court_media` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `court_id` int(10) NOT NULL,
  `title` varchar(250) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:图片|1:视频',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='场地图片';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
