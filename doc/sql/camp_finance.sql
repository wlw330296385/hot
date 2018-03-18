-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-22 15:31:31
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
-- 表的结构 `camp_finance`
--

CREATE TABLE `camp_finance` (
  `id` int(11) UNSIGNED NOT NULL,
  `camp_id` int(11) NOT NULL COMMENT '训练营id',
  `camp` varchar(100) NOT NULL COMMENT '训练营',
  `finance_type` int(11) NOT NULL COMMENT '财务类型:1课程营业额|2课时工资',
  `lesson_turnover` int(11) NOT NULL COMMENT '课程营业额',
  `bill_id` int(11) NOT NULL COMMENT '订单id',
  `schedule_salary` int(11) NOT NULL COMMENT '课时工资',
  `schedule_id` int(11) NOT NULL COMMENT '课时id',
  `date` varchar(20) NOT NULL DEFAULT '' COMMENT '对应数据发生日期',
  `datetime` int(11) NOT NULL COMMENT '对应数据发生日期时间戳',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='训练营财务收入支出记录';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `camp_finance`
--
ALTER TABLE `camp_finance`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `camp_finance`
--
ALTER TABLE `camp_finance`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
