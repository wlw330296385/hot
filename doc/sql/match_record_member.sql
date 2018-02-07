-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-02-07 14:31:07
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
-- 表的结构 `match_record_member`
--

CREATE TABLE `match_record_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `match_id` int(11) NOT NULL COMMENT '比赛id',
  `match` varchar(100) NOT NULL COMMENT '比赛名',
  `match_record_id` int(11) NOT NULL COMMENT '比赛战绩id',
  `team_id` int(11) NOT NULL COMMENT '球队id',
  `team` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '球队名',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '会员名',
  `avatar` varchar(200) CHARACTER SET utf8mb4 NOT NULL COMMENT '会员头像',
  `contact_tel` varchar(20) CHARACTER SET utf8mb4 NOT NULL COMMENT '会员电话',
  `student_id` int(11) NOT NULL COMMENT '学生id',
  `student` varchar(100) CHARACTER SET utf8mb4 NOT NULL COMMENT '学生名',
  `is_apply` int(11) NOT NULL DEFAULT '-1' COMMENT '报名标识:1报名|-1默认',
  `is_attend` int(11) NOT NULL DEFAULT '-1' COMMENT '出席标识:1出席|-1默认',
  `is_checkin` int(11) NOT NULL DEFAULT '-1' COMMENT '出赛登录标识:1已登录|-1默认,判断是否更新队员比赛出场次',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态:1有效|-1无效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='比赛出赛会员';

--
-- 转存表中的数据 `match_record_member`
--

INSERT INTO `match_record_member` (`id`, `match_id`, `match`, `match_record_id`, `team_id`, `team`, `member_id`, `member`, `avatar`, `contact_tel`, `student_id`, `student`, `is_apply`, `is_attend`, `is_checkin`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 1, '荣光WTF vs （待定）', 1, 2, '荣光WTF', 7, 'wayen_z', '/uploads/images/avatar/c65ece035fcfc2de5e3c38f7bb70d69834f28f25', '15018514302', 0, '', 1, -1, 1, 1, 1516853112, 1517395393, NULL),
(2, 2, 'H1 vs 学府小学 三1班', 2, 3, 'H1', 1, 'HoChen', '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', '13823599611', 0, '', 1, 1, 1, 1, 1517299445, 1517300262, NULL),
(3, 2, 'H1 vs 学府小学 三1班', 2, 3, 'H1', 6, 'legend', '/uploads/images/avatar/f5edb7fdb3aa16a70927cc43c82b4784f707f4b7', '13826505160', 0, '', -1, -1, 1, 1, 1517299624, 1517299793, NULL),
(4, 2, 'H1 vs 学府小学 三1班', 2, 3, 'H1', 24, 'Hot777', '/uploads/images/avatar/97c1acc66b14de212be90cd8d9bc5b9a76a841f0', '17727573721', 0, '', -1, 1, 1, 1, 1517299624, 1517300262, NULL),
(5, 2, 'H1 vs 学府小学 三1班', 2, 3, 'H1', 6, 'legend', '/uploads/images/avatar/f5edb7fdb3aa16a70927cc43c82b4784f707f4b7', '13826505160', 0, '', 1, 1, 1, 1, 1517300257, 1517300262, NULL),
(6, 3, 'H1 vs 大热追梦队', 3, 3, 'H1', 1, 'HoChen', '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', '13823599611', 0, '', 1, -1, -1, 1, 1517314641, 1517314641, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match_record_member`
--
ALTER TABLE `match_record_member`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `match_record_member`
--
ALTER TABLE `match_record_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
