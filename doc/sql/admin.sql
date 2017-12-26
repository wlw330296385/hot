-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-26 15:46:44
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
  `truename` varchar(50) NOT NULL COMMENT '真实姓名',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `avatar` varchar(200) NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '头像',
  `telephone` bigint(20) NOT NULL COMMENT '手机号',
  `group_id` int(111) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态:1正常|0禁用',
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

INSERT INTO `admin` (`id`, `username`, `password`, `truename`, `email`, `avatar`, `telephone`, `group_id`, `status`, `create_time`, `update_time`, `logintime`, `lastlogin_at`, `lastlogin_ip`, `lastlogin_ua`) VALUES
(1, 'HOT', '7288bc489a5be340d09e0db76f133b9b1856c50e', '大热篮球', '', '/static/default/avatar.png', 0, 1, 1, 0, 1514270609, 124, 1514270609, '116.25.43.207', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.62 Safari/537.36'),
(2, 'yalu', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '/static/default/avatar.png', 0, 9, 1, 0, 1514270238, 36, 1514270238, '116.25.43.207', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36'),
(3, 'xian', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '111', '', '/static/default/avatar.png', 0, 5, 1, 1512456554, 1514271079, 30, 1514271079, '116.25.43.182', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22'),
(4, 'ho', 'a55330a47debc5933ae3a5a079e2537920b5ca20', '陈烈侯', '', '/static/default/avatar.png', 0, 7, 1, 1513053616, 1514088098, 5, 1514088098, '61.141.136.18', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.104 Safari/537.36 Core/1.53.3427.400 QQBrowser/9.6.12513.400'),
(5, 'bingo', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '张文清', '', '/static/default/avatar.png', 0, 6, 1, 1513053730, 1513053730, 0, 0, '', ''),
(6, 'yanzi', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '燕子', '', '/static/default/avatar.png', 0, 6, 1, 1513053901, 1513308206, 1, 1513308206, '116.25.42.196', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
