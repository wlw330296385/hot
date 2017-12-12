-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-12 12:56:41
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
-- 转存表中的数据 `exercise`
--

INSERT INTO `exercise` (`id`, `member_id`, `member`, `camp_id`, `camp`, `exercise`, `pid`, `exercise_setion`, `exercise_detail`, `media`, `is_open`, `status`, `create_time`, `delete_time`, `update_time`) VALUES
(1, 0, '平台', 0, '平台', '热身游戏', 0, '', '', '', 0, 1, 0, NULL, 0),
(2, 0, '平台', 0, '平台', '投篮', 0, '', '', '', 1, 1, 0, NULL, 0),
(3, 0, '平台', 0, '平台', '传球', 0, '', '', '', 1, 1, 0, NULL, 0),
(4, 0, '平台', 0, '平台', '上篮', 0, '', '', '', 1, 1, 0, NULL, 0),
(5, 0, '平台', 0, '平台', '原地运球', 0, '', '', '', 1, 1, 0, NULL, 0),
(6, 0, '平台', 0, '平台', '行进间运球', 0, '', '', '', 1, 1, 0, NULL, 0),
(7, 0, '平台', 0, '平台', '基本移动技能', 0, '', '', '', 1, 1, 0, NULL, 0),
(8, 0, '平台', 0, '平台', '基本团队配合', 0, '', '', '', 1, 1, 0, NULL, 0),
(9, 0, '平台', 0, '平台', '一对一', 0, '', '', '', 1, 1, 0, NULL, 0),
(10, 0, '平台', 0, '平台', '进阶团队配合', 0, '', '', '', 1, 1, 0, NULL, 0),
(11, 0, '平台', 0, '平台', '其他', 0, '', '', '', 1, 1, 0, NULL, 0),
(12, 0, '平台', 0, '平台', '单人对墙传球', 3, '', '单人对墙传球', '', 1, 1, 1501582131, NULL, 1501582131),
(14, 0, '平台', 0, '平台', '两人原地传接球', 3, '', '两人面对面站立，原地进行双手传接球练习。作用：提高传球的准确度', '', 1, 1, 1501643275, NULL, 1501747177),
(15, 0, '平台', 0, '平台', '三人或多人同时传球练习', 3, '', '每人站一边。成三角型。间距3米。用一球原地互相来回传接球。作用：提高传接球的准确性', '', 1, 1, 1501646362, NULL, 1501660092),
(16, 0, '平台', 0, '平台', '抢尾巴（无球、运球）', 1, '', '游戏规则：每人一条绳子系在腰后当尾巴，游戏开始后，在保护自己尾巴的同时，把别人的尾巴抢走。\r\n练习作用：提高移动和摆脱能力、敏捷性、反应能力。', 'http://ou1z1q8b2.bkt.clouddn.com/2017080350ce85982cb2099a23.mp4', 1, 1, 1501743930, NULL, 1501747062),
(17, 0, '平台', 0, '平台', '雪糕筒大战（无球 、运球）', 1, '', '游戏规则：两组队员同时进行，A组负责将场地上的雪糕筒推到，B组负责扶起。练习作用：提高团队协作、移动、反应能力。', '', 1, 1, 1502267118, NULL, 1502267199);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
