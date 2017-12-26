-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-26 15:52:33
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
-- 表的结构 `admin_group`
--

CREATE TABLE `admin_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL,
  `sort` int(11) NOT NULL,
  `menu_auth` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin_group`
--

INSERT INTO `admin_group` (`id`, `pid`, `name`, `description`, `sort`, `menu_auth`, `status`, `create_time`, `update_time`) VALUES
(1, 0, '超级管理员', 'woo', 0, '0', 1, 0, 0),
(2, 0, '财务部', '财务部', 1, '[1,4,15,16,17,18,19,20,64,65,66,67,68,69,70,71]', 1, 0, 0),
(3, 2, '出纳', '财务部的出纳', 1, '[1,4,15,16,17,18,19,20,64,65,66,67,68,69,70,71]', 1, 0, 0),
(4, 0, '行政部', '行政部', 2, '[1,3,7,8,9,10,11,12,12,13,14,22,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,72,73,74,75,76,77,78,81,5,21,82,83,84,85,86,88,89,,90]', 1, 0, 0),
(5, 4, '行政专员', '行政专员', 1, '[1,3,7,8,9,10,11,12,12,13,14,22,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,72,73,74,75,76,77,78,81,5,21,82,83,84,85,86,88,89,90]', 1, 0, 0),
(6, 4, '客服专员', '客服专员', 2, '[1,3,7,8,9,10,11,12,12,13,14,22,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,72,73,74,75,76,77,78,81,5,21,82,83,84,85,86,88,89,90]', 1, 0, 0),
(7, 1, '平台管理员', '权限最大', 3, '[90,89,88,87,86,85,84,83,82,81,80,79,78,77,76,75,74,73,72,71,70,69,68,67,66,65,64,63,62,61,60,59,58,57,56,55,54,53,52,51,50,49,48,47,46,45,44,43,42,41,40,39,38,37,36,35,34,33,32,31,30,29,28,27,25,24,23,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1]', 1, 0, 0),
(8, 0, '办公室', '部门', 5, '[90,89,88,87,86,85,84,83,82,81,78,77,76,75,74,73,72,71,70,69,68,67,66,65,64,63,62,61,60,59,58,57,56,55,54,53,52,51,50,49,48,47,46,45,44,43,42,41,40,39,38,37,36,35,34,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,1,3,4,5]', 1, 0, 0),
(9, 8, '办公司主任', '职位', 0, '[90,89,88,87,86,85,84,83,82,81,78,77,76,75,74,73,72,71,70,69,68,67,66,65,64,63,62,61,60,59,58,57,56,55,54,53,52,51,50,49,48,47,46,45,44,43,42,41,40,39,38,37,36,35,34,22,21,20,19,18,17,16,15,14,13,12,11,10,9,8,7,1,3,4,5]', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_group`
--
ALTER TABLE `admin_group`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_group`
--
ALTER TABLE `admin_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
