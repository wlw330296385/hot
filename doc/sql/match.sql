-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-02-07 14:30:26
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
-- 表的结构 `match`
--

CREATE TABLE `match` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` int(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '赛事类型:1友谊赛...',
  `name` varchar(100) NOT NULL COMMENT '赛事名称',
  `member_id` int(10) UNSIGNED NOT NULL COMMENT '创建人会员id',
  `member` varchar(100) NOT NULL COMMENT '创建人会员',
  `member_avatar` varchar(200) NOT NULL COMMENT '创建人会员头像',
  `team_id` int(11) NOT NULL COMMENT '创建比赛球队id(可无)',
  `team` varchar(50) NOT NULL COMMENT '创建比赛球队(可无)',
  `match_time` int(10) DEFAULT NULL COMMENT '比赛时间(单次比赛)',
  `start_time` int(11) DEFAULT NULL COMMENT '比赛开始时间(联赛等)',
  `end_time` int(11) DEFAULT NULL COMMENT '比赛结束时间(联赛等)',
  `reg_start_time` int(11) DEFAULT NULL COMMENT '开始报名时间',
  `reg_end_time` int(11) DEFAULT NULL COMMENT '截止报名时间',
  `province` varchar(50) NOT NULL COMMENT '比赛所在地区(省)',
  `city` varchar(50) NOT NULL COMMENT '比赛所在地区(市)',
  `area` varchar(50) NOT NULL COMMENT '比赛所在地区(区)',
  `court_id` int(11) NOT NULL COMMENT '场地court_id',
  `court` varchar(100) NOT NULL COMMENT '场地名称',
  `court_lng` varchar(20) NOT NULL COMMENT '场地定位坐标lng',
  `court_lat` varchar(20) NOT NULL COMMENT '场地定位坐标lat',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '状态:1正常|-1下架',
  `logo` varchar(255) NOT NULL COMMENT 'logo',
  `cover` varchar(255) NOT NULL COMMENT '封面图',
  `finished_time` int(11) DEFAULT NULL COMMENT '比赛完成时间',
  `is_finished` int(11) NOT NULL DEFAULT '-1' COMMENT '比赛是否完成:-1未完成|1已完成',
  `apply_status` int(11) NOT NULL DEFAULT '-1' COMMENT '约战申请状态:1匹配中|2完成匹配|-1默认',
  `islive` int(11) NOT NULL DEFAULT '-1' COMMENT '是否约战:1是|-1否',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注,温馨提示',
  `send_message` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '发布通知1:通知|-1不通知',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='赛事(比赛)主表';

--
-- 转存表中的数据 `match`
--

INSERT INTO `match` (`id`, `type`, `name`, `member_id`, `member`, `member_avatar`, `team_id`, `team`, `match_time`, `start_time`, `end_time`, `reg_start_time`, `reg_end_time`, `province`, `city`, `area`, `court_id`, `court`, `court_lng`, `court_lat`, `status`, `logo`, `cover`, `finished_time`, `is_finished`, `apply_status`, `islive`, `remarks`, `send_message`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 1, '荣光WTF vs （待定）', 7, 'wayen_z', '/uploads/images/avatar/cb9a76925c455ea50425e30edc0708341fc2784e', 2, '荣光WT', 1517303580, NULL, NULL, NULL, NULL, '广东省', '深圳市', '南山区', 53, '沙嘴文化广场篮球场（2号场）', '', '', 1, '', '', NULL, -1, -1, -1, '没有', 0, 1516851427, 1517395393, NULL),
(2, 1, 'H1 vs 学府小学 三1班', 1, 'HoChen', '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', 3, 'H1', 1517300220, NULL, NULL, NULL, NULL, '广东省', '深圳市', '南山区', 9, '海滨实验小学篮球场', '', '', 1, '', '', 1517300220, 1, -1, -1, '', -1, 1517298706, 1517300262, NULL),
(3, 1, 'H1 vs 大热追梦队', 24, 'Hot777', '/uploads/images/avatar/97c1acc66b14de212be90cd8d9bc5b9a76a841f0', 3, 'H1', 1522635600, NULL, NULL, NULL, NULL, '广东省', '深圳市', '南山区', 18, '丽山文体中心', '', '', 1, '', '', NULL, -1, -1, 1, '场地费AA\n自带裁判', 1, 1517314429, 1517314429, NULL),
(4, 1, 'H1篮球队 vs （待定）', 1, 'HoChen', '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', 3, 'H1篮球队', 1519825680, NULL, NULL, NULL, NULL, '广东省', '深圳市', '福田区', 57, '特区报社篮球场', '', '', 1, '', '', NULL, -1, -1, 1, '', 1, 1517320344, 1517320344, NULL),
(5, 1, '大热追梦队 vs （待定）', 18, 'AK', '/uploads/images/avatar/04a034ac3911fa4b9b06fb9087a7223812696411', 4, '大热追梦队', 1527652500, NULL, NULL, NULL, NULL, '广东省', '深圳市', '南山区', 20, '塘朗球场', '', '', 1, '', '', NULL, -1, -1, 0, '', 0, 1517371097, 1517371097, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match`
--
ALTER TABLE `match`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `match`
--
ALTER TABLE `match`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
