-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-13 16:15:25
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
-- 转存表中的数据 `admin_group`
--

INSERT INTO `admin_group` (`id`, `pid`, `name`, `description`, `sort`, `menu_auth`, `status`, `create_time`, `update_time`) VALUES
(1, 0, '超级管理员', 'woo', 0, '0', 1, 0, 0),
(2, 0, '财务部', '财务部', 1, '[1,4,15,16,17,18,19,20,64,65,66,67,68,69,70,71]', 1, 0, 0),
(3, 2, '出纳', '财务部的出纳', 1, '[1,4,15,16,17,18,19,20,64,65,66,67,68,69,70,71]', 1, 0, 0),
(4, 0, '行政部', '行政部', 2, '[1,3,7,8,9,10,11,12,12,13,14,22,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,72,73,74,75,76,77,78,81,5,21,81]', 1, 0, 0),
(5, 4, '行政专员', '行政专员', 1, '[1,3,7,8,9,10,11,12,12,13,14,22,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,72,73,74,75,76,77,78,81,5,21,81]', 1, 0, 0),
(6, 4, '客服专员', '客服专员', 2, '[1,3,7,8,9,10,11,12,13,14,22]', 1, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
