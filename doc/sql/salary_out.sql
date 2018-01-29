-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-29 17:52:31
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
-- 表的结构 `salary_out`
--

CREATE TABLE `salary_out` (
  `id` int(10) UNSIGNED NOT NULL,
  `salary` decimal(8,2) NOT NULL COMMENT '佣金',
  `tid` varchar(200) NOT NULL COMMENT '交易单号',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `realname` varchar(60) NOT NULL COMMENT '真实姓名',
  `telephone` bigint(11) NOT NULL,
  `ident` bigint(20) NOT NULL COMMENT '身份证号',
  `openid` varchar(64) NOT NULL,
  `bank_card` varchar(64) NOT NULL COMMENT '银行卡号',
  `bank` varchar(30) NOT NULL COMMENT '账号类型,如农业银行|支付宝',
  `fee` decimal(6,2) NOT NULL COMMENT '手续费',
  `pay_time` int(10) NOT NULL COMMENT '支付时间',
  `bank_type` tinyint(4) NOT NULL COMMENT '1:银行卡|2:支付宝',
  `is_pay` tinyint(4) NOT NULL DEFAULT '0',
  `buffer` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '冻结资金',
  `callback_str` text NOT NULL COMMENT '支付回调',
  `system_remarks` text NOT NULL,
  `create_time` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:申请中|1:已支付|2:取消|-1:对冲',
  `update_time` int(11) NOT NULL,
  `delete_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='佣金提现申请';

--
-- 转存表中的数据 `salary_out`
--

INSERT INTO `salary_out` (`id`, `salary`, `tid`, `member_id`, `member`, `realname`, `telephone`, `ident`, `openid`, `bank_card`, `bank`, `fee`, `pay_time`, `bank_type`, `is_pay`, `buffer`, `callback_str`, `system_remarks`, `create_time`, `status`, `update_time`, `delete_time`) VALUES
(1, '1.00', '20171226162014000', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', 1509724800, 1, 1, '0.00', '', '[系统出账]id:2,admin:yalu;', 1509724800, 1, 0, 1515306527),
(2, '50.00', '2.0171227114617E+21', 8, 'woo123', '吴丽文', 18507717466, 0, 'o83291CzkRqonKdTVSJLGhYoU98Q', '18507717466', '支付宝', '0.00', 0, 1, 0, '0.00', '', '', 1514346379, 0, 0, NULL),
(3, '50.00', '20171227120030136890306367', 8, 'woo123', '吴丽文', 18507717466, 0, 'o83291CzkRqonKdTVSJLGhYoU98Q', '12480864311268909', '农业银行', '0.00', 0, 2, 0, '0.00', '', '', 1514347235, 0, 0, NULL),
(4, '21209.00', '20180101222552851333422241', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', 0, 1, 0, '0.00', '', '', 1514816778, 0, 0, 1515306527),
(5, '4850.00', '20180107143242256933422241', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', 0, 1, 0, '0.00', '', '[系统拒绝提现申请]id:2,admin:yalu;', 1515306773, 2, 0, NULL),
(6, '7230.00', '20180107143256404433422241', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', 0, 1, 0, '0.00', '', '[系统拒绝提现申请]id:2,admin:yalu;', 1515306782, 2, 0, NULL),
(7, '8520.00', '20180107143306951833422241', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', 0, 1, 0, '0.00', '', '[系统拒绝提现申请]id:2,admin:yalu;', 1515306790, 2, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `salary_out`
--
ALTER TABLE `salary_out`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `salary_out`
--
ALTER TABLE `salary_out`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
