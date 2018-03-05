-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-03-05 17:51:48
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
-- 转存表中的数据 `rebate`
--

INSERT INTO `rebate` (`id`, `member_id`, `member`, `sid`, `s_member`, `salary`, `score`, `salary_id`, `tier`, `datemonth`, `create_time`, `update_time`, `delete_time`, `system_remarks`) VALUES
(1, 2, 'Hot-basketball2', 19, '钟声', '1237.00', '0.00', 0, 1, '201712', 1514743801, 1514743801, 1517302005, '20180130:遍历历史数据,此记录无效了'),
(2, 2, 'Hot-basketball2', 36, 'Gavin.zhuang', '6.25', '0.00', 0, 1, '201710', 1517302317, 1517302317, NULL, NULL),
(3, 1, 'HoChen', 2, 'Hot-basketball2', '3.75', '0.00', 0, 2, '201710', 1517302317, 1517302317, NULL, NULL),
(4, 2, 'Hot-basketball2', 36, 'Gavin.zhuang', '26.25', '0.00', 0, 1, '201711', 1517302317, 1517302317, NULL, NULL),
(5, 1, 'HoChen', 2, 'Hot-basketball2', '15.75', '0.00', 0, 2, '201711', 1517302317, 1517302317, NULL, NULL),
(6, 2, 'Hot-basketball2', 19, '钟声', '4.00', '0.00', 0, 1, '201706', 1517302317, 1517302317, NULL, NULL),
(7, 1, 'HoChen', 2, 'Hot-basketball2', '2.40', '0.00', 0, 2, '201706', 1517302317, 1517302317, NULL, NULL),
(8, 2, 'Hot-basketball2', 19, '钟声', '20.00', '0.00', 0, 1, '201707', 1517302317, 1517302317, NULL, NULL),
(9, 1, 'HoChen', 2, 'Hot-basketball2', '12.00', '0.00', 0, 2, '201707', 1517302317, 1517302317, NULL, NULL),
(10, 2, 'Hot-basketball2', 19, '钟声', '36.50', '0.00', 0, 1, '201709', 1517302317, 1517302317, NULL, NULL),
(11, 1, 'HoChen', 2, 'Hot-basketball2', '21.90', '0.00', 0, 2, '201709', 1517302317, 1517302317, NULL, NULL),
(12, 16, 'andy.lin', 184, '涵叔', '15.00', '0.00', 0, 1, '201711', 1517302317, 1517302317, NULL, NULL),
(13, 2, 'Hot-basketball2', 16, 'andy.lin', '9.00', '0.00', 0, 2, '201711', 1517302317, 1517302317, NULL, NULL),
(14, 2, 'Hot-basketball2', 18, 'AK', '117.30', '0.00', 0, 1, '201711', 1517302317, 1517302317, NULL, NULL),
(15, 1, 'HoChen', 2, 'Hot-basketball2', '70.38', '0.00', 0, 2, '201711', 1517302317, 1517302317, NULL, NULL),
(16, 2, 'Hot-basketball2', 18, 'AK', '40.50', '0.00', 0, 1, '201710', 1517302317, 1517302317, NULL, NULL),
(17, 1, 'HoChen', 2, 'Hot-basketball2', '24.30', '0.00', 0, 2, '201710', 1517302317, 1517302317, NULL, NULL),
(18, 2, 'Hot-basketball2', 27, 'coachj', '352.50', '0.00', 0, 1, '201712', 1517302317, 1517302317, NULL, NULL),
(19, 1, 'HoChen', 2, 'Hot-basketball2', '211.50', '0.00', 0, 2, '201712', 1517302317, 1517302317, NULL, NULL),
(20, 2, 'Hot-basketball2', 16, 'andy.lin', '30.00', '0.00', 0, 1, '201712', 1517302317, 1517302317, NULL, NULL),
(21, 1, 'HoChen', 2, 'Hot-basketball2', '18.00', '0.00', 0, 2, '201712', 1517302317, 1517302317, NULL, NULL),
(22, 2, 'Hot-basketball2', 17, 'Bruce.Dong', '221.25', '0.00', 0, 1, '201712', 1517302317, 1517302317, NULL, NULL),
(23, 1, 'HoChen', 2, 'Hot-basketball2', '132.75', '0.00', 0, 2, '201712', 1517302317, 1517302317, NULL, NULL),
(24, 16, 'andy.lin', 184, '涵叔', '30.00', '0.00', 0, 1, '201712', 1517302317, 1517302317, NULL, NULL),
(25, 2, 'Hot-basketball2', 16, 'andy.lin', '18.00', '0.00', 0, 2, '201712', 1517302317, 1517302317, NULL, NULL),
(26, 2, 'Hot-basketball2', 18, 'AK', '737.35', '0.00', 0, 1, '201712', 1517302317, 1517302317, NULL, NULL),
(27, 1, 'HoChen', 2, 'Hot-basketball2', '442.41', '0.00', 0, 2, '201712', 1517302317, 1517302317, NULL, NULL),
(28, 2, 'Hot-basketball2', 36, 'Gavin.zhuang', '43.00', '0.00', 0, 1, '201712', 1517302317, 1517302317, NULL, NULL),
(29, 1, 'HoChen', 2, 'Hot-basketball2', '25.80', '0.00', 0, 2, '201712', 1517302317, 1517302317, NULL, NULL),
(30, 2, 'Hot-basketball2', 27, 'coachj', '5.00', '0.00', 0, 1, '201709', 1517302317, 1517302317, NULL, NULL),
(31, 1, 'HoChen', 2, 'Hot-basketball2', '3.00', '0.00', 0, 2, '201709', 1517302317, 1517302317, NULL, NULL),
(32, 2, 'Hot-basketball2', 27, 'coachj', '21.25', '0.00', 0, 1, '201710', 1517302317, 1517302317, NULL, NULL),
(33, 1, 'HoChen', 2, 'Hot-basketball2', '12.75', '0.00', 0, 2, '201710', 1517302317, 1517302317, NULL, NULL),
(34, 2, 'Hot-basketball2', 27, 'coachj', '58.75', '0.00', 0, 1, '201711', 1517302317, 1517302317, NULL, NULL),
(35, 1, 'HoChen', 2, 'Hot-basketball2', '35.25', '0.00', 0, 2, '201711', 1517302317, 1517302317, NULL, NULL),
(36, 1, 'HoChen', 2, 'Hot-basketball2', '1194.55', '0.00', 0, 1, '201712', 1517302317, 1517302317, NULL, NULL),
(37, 2, 'Hot-basketball2', 19, '钟声', '860.50', '0.00', 0, 1, '201712', 1517302317, 1517302317, NULL, NULL),
(38, 1, 'HoChen', 2, 'Hot-basketball2', '516.30', '0.00', 0, 2, '201712', 1517302317, 1517302317, NULL, NULL),
(39, 2, 'Hot-basketball2', 19, '钟声', '417.75', '0.00', 0, 1, '201711', 1517302317, 1517302317, NULL, NULL),
(40, 1, 'HoChen', 2, 'Hot-basketball2', '250.65', '0.00', 0, 2, '201711', 1517302317, 1517302317, NULL, NULL),
(41, 2, 'Hot-basketball2', 17, 'Bruce.Dong', '11.25', '0.00', 0, 1, '201710', 1517302317, 1517302317, NULL, NULL),
(42, 1, 'HoChen', 2, 'Hot-basketball2', '6.75', '0.00', 0, 2, '201710', 1517302317, 1517302317, NULL, NULL),
(43, 1, 'HoChen', 2, 'Hot-basketball2', '147.00', '0.00', 0, 1, '201711', 1517302317, 1517302317, NULL, NULL),
(44, 2, 'Hot-basketball2', 17, 'Bruce.Dong', '62.50', '0.00', 0, 1, '201711', 1517302317, 1517302317, NULL, NULL),
(45, 1, 'HoChen', 2, 'Hot-basketball2', '37.50', '0.00', 0, 2, '201711', 1517302317, 1517302317, NULL, NULL),
(46, 1, 'HoChen', 2, 'Hot-basketball2', '78.75', '0.00', 0, 1, '201710', 1517302317, 1517302317, NULL, NULL),
(47, 2, 'Hot-basketball2', 19, '钟声', '267.50', '0.00', 0, 1, '201710', 1517302317, 1517302317, NULL, NULL),
(48, 1, 'HoChen', 2, 'Hot-basketball2', '160.50', '0.00', 0, 2, '201710', 1517302317, 1517302317, NULL, NULL),
(49, 2, 'Hot-basketball2', 16, 'andy.lin', '45.00', '0.00', 0, 1, '201801', 1517422201, 1517422201, NULL, NULL),
(50, 1, 'HoChen', 2, 'Hot-basketball2', '27.00', '0.00', 0, 2, '201801', 1517422201, 1517422201, NULL, NULL),
(51, 2, 'Hot-basketball2', 27, 'coachj', '28.75', '0.00', 0, 1, '201801', 1517422201, 1517422201, NULL, NULL),
(52, 1, 'HoChen', 2, 'Hot-basketball2', '17.25', '0.00', 0, 2, '201801', 1517422201, 1517422201, NULL, NULL),
(53, 16, 'andy.lin', 184, '涵叔', '45.00', '0.00', 0, 1, '201801', 1517422201, 1517422201, NULL, NULL),
(54, 2, 'Hot-basketball2', 16, 'andy.lin', '27.00', '0.00', 0, 2, '201801', 1517422201, 1517422201, NULL, NULL),
(55, 2, 'Hot-basketball2', 18, 'AK', '397.85', '0.00', 0, 1, '201801', 1517422201, 1517422201, NULL, NULL),
(56, 1, 'HoChen', 2, 'Hot-basketball2', '238.71', '0.00', 0, 2, '201801', 1517422201, 1517422201, NULL, NULL),
(57, 2, 'Hot-basketball2', 19, '钟声', '549.75', '0.00', 0, 1, '201801', 1517422201, 1517422201, NULL, NULL),
(58, 1, 'HoChen', 2, 'Hot-basketball2', '329.85', '0.00', 0, 2, '201801', 1517422201, 1517422201, NULL, NULL),
(59, 1, 'HoChen', 2, 'Hot-basketball2', '181.50', '0.00', 0, 1, '201801', 1517422201, 1517422201, NULL, NULL),
(60, 2, 'Hot-basketball2', 36, 'Gavin.zhuang', '35.00', '0.00', 0, 1, '201801', 1517422201, 1517422201, NULL, NULL),
(61, 1, 'HoChen', 2, 'Hot-basketball2', '21.00', '0.00', 0, 2, '201801', 1517422201, 1517422201, NULL, NULL),
(62, 2, 'Hot-basketball2', 17, 'Bruce.Dong', '32.50', '0.00', 0, 1, '201802', 1519841402, 1519841402, NULL, NULL),
(63, 1, 'HoChen', 2, 'Hot-basketball2', '19.50', '0.00', 0, 2, '201802', 1519841402, 1519841402, NULL, NULL),
(64, 2, 'Hot-basketball2', 18, 'AK', '84.85', '0.00', 0, 1, '201802', 1519841402, 1519841402, NULL, NULL),
(65, 1, 'HoChen', 2, 'Hot-basketball2', '50.91', '0.00', 0, 2, '201802', 1519841402, 1519841402, NULL, NULL),
(66, 1, 'HoChen', 2, 'Hot-basketball2', '64.55', '0.00', 0, 1, '201802', 1519841402, 1519841402, NULL, NULL),
(67, 2, 'Hot-basketball2', 19, '钟声', '80.00', '0.00', 0, 1, '201802', 1519841402, 1519841402, NULL, NULL),
(68, 1, 'HoChen', 2, 'Hot-basketball2', '48.00', '0.00', 0, 2, '201802', 1519841402, 1519841402, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
