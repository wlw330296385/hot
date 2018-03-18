-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-25 14:17:22
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

--
-- 转存表中的数据 `bankcard`
--

INSERT INTO `bankcard` (`id`, `bank`, `bank_card`, `bank_type`, `member`, `member_id`, `realname`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '中国工商银行', '6212264000053206005', 1, 'andy.lin', 16, '林泽铭', 1514175561, NULL, NULL),
(2, '中国工商银行', '6212264000060621063', 1, 'Bruce.Dong', 17, '董硕同', 1514175561, NULL, NULL),
(3, '中国工商银行', '6217214000020106072', 1, 'AK', 18, '安凯翔', 1514175561, NULL, NULL),
(4, '中国工商银行', '6212264000045738313', 1, '钟声', 19, '钟声', 1514175561, NULL, NULL),
(5, '中国工商银行', '6212264000037559362', 1, 'coachj', 27, '黄万瑞', 1514175561, NULL, NULL),
(6, '中国工商银行', '6212264000014578286', 1, 'Gavin.zhuang', 36, '庄贵钦', 1514175561, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bankcard`
--
ALTER TABLE `bankcard`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `bankcard`
--
ALTER TABLE `bankcard`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
