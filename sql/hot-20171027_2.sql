-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-10-27 12:03:28
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

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) UNSIGNED NOT NULL,
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
  `lastlogin_ua` varchar(200) NOT NULL DEFAULT '' COMMENT '最后登录ua'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `truename`, `email`, `avatar`, `telephone`, `stats`, `create_time`, `update_time`, `logintime`, `lastlogin_at`, `lastlogin_ip`, `lastlogin_ua`) VALUES
(1, 'admin', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', NULL, NULL, '/static/default/avatar.png', NULL, 1, 0, 1509076413, 79, 1509076413, '116.25.40.33', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.62 Safari/537.36');

-- --------------------------------------------------------

--
-- 表的结构 `bankcard`
--

CREATE TABLE `bankcard` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank` varchar(60) NOT NULL COMMENT '账号类型:支付宝|银行卡',
  `bank_card` varchar(60) NOT NULL COMMENT '账号',
  `bank_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:银行卡|2:支付宝',
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `realname` varchar(60) NOT NULL COMMENT '卡的真实姓名,不是会员的真实姓名',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) DEFAULT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='个人金融账户,支付宝,银行卡';

-- --------------------------------------------------------

--
-- 表的结构 `bill`
--

CREATE TABLE `bill` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `is_pay` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:未支付|1:已支付.用来做微信支付的回调修改',
  `pay_time` int(10) NOT NULL COMMENT '支付时间',
  `update_time` int(11) NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:未支付|1:已支付|-1:申请退款|-2:已退款',
  `refundamount` int(11) DEFAULT '0' COMMENT '申请退款金额',
  `system_remarks` varchar(255) NOT NULL COMMENT '系统备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `bill`
--

INSERT INTO `bill` (`id`, `bill_order`, `goods_id`, `goods`, `total`, `price`, `camp_id`, `camp`, `goods_type`, `goods_des`, `student_id`, `student`, `member_id`, `member`, `balance_pay`, `score_pay`, `remarks`, `pay_type`, `callback_str`, `is_pay`, `pay_time`, `update_time`, `create_time`, `delete_time`, `status`, `refundamount`, `system_remarks`) VALUES
(1, '1201709281131356649', 4, '周六上午十点低年级班', 15, '100', 2, '大热前海训练营', 1, '陈小准预约体验周六上午十点低年级班', 2, '陈小准', 6, 'legend', '0', 0, '无', '', '0', 1, 0, 1506569500, 1506569500, NULL, 1, 0, ''),
(2, '1201709281132289231', 4, '周六上午十点低年级班', 15, '100', 2, '大热前海训练营', 1, '陈小准预约体验周六上午十点低年级班', 2, '陈小准', 6, 'legend', '0', 0, '无', '', '0', 1, 0, 1506569572, 1506569572, NULL, 1, 0, ''),
(3, '1201710071347056265', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, 'Easychen 预约体验猴塞雷课程', 3, 'Easychen ', 13, 'Greeny', '0', 0, '无', '', '0', 1, 0, 1507355231, 1507355231, NULL, 1, 0, ''),
(4, '1201710071349275266', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, 'Easychen 购买猴塞雷课程', 3, 'Easychen ', 13, 'Greeny', '100', 0, '无', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1507355398, 1507355398, NULL, 1, 0, ''),
(5, '1201710091106464244', 4, '周六上午十点低年级班', 1, '100', 2, '大热前海训练营', 1, '123预约体验周六上午十点低年级班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507518508, 1507518508, NULL, 1, 0, ''),
(6, '1201710091111163910', 4, '周六上午十点低年级班', 1, '100', 2, '大热前海训练营', 1, '123预约体验周六上午十点低年级班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507518677, 1507518677, NULL, 1, 0, ''),
(7, '1201710091112263513', 4, '周六上午十点低年级班', 1, '100', 2, '大热前海训练营', 1, '123预约体验周六上午十点低年级班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507518749, 1507518749, NULL, 1, 0, ''),
(8, '1201710091632015853', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507537926, 1507537926, NULL, 1, 0, ''),
(9, '1201710091632015853', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507538100, 1507538100, NULL, 1, 0, ''),
(10, '1201710091632015853', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507538154, 1507538154, NULL, 1, 0, ''),
(11, '1201710091632015853', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507539082, 1507539082, NULL, 1, 0, ''),
(12, '1201710091655298358', 6, '超级射手班', 1, '120', 4, '准行者训练营', 1, '123预约体验超级射手班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507539335, 1507539335, NULL, 1, 0, ''),
(13, '1201710091659136879', 4, '周六上午十点低年级班', 1, '100', 2, '大热前海训练营', 1, '123预约体验周六上午十点低年级班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507539555, 1507539555, NULL, 1, 0, ''),
(14, '1201710091720145464', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, '123预约体验猴塞雷课程', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507540816, 1507540816, NULL, 1, 0, ''),
(15, '1201710091741026501', 2, '小学低年级初级班', 10, '1', 3, '齐天大热', 1, '123购买小学低年级初级班', 1, '123', 8, 'woo123', '10', 0, '无', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1507542080, 1507542080, NULL, 1, 0, ''),
(16, '1201710091825539450', 6, '超级射手班', 1, '120', 4, '准行者训练营', 1, '123预约体验超级射手班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507544755, 1507544755, NULL, 1, 0, ''),
(17, '1201710091826474260', 1, '大热幼儿班', 1, '100', 1, '大热体适能中心', 1, '123预约体验大热幼儿班', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507544809, 1507544809, NULL, 1, 0, ''),
(18, '1201710091830393947', 3, '超级控球手', 1, '120', 4, '准行者训练营', 1, '123预约体验超级控球手', 1, '123', 8, 'woo123', '0', 0, '无', '', '0', 1, 0, 1507545041, 1507545041, NULL, 1, 0, ''),
(19, '1201710101809377908', 12, '校园兴趣班', 10, '1', 3, '齐天大热', 1, '小霖购买校园兴趣班', 4, '小霖', 4, 'weilin666', '10', 0, '无', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1507630199, 1507630199, NULL, 1, 0, ''),
(20, '1201710112133332733', 13, '周日北头高年级初中班', 15, '100', 9, '大热篮球俱乐部', 1, '张晨儒购买周日北头高年级初中班', 5, '张晨儒', 15, '13537781797', '1500', 0, '无', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1507728830, 1507728830, NULL, 1, 0, ''),
(21, '1201710131538143724', 3, '超级控球手', 1, '120', 4, '准行者训练营', 1, '刘嘉预约体验超级控球手', 6, '刘嘉', 5, '123abc', '0', 0, '', '', '0', 1, 0, 1507880297, 1507880297, NULL, 1, 0, ''),
(22, '1201710141011107532', 25, '荣光篮球强化', 1, '1', 5, '荣光训练营', 1, '儿童劫预约体验荣光篮球强化', 7, '儿童劫', 10, 'wl', '0', 0, '', '', '0', 1, 0, 1507947073, 1507947073, NULL, 1, 0, ''),
(23, '1201710151832555913', 12, '校园兴趣班', 10, '1', 3, '齐天大热', 1, '123购买校园兴趣班', 1, '123', 8, 'woo123', '10', 0, '测试', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508063597, 1508063597, NULL, 1, 0, ''),
(24, '1201710150000000000', 13, '高年级班', 15, '100', 9, '大热篮球俱乐部', 1, '钟欣志购买高年级班', 8, '钟欣志', 23, '钟欣志', '1500', 0, '', 'wxpay', '', 1, 1508141658, 1508141658, 1508141658, NULL, 1, 0, '系统补录'),
(25, '1201710150000000001', 13, '高年级班', 30, '100', 9, '大热篮球俱乐部', 1, '罗翔宇购买高年级班', 9, '罗翔宇', 25, '罗翔宇', '3000', 0, '', 'wxpay', '', 1, 1508141658, 1508141658, 1508141658, NULL, 1, 0, '系统补录'),
(27, '1201710171027563375', 6, '超级射手班', 1, '1', 4, '准行者训练营', 1, '陈佳佑购买超级射手班', 11, '陈佳佑', 33, 'yanyan', '1', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508207328, 1508207328, NULL, 1, 0, ''),
(28, '1201710172007052272', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '邓赖迪购买前海小学', 13, '邓赖迪', 22, '邓赖迪', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508242055, 1508242055, NULL, 1, 0, '20171020:修改购买课程为lesson_id=31'),
(29, '1201710171027563375', 6, '超级射手班', 1, '1', 4, '准行者训练营', 1, '陈佳佑购买超级射手班', 11, '陈佳佑', 33, 'yanyan', '1', 0, '您的剩余课时为2, 您的订单总数量为1,因此退您1节课的钱', '', '', 1, 0, 1508409701, 1508248072, NULL, -2, 1, ''),
(30, '1201710150000000003', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '陈承铭购买前海小学15节课', 14, '陈承铭', 26, '陈承铭', '1500', 0, '', 'wxpay', '', 1, 1508318976, 0, 1508318976, NULL, 1, 0, '系统插入,时间2017年10月18日17:46:08'),
(31, '1201710191424259051', 12, '校园兴趣班', 1, '1', 3, '齐天大热', 1, '123预约体验校园兴趣班', 1, '123', 8, 'woo123', '0', 0, '', '', '0', 1, 0, 1508394268, 1508394268, NULL, 1, 0, ''),
(32, '1201710191449077302', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, '123预约体验猴塞雷课程', 1, '123', 8, 'woo123', '0', 0, '', '', '0', 1, 0, 1508395751, 1508395751, NULL, 1, 0, ''),
(33, '1201710191449077302', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, '123预约体验猴塞雷课程', 1, '123', 8, 'woo123', '0', 0, '', '', '0', 1, 0, 1508395890, 1508395890, NULL, 1, 0, ''),
(34, '1201710191449077302', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, '123预约体验猴塞雷课程', 1, '123', 8, 'woo123', '0', 0, '', '', '0', 1, 0, 1508395952, 1508395952, NULL, 1, 0, ''),
(35, '1201710191456452612', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, '123预约体验猴塞雷课程', 1, '123', 8, 'woo123', '0', 0, '', '', '0', 1, 0, 1508396213, 1508396213, NULL, 1, 0, ''),
(36, '1201710191458454359', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, '刘嘉预约体验猴塞雷课程', 6, '刘嘉', 5, '123abc', '0', 0, '', '', '0', 1, 0, 1508396331, 1508396331, NULL, 1, 0, ''),
(37, '1201710191504423677', 11, '猴塞雷课程', 1, '100', 3, '齐天大热', 1, '刘嘉预约体验猴塞雷课程', 6, '刘嘉', 5, '123abc', '0', 0, '', '', '0', 1, 0, 1508396685, 1508396685, NULL, 1, 0, ''),
(38, '1201710191508357622', 12, '校园兴趣班', 1, '1', 3, '齐天大热', 1, '刘嘉预约体验校园兴趣班', 6, '刘嘉', 5, '123abc', '0', 0, '', '', '0', 1, 0, 1508396925, 1508396925, NULL, 1, 0, ''),
(39, '1201710201650501601', 12, '校园兴趣班', 10, '1', 3, '齐天大热', 1, '陈小准购买校园兴趣班', 2, '陈小准', 6, 'legend', '10', 0, '哥哥哥', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508489473, 1508489473, NULL, 1, 0, ''),
(40, '1201710201655144883', 12, '校园兴趣班', 10, '1', 3, '齐天大热', 1, '陈小准购买校园兴趣班', 2, '陈小准', 6, 'legend', '10', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508489735, 1508489735, NULL, 1, 0, ''),
(41, '1201710211057457832', 36, '北大附小一年级', 15, '100', 15, '钟声训练营', 1, '陈润宏购买北大附小一年级', 15, '陈润宏', 43, '陈润宏', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508554704, 1508554704, NULL, 1, 0, ''),
(42, '1201710211059171400', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '李润弘购买前海小学', 16, '李润弘', 42, '李润弘', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508554789, 1508554789, NULL, 1, 0, ''),
(43, '1201710221039031877', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '郑肖杰购买前海小学', 17, '郑肖杰', 48, '郑肖杰', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508639991, 1508639991, NULL, 1, 0, ''),
(44, '1201710221540485210', 29, '石厦学校兰球队', 15, '100', 15, '钟声训练营', 1, '黄浩购买石厦学校兰球队', 18, '黄浩', 49, '黄浩', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508658059, 1508658059, NULL, 1, 0, ''),
(45, '1201710221644099327', 29, '石厦学校兰球队', 15, '100', 15, '钟声训练营', 1, '吴师隽购买石厦学校兰球队', 19, '吴师隽', 52, '吴师隽', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508661866, 1508661866, NULL, 1, 0, ''),
(46, '1201710222048182609', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '唐轩衡购买前海小学', 20, '唐轩衡', 55, '唐轩衡', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508676522, 1508676522, NULL, 1, 0, ''),
(47, '1201710230947598204', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '郑皓畅购买前海小学', 22, '郑皓畅', 56, '郑皓畅', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508723297, 1508723297, NULL, 1, 0, ''),
(48, '1201710230947417559', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '陈高翔购买前海小学', 21, '陈高翔', 59, '陈高翔', '1500', 0, '前海小学陈高翔', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508723329, 1508723329, NULL, 1, 0, ''),
(49, '1201710231009249234', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '战奕名购买前海小学', 25, '战奕名', 51, '战奕名', '1500', 0, '老学员组织参加十人团报，有送二课时，本次团有二名新人，饶宾，陈高翔', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508724642, 1508724642, NULL, 1, 0, ''),
(50, '1201710231029072550', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '李语辰购买前海小学', 26, '李语辰', 46, '李语辰', '1500', 0, '团购15送2', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508725787, 1508725787, NULL, 1, 0, ''),
(51, '1201710231034138371', 29, '石厦学校兰球队', 15, '100', 15, '钟声训练营', 1, '张毓楠购买石厦学校兰球队', 27, '张毓楠', 50, '张毓楠', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508726076, 1508726076, NULL, 1, 0, ''),
(52, '1201710231034543967', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '王钰龙购买前海小学', 28, '王钰龙', 60, '王钰龙', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508726144, 1508726144, NULL, 1, 0, ''),
(53, '1201710231128422121', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '刘宇恒购买前海小学', 29, '刘宇恒', 62, '刘宇恒', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508729343, 1508729343, NULL, 1, 0, ''),
(54, '1201710231147005486', 36, '北大附小一年级', 15, '100', 15, '钟声训练营', 1, '黄子诺购买北大附小一年级', 30, '黄子诺', 63, 'leonhuang', '1500', 0, '赠送球，球服，一节课', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508730453, 1508730453, NULL, 1, 0, ''),
(55, '1201710231219544391', 36, '北大附小一年级', 15, '100', 15, '钟声训练营', 1, '梁峻玮购买北大附小一年级', 33, '梁峻玮', 66, '20101119', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508732407, 1508732407, NULL, 1, 0, ''),
(56, '1201710231305331610', 36, '北大附小一年级', 15, '100', 15, '钟声训练营', 1, '刘一凡购买北大附小一年级', 34, '刘一凡', 67, 'gaojun', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508735154, 1508735154, NULL, 1, 0, ''),
(57, '120171023134850181', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '万宇宸购买前海小学', 35, '万宇宸', 61, '万宇宸', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508737748, 1508737748, NULL, 1, 0, ''),
(58, '1201710232142144641', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '邱仁鹏购买前海小学', 36, '邱仁鹏', 73, 'SZQIUJB', '1500', 0, '团购15节送2节', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508766196, 1508766196, NULL, 1, 0, ''),
(59, '1201710232145334074', 36, '北大附小一年级', 15, '100', 15, '钟声训练营', 1, '林需睦购买北大附小一年级', 38, '林需睦', 74, '13823181560', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508766362, 1508766362, NULL, 1, 0, ''),
(60, '120171023230255696', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '饶滨购买前海小学', 39, '饶滨', 58, '饶滨', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508770993, 1508770993, NULL, 1, 0, ''),
(61, '1201710241550126737', 38, 'AKcross课程', 15, '100', 13, 'AKcross训练营', 1, '游逸朗购买AKcross课程', 41, '游逸朗', 79, 'Youboy806', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508831426, 1508831426, NULL, 1, 0, ''),
(62, '1201710242055046491', 13, '高年级班', 15, '100', 9, '大热篮球俱乐部', 1, '陈宛杭购买高年级班', 42, '陈宛杭', 80, 'kiko', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508849731, 1508849731, NULL, 1, 0, ''),
(63, '1201710242108262316', 36, '北大附小一年级', 15, '100', 15, '钟声训练营', 1, '邓粤天购买北大附小一年级', 43, '邓粤天', 82, '13927482132', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508850519, 1508850519, NULL, 1, 0, ''),
(64, '1201710261039114732', 25, '荣光篮球强化', 1, '1', 5, '荣光训练营', 1, '苏楠楠购买荣光篮球强化', 52, '苏楠楠', 6, 'legend', '1', 0, '', 'wxpay', '测试', 1, 0, 1508985553, 1508985553, NULL, 1, 0, ''),
(65, '1201710261041275729', 25, '荣光篮球强化', 1, '1', 5, '荣光训练营', 1, '苏楠楠购买荣光篮球强化', 52, '苏楠楠', 6, 'legend', '1', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508985697, 1508985697, NULL, 1, 0, ''),
(66, '1201710261052274244', 36, '北大附小一年级', 15, '100', 15, '钟声训练营', 1, '姚定希购买北大附小一年级', 56, '姚定希', 86, '姚定希', '1500', 0, '', 'wxpay', '测试', 1, 0, 1508986351, 1508986351, NULL, 1, 0, ''),
(67, '1201710261056235265', 31, '前海小学', 15, '100', 15, '钟声训练营', 1, '梁懿购买前海小学', 57, '梁懿', 83, '梁懿', '1500', 0, '', 'wxpay', '测试', 1, 0, 1508986588, 1508986588, NULL, 1, 0, ''),
(68, '1201710261103254721', 25, '荣光篮球强化', 1, '1', 5, '荣光训练营', 1, '哈哈购买荣光篮球强化', 58, '哈哈', 6, 'legend', '1', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508987014, 1508987014, NULL, 1, 0, ''),
(69, '1201710261147319808', 29, '石厦学校兰球队', 15, '100', 15, '钟声训练营', 1, '陈昊阳购买石厦学校兰球队', 40, '陈昊阳', 76, 'cjwcyc', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1508989728, 1508989728, NULL, 1, 0, ''),
(70, '1201710261237283787', 25, '荣光篮球强化', 1, '1', 5, '荣光训练营', 1, '小woo购买荣光篮球强化', 46, '小woo', 8, 'woo123', '1', 0, '', 'wxpay', '测试', 1, 0, 1508992654, 1508992654, NULL, 1, 0, ''),
(71, '1201710261512286932', 36, '北大附小一年级', 15, '100', 15, '钟声训练营', 1, '周子杰购买北大附小一年级', 62, '周子杰', 81, 'rebeccazhangly', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1509001966, 1509001966, NULL, 1, 0, ''),
(72, '1201710261623183711', 32, '松坪小学', 15, '100', 15, '钟声训练营', 1, '余永康购买松坪小学', 63, '余永康', 84, '余永康', '1500', 0, '预交篮球15节课费用', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1509006276, 1509006276, NULL, 1, 0, ''),
(73, '1201710261656532143', 32, '松坪小学', 15, '100', 15, '钟声训练营', 1, '饶宏宇购买松坪小学', 66, '饶宏宇', 39, '饶宏宇', '1500', 0, '', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1509008230, 1509008230, NULL, 1, 0, ''),
(74, '1201710261715415806', 32, '松坪小学', 15, '100', 15, '钟声训练营', 1, '朱涛购买松坪小学', 67, '朱涛', 87, '朱涛', '1500', 0, '朱涛购买篮球费用', 'wxpay', '{\"err_msg\":\"get_brand_wcpay_request:ok\"}', 1, 0, 1509009392, 1509009392, NULL, 1, 0, ''),
(75, '1201710231510000000', 36, '北大附小一年级', 15, '1000', 15, '钟声训练营', 1, '蒋清奕购买北大附小一年级课程', 31, '蒋清奕', 65, '蒋清奕', '1500', 0, '', 'wxpay', '', 1, 1508774400, 1508774400, 1508774400, NULL, 1, 0, '系统插入,时间2017年10月27日11:02:26');

-- --------------------------------------------------------

--
-- 表的结构 `camp`
--

CREATE TABLE `camp` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `total_events` int(11) NOT NULL DEFAULT '0' COMMENT '活动数量',
  `total_schedule` int(10) NOT NULL DEFAULT '0',
  `logo` varchar(255) DEFAULT '/static/frontend/images/uploadDefault.jpg' COMMENT '训练营LOGO',
  `camp_base` int(10) NOT NULL DEFAULT '0' COMMENT '训练点数量',
  `remarks` text COMMENT '个人备注',
  `sys_remarks` varchar(255) DEFAULT '' COMMENT '平台备注',
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
  `balance` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '训练营余额',
  `score` int(10) NOT NULL COMMENT '训练营积分',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态:0 待审核|1 正常|2 关闭|3 重新审核',
  `create_time` int(11) NOT NULL COMMENT '创建时间戳',
  `update_time` int(11) NOT NULL COMMENT '更新时间戳',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `camp`
--

INSERT INTO `camp` (`id`, `camp`, `member_id`, `realname`, `max_member`, `total_coach`, `act_coach`, `total_member`, `act_member`, `total_lessons`, `finished_lessons`, `star`, `total_grade`, `act_grade`, `total_events`, `total_schedule`, `logo`, `camp_base`, `remarks`, `sys_remarks`, `location`, `province`, `city`, `area`, `camp_telephone`, `camp_email`, `type`, `banner`, `company`, `cert_id`, `hot`, `camp_introduction`, `balance`, `score`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '大热体适能中心', 2, '大热篮球2', 0, 0, 0, 2, 0, 0, 0, '0.00', 0, 0, 0, 0, '/uploads/images/banner/2017/09/59ca092820279.JPG', 0, '', '', '', '广东省', '深圳市', '南山区', '18565717133', '', 2, '/uploads/images/banner/2017/09/59ca0953d9cab.JPG', '大热总部', 0, 1, '大热室内训练', '0.00', 0, 1, 1506412380, 1506414363, NULL),
(2, '大热前海训练营', 3, '大热篮球1', 0, 0, 0, 2, 0, 0, 0, '0.00', 0, 0, 0, 0, '/uploads/images/banner/2017/09/59ca0937e193b.jpg', 0, '', '', '', '广东省', '深圳市', '南山区', '15820474733', '', 2, '/uploads/images/banner/2017/09/59ca099495b13.jpg', '大热总部', 0, 1, '欢迎加入大热篮球训练营', '1050.00', 0, 1, 1506412380, 1506414356, NULL),
(3, '齐天大热', 1, '陈侯', 0, 0, 0, 14, 0, 0, 0, '0.00', 2, 0, 0, 2, '/uploads/images/banner/2017/09/59ca09d5916c4.jpg', 0, '', '', '深圳总部', '广东省', '深圳市', '南山区', '13823599611', '', 2, '/uploads/images/banner/2017/10/59d8e043195d6.jpg', '大热总部', 0, 1, '大热猴塞雷', '105.00', 0, 1, 1506412381, 1507385417, NULL),
(4, '准行者训练营', 6, '陈烈准', 0, 0, 0, 6, 0, 7, 0, '0.00', 4, 0, 0, 0, '/uploads/images/banner/2017/09/59ca142b31f86.JPG', 0, '', '', '', '广东省', '深圳市', '南山区', '13826505160', '', 0, '/uploads/images/banner/2017/09/59ca14360c76b.JPG', '', 0, 1, 'I believe I can fly!', '2.10', 0, 1, 1506415619, 1506422262, NULL),
(5, '荣光训练营', 7, '张伟荣', 0, 0, 0, 5, 0, 1, 0, '0.00', 5, 0, 0, 4, '/uploads/images/banner/2017/09/59cc5d0d7ab73.jpg', 0, '', '', '', '广东省', '深圳市', '福田区', '15018514302', '', 2, '/uploads/images/banner/2017/09/59cc5d126da55.jpg', '', 0, 1, '暂时没有', '2.80', 0, 1, 1506565273, 1507105258, NULL),
(9, '大热篮球俱乐部', 2, '大热篮球', 0, 0, 0, 4, 0, 12, 0, '0.00', 0, 0, 0, 0, '/uploads/images/banner/2017/09/59ce0f0bb2253.JPG', 0, '', '系统增加balance=3150,2017年10月18日15:37:31', '深圳南山阳光文体中心', '广东省', '深圳市', '南山区', '18565717133', '', 1, '/uploads/images/banner/2017/09/59ce0f1cd8156.JPG', '大热体育文化（深圳）有限公司', 0, 0, '', '5250.00', 0, 1, 1506676445, 1507628247, NULL),
(13, 'AKcross训练营', 18, '安凯翔', 0, 0, 0, 1, 0, 2, 0, '0.00', 0, 0, 0, 0, '/static/frontend/images/uploadDefault.jpg', 0, '', '', '', '广东省', '深圳市', '南山区', '', '', 0, '/static/frontend/images/uploadDefault.jpg', '', 0, 0, '', '1050.00', 0, 1, 1507951263, 1507966904, NULL),
(14, 'Ball  is  life', 17, '董硕同', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 0, 0, 0, '/uploads/images/banner/2017/10/59e1839a81d25.jpeg', 0, '', '', '', '广东省', '深圳市', '南山区', '13172659677', '', 0, '/uploads/images/banner/2017/10/59e183b19362c.jpeg', '', 0, 0, '练就对了', '0.00', 0, 1, 1507951319, 1507966910, NULL),
(15, '钟声训练营', 19, '钟声', 0, 0, 0, 29, 0, 5, 0, '0.00', 4, 0, 0, 0, '/static/frontend/images/uploadDefault.jpg', 0, '', '系统增加balance=1050,时间2017年10月18日17:26:30,历史会员+1,余额30450+1050,时间2017年10月27日10:53:10', '', '广东省', '深圳市', '南山区', '', '', 1, '/static/frontend/images/uploadDefault.jpg', '', 0, 0, '', '31500.00', 0, 1, 1508037092, 1508037092, NULL),
(16, '热风学校', 11, '陈永仁', 0, 0, 0, 0, 0, 0, 0, '0.00', 0, 0, 0, 0, '/uploads/images/banner/2017/10/59e2d345277ff.JPG', 0, '', '', '深圳湾', '广东省', '深圳市', '南山区', '', '', 1, '/uploads/images/banner/2017/10/59e2d35c3b1d1.JPG', '大热集团', 0, 0, '热风籃球社團', '0.00', 0, 1, 1508037396, 1508041161, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `camp_comment`
--

CREATE TABLE `camp_comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `comment` text NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(18, 3, '齐天大热', 'cool', 'hot111', 11, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKJwIOoK7eq3g5cId6ic0tY0CjlYvib95yq8fOurvnGL5FqtEB1FIub1ygjHQ5DetTaYwExnaibudnFA/0', 1507350936, 1507350936, NULL),
(19, 1, '大热体适能中心', '哈哈哈', '堡', 0, 'https://wx.qlogo.cn/mmopen/vi_32/rZEIzYRP1Qt4n9Jmgialoj3O2oH6mLw0P3ZZRc3hHpXQjN51gP3CAfBGsBPg3iaBFuycfkgAJicib09EaKt8IM4t1w/0', 1508484568, 1508484568, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `camp_member`
--

CREATE TABLE `camp_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1:学生|2:教练|3:管理员|4:创建者|-1:粉丝',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:待审核|1:正常|2:退出|-1:被辞退|3:''已毕业''|-2:被拒绝',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='训练营身份权限表';

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
(7, 3, '齐天大热', 4, 'weilin666', '加入做教练', 2, 1, 1506414192, NULL, 1507630647),
(8, 2, '大热前海训练营', 4, 'weilin666', '加入做教练', 2, 1, 1506414206, NULL, 1506414379),
(9, 1, '大热体适能中心', 4, 'weilin666', '加入教练', 2, 1, 1506414220, NULL, 1506414603),
(10, 3, '齐天大热', 5, '123abc', '江河湖海', 2, -1, 1506414545, NULL, 0),
(11, 2, '大热前海训练营', 5, '123abc', '嘉兴', 2, 1, 1506414561, NULL, 0),
(12, 1, '大热体适能中心', 5, '123abc', '嘉兴', 2, 1, 1506414573, NULL, 0),
(13, 4, '准行者训练营', 6, '陈烈准', '创建训练营', 4, 1, 1506415619, NULL, 1506415619),
(15, 4, '准行者训练营', 1, 'HoChen', '我', 3, 1, 1506502597, NULL, 0),
(16, 5, '荣光训练营', 7, '张伟荣', '创建训练营', 4, 1, 1506565273, NULL, 1506565273),
(17, 4, '准行者训练营', 8, 'woo123', '我要成为管理员', 3, 1, 1506566640, NULL, 0),
(18, 2, '大热前海训练营', 6, 'legend', '', 1, 1, 1506569500, NULL, 1506569500),
(20, 2, '大热前海训练营', 1, 'HoChen', '我', 3, 1, 1506655861, NULL, 0),
(25, 9, '大热篮球俱乐部', 2, '大热篮球', '创建训练营', 4, 1, 1506676445, NULL, 1506676445),
(29, 4, '准行者训练营', 7, 'wayen_z', '我要成为粉丝', 2, 1, 1506754252, NULL, 0),
(31, 3, '齐天大热', 11, 'hot111', 'Hi', 2, 0, 1507350804, NULL, 0),
(32, 3, '齐天大热', 13, 'Greeny', '', 1, 1, 1507355231, NULL, 1507355231),
(33, 2, '大热前海训练营', 8, 'woo123', '', 1, 1, 1507518508, NULL, 1507518508),
(34, 1, '大热体适能中心', 8, 'woo123', '', 1, 1, 1507538155, NULL, 1507538155),
(35, 4, '准行者训练营', 8, 'woo123', '', 1, 1, 1507539336, NULL, 1507539336),
(36, 3, '齐天大热', 8, 'woo123', '', 1, 1, 1507540817, NULL, 1507540817),
(37, 3, '齐天大热', 4, 'weilin666', '买了课程', 1, 1, 1506414192, NULL, 1507796249),
(38, 9, '大热篮球俱乐部', 15, '13537781797', '', 1, 1, 1507728831, NULL, 1507728831),
(39, 9, '大热篮球俱乐部', 3, 'Hot Basketball 1', '冯冯冯', 3, 1, 1507778591, NULL, 1508469017),
(40, 4, '准行者训练营', 5, '123abc', '', 1, 1, 1507880299, NULL, 1507880299),
(41, 5, '荣光训练营', 4, 'weilin666', '测试推送', 2, 1, 1507890574, NULL, 1508255562),
(42, 5, '荣光训练营', 4, 'weilin666', '手动改数据的', 1, 1, 1507947074, NULL, 1508984150),
(43, 13, 'AKcross训练营', 18, '安凯翔', '创建训练营', 4, 1, 1507951263, NULL, 1507951263),
(44, 14, 'Ball  is  life', 17, '董硕同', '创建训练营', 4, 1, 1507951319, NULL, 1507951319),
(45, 3, '齐天大热', 24, 'Hot777', 'Yo ', 2, 1, 1507972576, NULL, 1507972674),
(46, 15, '钟声训练营', 19, '钟声', '创建训练营', 4, 1, 1508037092, NULL, 1508037092),
(47, 16, '热风学校', 11, '陈永仁', '创建训练营', 4, 1, 1508037396, NULL, 1508037396),
(48, 16, '热风学校', 1, 'HoChen', '我', 3, 0, 1508040916, NULL, 1508040916),
(49, 9, '大热篮球俱乐部', 6, 'legend', '准哥加入，查看数据', 3, 1, 1508055043, NULL, 1508055043),
(51, 9, '大热篮球俱乐部', 23, '钟欣志', '系统插入2017年10月18日17:34:40', 1, 1, 1508141658, NULL, 0),
(52, 9, '大热篮球俱乐部', 25, '罗翔宇', '系统插入2017年10月18日17:34:43', 1, 1, 1508141658, NULL, 0),
(53, 4, '准行者训练营', 33, 'yanyan', '', 1, 1, 1508206653, NULL, 1508206653),
(54, 2, '大热前海训练营', 22, '邓赖迪', '', 1, 1, 1508242058, NULL, 1508242058),
(55, 15, '钟声训练营', 27, '陈承铭', '系统插入2017年10月18日17:30:21', 1, 1, 1508318976, NULL, 0),
(58, 3, '齐天大热', 5, '123abc', '', 1, 1, 1508396332, NULL, 1508396332),
(59, 4, '准行者训练营', 4, 'weilin666', '加入做教务\n', 3, 1, 1508399193, NULL, 1508399256),
(60, 15, '钟声训练营', 2, 'Hot-basketball2', 'ttt', 3, -1, 1508469074, NULL, 1508859524),
(61, 3, '齐天大热', 6, 'legend', '', 1, 1, 1508489474, NULL, 1508489474),
(62, 15, '钟声训练营', 43, '陈润宏', '', 1, 1, 1508554705, NULL, 1508554705),
(63, 15, '钟声训练营', 42, '李润弘', '', 1, 1, 1508554790, NULL, 1508554790),
(64, 15, '钟声训练营', 48, '郑肖杰', '', 1, 1, 1508639992, NULL, 1508639992),
(65, 15, '钟声训练营', 49, '黄浩', '', 1, 1, 1508658061, NULL, 1508658061),
(66, 15, '钟声训练营', 52, '吴师隽', '', 1, 1, 1508661867, NULL, 1508661867),
(67, 15, '钟声训练营', 55, '唐轩衡', '', 1, 1, 1508676524, NULL, 1508676524),
(68, 15, '钟声训练营', 56, '郑皓畅', '', 1, 1, 1508723298, NULL, 1508723298),
(69, 15, '钟声训练营', 59, '陈高翔', '', 1, 1, 1508723330, NULL, 1508723330),
(70, 15, '钟声训练营', 51, '战奕名', '', 1, 1, 1508724644, NULL, 1508724644),
(71, 15, '钟声训练营', 46, '李语辰', '', 1, 1, 1508725788, NULL, 1508725788),
(72, 15, '钟声训练营', 50, '张毓楠', '', 1, 1, 1508726077, NULL, 1508726077),
(73, 15, '钟声训练营', 60, '王钰龙', '', 1, 1, 1508726145, NULL, 1508726145),
(74, 15, '钟声训练营', 62, '刘宇恒', '', 1, 1, 1508729344, NULL, 1508729344),
(75, 15, '钟声训练营', 63, 'leonhuang', '', 1, 1, 1508730455, NULL, 1508730455),
(76, 15, '钟声训练营', 66, '20101119', '', 1, 1, 1508732408, NULL, 1508732408),
(77, 15, '钟声训练营', 67, 'gaojun', '', 1, 1, 1508735155, NULL, 1508735155),
(78, 15, '钟声训练营', 61, '万宇宸', '', 1, 1, 1508737749, NULL, 1508737749),
(79, 15, '钟声训练营', 73, 'SZQIUJB', '', 1, 1, 1508766198, NULL, 1508766198),
(80, 15, '钟声训练营', 74, '13823181560', '', 1, 1, 1508766363, NULL, 1508766363),
(81, 15, '钟声训练营', 58, '饶滨', '', 1, 1, 1508770994, NULL, 1508770994),
(82, 13, 'AKcross训练营', 2, 'Hot-basketball2', '哗啦啦啦啦', 3, 1, 1508829675, NULL, 1508829726),
(83, 13, 'AKcross训练营', 79, 'Youboy806', '', 1, 1, 1508831427, NULL, 1508831427),
(84, 9, '大热篮球俱乐部', 78, '张雅璐', '恭喜发财', 3, 1, 1508831833, NULL, 1508923164),
(85, 2, '大热前海训练营', 78, '张雅璐', '情比金坚', 2, 0, 1508833047, NULL, 1508833047),
(86, 9, '大热篮球俱乐部', 19, '钟声', '钟声', 2, 1, 1508849680, NULL, 1508854111),
(87, 9, '大热篮球俱乐部', 80, 'kiko', '', 1, 1, 1508849732, NULL, 1508849732),
(88, 15, '钟声训练营', 82, '13927482132', '', 1, 1, 1508850520, NULL, 1508850520),
(89, 9, '大热篮球俱乐部', 18, '18566201712', 'jjjj', 2, 1, 1508917693, NULL, 1508919856),
(90, 5, '荣光训练营', 6, 'legend', '', 1, 1, 1508985553, NULL, 1508985553),
(91, 15, '钟声训练营', 86, '姚定希', '', 1, 1, 1508986357, NULL, 1508986357),
(92, 15, '钟声训练营', 83, '梁懿', '', 1, 1, 1508986589, NULL, 1508986589),
(93, 15, '钟声训练营', 76, 'cjwcyc', '', 1, 1, 1508989728, NULL, 1508989728),
(94, 5, '荣光训练营', 8, 'woo123', '', 1, 1, 1508992655, NULL, 1508992655),
(95, 15, '钟声训练营', 81, 'rebeccazhangly', '', 1, 1, 1509001967, NULL, 1509001967),
(96, 15, '钟声训练营', 84, '余永康', '', 1, 1, 1509006277, NULL, 1509006277),
(97, 15, '钟声训练营', 36, 'Gavin.zhuang', '申请助教', 2, 1, 1509007513, NULL, 1509007968),
(98, 15, '钟声训练营', 39, '饶宏宇', '', 1, 1, 1509008231, NULL, 1509008231),
(99, 15, '钟声训练营', 87, '朱涛', '', 1, 1, 1509009392, NULL, 1509009392),
(100, 15, '钟声训练营', 65, '蒋清奕', '系统插入2017年10月27日10:43:48', 1, 1, 1508774400, NULL, 1508774400);

-- --------------------------------------------------------

--
-- 表的结构 `camp_power`
--

CREATE TABLE `camp_power` (
  `id` int(10) UNSIGNED NOT NULL,
  `camp_id` int(10) NOT NULL,
  `member_id` int(10) NOT NULL COMMENT '角色名称',
  `coach` tinyint(4) NOT NULL DEFAULT '0' COMMENT '有教练权限就是1',
  `admin` tinyint(4) NOT NULL DEFAULT '0' COMMENT '管理员',
  `owner` tinyint(4) NOT NULL DEFAULT '0' COMMENT '拥有者',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员角色表';

-- --------------------------------------------------------

--
-- 表的结构 `cert`
--

CREATE TABLE `cert` (
  `id` int(10) UNSIGNED NOT NULL,
  `camp_id` int(10) NOT NULL COMMENT '所属训练营id',
  `member_id` int(10) NOT NULL COMMENT '用户id',
  `cert_no` varchar(60) NOT NULL COMMENT '证件号码',
  `cert_type` tinyint(4) NOT NULL COMMENT '1:身份证;2:学生证;3:教练资质证书;4:营业执照|5:银行卡',
  `photo_positive` varchar(255) NOT NULL COMMENT '证件照正面',
  `photo_back` varchar(255) NOT NULL COMMENT '证件照背面',
  `portrait` varchar(255) NOT NULL COMMENT '肖像',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:未审核|1:正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='证件表';

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
(40, 12, 0, '', 0, '/uploads/images/cert/2017/10/59d4b88d51d9c.jpg', '', '', 0, 1507113103, 1507113103),
(41, 0, 19, ' 440301196908292114', 1, '/uploads/images/cert/2017/10/59df3bf864a91.jpg', '/uploads/images/cert/2017/10/59df3c1413d7d.jpg', '', 0, 1507804421, 1508325011),
(42, 0, 19, '', 3, '/uploads/images/cert/2017/10/59df3e187efa2.jpg', '', '', 0, 1507804421, 1508325011),
(43, 0, 18, '650203199203270732', 1, '/uploads/images/cert/2017/10/59e181f56865f.png', '/uploads/images/cert/2017/10/59e181fec1ed5.jpg', '', 0, 1507951149, 1507951149),
(44, 0, 18, '0', 3, '/uploads/images/cert/2017/10/59e181116d09e.jpg', '', '', 0, 1507951149, 1507951149),
(45, 0, 17, '230203199207091215', 1, '/uploads/images/cert/2017/10/59e180eb3de82.jpeg', '/uploads/images/cert/2017/10/59e180f7ddee4.jpeg', '', 0, 1507951194, 1507951194),
(46, 0, 17, '0', 3, '/uploads/images/cert/2017/10/59e1815bebf5d.jpeg', '', '', 0, 1507951194, 1507951194),
(47, 0, 24, '44030', 1, '/uploads/images/cert/2017/10/59e1d0294f353.JPG', '/uploads/images/cert/2017/10/59e1d03290abc.JPG', '', 0, 1507971658, 1507971658),
(48, 0, 24, '0', 3, '/uploads/images/cert/2017/10/59e1d0924a601.JPG', '', '', 0, 1507971658, 1507971658),
(49, 16, 0, '', 4, '/uploads/images/cert/2017/10/59e2d45eb06d8.JPG', '', '', 0, 1508037774, 1508037774),
(50, 16, 0, '44030', 1, '/uploads/images/cert/2017/10/59e2d46555d40.JPG', '', '', 0, 1508037774, 1508037774),
(51, 16, 11, '44030', 1, '/uploads/images/cert/2017/10/59e2d477a1de1.JPG', '', '', 0, 1508037774, 1508037774),
(52, 16, 0, '', 0, '/uploads/images/cert/2017/10/59e2d489387f5.JPG', '', '', 0, 1508037774, 1508037774),
(53, 0, 78, '421022199402250060', 1, '/uploads/images/cert/2017/10/59eeed9a7c153.jpeg', '/uploads/images/cert/2017/10/59eeeda705f1f.jpeg', '', 0, 1508830799, 1508830799),
(54, 0, 78, '0', 3, '/uploads/images/cert/2017/10/59eeede72f23d.jpeg', '', '', 0, 1508830799, 1508830799),
(55, 0, 36, '441723199212043413', 1, '/uploads/images/cert/2017/10/59f19e41345ad.jpg', '/uploads/images/cert/2017/10/59f19e5332940.jpg', '', 0, 1509006951, 1509006951),
(56, 0, 36, '0', 3, '/uploads/images/cert/2017/10/59f19e634d6c1.JPG', '', '', 0, 1509006951, 1509006951);

-- --------------------------------------------------------

--
-- 表的结构 `coach`
--

CREATE TABLE `coach` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `delete_time` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `coach`
--

INSERT INTO `coach` (`id`, `coach`, `sex`, `province`, `city`, `area`, `member_id`, `student_flow`, `schedule_flow`, `star`, `create_time`, `update_time`, `coach_rank`, `cert_id`, `tag1`, `tag2`, `tag3`, `tag4`, `tag5`, `coach_year`, `experience`, `introduction`, `remarks`, `sys_remarks`, `portraits`, `description`, `coach_level`, `status`, `delete_time`) VALUES
(1, '刘伟霖', 1, '广东省', '深圳市', '南山区', 4, 0, 0, '0.0', 1506414074, 1507184567, 1, 0, '', '', '', '', '', 1, '哈哈哈哈哈哈或或或', '方式的发送到发送到', '', '', '/uploads/images/cert/2017/09/59ca0dd2685f8.jpg', '绕弯儿翁二', 1, 1, NULL),
(2, '刘嘉兴', 1, '广东省', '深圳市', '南山区', 5, 0, 0, '0.0', 1506414257, 1506414481, 1, 0, '', '', '', '', '', 24, '1', '1', '', '', '/uploads/images/cert/2017/09/59ca0e8af1cb1.jpg', '1', 1, 1, NULL),
(3, '陈侯', 1, '广东省', '深圳市', '南山区', 1, 0, 0, '0.0', 1506667013, 1506904225, 1, 0, '', '', '', '', '', 5, '猴塞雷', '真的猴塞雷', '', '', '/uploads/images/cert/2017/10/59d1888c3a6ef.jpg', '????', 1, 1, NULL),
(4, '冼玉华', 1, '广东省', '深圳市', '龙岗区', 2, 0, 0, '0.0', 1506675797, 1507718188, 1, 0, '', '', '', '', '', 1, '11', '11', '', '', '/uploads/images/cert/2017/09/59ce0c29d5db2.JPG', '。', 1, 1, NULL),
(5, '陈准', 1, '广东省', '深圳市', '南山区', 6, 0, 0, '0.0', 1506759874, 1507718197, 1, 0, '', '', '', '', '', 8, '只能说很有经验', '迷一样的人', '', '', '/uploads/images/cert/2017/09/59cf544ea3c59.JPG', '好好学习天天大热', 1, 1, NULL),
(6, '张伟荣', 1, '广东省', '深圳市', '福田区', 7, 0, 0, '0.0', 1507105159, 1507718181, 1, 0, '', '', '', '', '', 5, '暂无', '无', '', '', '/uploads/images/cert/2017/10/59d499501334c.jpg', '全力以赴', 1, 1, NULL),
(7, '钟声', 1, '广东省', '深圳市', '南山区', 19, 0, 0, '0.0', 1507804421, 1508325011, 1, 0, '', '', '', '', '', 10, '带好每个篮球队的教学需要教练要有颗积极奉献精神，言传身教，把先进教学技能传授学员，培养不同年令段学员对学习篮球兴趣爱好。', '国家一级运动员，吉林省体工队篮球运动员，国家体育总局篮球二级社会指导员，广州体育学院篮球专业，深圳市体育发展中心篮球职业队运动员。', '', '', '/uploads/images/cert/2017/10/59df3c4e3cb4c.jpeg', '带好每一名学员，培养学员团队意识，，，努力拚搏，勇不言败。', 1, 1, NULL),
(11, 'Michael Mcgrath', 1, '广东省', '深圳市', '南山区', 24, 0, 0, '0.0', 1507971658, 1507971967, 1, 0, '', '', '', '', '', 8, '8年体适能从业经验', '来自澳大利亚', '', '', '/uploads/images/cert/2017/10/59e1d08826771.PNG', 'Just believe in yourself ', 1, 1, NULL),
(12, '张雅璐', 1, '广东省', '深圳市', '南山区', 78, 0, 0, '0.0', 1508830799, 1508831035, 1, 0, '', '', '', '', '', 0, '0', '0', '', '', '/uploads/images/cert/2017/10/59eeedd7b6458.jpeg', '0', 1, 1, NULL),
(13, '庄贵钦', 1, '广东省', '深圳市', '南山区', 36, 0, 0, '0.0', 1509006951, 1509006951, 1, 0, '', '', '', '', '', 2, '带过小学初中班，校园大课堂', '\n来自广东阳江，热爱篮球，喜欢篮球', '', '', '/uploads/images/cert/2017/10/59f19d3085f3a.JPG', '热爱生活热爱工作', 1, 0, NULL),
(9, '安凯翔', 1, '广东省', '深圳市', '南山区', 18, 0, 0, '0.0', 1507951149, 1507966837, 1, 0, '', '', '', '', '', 6, '老到九十九,小到刚会走，拿起篮球，就能牛！', '我很帅', '', '', '/uploads/images/cert/2017/10/59e180fb14501.jpg', '十倍努力，守我初心', 1, 1, NULL),
(10, '董硕同', 1, '广东省', '深圳市', '南山区', 17, 0, 0, '0.0', 1507951194, 1507966717, 1, 0, '', '', '', '', '', 3, '带领的班级有：幼儿班、小学低年级班、小学高年级班、初中班，私教课，教学经验丰富。', '国家篮球二级运动员\n国家篮球二级社会体育指导员\n东莞NBA篮球学校中级教练员', '', '', '/uploads/images/cert/2017/10/59e18107be68d.jpeg', '不仅传授球技，更想通过篮球传授给学员人生的道理，篮球育人。', 1, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `coach_comment`
--

CREATE TABLE `coach_comment` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `court`
--

CREATE TABLE `court` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `court`
--

INSERT INTO `court` (`id`, `province`, `city`, `area`, `court`, `camp_id`, `camp`, `location`, `principal`, `open_time`, `contract`, `remarks`, `sys_remarks`, `chip_rent`, `full_rent`, `half_rent`, `outdoors`, `cover`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '广东省', '深圳市', '南山区', '大热前海训练中心', 0, '系统', '', '陈侯', '8:00-20:00', '0755-22222222', '', '系统场地', '0.00', '0.00', '0.00', 0, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 1, 1506410999, 1506410999, NULL),
(3, '广东省', '深圳市', '南山区', '前海北头运动场', 0, '系统', '', '', '', '', '', '', '0.00', '0.00', '0.00', 1, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 1, 0, 0, NULL),
(5, '广东省', '深圳市', '南山区', '阳光文体中心迷你场', 4, '准行者训练营', '桂庙路口116号', '陈准', '09:00-22:00', '26650516', '一个迷你综合小球场', '', '20.00', '200.00', '100.00', 2, 'a:2:{i:0;s:47:\"/uploads/images/court/2017/09/59cc9f61b14d0.JPG\";i:1;s:47:\"/uploads/images/court/2017/09/59cc9f89dbbb9.JPG\";}', 1, 0, 1507718141, NULL),
(7, '广东省', '深圳市', '南山区', '阳光迷你场', 4, '准行者训练营', '哪里', '准的', '1213', '13826505160', '测试', '', '10.00', '200.00', '100.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/09/59cf722b2d8e8.JPG\";}', 0, 1506767406, 1506767406, NULL),
(8, '广东省', '深圳市', '福田区', '荣光场', 5, '荣光训练营', '福田', '张伟荣', '9:00-18:00', '15018514302', '暂时没有', '', '30.00', '300.00', '150.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/10/59d1c4e76cf4c.jpg\";}', 1, 1506919679, 1507718136, NULL),
(9, '广东省', '深圳市', '南山区', '海滨实验小学篮球场', 3, '齐天大热', '学府路', '无名', '0', '0', '仅周末使用', '', '0.00', '0.00', '0.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/10/59d1ce09eeccd.JPG\";}', 0, 1506921998, 1506921998, NULL),
(10, '广东省', '深圳市', '福田区', '荣光训练场', 5, '荣光训练营', '福田车公庙', '张伟荣', '上午9点～下午18:00', '15018514302', '没有', '', '20.00', '200.00', '100.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/10/59d49a910409d.jpg\";}', 0, 1507105426, 1507105426, NULL),
(11, '广东省', '深圳市', '龙岗区', '龙岗公安分局训练场', 9, '大热篮球俱乐部', '龙岗', '龙岗民警', '全天', '123456', '', '', '0.00', '0.00', '0.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1507712069, 1507712069, NULL),
(12, '广东省', '深圳市', '南山区', '南山天台兰球场', 15, '钟声训练营', '北环大道', '1', '1', '1', '', '', '1.00', '240.00', '120.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1508037328, 1508037328, NULL),
(13, '广东省', '深圳市', '福田区', '福田体育公园兰球场', 15, '钟声训练营', '福田体育公园', '1', '1', '1', '', '', '1.00', '280.00', '140.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1508037524, 1508037524, NULL),
(14, '广东省', '深圳市', '南山区', '前海小学', 15, '钟声训练营', '前海小学', '1', '1', '1', '', '', '0.00', '0.00', '0.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1508037658, 1508037658, NULL),
(15, '广东省', '深圳市', '南山区', '松坪小学', 15, '钟声训练营', '松坪小学', '1', '1', '1', '', '', '1.00', '0.00', '0.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1508037742, 1508037742, NULL),
(16, '广东省', '深圳市', '南山区', '丽山文体中心篮球场', 13, 'AKcross训练营', '丽水路110', '杨先生', '朝八晚十一', '18688943424', '…', '', '10.00', '170.00', '85.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1508218903, 1508218903, NULL),
(17, '广东省', '深圳市', '南山区', '星海名城小区兰球场', 15, '钟声训练营', '星海名城一期', '0', '6', '0', '', '', '1.00', '2.00', '1.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1508306333, 1508306333, NULL),
(18, '广东省', '深圳市', '南山区', '丽山文体中心', 13, 'AKcross训练营', '广东省深圳市南山区丽山路197号', '安生', '全天', '18566201712', '………', '', '10.00', '170.00', '85.00', 2, 'a:1:{i:0;s:47:\"/uploads/images/court/2017/10/59e731c5d99a6.jpg\";}', 0, 1508323785, 1508323785, NULL),
(19, '广东省', '深圳市', '南山区', '南外文华球场', 13, 'AKcross训练营', ' 0', '安教练', '0', '18566201712', '0', '', '0.00', '0.00', '0.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1508829630, 1508829630, NULL),
(20, '广东省', '深圳市', '南山区', '塘朗球场', 13, 'AKcross训练营', '塘朗大舞台', '安教练', '0', '18566201712', 'z', '', '0.00', '0.00', '0.00', 2, 'a:3:{i:0;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:1;s:41:\"/static/frontend/images/uploadDefault.jpg\";i:2;s:41:\"/static/frontend/images/uploadDefault.jpg\";}', 0, 1508829701, 1508829701, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `court_camp`
--

CREATE TABLE `court_camp` (
  `id` int(10) UNSIGNED NOT NULL,
  `court` varchar(255) NOT NULL,
  `court_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '是否可用:1可用|-1:不可用',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(13, '荣光训练场', 10, 5, '荣光训练营', 1, 1507105426, 1507105426, NULL),
(14, '前海北头运动场', 3, 9, '大热篮球俱乐部', 0, 1507705419, 1507705419, NULL),
(15, '大热前海训练中心', 1, 9, '大热篮球俱乐部', 0, 1507705433, 1507705433, NULL),
(16, '龙岗公安分局训练场', 11, 9, '大热篮球俱乐部', 1, 1507712069, 1507712069, NULL),
(17, '南山天台兰球场', 12, 15, '钟声训练营', 1, 1508037328, 1508037328, NULL),
(18, '福田体育公园兰球场', 13, 15, '钟声训练营', 1, 1508037524, 1508037524, NULL),
(19, '前海小学', 14, 15, '钟声训练营', 1, 1508037658, 1508037658, NULL),
(20, '松坪小学', 15, 15, '钟声训练营', 1, 1508037742, 1508037742, NULL),
(21, '丽山文体中心篮球场', 16, 13, 'AKcross训练营', 1, 1508218903, 1508218903, NULL),
(22, '星海名城小区兰球场', 17, 15, '钟声训练营', 1, 1508306333, 1508306333, NULL),
(23, '丽山文体中心', 18, 13, 'AKcross训练营', 1, 1508323785, 1508323785, NULL),
(24, '南外文华球场', 19, 13, 'AKcross训练营', 1, 1508829630, 1508829630, NULL),
(25, '塘朗球场', 20, 13, 'AKcross训练营', 1, 1508829702, 1508829702, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `event`
--

CREATE TABLE `event` (
  `id` int(10) UNSIGNED NOT NULL,
  `event` varchar(255) NOT NULL COMMENT '活动主题',
  `organization_id` int(10) NOT NULL COMMENT '组织id',
  `organization` varchar(60) NOT NULL COMMENT '组织名称:训练|校园',
  `organization_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:训练营|2:校园',
  `target_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:不限|2:营内|3:班内',
  `target_id` int(10) NOT NULL DEFAULT '0' COMMENT '具体对象id',
  `target` varchar(60) NOT NULL COMMENT '具体对象名称',
  `event_type` varchar(60) NOT NULL COMMENT '活动类型:团队建设balabla',
  `is_free` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:免费|2:收费',
  `price` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '活动单价',
  `finance` varchar(60) NOT NULL COMMENT '活动结算人',
  `finance_id` int(10) NOT NULL COMMENT '活动结算人的member_id',
  `member` varchar(60) NOT NULL COMMENT '发布者和最后更新人',
  `member_id` int(10) NOT NULL COMMENT '发布者和最后更新者的member_id',
  `start` int(10) NOT NULL,
  `end` int(10) NOT NULL,
  `event_time` int(10) NOT NULL COMMENT '具体活动时间',
  `participator` int(10) NOT NULL COMMENT '报名数|参与者数量',
  `province` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `area` varchar(60) NOT NULL,
  `location` varchar(255) NOT NULL COMMENT '活动场地',
  `max` tinyint(4) NOT NULL DEFAULT '99' COMMENT '最大参与数',
  `min` tinyint(4) NOT NULL DEFAULT '2' COMMENT '最小参与数',
  `event_des` text NOT NULL COMMENT '活动简介',
  `contract` varchar(60) NOT NULL,
  `telephone` varchar(60) NOT NULL,
  `cover` varchar(255) NOT NULL DEFAULT '/static/frontend/images/uploadDefault.jpg',
  `remarks` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `event_member`
--

CREATE TABLE `event_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) NOT NULL,
  `event` varchar(255) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `is_pay` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:已缴费|2:未缴费',
  `is_sign` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否签到 0:未签到|1:已签到',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:已报名|2:已签到|3:以参与|4:中途退出',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='活动-会员关系表';

-- --------------------------------------------------------

--
-- 表的结构 `exercise`
--

CREATE TABLE `exercise` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `update_time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `grade` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `coach_salary` int(8) NOT NULL DEFAULT '0' COMMENT '主教练佣金',
  `assistant_id` varchar(255) NOT NULL COMMENT '副教练id集合,序列化,member.id',
  `assistant` varchar(255) NOT NULL COMMENT '副教练,序列化,对应',
  `assistant_salary` int(8) DEFAULT '0' COMMENT '助教底薪',
  `salary_base` int(10) NOT NULL DEFAULT '0' COMMENT '人头基数',
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
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '-1:预排;1:正常|2:下架',
  `delete_time` int(10) DEFAULT NULL,
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `grade`
--

INSERT INTO `grade` (`id`, `lesson`, `lesson_id`, `gradecate`, `gradecate_id`, `grade`, `camp_id`, `camp`, `leader`, `leader_id`, `teacher`, `teacher_id`, `coach`, `coach_id`, `coach_salary`, `assistant_id`, `assistant`, `assistant_salary`, `salary_base`, `students`, `week`, `lesson_time`, `start`, `end`, `province`, `city`, `area`, `location`, `plan`, `plan_id`, `court`, `court_id`, `rent`, `remarks`, `status`, `delete_time`, `create_time`, `update_time`) VALUES
(1, '小学低年级初级班', 2, '幼儿兴趣班（4-6岁）', 5, '陈班豆丁', 3, '齐天大热', '陈侯', 1, '陈侯', 1, '123abc', 5, 100, 'a:1:{i:0;s:1:\"6\";}', 'a:1:{i:0;s:9:\"weilin666\";}', 0, 10, 0, '周日', '17:00', 0, 0, '', '', '', '', '', 0, '大热前海训练中心', 2, '50.00', '', -1, 1507361630, 1506936198, 1507361630),
(2, '小学低年级初级班', 2, '幼儿兴趣班（4-6岁）', 5, '陈班豆丁', 3, '齐天大热', '陈侯', 1, '陈侯', 1, '123abc', 5, 100, 'a:1:{i:0;s:1:\"6\";}', 'a:1:{i:0;s:9:\"weilin666\";}', 0, 10, 0, '周日', '17:00', 0, 0, '广东省', '深圳市', '南山区', '', '', 0, '大热前海训练中心', 2, '50.00', '', 1, NULL, 1506936199, 1508472456),
(3, '猴塞雷课程', 11, '私教（4-18岁）', 34, '猴塞雷私教班', 3, '齐天大热', '', 0, '', 0, 'weilin666', 4, 20, 'a:1:{i:0;s:2:\"11\";}', 'a:1:{i:0;s:15:\"Michael Mcgrath\";}', 0, 10, 0, '周五', '00:00', 0, 0, '广东省', '深圳市', '南山区', '', '', 0, '大热前海训练中心', 2, '0.00', '', -1, NULL, 1507361617, 1508839950),
(4, '超级控球手', 3, '体验班（4-18岁）', 35, '测试班', 4, '准行者训练营', '', 0, '', 0, '陈准', 5, 120, 'a:1:{i:0;s:1:\"1\";}', 'a:1:{i:0;s:9:\"刘伟霖\";}', 100, 30, 1, '周二,周四', '10:10,08:00', 0, 0, '广东省', '深圳市', '南山区', '深圳南山北头', '', 0, '阳光迷你场', 2, '0.00', '测试一下', 1, NULL, 1507699218, 1509018952),
(5, '荣光篮球强化', 25, '体验班（4-18岁）', 35, '荣光测试营', 0, '', '张伟荣', 6, '张伟荣', 6, '张伟荣', 6, 100, 'a:1:{i:0;s:1:\"6\";}', 'a:1:{i:0;s:9:\"张伟荣\";}', 80, 20, 0, '周三', '16:30', 0, 0, '', '', '', '前海', '', 0, '荣光训练场', 0, '0.00', '', -1, NULL, 1508142698, 1508142698),
(6, '荣光篮球强化', 25, '体验班（4-18岁）', 35, '荣光测试营', 0, '', '张伟荣', 6, '张伟荣', 6, '张伟荣', 6, 100, 'a:1:{i:0;s:1:\"6\";}', 'a:1:{i:0;s:9:\"张伟荣\";}', 80, 20, 0, '周三', '16:30', 0, 0, '', '', '', '前海', '', 0, '荣光训练场', 0, '0.00', '', -1, NULL, 1508142707, 1508142707),
(7, '超级射手班', 6, '校园兴趣班（4-18岁）', 37, '测试版2', 0, '', '陈准', 5, '', 0, '张伟荣', 6, 120, '', '', 100, 80, 0, '周二', '10:11', 0, 0, '', '', '', '测试', '', 0, '大热前海训练中心', 0, '0.00', '', 1, NULL, 1508206607, 1508206607),
(8, '荣光篮球强化', 25, '体验班（4-18岁）', 35, '荣光体验班', 5, '荣光训练营', '张伟荣', 6, '张伟荣', 6, '张伟荣', 6, 100, 'a:1:{i:0;s:1:\"6\";}', 'a:1:{i:0;s:9:\"张伟荣\";}', 0, 5, 1, '周三', '09:40', 0, 0, '广东省', '深圳市', '南山区', '南山荣光', '', 0, '荣光训练场', 0, '0.00', '测试，没有哦', 1, NULL, 1508255376, 1509018808),
(12, '平台示例请勿购买', 37, '企业（事业单位）', 38, '天才班', 4, '准行者训练营', '', 0, '', 0, '陈准', 5, 120, '', '', 0, 20, 0, '周二,周四', '17:30,13:00', 0, 0, '广东省', '深圳市', '南山区', '阳光文体中心', '', 0, '阳光迷你场', 0, '0.00', '', 1, NULL, 1508648702, 1509018944),
(16, '校园兴趣班', 12, '校园兴趣班（4-18岁）', 37, '陈班豆丁222', 3, '齐天大热', '', 0, '', 0, 'Michael Mcgrath', 11, 222, '', '', 0, 0, 2, '周一', '00:00', 0, 0, '广东省', '深圳市', '南山区', '学府路', '', 0, '海滨实验小学篮球场', 0, '0.00', '', -1, 1508747591, 1508747575, 1508747591),
(21, '北大附小一年级', 36, '低年组球队（7-9岁）', 23, '北大附小周三五', 15, '钟声训练营', '', 0, '', 0, '钟声', 7, 200, '', '', 0, 20, 9, '周三,周五', '18:00,14:30', 0, 0, '广东省', '深圳市', '南山区', '星海名城一期', '', 0, '星海名城小区兰球场', 17, '0.00', '', 1, NULL, 1508991708, 1509073844),
(22, '石厦学校兰球队', 29, '初高中球队（13-18岁）', 26, '石厦学校兰球队', 15, '钟声训练营', '', 0, '', 0, '钟声', 7, 200, '', '', 0, 20, 4, '周日', '16:00', 0, 0, '广东省', '深圳市', '福田区', '福田体育公园', '', 0, '福田体育公园兰球场', 13, '0.00', '', 1, NULL, 1508991944, 1508991944),
(23, '前海小学', 31, '小学 - 综合班（7-9岁）', 12, '前海小学兰球班', 15, '钟声训练营', '', 0, '', 0, '钟声', 7, 200, '', '', 0, 20, 14, '周日', '08:30', 0, 0, '广东省', '深圳市', '南山区', '前海小学', '', 0, '前海小学', 14, '0.00', '', 1, NULL, 1508992187, 1508992187),
(24, '松坪小学', 32, '小学校队（7-12岁）', 25, '松坪小学兰球班', 15, '钟声训练营', '', 0, '', 0, '钟声', 7, 200, 'a:1:{i:0;s:2:\"13\";}', 'a:1:{i:0;s:9:\"庄贵钦\";}', 0, 20, 3, '周日', '08:30', 0, 0, '广东省', '深圳市', '南山区', '松坪小学', '', 0, '松坪小学', 15, '0.00', '', 1, NULL, 1509006913, 1509009518);

-- --------------------------------------------------------

--
-- 表的结构 `grade_category`
--

CREATE TABLE `grade_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '课程分类名',
  `status` tinyint(4) NOT NULL COMMENT '状态:1正常|-1禁用|0默认',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程分类';

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

CREATE TABLE `grade_member` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `avatar` varchar(255) NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '头像',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '2:体验生|1:正式学生',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '-1:离营|0:待审核|1:正常|2:退出|3:被开除|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='班级-会员关联表';

--
-- 转存表中的数据 `grade_member`
--

INSERT INTO `grade_member` (`id`, `grade`, `grade_id`, `lesson`, `lesson_id`, `camp_id`, `camp`, `student_id`, `student`, `member`, `member_id`, `rest_schedule`, `avatar`, `type`, `remarks`, `status`, `create_time`, `delete_time`, `update_time`) VALUES
(1, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 2, '陈小准', 'legend', 6, 15, '', 2, '', 1, 1506569500, NULL, 0),
(2, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 2, '陈小准', 'legend', 6, 15, '', 2, '', 1, 1506569572, NULL, 0),
(3, '猴塞雷私教班', 3, '猴塞雷课程', 11, 3, '齐天大热', 3, 'Easychen ', 'Greeny', 13, 2, '', 2, '', 1, 1507355231, NULL, 1508839950),
(4, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 1, '123', 'woo123', 8, 4, '', 2, '', 1, 1507518508, NULL, 1507518508),
(5, '', 0, '大热幼儿班', 1, 1, '大热体适能中心', 1, '123', 'woo123', 8, 5, '/static/default/avatar.png', 2, '', 1, 1507537926, NULL, 1507537926),
(6, '', 0, '超级射手班', 6, 4, '准行者训练营', 1, '123', 'woo123', 8, 2, '/static/default/avatar.png', 2, '', 1, 1507539335, NULL, 1507539335),
(7, '猴塞雷私教班', 3, '猴塞雷课程', 11, 3, '齐天大热', 1, '123', 'woo123', 8, 5, '/static/default/avatar.png', 2, '', 1, 1507540816, NULL, 1508839950),
(8, '陈班豆丁', 2, '小学低年级初级班', 2, 3, '齐天大热', 1, '123', 'woo123', 8, 10, '/static/default/avatar.png', 1, '', 1, 1507542080, NULL, 1508472456),
(9, '测试班', 4, '超级控球手', 3, 4, '准行者训练营', 1, '123', 'woo123', 8, 1, '/static/default/avatar.png', 2, '', 1, 1507545041, NULL, 1509018402),
(10, '', 0, '校园兴趣班', 12, 3, '齐天大热', 4, '小霖', 'weilin666', 4, 10, '/static/default/avatar.png', 1, '', 1, 1507630199, NULL, 1507630199),
(12, '', 0, '周日北头高年级初中班', 13, 9, '大热篮球俱乐部', 5, '张晨儒', '13537781797', 15, 15, '/static/default/avatar.png', 1, '', 1, 1507728830, NULL, 1507728830),
(13, '0', 0, '超级控球手', 3, 4, '准行者训练营', 6, '刘嘉', '123abc', 5, 1, '/static/default/avatar.png', 2, '', 1, 1507880297, NULL, 1509018952),
(14, '荣光体验班', 8, '荣光篮球强化', 25, 5, '荣光训练营', 7, '儿童劫', 'wl', 10, 1, '/static/default/avatar.png', 2, '', 1, 1507947073, NULL, 1509018783),
(15, '', 0, '校园兴趣班', 12, 3, '齐天大热', 1, '123', 'woo123', 8, 11, '/static/default/avatar.png', 1, '', 1, 1508063597, NULL, 1508063597),
(16, '', 0, '大热高级班', 13, 9, '大热篮球俱乐部', 8, '钟欣志', '钟欣志', 23, 15, '/static/default/avatar.png', 1, '系统插入', 1, 1508141658, NULL, 0),
(17, '', 0, '大热高级班', 13, 9, '大热篮球俱乐部', 9, '罗翔宇', '罗翔宇', 25, 30, '/static/default/avatar.png', 1, '系统插入', 1, 1508141658, NULL, 0),
(19, '', 0, '超级射手班', 6, 4, '准行者训练营', 11, '陈佳佑', 'yanyan', 33, 1, '/static/default/avatar.png', 1, '', 1, 1508207328, NULL, 1508207328),
(20, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 13, '邓赖迪', '邓赖迪', 22, 15, '/static/default/avatar.png', 1, '', 1, 1508242055, NULL, 1508242055),
(21, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 14, '陈承铭', '陈承铭', 26, 15, '/static/default/avatar.png', 1, '系统插入,时间2017年10月18日17:40:19', 1, 1508318976, NULL, 1508992187),
(22, '猴塞雷私教班', 3, '猴塞雷课程', 11, 3, '齐天大热', 6, '刘嘉', '123abc', 5, 2, 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYIDwRM5lic1WWW9mKWFS1a1fYeA/0', 2, '', 1, 1508396331, NULL, 1508839950),
(23, '', 0, '校园兴趣班', 12, 3, '齐天大热', 6, '刘嘉', '123abc', 5, 1, 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYIDwRM5lic1WWW9mKWFS1a1fYeA/0', 2, '', 1, 1508396925, NULL, 1508747575),
(24, '', 0, '校园兴趣班', 12, 3, '齐天大热', 2, '陈小准', 'legend', 6, 20, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', 1, 1508489473, NULL, 1508747575),
(25, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 15, '陈润宏', '陈润宏', 43, 15, 'https://wx.qlogo.cn/mmopen/vi_32/wCFb3b7CBRJSuXQazfF7N0GIfuhF53JRlkVEq2Z2pUgIMraJI2iaWwCONHk7nkJibrUQiaEyU8yrPxianhMIyuArdg/0', 1, '', 1, 1508554704, NULL, 1508991708),
(26, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 16, '李润弘', '李润弘', 42, 15, 'https://wx.qlogo.cn/mmopen/vi_32/icD3j8Uhe4xOLJS1zichGLY3rfpJAI4Efd95vMQxlBhSABPWicw4tOHsyY2rnPVAFDbAohTvsMAxoLIo49bA33Z1g/0', 1, '', 1, 1508554789, NULL, 1508992187),
(27, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 17, '郑肖杰', '郑肖杰', 48, 15, 'https://wx.qlogo.cn/mmopen/vi_32/8B6CScn6mZribr9bTI1RhDEiaQvCtKUKp9BmL1VLoamZWKFF3mHqfOOw2zN5gOIFCBpwsycFWFnr6SulEH2hRLBA/0', 1, '', 1, 1508639991, NULL, 1508992187),
(28, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 18, '黄浩', '黄浩', 49, 15, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIn1c0h4Xcn8dISicib3c5qRUsmhvibqvQMY7q3qFUSVw36nw1XW7GEQx1nVkkWQyEyGbtr6JMuBOfyg/0', 1, '', 1, 1508658059, NULL, 1508991944),
(29, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 19, '吴师隽', '吴师隽', 52, 15, 'https://wx.qlogo.cn/mmopen/vi_32/NYp0qdFEpicQ36DW8ZpibPCSVAf3NSCNJgwbgKerkcXV3wlXwUdn0XfgBf26eIZ4tqibxT5ScU6el8A1bouRwibcJg/0', 1, '', 1, 1508661866, NULL, 1508991944),
(30, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 20, '唐轩衡', '唐轩衡', 55, 15, 'https://wx.qlogo.cn/mmopen/vi_32/VVyUyM6Q3vHB0kvA47iafepgr2L2vx8nvxzeSIKqJQLGz6qA9RWloXBmvCic1r4pD1chaLOLck0y4r3aibFmEE1YQ/0', 1, '', 1, 1508676522, NULL, 1508992187),
(31, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 22, '郑皓畅', '郑皓畅', 56, 15, 'https://wx.qlogo.cn/mmopen/vi_32/6zNQeeicR57x1lcicY9mgX2MBCibf3OkicIKIvEcq1Ec7ibFPRFkEtg8nKeBoiaNfrwoGmvu9Wt5BWo9HicxroYqjRZsw/0', 1, '', 1, 1508723297, NULL, 1508992187),
(32, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 21, '陈高翔', '陈高翔', 59, 15, 'https://wx.qlogo.cn/mmopen/vi_32/yzvxOetibI0IK3Jjwxb8AhFLpiaf8sEqjkhPwXgtr0JRXWJNIVDBvT6QjblpFABBKGCvGryia5xz20zwzEg5BZ6dg/0', 1, '', 1, 1508723329, NULL, 1508992187),
(33, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 25, '战奕名', '战奕名', 51, 15, 'https://wx.qlogo.cn/mmopen/vi_32/v4IpFsmBcCwGN9D1SzfmfahDia8p8l3saE3DbWnmOY2HCClXCmfibzzw3H3hcnbXAAkcwQH6icJxiabSc03HnXSLlA/0', 1, '', 1, 1508724642, NULL, 1508992187),
(34, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 26, '李语辰', '李语辰', 46, 15, 'https://wx.qlogo.cn/mmopen/vi_32/JVWE6PQ990A8KoicXXxCEzKP2trTcWSkBsW16ibaYbTZHSTA4mOy410wA2u9uuxUB0FiavLiaBkicKCp9icc9Rgry7HQ/0', 1, '', 1, 1508725787, NULL, 1508992187),
(35, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 27, '张毓楠', '张毓楠', 50, 15, 'https://wx.qlogo.cn/mmopen/vi_32/ywnQfcMqe2uC9KP2fDr6QorLMk8FFkIL3IUpfJn7D8707CEIfcUwLEOLGf85A0C9bY4a29ZkcfkGa3RwSKoMbw/0', 1, '', 1, 1508726076, NULL, 1508991944),
(36, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 28, '王钰龙', '王钰龙', 60, 15, 'https://wx.qlogo.cn/mmopen/vi_32/mpqiaCLKTSkHXZbs2GqFnjoflrkMib2j49z5yM8VHDmmUSicHZI5iak2Tia6ykX7tXT8TOBYB2v9UaYmnJ99Z0FCO0g/0', 1, '', 1, 1508726144, NULL, 1508992187),
(37, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 29, '刘宇恒', '刘宇恒', 62, 15, 'https://wx.qlogo.cn/mmopen/vi_32/dg5BzBbk6ialKxBfoWtI9iayIQS6b5pG0QF1ib4YiauZics9fBRksgtWibAcHYEGiaJbjOR4W0jOgGJIb6LAwiapjEkkbg/0', 1, '', 1, 1508729343, NULL, 1508992187),
(38, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 30, '黄子诺', 'leonhuang', 63, 15, 'https://wx.qlogo.cn/mmopen/vi_32/PH3lR9dDe7o1dzyQIgkpkLhkOchMTwEEqQ3TI2oKPmxGNOKbgicYAV4wORoMLw2NGBaNDjVMv8x38BjJRibThTzg/0', 1, '', 1, 1508730453, NULL, 1508991708),
(39, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 33, '梁峻玮', '20101119', 66, 15, 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Du6wQajIibtJa0SkWurB9LkfK1vR4BQiaZ14GnibibNdUdOG0iaQlVvcthLcx7Qf0mKBBLw/0', 1, '', 1, 1508732407, NULL, 1508991708),
(40, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 34, '刘一凡', 'gaojun', 67, 15, 'https://wx.qlogo.cn/mmopen/vi_32/x7dO3qq2JzUkwK79rS0ZmwrnficUG7mB9bAUOQ7lB52dY5uhUMgBFPQoAsY5w1LWrzYwDROVSKrYoqmq6qgYrcg/0', 1, '', 1, 1508735154, NULL, 1508991708),
(41, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 35, '万宇宸', '万宇宸', 61, 15, 'https://wx.qlogo.cn/mmopen/vi_32/pnKFC33CDdnArcQ0ONDFVdlQ1yF6aewh99xgKW3G72iaruRr1oGTIwV8gfpfptb4VpBdicrZ9pJLwpib50cYrfVVw/0', 1, '', 1, 1508737748, NULL, 1508992187),
(42, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 36, '邱仁鹏', 'SZQIUJB', 73, 15, 'https://wx.qlogo.cn/mmopen/vi_32/oBJMukfMx9mAfOFLL6oILN4zz1F39lUDnibK34DTlPq3YUq2P7gWk4muj1cDFKMQLlN5ypREzibVJO4yKSEUK62w/0', 1, '', 1, 1508766196, NULL, 1508992187),
(43, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 38, '林需睦', '13823181560', 74, 15, 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqicTFZcNkXiaVqLpNeiapVYiaItQ1hGcic0s9BCKqx2aDYVMSD9KNkhuVmtZyvCXASgk1I6jH9LbMw4HQ/0', 1, '', 1, 1508766362, NULL, 1508991708),
(44, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 39, '饶滨', '饶滨', 58, 15, 'https://wx.qlogo.cn/mmopen/vi_32/3q4wOibh9nZPekaEh1mPpULmJARKuuXRphK7Mak1kTjCNNIibNEjNicoEVtmJLT9G7kjoNZ6vllcLteP8vibyXiaj0A/0', 1, '', 1, 1508770993, NULL, 1508992187),
(45, '', 0, 'AKcross课程', 38, 13, 'AKcross训练营', 41, '游逸朗', 'Youboy806', 79, 15, 'https://wx.qlogo.cn/mmopen/vi_32/LMPP1EaHUlWoor4A7ibKMl1XM80TcezRI5GgwThYwOHPybVktqd8QicgtYr8svs4LPxP0bmSpszQtricUuCGPtuFg/0', 1, '', 1, 1508831426, NULL, 1508831426),
(46, '', 0, '高年级班', 13, 9, '大热篮球俱乐部', 42, '陈宛杭', 'kiko', 80, 15, 'https://wx.qlogo.cn/mmopen/vi_32/zocbwtq7yDlo6zSBZ0jmSgpaHaFWmAotUTmzHopaB1Vl8DVWP9Gdd7U37xhdUkg30Z6HE6BzIBKGqEJBRDQOLA/0', 1, '', 1, 1508849731, NULL, 1508849731),
(47, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 43, '邓粤天', '13927482132', 82, 15, 'https://wx.qlogo.cn/mmhead/jJSbu4Te5ib9GgS8EBYzj9DGPl5G68qqDVadUWdDKYdNwEibDBUlFaPA/0', 1, '', 1, 1508850519, NULL, 1508991708),
(48, '0', 0, '荣光篮球强化', 25, 5, '荣光训练营', 52, '苏楠楠', 'legend', 6, 2, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', 1, 1508985553, NULL, 1509018797),
(49, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 56, '姚定希', '姚定希', 86, 15, 'https://wx.qlogo.cn/mmhead/BfRL3E0G1pdy5s3m2OtzHEbJ0tv6PFPzUu34m3zQ3XzzmlMkMgGMOg/0', 1, '', 1, 1508986351, NULL, 1508991708),
(50, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 57, '梁懿', '梁懿', 83, 15, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIZILv4jZfYyLDTSDRic2TicWv1Lqsy7ibgV1LK3PiaycF11vJQ2Ud4PrDa0XvcQEhdaEAEkb2feNbtCQ/0', 1, '', 1, 1508986588, NULL, 1508992187),
(51, '0', 0, '荣光篮球强化', 25, 5, '荣光训练营', 58, '哈哈', 'legend', 6, 1, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', 1, 1508987014, NULL, 1509018808),
(52, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 40, '陈昊阳', 'cjwcyc', 76, 15, 'https://wx.qlogo.cn/mmopen/vi_32/GCNUn1n4CPiaMuVncIvb0u3mCyCNIYOQmjMVuSx5SrGOPe94lWMticoCRn3G2qry302FPPTkcichHEpKrzwIb1TrA/0', 1, '', 1, 1508989728, NULL, 1508991944),
(53, '0', 0, '荣光篮球强化', 25, 5, '荣光训练营', 46, '小woo', 'woo123', 8, 1, 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1, '', 1, 1508992654, NULL, 1509018808),
(54, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 62, '周子杰', 'rebeccazhangly', 81, 15, 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Dribia5ZQu19qPDlO8LQuwYfbEKvkc4np2NicicpECusbLsAYMLtVn4pT8IcyBibvMnjL6w/0', 1, '', 1, 1509001966, NULL, 1509018809),
(55, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 63, '余永康', '余永康', 84, 15, 'https://wx.qlogo.cn/mmopen/vi_32/AvTOBqK5D0azFkS8BVibFucZyG9z9rLicQYL7FkBl6QicS6z4mdNejuvU4Qial8z9wOfInP4anVMAK7sAeoX5A1tOg/0', 1, '', 1, 1509006276, NULL, 1509009518),
(56, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 66, '饶宏宇', '饶宏宇', 39, 15, 'https://wx.qlogo.cn/mmopen/vi_32/QiaJBRJFj5Xt3S5WluEumvf6C68fm3U1NBVpSlicePadW44QHt3aDljkr1iaYYZDH2LlXibQfFIlp2oNaxX6dHAasg/0', 1, '', 1, 1509008230, NULL, 1509009518),
(57, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 67, '朱涛', '朱涛', 87, 15, 'https://wx.qlogo.cn/mmhead/uchmtWQh7iaqm9z1QucKESYwDiasve3glVvHvDEEEvZmEBJrp26SDrcA/0', 1, '', 1, 1509009392, NULL, 1509009518),
(58, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 31, '蒋清奕', '蒋清奕', 65, 15, '/static/default/avatar.png', 1, '系统插入,时间2017年10月27日10:58:40', 1, 1508774400, NULL, 1509073844);

-- --------------------------------------------------------

--
-- 表的结构 `income`
--

CREATE TABLE `income` (
  `id` int(10) UNSIGNED NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `lesson` varchar(60) NOT NULL,
  `camp_id` int(10) NOT NULL COMMENT '训练营id',
  `camp` varchar(60) NOT NULL,
  `income` decimal(12,2) NOT NULL COMMENT '训练营收入',
  `member_id` int(10) NOT NULL COMMENT '购买者id',
  `member` varchar(60) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='训练营收入表';

--
-- 转存表中的数据 `income`
--

INSERT INTO `income` (`id`, `lesson_id`, `lesson`, `camp_id`, `camp`, `income`, `member_id`, `member`, `remarks`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 11, '猴塞雷课程', 3, '3', '70.00', 13, 'Greeny', '', 1507355398, 0, NULL),
(2, 2, '小学低年级初级班', 3, '3', '7.00', 8, 'woo123', '', 1507542080, 0, NULL),
(3, 12, '校园兴趣班', 3, '3', '7.00', 4, 'weilin666', '', 1507630200, 0, NULL),
(4, 13, '周日北头高年级初中班', 9, '9', '1050.00', 15, '13537781797', '', 1507728831, 0, NULL),
(5, 12, '校园兴趣班', 3, '3', '7.00', 8, 'woo123', '', 1508063598, 0, NULL),
(6, 6, '超级射手班', 4, '4', '0.70', 33, 'yanyan', '', 1508206653, 0, NULL),
(7, 6, '超级射手班', 4, '4', '0.70', 33, 'yanyan', '', 1508207330, 0, NULL),
(8, 4, '周六上午十点低年级班', 2, '2', '1050.00', 22, '邓赖迪', '', 1508242058, 0, NULL),
(9, 6, '超级射手班', 4, '4', '0.70', 33, 'yanyan', '', 1508248072, 0, NULL),
(10, 13, '高年级班', 9, '大热篮球俱乐部', '1050.00', 23, '钟欣志', '系统补录', 1508256000, 0, NULL),
(11, 13, '高年级班', 9, '大热篮球俱乐部', '2100.00', 25, '罗翔宇', '系统补录', 1508256000, 0, NULL),
(12, 33, '前海小学', 15, '钟声训练营', '1050.00', 26, '陈承铭', '系统补录', 1508256000, 0, NULL),
(13, 12, '校园兴趣班', 3, '3', '7.00', 6, 'legend', '', 1508489474, 0, NULL),
(14, 12, '校园兴趣班', 3, '3', '7.00', 6, 'legend', '', 1508489736, 0, NULL),
(15, 36, '北大附小一年级', 15, '15', '1050.00', 43, '陈润宏', '', 1508554705, 0, NULL),
(16, 31, '前海小学', 15, '15', '1050.00', 42, '李润弘', '', 1508554790, 0, NULL),
(17, 31, '前海小学', 15, '15', '1050.00', 48, '郑肖杰', '', 1508639992, 0, NULL),
(18, 29, '石厦学校兰球队', 15, '15', '1050.00', 49, '黄浩', '', 1508658061, 0, NULL),
(19, 29, '石厦学校兰球队', 15, '15', '1050.00', 52, '吴师隽', '', 1508661867, 0, NULL),
(20, 31, '前海小学', 15, '15', '1050.00', 55, '唐轩衡', '', 1508676524, 0, NULL),
(21, 31, '前海小学', 15, '15', '1050.00', 56, '郑皓畅', '', 1508723298, 0, NULL),
(22, 31, '前海小学', 15, '15', '1050.00', 59, '陈高翔', '', 1508723330, 0, NULL),
(23, 31, '前海小学', 15, '15', '1050.00', 51, '战奕名', '', 1508724644, 0, NULL),
(24, 31, '前海小学', 15, '15', '1050.00', 46, '李语辰', '', 1508725788, 0, NULL),
(25, 29, '石厦学校兰球队', 15, '15', '1050.00', 50, '张毓楠', '', 1508726077, 0, NULL),
(26, 31, '前海小学', 15, '15', '1050.00', 60, '王钰龙', '', 1508726145, 0, NULL),
(27, 31, '前海小学', 15, '15', '1050.00', 62, '刘宇恒', '', 1508729344, 0, NULL),
(28, 36, '北大附小一年级', 15, '15', '1050.00', 63, 'leonhuang', '', 1508730455, 0, NULL),
(29, 36, '北大附小一年级', 15, '15', '1050.00', 66, '20101119', '', 1508732408, 0, NULL),
(30, 36, '北大附小一年级', 15, '15', '1050.00', 67, 'gaojun', '', 1508735155, 0, NULL),
(31, 31, '前海小学', 15, '15', '1050.00', 61, '万宇宸', '', 1508737749, 0, NULL),
(32, 31, '前海小学', 15, '15', '1050.00', 73, 'SZQIUJB', '', 1508766198, 0, NULL),
(33, 36, '北大附小一年级', 15, '15', '1050.00', 74, '13823181560', '', 1508766364, 0, NULL),
(34, 31, '前海小学', 15, '15', '1050.00', 58, '饶滨', '', 1508770994, 0, NULL),
(35, 38, 'AKcross课程', 13, '13', '1050.00', 79, 'Youboy806', '', 1508831427, 0, NULL),
(36, 13, '高年级班', 9, '9', '1050.00', 80, 'kiko', '', 1508849732, 0, NULL),
(37, 36, '北大附小一年级', 15, '15', '1050.00', 82, '13927482132', '', 1508850520, 0, NULL),
(38, 25, '荣光篮球强化', 5, '5', '0.70', 6, 'legend', '', 1508985553, 0, NULL),
(39, 25, '荣光篮球强化', 5, '5', '0.70', 6, 'legend', '', 1508985698, 0, NULL),
(40, 36, '北大附小一年级', 15, '15', '1050.00', 86, '姚定希', '', 1508986357, 0, NULL),
(41, 31, '前海小学', 15, '15', '1050.00', 83, '梁懿', '', 1508986589, 0, NULL),
(42, 25, '荣光篮球强化', 5, '5', '0.70', 6, 'legend', '', 1508987015, 0, NULL),
(43, 29, '石厦学校兰球队', 15, '15', '1050.00', 76, 'cjwcyc', '', 1508989728, 0, NULL),
(44, 25, '荣光篮球强化', 5, '5', '0.70', 8, 'woo123', '', 1508992655, 0, NULL),
(45, 36, '北大附小一年级', 15, '15', '1050.00', 81, 'rebeccazhangly', '', 1509001967, 0, NULL),
(46, 32, '松坪小学', 15, '15', '1050.00', 84, '余永康', '', 1509006277, 0, NULL),
(47, 32, '松坪小学', 15, '15', '1050.00', 39, '饶宏宇', '', 1509008231, 0, NULL),
(48, 32, '松坪小学', 15, '15', '1050.00', 87, '朱涛', '', 1509009393, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `lesson`
--

CREATE TABLE `lesson` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `status` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '0:未审核;1:正常;-1:下架',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `lesson`
--

INSERT INTO `lesson` (`id`, `lesson`, `member`, `member_id`, `leader_id`, `leader`, `gradecate`, `gradecate_id`, `camp`, `camp_id`, `cost`, `total`, `score`, `coach`, `coach_id`, `assistant`, `assistant_id`, `teacher`, `teacher_id`, `min`, `max`, `week`, `start`, `end`, `lesson_time`, `dom`, `sort`, `hot`, `hit`, `students`, `province`, `city`, `area`, `court_id`, `court`, `location`, `telephone`, `cover`, `remarks`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '大热幼儿班', 'Hot-basketball2', 2, 0, '', '幼儿篮球兴趣班', 1, '大热体适能中心', 1, '100', 1, 0, '刘伟霖', 1, '', '', '', 0, 4, 10, '周日', '0000-00-00', '0000-00-00', '10:30:00', 'a:1:{i:0;s:2:\"15\";}', 0, 1, 0, 5, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/lesson/5.jpg', '', 1, 0, 1507778640, 1507778640),
(2, '小学低年级初级班', 'HoChen', 1, 0, '', '基础篮球课程', 6, '齐天大热', 3, '120', 1, 0, '刘伟霖', 1, '', '', '', 0, 1, 15, '周日', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"10\";}', 0, 1, 0, 1, '广东省', '深圳市', '南山区', 3, '前海北投运动场', '', '', '/uploads/images/lesson/6.jpg', '', 1, 0, 0, NULL),
(3, '超级控球手', 'legend', 6, 0, '', '强化篮球课程', 0, '准行者训练营', 4, '120', 1, 0, '陈准', 3, 'a:2:{i:0;s:9:\"张伟荣\";i:1;s:6:\"陈准\";}', 'a:2:{i:0;s:1:\"6\";i:1;s:1:\"5\";}', '', 0, 5, 10, '周日', '0000-00-00', '0000-00-00', '18:40:00', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"5\";i:2;s:2:\"10\";}', 0, 1, 0, 2, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/lesson/7.jpg', '', -1, 0, 1508387642, NULL),
(4, '周六上午十点低年级班', 'Hot Basketball 1', 3, 0, '', '基础篮球课程', 6, '大热前海训练营', 2, '100', 1, 0, '刘嘉兴', 2, 'a:1:{i:0;s:9:\"刘伟霖\";}', 'a:1:{i:0;s:1:\"1\";}', '', 0, 4, 10, '周六', '0000-00-00', '0000-00-00', '10:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 1, 0, 7, '广东省', '深圳市', '南山区', 3, '前海北投运动场', '', '', '/uploads/images/lesson/8.jpg', '', -1, 0, 1508469252, NULL),
(5, '射手特训班', 'HoChen', 1, 5, '刘嘉兴', '强化篮球课程', 16, '齐天大热', 3, '200', 1, 0, '刘伟霖', 1, '', '', '', 0, 1, 4, '周日', '0000-00-00', '0000-00-00', '18:43:00', 'a:2:{i:0;s:2:\"10\";i:1;s:2:\"20\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '', '', -1, 0, 0, NULL),
(6, '超级射手班', 'legend', 6, 7, 'wayen_z', '特色训练课程', 0, '准行者训练营', 4, '1', 1, 0, '陈准', 3, 'a:2:{i:0;s:6:\"陈准\";i:1;s:9:\"刘伟霖\";}', 'a:1:{i:0;s:1:\"6\";}', 'wayen_z', 7, 5, 10, '周日', '0000-00-00', '0000-00-00', '09:50:00', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"5\";i:2;s:2:\"10\";}', 0, 0, 0, 4, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/09/59ca41677c295.jpg', '你想成为三井寿吗？', -1, 0, 1508387623, NULL),
(7, '超级防守班', 'legend', 6, 0, '', '特色训练课程', 27, '准行者训练营', 4, '120', 1, 0, '刘伟霖', 1, '', '', '', 0, 5, 10, '周日', '0000-00-00', '0000-00-00', '20:15:00', 'a:2:{i:0;s:1:\"5\";i:1;s:2:\"10\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/09/59ca458351901.JPG', '', -1, 0, 1508128806, NULL),
(8, '超级飞侠', 'legend', 6, 0, '', '基础篮球课程', 6, '准行者训练营', 4, '100', 1, 0, '刘伟霖', 1, '', '', '', 0, 5, 10, '周日', '0000-00-00', '0000-00-00', '23:55:00', 'a:2:{i:0;s:1:\"5\";i:1;s:2:\"10\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/09/59ca78f278870.JPG', '测试', -1, 0, 0, NULL),
(11, '猴塞雷课程', 'HoChen', 1, 0, '', '特色训练课程', 27, '齐天大热', 3, '100', 1, 0, '陈侯', 3, '', '', '', 0, 1, 2, '周日', '0000-00-00', '0000-00-00', '15:00:00', 'a:1:{i:0;s:1:\"1\";}', 0, 0, 0, 9, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/10/59d8686eb9fa4.jpg', '', 1, 1507354740, 1507354859, NULL),
(12, '校园兴趣班', 'HoChen', 1, 5, '123abc', '其他', 0, '齐天大热', 3, '1', 1, 0, '陈侯', 3, '', '', '', 0, 1, 20, '周日', '0000-00-00', '0000-00-00', '15:30:00', 'a:1:{i:0;s:2:\"10\";}', 0, 0, 0, 6, '广东省', '深圳市', '南山区', 9, '海滨实验小学篮球场', '学府路', '', '/uploads/images/court/2017/10/59dc9aaf4c67e.jpg', '', 1, 1507629294, 1508063350, NULL),
(33, '测试3', 'legend', 6, 5, '陈准', '校园兴趣班（4-18岁）', 0, '准行者训练营', 4, '20', 1, 0, '陈准', 5, 'a:1:{i:0;s:9:\"张伟荣\";}', 'a:1:{i:0;s:1:\"6\";}', '陈准', 5, 0, 0, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:2:{i:0;s:1:\"5\";i:1;s:2:\"10\";}', 0, 0, 0, 0, '北京市', '北京市', '东城区', 7, '阳光迷你场', '哪里', '', '/uploads/images/court/2017/10/59e596701c1f5.JPG', '测试2', -1, 1508218487, 1508218732, NULL),
(13, '大热常规班', 'Hot-basketball2', 2, 0, '', '综合篮球课程', 0, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 0, 20, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 0, 0, 4, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59e45b3b895e3.JPG', '', 1, 1507706211, 1508985890, NULL),
(14, '北头周日十点低年级班', 'Hot-basketball2', 2, 0, '', '基础篮球课程', 6, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 0, 20, '周日', '0000-00-00', '0000-00-00', '10:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59ddc7497d499.JPG', '', -1, 1507706700, 1508913472, 1508913472),
(30, '南头城小学', '钟声', 19, 0, '', '小学 - 基础班（7-9岁）', 0, '钟声训练营', 15, '100', 1, 0, '钟声', 7, '', '', '', 0, 0, 20, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 12, '南山天台兰球场', '北环大道', '', '/uploads/images/court/2017/10/59e835f79a8c6.jpeg', '', 1, 1508039002, 1508390396, NULL),
(15, '龙岗民警子女篮球训练课程', 'Hot-basketball2', 2, 0, '', '基础篮球课程', 0, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 0, 30, '周六', '0000-00-00', '0000-00-00', '16:30:00', 'a:1:{i:0;s:2:\"12\";}', 0, 1, 0, 0, '广东省', '深圳市', '龙岗区', 11, '龙岗公安分局训练场', '龙岗', '', '/uploads/images/court/2017/10/59dddbd68b41f.JPG', '', 1, 1507711963, 1507779593, NULL),
(16, '周日低年级基础班', 'Hot-basketball2', 2, 0, '', '基础篮球课程', 6, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 5, 15, '周日', '0000-00-00', '0000-00-00', '10:00:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/10/59dddf350ab88.JPG', '', -1, 1507712823, 1508913468, 1508913468),
(17, '北头周日初中班', 'Hot-basketball2', 2, 0, '', '综合篮球课程', 11, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 6, 20, '周日', '0000-00-00', '0000-00-00', '08:00:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59dddfdf6110c.JPG', '', -1, 1507712994, 1508913464, 1508913464),
(18, '周六北头六点半初中班', 'Hot-basketball2', 2, 0, '', '综合篮球课程', 0, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 6, 20, '周六', '0000-00-00', '0000-00-00', '18:30:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59dde04b9c8f0.JPG', '', -1, 1507713102, 1508913460, 1508913460),
(19, '周六北头前海代表队', 'Hot-basketball2', 2, 0, '', '综合篮球课程', 11, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 6, 20, '周六', '0000-00-00', '0000-00-00', '17:00:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59dde0a9c153c.JPG', '', -1, 1507713197, 1508913456, 1508913456),
(20, '周六北头小学班', 'Hot-basketball2', 2, 0, '', '基础篮球课程', 6, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 6, 20, '周六', '0000-00-00', '0000-00-00', '15:30:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59dde10dade98.JPG', '', -1, 1507713295, 1508913452, 1508913452),
(21, '周六幼儿班', 'Hot-basketball2', 2, 0, '', '幼儿篮球兴趣班', 1, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 4, 10, '周六', '0000-00-00', '0000-00-00', '10:30:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/10/59dde1622102b.JPG', '', -1, 1507713379, 1508913449, 1508913449),
(22, '初中班', 'Hot-basketball2', 2, 0, '', '综合篮球课程', 0, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 6, 20, '周六', '0000-00-00', '0000-00-00', '08:15:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59dde1bec9d8d.JPG', '', -1, 1507713472, 1508913444, 1508913444),
(23, '低年级班', 'Hot-basketball2', 2, 0, '', '综合篮球课程', 0, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 6, 20, '周六', '0000-00-00', '0000-00-00', '08:00:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59dde34b490d0.JPG', '', -1, 1507713871, 1508913440, 1508913440),
(24, '周五北头低年级课程', 'Hot-basketball2', 2, 0, '', '综合篮球课程', 11, '大热篮球俱乐部', 9, '100', 1, 0, '冼玉华', 4, '', '', '', 0, 6, 20, '周五', '0000-00-00', '0000-00-00', '19:00:00', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"15\";i:2;s:2:\"30\";}', 0, 1, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59dde3ff8d650.JPG', '', -1, 1507714050, 1508913435, 1508913435),
(29, '石厦学校兰球队', '钟声', 19, 0, '', '高年组球队（9-12岁）', 0, '钟声训练营', 15, '100', 1, 0, '钟声', 7, '', '', '', 0, 0, 15, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 0, 0, 4, '广东省', '深圳市', '福田区', 13, '福田体育公园兰球场', '福田体育公园', '', '/uploads/images/court/2017/10/59e83616221da.jpeg', '', 1, 1508038824, 1508390426, NULL),
(25, '荣光篮球强化', 'wayen_z', 7, 7, '张伟荣', '强化篮球课程', 16, '荣光训练营', 5, '1', 1, 0, '张伟荣', 6, 'a:1:{i:0;s:9:\"张伟荣\";}', 'a:1:{i:0;s:1:\"6\";}', '张伟荣', 7, 1, 2, '周日', '0000-00-00', '0000-00-00', '14:30:00', 'a:1:{i:0;s:1:\"1\";}', 0, 0, 0, 5, '广东省', '深圳市', '福田区', 10, '荣光训练场', '福田车公庙', '', '/uploads/images/court/2017/10/59e09752d9e93.jpg', '荣光新课程', 1, 1507891038, 1508749091, NULL),
(26, '最后测一下', 'legend', 6, 6, '陈准', '特色训练课程', 27, '准行者训练营', 4, '200', 1, 0, '陈准', 5, 'a:1:{i:0;s:9:\"张伟荣\";}', 'a:1:{i:0;s:1:\"6\";}', '陈准', 6, 0, 0, '周六', '0000-00-00', '0000-00-00', '00:48:00', 'a:2:{i:0;s:2:\"10\";i:1;s:2:\"20\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59e0ef7a09555.JPG', '保证ok', -1, 1507913608, 1507913608, NULL),
(27, '特长班', 'legend', 6, 6, '陈准', '特色训练课程', 27, '准行者训练营', 4, '150', 1, 0, '陈准', 5, 'a:1:{i:0;s:9:\"张伟荣\";}', 'a:1:{i:0;s:1:\"6\";}', '陈准', 6, 1, 5, '周五', '0000-00-00', '0000-00-00', '18:55:00', 'a:1:{i:0;s:2:\"10\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/10/59e0f1fe18789.JPG', '曹操', -1, 1507914246, 1508306778, NULL),
(28, '最后试试', 'legend', 6, 0, '', '其他', 33, '准行者训练营', 4, '23', 1, 0, '陈准', 6, '', '', '', 0, 2, 5, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"10\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/10/59e175c6c9674.JPG', '哈哈', -1, 1507947981, 1507947981, NULL),
(31, '前海小学', '钟声', 19, 0, '', '小学 - 综合班（7-9岁）', 0, '钟声训练营', 15, '100', 1, 0, '钟声', 7, '', '', '', 0, 0, 20, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 1, 0, 13, '广东省', '深圳市', '南山区', 14, '前海小学', '前海小学', '', '/uploads/images/court/2017/10/59e835c9bb350.jpeg', '', 1, 1508039125, 1508390350, NULL),
(32, '松坪小学', '钟声', 19, 0, '', '高年组球队（9-12岁）', 0, '钟声训练营', 15, '100', 1, 0, '钟声', 7, '', '', '', 0, 0, 20, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 1, 0, 3, '广东省', '深圳市', '南山区', 15, '松坪小学', '松坪小学', '', '/uploads/images/court/2017/10/59e8359fdc6c4.jpeg', '', 1, 1508039305, 1508390308, NULL),
(34, '测试课程', 'legend', 6, 0, '', '校园兴趣班（4-18岁）', 0, '准行者训练营', 4, '120', 1, 0, '陈准', 5, 'a:1:{i:0;s:9:\"张伟荣\";}', 'a:1:{i:0;s:1:\"6\";}', '', 0, 1, 5, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:2:{i:0;s:1:\"5\";i:1;s:2:\"10\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 1, '大热前海训练中心', '', '', '/uploads/images/court/2017/10/59e6e5af461cc.JPG', '虫草', -1, 1508304309, 1508476714, NULL),
(35, '测试班', 'legend', 6, 0, '', '校园兴趣班（4-18岁）', 0, '准行者训练营', 4, '120', 1, 0, '陈准', 5, 'a:1:{i:0;s:9:\"刘伟霖\";}', 'a:1:{i:0;s:1:\"1\";}', '', 0, 1, 5, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"10\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 3, '前海北头运动场', '', '', '/uploads/images/court/2017/10/59e6e8d41bbea.JPG', '', -1, 1508305135, 1508475198, NULL),
(36, '北大附小一年级', '钟声', 19, 0, '', '小学 - 基础班（7-9岁）', 0, '钟声训练营', 15, '100', 1, 0, '钟声', 7, '', '', '', 0, 15, 20, '周五', '0000-00-00', '0000-00-00', '14:30:00', 'a:1:{i:0;s:2:\"15\";}', 0, 0, 0, 9, '广东省', '深圳市', '南山区', 17, '星海名城小区兰球场', '星海名城一期', '', '/uploads/images/court/2017/10/59e8355f38596.jpeg', '系统给students+1  时间 2017年10月27日10:46:17', 1, 1508306502, 1508390243, NULL),
(37, '平台示例请勿购买', 'legend', 6, 0, '', '企业（事业单位）', 38, '准行者训练营', 4, '1', 1, 0, '陈准', 5, '', '', '', 0, 1, 5, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:2:{i:0;s:1:\"1\";i:1;s:2:\"10\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 7, '阳光迷你场', '哪里', '', '/uploads/images/court/2017/10/59ec269448392.JPG', '平台测试课程请勿购买', 1, 1508648619, 1508648628, NULL),
(38, 'AKcross课程', 'Hot-basketball2', 2, 0, '', '小学 - 综合班（10-12岁）', 13, 'AKcross训练营', 13, '100', 1, 0, '安凯翔', 9, '', '', '', 0, 0, 20, '可选', '0000-00-00', '0000-00-00', '00:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 0, 0, 1, '广东省', '深圳市', '南山区', 16, '丽山文体中心篮球场', '丽水路110', '', '/uploads/images/court/2017/10/59eeeab96b2fa.JPG', '', 1, 1508829889, 1508830033, NULL),
(39, '南外文华快艇队', '18566201712', 18, 0, '', '高年组球队（9-12岁）', 24, 'AKcross训练营', 13, '88', 1, 0, '安凯翔', 9, 'a:1:{i:0;s:9:\"冼玉华\";}', 'a:1:{i:0;s:1:\"4\";}', '', 0, 6, 15, '周三', '0000-00-00', '0000-00-00', '17:00:00', 'a:1:{i:0;s:2:\"15\";}', 0, 0, 0, 0, '广东省', '深圳市', '南山区', 19, '南外文华球场', ' 0', '', '/uploads/images/court/2017/10/59eeeabf5b7a2.jpg', '', -1, 1508829889, 1508829889, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `log_admindo`
--

CREATE TABLE `log_admindo` (
  `id` int(10) UNSIGNED NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `username` varchar(100) DEFAULT NULL COMMENT '管理员名字',
  `doing` varchar(255) DEFAULT NULL COMMENT '操作事件',
  `url` varchar(100) DEFAULT NULL COMMENT '操作页面',
  `ip` varchar(50) NOT NULL COMMENT 'ip',
  `created_at` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(40, 1, 'admin', '审核教练id: 1审核操作:审核已通过成功', '/admin/coach/audit', '58.60.127.150', 1507184567),
(41, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.40.78', 1507628222),
(42, 1, 'admin', '审核训练营id: 9审核操作:审核已通过成功', '/admin/camp/audit', '116.25.40.78', 1507628247),
(43, 1, 'admin', '审核训练营id: 6审核操作:审核已通过成功', '/admin/camp/audit', '116.25.40.78', 1507628316),
(44, 1, 'admin', '审核训练营id: 11审核操作:审核已通过成功', '/admin/camp/audit', '116.25.40.78', 1507628322),
(45, 0, '', '控制台 登录 失败', '/admin/login/index', '116.25.40.78', 1507628461),
(46, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.40.78', 1507628474),
(47, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.43.204', 1507718115),
(48, 1, 'admin', '审核场地id: 8 审核操作:场地资源被选为平台公开场地成功', '/admin/court/audit', '116.25.43.204', 1507718136),
(49, 1, 'admin', '审核场地id: 5 审核操作:场地资源被选为平台公开场地成功', '/admin/court/audit', '116.25.43.204', 1507718142),
(50, 1, 'admin', '审核教练id: 6审核操作:审核已通过成功', '/admin/coach/audit', '116.25.43.204', 1507718181),
(51, 1, 'admin', '审核教练id: 4审核操作:审核已通过成功', '/admin/coach/audit', '116.25.43.204', 1507718189),
(52, 1, 'admin', '审核教练id: 5审核操作:审核已通过成功', '/admin/coach/audit', '116.25.43.204', 1507718198),
(53, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.42.21', 1507966630),
(54, 1, 'admin', '审核教练id: 10审核操作:审核已通过成功', '/admin/coach/audit', '116.25.42.21', 1507966718),
(55, 1, 'admin', '审核教练id: 9审核操作:审核已通过成功', '/admin/coach/audit', '116.25.42.21', 1507966837),
(56, 1, 'admin', '审核教练id: 7审核操作:审核已通过成功', '/admin/coach/audit', '116.25.42.21', 1507966890),
(57, 1, 'admin', '审核训练营id: 13审核操作:审核已通过成功', '/admin/camp/audit', '116.25.42.21', 1507966904),
(58, 1, 'admin', '审核训练营id: 14审核操作:审核已通过成功', '/admin/camp/audit', '116.25.42.21', 1507966910),
(59, 1, 'admin', '审核教练id: 11审核操作:审核已通过成功', '/admin/coach/audit', '116.25.42.21', 1507971968),
(60, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.40.46', 1508321638),
(61, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.41.221', 1508815897),
(62, 1, 'admin', '审核教练id: 12审核操作:审核已通过成功', '/admin/coach/audit', '116.25.41.221', 1508831036),
(63, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.41.221', 1508898565),
(64, 1, 'admin', '修改平台信息 成功', '/admin/system/editinfo', '116.25.41.221', 1508898729),
(65, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.40.33', 1508912390),
(66, 1, 'admin', '修改平台信息 失败', '/admin/system/editinfo', '116.25.40.33', 1508912454),
(67, 1, 'admin', '控制台 登录 成功', '/admin/login/index', '116.25.40.33', 1509076413);

-- --------------------------------------------------------

--
-- 表的结构 `log_camp_member`
--

CREATE TABLE `log_camp_member` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_grade_member`
--

CREATE TABLE `log_grade_member` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_income`
--

CREATE TABLE `log_income` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_pay`
--

CREATE TABLE `log_pay` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_rebate`
--

CREATE TABLE `log_rebate` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_salary_in`
--

CREATE TABLE `log_salary_in` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_salary_out`
--

CREATE TABLE `log_salary_out` (
  `id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `data` int(10) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `log_sendtemplatemsg`
--

CREATE TABLE `log_sendtemplatemsg` (
  `id` int(11) NOT NULL,
  `wxopenid` varchar(100) NOT NULL COMMENT '接收的openid',
  `member_id` int(11) NOT NULL COMMENT '接收的memberid',
  `url` varchar(255) DEFAULT NULL COMMENT '消息的url地址',
  `content` text COMMENT '消息的内容 seriliaze',
  `status` tinyint(4) DEFAULT '0' COMMENT '发送成功状态:1成功|0失败',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='发送模板消息log';

--
-- 转存表中的数据 `log_sendtemplatemsg`
--

INSERT INTO `log_sendtemplatemsg` (`id`, `wxopenid`, `member_id`, `url`, `content`, `status`, `create_time`, `update_time`) VALUES
(1, 'o83291Ic0nyfFcuRrhsu2s4sBYxQ', 10, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/12/openid/o83291Ic0nyfFcuRrhsu2s4sBYxQ', 'a:4:{s:6:\"touser\";s:28:\"o83291Ic0nyfFcuRrhsu2s4sBYxQ\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:99:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/12/openid/o83291Ic0nyfFcuRrhsu2s4sBYxQ\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的训练营注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月04日 18时35分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:36:\"点击进入训练营进行操作吧\";}}}', 0, 1507113353, NULL),
(2, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月05日 14时15分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 0, 1507184126, NULL),
(3, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月05日 14时18分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507184296, NULL),
(4, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/coach/updatecoach/openid/o83291Nf-U88M3FV7KRiu_0czrSg', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:91:\"https://m.hot-basketball.com/frontend/coach/updatecoach/openid/o83291Nf-U88M3FV7KRiu_0czrSg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核未通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核未通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月05日 14时22分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:30:\"点击进入修改完善资料\";}}}', 1, 1507184521, NULL),
(5, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291Nf-U88M3FV7KRiu_0czrSg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月05日 14时22分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507184567, NULL),
(6, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9/openid/o83291FaVoul_quMxTYAOHt-NmHg', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:98:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9/openid/o83291FaVoul_quMxTYAOHt-NmHg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的训练营注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月10日 17时37分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:36:\"点击进入训练营进行操作吧\";}}}', 1, 1507628247, NULL),
(7, 'o83291I75hoZy8HuDN6nfM6c7qZM', 9, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/6/openid/o83291I75hoZy8HuDN6nfM6c7qZM', 'a:4:{s:6:\"touser\";s:28:\"o83291I75hoZy8HuDN6nfM6c7qZM\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:98:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/6/openid/o83291I75hoZy8HuDN6nfM6c7qZM\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的训练营注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月10日 17时38分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:36:\"点击进入训练营进行操作吧\";}}}', 1, 1507628316, NULL),
(8, 'o83291HVzrqZlYFdSeK1OBx6sX_E', 5, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/11/openid/o83291HVzrqZlYFdSeK1OBx6sX_E', 'a:4:{s:6:\"touser\";s:28:\"o83291HVzrqZlYFdSeK1OBx6sX_E\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:99:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/11/openid/o83291HVzrqZlYFdSeK1OBx6sX_E\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的训练营注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月10日 17时38分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:36:\"点击进入训练营进行操作吧\";}}}', 1, 1507628322, NULL),
(9, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/index/index', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"anBmKL68Y99ZhX3SVNyyX6hrtzhlDW3RrB-vB6_GmqM\";s:3:\"url\";s:49:\"https://m.hot-basketball.com/frontend/index/index\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:65:\"您好, 您所在的准行者训练营的教练身份被移除了\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"weilin666\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:33:\"训练营营主或管理员移除\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:28:\"2017年10月11日 15时17分\";}}}', 1, 1507706271, NULL),
(10, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/index/index', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"anBmKL68Y99ZhX3SVNyyX6hrtzhlDW3RrB-vB6_GmqM\";s:3:\"url\";s:49:\"https://m.hot-basketball.com/frontend/index/index\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:65:\"您好, 您所在的准行者训练营的教练身份被移除了\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"weilin666\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:33:\"训练营营主或管理员移除\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:28:\"2017年10月11日 16时17分\";}}}', 1, 1507709856, NULL),
(11, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, 'https://m.hot-basketball.com/frontend/camp/courtlistofcamp/camp_id/5', 'a:4:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/camp/courtlistofcamp/camp_id/5\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:70:\"您好,您所发布的荣光场场地资源被选为平台公开场地\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:39:\"场地资源被选为平台公开场地\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月11日 18时35分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:24:\"点击进入查看详情\";}}}', 1, 1507718136, NULL),
(12, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, 'https://m.hot-basketball.com/frontend/camp/courtlistofcamp/camp_id/4', 'a:4:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/camp/courtlistofcamp/camp_id/4\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:88:\"您好,您所发布的阳光文体中心迷你场场地资源被选为平台公开场地\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:39:\"场地资源被选为平台公开场地\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月11日 18时35分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:24:\"点击进入查看详情\";}}}', 1, 1507718142, NULL),
(13, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291GqxP1FCqmfVncltkGVWPaY', 'a:4:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291GqxP1FCqmfVncltkGVWPaY\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月11日 18时36分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507718181, NULL),
(14, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291FaVoul_quMxTYAOHt-NmHg', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291FaVoul_quMxTYAOHt-NmHg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月11日 18时36分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507718189, NULL),
(15, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 'a:4:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291E-y8PFoWJ4k0IRFArpN0p8\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月11日 18时36分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507718198, NULL),
(16, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/5/status/0', 'a:4:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:77:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/5/status/0\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:21:\"加入训练营申请\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"weilin666\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-13 18:29:34\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1507890574, NULL),
(17, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, '/frontend/camp/coachlistofcamp/camp_id/5/status/0/openid/o83291GqxP1FCqmfVncltkGVWPaY', 'a:4:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:85:\"/frontend/camp/coachlistofcamp/camp_id/5/status/0/openid/o83291GqxP1FCqmfVncltkGVWPaY\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:21:\"加入训练营申请\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"weilin666\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-13 18:29:34\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1507948855, NULL),
(18, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/5/status/0/openid/o83291GqxP1FCqmfVncltkGVWPaY', 'a:4:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/5/status/0/openid/o83291GqxP1FCqmfVncltkGVWPaY\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:21:\"加入训练营申请\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"weilin666\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-13 18:29:34\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1507948896, NULL),
(19, 'o83291PTfjOJ13exCnFAYGOiYPqU', 17, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291PTfjOJ13exCnFAYGOiYPqU', 'a:4:{s:6:\"touser\";s:28:\"o83291PTfjOJ13exCnFAYGOiYPqU\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291PTfjOJ13exCnFAYGOiYPqU\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月14日 15时38分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507966718, NULL),
(20, 'o83291A1ANguB2ziQFNuNZfVNqpY', 18, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291A1ANguB2ziQFNuNZfVNqpY', 'a:4:{s:6:\"touser\";s:28:\"o83291A1ANguB2ziQFNuNZfVNqpY\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291A1ANguB2ziQFNuNZfVNqpY\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月14日 15时40分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507966837, NULL),
(21, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291FErHA03raoSlWaWQTtl1Jo', 'a:4:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291FErHA03raoSlWaWQTtl1Jo\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月14日 15时41分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507966890, NULL),
(22, 'o83291A1ANguB2ziQFNuNZfVNqpY', 18, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/13/openid/o83291A1ANguB2ziQFNuNZfVNqpY', 'a:4:{s:6:\"touser\";s:28:\"o83291A1ANguB2ziQFNuNZfVNqpY\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:99:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/13/openid/o83291A1ANguB2ziQFNuNZfVNqpY\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的训练营注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月14日 15时41分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:36:\"点击进入训练营进行操作吧\";}}}', 1, 1507966904, NULL),
(23, 'o83291PTfjOJ13exCnFAYGOiYPqU', 17, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/14/openid/o83291PTfjOJ13exCnFAYGOiYPqU', 'a:4:{s:6:\"touser\";s:28:\"o83291PTfjOJ13exCnFAYGOiYPqU\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:99:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/14/openid/o83291PTfjOJ13exCnFAYGOiYPqU\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的训练营注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月14日 15时41分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:36:\"点击进入训练营进行操作吧\";}}}', 1, 1507966910, NULL),
(24, 'o83291CbcwZsw60mUhBqCGfpFDbM', 24, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291CbcwZsw60mUhBqCGfpFDbM', 'a:4:{s:6:\"touser\";s:28:\"o83291CbcwZsw60mUhBqCGfpFDbM\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291CbcwZsw60mUhBqCGfpFDbM\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月14日 17时06分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1507971968, NULL),
(25, 'o83291IEM6JPXsCe5bIT_XRt2oes', 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/3/status/0/openid/o83291IEM6JPXsCe5bIT_XRt2oes', 'a:4:{s:6:\"touser\";s:28:\"o83291IEM6JPXsCe5bIT_XRt2oes\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/3/status/0/openid/o83291IEM6JPXsCe5bIT_XRt2oes\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:21:\"加入训练营申请\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"Hot777\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-14 17:16:16\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1507972577, NULL),
(26, 'o83291I0HI28QoLyldPwvPnPExQQ', 11, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/16/status/0/openid/o83291I0HI28QoLyldPwvPnPExQQ', 'a:4:{s:6:\"touser\";s:28:\"o83291I0HI28QoLyldPwvPnPExQQ\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:114:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/16/status/0/openid/o83291I0HI28QoLyldPwvPnPExQQ\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:21:\"加入训练营申请\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"HoChen\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-15 12:15:16\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508040916, NULL),
(27, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:21:\"加入训练营申请\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"legend\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-15 16:10:43\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508055043, NULL),
(37, 'o83291HVzrqZlYFdSeK1OBx6sX_E', 5, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291HVzrqZlYFdSeK1OBx6sX_E\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/38\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"刘嘉\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710191508357622\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"0元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"刘嘉预约体验校园兴趣班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508396926, 1508396926),
(38, 'o83291IEM6JPXsCe5bIT_XRt2oes', 1, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291IEM6JPXsCe5bIT_XRt2oes\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/38\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:27:\"体验课预约申请成功\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"刘嘉\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710191508357622\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"0元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"刘嘉预约体验校园兴趣班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508396926, 1508396926),
(39, 'o83291CzkRqonKdTVSJLGhYoU98Q', 8, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/4/status/0/openid/o83291CzkRqonKdTVSJLGhYoU98Q', 'a:4:{s:6:\"touser\";s:28:\"o83291CzkRqonKdTVSJLGhYoU98Q\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/4/status/0/openid/o83291CzkRqonKdTVSJLGhYoU98Q\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:21:\"加入训练营申请\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"weilin666\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-19 15:46:33\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508399193, NULL),
(40, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/4/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 'a:4:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/4/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:21:\"加入训练营申请\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"weilin666\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-19 15:46:33\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508399193, NULL),
(41, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/4', 'a:4:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/4\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:27:\"加入训练营申请结果\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-19 15:47:36\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508399257, NULL),
(42, 'o83291PIWaWsfNat_XkflwCO5sX0', 3, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 'a:4:{s:6:\"touser\";s:28:\"o83291PIWaWsfNat_XkflwCO5sX0\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:74:\"您好，您申请加入大热篮球俱乐部 成为 管理员审核通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-20 11:10:17\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508469023, NULL),
(43, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/15/status/0/openid/o83291FErHA03raoSlWaWQTtl1Jo', 'a:4:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:114:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/15/status/0/openid/o83291FErHA03raoSlWaWQTtl1Jo\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:84:\"会员 Hot-basketball2申请加入钟声训练营 成为 管理员，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"Hot-basketball2\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-20 11:11:14\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508469074, NULL),
(44, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/15', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:63:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/15\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:68:\"您好，您申请加入钟声训练营 成为 管理员审核通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-20 12:30:26\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508473826, NULL),
(45, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/39\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈小准\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710201650501601\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:5:\"10元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:30:\"陈小准购买校园兴趣班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508489474, 1508489474),
(46, 'o83291IEM6JPXsCe5bIT_XRt2oes', 1, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291IEM6JPXsCe5bIT_XRt2oes\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/39\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈小准\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710201650501601\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:5:\"10元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:30:\"陈小准购买校园兴趣班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508489474, 1508489474),
(47, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/40\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈小准\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710201655144883\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:5:\"10元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:30:\"陈小准购买校园兴趣班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 0, 1508489736, 1508489736),
(48, 'o83291IEM6JPXsCe5bIT_XRt2oes', 1, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291IEM6JPXsCe5bIT_XRt2oes\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/40\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈小准\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710201655144883\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:5:\"10元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:30:\"陈小准购买校园兴趣班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508489736, 1508489736),
(49, 'o83291M6xwf4rjV8gYdIrlT_qHhQ', 43, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291M6xwf4rjV8gYdIrlT_qHhQ\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/41\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈润宏\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710211057457832\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"陈润宏购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508554704, 1508554704),
(50, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/41\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈润宏\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710211057457832\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"陈润宏购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508554705, 1508554705),
(51, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/41\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈润宏\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710211057457832\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"陈润宏购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508554705, 1508554705),
(52, 'o83291HallUspE1Y0-nGCP6aGI90', 42, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291HallUspE1Y0-nGCP6aGI90\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/42\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"李润弘\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710211059171400\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"李润弘购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508554790, 1508554790),
(53, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/42\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"李润弘\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710211059171400\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"李润弘购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508554790, 1508554790),
(54, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/42\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"李润弘\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710211059171400\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"李润弘购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508554790, 1508554790),
(55, 'o83291DEQMrOGBcwXrbPisKaET1w', 26, 'https://m.hot-basketball.com/frontend/schedule/scheduleinfo/schedule_id/26/camp_id/5/openid/o83291DEQMrOGBcwXrbPisKaET1w', 'a:4:{s:6:\"touser\";s:28:\"o83291DEQMrOGBcwXrbPisKaET1w\";s:11:\"template_id\";s:43:\"_ld4qtOLJA1vl-oh0FxCliMK1tbGD0nOTq7Z4OmeFCE\";s:3:\"url\";s:120:\"https://m.hot-basketball.com/frontend/schedule/scheduleinfo/schedule_id/26/camp_id/5/openid/o83291DEQMrOGBcwXrbPisKaET1w\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:87:\"您参加的荣光训练营-荣光篮球强化-荣光体验班班级 发布最新课时\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:27:\"荣光体验班最新课时\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-21 16:19\";}s:6:\"remark\";a:1:{s:5:\"value\";s:42:\"点击进入查看详细，并进行评价\";}}}', 1, 1508577717, NULL),
(56, 'o83291Ic0nyfFcuRrhsu2s4sBYxQ', 10, 'https://m.hot-basketball.com/frontend/schedule/scheduleinfo/schedule_id/26/camp_id/5/openid/o83291Ic0nyfFcuRrhsu2s4sBYxQ', 'a:4:{s:6:\"touser\";s:28:\"o83291Ic0nyfFcuRrhsu2s4sBYxQ\";s:11:\"template_id\";s:43:\"_ld4qtOLJA1vl-oh0FxCliMK1tbGD0nOTq7Z4OmeFCE\";s:3:\"url\";s:120:\"https://m.hot-basketball.com/frontend/schedule/scheduleinfo/schedule_id/26/camp_id/5/openid/o83291Ic0nyfFcuRrhsu2s4sBYxQ\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:87:\"您参加的荣光训练营-荣光篮球强化-荣光体验班班级 发布最新课时\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:27:\"荣光体验班最新课时\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-21 16:19\";}s:6:\"remark\";a:1:{s:5:\"value\";s:42:\"点击进入查看详细，并进行评价\";}}}', 1, 1508579132, NULL),
(57, 'o83291DFDpzuxxmAsQtnfZICTBsw', 48, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291DFDpzuxxmAsQtnfZICTBsw\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/43\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"郑肖杰\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221039031877\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"郑肖杰购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508639992, 1508639992),
(58, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/43\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"郑肖杰\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221039031877\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"郑肖杰购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508639992, 1508639992),
(59, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/43\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"郑肖杰\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221039031877\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"郑肖杰购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508639992, 1508639992),
(60, 'o83291KSimBWL49RP8HvnUEu6tqE', 49, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291KSimBWL49RP8HvnUEu6tqE\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/44\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"黄浩\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221540485210\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"黄浩购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508658060, 1508658060),
(61, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/44\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"黄浩\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221540485210\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"黄浩购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508658060, 1508658060),
(62, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/44\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"黄浩\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221540485210\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"黄浩购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508658061, 1508658061),
(63, 'o83291A33b20_vCpOuuks0zf1BKI', 52, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291A33b20_vCpOuuks0zf1BKI\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/45\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"吴师隽\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221644099327\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"吴师隽购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508661866, 1508661866),
(64, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/45\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"吴师隽\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221644099327\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"吴师隽购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508661867, 1508661867),
(65, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/45\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"吴师隽\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710221644099327\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"吴师隽购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508661867, 1508661867),
(66, 'o83291IecDIpcwfwvTI4VjdDVnLg', 55, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291IecDIpcwfwvTI4VjdDVnLg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/46\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"唐轩衡\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710222048182609\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"唐轩衡购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508676523, 1508676523),
(67, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/46\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"唐轩衡\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710222048182609\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"唐轩衡购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508676523, 1508676523),
(68, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/46\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"唐轩衡\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710222048182609\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"唐轩衡购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508676524, 1508676524),
(69, 'o83291IKJJk_0rmmzyE61dhptuN0', 56, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291IKJJk_0rmmzyE61dhptuN0\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/47\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"郑皓畅\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710230947598204\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"郑皓畅购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508723298, 1508723298),
(70, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/47\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"郑皓畅\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710230947598204\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"郑皓畅购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508723298, 1508723298),
(71, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/47\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"郑皓畅\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710230947598204\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"郑皓畅购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508723298, 1508723298),
(72, 'o83291Jlbvm7DwWPGS5MufN3NC8o', 59, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291Jlbvm7DwWPGS5MufN3NC8o\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/48\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈高翔\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710230947417559\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"陈高翔购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508723329, 1508723329),
(73, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/48\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈高翔\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710230947417559\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"陈高翔购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508723330, 1508723330),
(74, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/48\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈高翔\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710230947417559\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"陈高翔购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508723330, 1508723330),
(75, 'o83291NqF3-x4zg2KoZEs508UD3A', 51, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291NqF3-x4zg2KoZEs508UD3A\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/49\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"战奕名\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231009249234\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"战奕名购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508724643, 1508724643),
(76, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/49\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"战奕名\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231009249234\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"战奕名购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508724643, 1508724643),
(77, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/49\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"战奕名\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231009249234\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"战奕名购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508724644, 1508724644),
(78, 'o83291OtlzRp8MCFMagBBMOlAGDI', 46, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291OtlzRp8MCFMagBBMOlAGDI\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/50\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"李语辰\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231029072550\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"李语辰购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508725787, 1508725787),
(79, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/50\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"李语辰\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231029072550\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"李语辰购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508725788, 1508725788),
(80, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/50\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"李语辰\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231029072550\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"李语辰购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508725788, 1508725788),
(81, 'o83291GqvM0TIqzyNcBM4Xu1dCD4', 50, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291GqvM0TIqzyNcBM4Xu1dCD4\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/51\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"张毓楠\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231034138371\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"张毓楠购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508726077, 1508726077),
(82, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/51\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"张毓楠\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231034138371\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"张毓楠购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508726077, 1508726077),
(83, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/51\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"张毓楠\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231034138371\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"张毓楠购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508726077, 1508726077);
INSERT INTO `log_sendtemplatemsg` (`id`, `wxopenid`, `member_id`, `url`, `content`, `status`, `create_time`, `update_time`) VALUES
(84, 'o83291Nv-kf4Mm-3fcGXFrftR2BM', 60, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291Nv-kf4Mm-3fcGXFrftR2BM\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/52\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"王钰龙\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231034543967\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"王钰龙购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508726144, 1508726144),
(85, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/52\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"王钰龙\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231034543967\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"王钰龙购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508726145, 1508726145),
(86, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/52\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"王钰龙\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231034543967\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"王钰龙购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508726145, 1508726145),
(87, 'o83291ABmknfWiRut_zD2p6P7664', 62, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291ABmknfWiRut_zD2p6P7664\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/53\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"刘宇恒\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231128422121\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"刘宇恒购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508729343, 1508729343),
(88, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/53\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"刘宇恒\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231128422121\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"刘宇恒购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508729343, 1508729343),
(89, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/53\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"刘宇恒\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231128422121\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"刘宇恒购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508729344, 1508729344),
(90, 'o83291FMYyZlagb8A74nkYfdWnE4', 63, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FMYyZlagb8A74nkYfdWnE4\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/54\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"黄子诺\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231147005486\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"黄子诺购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508730455, 1508730455),
(91, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/54\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"黄子诺\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231147005486\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"黄子诺购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508730455, 1508730455),
(92, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/54\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"黄子诺\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231147005486\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"黄子诺购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508730455, 1508730455),
(93, 'o83291IobV5CnYduYqHQP3OeFCVM', 66, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291IobV5CnYduYqHQP3OeFCVM\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/55\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"梁峻玮\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231219544391\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"梁峻玮购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508732407, 1508732407),
(94, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/55\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"梁峻玮\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231219544391\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"梁峻玮购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508732408, 1508732408),
(95, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/55\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"梁峻玮\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231219544391\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"梁峻玮购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508732408, 1508732408),
(96, 'o83291M9vdRoN4N4CRULeSB1CasI', 67, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291M9vdRoN4N4CRULeSB1CasI\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/56\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"刘一凡\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231305331610\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"刘一凡购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508735155, 1508735155),
(97, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/56\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"刘一凡\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231305331610\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"刘一凡购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508735155, 1508735155),
(98, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/56\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"刘一凡\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231305331610\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"刘一凡购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508735155, 1508735155),
(99, 'o83291DhgEQp_py8JNcUAcRVwdfI', 61, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291DhgEQp_py8JNcUAcRVwdfI\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/57\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"万宇宸\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:18:\"120171023134850181\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"万宇宸购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508737748, 1508737748),
(100, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/57\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"万宇宸\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:18:\"120171023134850181\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"万宇宸购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508737749, 1508737749),
(101, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/57\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"万宇宸\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:18:\"120171023134850181\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"万宇宸购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508737749, 1508737749),
(102, 'o83291CoSbokWDoHUwFSfsQmOdnE', 73, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291CoSbokWDoHUwFSfsQmOdnE\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/58\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"邱仁鹏\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710232142144641\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"邱仁鹏购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508766197, 1508766197),
(103, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/58\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"邱仁鹏\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710232142144641\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"邱仁鹏购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508766197, 1508766197),
(104, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/58\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"邱仁鹏\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710232142144641\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"邱仁鹏购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508766198, 1508766198),
(105, 'o83291N2g6PxiplYQU6SxB8dWp7A', 74, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291N2g6PxiplYQU6SxB8dWp7A\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/59\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"林需睦\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710232145334074\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"林需睦购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 0, 1508766363, 1508766363),
(106, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/59\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"林需睦\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710232145334074\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"林需睦购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508766363, 1508766363),
(107, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/59\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"林需睦\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710232145334074\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"林需睦购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508766363, 1508766363),
(108, 'o83291FwBuKh8hcIAyNNc5WQ3-nc', 58, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FwBuKh8hcIAyNNc5WQ3-nc\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/60\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"饶滨\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:18:\"120171023230255696\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:24:\"饶滨购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508770994, 1508770994),
(109, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/60\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"饶滨\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:18:\"120171023230255696\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:24:\"饶滨购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508770994, 1508770994),
(110, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/60\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"饶滨\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:18:\"120171023230255696\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:24:\"饶滨购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508770994, 1508770994),
(111, 'o83291A1ANguB2ziQFNuNZfVNqpY', 18, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/13/status/0/openid/o83291A1ANguB2ziQFNuNZfVNqpY', 'a:4:{s:6:\"touser\";s:28:\"o83291A1ANguB2ziQFNuNZfVNqpY\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:114:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/13/status/0/openid/o83291A1ANguB2ziQFNuNZfVNqpY\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:85:\"会员 Hot-basketball2申请加入AKcross训练营 成为 管理员，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"Hot-basketball2\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-24 15:21:15\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508829676, NULL),
(112, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/13', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:63:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/13\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:69:\"您好，您申请加入AKcross训练营 成为 管理员审核通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-24 15:22:06\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508829727, NULL),
(113, 'o83291O77zbRozhXag-N4H-3gYNs', 78, 'https://m.hot-basketball.com/frontend/index/index/openid/o83291O77zbRozhXag-N4H-3gYNs', 'a:4:{s:6:\"touser\";s:28:\"o83291O77zbRozhXag-N4H-3gYNs\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:85:\"https://m.hot-basketball.com/frontend/index/index/openid/o83291O77zbRozhXag-N4H-3gYNs\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:59:\"您好,您所提交的教练员注册申请 审核已通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"审核已通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:28:\"2017年10月24日 15时43分\";}s:6:\"remark\";a:1:{s:5:\"value\";s:33:\"点击进入平台进行操作吧\";}}}', 1, 1508831036, NULL),
(114, 'o83291MpnhMJjG5RQKYNPmAN_COw', 79, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291MpnhMJjG5RQKYNPmAN_COw\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/61\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"游逸朗\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710241550126737\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:28:\"游逸朗购买AKcross课程\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 0, 1508831426, 1508831426),
(115, 'o83291A1ANguB2ziQFNuNZfVNqpY', 18, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291A1ANguB2ziQFNuNZfVNqpY\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/61\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"游逸朗\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710241550126737\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:28:\"游逸朗购买AKcross课程\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508831426, 1508831426),
(116, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/61\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"游逸朗\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710241550126737\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:28:\"游逸朗购买AKcross课程\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508831427, 1508831427),
(117, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 'a:4:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:84:\"会员 张雅璐申请加入大热篮球俱乐部 成为 管理员，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"张雅璐\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-24 15:57:13\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508831833, NULL),
(118, 'o83291PIWaWsfNat_XkflwCO5sX0', 3, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0', 'a:4:{s:6:\"touser\";s:28:\"o83291PIWaWsfNat_XkflwCO5sX0\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:84:\"会员 张雅璐申请加入大热篮球俱乐部 成为 管理员，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"张雅璐\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-24 15:57:13\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508831834, NULL),
(119, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:84:\"会员 张雅璐申请加入大热篮球俱乐部 成为 管理员，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"张雅璐\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-24 15:57:13\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508831834, NULL),
(120, 'o83291O77zbRozhXag-N4H-3gYNs', 78, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 'a:4:{s:6:\"touser\";s:28:\"o83291O77zbRozhXag-N4H-3gYNs\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:74:\"您好，您申请加入大热篮球俱乐部 成为 管理员审核通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-24 15:57:30\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508831851, NULL),
(121, 'o83291IEM6JPXsCe5bIT_XRt2oes', 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/2/status/0/openid/o83291IEM6JPXsCe5bIT_XRt2oes', 'a:4:{s:6:\"touser\";s:28:\"o83291IEM6JPXsCe5bIT_XRt2oes\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/2/status/0/openid/o83291IEM6JPXsCe5bIT_XRt2oes\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:81:\"会员 张雅璐申请加入大热前海训练营 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"张雅璐\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-24 16:17:27\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508833047, NULL),
(122, 'o83291PIWaWsfNat_XkflwCO5sX0', 3, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/2/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0', 'a:4:{s:6:\"touser\";s:28:\"o83291PIWaWsfNat_XkflwCO5sX0\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/2/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:81:\"会员 张雅璐申请加入大热前海训练营 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"张雅璐\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"2017-10-24 16:17:27\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508833048, NULL),
(123, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 'a:4:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:78:\"会员 钟声申请加入大热篮球俱乐部 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"钟声\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-24 20:54\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508849680, NULL),
(124, 'o83291PIWaWsfNat_XkflwCO5sX0', 3, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0', 'a:4:{s:6:\"touser\";s:28:\"o83291PIWaWsfNat_XkflwCO5sX0\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:78:\"会员 钟声申请加入大热篮球俱乐部 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"钟声\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-24 20:54\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508849681, NULL),
(125, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:78:\"会员 钟声申请加入大热篮球俱乐部 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"钟声\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-24 20:54\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508849681, NULL),
(126, 'o83291L6prIP8OpF4hhEodd2Lbbw', 80, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291L6prIP8OpF4hhEodd2Lbbw\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/62\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈宛杭\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710242055046491\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"陈宛杭购买高年级班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 0, 1508849731, 1508849731),
(127, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/62\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈宛杭\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710242055046491\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"陈宛杭购买高年级班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508849731, 1508849731),
(128, 'o83291PIWaWsfNat_XkflwCO5sX0', 3, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291PIWaWsfNat_XkflwCO5sX0\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/62\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈宛杭\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710242055046491\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"陈宛杭购买高年级班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508849732, 1508849732),
(129, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/62\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈宛杭\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710242055046491\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"陈宛杭购买高年级班\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508849732, 1508849732),
(130, 'o83291GrGjtzRHy-Ce-iISVv1g8g', 82, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291GrGjtzRHy-Ce-iISVv1g8g\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/63\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"邓粤天\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710242108262316\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"邓粤天购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508850519, 1508850519),
(131, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/63\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"邓粤天\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710242108262316\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"邓粤天购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508850520, 1508850520),
(132, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/63\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"邓粤天\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710242108262316\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"邓粤天购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508850520, 1508850520),
(133, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 'a:4:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:71:\"您好，您申请加入大热篮球俱乐部 成为 教练审核通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-24 22:08\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508854111, NULL),
(134, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/index/index', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"anBmKL68Y99ZhX3SVNyyX6hrtzhlDW3RrB-vB6_GmqM\";s:3:\"url\";s:49:\"https://m.hot-basketball.com/frontend/index/index\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:65:\"您好, 您所在的钟声训练营的管理员身份被移除了\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:15:\"Hot-basketball2\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:33:\"训练营营主或管理员移除\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:28:\"2017年10月24日 23时38分\";}}}', 1, 1508859525, NULL),
(135, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 'a:4:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:83:\"会员 18566201712申请加入大热篮球俱乐部 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:11:\"18566201712\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-25 15:48\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508917693, NULL),
(136, 'o83291PIWaWsfNat_XkflwCO5sX0', 3, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0', 'a:4:{s:6:\"touser\";s:28:\"o83291PIWaWsfNat_XkflwCO5sX0\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:83:\"会员 18566201712申请加入大热篮球俱乐部 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:11:\"18566201712\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-25 15:48\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508917694, NULL),
(137, 'o83291FaVoul_quMxTYAOHt-NmHg', 2, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 'a:4:{s:6:\"touser\";s:28:\"o83291FaVoul_quMxTYAOHt-NmHg\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:113:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:83:\"会员 18566201712申请加入大热篮球俱乐部 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:11:\"18566201712\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-25 15:48\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508917694, NULL),
(138, 'o83291A1ANguB2ziQFNuNZfVNqpY', 18, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 'a:4:{s:6:\"touser\";s:28:\"o83291A1ANguB2ziQFNuNZfVNqpY\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:71:\"您好，您申请加入大热篮球俱乐部 成为 教练审核通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-25 16:24\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508919856, NULL),
(139, 'o83291O77zbRozhXag-N4H-3gYNs', 78, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 'a:4:{s:6:\"touser\";s:28:\"o83291O77zbRozhXag-N4H-3gYNs\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:74:\"您好，您申请加入大热篮球俱乐部 成为 管理员审核通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-25 17:19\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1508923164, NULL),
(140, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/64\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"苏楠楠\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261039114732\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"1元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"苏楠楠购买荣光篮球强化\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508985553, 1508985553),
(141, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/64\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"苏楠楠\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261039114732\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"1元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"苏楠楠购买荣光篮球强化\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508985553, 1508985553),
(142, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/65\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"苏楠楠\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261041275729\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"1元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"苏楠楠购买荣光篮球强化\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508985697, 1508985697),
(143, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/65\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"苏楠楠\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261041275729\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"1元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:33:\"苏楠楠购买荣光篮球强化\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508985698, 1508985698),
(144, 'o83291BakAlQCWKeyc_FFF_4wv9k', 86, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291BakAlQCWKeyc_FFF_4wv9k\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/66\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"姚定希\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261052274244\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"姚定希购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 0, 1508986357, 1508986357),
(145, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/66\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"姚定希\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261052274244\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"姚定希购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508986357, 1508986357),
(146, 'o83291POg8ZrEhE3Zgt-G07LhPCQ', 83, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291POg8ZrEhE3Zgt-G07LhPCQ\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/67\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"梁懿\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261056235265\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:24:\"梁懿购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508986589, 1508986589),
(147, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/67\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"梁懿\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261056235265\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:24:\"梁懿购买前海小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508986589, 1508986589),
(148, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/68\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"哈哈\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261103254721\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"1元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:30:\"哈哈购买荣光篮球强化\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508987015, 1508987015),
(149, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/68\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"哈哈\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261103254721\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"1元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:30:\"哈哈购买荣光篮球强化\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508987015, 1508987015),
(150, 'o83291BZ-sS_M4TfalEvYBJPKhPs', 76, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291BZ-sS_M4TfalEvYBJPKhPs\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/69\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈昊阳\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261147319808\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"陈昊阳购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 0, 1508989728, 1508989728),
(151, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/69\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"陈昊阳\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261147319808\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"陈昊阳购买石厦学校兰球队\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508989728, 1508989728),
(152, 'o83291CzkRqonKdTVSJLGhYoU98Q', 8, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291CzkRqonKdTVSJLGhYoU98Q\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/70\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"小woo\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261237283787\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"1元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:30:\"小woo购买荣光篮球强化\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508992655, 1508992655),
(153, 'o83291GqxP1FCqmfVncltkGVWPaY', 7, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291GqxP1FCqmfVncltkGVWPaY\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/70\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"小woo\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261237283787\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:4:\"1元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:30:\"小woo购买荣光篮球强化\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1508992655, 1508992655),
(154, 'o83291EXiFa63cldJebi_gdGD5Xo', 81, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291EXiFa63cldJebi_gdGD5Xo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/71\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"周子杰\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261512286932\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"周子杰购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509001966, 1509001966),
(155, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/71\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"周子杰\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261512286932\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:36:\"周子杰购买北大附小一年级\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509001967, 1509001967),
(156, 'o83291A2aAflGavcBJDjeHRMPgc4', 84, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291A2aAflGavcBJDjeHRMPgc4\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/72\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"余永康\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261623183711\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"余永康购买松坪小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509006276, 1509006276);
INSERT INTO `log_sendtemplatemsg` (`id`, `wxopenid`, `member_id`, `url`, `content`, `status`, `create_time`, `update_time`) VALUES
(157, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/72\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"余永康\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261623183711\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"余永康购买松坪小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509006277, 1509006277),
(158, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/15/status/0/openid/o83291FErHA03raoSlWaWQTtl1Jo', 'a:4:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"aOTMBdZbOKo8fFEKS5HWNaw9Gu-2c8ASTOcXlL6129Q\";s:3:\"url\";s:114:\"https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/15/status/0/openid/o83291FErHA03raoSlWaWQTtl1Jo\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:78:\"会员 Gavin.zhuang申请加入钟声训练营 成为 教练，请及时处理\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"Gavin.zhuang\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-26 16:45\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1509007514, NULL),
(159, 'o83291PGocc_Bwa-1J7pB9ApCFmM', 36, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/15', 'a:4:{s:6:\"touser\";s:28:\"o83291PGocc_Bwa-1J7pB9ApCFmM\";s:11:\"template_id\";s:43:\"xohb4WrWcaDosmQWQL27-l-zNgnMc03hpPORPjVjS88\";s:3:\"url\";s:63:\"https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/15\";s:4:\"data\";a:4:{s:5:\"first\";a:1:{s:5:\"value\";s:65:\"您好，您申请加入钟声训练营 成为 教练审核通过\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:12:\"审核通过\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:16:\"2017-10-26 16:52\";}s:6:\"remark\";a:1:{s:5:\"value\";s:18:\"点击进入操作\";}}}', 1, 1509007969, NULL),
(160, 'o83291BRbsgvR3ENAV20DXRRdqoI', 39, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291BRbsgvR3ENAV20DXRRdqoI\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/73\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"饶宏宇\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261656532143\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"饶宏宇购买松坪小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509008230, 1509008230),
(161, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/73\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"饶宏宇\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261656532143\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:27:\"饶宏宇购买松坪小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509008231, 1509008231),
(162, 'o83291GAv0SNsD3YmISgMiHOut0Q', 87, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291GAv0SNsD3YmISgMiHOut0Q\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:62:\"https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/74\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"朱涛\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261715415806\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:24:\"朱涛购买松坪小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 0, 1509009392, 1509009392),
(163, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/74\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:24:\"订单支付成功通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:6:\"朱涛\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710261715415806\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:24:\"朱涛购买松坪小学\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509009392, 1509009392),
(164, 'o83291CzkRqonKdTVSJLGhYoU98Q', 8, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291CzkRqonKdTVSJLGhYoU98Q\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:51:\"蒋清奕购买课程订单支付成功补发通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"蒋清奕\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231510000000\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:21:\"蒋清奕购买课程\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509074937, 1509074937),
(165, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 6, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291E-y8PFoWJ4k0IRFArpN0p8\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:51:\"蒋清奕购买课程订单支付成功补发通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"蒋清奕\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231510000000\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:21:\"蒋清奕购买课程\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509074938, 1509074938),
(166, 'o83291Nf-U88M3FV7KRiu_0czrSg', 4, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291Nf-U88M3FV7KRiu_0czrSg\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:51:\"蒋清奕购买课程订单支付成功补发通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"蒋清奕\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231510000000\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:21:\"蒋清奕购买课程\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509074938, 1509074938),
(167, 'o83291IEM6JPXsCe5bIT_XRt2oes', 1, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291IEM6JPXsCe5bIT_XRt2oes\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:51:\"蒋清奕购买课程订单支付成功补发通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"蒋清奕\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231510000000\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:21:\"蒋清奕购买课程\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509074938, 1509074938),
(168, 'o83291FErHA03raoSlWaWQTtl1Jo', 19, NULL, 'a:5:{s:6:\"touser\";s:28:\"o83291FErHA03raoSlWaWQTtl1Jo\";s:11:\"template_id\";s:43:\"oB1u_CWLR0h9HE4CpszWjFE-9dFAQ89aufv7C1y-NyU\";s:3:\"url\";s:68:\"https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75\";s:8:\"topcolor\";s:7:\"#FF0000\";s:4:\"data\";a:6:{s:5:\"first\";a:1:{s:5:\"value\";s:51:\"蒋清奕购买课程订单支付成功补发通知\";}s:8:\"keyword1\";a:1:{s:5:\"value\";s:9:\"蒋清奕\";}s:8:\"keyword2\";a:1:{s:5:\"value\";s:19:\"1201710231510000000\";}s:8:\"keyword3\";a:1:{s:5:\"value\";s:7:\"1500元\";}s:8:\"keyword4\";a:1:{s:5:\"value\";s:21:\"蒋清奕购买课程\";}s:6:\"remark\";a:1:{s:5:\"value\";s:12:\"大热篮球\";}}}', 1, 1509074973, 1509074973);

-- --------------------------------------------------------

--
-- 表的结构 `log_wxpay`
--

CREATE TABLE `log_wxpay` (
  `id` int(10) UNSIGNED NOT NULL,
  `callback` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `media`
--

CREATE TABLE `media` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE `member` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(10) DEFAULT '0',
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
  `hp` int(10) NOT NULL COMMENT '业绩|经验',
  `cert_id` int(10) NOT NULL COMMENT '证件id',
  `score` int(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `flow` int(10) NOT NULL COMMENT '流量,三层关系',
  `balance` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '人民币余额',
  `remarks` varchar(255) NOT NULL COMMENT 'remarks',
  `delete_time` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`id`, `pid`, `hot_id`, `openid`, `member`, `nickname`, `avatar`, `telephone`, `password`, `email`, `realname`, `province`, `city`, `area`, `location`, `sex`, `height`, `weight`, `charater`, `shoe_code`, `birthday`, `create_time`, `update_time`, `level`, `hp`, `cert_id`, `score`, `flow`, `balance`, `remarks`, `delete_time`) VALUES
(1, 0, 12345678, 'o83291IEM6JPXsCe5bIT_XRt2oes', 'HoChen', 'HO', 'https://wx.qlogo.cn/mmopen/vi_32/SibkSPyDCsQgsldCSicKXvqPNPvb17ibRBGl7sEWGx9ZUXYjuIRavp1UDiaMGRyC0J57ulsAOxQCvn0eBhP8UXp4UA/0', 13823599611, '872d593b8b25ae4d55984b076e4736021a0cd211', '37272343@QQ.com', '', '广东省', '深圳市', '南山区', '', 1, '173.0', '70.0', '', '0.0', '1980-09-28', 1506411866, 1506936429, 1, 0, 0, 0, 0, '0.00', '', NULL),
(2, 0, 22222222, 'o83291FaVoul_quMxTYAOHt-NmHg', 'Hot-basketball2', '大热篮球俱乐部2', 'https://wx.qlogo.cn/mmopen/vi_32/hRnMzjwHkMNhoQiaP1tATWgTvEvsNTQibWEysfJnEQ9hS50ZiatuR7XkPjdCzIib5ZjE4CxXUXo7eAwnnWZZhqGTJQ/0', 18565717133, 'c0bcae4cbde0304dd6e0df40d02ba9d00bd7714f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506411868, 1506411868, 1, 0, 0, 0, 0, '0.00', '', NULL),
(3, 0, 11111111, 'o83291PIWaWsfNat_XkflwCO5sX0', 'Hot Basketball 1', '大热篮球俱乐部1', 'https://wx.qlogo.cn/mmopen/vi_32/vJYBxqAI4qV7pRBsbHSBUw83PrV2BH8hkY1vV4LebwTKe2GRPvwRDF8LlpjuRS5rBBgicdVUk5W1m6icwphlNIzw/0', 15820474733, 'c0bcae4cbde0304dd6e0df40d02ba9d00bd7714f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506411921, 1506411921, 1, 0, 0, 0, 0, '0.00', '', NULL),
(4, 0, 66666666, 'o83291Nf-U88M3FV7KRiu_0czrSg', 'weilin666', 'WL伟霖', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJXZOE1LAocibpESZQmicYIiaV9xNgKdLRgdL4Hn7omXHdFTwqJTphdHFhGMKujX46B6icUJlfibOKx5pw/0', 13410599613, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506413991, 1507864772, 1, 0, 0, 0, 0, '0.00', '', NULL),
(5, 0, 33034200, 'o83291HVzrqZlYFdSeK1OBx6sX_E', '123abc', '劉嘉興', 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYIDwRM5lic1WWW9mKWFS1a1fYeA/0', 13418931599, '0ec86335375000549a1f41c771049e206cb0c77f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506414131, 1506414131, 1, 0, 0, 0, 0, '0.00', '', NULL),
(6, 0, 39462845, 'o83291E-y8PFoWJ4k0IRFArpN0p8', 'legend', '© iamLegend', 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 13826505160, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', 'lekzoom@163.com', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506415529, 1507797500, 1, 0, 0, 0, 0, '10.00', 'balance+10,做测试', NULL),
(7, 0, 45886966, 'o83291GqxP1FCqmfVncltkGVWPaY', 'wayen_z', 'Wayen', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJsb6yF8nF3I5eGmQT8zoRicAaF9QjfTbHwBofiaa5tIHUpRqMicicth5SW0I4L6pTbr6UDbGnqSZWPpQ/0', 15018514302, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '185918240@qq.com', '', '', '', '', '', 1, '170.0', '52.0', '', '0.0', '1993-10-01', 1506439301, 1508815217, 1, 0, 0, 0, 0, '0.00', '', NULL),
(8, 0, 90306367, 'o83291CzkRqonKdTVSJLGhYoU98Q', 'woo123', 'WOO', 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 18507717466, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506565743, 1506565743, 1, 0, 0, 0, 0, '100.00', '', NULL),
(9, 0, 26233702, 'o83291I75hoZy8HuDN6nfM6c7qZM', 'GaoYan', '燕子', 'https://wx.qlogo.cn/mmopen/vi_32/ctgjGIoTXvGgGdMuicTg0JJ06laxfIjySYQxxibQdj62ORwYuBOA5dJJMJ1XDmVTyzghmTNEicxveUsMCaqfvicSKA/0', 13662270560, '17f4e70a33cfa503f9cd6098ee67e7e9b49cb995', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506576907, 1506576907, 1, 0, 0, 0, 0, '0.00', '', NULL),
(33, 0, 91787026, 'o83291IHLROCvqO8JHb7e5mP1KFs', 'yanyan', 'Yan', 'https://wx.qlogo.cn/mmopen/vi_32/O7FdsFsjE6NfAwpXI4ibEoGlatUpKmnOtfwibtS3ibD1x7U9iaYTdF6X7Iicx5O5xdOcs3w5VcaiaV9Em3yQj9o0arqA/0', 13632649700, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508202221, 1508202221, 1, 0, 0, 0, 0, '0.00', '', NULL),
(11, 24, 79986624, 'o83291I0HI28QoLyldPwvPnPExQQ', 'hot111', 'Hot 1', 'https://wx.qlogo.cn/mmopen/vi_32/muicwf6diaciaaERRnFIxgxUicbhjOHiatRUCWYL23rhQzqPkcad0OKWzyAxDLvSkku7yMo1icfGgSjjGXQ4FibcnOL7w/0', 18126211925, '90a66b83f55b773baeba20cb41608d442cf1bb2d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506659842, 1507723503, 1, 0, 0, 0, 0, '0.00', '', NULL),
(12, 0, 70124881, 'o83291E81bVr-WDGRTcybW1P2jOw', 'willng', 'WILL', 'https://wx.qlogo.cn/mmopen/vi_32/u0hn2SHI1D1dbhYlZibicIjWzySCmtmiaaW5ta7PLc3DsDV6Ks90OBGUtMKbwTnZ2Av2iaDIEkelQqniaIVzoaqC7xA/0', 13684925727, '1755de0f1d6eaa4ae7b78b70972b672f97cbcc5c', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506683191, 1506683191, 1, 0, 0, 0, 0, '0.00', '', NULL),
(13, 0, 104930775, 'o83291FVItqsEfwQSDEqNlzyuHks', 'Greeny', '彩彩', 'https://wx.qlogo.cn/mmopen/vi_32/Zv8ZEHKjZyjrTMFWe6HdRGyzZzBqsBMABVOsfzchrMqZ0tCbl9RXXSibChjOX8whWsORxvbZQ7xsp2z1Nuf8Fag/0', 13828880254, 'f0410bf59c30e4b49c8461891521b8f8a7c33c59', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507355136, 1507355136, 1, 0, 0, 0, 0, '0.00', '', NULL),
(14, 0, 52716295, 'o83291KL2AaC9BHyc9zFd_kFvtQw', 'MirandaXian', 'Miranda 冼', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKic6bHKticocJYeku4Tvq5O8EKy3dSct1zibMw9lsE2zKqSjd9QGnw3732LUT1crga45puTKrE7W74w/0', 13480839509, '55a4457158e14ac506c4fab130406d17911c4c1e', '', '', '', '', '', '', 2, '0.0', '0.0', '', '0.0', '0000-00-00', 1507707377, 1507789272, 1, 0, 0, 0, 0, '0.00', '', NULL),
(15, 0, 35176624, 'o83291MimVCWJqgxQh8PS-6rK-pE', '13537781797', '武爱平', 'https://wx.qlogo.cn/mmopen/vi_32/EjW08lGy0nK6Z6o1yepRh0N8wZMXGR7IagCefF8yXMEaKDflaibzxUmBicqlkUqicjIvqwXphDBKqWD6CdYNkHuJw/0', 13537781797, '615732e469d328f8115f1692441118c116847ec4', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507708923, 1507708923, 1, 0, 0, 0, 0, '0.00', '', NULL),
(16, 0, 90913709, 'o83291NnmXYmtzw-FGuPP-rDxFc0', 'andy.lin', 'LINZEMING', 'https://wx.qlogo.cn/mmopen/vi_32/IolbUoRiaibzjwML7wBHb3QWHVRSDcNQ27jlY2NyaWC0nib62dOic5ZrLRSOVIa24aO8F56icBwKa4oIZha00VibXBwA/0', 13717147667, '213a23ad9091ae9a704ef495da802785df6a9b29', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507782144, 1507782144, 1, 0, 0, 0, 0, '0.00', '', NULL),
(17, 0, 83102079, 'o83291PTfjOJ13exCnFAYGOiYPqU', 'Bruce.Dong', '☀️ 董硕同', 'https://wx.qlogo.cn/mmopen/vi_32/hcLPwracBdo0ciclAv1D5nFykDibNOSMzIwRicn3N8mNsu9HQrNWSS1S0cGy5EwXfqF7XYEY3mgWN8kgM3KxotIibA/0', 13172659677, '5c9b8bf09481ec3bd0b0a0feba360e051c06ca1a', '315308977@qq.com', '', '', '', '', '', 1, '182.0', '76.0', '', '0.0', '1992-07-09', 1507782722, 1508582212, 1, 0, 0, 0, 0, '0.00', '', NULL),
(18, 0, 82244230, 'o83291A1ANguB2ziQFNuNZfVNqpY', '18566201712', 'AK.????', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3oGkQMmHhLG7AE2Zh7Jog/0', 18566201712, 'ce1ed704cc234a91519b6254825fcaef1c74710d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507784651, 1507784651, 1, 0, 0, 0, 0, '0.00', '', NULL),
(19, 0, 33422241, 'o83291FErHA03raoSlWaWQTtl1Jo', '钟声', '声子', 'https://wx.qlogo.cn/mmopen/vi_32/GYJRqVSbrHfNr7k1CeGBmBuklcV9AsrabdT7L2ocyibnk3ooib4zuJnHN1pviakXZicBJEVPlxfXNn9giagYzLWZU5w/0', 15999557852, '0fa2b9ba3ec7c879de86cee5656a2c123a07fbe3', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507801745, 1507801745, 1, 0, 0, 0, 0, '0.00', '', NULL),
(20, 0, 10250947, 'o83291KD96qrAbVGyYjT9IRFIFF0', 'Tekapo', '黄岗', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJ0BiclRbtdQ0grGuR4Jl8uZy5sDZ0lODw0GrPA39bTAxrYxG69Vex8sp2nLLs96DxRKWS6QHB3vxQ/0', 13602582272, '3352b3dc9eb13627dda16b8206f49bc22755f3d7', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507883594, 1507883594, 1, 0, 0, 0, 0, '0.00', '', NULL),
(21, 0, 97184947, 'o83291EeENsitgzLK7q0syOUHpGs', 'Bingo', 'Bingo', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTL2ZoHxVIic5SlydeEBSayd4F29BFSmGIYicWlOChxbsA3TCAiczib043Ficr9cKyOIYUiaiaoYrrKXuTxmA/0', 13692692153, '860bfaa5bdddb3afb51aafb192b2b68ed43dc13d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507950469, 1507950469, 1, 0, 0, 0, 0, '0.00', '', NULL),
(22, 0, 47908831, 'o83291A5wGtrhnird1sZ9S19OqPc', '邓赖迪', '花花', 'https://wx.qlogo.cn/mmopen/vi_32/yxWUVmiccGZeSicNH29hbhqBq2p1ET1phRfdAXjhVr74S4bsuykQibg4ruiafib3bdcMOPMIDnaflo4bpiaAeYITerNw/0', 13537819321, '4a79158bd33a885dd0a0068d1a1410fce6196b85', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507950583, 1507950583, 1, 0, 0, 0, 0, '0.00', '', NULL),
(23, 0, 68494703, 'o83291CMWK1XzKOSJN1CW95ybYgk', '123456', '祖儿', 'https://wx.qlogo.cn/mmopen/vi_32/X9UaYIg5SOWJPT50nQlI2wJj8LiclBgqxic2TVmrJjjgFQP418GXB1TI7SmIXaz0S0WL7ZFgGJ5AZshia13Fu7A0w/0', 13699816180, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507951568, 1507951568, 1, 0, 0, 0, 0, '0.00', '', NULL),
(24, 1, 58090222, 'o83291CbcwZsw60mUhBqCGfpFDbM', 'Hot777', '大热 H1', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKJwIOoK7eq3g5cId6ic0tY0CjlYvib95yq8fOurvnGL5FqtEB1FIub1y1FlE8LWY92gjTfqoibicUjzA/0', 17727573721, 'aab6b9ab4cb94cbc67044343dabdd91b918486be', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507960953, 1507960953, 1, 0, 0, 0, 0, '0.00', '', NULL),
(25, 0, 108115832, 'o83291JdwssMW2YtU6CxHJDsDyl4', '罗翔宇', '春暧花开', 'https://wx.qlogo.cn/mmopen/vi_32/osJ1rDGqWf17lXSx5ibm0gARnYZw9e47782fdX1MPG3ibp1PvEnfRVfk41CiaO8wSCia6kiaWS3ibv0Ro83rsRJwycbQ/0', 13924641692, 'a7a15393874b877750039485ef682701eb8030bf', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507968238, 1507968238, 1, 0, 0, 0, 0, '0.00', '', NULL),
(26, 0, 91754481, 'o83291DEQMrOGBcwXrbPisKaET1w', '陈承铭', ' 屈', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTL5J7KP9AoeM14ktVyZVQUawzkcSzDF1ibL6YNXibqic52jLx9wrkUt6SxBhPYPe66FSiayibq3hx1TXwA/0', 13570811474, '1bf1de8d1b00beaba61d31f95bab77f51c43542a', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1507975719, 1507975719, 1, 0, 0, 0, 0, '0.00', '', NULL),
(27, 0, 100163773, 'o83291L2DtT9rOnVagr0B9Y07YYs', 'coachj', 'Love', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTI0AhqIOicZ21iczmWqJiajtssTHwRkQBLoPguQpp92LwAxc1ywJwDfnq3XsvCEfUvoxoPrYRl41vxlQ/0', 13760379341, '1a741b950b4d7bdd7781f81c626681f9cbff1653', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508051194, 1508051194, 1, 0, 0, 0, 0, '0.00', '', NULL),
(35, 0, 56431609, 'o83291Ch9vlLwqkcigU5Ka-GzGN0', 'LK', 'LK_┏(｀ー´)┛ ????', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eolibHibbzicClicU4Tx7BvhHibaNvqbcmjJHK5s69wogoIbulSGUkmpMicg1oGzf3Ilh6MV9TKgial5b4mg/0', 13510075181, 'f9ea01c6aa2cb804340a28c4a145aeeda2b484f9', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508305544, 1508305544, 1, 0, 0, 0, 0, '0.00', '', NULL),
(34, 0, 75302054, 'o83291D_Mpi8_2hLfvs9NzkKHAhI', 'zehanw', 'HAN', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eprCjIwMn5f9IMKqFrTljjAC5pPdt7a6Rx5RicWLPEWU3qiaDfZeicAtu0ibqFzxcX28qRyviagtXBqFLQ/0', 13632567039, '312b55aedd92b1695d8a65449dd152e536bcb314', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508244318, 1508244318, 1, 0, 0, 0, 0, '0.00', '', NULL),
(36, 0, 61644254, 'o83291PGocc_Bwa-1J7pB9ApCFmM', 'Gavin.zhuang', '小   庄', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83epOduDhUtuyC1AWUhibGFF1seAZNEEmNCweyxicNXJruzTiav7ljzgzTgSDibNEjxYw6lkotuByqmBluQ/0', 18576475234, '6137d90f72e65f29f4a87e12eec553bbbcff50e3', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508383315, 1508383315, 1, 0, 0, 0, 0, '0.00', '', NULL),
(37, 0, 58709332, 'o83291CC9v5oNsz94zBlG52LpbQM', 'Jim', '萍', 'https://wx.qlogo.cn/mmopen/vi_32/teBGmK4b9WbVfujdt0fgltCpLBYa0ib8XpsSicibhkQSdu5BJEZ1w64qHOyNVGEsHMia4yGkOVTc9cZFLynibYhiatlw/0', 13927440305, '059daabc61a6165865357a78fde10182c2b84afb', '', '', '', '', '', '', 1, '119.0', '46.0', '', '0.0', '2017-10-19', 1508389108, 1508389209, 1, 0, 0, 0, 0, '0.00', '', NULL),
(38, 0, 85903084, 'o83291AHUqBXijaCqkgHPerflh24', '1234567', '梦燕????', 'https://wx.qlogo.cn/mmopen/vi_32/L4w7xviahsLZpQRsial3ljBCAqVsKuicCyllnBEyxibJVzccPapXUp0N6EGZkO6WTNgwKrsKwW5GUSr7my3D2wbSTA/0', 13632747197, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508389154, 1508389154, 1, 0, 0, 0, 0, '0.00', '', NULL),
(39, 0, 92203299, 'o83291BRbsgvR3ENAV20DXRRdqoI', '饶宏宇', 'Ro', 'https://wx.qlogo.cn/mmopen/vi_32/QiaJBRJFj5Xt3S5WluEumvf6C68fm3U1NBVpSlicePadW44QHt3aDljkr1iaYYZDH2LlXibQfFIlp2oNaxX6dHAasg/0', 13640904690, '9a800787f184ecc38a3d5ee620265bb679de5e53', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508389277, 1508389277, 1, 0, 0, 0, 0, '0.00', '', NULL),
(40, 0, 59142401, 'o83291NrSkWFU7LfiIq_p5r9JXL0', 'M00101556', 'caomx', 'https://wx.qlogo.cn/mmopen/vi_32/1ZjxdtbJHy7R0UO9djt1lRKk8N8aMlVazic98oDpPrpUDbg274urtMAqZpibUnekg5kic6rqkaO6tGvO2ZRvE00Lw/0', 13322928764, '2f613e6c139fb5c7d7f39395914987b71ed2cf13', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508391132, 1508391132, 1, 0, 0, 0, 0, '0.00', '', NULL),
(41, NULL, 84925822, 'o83291IIYc8lxSTo9KAgMMtNr2Qo', '吴杰熹', '朱古力熹', 'https://wx.qlogo.cn/mmopen/vi_32/ibKYWs0QPdsN79xRpfibL8MzH2ICzlJZvjzrswyjmMkLQmU1FABKeygz4XLs53ibhw4ZSyaxJP7S4xUEuYtib7iaKzg/0', 13590492401, 'fcc2e61cadc33dea3b277b29e5dd14dc4737d434', '', '', '', '', '', '', 1, '132.0', '25.0', '', '0.0', '2009-12-06', 1508416051, 1508416103, 1, 0, 0, 0, 0, '0.00', '', NULL),
(42, NULL, 67984288, 'o83291HallUspE1Y0-nGCP6aGI90', '李润弘', '绿叶', 'https://wx.qlogo.cn/mmopen/vi_32/icD3j8Uhe4xOLJS1zichGLY3rfpJAI4Efd95vMQxlBhSABPWicw4tOHsyY2rnPVAFDbAohTvsMAxoLIo49bA33Z1g/0', 13510074790, '4b03dd04eebbccc7aa1916e834570e06213e1a2d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508554501, 1508554501, 1, 0, 0, 0, 0, '0.00', '', NULL),
(43, NULL, 38832247, 'o83291M6xwf4rjV8gYdIrlT_qHhQ', '陈润宏', '一棵树', 'https://wx.qlogo.cn/mmopen/vi_32/wCFb3b7CBRJSuXQazfF7N0GIfuhF53JRlkVEq2Z2pUgIMraJI2iaWwCONHk7nkJibrUQiaEyU8yrPxianhMIyuArdg/0', 13713999790, 'f0bd8d46bd883a004baf3ef057314a8e7fc9e113', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508554550, 1508554550, 1, 0, 0, 0, 0, '0.00', '', NULL),
(44, NULL, 35976718, 'o83291BwznLAH7pBl-6LM4F0rL-E', '廖文浩', 'ann', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eoShtJ3NkpeFNicDMEXHAt0eDdydya3UEkzsXobqVMSwst4AeIeh8GgopeSE1zNICn5BSzmibgN8cTQ/0', 13509682395, '90d7798eca5eb369e099a972e61e061ed18418bd', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508554850, 1508554850, 1, 0, 0, 0, 0, '0.00', '', NULL),
(45, NULL, 65522820, 'o83291Coq_rFc2vXFEjA_PXm2h9Q', '莫子涵', '涵涵', 'https://wx.qlogo.cn/mmopen/vi_32/T7ZtJndGPRfkJK4kWyp11c19LMHPiaOhdY8zLUUD3Dsd3cLmDlOsJWCGtlzyCSRBkbGfHAfxnwGIGkniccEgtfbg/0', 13682450510, 'bc756cc88d5ab707a4b736a43b7183ee94bb70e4', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508554972, 1508554972, 1, 0, 0, 0, 0, '0.00', '', NULL),
(10, 0, 22126687, 'o83291Ic0nyfFcuRrhsu2s4sBYxQ', 'wl', 'wlsmall', 'https://wx.qlogo.cn/mmopen/vi_32/CED6Q8VjibXYAa7PaFUib9ZLINjK5MdCrCKiaAeAR9V0icYLRqfWwkt6mv81a0Fmx7HhZvDic0A7ia87CdZz2c41JurA/0', 13902925499, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1506602372, 1506602372, 1, 0, 0, 0, 0, '0.00', '', NULL),
(46, NULL, 72701324, 'o83291OtlzRp8MCFMagBBMOlAGDI', '李语辰', '云li', 'https://wx.qlogo.cn/mmopen/vi_32/JVWE6PQ990A8KoicXXxCEzKP2trTcWSkBsW16ibaYbTZHSTA4mOy410wA2u9uuxUB0FiavLiaBkicKCp9icc9Rgry7HQ/0', 15622835386, 'ef79c906d8236281cdc96176b890f5355c96b97f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508567913, 1508567913, 1, 0, 0, 0, 0, '0.00', '', NULL),
(47, NULL, 26804344, 'o83291Lf7-Kh8DJXkEiwZZv3VHk8', '郑梓深', '百铃', 'https://wx.qlogo.cn/mmopen/vi_32/skK8bIFDzEibrn29rQGrBWhtu1W93Libicw8s3BXvowVHuUNdkIia9wMsHjyQQbEKOYvKXYcer3prQMbRj6eBSAqibQ/0', 15889703813, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508570496, 1508570496, 1, 0, 0, 0, 0, '0.00', '', NULL),
(48, NULL, 93888399, 'o83291DFDpzuxxmAsQtnfZICTBsw', '郑肖杰', 'ZHM', 'https://wx.qlogo.cn/mmopen/vi_32/8B6CScn6mZribr9bTI1RhDEiaQvCtKUKp9BmL1VLoamZWKFF3mHqfOOw2zN5gOIFCBpwsycFWFnr6SulEH2hRLBA/0', 13925297472, '6f44ba6b99ca270568a8882bf5c4f0aaa73d60a2', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508639855, 1508639855, 1, 0, 0, 0, 0, '0.00', '', NULL),
(49, NULL, 101723099, 'o83291KSimBWL49RP8HvnUEu6tqE', '黄浩', '????冬雪????', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIn1c0h4Xcn8dISicib3c5qRUsmhvibqvQMY7q3qFUSVw36nw1XW7GEQx1nVkkWQyEyGbtr6JMuBOfyg/0', 15999691100, '9ff765a45887e2808e705fe11a6a9ac01e13d354', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508658012, 1508658012, 1, 0, 0, 0, 0, '0.00', '', NULL),
(50, NULL, 70298257, 'o83291GqvM0TIqzyNcBM4Xu1dCD4', '张毓楠', '艾楠', 'https://wx.qlogo.cn/mmopen/vi_32/ywnQfcMqe2uC9KP2fDr6QorLMk8FFkIL3IUpfJn7D8707CEIfcUwLEOLGf85A0C9bY4a29ZkcfkGa3RwSKoMbw/0', 13928447499, 'd73e3bb1ca7fb74471ffac8a456a944f36144bcd', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508659584, 1508659584, 1, 0, 0, 0, 0, '0.00', '', NULL),
(51, NULL, 18018422, 'o83291NqF3-x4zg2KoZEs508UD3A', '战奕名', 'carolB????T', 'https://wx.qlogo.cn/mmopen/vi_32/v4IpFsmBcCwGN9D1SzfmfahDia8p8l3saE3DbWnmOY2HCClXCmfibzzw3H3hcnbXAAkcwQH6icJxiabSc03HnXSLlA/0', 15818553993, '123476f60f65e2776874e79d27c0c3bf5247424e', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508661091, 1508661091, 1, 0, 0, 0, 0, '0.00', '', NULL),
(52, NULL, 59092431, 'o83291A33b20_vCpOuuks0zf1BKI', '吴师隽', 'SMC气动元件', 'https://wx.qlogo.cn/mmopen/vi_32/NYp0qdFEpicQ36DW8ZpibPCSVAf3NSCNJgwbgKerkcXV3wlXwUdn0XfgBf26eIZ4tqibxT5ScU6el8A1bouRwibcJg/0', 13670002176, 'd0677264b79381bb7fc15d0d87dfa2fdb4573825', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508661799, 1508661799, 1, 0, 0, 0, 0, '0.00', '', NULL),
(53, NULL, 72032210, 'o83291Ic09SqseuvbS0y0ts9K94Y', '韦哲睿', '李小玲', 'https://wx.qlogo.cn/mmopen/vi_32/IQVqNKB1RYttbqHVribH2DvpGBqfwjKYkVVnax4aOXj4Fdar57QxQXB7ib5DDBH5xJkKd3rXY8oEcC5bhicFuSY0A/0', 13537699951, '4cab5c7dd3dc788e32bc4afb4c9a4be8671838d5', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508661829, 1508661829, 1, 0, 0, 0, 0, '0.00', '', NULL),
(54, NULL, 59339362, 'o83291BVjxWwwKJAjEG5v5feUxRI', '林嘉钰', '????香花满园', 'https://wx.qlogo.cn/mmopen/vi_32/cfAga8yZoHFNhISg6dACW2DuAAAYZCKJYnKFKA1rmpIXJHiajE19tecyXd1kecCk6JPIBGGjSAIYnftthSYASTQ/0', 13530306808, 'a1eba0bae9c2d9819eec64aeb6e14c66071cea1f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508663464, 1508663464, 1, 0, 0, 0, 0, '0.00', '', NULL),
(55, NULL, 55387384, 'o83291IecDIpcwfwvTI4VjdDVnLg', '唐轩衡', '冰冻', 'https://wx.qlogo.cn/mmopen/vi_32/VVyUyM6Q3vHB0kvA47iafepgr2L2vx8nvxzeSIKqJQLGz6qA9RWloXBmvCic1r4pD1chaLOLck0y4r3aibFmEE1YQ/0', 13538289022, 'cfe94735d77ff94770afe5a612c2119532e5d03d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508676301, 1508676301, 1, 0, 0, 0, 0, '0.00', '', NULL),
(56, NULL, 74436155, 'o83291IKJJk_0rmmzyE61dhptuN0', '郑皓畅', '日月星辉', 'https://wx.qlogo.cn/mmopen/vi_32/6zNQeeicR57x1lcicY9mgX2MBCibf3OkicIKIvEcq1Ec7ibFPRFkEtg8nKeBoiaNfrwoGmvu9Wt5BWo9HicxroYqjRZsw/0', 13556389955, '9435de947d1369a4229351548714c115cad888fc', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508676398, 1508676398, 1, 0, 0, 0, 0, '0.00', '', NULL),
(58, NULL, 108906599, 'o83291FwBuKh8hcIAyNNc5WQ3-nc', '饶滨', '许 燕', 'https://wx.qlogo.cn/mmopen/vi_32/3q4wOibh9nZPekaEh1mPpULmJARKuuXRphK7Mak1kTjCNNIibNEjNicoEVtmJLT9G7kjoNZ6vllcLteP8vibyXiaj0A/0', 13113013889, '1bf4220bbbda80422b639a4ab418312852cc8397', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508687857, 1508687857, 1, 0, 0, 0, 0, '0.00', '', NULL),
(81, 0, 67377266, 'o83291EXiFa63cldJebi_gdGD5Xo', 'rebeccazhangly', 'Rebecca', 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Dribia5ZQu19qPDlO8LQuwYfbEKvkc4np2NicicpECusbLsAYMLtVn4pT8IcyBibvMnjL6w/0', 13632598336, 'a11a1b131e14657433e11680f363fea986d60fa9', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508848866, 1508848866, 1, 0, 0, 0, 0, '0.00', '', NULL),
(59, NULL, 93002945, 'o83291Jlbvm7DwWPGS5MufN3NC8o', '陈高翔', 'Jenny', 'https://wx.qlogo.cn/mmopen/vi_32/yzvxOetibI0IK3Jjwxb8AhFLpiaf8sEqjkhPwXgtr0JRXWJNIVDBvT6QjblpFABBKGCvGryia5xz20zwzEg5BZ6dg/0', 18603038806, '3dc3d04aa41c194320ab93a6f8e7047ed3ddcf9f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508689138, 1508689138, 1, 0, 0, 0, 0, '0.00', '', NULL),
(60, NULL, 77780684, 'o83291Nv-kf4Mm-3fcGXFrftR2BM', '王钰龙', '小叮当', 'https://wx.qlogo.cn/mmopen/vi_32/mpqiaCLKTSkHXZbs2GqFnjoflrkMib2j49z5yM8VHDmmUSicHZI5iak2Tia6ykX7tXT8TOBYB2v9UaYmnJ99Z0FCO0g/0', 13723758658, '7d49a57d110cb73fa99c630a9ff1c7fac63672ba', '', '', '', '', '', '', 1, '139.0', '26.0', '', '0.0', '2007-11-03', 1508724248, 1508724367, 1, 0, 0, 0, 0, '0.00', '', NULL),
(61, NULL, 28851096, 'o83291DhgEQp_py8JNcUAcRVwdfI', '万宇宸', 'Raina', 'https://wx.qlogo.cn/mmopen/vi_32/pnKFC33CDdnArcQ0ONDFVdlQ1yF6aewh99xgKW3G72iaruRr1oGTIwV8gfpfptb4VpBdicrZ9pJLwpib50cYrfVVw/0', 13714718628, '97083a2bc4dd76b2d27d7cbebce06976f9e7b442', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508725971, 1508725971, 1, 0, 0, 0, 0, '0.00', '', NULL),
(62, NULL, 42845110, 'o83291ABmknfWiRut_zD2p6P7664', '刘宇恒', '小鱼儿', 'https://wx.qlogo.cn/mmopen/vi_32/dg5BzBbk6ialKxBfoWtI9iayIQS6b5pG0QF1ib4YiauZics9fBRksgtWibAcHYEGiaJbjOR4W0jOgGJIb6LAwiapjEkkbg/0', 13602581364, '5dd101db2d3974e61f097509c74a11c99d608797', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508729227, 1508729227, 1, 0, 0, 0, 0, '0.00', '', NULL),
(63, NULL, 80877252, 'o83291FMYyZlagb8A74nkYfdWnE4', 'leonhuang', '饭没了秀', 'https://wx.qlogo.cn/mmopen/vi_32/PH3lR9dDe7o1dzyQIgkpkLhkOchMTwEEqQ3TI2oKPmxGNOKbgicYAV4wORoMLw2NGBaNDjVMv8x38BjJRibThTzg/0', 13826554640, '4414a5d2b0a1e20d4836d33b4669c56a1243af2e', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508729576, 1508729576, 1, 0, 0, 0, 0, '0.00', '', NULL),
(82, 0, 60994770, 'o83291GrGjtzRHy-Ce-iISVv1g8g', '13927482132', '李苏阳', 'https://wx.qlogo.cn/mmhead/jJSbu4Te5ib9GgS8EBYzj9DGPl5G68qqDVadUWdDKYdNwEibDBUlFaPA/0', 13927482132, 'd92a1116c32c5401a5a6d788f1be95f7092375bd', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508850461, 1508850461, 1, 0, 0, 0, 0, '0.00', '', NULL),
(65, NULL, 27286407, 'o83291KfnvX8nNY_1vkN-45hbUtU', '蒋清奕', '金华', 'https://wx.qlogo.cn/mmopen/vi_32/KPhkPWv5GJzGOMfpr7zUuu7pmiasbeR0AjxvL00FxSmK2m9WLhlia5VB9iaw1skboCIHmIibsOcZ7KDiaicycSvcygNw/0', 13510633766, '092aa903338b3392a888e920287aae004174c70b', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508730778, 1508730778, 1, 0, 0, 0, 0, '0.00', '', NULL),
(66, NULL, 65093840, 'o83291IobV5CnYduYqHQP3OeFCVM', '20101119', '雯琪annie', 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Du6wQajIibtJa0SkWurB9LkfK1vR4BQiaZ14GnibibNdUdOG0iaQlVvcthLcx7Qf0mKBBLw/0', 13928438541, '7fa25b73111f06e708252eecb11409474264a0c8', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508732339, 1508732339, 1, 0, 0, 0, 0, '0.00', '', NULL),
(67, NULL, 91061295, 'o83291M9vdRoN4N4CRULeSB1CasI', 'gaojun', 'gaojun', 'https://wx.qlogo.cn/mmopen/vi_32/x7dO3qq2JzUkwK79rS0ZmwrnficUG7mB9bAUOQ7lB52dY5uhUMgBFPQoAsY5w1LWrzYwDROVSKrYoqmq6qgYrcg/0', 13501570069, 'e8b56895598159a9edf4fe584d208037361a2b4b', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508735081, 1508735081, 1, 0, 0, 0, 0, '0.00', '', NULL),
(68, NULL, 36012900, 'o83291O8MYKJBiohRSYgdTzs4XUk', 'M00101482', '游游', 'https://wx.qlogo.cn/mmopen/vi_32/jDdLSG5kAwZmeLicLRichLhJmJQ5gRRoic22fRNNFwZkyvH2sey5ktxIsUNt8iciciaUCF2VVh635PndgRnWekd3Zclg/0', 18319019560, '04076acd22916be8bbdbca29b285991cfa898034', '', '', '', '', '', '', 2, '123.0', '20.0', '', '0.0', '2010-07-31', 1508736263, 1508736516, 1, 0, 0, 0, 0, '0.00', '', NULL),
(80, 0, 16752716, 'o83291L6prIP8OpF4hhEodd2Lbbw', 'kiko', '湘云', 'https://wx.qlogo.cn/mmopen/vi_32/zocbwtq7yDlo6zSBZ0jmSgpaHaFWmAotUTmzHopaB1Vl8DVWP9Gdd7U37xhdUkg30Z6HE6BzIBKGqEJBRDQOLA/0', 13603022117, '5f5a43224f21b7774db8d095b33677ed14a12920', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508847551, 1508847551, 1, 0, 0, 0, 0, '0.00', '', NULL),
(70, NULL, 99451210, 'o83291IPjneZsoXyULWjxZRdE3h8', '6227007200800133748', '丽丽', 'https://wx.qlogo.cn/mmopen/vi_32/SMP0cx6pcibSMCfJH6rUZgDNhqkPAx8DySmeBVERVZb1icRwfKJ30BMhicYOGQ6dcuSicGPgPvK42wtLEeL5ibC05eQ/0', 15817261835, '6cb49c353416f37088de58f573aa8ea2550f29cc', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508741576, 1508741576, 1, 0, 0, 0, 0, '0.00', '', NULL),
(86, 0, 20741295, 'o83291BakAlQCWKeyc_FFF_4wv9k', '姚定希', '黄艳', 'https://wx.qlogo.cn/mmhead/BfRL3E0G1pdy5s3m2OtzHEbJ0tv6PFPzUu34m3zQ3XzzmlMkMgGMOg/0', 13985047399, '807a9b622c3bc48ff0abfcc42f7ea2fc22898c7f', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508944002, 1508944002, 1, 0, 0, 0, 0, '0.00', '', NULL),
(72, NULL, 48486506, 'o83291CH5sA5EBZJ07kqgrzApYDQ', '邱仁鹏', '余', 'https://wx.qlogo.cn/mmopen/vi_32/fBDFFCYPFnNoqujMnoc0icibND9eDdfXFgwVkrE8zmtBib7o4kjHjric7XKUvd9icicxnTr5icOokavbvTQrcuzw9veMQ/0', 18620306265, '96dc7e75e0ed71b894851e1ed3ea4c8ed8c78c2e', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508765322, 1508765322, 1, 0, 0, 0, 0, '0.00', '', NULL),
(73, NULL, 85224769, 'o83291CoSbokWDoHUwFSfsQmOdnE', 'SZQIUJB', 'bo', 'https://wx.qlogo.cn/mmopen/vi_32/oBJMukfMx9mAfOFLL6oILN4zz1F39lUDnibK34DTlPq3YUq2P7gWk4muj1cDFKMQLlN5ypREzibVJO4yKSEUK62w/0', 13928451722, '2ecc61b813544af638b9462253c99306208ac2bf', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508765724, 1508765724, 1, 0, 0, 0, 0, '0.00', '', NULL),
(74, NULL, 10334581, 'o83291N2g6PxiplYQU6SxB8dWp7A', '13823181560', '慧子（Helen）', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqicTFZcNkXiaVqLpNeiapVYiaItQ1hGcic0s9BCKqx2aDYVMSD9KNkhuVmtZyvCXASgk1I6jH9LbMw4HQ/0', 13823181560, 'b03e72013e63d69743ce49ac7defd135bf460687', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508765932, 1508765932, 1, 0, 0, 0, 0, '0.00', '', NULL),
(75, NULL, 31882521, 'o83291Bmf1mURlEisNcoyGav6Mxg', 'Jerry', 'Maggie', 'https://wx.qlogo.cn/mmopen/vi_32/7g6icshVrInKsnnzvMpm7jBVXywRsKHnITNpDYTVPXYEWaYh1sDHPRU2z5YIIJdMvNM9HWOPMKyiakHiaibM9lY6sA/0', 13510234557, 'babfac43cea99f9520bd3172f06bb7e010406169', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508771646, 1508771646, 1, 0, 0, 0, 0, '0.00', '', NULL),
(76, NULL, 88147033, 'o83291BZ-sS_M4TfalEvYBJPKhPs', 'cjwcyc', '行山', 'https://wx.qlogo.cn/mmopen/vi_32/GCNUn1n4CPiaMuVncIvb0u3mCyCNIYOQmjMVuSx5SrGOPe94lWMticoCRn3G2qry302FPPTkcichHEpKrzwIb1TrA/0', 13423851796, 'f8012e5b9b2390d3ca416e1ebfe0b9bb90820689', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508810024, 1508810024, 1, 0, 0, 0, 0, '0.00', '', NULL),
(77, 0, 76472437, 'o83291EuefUtWkofTPoFRH83_aHs', 'wayen', 'wayen', '/0', 18124663652, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508816003, 1508816003, 1, 0, 0, 0, 0, '0.00', '', NULL),
(78, 0, 109136210, 'o83291O77zbRozhXag-N4H-3gYNs', '张雅璐', 'Yalu????', 'https://wx.qlogo.cn/mmopen/vi_32/WPDdAKibD9e6HTQM38lcVmEPCSOljciaUwicgN1eyzApz83nDpFHna5asP62Gx3kGVylCRbvFAibarypnc5Rue3Y7Q/0', 13026617697, 'e592faf43066dba26d9586c349ec0d89a5947fb3', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508827751, 1508827751, 1, 0, 0, 0, 0, '0.00', '', NULL),
(79, 0, 66068579, 'o83291MpnhMJjG5RQKYNPmAN_COw', 'Youboy806', '游仔', 'https://wx.qlogo.cn/mmopen/vi_32/LMPP1EaHUlWoor4A7ibKMl1XM80TcezRI5GgwThYwOHPybVktqd8QicgtYr8svs4LPxP0bmSpszQtricUuCGPtuFg/0', 13602600100, '64d6c0cace096bb3513083ff3f33896c2265273c', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508831247, 1508831247, 1, 0, 0, 0, 0, '0.00', '', NULL),
(83, 0, 13227651, 'o83291POg8ZrEhE3Zgt-G07LhPCQ', '梁懿', '芳芳', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIZILv4jZfYyLDTSDRic2TicWv1Lqsy7ibgV1LK3PiaycF11vJQ2Ud4PrDa0XvcQEhdaEAEkb2feNbtCQ/0', 13927478108, 'f736145c15764b4001d04327672ac692b9c51506', '', '', '', '', '', '', 1, '142.0', '32.0', '', '0.0', '2007-12-21', 1508851206, 1508898976, 1, 0, 0, 0, 0, '0.00', '', NULL),
(84, 0, 34555394, 'o83291A2aAflGavcBJDjeHRMPgc4', '余永康', '赵赵', 'https://wx.qlogo.cn/mmopen/vi_32/AvTOBqK5D0azFkS8BVibFucZyG9z9rLicQYL7FkBl6QicS6z4mdNejuvU4Qial8z9wOfInP4anVMAK7sAeoX5A1tOg/0', 18681520620, '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508852139, 1508852139, 1, 0, 0, 0, 0, '0.00', '', NULL),
(85, 0, 79151778, 'o83291Jxj27gv141vyY4NnrmWqg4', '2892997867', '刘芝杰', 'https://wx.qlogo.cn/mmopen/vi_32/fzlsHF32wWHFE46DsdCfe9WOXTDyicTib6M3xXdASDUFnA6v13Kpjicvr8b5OwAvem86G5ZMZicILicp036uwmFm7mA/0', 18938039629, '7bb9d1ef716fedda37743cf29f41ed92363f43d4', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1508856490, 1508856490, 1, 0, 0, 0, 0, '0.00', '', NULL),
(87, 0, 76368590, 'o83291GAv0SNsD3YmISgMiHOut0Q', '朱涛', 'Z纪媛', 'https://wx.qlogo.cn/mmhead/uchmtWQh7iaqm9z1QucKESYwDiasve3glVvHvDEEEvZmEBJrp26SDrcA/0', 13760460789, '3c9c84ce72513acfcdd517fb37b2af070e7ba8dc', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1509009233, 1509009233, 1, 0, 0, 0, 0, '0.00', '', NULL),
(88, 0, 19538741, 'o83291Hqgu7Kmgm99VtTlw0zyuzQ', 'FANGHUIYAN', '村长', 'https://wx.qlogo.cn/mmhead/bVy2VQVTWzbtVlldXFcWqic1ib9ZZa0fHvPloPhBgA6SCicFgUCfqnibWw/0', 13510313780, '2b4ba47d31d0c5b847342ede68ebbe692e04497a', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1509021512, 1509021512, 1, 0, 0, 0, 0, '0.00', '', NULL),
(89, 0, 19852856, 'o83291KnV3vkKun-bcmExl4nGa_s', 'Li hong', '晨曦', 'https://wx.qlogo.cn/mmhead/1gvL9ficRs1GIL0Fv2IASoiaGKt82wfWVElkLJ3xUOZ9JnvzsX6AA5NA/0', 13670280289, '6e81f48a18faf001101e2ededbd204f6ae2bac27', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1509024639, 1509024639, 1, 0, 0, 0, 0, '0.00', '', NULL),
(90, 0, 59828826, 'o83291KG_xNz0ywKXQiABwjmVGUk', 'lixiaofang', '一小凡人', 'https://wx.qlogo.cn/mmhead/Ib5852jAyb860z7fQb9L9kCSb5ZU8QicSwlB0MXFXJxAz3Bqib1iaGpsw/0', 13613097067, '4af0a2b6d5df8b2d2fde6d3dba885826d382522e', '', '', '', '', '', '', 1, '0.0', '0.0', '', '0.0', '0000-00-00', 1509062613, 1509062613, 1, 0, 0, 0, 0, '0.00', '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(240) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_system` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:系统消息:2训练营消息',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1未读|0过期|2已读'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`id`, `title`, `content`, `url`, `is_system`, `create_time`, `update_time`, `delete_time`, `status`) VALUES
(1, '课程大热幼儿班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091826474260<br /> 金额:0<br /> 商品信息:123预约体验大热幼儿班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/17', 2, 1507544809, 1507544809, NULL, 1),
(2, '课程超级控球手已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091830393947<br /> 金额:0<br /> 商品信息:123预约体验超级控球手', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/18', 2, 1507545041, 1507545041, NULL, 1),
(3, '订单支付成功通知', '用户名:小霖<br /> 订单编号:1201710101809377908<br /> 金额:10元<br /> 商品信息:小霖购买校园兴趣班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/19', 2, 1507630200, 1507630200, NULL, 1),
(4, '您好,您所发布的荣光场场地资源被选为平台公开场地', '您好,您所发布的荣光场场地资源被选为平台公开场地', 'https://m.hot-basketball.com/frontend/camp/courtlistofcamp/camp_id/5', 1, 1507718136, 0, NULL, 1),
(5, '您好,您所发布的阳光文体中心迷你场场地资源被选为平台公开场地', '您好,您所发布的阳光文体中心迷你场场地资源被选为平台公开场地', 'https://m.hot-basketball.com/frontend/camp/courtlistofcamp/camp_id/4', 1, 1507718142, 0, NULL, 1),
(6, '订单支付成功通知', '用户名:张晨儒<br /> 订单编号:1201710112133332733<br /> 金额:1500元<br /> 商品信息:张晨儒购买周日北头高年级初中班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/20', 2, 1507728831, 1507728831, NULL, 1),
(7, '体验课预约申请成功', '用户名:刘嘉<br /> 订单编号:1201710131538143724<br /> 金额:0元<br /> 商品信息:刘嘉预约体验超级控球手', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/21', 2, 1507880298, 1507880298, NULL, 1),
(8, '加入训练营申请', '会员 weilin666申请加入荣光训练营 成为 教练, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/5/status/0', 2, 1507890574, 0, NULL, 1),
(9, '体验课预约申请成功', '用户名:儿童劫<br /> 订单编号:1201710141011107532<br /> 金额:0元<br /> 商品信息:儿童劫预约体验荣光篮球强化', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/22', 2, 1507947074, 1507947074, NULL, 1),
(10, '加入训练营申请', '会员 weilin666申请加入荣光训练营 成为 教练, 请及时处理', '/frontend/camp/coachlistofcamp/camp_id/5/status/0/openid/o83291GqxP1FCqmfVncltkGVWPaY', 2, 1507948855, 0, NULL, 1),
(11, '加入训练营申请', '会员 weilin666申请加入荣光训练营 成为 教练, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/5/status/0/openid/o83291GqxP1FCqmfVncltkGVWPaY', 2, 1507948896, 0, NULL, 1),
(12, '加入训练营申请', '会员 Hot777申请加入齐天大热 成为 教练, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/3/status/0/openid/o83291IEM6JPXsCe5bIT_XRt2oes', 2, 1507972577, 0, NULL, 1),
(13, '加入训练营申请', '会员 HoChen申请加入热风学校 成为 管理员, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/16/status/0/openid/o83291I0HI28QoLyldPwvPnPExQQ', 2, 1508040916, 0, NULL, 1),
(14, '加入训练营申请', '会员 legend申请加入大热篮球俱乐部 成为 管理员, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 2, 1508055043, 0, NULL, 1),
(15, '订单支付成功通知', '用户名:123<br /> 订单编号:1201710151832555913<br /> 金额:10元<br /> 商品信息:123购买校园兴趣班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/23', 2, 1508063598, 1508063598, NULL, 1),
(16, '订单支付成功通知', '用户名:陈佳佑<br /> 订单编号:1201710171017193132<br /> 金额:1元<br /> 商品信息:陈佳佑购买超级射手班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/26', 2, 1508206651, 1508206651, NULL, 1),
(17, '订单支付成功通知', '用户名:陈佳佑<br /> 订单编号:1201710171027563375<br /> 金额:1元<br /> 商品信息:陈佳佑购买超级射手班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/27', 2, 1508207329, 1508207329, NULL, 1),
(18, '订单支付成功通知', '用户名:邓赖迪<br /> 订单编号:1201710172007052272<br /> 金额:1500元<br /> 商品信息:邓赖迪购买周六上午十点低年级班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/28', 2, 1508242057, 1508242057, NULL, 1),
(19, '体验课预约申请成功', '用户名:123<br /> 订单编号:1201710191424259051<br /> 金额:0元<br /> 商品信息:123预约体验校园兴趣班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/31', 2, 1508394269, 1508394269, NULL, 1),
(20, '退款申请-超级射手班', '订单号: 1201710171027563375<br/>退款金额: 1元<br/>退款理由:申请退款测试', '/frontend/bill/billinfoofcamp/id/29', 1, 1508409464, 1508409464, NULL, 1),
(22, '退款申请-超级射手班', '订单号: 1201710171027563375<br/>退款金额: 1元<br/>退款理由:申请退款测试', '/frontend/bill/billinfoofcamp/id/29', 1, 1508409464, 1508409464, NULL, 1),
(24, '退款申请-超级射手班', '订单号: 1201710171027563375<br/>退款金额: 1元<br/>退款理由:申请退款测试', '/frontend/bill/billinfoofcamp/id/29', 1, 1508409464, 1508409464, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `message_member`
--

CREATE TABLE `message_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(240) NOT NULL,
  `content` text NOT NULL,
  `member_id` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:未读|2:已读',
  `url` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `message_member`
--

INSERT INTO `message_member` (`id`, `title`, `content`, `member_id`, `status`, `url`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '您已购买了课程大热幼儿班', '用户名123\\n 订单编号1201710091632015853\\n 金额0\\n 商品信息123预约体验大热幼儿班\\n 订单编号', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/10', 1507538154, 1507538154, NULL),
(3, '您已购买了课程大热幼儿班', '用户名123\\n 订单编号1201710091632015853\\n 金额0\\n 商品信息123预约体验大热幼儿班\\n 订单编号', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/11', 1507539082, 1507539082, NULL),
(43, '订单支付成功-校园兴趣班', '订单号: 1201710191508357622<br/>支付金额: 0元<br/>支付学生信息:刘嘉', 5, 2, '/frontend/bill/billinfo/bill_id/38', 1508396926, 1508396926, NULL),
(42, '预约体验申请-猴塞雷课程', '订单号: 1201710191504423677<br/>支付金额: 0元<br/>申请学生:刘嘉<br/>申请理由: ', 1, 2, '/frontend/bill/billinfoofcamp/bill_id/37', 1508396686, 1508396686, NULL),
(5, '您已购买了课程超级射手班', '用户名:123<br /> 订单编号:1201710091655298358<br /> 金额:0<br />商品信息:123预约体验超级射手班<br />订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/12', 1507539335, 1507539335, NULL),
(6, '课程超级射手班已被申请体验,请及时处理', '用户名:123<br />订单编号:1201710091655298358<br />金额:0<br />商品信息:123预约体验超级射手班<br /> 订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/12', 1507539336, 1507539336, NULL),
(7, '课程超级射手班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091655298358<br /> 金额:0<br /> 商品信息:123预约体验超级射手班<br /> 订单编号:', 6, 2, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/12', 1507539336, 1507539336, NULL),
(8, '您已购买了课程周六上午十点低年级班', '用户名:123\\n 订单编号:1201710091659136879\\n 金额:0\\n 商品信息:123预约体验周六上午十点低年级班\\n 订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/13', 1507539555, 1507539555, NULL),
(9, '课程周六上午十点低年级班已被申请体验,请及时处理', '用户名:123\\n 订单编号:1201710091659136879\\n 金额:0\\n 商品信息:123预约体验周六上午十点低年级班\\n 订单编号:', 3, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/13', 1507539556, 1507539556, NULL),
(10, '课程周六上午十点低年级班已被申请体验,请及时处理', '用户名:123\\n 订单编号:1201710091659136879\\n 金额:0\\n 商品信息:123预约体验周六上午十点低年级班\\n 订单编号:', 1, 2, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/13', 1507539556, 1507539556, NULL),
(11, '您已购买了课程猴塞雷课程', '用户名:123<br /> 订单编号:1201710091720145464<br /> 金额:0<br /> 商品信息:123预约体验猴塞雷课程<br /> 订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/14', 1507540816, 1507540816, NULL),
(12, '课程猴塞雷课程已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091720145464<br /> 金额:0<br /> 商品信息:123预约体验猴塞雷课程<br /> 订单编号:', 1, 2, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/14', 1507540817, 1507540817, NULL),
(13, '您已购买了课程小学低年级初级班', '用户名:123<br /> 订单编号:1201710091741026501<br /> 金额:10<br /> 商品信息:123购买小学低年级初级班<br /> 订单编号:', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/15', 1507542080, 1507542080, NULL),
(14, '课程小学低年级初级班已被购买,请及时处理', '用户名:123<br /> 订单编号:1201710091741026501<br /> 金额:10<br /> 商品信息:123购买小学低年级初级班<br /> 订单编号:', 1, 2, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/15', 1507542080, 1507542080, NULL),
(15, '您已购买了课程超级射手班', '用户名:123<br /> 订单编号:1201710091825539450<br /> 金额:0<br /> 商品信息:123预约体验超级射手班', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/16', 1507544755, 1507544755, NULL),
(16, '课程超级射手班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091825539450<br /> 金额:0<br /> 商品信息:123预约体验超级射手班', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/16', 1507544756, 1507544756, NULL),
(17, '课程超级射手班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091825539450<br /> 金额:0<br /> 商品信息:123预约体验超级射手班', 6, 2, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/16', 1507544756, 1507544756, NULL),
(18, '您已购买了课程大热幼儿班', '用户名:123<br /> 订单编号:1201710091826474260<br /> 金额:0<br /> 商品信息:123预约体验大热幼儿班', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/17', 1507544809, 1507544809, NULL),
(19, '您已购买了课程超级控球手', '用户名:123<br /> 订单编号:1201710091830393947<br /> 金额:0<br /> 商品信息:123预约体验超级控球手', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/18', 1507545041, 1507545041, NULL),
(20, '发给嘉兴的测试信息', '发给嘉兴的测试信息发给嘉兴的测试信息发给嘉兴的测试信息发给嘉兴的测试信息发给嘉兴的测试信息发给嘉兴的测试信息', 5, 2, 'https://m.hot-basketball.com/frontend', 0, 0, NULL),
(21, '订单支付成功通知', '用户名:小霖<br /> 订单编号:1201710101809377908<br /> 金额:10元<br /> 商品信息:小霖购买校园兴趣班', 4, 2, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/19', 1507630199, 1507630199, NULL),
(22, '您好, 您所在的准行者训练营的教练身份被移除了', '您好, 您所在的准行者训练营的教练身份被移除了', 4, 2, 'https://m.hot-basketball.com/frontend/index/index', 1507709856, 1507709856, NULL),
(23, '订单支付成功通知', '用户名:张晨儒<br /> 订单编号:1201710112133332733<br /> 金额:1500元<br /> 商品信息:张晨儒购买周日北头高年级初中班', 15, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/20', 1507728830, 1507728830, NULL),
(24, '订单支付成功通知', '用户名:刘嘉<br /> 订单编号:1201710131538143724<br /> 金额:0元<br /> 商品信息:刘嘉预约体验超级控球手', 5, 2, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/21', 1507880297, 1507880297, NULL),
(25, '订单支付成功通知', '用户名:儿童劫<br /> 订单编号:1201710141011107532<br /> 金额:0元<br /> 商品信息:儿童劫预约体验荣光篮球强化', 10, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/22', 1507947073, 1507947073, NULL),
(26, '订单支付成功通知', '用户名:123<br /> 订单编号:1201710151832555913<br /> 金额:10元<br /> 商品信息:123购买校园兴趣班', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/23', 1508063597, 1508063597, NULL),
(27, '订单支付成功通知', '用户名:陈佳佑<br /> 订单编号:1201710171017193132<br /> 金额:1元<br /> 商品信息:陈佳佑购买超级射手班', 33, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/26', 1508206651, 1508206651, NULL),
(28, '订单支付成功通知', '用户名:陈佳佑<br /> 订单编号:1201710171027563375<br /> 金额:1元<br /> 商品信息:陈佳佑购买超级射手班', 33, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/27', 1508207328, 1508207328, NULL),
(29, '订单支付成功通知', '用户名:邓赖迪<br /> 订单编号:1201710172007052272<br /> 金额:1500元<br /> 商品信息:邓赖迪购买周六上午十点低年级班', 22, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/28', 1508242055, 1508242055, NULL),
(30, '订单支付成功通知', '用户名:123<br /> 订单编号:1201710191424259051<br /> 金额:0元<br /> 商品信息:123预约体验校园兴趣班', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/31', 1508394268, 1508394268, NULL),
(31, '订单支付成功-猴塞雷课程', '订单号: 1201710191449077302<br/>支付金额: 0元<br/>支付学生信息:123', 8, 1, '/frontend/bill/billinfo/bill_id/33', 1508395890, 1508395890, NULL),
(32, '订单支付成功-猴塞雷课程', '订单号: 1201710191449077302<br/>支付金额: 0元<br/>支付学生信息:123', 8, 1, '/frontend/bill/billinfo/bill_id/34', 1508395952, 1508395952, NULL),
(33, '预约体验申请-猴塞雷课程', '订单号: 1201710191449077302<br/>支付金额: 0元<br/>申请学生:123<br/>申请理由: ', 8, 1, '/frontend/bill/billinfoofcamp/bill_id/34', 1508395953, 1508395953, NULL),
(41, '订单支付成功-猴塞雷课程', '订单号: 1201710191504423677<br/>支付金额: 0元<br/>支付学生信息:刘嘉', 5, 2, '/frontend/bill/billinfo/bill_id/37', 1508396685, 1508396685, NULL),
(35, '订单支付成功-猴塞雷课程', '订单号: 1201710191456452612<br/>支付金额: 0元<br/>支付学生信息:123', 8, 1, '/frontend/bill/billinfo/bill_id/35', 1508396213, 1508396213, NULL),
(36, '预约体验申请-猴塞雷课程', '订单号: 1201710191456452612<br/>支付金额: 0元<br/>申请学生:123<br/>申请理由: ', 8, 1, '/frontend/bill/billinfoofcamp/id/35', 1508396214, 1508396214, NULL),
(38, '订单支付成功-猴塞雷课程', '订单号: 1201710191458454359<br/>支付金额: 0元<br/>支付学生信息:刘嘉', 5, 2, '/frontend/bill/billinfo/bill_id/36', 1508396331, 1508396331, NULL),
(39, '预约体验申请-猴塞雷课程', '订单号: 1201710191458454359<br/>支付金额: 0元<br/>申请学生:刘嘉<br/>申请理由: ', 5, 2, '/frontend/bill/billinfoofcamp/bill_id/36', 1508396332, 1508396332, NULL),
(44, '预约体验申请-校园兴趣班', '订单号: 1201710191508357622<br/>支付金额: 0元<br/>申请学生:刘嘉<br/>申请理由: ', 1, 2, '/frontend/bill/billinfoofcamp/bill_id/38', 1508396926, 1508396926, NULL),
(45, '加入训练营申请', '会员 weilin666申请加入准行者训练营 成为 管理员，请及时处理', 8, 1, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/4/status/0/openid/o83291CzkRqonKdTVSJLGhYoU98Q', 1508399193, 0, NULL),
(46, '加入训练营申请', '会员 weilin666申请加入准行者训练营 成为 管理员，请及时处理', 6, 2, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/4/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 1508399193, 0, NULL),
(47, '加入训练营申请结果', '您好，您申请加入准行者训练营 成为 管理员审核通过', 4, 2, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/4', 1508399257, 0, NULL),
(48, '超级射手班退款申请已被同意', '订单号: 1201710171027563375<br/>支付金额: 1元<br/>支付信息:陈佳佑', 6, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/29', 1508405088, 1508405088, NULL),
(49, '超级射手班退款申请已被同意', '订单号: 1201710171027563375<br/>支付金额: 1元<br/>支付信息:陈佳佑', 6, 1, 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/29', 1508409701, 1508409701, NULL),
(50, '加入训练营申请结果', '您好，您申请加入大热篮球俱乐部 成为 管理员审核通过', 3, 1, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 1508469023, 0, NULL),
(51, '加入训练营申请', '会员 Hot-basketball2申请加入钟声训练营 成为 管理员，请及时处理', 19, 2, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/15/status/0/openid/o83291FErHA03raoSlWaWQTtl1Jo', 1508469074, 0, NULL),
(52, '加入训练营申请结果', '您好，您申请加入钟声训练营 成为 管理员审核通过', 2, 1, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/15', 1508473826, 0, NULL),
(53, '订单支付成功-校园兴趣班', '订单号: 1201710201650501601<br/>支付金额: 10元<br/>支付学生信息:陈小准', 6, 1, '/frontend/bill/billinfo/bill_id/39', 1508489473, 1508489473, NULL),
(54, '购买课程-校园兴趣班', '订单号: 1201710201650501601<br/>支付金额: 10元<br/>购买学生:陈小准<br/>购买理由: 哥哥哥', 1, 2, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/39', 1508489474, 1508489474, NULL),
(55, '订单支付成功-校园兴趣班', '订单号: 1201710201655144883<br/>支付金额: 10元<br/>支付学生信息:陈小准', 6, 1, '/frontend/bill/billinfo/bill_id/40', 1508489735, 1508489735, NULL),
(56, '购买课程-校园兴趣班', '订单号: 1201710201655144883<br/>支付金额: 10元<br/>购买学生:陈小准<br/>购买理由: ', 1, 2, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/40', 1508489736, 1508489736, NULL),
(57, '订单支付成功-北大附小一年级', '订单号: 1201710211057457832<br/>支付金额: 1500元<br/>支付学生信息:陈润宏', 43, 1, '/frontend/bill/billinfo/bill_id/41', 1508554704, 1508554704, NULL),
(58, '购买课程-北大附小一年级', '订单号: 1201710211057457832<br/>支付金额: 1500元<br/>购买学生:陈润宏<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/41', 1508554705, 1508554705, NULL),
(59, '购买课程-北大附小一年级', '订单号: 1201710211057457832<br/>支付金额: 1500元<br/>购买学生:陈润宏<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/41', 1508554705, 1508554705, NULL),
(60, '订单支付成功-前海小学', '订单号: 1201710211059171400<br/>支付金额: 1500元<br/>支付学生信息:李润弘', 42, 2, '/frontend/bill/billinfo/bill_id/42', 1508554789, 1508554789, NULL),
(61, '购买课程-前海小学', '订单号: 1201710211059171400<br/>支付金额: 1500元<br/>购买学生:李润弘<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/42', 1508554790, 1508554790, NULL),
(62, '购买课程-前海小学', '订单号: 1201710211059171400<br/>支付金额: 1500元<br/>购买学生:李润弘<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/42', 1508554790, 1508554790, NULL),
(63, '荣光体验班最新课时', '您参加的荣光训练营-荣光篮球强化-荣光体验班班级 发布最新课时', 26, 1, 'https://m.hot-basketball.com/frontend/schedule/scheduleinfo/schedule_id/26/camp_id/5/openid/o83291DEQMrOGBcwXrbPisKaET1w', 1508577717, 0, NULL),
(64, '荣光体验班最新课时', '您参加的荣光训练营-荣光篮球强化-荣光体验班班级 发布最新课时', 10, 1, 'https://m.hot-basketball.com/frontend/schedule/scheduleinfo/schedule_id/26/camp_id/5/openid/o83291Ic0nyfFcuRrhsu2s4sBYxQ', 1508579132, 0, NULL),
(65, '订单支付成功-前海小学', '订单号: 1201710221039031877<br/>支付金额: 1500元<br/>支付学生信息:郑肖杰', 48, 1, '/frontend/bill/billinfo/bill_id/43', 1508639991, 1508639991, NULL),
(66, '购买课程-前海小学', '订单号: 1201710221039031877<br/>支付金额: 1500元<br/>购买学生:郑肖杰<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/43', 1508639992, 1508639992, NULL),
(67, '购买课程-前海小学', '订单号: 1201710221039031877<br/>支付金额: 1500元<br/>购买学生:郑肖杰<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/43', 1508639992, 1508639992, NULL),
(68, '订单支付成功-石厦学校兰球队', '订单号: 1201710221540485210<br/>支付金额: 1500元<br/>支付学生信息:黄浩', 49, 1, '/frontend/bill/billinfo/bill_id/44', 1508658059, 1508658059, NULL),
(69, '购买课程-石厦学校兰球队', '订单号: 1201710221540485210<br/>支付金额: 1500元<br/>购买学生:黄浩<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/44', 1508658061, 1508658061, NULL),
(70, '购买课程-石厦学校兰球队', '订单号: 1201710221540485210<br/>支付金额: 1500元<br/>购买学生:黄浩<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/44', 1508658061, 1508658061, NULL),
(71, '订单支付成功-石厦学校兰球队', '订单号: 1201710221644099327<br/>支付金额: 1500元<br/>支付学生信息:吴师隽', 52, 1, '/frontend/bill/billinfo/bill_id/45', 1508661866, 1508661866, NULL),
(72, '购买课程-石厦学校兰球队', '订单号: 1201710221644099327<br/>支付金额: 1500元<br/>购买学生:吴师隽<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/45', 1508661867, 1508661867, NULL),
(73, '购买课程-石厦学校兰球队', '订单号: 1201710221644099327<br/>支付金额: 1500元<br/>购买学生:吴师隽<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/45', 1508661867, 1508661867, NULL),
(74, '订单支付成功-前海小学', '订单号: 1201710222048182609<br/>支付金额: 1500元<br/>支付学生信息:唐轩衡', 55, 2, '/frontend/bill/billinfo/bill_id/46', 1508676522, 1508676522, NULL),
(75, '购买课程-前海小学', '订单号: 1201710222048182609<br/>支付金额: 1500元<br/>购买学生:唐轩衡<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/46', 1508676524, 1508676524, NULL),
(76, '购买课程-前海小学', '订单号: 1201710222048182609<br/>支付金额: 1500元<br/>购买学生:唐轩衡<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/46', 1508676524, 1508676524, NULL),
(77, '订单支付成功-前海小学', '订单号: 1201710230947598204<br/>支付金额: 1500元<br/>支付学生信息:郑皓畅', 56, 1, '/frontend/bill/billinfo/bill_id/47', 1508723297, 1508723297, NULL),
(78, '购买课程-前海小学', '订单号: 1201710230947598204<br/>支付金额: 1500元<br/>购买学生:郑皓畅<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/47', 1508723298, 1508723298, NULL),
(79, '购买课程-前海小学', '订单号: 1201710230947598204<br/>支付金额: 1500元<br/>购买学生:郑皓畅<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/47', 1508723298, 1508723298, NULL),
(80, '订单支付成功-前海小学', '订单号: 1201710230947417559<br/>支付金额: 1500元<br/>支付学生信息:陈高翔', 59, 1, '/frontend/bill/billinfo/bill_id/48', 1508723329, 1508723329, NULL),
(81, '购买课程-前海小学', '订单号: 1201710230947417559<br/>支付金额: 1500元<br/>购买学生:陈高翔<br/>购买理由: 前海小学陈高翔', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/48', 1508723330, 1508723330, NULL),
(82, '购买课程-前海小学', '订单号: 1201710230947417559<br/>支付金额: 1500元<br/>购买学生:陈高翔<br/>购买理由: 前海小学陈高翔', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/48', 1508723330, 1508723330, NULL),
(83, '订单支付成功-前海小学', '订单号: 1201710231009249234<br/>支付金额: 1500元<br/>支付学生信息:战奕名', 51, 2, '/frontend/bill/billinfo/bill_id/49', 1508724642, 1508724642, NULL),
(84, '购买课程-前海小学', '订单号: 1201710231009249234<br/>支付金额: 1500元<br/>购买学生:战奕名<br/>购买理由: 老学员组织参加十人团报，有送二课时，本次团有二名新人，饶宾，陈高翔', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/49', 1508724644, 1508724644, NULL),
(85, '购买课程-前海小学', '订单号: 1201710231009249234<br/>支付金额: 1500元<br/>购买学生:战奕名<br/>购买理由: 老学员组织参加十人团报，有送二课时，本次团有二名新人，饶宾，陈高翔', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/49', 1508724644, 1508724644, NULL),
(86, '订单支付成功-前海小学', '订单号: 1201710231029072550<br/>支付金额: 1500元<br/>支付学生信息:李语辰', 46, 1, '/frontend/bill/billinfo/bill_id/50', 1508725787, 1508725787, NULL),
(87, '购买课程-前海小学', '订单号: 1201710231029072550<br/>支付金额: 1500元<br/>购买学生:李语辰<br/>购买理由: 团购15送2', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/50', 1508725788, 1508725788, NULL),
(88, '购买课程-前海小学', '订单号: 1201710231029072550<br/>支付金额: 1500元<br/>购买学生:李语辰<br/>购买理由: 团购15送2', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/50', 1508725788, 1508725788, NULL),
(89, '订单支付成功-石厦学校兰球队', '订单号: 1201710231034138371<br/>支付金额: 1500元<br/>支付学生信息:张毓楠', 50, 1, '/frontend/bill/billinfo/bill_id/51', 1508726076, 1508726076, NULL),
(90, '购买课程-石厦学校兰球队', '订单号: 1201710231034138371<br/>支付金额: 1500元<br/>购买学生:张毓楠<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/51', 1508726077, 1508726077, NULL),
(91, '购买课程-石厦学校兰球队', '订单号: 1201710231034138371<br/>支付金额: 1500元<br/>购买学生:张毓楠<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/51', 1508726077, 1508726077, NULL),
(92, '订单支付成功-前海小学', '订单号: 1201710231034543967<br/>支付金额: 1500元<br/>支付学生信息:王钰龙', 60, 1, '/frontend/bill/billinfo/bill_id/52', 1508726144, 1508726144, NULL),
(93, '购买课程-前海小学', '订单号: 1201710231034543967<br/>支付金额: 1500元<br/>购买学生:王钰龙<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/52', 1508726145, 1508726145, NULL),
(94, '购买课程-前海小学', '订单号: 1201710231034543967<br/>支付金额: 1500元<br/>购买学生:王钰龙<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/52', 1508726145, 1508726145, NULL),
(95, '订单支付成功-前海小学', '订单号: 1201710231128422121<br/>支付金额: 1500元<br/>支付学生信息:刘宇恒', 62, 1, '/frontend/bill/billinfo/bill_id/53', 1508729343, 1508729343, NULL),
(96, '购买课程-前海小学', '订单号: 1201710231128422121<br/>支付金额: 1500元<br/>购买学生:刘宇恒<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/53', 1508729344, 1508729344, NULL),
(97, '购买课程-前海小学', '订单号: 1201710231128422121<br/>支付金额: 1500元<br/>购买学生:刘宇恒<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/53', 1508729344, 1508729344, NULL),
(98, '订单支付成功-北大附小一年级', '订单号: 1201710231147005486<br/>支付金额: 1500元<br/>支付学生信息:黄子诺', 63, 1, '/frontend/bill/billinfo/bill_id/54', 1508730453, 1508730453, NULL),
(99, '购买课程-北大附小一年级', '订单号: 1201710231147005486<br/>支付金额: 1500元<br/>购买学生:黄子诺<br/>购买理由: 赠送球，球服，一节课', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/54', 1508730455, 1508730455, NULL),
(100, '购买课程-北大附小一年级', '订单号: 1201710231147005486<br/>支付金额: 1500元<br/>购买学生:黄子诺<br/>购买理由: 赠送球，球服，一节课', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/54', 1508730455, 1508730455, NULL),
(101, '订单支付成功-北大附小一年级', '订单号: 1201710231219544391<br/>支付金额: 1500元<br/>支付学生信息:梁峻玮', 66, 1, '/frontend/bill/billinfo/bill_id/55', 1508732407, 1508732407, NULL),
(102, '购买课程-北大附小一年级', '订单号: 1201710231219544391<br/>支付金额: 1500元<br/>购买学生:梁峻玮<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/55', 1508732408, 1508732408, NULL),
(103, '购买课程-北大附小一年级', '订单号: 1201710231219544391<br/>支付金额: 1500元<br/>购买学生:梁峻玮<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/55', 1508732408, 1508732408, NULL),
(104, '订单支付成功-北大附小一年级', '订单号: 1201710231305331610<br/>支付金额: 1500元<br/>支付学生信息:刘一凡', 67, 1, '/frontend/bill/billinfo/bill_id/56', 1508735154, 1508735154, NULL),
(105, '购买课程-北大附小一年级', '订单号: 1201710231305331610<br/>支付金额: 1500元<br/>购买学生:刘一凡<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/56', 1508735155, 1508735155, NULL),
(106, '购买课程-北大附小一年级', '订单号: 1201710231305331610<br/>支付金额: 1500元<br/>购买学生:刘一凡<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/56', 1508735155, 1508735155, NULL),
(107, '订单支付成功-前海小学', '订单号: 120171023134850181<br/>支付金额: 1500元<br/>支付学生信息:万宇宸', 61, 1, '/frontend/bill/billinfo/bill_id/57', 1508737748, 1508737748, NULL),
(108, '购买课程-前海小学', '订单号: 120171023134850181<br/>支付金额: 1500元<br/>购买学生:万宇宸<br/>购买理由: ', 19, 2, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/57', 1508737749, 1508737749, NULL),
(109, '购买课程-前海小学', '订单号: 120171023134850181<br/>支付金额: 1500元<br/>购买学生:万宇宸<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/57', 1508737749, 1508737749, NULL),
(110, '订单支付成功-前海小学', '订单号: 1201710232142144641<br/>支付金额: 1500元<br/>支付学生信息:邱仁鹏', 73, 1, '/frontend/bill/billinfo/bill_id/58', 1508766196, 1508766196, NULL),
(111, '购买课程-前海小学', '订单号: 1201710232142144641<br/>支付金额: 1500元<br/>购买学生:邱仁鹏<br/>购买理由: 团购15节送2节', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/58', 1508766198, 1508766198, NULL),
(112, '购买课程-前海小学', '订单号: 1201710232142144641<br/>支付金额: 1500元<br/>购买学生:邱仁鹏<br/>购买理由: 团购15节送2节', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/58', 1508766198, 1508766198, NULL),
(113, '订单支付成功-北大附小一年级', '订单号: 1201710232145334074<br/>支付金额: 1500元<br/>支付学生信息:林需睦', 74, 1, '/frontend/bill/billinfo/bill_id/59', 1508766362, 1508766362, NULL),
(114, '购买课程-北大附小一年级', '订单号: 1201710232145334074<br/>支付金额: 1500元<br/>购买学生:林需睦<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/59', 1508766363, 1508766363, NULL),
(115, '购买课程-北大附小一年级', '订单号: 1201710232145334074<br/>支付金额: 1500元<br/>购买学生:林需睦<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/59', 1508766363, 1508766363, NULL),
(116, '订单支付成功-前海小学', '订单号: 120171023230255696<br/>支付金额: 1500元<br/>支付学生信息:饶滨', 58, 1, '/frontend/bill/billinfo/bill_id/60', 1508770993, 1508770993, NULL),
(117, '购买课程-前海小学', '订单号: 120171023230255696<br/>支付金额: 1500元<br/>购买学生:饶滨<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/60', 1508770994, 1508770994, NULL),
(118, '购买课程-前海小学', '订单号: 120171023230255696<br/>支付金额: 1500元<br/>购买学生:饶滨<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/60', 1508770994, 1508770994, NULL),
(119, '加入训练营申请', '会员 Hot-basketball2申请加入AKcross训练营 成为 管理员，请及时处理', 18, 1, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/13/status/0/openid/o83291A1ANguB2ziQFNuNZfVNqpY', 1508829676, 0, NULL),
(120, '加入训练营申请结果', '您好，您申请加入AKcross训练营 成为 管理员审核通过', 2, 1, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/13', 1508829727, 0, NULL),
(121, '订单支付成功-AKcross课程', '订单号: 1201710241550126737<br/>支付金额: 1500元<br/>支付学生信息:游逸朗', 79, 1, '/frontend/bill/billinfo/bill_id/61', 1508831426, 1508831426, NULL),
(122, '购买课程-AKcross课程', '订单号: 1201710241550126737<br/>支付金额: 1500元<br/>购买学生:游逸朗<br/>购买理由: ', 18, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/61', 1508831427, 1508831427, NULL),
(123, '购买课程-AKcross课程', '订单号: 1201710241550126737<br/>支付金额: 1500元<br/>购买学生:游逸朗<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/61', 1508831427, 1508831427, NULL),
(124, '加入训练营申请', '会员 张雅璐申请加入大热篮球俱乐部 成为 管理员，请及时处理', 6, 2, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 1508831833, 0, NULL),
(125, '加入训练营申请', '会员 张雅璐申请加入大热篮球俱乐部 成为 管理员，请及时处理', 3, 1, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0', 1508831834, 0, NULL),
(126, '加入训练营申请', '会员 张雅璐申请加入大热篮球俱乐部 成为 管理员，请及时处理', 2, 1, 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 1508831834, 0, NULL),
(127, '加入训练营申请结果', '您好，您申请加入大热篮球俱乐部 成为 管理员审核通过', 78, 1, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 1508831851, 0, NULL),
(128, '加入训练营申请', '会员 张雅璐申请加入大热前海训练营 成为 教练，请及时处理', 1, 2, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/2/status/0/openid/o83291IEM6JPXsCe5bIT_XRt2oes', 1508833047, 0, NULL),
(129, '加入训练营申请', '会员 张雅璐申请加入大热前海训练营 成为 教练，请及时处理', 3, 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/2/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0', 1508833048, 0, NULL),
(130, '加入训练营申请', '会员 钟声申请加入大热篮球俱乐部 成为 教练，请及时处理', 6, 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 1508849680, 0, NULL),
(131, '加入训练营申请', '会员 钟声申请加入大热篮球俱乐部 成为 教练，请及时处理', 3, 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0', 1508849681, 0, NULL),
(132, '加入训练营申请', '会员 钟声申请加入大热篮球俱乐部 成为 教练，请及时处理', 2, 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 1508849681, 0, NULL),
(133, '订单支付成功-高年级班', '订单号: 1201710242055046491<br/>支付金额: 1500元<br/>支付学生信息:陈宛杭', 80, 1, '/frontend/bill/billinfo/bill_id/62', 1508849731, 1508849731, NULL),
(134, '购买课程-高年级班', '订单号: 1201710242055046491<br/>支付金额: 1500元<br/>购买学生:陈宛杭<br/>购买理由: ', 6, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/62', 1508849732, 1508849732, NULL),
(135, '购买课程-高年级班', '订单号: 1201710242055046491<br/>支付金额: 1500元<br/>购买学生:陈宛杭<br/>购买理由: ', 3, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/62', 1508849732, 1508849732, NULL),
(136, '购买课程-高年级班', '订单号: 1201710242055046491<br/>支付金额: 1500元<br/>购买学生:陈宛杭<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/62', 1508849732, 1508849732, NULL),
(137, '订单支付成功-北大附小一年级', '订单号: 1201710242108262316<br/>支付金额: 1500元<br/>支付学生信息:邓粤天', 82, 1, '/frontend/bill/billinfo/bill_id/63', 1508850519, 1508850519, NULL),
(138, '购买课程-北大附小一年级', '订单号: 1201710242108262316<br/>支付金额: 1500元<br/>购买学生:邓粤天<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/63', 1508850520, 1508850520, NULL),
(139, '购买课程-北大附小一年级', '订单号: 1201710242108262316<br/>支付金额: 1500元<br/>购买学生:邓粤天<br/>购买理由: ', 2, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/63', 1508850520, 1508850520, NULL),
(140, '加入训练营申请结果', '您好，您申请加入大热篮球俱乐部 成为 教练审核通过', 19, 1, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 1508854111, 0, NULL),
(141, '您好, 您所在的钟声训练营的管理员身份被移除了', '您好, 您所在的钟声训练营的管理员身份被移除了', 2, 1, 'https://m.hot-basketball.com/frontend/index/index', 1508859525, 1508859525, NULL),
(142, '加入训练营申请', '会员 18566201712申请加入大热篮球俱乐部 成为 教练，请及时处理', 6, 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291E-y8PFoWJ4k0IRFArpN0p8', 1508917693, 0, NULL),
(143, '加入训练营申请', '会员 18566201712申请加入大热篮球俱乐部 成为 教练，请及时处理', 3, 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291PIWaWsfNat_XkflwCO5sX0', 1508917694, 0, NULL),
(144, '加入训练营申请', '会员 18566201712申请加入大热篮球俱乐部 成为 教练，请及时处理', 2, 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 1508917694, 0, NULL),
(145, '加入训练营申请结果', '您好，您申请加入大热篮球俱乐部 成为 教练审核通过', 18, 1, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 1508919857, 0, NULL),
(146, '加入训练营申请结果', '您好，您申请加入大热篮球俱乐部 成为 管理员审核通过', 78, 1, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/9', 1508923164, 0, NULL),
(147, '订单支付成功-荣光篮球强化', '订单号: 1201710261039114732<br/>支付金额: 1元<br/>支付学生信息:苏楠楠', 6, 1, '/frontend/bill/billinfo/bill_id/64', 1508985553, 1508985553, NULL),
(148, '购买课程-荣光篮球强化', '订单号: 1201710261039114732<br/>支付金额: 1元<br/>购买学生:苏楠楠<br/>购买理由: ', 7, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/64', 1508985553, 1508985553, NULL),
(149, '订单支付成功-荣光篮球强化', '订单号: 1201710261041275729<br/>支付金额: 1元<br/>支付学生信息:苏楠楠', 6, 1, '/frontend/bill/billinfo/bill_id/65', 1508985697, 1508985697, NULL),
(150, '购买课程-荣光篮球强化', '订单号: 1201710261041275729<br/>支付金额: 1元<br/>购买学生:苏楠楠<br/>购买理由: ', 7, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/65', 1508985698, 1508985698, NULL),
(151, '订单支付成功-北大附小一年级', '订单号: 1201710261052274244<br/>支付金额: 1500元<br/>支付学生信息:姚定希', 86, 1, '/frontend/bill/billinfo/bill_id/66', 1508986351, 1508986351, NULL),
(152, '购买课程-北大附小一年级', '订单号: 1201710261052274244<br/>支付金额: 1500元<br/>购买学生:姚定希<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/66', 1508986357, 1508986357, NULL),
(153, '订单支付成功-前海小学', '订单号: 1201710261056235265<br/>支付金额: 1500元<br/>支付学生信息:梁懿', 83, 1, '/frontend/bill/billinfo/bill_id/67', 1508986589, 1508986589, NULL),
(154, '购买课程-前海小学', '订单号: 1201710261056235265<br/>支付金额: 1500元<br/>购买学生:梁懿<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/67', 1508986589, 1508986589, NULL),
(155, '订单支付成功-荣光篮球强化', '订单号: 1201710261103254721<br/>支付金额: 1元<br/>支付学生信息:哈哈', 6, 1, '/frontend/bill/billinfo/bill_id/68', 1508987014, 1508987014, NULL),
(156, '购买课程-荣光篮球强化', '订单号: 1201710261103254721<br/>支付金额: 1元<br/>购买学生:哈哈<br/>购买理由: ', 7, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/68', 1508987015, 1508987015, NULL),
(157, '订单支付成功-石厦学校兰球队', '订单号: 1201710261147319808<br/>支付金额: 1500元<br/>支付学生信息:陈昊阳', 76, 1, '/frontend/bill/billinfo/bill_id/69', 1508989728, 1508989728, NULL),
(158, '购买课程-石厦学校兰球队', '订单号: 1201710261147319808<br/>支付金额: 1500元<br/>购买学生:陈昊阳<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/69', 1508989728, 1508989728, NULL),
(159, '订单支付成功-荣光篮球强化', '订单号: 1201710261237283787<br/>支付金额: 1元<br/>支付学生信息:小woo', 8, 1, '/frontend/bill/billinfo/bill_id/70', 1508992654, 1508992654, NULL),
(160, '购买课程-荣光篮球强化', '订单号: 1201710261237283787<br/>支付金额: 1元<br/>购买学生:小woo<br/>购买理由: ', 7, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/70', 1508992655, 1508992655, NULL),
(161, '订单支付成功-北大附小一年级', '订单号: 1201710261512286932<br/>支付金额: 1500元<br/>支付学生信息:周子杰', 81, 1, '/frontend/bill/billinfo/bill_id/71', 1509001966, 1509001966, NULL),
(162, '购买课程-北大附小一年级', '订单号: 1201710261512286932<br/>支付金额: 1500元<br/>购买学生:周子杰<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/71', 1509001967, 1509001967, NULL),
(163, '订单支付成功-松坪小学', '订单号: 1201710261623183711<br/>支付金额: 1500元<br/>支付学生信息:余永康', 84, 1, '/frontend/bill/billinfo/bill_id/72', 1509006276, 1509006276, NULL),
(164, '购买课程-松坪小学', '订单号: 1201710261623183711<br/>支付金额: 1500元<br/>购买学生:余永康<br/>购买理由: 预交篮球15节课费用', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/72', 1509006277, 1509006277, NULL),
(165, '加入训练营申请', '会员 Gavin.zhuang申请加入钟声训练营 成为 教练，请及时处理', 19, 1, 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/15/status/0/openid/o83291FErHA03raoSlWaWQTtl1Jo', 1509007514, 0, NULL),
(166, '加入训练营申请结果', '您好，您申请加入钟声训练营 成为 教练审核通过', 36, 1, 'https://m.hot-basketball.com/frontend/camp/powercamp/camp_id/15', 1509007969, 0, NULL),
(167, '订单支付成功-松坪小学', '订单号: 1201710261656532143<br/>支付金额: 1500元<br/>支付学生信息:饶宏宇', 39, 1, '/frontend/bill/billinfo/bill_id/73', 1509008230, 1509008230, NULL),
(168, '购买课程-松坪小学', '订单号: 1201710261656532143<br/>支付金额: 1500元<br/>购买学生:饶宏宇<br/>购买理由: ', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/73', 1509008231, 1509008231, NULL),
(169, '订单支付成功-松坪小学', '订单号: 1201710261715415806<br/>支付金额: 1500元<br/>支付学生信息:朱涛', 87, 1, '/frontend/bill/billinfo/bill_id/74', 1509009392, 1509009392, NULL),
(170, '购买课程-松坪小学', '订单号: 1201710261715415806<br/>支付金额: 1500元<br/>购买学生:朱涛<br/>购买理由: 朱涛购买篮球费用', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/74', 1509009392, 1509009392, NULL),
(171, '购买课程-北大附小一年级', '订单号: 1201710231510000000<br/>支付金额: 1500元<br/>购买学生:蒋清奕<br/>购买理由: 系统补发', 8, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75', 1509074938, 1509074938, NULL),
(172, '购买课程-北大附小一年级', '订单号: 1201710231510000000<br/>支付金额: 1500元<br/>购买学生:蒋清奕<br/>购买理由: 系统补发', 6, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75', 1509074938, 1509074938, NULL),
(173, '购买课程-北大附小一年级', '订单号: 1201710231510000000<br/>支付金额: 1500元<br/>购买学生:蒋清奕<br/>购买理由: 系统补发', 4, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75', 1509074938, 1509074938, NULL),
(174, '购买课程-北大附小一年级', '订单号: 1201710231510000000<br/>支付金额: 1500元<br/>购买学生:蒋清奕<br/>购买理由: 系统补发', 1, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75', 1509074938, 1509074938, NULL),
(175, '购买课程-北大附小一年级', '订单号: 1201710231510000000<br/>支付金额: 1500元<br/>购买学生:蒋清奕<br/>购买理由: 系统补发', 19, 1, 'https://m.hot-basketball.com/frontend/bill/billinfoofcamp/bill_id/75', 1509074973, 1509074973, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `message_read`
--

CREATE TABLE `message_read` (
  `id` int(10) UNSIGNED NOT NULL,
  `message_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'message表id',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '接收广播的会员id',
  `isread` int(11) NOT NULL DEFAULT '1' COMMENT '是否已读:1未读|2已读',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统广播-会员阅读关联';

--
-- 转存表中的数据 `message_read`
--

INSERT INTO `message_read` (`id`, `message_id`, `member_id`, `isread`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 3, 4, 2, 1508476102, 1508476331, NULL),
(2, 15, 6, 2, 1508476963, 1508477240, NULL),
(3, 19, 6, 2, 1508479571, NULL, NULL),
(4, 24, 5, 2, 1508815227, NULL, NULL),
(5, 22, 5, 2, 1508815228, NULL, NULL),
(6, 20, 5, 2, 1508815229, NULL, NULL),
(7, 19, 5, 2, 1508815231, NULL, NULL),
(8, 18, 5, 2, 1508815232, NULL, NULL),
(9, 17, 5, 2, 1508815234, NULL, NULL),
(10, 16, 5, 2, 1508815237, NULL, NULL),
(11, 15, 5, 2, 1508815238, NULL, NULL),
(12, 14, 5, 2, 1508815240, NULL, NULL),
(13, 3, 5, 2, 1508815243, NULL, NULL),
(14, 4, 5, 2, 1508815244, NULL, NULL),
(15, 5, 5, 2, 1508815249, NULL, NULL),
(16, 6, 5, 2, 1508815250, NULL, NULL),
(17, 7, 5, 2, 1508815251, NULL, NULL),
(18, 8, 5, 2, 1508815251, NULL, NULL),
(19, 9, 5, 2, 1508815253, NULL, NULL),
(20, 13, 5, 2, 1508815266, NULL, NULL),
(21, 24, 4, 2, 1508815308, NULL, NULL),
(22, 24, 6, 2, 1508815315, NULL, NULL),
(23, 12, 5, 2, 1508815321, NULL, NULL),
(24, 11, 5, 2, 1508815335, NULL, NULL),
(25, 1, 6, 2, 1508815358, NULL, NULL),
(26, 24, 78, 2, 1508829948, NULL, NULL),
(27, 10, 5, 2, 1508849243, NULL, NULL),
(28, 13, 1, 2, 1508913086, NULL, NULL),
(29, 14, 1, 2, 1508913087, NULL, NULL),
(30, 15, 1, 2, 1508913091, NULL, NULL),
(31, 16, 1, 2, 1508913092, NULL, NULL),
(32, 17, 1, 2, 1508913093, NULL, NULL),
(33, 18, 1, 2, 1508913097, NULL, NULL),
(34, 19, 1, 2, 1508913098, NULL, NULL),
(35, 20, 1, 2, 1508913100, NULL, NULL),
(36, 22, 1, 2, 1508913101, NULL, NULL),
(37, 24, 1, 2, 1508913106, NULL, NULL),
(38, 2, 5, 2, 1508941727, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `pay`
--

CREATE TABLE `pay` (
  `id` int(10) UNSIGNED NOT NULL,
  `member` varchar(60) NOT NULL,
  `member_id` int(10) NOT NULL,
  `pay_type` varchar(60) NOT NULL DEFAULT '微信支付' COMMENT '支付方式',
  `money` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `callback_str` text NOT NULL COMMENT '支付回调',
  `remarks` varchar(240) NOT NULL COMMENT '备注',
  `create_time` int(10) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值记录';

-- --------------------------------------------------------

--
-- 表的结构 `plan`
--

CREATE TABLE `plan` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `sys_remarks` varchar(255) NOT NULL COMMENT '系统备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `rebate`
--

CREATE TABLE `rebate` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收入提成';

-- --------------------------------------------------------

--
-- 表的结构 `rebate_hp`
--

CREATE TABLE `rebate_hp` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `update_time` int(11) NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='HP业绩返利';

-- --------------------------------------------------------

--
-- 表的结构 `rebate_score`
--

CREATE TABLE `rebate_score` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `update_time` int(11) NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分返利';

-- --------------------------------------------------------

--
-- 表的结构 `salary_in`
--

CREATE TABLE `salary_in` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统发放教练佣金';

-- --------------------------------------------------------

--
-- 表的结构 `salary_out`
--

CREATE TABLE `salary_out` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金提现申请';

-- --------------------------------------------------------

--
-- 表的结构 `schedule`
--

CREATE TABLE `schedule` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `leader_id` int(11) DEFAULT NULL COMMENT '对应member表,领队id',
  `leader` varchar(60) DEFAULT NULL COMMENT '领队',
  `coach` varchar(60) NOT NULL COMMENT '教练',
  `coach_id` int(10) NOT NULL COMMENT 'member表id',
  `students` int(10) NOT NULL COMMENT '上课学生总数',
  `student_str` text NOT NULL COMMENT '序列化学生名字集合',
  `assistant_id` varchar(255) NOT NULL COMMENT '序列化',
  `assistant` varchar(255) NOT NULL COMMENT '助教,序列化',
  `coach_salary` decimal(8,2) NOT NULL,
  `assistant_salary` decimal(8,2) NOT NULL,
  `salary_base` decimal(8,2) NOT NULL,
  `leave_ids` varchar(255) NOT NULL COMMENT 'ids',
  `leave` varchar(255) NOT NULL DEFAULT '0' COMMENT '请假人员总数',
  `plan_id` int(10) NOT NULL COMMENT 'id',
  `plan` varchar(255) NOT NULL COMMENT '教案',
  `exercise` varchar(255) NOT NULL,
  `lesson_time` int(10) NOT NULL COMMENT '上课时间,2017-10-12 18:53:16的时间戳',
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
  `update_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `schedule`
--

INSERT INTO `schedule` (`id`, `camp_id`, `camp`, `lesson`, `lesson_id`, `grade`, `grade_id`, `grade_category_id`, `grade_category`, `teacher`, `teacher_id`, `leader_id`, `leader`, `coach`, `coach_id`, `students`, `student_str`, `assistant_id`, `assistant`, `coach_salary`, `assistant_salary`, `salary_base`, `leave_ids`, `leave`, `plan_id`, `plan`, `exercise`, `lesson_time`, `cover`, `province`, `city`, `area`, `court_id`, `court`, `location`, `rent`, `star`, `remarks`, `media_ids`, `media_urls`, `status`, `create_time`, `delete_time`, `update_time`) VALUES
(1, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 0, '', '陈侯', 0, NULL, NULL, '123abc', 5, 0, '请添加学员', '', 'weilin666', '0.00', '0.00', '0.00', '', '0', 0, '', '', 17, '/uploads/images/cert/2017/10/59d2320379719.JPG', '', '', '', 0, '大热前海训练中心', '', '50.00', '20.0', '', '', '', 0, 1506522222, NULL, NULL),
(26, 5, '荣光训练营', '荣光篮球强化', 25, '荣光体验班', 8, 35, '体验班（4-18岁）', '张伟荣', 6, 6, '张伟荣', '张伟荣', 6, 1, 'a:1:{i:0;a:2:{s:10:\"student_id\";s:1:\"7\";s:7:\"student\";s:9:\"儿童劫\";}}', 'a:1:{i:0;s:1:\"1\";}', 'a:1:{i:0;s:9:\"刘伟霖\";}', '100.00', '80.00', '0.00', '', '0', 0, '', '', 1508573940, '', '广东省', '深圳市', '南山区', 0, '荣光训练场', '', '0.00', '20.0', '测试，没有哦', '', '', 1, 1508574204, NULL, 1508579131),
(18, 3, '齐天大热', '小学低年级初级班', 2, '最齐天大热', 21, 0, '', '刘伟霖', 0, NULL, NULL, '刘嘉兴', 5, 0, '', '', '', '0.00', '0.00', '0.00', '', '0', 0, '', '', 14, '/uploads\\images\\cert\\2017\\10/59df0803dd313.jpg', '', '', '', 0, '', '', '0.00', '20.0', '无', '', '', 0, 1506579638, NULL, NULL),
(19, 3, '齐天大热', '小学低年级初级班', 2, '最齐天大热', 21, 0, '', '（选填）', 0, NULL, NULL, '刘伟霖', 4, 0, '', '', '', '0.00', '0.00', '0.00', '', '0', 0, '', '', 11, '', '', '', '', 0, '', '', '0.00', '20.0', '无', '', '', 0, 1506579999, NULL, NULL),
(20, 3, '齐天大热', '小学低年级初级班', 2, '最齐天大热', 21, 0, '', '刘伟霖', 0, NULL, NULL, '陈侯', 1, 0, '', '', '', '0.00', '0.00', '0.00', '', '0', 0, '', '', 11, '', '', '', '', 0, '', '', '0.00', '20.0', '0000', '', '', 0, 1507791401, NULL, NULL),
(21, 4, '准行者训练营', '超级控球手', 3, '测试班', 4, 0, '', '', 0, NULL, NULL, '陈准', 6, 0, '', '', '', '0.00', '0.00', '0.00', '', '0', 0, '', '', 20, '/uploads/images/cert/2017/10/59df5e3b2129d.JPG', '', '', '', 0, '阳光迷你场', '', '0.00', '20.0', '测试一下', '', '', 0, 1507810905, NULL, NULL),
(22, 5, '荣光训练营', '荣光篮球强化', 25, '荣光体验班', 8, 35, '体验班（4-18岁）', '张伟荣', 6, 6, '张伟荣', '张伟荣', 6, 1, 'a:1:{i:0;a:2:{s:10:\"student_id\";s:2:\"14\";s:7:\"student\";s:9:\"儿童劫\";}}', 'a:1:{i:0;s:1:\"6\";}', 'a:1:{i:0;s:9:\"张伟荣\";}', '100.00', '80.00', '0.00', '', '0', 0, '', '', 1507601400, '/uploads/images/cert/2017/10/59e626c4e8c6f.jpg', '广东省', '深圳市', '南山区', 0, '荣光训练场', '', '0.00', '20.0', '测试，没有哦', '', '', 0, 1508255452, NULL, 1508255452),
(23, 5, '荣光训练营', '荣光篮球强化', 25, '荣光体验班', 23, 35, '体验班（4-18岁）', '张伟荣', 6, 6, '张伟荣', '张伟荣', 6, 1, 'a:1:{i:0;a:2:{s:10:\"student_id\";s:2:\"14\";s:7:\"student\";s:9:\"儿童劫\";}}', 'a:1:{i:0;s:1:\"1\";}', 'a:1:{i:0;s:9:\"刘伟霖\";}', '100.00', '80.00', '0.00', '', '0', 0, '', '', 1349835000, '', '广东省', '深圳市', '南山区', 0, '荣光训练场', '', '0.00', '20.0', '测试，没有哦', '', '', 0, 1508323980, NULL, 1508679627),
(27, 5, '荣光训练营', '荣光篮球强化', 25, '荣光体验班', 27, 35, '体验班（4-18岁）', '张伟荣', 6, 6, '张伟荣', '张伟荣', 6, 1, 'a:1:{i:0;a:2:{s:7:\"student\";s:9:\"儿童劫\";s:10:\"student_id\";s:1:\"7\";}}', 'a:1:{i:0;s:1:\"1\";}', 'a:1:{i:0;s:9:\"刘伟霖\";}', '100.00', '80.00', '0.00', '', '0', 0, '', '', 1508742300, '/uploads/images/cert/2017/10/59ed9593acccd.jpg', '广东省', '深圳市', '南山区', 0, '荣光训练场', '', '0.00', '20.0', '测试，没有哦', '', '', 0, 1508742569, NULL, 1508742582),
(24, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 5, '幼儿兴趣班（4-6岁）', '陈侯', 1, 1, '陈侯', '陈侯', 3, 1, 'a:1:{i:0;a:2:{s:10:\"student_id\";s:1:\"8\";s:7:\"student\";s:3:\"123\";}}', '', '', '23.00', '0.00', '0.00', '', '0', 0, '', '', 1508399760, '/uploads/images/cert/2017/10/59e97462d7d3b.jpeg', '广东省', '深圳市', '南山区', 2, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 1508472023, NULL, 1508472023),
(25, 3, '齐天大热', '小学低年级初级班', 2, '陈班豆丁', 2, 5, '幼儿兴趣班（4-6岁）', '陈侯', 1, 1, '陈侯', '刘伟霖', 1, 1, 'a:1:{i:0;a:2:{s:10:\"student_id\";s:1:\"8\";s:7:\"student\";s:3:\"123\";}}', '', '', '100.00', '0.00', '0.00', '', '0', 0, '', '', 1508472120, '/uploads/images/cert/2017/10/59e975a986a03.jpeg', '广东省', '深圳市', '南山区', 2, '大热前海训练中心', '', '0.00', '20.0', '', '', '', 0, 1508472396, NULL, 1508472396);

-- --------------------------------------------------------

--
-- 表的结构 `schedule_comment`
--

CREATE TABLE `schedule_comment` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `schedule_media`
--

CREATE TABLE `schedule_media` (
  `id` int(10) UNSIGNED NOT NULL,
  `schedule_id` int(10) NOT NULL COMMENT '对应student_id或者coach_id或者班主任id',
  `schedule` varchar(240) NOT NULL,
  `url` varchar(255) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `schedule_member`
--

CREATE TABLE `schedule_member` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `update_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课时-会员关系';

--
-- 转存表中的数据 `schedule_member`
--

INSERT INTO `schedule_member` (`id`, `schedule_id`, `schedule`, `camp_id`, `camp`, `user_id`, `user`, `type`, `status`, `schedule_time`, `create_time`, `delete_time`, `update_time`) VALUES
(10, 26, '荣光体验班', 5, '荣光训练营', 7, '儿童劫', 1, 1, 1508573940, 1508579131, NULL, 1508579131),
(11, 26, '荣光体验班', 5, '荣光训练营', 6, '张伟荣', 2, 1, 1508573940, 1508579131, NULL, 1508579131),
(12, 26, '荣光体验班', 5, '荣光训练营', 1, '刘伟霖', 2, 1, 1508573940, 1508579131, NULL, 1508579131);

-- --------------------------------------------------------

--
-- 表的结构 `score`
--

CREATE TABLE `score` (
  `id` int(10) UNSIGNED NOT NULL,
  `score` int(10) NOT NULL,
  `score_des` varchar(240) NOT NULL COMMENT '积分说明:订单积分|活动积分|xxx赠送积分',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分记录表';

-- --------------------------------------------------------

--
-- 表的结构 `sells`
--

CREATE TABLE `sells` (
  `id` int(10) UNSIGNED NOT NULL,
  `salary` decimal(8,2) NOT NULL,
  `score` int(10) NOT NULL,
  `goods_id` int(10) NOT NULL,
  `goods` varchar(255) NOT NULL,
  `goods_quantity` int(10) NOT NULL COMMENT '商品数量',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品销售分红收入';

-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE `setting` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `starrebate` decimal(6,2) NOT NULL DEFAULT '0.25' COMMENT '评价分扣减比例,评分满分得到全部佣金0.25,评分满分为100分'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `setting`
--

INSERT INTO `setting` (`id`, `sitename`, `memberlevel1`, `memberlevel2`, `memberlevel3`, `coachlevel1`, `coachlevel2`, `coachlevel3`, `coachlevel4`, `coachlevel5`, `coachlevel6`, `coachlevel7`, `coachlevel8`, `keywords`, `description`, `footer`, `title`, `wxappid`, `wxsecret`, `logo`, `banner`, `lrss`, `lrcs`, `status`, `coachlevel1award`, `coachlevel2award`, `rebate`, `sysrebate`, `rebate2`, `starrebate`) VALUES
(1, '大热篮球管家', 10, 30, 50, 50, 100, 150, 0, 0, 0, 0, 0, '大热篮球管家', '大热篮球管家', '© 2017 1Zstudio. All Rights Reserved.', '大热篮球管家', '', '', '/static/default/logo.jpg', 'a:3:{i:0;s:28:\"/uploads/images/banner/1.jpg\";i:1;s:28:\"/uploads/images/banner/2.jpg\";i:2;s:28:\"/uploads/images/banner/3.jpg\";}', 50, 100, 1, 500, 1000, '0.05', '0.30', '0.03', '0.20');

-- --------------------------------------------------------

--
-- 表的结构 `smsverify`
--

CREATE TABLE `smsverify` (
  `id` int(10) UNSIGNED NOT NULL,
  `phone` bigint(11) NOT NULL COMMENT '手机号码',
  `smscode` int(10) NOT NULL COMMENT '短信验证码',
  `content` text COMMENT '短信内容',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `use` varchar(50) DEFAULT NULL COMMENT '验证码使用场景,存中文',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态:0未使用|1已使用|2已失效'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发送短信';

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
(46, 13828880254, 152169, '{\"code\":152169,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507355122, '会员注册', 1),
(47, 18124663652, 961082, '{\"code\":961082,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507628251, '会员注册', 0),
(48, 15018514302, 656658, '{\"code\":656658,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507628353, '会员注册', 0),
(49, 18124663652, 910524, '{\"code\":910524,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507628394, '会员注册', 0),
(50, 13480839509, 954594, '{\"code\":954594,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507707365, '会员注册', 1),
(51, 13537781797, 216000, '{\"code\":216000,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507708903, '会员注册', 1),
(52, 13537781797, 775054, '{\"code\":775054,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507713031, '会员注册', 1),
(53, 13717147667, 140905, '{\"code\":140905,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507782131, '会员注册', 1),
(54, 13172659677, 990908, '{\"code\":990908,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507782712, '会员注册', 1),
(55, 18566201712, 853604, '{\"code\":853604,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507784631, '会员注册', 1),
(56, 15999557852, 159969, '{\"code\":159969,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507801724, '会员注册', 1),
(57, 13602582272, 749630, '{\"code\":749630,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507883563, '会员注册', 1),
(58, 13692692153, 785773, '{\"code\":785773,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507950445, '会员注册', 1),
(59, 13537819321, 917744, '{\"code\":917744,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507950574, '会员注册', 1),
(60, 13699816180, 480313, '{\"code\":480313,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507951536, '会员注册', 1),
(61, 17727573721, 259053, '{\"code\":259053,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507960903, '会员注册', 1),
(62, 13924641692, 969677, '{\"code\":969677,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507968223, '会员注册', 1),
(63, 13570811474, 988382, '{\"code\":988382,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1507975709, '会员注册', 1),
(64, 15999557852, 866501, '{\"code\":866501,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508035963, '训练营注册', 0),
(65, 15999557852, 832382, '{\"code\":832382,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508036029, '训练营注册', 0),
(66, 15999557852, 124874, '{\"code\":124874,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508036098, '训练营注册', 0),
(67, 15999557852, 666493, '{\"code\":666493,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508036164, '训练营注册', 0),
(68, 15999557852, 250291, '{\"code\":250291,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508036235, '训练营注册', 0),
(69, 15999557852, 100050, '{\"code\":100050,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508036348, '训练营注册', 0),
(70, 15999557852, 204102, '{\"code\":204102,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508036525, '训练营注册', 0),
(71, 15999557852, 211103, '{\"code\":211103,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508036728, '训练营注册', 0),
(72, 15999557852, 770915, '{\"code\":770915,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508036770, '训练营注册', 0),
(73, 15999557852, 717082, '{\"code\":717082,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508037023, '训练营注册', 1),
(74, 18126211925, 967294, '{\"code\":967294,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508037316, '训练营注册', 1),
(75, 13760379341, 942255, '{\"code\":942255,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508051162, '会员注册', 1),
(76, 13480839509, 724240, '{\"code\":724240,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508052546, '会员注册', 1),
(77, 13480839509, 871670, '{\"code\":871670,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508052620, '会员注册', 1),
(78, 13632649700, 864782, '{\"code\":864782,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508054217, '会员注册', 1),
(79, 13632649700, 662279, '{\"code\":662279,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508129805, '会员注册', 1),
(80, 13902925499, 754229, '{\"code\":754229,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508155723, '会员注册', 0),
(81, 13632649700, 797040, '{\"code\":797040,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508157266, '会员注册', 1),
(82, 13632649700, 543665, '{\"code\":543665,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508202195, '会员注册', 1),
(83, 13632567039, 625966, '{\"code\":625966,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508244304, '会员注册', 1),
(84, 13510075181, 619602, '{\"code\":619602,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508305516, '会员注册', 1),
(85, 18576475234, 613032, '{\"code\":613032,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508383304, '会员注册', 1),
(86, 13927440305, 453333, '{\"code\":453333,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508389095, '会员注册', 1),
(87, 13632747197, 174614, '{\"code\":174614,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508389120, '会员注册', 1),
(88, 13640904690, 765469, '{\"code\":765469,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508389265, '会员注册', 1),
(89, 13322928764, 280517, '{\"code\":280517,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508391116, '会员注册', 1),
(90, 13590492401, 706237, '{\"code\":706237,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508402595, '会员注册', 0),
(91, 13590492401, 237458, '{\"code\":237458,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508403068, '会员注册', 0),
(92, 13590492401, 529159, '{\"code\":529159,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508416038, '会员注册', 1),
(93, 13510074790, 433300, '{\"code\":433300,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508554458, '会员注册', 1),
(94, 13713999790, 501619, '{\"code\":501619,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508554528, '会员注册', 1),
(95, 13509682395, 411224, '{\"code\":411224,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508554820, '会员注册', 1),
(96, 13682450510, 165145, '{\"code\":165145,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508554959, '会员注册', 1),
(97, 15622835386, 227620, '{\"code\":227620,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508567896, '会员注册', 1),
(98, 15889703813, 276867, '{\"code\":276867,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508570475, '会员注册', 1),
(99, 13925297472, 331787, '{\"code\":331787,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508639802, '会员注册', 1),
(100, 15999691100, 260153, '{\"code\":260153,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508657993, '会员注册', 1),
(101, 13928447499, 209531, '{\"code\":209531,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508659564, '会员注册', 1),
(102, 15818553993, 609941, '{\"code\":609941,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508661081, '会员注册', 1),
(103, 13670002176, 377807, '{\"code\":377807,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508661780, '会员注册', 1),
(104, 13537699951, 733039, '{\"code\":733039,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508661791, '会员注册', 1),
(105, 13530306808, 308266, '{\"code\":308266,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508663445, '会员注册', 1),
(106, 13530306808, 249060, '{\"code\":249060,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508669648, '会员注册', 1),
(107, 13537699951, 844253, '{\"code\":844253,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508674598, '会员注册', 1),
(108, 15818553993, 827524, '{\"code\":827524,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508675776, '会员注册', 1),
(109, 13538289022, 152715, '{\"code\":152715,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508676284, '会员注册', 1),
(110, 13556389955, 997779, '{\"code\":997779,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508676383, '会员注册', 1),
(111, 13927478108, 109707, '{\"code\":109707,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508677780, '会员注册', 1),
(112, 13113013889, 237191, '{\"code\":237191,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508687827, '会员注册', 1),
(113, 18603038806, 432104, '{\"code\":432104,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508689120, '会员注册', 1),
(114, 13723758658, 529798, '{\"code\":529798,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508724226, '会员注册', 1),
(115, 13928447499, 329786, '{\"code\":329786,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508725778, '会员注册', 1),
(116, 13714718628, 468286, '{\"code\":468286,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508725950, '会员注册', 1),
(117, 13602581364, 280986, '{\"code\":280986,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508729207, '会员注册', 1),
(118, 13826554640, 810880, '{\"code\":810880,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508729562, '会员注册', 1),
(119, 13510633766, 471129, '{\"code\":471129,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508730596, '会员注册', 1),
(120, 13632598336, 211401, '{\"code\":211401,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508730680, '会员注册', 1),
(121, 13510633766, 704938, '{\"code\":704938,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508730736, '会员注册', 1),
(122, 13928438541, 254265, '{\"code\":254265,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508732329, '会员注册', 1),
(123, 13501570069, 321046, '{\"code\":321046,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508735037, '会员注册', 1),
(124, 18319019560, 856222, '{\"code\":856222,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508736251, '会员注册', 1),
(125, 13537699951, 682620, '{\"code\":682620,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508736465, '会员注册', 1),
(126, 13927482132, 914585, '{\"code\":914585,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508740945, '会员注册', 1),
(127, 13632598336, 626739, '{\"code\":626739,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508741204, '会员注册', 1),
(128, 15817261835, 473955, '{\"code\":473955,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508741552, '会员注册', 1),
(129, 13985047399, 730105, '{\"code\":730105,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508751987, '会员注册', 1),
(130, 13985047399, 308652, '{\"code\":308652,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508755887, '会员注册', 1),
(131, 13985047399, 376395, '{\"code\":376395,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508756505, '会员注册', 1),
(132, 13927482132, 412351, '{\"code\":412351,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508765272, '会员注册', 1),
(133, 18620306265, 896256, '{\"code\":896256,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508765309, '会员注册', 1),
(134, 13927482132, 606518, '{\"code\":606518,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508765491, '会员注册', 1),
(135, 13928451722, 895833, '{\"code\":895833,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508765706, '会员注册', 1),
(136, 13823181560, 239087, '{\"code\":239087,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508765920, '会员注册', 1),
(137, 13927482132, 746094, '{\"code\":746094,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508767122, '会员注册', 1),
(138, 13927482132, 534606, '{\"code\":534606,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508767180, '会员注册', 1),
(139, 13927482132, 319691, '{\"code\":319691,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508767861, '会员注册', 1),
(140, 15817261835, 272415, '{\"code\":272415,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508767955, '会员注册', 1),
(141, 15817261835, 772250, '{\"code\":772250,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508768152, '会员注册', 1),
(142, 15817261835, 851929, '{\"code\":851929,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508768490, '会员注册', 1),
(143, 13066830132, 368102, '{\"code\":368102,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508769499, '会员注册', 1),
(144, 13927478108, 103458, '{\"code\":103458,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508770039, '会员注册', 0),
(145, 13510234557, 475088, '{\"code\":475088,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508771630, '会员注册', 1),
(146, 13423851796, 142054, '{\"code\":142054,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508810005, '会员注册', 1),
(147, 13927482132, 488985, '{\"code\":488985,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508810627, '会员注册', 1),
(148, 13927482132, 606155, '{\"code\":606155,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508812958, '会员注册', 1),
(149, 15018514302, 169880, '{\"code\":169880,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508815196, '会员注册', 0),
(150, 18124663652, 200172, '{\"code\":200172,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508815975, '会员注册', 1),
(151, 13026617697, 547674, '{\"code\":547674,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508827732, '会员注册', 1),
(152, 13602600100, 556847, '{\"code\":556847,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508831226, '会员注册', 1),
(153, 13632598336, 415215, '{\"code\":415215,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508835255, '会员注册', 1),
(154, 13927478108, 944207, '{\"code\":944207,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508839332, '会员注册', 1),
(155, 13603022117, 769051, '{\"code\":769051,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508847529, '会员注册', 1),
(156, 13632598336, 703327, '{\"code\":703327,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508848854, '会员注册', 1),
(157, 13985047399, 662478, '{\"code\":662478,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508848980, '会员注册', 1),
(158, 13927482132, 958481, '{\"code\":958481,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508850420, '会员注册', 1),
(159, 13632598336, 519343, '{\"code\":519343,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508851084, '会员注册', 1),
(160, 13927478108, 678879, '{\"code\":678879,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508851186, '会员注册', 1),
(161, 13632598336, 393336, '{\"code\":393336,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508851586, '会员注册', 1),
(162, 13985047399, 545131, '{\"code\":545131,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508851841, '会员注册', 1),
(163, 18681520620, 812584, '{\"code\":812584,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508852117, '会员注册', 1),
(164, 18938039629, 262071, '{\"code\":262071,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508856463, '会员注册', 1),
(165, 13985047399, 842260, '{\"code\":842260,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508938515, '会员注册', 1),
(166, 13985047399, 174673, '{\"code\":174673,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508943970, '会员注册', 1),
(167, 13632598336, 945680, '{\"code\":945680,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1508984426, '会员注册', 1),
(168, 13760460789, 283635, '{\"code\":283635,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1509009221, '会员注册', 1),
(169, 13510313780, 663300, '{\"code\":663300,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1509021469, '会员注册', 1),
(170, 13670280289, 582104, '{\"code\":582104,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1509024618, '会员注册', 1),
(171, 13613097067, 776564, '{\"code\":776564,\"minute\":5,\"comName\":\"HOT\\u5927\\u70ed\\u7bee\\u7403\"}', 1509062595, '会员注册', 1);

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE `student` (
  `id` int(10) UNSIGNED NOT NULL,
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
  `finished_lesson` int(10) NOT NULL COMMENT '已上课程',
  `total_schedule` int(10) NOT NULL DEFAULT '0',
  `finished_schedule` int(10) NOT NULL DEFAULT '0',
  `delete_time` int(10) DEFAULT NULL,
  `student_province` varchar(60) NOT NULL COMMENT '所在地区:省',
  `student_city` varchar(60) NOT NULL COMMENT '所在地区:市',
  `student_area` varchar(60) NOT NULL COMMENT '所在地区:区',
  `create_time` int(10) NOT NULL COMMENT '学员注册时间',
  `update_time` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`id`, `member_id`, `member`, `student`, `student_sex`, `openid`, `student_birthday`, `parent_id`, `parent`, `student_avatar`, `mobile`, `emergency_telephone`, `school`, `student_charater`, `student_weight`, `student_height`, `student_shoe_code`, `remarks`, `total_lesson`, `finished_lesson`, `total_schedule`, `finished_schedule`, `delete_time`, `student_province`, `student_city`, `student_area`, `create_time`, `update_time`) VALUES
(1, 8, 'woo123', '123', 1, '0', '0000-00-00', 0, '345', '/static/default/avatar.png', '', 18507717466, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 0, 0),
(2, 6, 'legend', '陈小准', 1, '0', '0000-00-00', 0, '陈烈准', '/static/default/avatar.png', '', 13826505160, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 0, 0),
(3, 13, 'Greeny', 'Easychen ', 1, '0', '0000-00-00', 0, 'Greeny', '/static/default/avatar.png', '', 13828880254, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 0, 0),
(4, 4, 'weilin666', '小霖', 1, '0', '0000-00-00', 0, '刘先生', '/static/default/avatar.png', '', 13410599613, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 0, 0),
(5, 15, '13537781797', '张晨儒', 1, '0', '0000-00-00', 0, '武小姐', '/static/default/avatar.png', '', 13537781797, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 0, 0),
(6, 5, '123abc', '刘嘉', 1, '0', '0000-00-00', 0, '刘嘉兴', '/static/default/avatar.png', '', 13418931599, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1507880294, 1507880294),
(61, 6, 'legend', '曹操', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 13826505160, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508993763, 1508993763),
(8, 23, '123456', '钟欣志', 1, '0', '0000-00-00', 0, '钟欣志爸爸', '/static/default/avatar.png', '', 13699816180, '', '', '0.00', '0.00', '', '系统插入', 0, 0, 0, 0, NULL, '', '', '', 1508141393, 1508141393),
(9, 25, '罗翔宇', '罗翔宇', 1, '0', '0000-00-00', 0, '罗翔宇爸爸', '/static/default/avatar.png', '', 13924641692, '', '', '0.00', '0.00', '', '系统插入', 0, 0, 0, 0, NULL, '', '', '', 1508143416, 1508143416),
(11, 33, 'yanyan', '陈佳佑', 1, '0', '0000-00-00', 0, '陈烈准', '/static/default/avatar.png', '', 13632649700, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508207276, 1508207276),
(12, 1, 'HoChen', '娟', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 13823599611, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508227397, 1508227397),
(13, 22, '邓赖迪', '邓赖迪', 1, '0', '0000-00-00', 0, '赖金花', '/static/default/avatar.png', '', 13537819321, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508242025, 1508242025),
(14, 26, '陈承铭', '陈承铭', 1, '0', '0000-00-00', 0, '陈承铭爸爸', '/static/default/avatar.png', '', 13570811474, '', '', '0.00', '0.00', '', '系统插入.时间2017年10月18日17:36:15', 1, 0, 15, 0, NULL, '', '', '', 1508318976, 0),
(15, 43, '陈润宏', '陈润宏', 1, '0', '0000-00-00', 0, '陈国顺', '/static/default/avatar.png', '', 13713999790, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508554665, 1508554665),
(16, 42, '李润弘', '李润弘', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 13510074790, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508554757, 1508554757),
(17, 48, '郑肖杰', '郑肖杰', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 13925297472, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508639901, 1508639901),
(18, 49, '黄浩', '黄浩', 1, '0', '0000-00-00', 0, '胡淑婵', '/static/default/avatar.png', '', 15999691100, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508658048, 1508658048),
(19, 52, '吴师隽', '吴师隽', 1, '0', '0000-00-00', 0, '柳超', '/static/default/avatar.png', '', 13670002176, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508661849, 1508661849),
(20, 55, '唐轩衡', '唐轩衡', 1, '0', '0000-00-00', 0, '陈楚君', '/static/default/avatar.png', '', 13538289022, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508676498, 1508676498),
(21, 59, '陈高翔', '陈高翔', 1, '0', '0000-00-00', 0, '高瑞珍', '/static/default/avatar.png', '', 18603038806, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508689260, 1508689260),
(22, 56, '郑皓畅', '郑皓畅', 1, '0', '0000-00-00', 0, '黄少明', '/static/default/avatar.png', '', 13556389955, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508723279, 1508723279),
(42, 80, 'kiko', '陈宛杭', 1, '0', '0000-00-00', 0, '王湘云', '/static/default/avatar.png', '', 13603022117, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508849703, 1508849703),
(41, 79, 'Youboy806', '游逸朗', 1, '0', '0000-00-00', 0, '游国荣', '/static/default/avatar.png', '', 13602600100, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508831412, 1508831412),
(25, 51, '战奕名', '战奕名', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 15818553993, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508724564, 1508724564),
(26, 46, '李语辰', '李语辰', 1, '0', '0000-00-00', 0, '李云', '/static/default/avatar.png', '', 15622835386, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508725747, 1508725747),
(27, 50, '张毓楠', '张毓楠', 1, '0', '0000-00-00', 0, '黄少珊', '/static/default/avatar.png', '', 13928447499, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508726053, 1508726053),
(28, 60, '王钰龙', '王钰龙', 1, '0', '0000-00-00', 0, '冯琴', '/static/default/avatar.png', '', 13723758658, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508726094, 1508726094),
(29, 62, '刘宇恒', '刘宇恒', 1, '0', '0000-00-00', 0, '小鱼儿', '/static/default/avatar.png', '', 13602581364, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508729322, 1508729322),
(30, 63, 'leonhuang', '黄子诺', 1, '0', '0000-00-00', 0, '汤晓罗', '/static/default/avatar.png', '', 13826554640, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508730420, 1508730420),
(31, 65, '蒋清奕', '蒋清奕', 1, '0', '0000-00-00', 0, '陈金华', '/static/default/avatar.png', '', 13510633766, '', '', '0.00', '0.00', '', '', 1, 0, 15, 0, NULL, '', '', '', 1508730892, 1508730892),
(43, 82, '13927482132', '邓粤天', 1, '0', '0000-00-00', 0, '李苏阳', '/static/default/avatar.png', '', 13927482132, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508850506, 1508850506),
(33, 66, '20101119', '梁峻玮', 1, '0', '0000-00-00', 0, '汪根娌', '/static/default/avatar.png', '', 13928438541, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508732394, 1508732394),
(34, 67, 'gaojun', '刘一凡', 1, '0', '0000-00-00', 0, '高军', '/static/default/avatar.png', '', 13501570069, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508735133, 1508735133),
(35, 61, '万宇宸', '万宇宸', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 13714718628, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508737730, 1508737730),
(36, 73, 'SZQIUJB', '邱仁鹏', 1, '0', '0000-00-00', 0, '邱剑波', '/static/default/avatar.png', '', 13928451722, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508766133, 1508766133),
(38, 74, '13823181560', '林需睦', 1, '0', '0000-00-00', 0, '黄小姐', '/static/default/avatar.png', '', 13823181560, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508766333, 1508766333),
(39, 58, '饶滨', '饶滨', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 13113013889, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508770975, 1508770975),
(40, 76, 'cjwcyc', '陈昊阳', 1, '0', '0000-00-00', 0, '杨丽', '/static/default/avatar.png', '', 13423851796, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508810101, 1508810101),
(44, 6, 'legend', '高规格', 1, '0', '0000-00-00', 0, '哈哈哈', '/static/default/avatar.png', '', 13826505160, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508903343, 1508903343),
(52, 6, 'legend', '苏楠楠', 1, '0', '0000-00-00', 0, '陈楠楠', '/static/default/avatar.png', '', 13826505160, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508913982, 1508913982),
(46, 8, 'woo123', '小woo', 1, '0', '0000-00-00', 0, 'woo', '/static/default/avatar.png', '', 18507717466, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508909610, 1508909610),
(47, 6, 'legend', '韩红', 1, '0', '0000-00-00', 0, '包包', '/static/default/avatar.png', '', 13826505160, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508909655, 1508909655),
(51, 77, 'wayen', '荣', 1, '0', '0000-00-00', 0, '张图', '/static/default/avatar.png', '', 18124663652, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508912251, 1508912251),
(53, 7, 'wayen_z', '张伟荣 ', 1, '0', '0000-00-00', 0, '张家长', '/static/default/avatar.png', '', 15018514302, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508922435, 1508922435),
(54, 7, 'wayen_z', '是是是', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 15018514302, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508922500, 1508922500),
(55, 7, 'wayen_z', '是', 1, '0', '0000-00-00', 0, '是是是', '/static/default/avatar.png', '', 15018514302, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508922556, 1508922556),
(56, 86, '姚定希', '姚定希', 1, '0', '0000-00-00', 0, '黄艳', '/static/default/avatar.png', '', 13985047399, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508944081, 1508944081),
(57, 83, '梁懿', '梁懿', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 13927478108, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1508982434, 1508982434),
(63, 84, '余永康', '余永康', 1, '0', '0000-00-00', 0, '赵丽君', '/static/default/avatar.png', '', 18681520620, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1509006198, 1509006198),
(62, 81, 'rebeccazhangly', '周子杰', 1, '0', '0000-00-00', 0, '', '/static/default/avatar.png', '', 13632598336, '', '', '0.00', '0.00', '', '', 1, 0, 15, 0, NULL, '', '', '', 1509001947, 1509001947),
(64, 39, '饶宏宇', '饶宏宇', 1, '0', '0000-00-00', 0, '饶剑锋', '/static/default/avatar.png', '', 13640904690, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1509008211, 1509008211),
(65, 39, '饶宏宇', '饶宏宇', 1, '0', '0000-00-00', 0, '饶剑锋', '/static/default/avatar.png', '', 13640904690, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1509008211, 1509008211),
(66, 39, '饶宏宇', '饶宏宇', 1, '0', '0000-00-00', 0, '饶剑锋', '/static/default/avatar.png', '', 13640904690, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1509008212, 1509008212),
(67, 87, '朱涛', '朱涛', 1, '0', '0000-00-00', 0, '张纪媛', '/static/default/avatar.png', '', 13760460789, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1509009341, 1509009341),
(68, 89, 'Li hong', '李泓', 1, '0', '0000-00-00', 0, '郑晓芬', '/static/default/avatar.png', '', 13670280289, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1509027560, 1509027560),
(69, 89, 'Li hong', '李泓', 1, '0', '0000-00-00', 0, '郑晓芬', '/static/default/avatar.png', '', 13670280289, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1509027697, 1509027697),
(70, 90, 'lixiaofang', '李小凡', 1, '0', '0000-00-00', 0, '李太喜', '/static/default/avatar.png', '', 13613097067, '', '', '0.00', '0.00', '', '', 0, 0, 0, 0, NULL, '', '', '', 1509062756, 1509062756);

-- --------------------------------------------------------

--
-- 表的结构 `system_award`
--

CREATE TABLE `system_award` (
  `id` int(10) UNSIGNED NOT NULL,
  `salary` decimal(8,2) NOT NULL,
  `score` int(10) NOT NULL,
  `member_id` int(10) NOT NULL,
  `member` varchar(10) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '奖励类型:1等级|2:阶衔|3:其他',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统奖励记录表';

-- --------------------------------------------------------

--
-- 表的结构 `__court_media`
--

CREATE TABLE `__court_media` (
  `id` int(10) UNSIGNED NOT NULL,
  `court_id` int(10) NOT NULL,
  `title` varchar(250) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:图片|1:视频',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='场地图片';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankcard`
--
ALTER TABLE `bankcard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `camp`
--
ALTER TABLE `camp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `camp_comment`
--
ALTER TABLE `camp_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `camp_member`
--
ALTER TABLE `camp_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `camp_power`
--
ALTER TABLE `camp_power`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cert`
--
ALTER TABLE `cert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coach_comment`
--
ALTER TABLE `coach_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `court_camp`
--
ALTER TABLE `court_camp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_member`
--
ALTER TABLE `event_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_category`
--
ALTER TABLE `grade_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_member`
--
ALTER TABLE `grade_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_admindo`
--
ALTER TABLE `log_admindo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_camp_member`
--
ALTER TABLE `log_camp_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_grade_member`
--
ALTER TABLE `log_grade_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_income`
--
ALTER TABLE `log_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_pay`
--
ALTER TABLE `log_pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_rebate`
--
ALTER TABLE `log_rebate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_salary_in`
--
ALTER TABLE `log_salary_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_salary_out`
--
ALTER TABLE `log_salary_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_sendtemplatemsg`
--
ALTER TABLE `log_sendtemplatemsg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_wxpay`
--
ALTER TABLE `log_wxpay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_member`
--
ALTER TABLE `message_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_read`
--
ALTER TABLE `message_read`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rebate`
--
ALTER TABLE `rebate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rebate_hp`
--
ALTER TABLE `rebate_hp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rebate_score`
--
ALTER TABLE `rebate_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_in`
--
ALTER TABLE `salary_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_out`
--
ALTER TABLE `salary_out`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_comment`
--
ALTER TABLE `schedule_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_media`
--
ALTER TABLE `schedule_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_member`
--
ALTER TABLE `schedule_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smsverify`
--
ALTER TABLE `smsverify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_award`
--
ALTER TABLE `system_award`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `__court_media`
--
ALTER TABLE `__court_media`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `bankcard`
--
ALTER TABLE `bankcard`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- 使用表AUTO_INCREMENT `camp`
--
ALTER TABLE `camp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `camp_comment`
--
ALTER TABLE `camp_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- 使用表AUTO_INCREMENT `camp_member`
--
ALTER TABLE `camp_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- 使用表AUTO_INCREMENT `camp_power`
--
ALTER TABLE `camp_power`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `cert`
--
ALTER TABLE `cert`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- 使用表AUTO_INCREMENT `coach`
--
ALTER TABLE `coach`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用表AUTO_INCREMENT `coach_comment`
--
ALTER TABLE `coach_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `court`
--
ALTER TABLE `court`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `court_camp`
--
ALTER TABLE `court_camp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- 使用表AUTO_INCREMENT `event`
--
ALTER TABLE `event`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `event_member`
--
ALTER TABLE `event_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `exercise`
--
ALTER TABLE `exercise`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- 使用表AUTO_INCREMENT `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- 使用表AUTO_INCREMENT `grade_category`
--
ALTER TABLE `grade_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- 使用表AUTO_INCREMENT `grade_member`
--
ALTER TABLE `grade_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- 使用表AUTO_INCREMENT `income`
--
ALTER TABLE `income`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- 使用表AUTO_INCREMENT `lesson`
--
ALTER TABLE `lesson`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- 使用表AUTO_INCREMENT `log_admindo`
--
ALTER TABLE `log_admindo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- 使用表AUTO_INCREMENT `log_sendtemplatemsg`
--
ALTER TABLE `log_sendtemplatemsg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
--
-- 使用表AUTO_INCREMENT `log_wxpay`
--
ALTER TABLE `log_wxpay`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `media`
--
ALTER TABLE `media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `member`
--
ALTER TABLE `member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- 使用表AUTO_INCREMENT `message_member`
--
ALTER TABLE `message_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;
--
-- 使用表AUTO_INCREMENT `message_read`
--
ALTER TABLE `message_read`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- 使用表AUTO_INCREMENT `pay`
--
ALTER TABLE `pay`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `plan`
--
ALTER TABLE `plan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `rebate`
--
ALTER TABLE `rebate`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `rebate_hp`
--
ALTER TABLE `rebate_hp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `rebate_score`
--
ALTER TABLE `rebate_score`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `salary_in`
--
ALTER TABLE `salary_in`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `salary_out`
--
ALTER TABLE `salary_out`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- 使用表AUTO_INCREMENT `schedule_comment`
--
ALTER TABLE `schedule_comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `schedule_media`
--
ALTER TABLE `schedule_media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `schedule_member`
--
ALTER TABLE `schedule_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- 使用表AUTO_INCREMENT `score`
--
ALTER TABLE `score`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `sells`
--
ALTER TABLE `sells`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `smsverify`
--
ALTER TABLE `smsverify`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--
-- 使用表AUTO_INCREMENT `student`
--
ALTER TABLE `student`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- 使用表AUTO_INCREMENT `system_award`
--
ALTER TABLE `system_award`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `__court_media`
--
ALTER TABLE `__court_media`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
