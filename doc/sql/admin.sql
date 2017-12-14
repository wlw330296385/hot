-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-13 16:17:54
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

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `truename`, `email`, `avatar`, `telephone`, `group_id`, `status`, `create_time`, `update_time`, `logintime`, `lastlogin_at`, `lastlogin_ip`, `lastlogin_ua`) VALUES
(1, 'admin', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '/static/default/avatar.png', 0, 1, 1, 0, 1513146061, 103, 1513146061, '116.25.42.5', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.84 Safari/537.36'),
(2, 'yalu', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '', '', '/static/default/avatar.png', 0, 3, 1, 0, 1513141994, 18, 1513141994, '116.25.42.5', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.104 Safari/537.36 Core/1.53.4295.400 QQBrowser/9.7.12661.400'),
(3, 'xian', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '111', '', '/static/default/avatar.png', 0, 5, 1, 1512456554, 1513053076, 3, 1513053076, '116.25.42.5', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22'),
(4, 'ho', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '陈烈侯', '', '/static/default/avatar.png', 0, 3, 1, 1513053616, 1513141648, 2, 1513141648, '116.25.42.5', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.104 Safari/537.36 Core/1.53.4295.400 QQBrowser/9.7.12661.400'),
(5, 'bingo', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '张文清', '', '/static/default/avatar.png', 0, 6, 1, 1513053730, 1513053730, 0, 0, '', ''),
(6, 'yanzi', '56c1dea092bcdb3c77b072d6ee9914008f8a383d', '燕子', '', '/static/default/avatar.png', 0, 6, 1, 1513053901, 1513053901, 0, 0, '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
