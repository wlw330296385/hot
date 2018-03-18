-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-02-07 14:30:53
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
-- 表的结构 `match_history_team`
--

CREATE TABLE `match_history_team` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL COMMENT '球队team_id',
  `team` varchar(100) NOT NULL COMMENT '球队team_name',
  `opponent_team_id` int(11) NOT NULL COMMENT '对手team_id',
  `opponent_team` varchar(100) NOT NULL COMMENT '对手team_name',
  `match_num` int(11) NOT NULL DEFAULT '0' COMMENT '对战次数',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='比赛历史对手表';

--
-- 转存表中的数据 `match_history_team`
--

INSERT INTO `match_history_team` (`id`, `team_id`, `team`, `opponent_team_id`, `opponent_team`, `match_num`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 3, 'H1', -1, '学府小学 三1班', 1, 1517298706, 1517298706, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match_history_team`
--
ALTER TABLE `match_history_team`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `match_history_team`
--
ALTER TABLE `match_history_team`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
