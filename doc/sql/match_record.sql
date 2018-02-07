-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-02-07 14:30:59
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
-- 表的结构 `match_record`
--

CREATE TABLE `match_record` (
  `id` int(10) UNSIGNED NOT NULL,
  `match_id` int(10) UNSIGNED NOT NULL COMMENT '比赛id',
  `match` varchar(100) NOT NULL COMMENT '比赛',
  `match_schedule_id` int(11) NOT NULL DEFAULT '0' COMMENT '联赛日程id',
  `match_time` int(11) NOT NULL COMMENT '具体比赛时间',
  `team_id` int(11) NOT NULL COMMENT '战绩数据所属球队id',
  `home_team_id` int(10) UNSIGNED NOT NULL COMMENT '主队球队id',
  `home_team` varchar(50) NOT NULL COMMENT '主队球队名',
  `home_team_logo` varchar(200) NOT NULL COMMENT '主队球队logo',
  `home_team_color` varchar(50) NOT NULL COMMENT '主队球队球服颜色(中文字)',
  `home_team_colorstyle` varchar(50) NOT NULL COMMENT '主队球队颜色(英文,用于显示样式)',
  `home_score` int(11) NOT NULL DEFAULT '0' COMMENT '主队得分',
  `away_team_id` int(11) NOT NULL COMMENT '客队球队id',
  `away_team` varchar(50) NOT NULL COMMENT '客队球队名',
  `away_team_logo` varchar(200) NOT NULL COMMENT '客队球队logo',
  `away_team_color` varchar(50) NOT NULL COMMENT '客队球队球服颜色(中文字)',
  `away_team_colorstyle` varchar(50) NOT NULL COMMENT '客队球队颜色(英文,用于显示样式)',
  `away_score` int(11) NOT NULL DEFAULT '0' COMMENT '客队得分',
  `album` text COMMENT '活动相册(json格式)',
  `win_team_id` int(11) NOT NULL COMMENT '比赛胜出球队id:用于统计球队胜场数',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='比赛战绩记录';

--
-- 转存表中的数据 `match_record`
--

INSERT INTO `match_record` (`id`, `match_id`, `match`, `match_schedule_id`, `match_time`, `team_id`, `home_team_id`, `home_team`, `home_team_logo`, `home_team_color`, `home_team_colorstyle`, `home_score`, `away_team_id`, `away_team`, `away_team_logo`, `away_team_color`, `away_team_colorstyle`, `away_score`, `album`, `win_team_id`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 1, '荣光WTF vs （待定）', 0, 1517303580, 2, 2, '荣光WTF', '/uploads/images/team/2018/01/thumb_5a694dda379c1.jpg', '黑色', 'black', 0, 0, '', '', '红色', 'red', 0, '[\"/uploads/images/teammatch/2018/01/thumb_5a699ac986d5d.jpg\"]', 0, 1516851427, 1517395393, NULL),
(2, 2, 'H1 vs 学府小学 三1班', 0, 1517300220, 3, 3, 'H1', '/uploads/images/team/2018/01/thumb_5a6986888936a.jpeg', '红色', 'red', 12, -1, '学府小学 三1班', '', '蓝色', 'blue', 19, '[\"/uploads/images/teammatch/2018/01/thumb_5a7026b90a433.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026b90a5ea.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026b965624.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026b9a7495.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026b9c707d.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026ba04b46.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026ba30c01.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026ba68317.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026ba7fa5b.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026bab6708.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026bb3f300.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026bb865f2.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026bbc019b.jpeg\",\"/uploads/images/teammatch/2018/01/thumb_5a7026bbb55c9.jpeg\"]', -1, 1517298706, 1517300262, NULL),
(3, 3, 'H1 vs 大热追梦队', 0, 1522635600, 3, 3, 'H1', '/uploads/images/team/2018/01/thumb_5a6986888936a.jpeg', '红色', 'red', 0, 4, '大热追梦队', '/uploads/images/team/2018/01/thumb_5a6e90f7c056e.jpg', '', '', 0, NULL, 0, 1517314429, 1517314429, NULL),
(4, 4, 'H1篮球队 vs （待定）', 0, 1519825680, 3, 3, 'H1篮球队', '/uploads/images/team/2018/01/thumb_5a706542d537e.jpeg', '蓝色', 'blue', 0, 0, '', '', '', '', 0, NULL, 0, 1517320344, 1517320344, NULL),
(5, 5, '大热追梦队 vs （待定）', 0, 1527652500, 4, 4, '大热追梦队', '/uploads/images/team/2018/01/thumb_5a6e90f7c056e.jpg', '红色', 'red', 0, 0, '', '', '', '', 0, NULL, 0, 1517371097, 1517371097, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match_record`
--
ALTER TABLE `match_record`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `match_record`
--
ALTER TABLE `match_record`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
