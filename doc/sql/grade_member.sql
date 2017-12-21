-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-21 11:47:50
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
-- 表的结构 `grade_member`
--

CREATE TABLE `grade_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `grade` varchar(60) NOT NULL,
  `grade_id` int(10) NOT NULL,
  `lesson` varchar(60) NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL COMMENT '所属训练营',
  `student_id` int(10) NOT NULL,
  `student` varchar(60) NOT NULL,
  `member` varchar(60) NOT NULL COMMENT '对应会员表member',
  `member_id` int(10) NOT NULL COMMENT '对应会员表id',
  `avatar` varchar(255) NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '头像',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '废除',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `system_remarks` varchar(255) DEFAULT NULL COMMENT '系统备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '-1:离营|0:待审核|1:正常|2:退出|3:被开除|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='班级-会员关联表';

--
-- 转存表中的数据 `grade_member`
--

INSERT INTO `grade_member` (`id`, `grade`, `grade_id`, `lesson`, `lesson_id`, `camp_id`, `camp`, `student_id`, `student`, `member`, `member_id`, `avatar`, `type`, `remarks`, `system_remarks`, `status`, `create_time`, `delete_time`, `update_time`) VALUES
(1, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 2, '陈小准', 'legend', 6, '', 2, '', NULL, 1, 1506569500, NULL, 0),
(2, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 2, '陈小准', 'legend', 6, '', 2, '', NULL, 1, 1506569572, NULL, 0),
(3, '猴塞雷私教班', 3, '猴塞雷课程', 11, 3, '猴赛雷训练营', 3, 'Easychen ', 'Greeny', 13, '', 2, '', NULL, 1, 1507355231, NULL, 1508839950),
(4, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 1, '123', 'woo123', 8, '', 2, '', NULL, 1, 1507518508, NULL, 1507518508),
(5, '', 0, '大热幼儿班', 1, 1, '大热体适能中心', 1, '123', 'woo123', 8, '/static/default/avatar.png', 2, '', NULL, 1, 1507537926, NULL, 1507537926),
(6, '', 0, '超级射手班', 6, 4, '准行者训练营', 1, '123', 'woo123', 8, '/static/default/avatar.png', 2, '', NULL, 1, 1507539335, NULL, 1507539335),
(7, '猴塞雷私教班', 3, '猴塞雷课程', 11, 3, '猴赛雷训练营', 1, '123', 'woo123', 8, '/static/default/avatar.png', 2, '', NULL, 1, 1507540816, NULL, 1508839950),
(8, '陈班豆丁', 2, '小学低年级初级班', 2, 3, '猴赛雷训练营', 1, '123', 'woo123', 8, '/static/default/avatar.png', 1, '', NULL, 1, 1507542080, NULL, 1508472456),
(9, '测试班', 4, '超级控球手', 3, 4, '准行者训练营', 1, '123', 'woo123', 8, '/static/default/avatar.png', 2, '', NULL, 1, 1507545041, NULL, 1509090703),
(10, '', 0, '校园兴趣班', 12, 3, '猴赛雷训练营', 4, '小霖', 'weilin666', 4, '/static/default/avatar.png', 1, '', NULL, 1, 1507630199, NULL, 1507630199),
(12, '周日北头高年级初中基础', 29, '周日北头高年级初中班', 13, 9, '大热篮球俱乐部', 5, '张晨儒', '13537781797', 15, '/static/default/avatar.png', 1, '', NULL, 1, 1507728830, NULL, 1509424032),
(13, '测试班', 4, '超级控球手', 3, 4, '准行者训练营', 6, '刘嘉', '123abc', 5, '/static/default/avatar.png', 2, '', NULL, 1, 1507880297, NULL, 1509085011),
(14, '1027班', 25, '荣光篮球强化', 25, 5, '荣光训练营', 7, '儿童劫', 'wl', 10, '/static/default/avatar.png', 2, '', NULL, 1, 1507947073, NULL, 1509180516),
(15, '', 0, '校园兴趣班', 12, 3, '猴赛雷训练营', 1, '123', 'woo123', 8, '/static/default/avatar.png', 1, '', NULL, 1, 1508063597, NULL, 1508063597),
(16, '周六北头前海五年级', 26, '大热高级班', 13, 9, '大热篮球俱乐部', 8, '钟欣志', '钟欣志', 23, '/static/default/avatar.png', 1, '系统插入', NULL, 1, 1508141658, NULL, 1509423753),
(17, '周六北头进阶班', 28, '大热高级班', 13, 9, '大热篮球俱乐部', 9, '罗翔宇', '罗翔宇', 25, '/static/default/avatar.png', 1, '系统插入', NULL, 1, 1508141658, NULL, 1509423900),
(19, '', 0, '超级射手班', 6, 4, '准行者训练营', 11, '陈佳佑', 'yanyan', 33, '/static/default/avatar.png', 1, '', NULL, 1, 1508207328, NULL, 1508207328),
(20, '', 0, '周六上午十点低年级班', 4, 2, '大热前海训练营', 13, '邓赖迪', '邓赖迪', 22, '/static/default/avatar.png', 1, '', NULL, 1, 1508242055, NULL, 1508242055),
(21, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 14, '陈承铭', '陈承铭', 26, '/static/default/avatar.png', 1, '系统插入,时间2017年10月18日17:40:19', '20171102修改学员剩余课时', 1, 1508318976, NULL, 1509608798),
(22, '猴塞雷私教班', 3, '猴塞雷课程', 11, 3, '猴赛雷训练营', 6, '刘嘉', '123abc', 5, 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYIDwRM5lic1WWW9mKWFS1a1fYeA/0', 2, '', NULL, 1, 1508396331, NULL, 1508839950),
(23, '', 0, '校园兴趣班', 12, 3, '猴赛雷训练营', 6, '刘嘉', '123abc', 5, 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYIDwRM5lic1WWW9mKWFS1a1fYeA/0', 2, '', NULL, 1, 1508396925, NULL, 1508747575),
(24, '', 0, '校园兴趣班', 12, 3, '猴赛雷训练营', 2, '陈小准', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', NULL, 1, 1508489473, NULL, 1508747575),
(25, '前海小学', 23, '前海小学', 31, 15, '钟声训练营', 15, '陈润宏', '陈润宏', 43, 'https://wx.qlogo.cn/mmopen/vi_32/wCFb3b7CBRJSuXQazfF7N0GIfuhF53JRlkVEq2Z2pUgIMraJI2iaWwCONHk7nkJibrUQiaEyU8yrPxianhMIyuArdg/0', 1, '', '20171102:北大附小改成前海小学', 1, 1508554704, NULL, 1509608798),
(26, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 16, '李润弘', '李润弘', 42, 'https://wx.qlogo.cn/mmopen/vi_32/icD3j8Uhe4xOLJS1zichGLY3rfpJAI4Efd95vMQxlBhSABPWicw4tOHsyY2rnPVAFDbAohTvsMAxoLIo49bA33Z1g/0', 1, '', '20171102修改学员剩余课时', 1, 1508554789, NULL, 1509608799),
(27, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 17, '郑肖杰', '郑肖杰', 48, 'https://wx.qlogo.cn/mmopen/vi_32/8B6CScn6mZribr9bTI1RhDEiaQvCtKUKp9BmL1VLoamZWKFF3mHqfOOw2zN5gOIFCBpwsycFWFnr6SulEH2hRLBA/0', 1, '', NULL, 1, 1508639991, NULL, 1508992187),
(28, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 18, '黄浩', '黄浩', 49, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIn1c0h4Xcn8dISicib3c5qRUsmhvibqvQMY7q3qFUSVw36nw1XW7GEQx1nVkkWQyEyGbtr6JMuBOfyg/0', 1, '', NULL, 1, 1508658059, NULL, 1508991944),
(29, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 19, '吴师隽', '吴师隽', 52, 'https://wx.qlogo.cn/mmopen/vi_32/NYp0qdFEpicQ36DW8ZpibPCSVAf3NSCNJgwbgKerkcXV3wlXwUdn0XfgBf26eIZ4tqibxT5ScU6el8A1bouRwibcJg/0', 1, '', NULL, 1, 1508661866, NULL, 1508991944),
(30, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 20, '唐轩衡', '唐轩衡', 55, 'https://wx.qlogo.cn/mmopen/vi_32/VVyUyM6Q3vHB0kvA47iafepgr2L2vx8nvxzeSIKqJQLGz6qA9RWloXBmvCic1r4pD1chaLOLck0y4r3aibFmEE1YQ/0', 1, '', NULL, 1, 1508676522, NULL, 1508992187),
(31, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 22, '郑皓畅', '郑皓畅', 56, 'https://wx.qlogo.cn/mmopen/vi_32/6zNQeeicR57x1lcicY9mgX2MBCibf3OkicIKIvEcq1Ec7ibFPRFkEtg8nKeBoiaNfrwoGmvu9Wt5BWo9HicxroYqjRZsw/0', 1, '', NULL, 1, 1508723297, NULL, 1508992187),
(32, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 21, '陈高翔', '陈高翔', 59, 'https://wx.qlogo.cn/mmopen/vi_32/yzvxOetibI0IK3Jjwxb8AhFLpiaf8sEqjkhPwXgtr0JRXWJNIVDBvT6QjblpFABBKGCvGryia5xz20zwzEg5BZ6dg/0', 1, '', NULL, 1, 1508723329, NULL, 1508992187),
(33, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 25, '战奕名', '战奕名', 51, 'https://wx.qlogo.cn/mmopen/vi_32/v4IpFsmBcCwGN9D1SzfmfahDia8p8l3saE3DbWnmOY2HCClXCmfibzzw3H3hcnbXAAkcwQH6icJxiabSc03HnXSLlA/0', 1, '', NULL, 1, 1508724642, NULL, 1508992187),
(34, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 26, '李语辰', '李语辰', 46, 'https://wx.qlogo.cn/mmopen/vi_32/JVWE6PQ990A8KoicXXxCEzKP2trTcWSkBsW16ibaYbTZHSTA4mOy410wA2u9uuxUB0FiavLiaBkicKCp9icc9Rgry7HQ/0', 1, '', NULL, 1, 1508725787, NULL, 1508992187),
(35, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 27, '张毓楠', '张毓楠', 50, 'https://wx.qlogo.cn/mmopen/vi_32/ywnQfcMqe2uC9KP2fDr6QorLMk8FFkIL3IUpfJn7D8707CEIfcUwLEOLGf85A0C9bY4a29ZkcfkGa3RwSKoMbw/0', 1, '', NULL, 1, 1508726076, NULL, 1508991944),
(36, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 28, '王钰龙', '王钰龙', 60, 'https://wx.qlogo.cn/mmopen/vi_32/mpqiaCLKTSkHXZbs2GqFnjoflrkMib2j49z5yM8VHDmmUSicHZI5iak2Tia6ykX7tXT8TOBYB2v9UaYmnJ99Z0FCO0g/0', 1, '', NULL, 1, 1508726144, NULL, 1508992187),
(37, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 29, '刘宇恒', '刘宇恒', 62, 'https://wx.qlogo.cn/mmopen/vi_32/dg5BzBbk6ialKxBfoWtI9iayIQS6b5pG0QF1ib4YiauZics9fBRksgtWibAcHYEGiaJbjOR4W0jOgGJIb6LAwiapjEkkbg/0', 1, '', NULL, 1, 1508729343, NULL, 1508992187),
(38, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 30, '黄子诺', 'leonhuang', 63, 'https://wx.qlogo.cn/mmopen/vi_32/PH3lR9dDe7o1dzyQIgkpkLhkOchMTwEEqQ3TI2oKPmxGNOKbgicYAV4wORoMLw2NGBaNDjVMv8x38BjJRibThTzg/0', 1, '', NULL, 1, 1508730453, NULL, 1508991708),
(39, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 33, '梁峻玮', '20101119', 66, 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Du6wQajIibtJa0SkWurB9LkfK1vR4BQiaZ14GnibibNdUdOG0iaQlVvcthLcx7Qf0mKBBLw/0', 1, '', NULL, 1, 1508732407, NULL, 1508991708),
(40, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 34, '刘一凡', 'gaojun', 67, 'https://wx.qlogo.cn/mmopen/vi_32/x7dO3qq2JzUkwK79rS0ZmwrnficUG7mB9bAUOQ7lB52dY5uhUMgBFPQoAsY5w1LWrzYwDROVSKrYoqmq6qgYrcg/0', 1, '', NULL, 1, 1508735154, NULL, 1508991708),
(41, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 35, '万宇宸', '万宇宸', 61, 'https://wx.qlogo.cn/mmopen/vi_32/pnKFC33CDdnArcQ0ONDFVdlQ1yF6aewh99xgKW3G72iaruRr1oGTIwV8gfpfptb4VpBdicrZ9pJLwpib50cYrfVVw/0', 1, '', NULL, 1, 1508737748, NULL, 1508992187),
(42, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 36, '邱仁鹏', 'SZQIUJB', 73, 'https://wx.qlogo.cn/mmopen/vi_32/oBJMukfMx9mAfOFLL6oILN4zz1F39lUDnibK34DTlPq3YUq2P7gWk4muj1cDFKMQLlN5ypREzibVJO4yKSEUK62w/0', 1, '', NULL, 1, 1508766196, NULL, 1508992187),
(43, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 38, '林需睦', '13823181560', 74, 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqicTFZcNkXiaVqLpNeiapVYiaItQ1hGcic0s9BCKqx2aDYVMSD9KNkhuVmtZyvCXASgk1I6jH9LbMw4HQ/0', 1, '', NULL, 1, 1508766362, NULL, 1508991708),
(44, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 39, '饶滨', '饶滨', 58, 'https://wx.qlogo.cn/mmopen/vi_32/3q4wOibh9nZPekaEh1mPpULmJARKuuXRphK7Mak1kTjCNNIibNEjNicoEVtmJLT9G7kjoNZ6vllcLteP8vibyXiaj0A/0', 1, '', NULL, 1, 1508770993, NULL, 1508992187),
(45, '', 0, 'AKcross课程', 38, 13, 'AKcross训练营', 41, '游逸朗', 'Youboy806', 79, 'https://wx.qlogo.cn/mmopen/vi_32/LMPP1EaHUlWoor4A7ibKMl1XM80TcezRI5GgwThYwOHPybVktqd8QicgtYr8svs4LPxP0bmSpszQtricUuCGPtuFg/0', 1, '', NULL, 1, 1508831426, NULL, 1508831426),
(46, '周六北头前海五年级', 26, '高年级班', 13, 9, '大热篮球俱乐部', 42, '陈宛杭', 'kiko', 80, 'https://wx.qlogo.cn/mmopen/vi_32/zocbwtq7yDlo6zSBZ0jmSgpaHaFWmAotUTmzHopaB1Vl8DVWP9Gdd7U37xhdUkg30Z6HE6BzIBKGqEJBRDQOLA/0', 1, '', NULL, 1, 1508849731, NULL, 1509422313),
(47, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 43, '邓粤天', '13927482132', 82, 'https://wx.qlogo.cn/mmhead/jJSbu4Te5ib9GgS8EBYzj9DGPl5G68qqDVadUWdDKYdNwEibDBUlFaPA/0', 1, '', NULL, 1, 1508850519, NULL, 1508991708),
(48, '1027班', 25, '荣光篮球强化', 25, 5, '荣光训练营', 52, '苏楠楠', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', NULL, 1, 1508985553, NULL, 1509089950),
(49, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 56, '姚定希', '姚定希', 86, 'https://wx.qlogo.cn/mmhead/BfRL3E0G1pdy5s3m2OtzHEbJ0tv6PFPzUu34m3zQ3XzzmlMkMgGMOg/0', 1, '', NULL, 1, 1508986351, NULL, 1508991708),
(50, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 57, '梁懿', '梁懿', 83, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIZILv4jZfYyLDTSDRic2TicWv1Lqsy7ibgV1LK3PiaycF11vJQ2Ud4PrDa0XvcQEhdaEAEkb2feNbtCQ/0', 1, '', NULL, 1, 1508986588, NULL, 1508992187),
(81, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 93, '张腾月', '腾月', 103, '/static/default/avatar.png', 1, '', '系统插入,时间2017年11月3日16:31:01', 1, 1509697785, NULL, 1509699522),
(52, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 40, '陈昊阳', 'cjwcyc', 76, 'https://wx.qlogo.cn/mmopen/vi_32/GCNUn1n4CPiaMuVncIvb0u3mCyCNIYOQmjMVuSx5SrGOPe94lWMticoCRn3G2qry302FPPTkcichHEpKrzwIb1TrA/0', 1, '', NULL, 1, 1508989728, NULL, 1508991944),
(53, '0', 0, '荣光篮球强化', 25, 5, '荣光训练营', 46, '小woo', 'woo123', 8, 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1, '', NULL, 1, 1508992654, NULL, 1509089966),
(54, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 62, '周子杰', 'rebeccazhangly', 81, 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Dribia5ZQu19qPDlO8LQuwYfbEKvkc4np2NicicpECusbLsAYMLtVn4pT8IcyBibvMnjL6w/0', 1, '', NULL, 1, 1509001966, NULL, 1509018809),
(55, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 63, '余永康', '余永康', 84, 'https://wx.qlogo.cn/mmopen/vi_32/AvTOBqK5D0azFkS8BVibFucZyG9z9rLicQYL7FkBl6QicS6z4mdNejuvU4Qial8z9wOfInP4anVMAK7sAeoX5A1tOg/0', 1, '', NULL, 1, 1509006276, NULL, 1509009518),
(56, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 66, '饶宏宇', '饶宏宇', 39, 'https://wx.qlogo.cn/mmopen/vi_32/QiaJBRJFj5Xt3S5WluEumvf6C68fm3U1NBVpSlicePadW44QHt3aDljkr1iaYYZDH2LlXibQfFIlp2oNaxX6dHAasg/0', 1, '', NULL, 1, 1509008230, NULL, 1509009518),
(57, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 67, '朱涛', '朱涛', 87, 'https://wx.qlogo.cn/mmhead/uchmtWQh7iaqm9z1QucKESYwDiasve3glVvHvDEEEvZmEBJrp26SDrcA/0', 1, '', NULL, 1, 1509009392, NULL, 1509009518),
(58, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 31, '蒋清奕', '蒋清奕', 65, '/static/default/avatar.png', 1, '系统插入,时间2017年10月27日10:58:40', NULL, 1, 1508774400, NULL, 1509073844),
(59, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 71, '李浚睿', 'Jerry', 75, 'https://wx.qlogo.cn/mmopen/vi_32/7g6icshVrInKsnnzvMpm7jBVXywRsKHnITNpDYTVPXYEWaYh1sDHPRU2z5YIIJdMvNM9HWOPMKyiakHiaibM9lY6sA/0', 1, '', NULL, 1, 1509079444, NULL, 1509079668),
(60, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 69, '李泓', 'Li hong', 89, '/static/default/avatar.png', 1, '系统插入,时间2017年10月27日14:16:02', NULL, 1, 1508947200, NULL, 1509090474),
(61, '北大附小周三五', 21, '北大附小一年级', 36, 15, '钟声训练营', 73, '侯皓轩', '小苹果', 91, 'https://wx.qlogo.cn/mmhead/wbKdib81ny6ibpPLZicROqqicQ7l1PrrmPwJmSpKrKG0FzztjmkibjApnwQ/0', 1, '', NULL, 1, 1509086650, NULL, 1509086840),
(62, '', 0, '荣光篮球强化', 25, 5, '荣光训练营', 74, '新学生', 'legend', 6, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', NULL, 1, 1509091585, NULL, 1509091585),
(64, '', 0, '平台示例请勿购买', 37, 4, '准行者训练营', 51, '荣', 'wayen', 77, '/0', 1, '', NULL, 1, 1509176780, NULL, 1509176780),
(65, '周六北头晚初中班', 27, '大热常规班', 13, 9, '大热篮球俱乐部', 75, '薛子豪', '薛子豪', 92, 'https://wx.qlogo.cn/mmhead/78EkX665csCzfpNaaBSvfy1JpmicTLfoh2FtiaNSKK6N5PYicTOeK8wjA/0', 1, '', NULL, 1, 1509180982, NULL, 1509423702),
(66, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 76, '张致远', '张致远', 93, 'https://wx.qlogo.cn/mmhead/C6nnRGnPbvwxhMnBf6aSBRKAcLpoOuhibqOodQsrO0abWLLVkRQrouQ/0', 1, '', NULL, 1, 1509191189, NULL, 1509193713),
(67, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 77, '王秉政', '王秉政', 94, 'https://wx.qlogo.cn/mmhead/sTJptKvBQLLibnLPq727HT4qqfl6GE7YibCk1iaJdbBOM7IpfWgIdROVg/0', 1, '', NULL, 1, 1509194924, NULL, 1509195346),
(68, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 70, '李小凡', 'lixiaofang', 90, 'https://wx.qlogo.cn/mmhead/Ib5852jAyb860z7fQb9L9kCSb5ZU8QicSwlB0MXFXJxAz3Bqib1iaGpsw/0', 1, '', NULL, 1, 1509237476, NULL, 1509248257),
(69, '松坪小学兰球班', 24, '松坪小学', 32, 15, '钟声训练营', 78, '邓俊伟', '邓俊伟', 95, 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM7fLJDnHuiaObafTXdfngPmhmgU8Oibic4DxUWECOq3RZ5TA/0', 1, '', NULL, 1, 1509246244, NULL, 1509248257),
(70, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 79, '方慧妍', 'FANGHUIYAN', 88, 'https://wx.qlogo.cn/mmhead/bVy2VQVTWzbtVlldXFcWqic1ib9ZZa0fHvPloPhBgA6SCicFgUCfqnibWw/0', 1, '', NULL, 1, 1509254479, NULL, 1509256861),
(71, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 80, '朱喆熙', '朱喆熙', 96, 'https://wx.qlogo.cn/mmhead/ZqDaDiccbgkhqudKfypGjYLEng5P9JSdNc6WfGichTYDY76OFtrtyiaZg/0', 1, '', NULL, 1, 1509271845, NULL, 1509272122),
(72, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 81, '周浩楠', '周浩楠、周宇希、周凯炀', 97, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, '', NULL, 1, 1509271960, NULL, 1509272122),
(73, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 82, '周宇希', '周浩楠、周宇希、周凯炀', 97, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, '', NULL, 1, 1509272077, NULL, 1509272122),
(74, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 83, '周凯炀', '周浩楠、周宇希、周凯炀', 97, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, '', NULL, 1, 1509272180, NULL, 1509278237),
(75, '前海小学兰球班', 23, '前海小学', 31, 15, '钟声训练营', 84, '王奕唐', 'Miya', 98, 'https://wx.qlogo.cn/mmhead/FrdAUicrPIibfdwVLEWdXjfszf6JtqbichNGmgX52g519jUT3AkWJkF5A/0', 1, '', NULL, 1, 1509283014, NULL, 1509283135),
(76, '', 0, 'AKcross课程', 38, 13, 'AKcross训练营', 86, '李李喆', 'Clement Lee', 100, 'https://wx.qlogo.cn/mmhead/WAibKjHvK5nGwOjqMd7aj2uwibgicK2CyeL73tEGSyCAaTtib8piaFODHRg/0', 1, '', NULL, 1, 1509433128, NULL, 1509433128),
(77, '', 0, '平台示例请勿购买', 37, 4, '准行者训练营', 46, '小woo', 'woo123', 8, '/static/default/avatar.png', 1, '', NULL, 1, 1509445644, NULL, 1509445644),
(78, '', 0, '大热常规班', 13, 9, '大热篮球俱乐部', 90, '梁浩然', 'LIANG', 101, '/static/default/avatar.png', 1, '', NULL, 1, 1509619809, NULL, 1509619809),
(79, '', 0, '大热常规班', 13, 9, '大热篮球俱乐部', 91, '梁浩峰', 'LIANG', 101, '/static/default/avatar.png', 1, '', NULL, 1, 1509619941, NULL, 1509619941),
(80, '石厦学校兰球队', 22, '石厦学校兰球队', 29, 15, '钟声训练营', 92, '张广涵', '张广涵', 102, '/static/default/avatar.png', 1, '', NULL, 1, 1509683459, NULL, 1509685850),
(82, '', 0, '校园兴趣班', 12, 3, '猴赛雷训练营', 89, '测试1', 'legend', 6, '/static/default/avatar.png', 1, '', NULL, 1, 1509700436, NULL, 1509700436),
(83, '南头城小学篮球班', 30, '南头城小学', 30, 15, '钟声训练营', 94, '赵俊豪', '赵俊豪', 104, '/static/default/avatar.png', 1, '', NULL, 1, 1509703640, NULL, 1509705361),
(84, '', 0, '大热常规班', 13, 9, '大热篮球俱乐部', 95, '曾跃阳', '30988232', 105, '/static/default/avatar.png', 1, '', NULL, 1, 1509720686, NULL, 1509720686),
(85, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 96, '陈予喆', 'hou1298280', 106, '/static/default/avatar.png', 1, '', NULL, 1, 1509782830, NULL, 1509782830),
(86, '', 0, '大热常规班', 13, 9, '大热篮球俱乐部', 97, '黄嘉荣', 'HANA', 107, '/static/default/avatar.png', 1, '', NULL, 1, 1509783164, NULL, 1509783164),
(87, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 98, '苏祖威', '061683', 108, '/static/default/avatar.png', 1, '', NULL, 1, 1509783379, NULL, 1509783379),
(88, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 99, '周子祺', 'lily', 109, '/static/default/avatar.png', 1, '', NULL, 1, 1509784749, NULL, 1509784749),
(89, '', 0, '大热常规班', 13, 9, '大热篮球俱乐部', 100, '关乐耀', '关乐耀', 110, '/static/default/avatar.png', 1, '', NULL, 1, 1509784965, NULL, 1509784965),
(90, '', 0, '大热常规班', 13, 9, '大热篮球俱乐部', 102, '张益凯', '张益凯', 111, '/static/default/avatar.png', 1, '', NULL, 1, 1509786985, NULL, 1509786985),
(91, '', 0, '大热常规班', 13, 9, '大热篮球俱乐部', 103, '陈嘉航', 'chenjiahang', 112, '/static/default/avatar.png', 1, '', NULL, 1, 1509787853, NULL, 1509787853),
(92, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 104, '王浩丁', '王浩丁', 113, '/static/default/avatar.png', 1, '', NULL, 1, 1509844432, NULL, 1509844432),
(93, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 105, '颜若宸', '颜若宸', 114, '/static/default/avatar.png', 1, '', NULL, 1, 1509845658, NULL, 1509845658),
(94, '', 0, '大热常规班', 13, 9, '大热篮球俱乐部', 106, '熊天华', '熊天华', 115, '/static/default/avatar.png', 1, '', NULL, 1, 1509856196, NULL, 1509856196),
(95, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 107, '曾子航', '13670022780', 116, '/static/default/avatar.png', 1, '', NULL, 1, 1509871789, NULL, 1509871789),
(96, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 108, '王瑞翔', '王少华', 117, '/static/default/avatar.png', 1, '', NULL, 1, 1509943670, NULL, 1509943670),
(97, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 109, '黄子杰', '黄子杰', 118, '/static/default/avatar.png', 1, '', NULL, 1, 1509943739, NULL, 1509943739),
(98, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 110, '郭懋增', '13662248558', 119, '/static/default/avatar.png', 1, '', NULL, 1, 1509970166, NULL, 1509970166),
(99, '', 0, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 111, '蔡佳烨', '6222355892320034', 120, '/static/default/avatar.png', 1, '', NULL, 1, 1509985530, NULL, 1509985530),
(100, '测试体', 31, '荣光篮球强化', 25, 5, '荣光训练营', 7, '儿童劫', 'wl', 10, '/static/default/avatar.png', 1, '', NULL, 1, 1510195422, 1510195469, 1510195476),
(101, '测试体', 31, '荣光篮球强化', 25, 5, '荣光训练营', 46, '小woo', 'woo123', 8, '/static/default/avatar.png', 1, '', NULL, 1, 1510195422, NULL, 1510195422),
(102, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 120, '关楠萧', '王少华', 117, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(103, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 116, '黄俊豪', '黄俊豪', 124, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(104, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 119, '杨涵', '6222024000065498186', 126, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(105, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 118, '邵冠霖', '6222024000065498186', 126, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(106, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 115, '王孝煊', '065385', 123, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(107, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 96, '陈予喆', 'hou1298280', 106, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(108, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 98, '苏祖威', '061683', 108, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(109, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 99, '周子祺', 'lily', 109, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(110, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 104, '王浩丁', '王浩丁', 113, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(111, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 105, '颜若宸', '颜若宸', 114, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(112, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 107, '曾子航', '13670022780', 116, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(113, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 108, '王瑞翔', '王少华', 117, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(114, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 109, '黄子杰', '黄子杰', 118, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(115, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 110, '郭懋增', '13662248558', 119, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(116, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 111, '蔡佳烨', '6222355892320034', 120, '/static/default/avatar.png', 1, '', NULL, 1, 1510326418, NULL, 1510326418),
(117, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 121, '袁帅', '6222024000065498186', 126, '/static/default/avatar.png', 1, '', NULL, 1, 1510369963, NULL, 1510369963),
(118, '天才班', 12, '平台示例请勿购买', 37, 4, '准行者训练营', 12, '娟', 'HoChen', 1, '/static/default/avatar.png', 1, '', NULL, 1, 1510383975, NULL, 1510383975),
(119, '天才班', 12, '平台示例请勿购买', 37, 4, '准行者训练营', 114, '毛毛', '1234', 122, '/static/default/avatar.png', 1, '', NULL, 1, 1510383975, NULL, 1510383975),
(120, '龙岗篮球训练营', 32, '龙岗民警子女篮球课程', 15, 9, '大热篮球俱乐部', 117, '李鸣轩', '13825243733', 125, '/static/default/avatar.png', 1, '', NULL, 1, 1510392984, NULL, 1510392984),
(121, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 122, '张旺鹏', '军歌', 128, '/static/default/avatar.png', 1, '', NULL, 1, 1510392984, NULL, 1510392984),
(122, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 165, '骆九宇', 'luojiuyu', 172, '/static/default/avatar.png', 1, '', NULL, 1, 1511249532, NULL, 1511249532),
(123, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 147, '杨耀斌', 'Yrb801129', 153, '/static/default/avatar.png', 1, '', NULL, 1, 1511249532, NULL, 1511249532),
(124, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 135, '林嘉豪', '鲁秋娟¹⁵⁹²⁰⁰⁸⁵⁹⁶⁰', 141, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(125, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 139, '毕宸君', 'Taily', 145, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(126, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 128, '刘进哲', '刘欣洋', 134, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(127, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 138, '钟铭楷', '丹佛儿', 144, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(128, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 137, '谢睿轩', '谢睿轩Ryan', 143, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(129, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 141, '张哲栋', '静', 147, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(130, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 127, '吴奇朗', '晨曦', 133, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(131, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 133, '杨灿', '杨灿13662559960', 139, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(132, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 134, '袁梓钦', '袁梓钦YZQ', 140, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, NULL, 1511249692),
(133, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 144, '肖振兴', '中国太保惠霞', 150, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, 1511857169, 1511857294),
(134, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 143, '方泓锴', 'fanghk', 149, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, 1511857169, 1511857294),
(135, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 140, '覃诗翔', '言覃多多', 146, '/static/default/avatar.png', 1, '', NULL, 1, 1511249692, 1511857169, 1511857294),
(136, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 159, '蓝炫皓', '飘', 165, '/static/default/avatar.png', 1, '', NULL, 1, 1511249835, NULL, 1511249835),
(137, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 158, '周尹木', 'zhouyinmu', 164, '/static/default/avatar.png', 1, '', NULL, 1, 1511249835, NULL, 1511249835),
(138, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 157, '刘秉松', 'yolanda传奇', 163, '/static/default/avatar.png', 1, '', NULL, 1, 1511249835, NULL, 1511249835),
(139, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 156, '唐愈翔', '龙船????唐力', 162, '/static/default/avatar.png', 1, '', NULL, 1, 1511249835, NULL, 1511249835),
(140, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 154, '赖德瑞', '张春丽＆', 160, '/static/default/avatar.png', 1, '', NULL, 1, 1511249835, NULL, 1511249835),
(141, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 153, '文经纬', 'Lisa Lee(李建平)', 159, '/static/default/avatar.png', 1, '', NULL, 1, 1511249835, NULL, 1511249835),
(142, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 95, '曾跃阳', '30988232', 105, '/static/default/avatar.png', 1, '', NULL, 1, 1511249835, NULL, 1511249835),
(143, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 97, '黄嘉荣', 'HANA', 107, '/static/default/avatar.png', 1, '', NULL, 1, 1511249835, NULL, 1511249835),
(144, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 151, '刘庭彦', '19782174', 157, '/static/default/avatar.png', 1, '', NULL, 1, 1511249871, NULL, 1511249871),
(145, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 155, '李祖帆', '浪花', 161, '/static/default/avatar.png', 1, '', NULL, 1, 1511249871, NULL, 1511249871),
(146, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 131, '吴靖宇', '吴靖宇wjy', 137, '/static/default/avatar.png', 1, '', NULL, 1, 1511249992, NULL, 1511249992),
(147, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 130, '李正昊', '18923856665', 136, '/static/default/avatar.png', 1, '', NULL, 1, 1511249992, NULL, 1511249992),
(148, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 145, '欧阳宇航', '欧阳宇航的外公', 151, '/static/default/avatar.png', 1, '', NULL, 1, 1511249992, NULL, 1511249992),
(149, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 143, '方泓锴', 'fanghk', 149, '/static/default/avatar.png', 1, '', NULL, 1, 1511249992, NULL, 1511249992),
(150, '周六鼎太低年级', 34, '大热常规班', 13, 9, '大热篮球俱乐部', 142, '谢欣桦', 'wiya', 148, '/static/default/avatar.png', 1, '', NULL, 1, 1511249992, NULL, 1511249992),
(151, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 146, '林子骞', 'Jack123', 152, '/static/default/avatar.png', 1, '', NULL, 1, 1511250091, NULL, 1511250091),
(152, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 125, '刘政翰', 'Dorothy', 131, '/static/default/avatar.png', 1, '', NULL, 1, 1511250091, NULL, 1511250091),
(153, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 136, '卢宇璠', '卢盛良', 142, '/static/default/avatar.png', 1, '', NULL, 1, 1511250091, NULL, 1511250091),
(154, '周六北头中高年级班', 35, '大热常规班', 13, 9, '大热篮球俱乐部', 106, '熊天华', '熊天华', 115, '/static/default/avatar.png', 1, '', NULL, 1, 1511250091, NULL, 1511250091),
(155, '南外周三五班', 36, 'AKcross课程', 38, 13, 'AKcross训练营', 160, '田家福', '雪', 166, '/static/default/avatar.png', 1, '', NULL, 1, 1511579836, NULL, 1511579836),
(156, '南外周三五班', 36, 'AKcross课程', 38, 13, 'AKcross训练营', 41, '游逸朗', 'Youboy806', 79, '/static/default/avatar.png', 1, '', NULL, 1, 1511579836, NULL, 1511579836),
(157, '南外周三五班', 36, 'AKcross课程', 38, 13, 'AKcross训练营', 86, '李李喆', 'Clement Lee', 100, '/static/default/avatar.png', 1, '', NULL, 1, 1511579836, NULL, 1511579836),
(158, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 171, '李闻韬', 'liwentao', 178, '/static/default/avatar.png', 1, '', NULL, 1, 1511857294, NULL, 1511857294),
(159, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 169, '吴贻然', 'ൠ杨ྉ子ྉൠ', 176, '/static/default/avatar.png', 1, '', NULL, 1, 1511857294, NULL, 1511857294),
(160, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 166, '陈智斌', '????✨Mandy*????', 173, '/static/default/avatar.png', 1, '', NULL, 1, 1511857294, NULL, 1511857294),
(161, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 150, '吴宇昊', 'victor', 156, '/static/default/avatar.png', 1, '', NULL, 1, 1511857294, NULL, 1511857294),
(162, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 100, '关乐耀', '关乐耀', 110, '/static/default/avatar.png', 1, '', NULL, 1, 1511857294, NULL, 1511857294),
(163, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 129, '饶鹏轩', 'bemyself', 135, '/static/default/avatar.png', 1, '', NULL, 1, 1511857739, NULL, 1511857739),
(164, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 102, '张益凯', '张益凯', 111, '/static/default/avatar.png', 1, '', NULL, 1, 1511857739, NULL, 1511857739),
(165, '龙岗篮球训练营', 32, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 152, '刘永锋', '风格独特见解', 158, '/static/default/avatar.png', 1, '', NULL, 1, 1511947995, NULL, 1511947995),
(166, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 165, '骆九宇', 'luojiuyu', 172, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(167, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 120, '关楠萧', '王少华', 117, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(168, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 116, '黄俊豪', '黄俊豪', 124, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(169, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 119, '杨涵', '6222024000065498186', 126, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(170, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 115, '王孝煊', '065385', 123, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(171, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 96, '陈予喆', 'hou1298280', 106, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(172, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 104, '王浩丁', '王浩丁', 113, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(173, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 105, '颜若宸', '颜若宸', 114, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(174, '龙岗训练营高年级课程', 37, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 108, '王瑞翔', '王少华', 117, '/static/default/avatar.png', 1, '', NULL, 1, 1512029865, NULL, 1512029865),
(175, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 152, '刘永锋', '风格独特见解', 158, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(176, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 147, '杨耀斌', 'Yrb801129', 153, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(177, '龙岗训练营低年级班', 38, '龙岗民警子女篮球课程', 15, 9, '大热篮球俱乐部', 117, '李鸣轩', '13825243733', 125, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(178, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 122, '张旺鹏', '军歌', 128, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(179, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 121, '袁帅', '6222024000065498186', 126, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(180, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 118, '邵冠霖', '6222024000065498186', 126, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(181, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 98, '苏祖威', '061683', 108, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(182, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 99, '周子祺', 'lily', 109, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(183, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 107, '曾子航', '13670022780', 116, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(184, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 109, '黄子杰', '黄子杰', 118, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(185, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 110, '郭懋增', '13662248558', 119, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(186, '龙岗训练营低年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 111, '蔡佳烨', '6222355892320034', 120, '/static/default/avatar.png', 1, '', NULL, 1, 1512030032, NULL, 1512030032),
(187, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 101, '哔哔哔', 'MirandaXian', 14, '/static/default/avatar.png', 1, '', NULL, 1, 1513744563, NULL, 1513744563),
(188, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 4, '小霖', 'weilin666', 4, '/static/default/avatar.png', 1, '', NULL, 1, 1513744563, NULL, 1513744563),
(189, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 223, '高燕', 'GaoYan', 9, '/static/default/avatar.png', 1, '', NULL, 1, 1513744563, NULL, 1513744563),
(190, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 6, '刘嘉', '+*', 5, '/static/default/avatar.png', 1, '', NULL, 1, 1513757343, NULL, 1513757343),
(191, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 226, 'GT ', 'willng', 12, '/static/default/avatar.png', 1, '', NULL, 1, 1513757343, NULL, 1513757343),
(192, '下午茶班', 39, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 225, 'Bingo', 'Bingo', 21, '/static/default/avatar.png', 1, '', NULL, 1, 1513757343, NULL, 1513757343),
(193, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 140, '覃诗翔', '言覃多多', 146, '/static/default/avatar.png', 1, '', NULL, 1, 1513761908, NULL, 1513761908),
(194, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 144, '肖振兴', '中国太保惠霞', 150, '/static/default/avatar.png', 1, '', NULL, 1, 1513761908, NULL, 1513761908),
(195, '周五北头低年级班', 33, '大热常规班', 13, 9, '大热篮球俱乐部', 173, '柯艾锐', '艾望承', 183, '/static/default/avatar.png', 1, '', NULL, 1, 1513761908, NULL, 1513761908),
(196, '龙岗训练营高年级班', 38, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 108, '王瑞翔', '王少华', 117, '/static/default/avatar.png', 1, '', NULL, 1, 1513764488, NULL, 1513764488),
(197, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 148, '柏成恩', '小福和小小福和小小小福', 154, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017),
(198, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 200, '王珑桥', '王珑桥', 238, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017),
(199, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 149, '谭天笑', 'TAN谭天笑', 155, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017),
(200, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 197, '谭晟中', '谭晟中谭正中', 235, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017),
(201, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 189, '洪新铠', '洪新铠', 214, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017),
(202, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 164, '林弋骁', 'Lynch', 171, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017),
(203, '周六北头前海五年级', 26, '大热常规班', 13, 9, '大热篮球俱乐部', 167, '黄川越', 'hcyhcy', 174, '/static/default/avatar.png', 1, '', NULL, 1, 1513765017, NULL, 1513765017),
(204, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 203, '朱俊亦', '朱俊亦', 241, '/static/default/avatar.png', 1, '', NULL, 1, 1513765379, NULL, 1513765379),
(205, '周六北头进阶班', 28, '大热常规班', 13, 9, '大热篮球俱乐部', 170, '黄之麓', '黄之麓666', 177, '/static/default/avatar.png', 1, '', NULL, 1, 1513765379, NULL, 1513765379);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grade_member`
--
ALTER TABLE `grade_member`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `grade_member`
--
ALTER TABLE `grade_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
