-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-02-07 14:30:46
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
-- 表的结构 `match_apply`
--

CREATE TABLE `match_apply` (
  `id` int(10) UNSIGNED NOT NULL,
  `match_id` int(10) UNSIGNED NOT NULL COMMENT '比赛id',
  `match` varchar(100) NOT NULL COMMENT '比赛name',
  `team_id` int(10) UNSIGNED NOT NULL COMMENT '发布申请的球队id',
  `team` varchar(100) NOT NULL COMMENT '发布申请的球队name',
  `telphone` varchar(20) NOT NULL COMMENT '联系人电话',
  `contact` varchar(20) NOT NULL COMMENT '联系人',
  `member_id` int(10) UNSIGNED NOT NULL COMMENT '发送申请的会员id',
  `member` varchar(100) NOT NULL COMMENT '发送申请的会员member',
  `member_avatar` varchar(200) NOT NULL COMMENT '发送申请的会员avatar',
  `remarks` varchar(200) NOT NULL COMMENT '备注信息',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:未处理|2:已同意|3:已拒绝',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='球队参加比赛申请';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match_apply`
--
ALTER TABLE `match_apply`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `match_apply`
--
ALTER TABLE `match_apply`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
