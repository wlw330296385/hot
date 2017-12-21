-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-21 14:36:42
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
-- 表的结构 `lesson_member`
--

CREATE TABLE `lesson_member` (
  `id` int(10) UNSIGNED NOT NULL,
  `lesson` varchar(60) NOT NULL,
  `lesson_id` int(10) NOT NULL,
  `camp_id` int(10) NOT NULL,
  `camp` varchar(60) NOT NULL COMMENT '所属训练营',
  `student_id` int(10) NOT NULL,
  `student` varchar(60) NOT NULL,
  `member` varchar(60) NOT NULL COMMENT '对应会员表member',
  `member_id` int(10) NOT NULL COMMENT '对应会员表id',
  `rest_schedule` int(10) NOT NULL DEFAULT '0' COMMENT '剩余课时,0时自动毕业',
  `avatar` varchar(255) NOT NULL DEFAULT '/static/default/avatar.png' COMMENT '头像',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '2:体验生|1:正式学生',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `system_remarks` varchar(255) DEFAULT NULL COMMENT '系统备注',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '-1:离营|0:待审核|1:正常|2:退出|3:被开除|4:毕业',
  `create_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `update_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程-会员关联表';

--
-- 转存表中的数据 `lesson_member`
--

INSERT INTO `lesson_member` (`id`, `lesson`, `lesson_id`, `camp_id`, `camp`, `student_id`, `student`, `member`, `member_id`, `rest_schedule`, `avatar`, `type`, `remarks`, `system_remarks`, `status`, `create_time`, `delete_time`, `update_time`) VALUES
(193, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 111, '蔡佳烨', '6222355892320034', 120, 13, '/static/default/avatar.png', 1, '', NULL, 1, 1509985530, NULL, 1509985530),
(194, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 110, '郭懋增', '13662248558', 119, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1509970166, NULL, 1509970166),
(195, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 109, '黄子杰', '黄子杰', 118, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1509943739, NULL, 1509943739),
(196, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 108, '王瑞翔', '王少华', 117, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1509943670, NULL, 1509943670),
(197, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 107, '曾子航', '13670022780', 116, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1509871789, NULL, 1509871789),
(198, '大热常规班', 13, 9, '大热篮球俱乐部', 106, '熊天华', '熊天华', 115, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1509856196, NULL, 1509856196),
(199, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 105, '颜若宸', '颜若宸', 114, 13, '/static/default/avatar.png', 1, '', NULL, 1, 1509845658, NULL, 1509845658),
(200, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 104, '王浩丁', '王浩丁', 113, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1509844432, NULL, 1509844432),
(201, '大热常规班', 13, 9, '大热篮球俱乐部', 103, '陈嘉航', 'chenjiahang', 112, 30, '/static/default/avatar.png', 1, '', NULL, 1, 1509787853, NULL, 1509787853),
(202, '大热常规班', 13, 9, '大热篮球俱乐部', 102, '张益凯', '张益凯', 111, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1509786985, NULL, 1509786985),
(203, '大热常规班', 13, 9, '大热篮球俱乐部', 100, '关乐耀', '关乐耀', 110, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1509784965, NULL, 1509784965),
(204, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 99, '周子祺', 'lily', 109, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1509784749, NULL, 1509784749),
(205, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 98, '苏祖威', '061683', 108, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1509783379, NULL, 1509783379),
(206, '大热常规班', 13, 9, '大热篮球俱乐部', 97, '黄嘉荣', 'HANA', 107, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1509783164, NULL, 1509783164),
(207, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 96, '陈予喆', 'hou1298280', 106, 11, '/static/default/avatar.png', 1, '', NULL, 1, 1509782830, NULL, 1509782830),
(208, '大热常规班', 13, 9, '大热篮球俱乐部', 95, '曾跃阳', '30988232', 105, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1509720686, NULL, 1509720686),
(209, '南头城小学', 30, 15, '钟声训练营', 94, '赵俊豪', '赵俊豪', 104, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1509703640, NULL, 1509705361),
(210, '校园兴趣班', 12, 3, '猴赛雷训练营', 89, '测试1', 'legend', 6, 5, '/static/default/avatar.png', 1, '', NULL, 1, 1509700436, NULL, 1509700436),
(211, '北大附小一年级', 36, 15, '钟声训练营', 93, '张腾月', '腾月', 103, 12, '/static/default/avatar.png', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1509697785, NULL, 1509699522),
(212, '石厦学校兰球队', 29, 15, '钟声训练营', 92, '张广涵', '张广涵', 102, 11, '/static/default/avatar.png', 1, '', NULL, 1, 1509683459, NULL, 1509685850),
(213, '大热常规班', 13, 9, '大热篮球俱乐部', 91, '梁浩峰', 'LIANG', 101, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1509619941, NULL, 1509619941),
(214, '大热常规班', 13, 9, '大热篮球俱乐部', 90, '梁浩然', 'LIANG', 101, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1509619809, NULL, 1509619809),
(215, '平台示例请勿购买', 37, 4, '准行者训练营', 46, '小woo', 'woo123', 8, 14, '/static/default/avatar.png', 1, '', NULL, 1, 1509445644, NULL, 1509445644),
(216, 'AKcross课程', 38, 13, 'AKcross训练营', 86, '李李喆', 'Clement Lee', 100, 15, 'https://wx.qlogo.cn/mmhead/WAibKjHvK5nGwOjqMd7aj2uwibgicK2CyeL73tEGSyCAaTtib8piaFODHRg/0', 1, '', NULL, 1, 1509433128, NULL, 1509433128),
(217, '前海小学', 31, 15, '钟声训练营', 84, '王奕唐', 'Miya', 98, 15, 'https://wx.qlogo.cn/mmhead/FrdAUicrPIibfdwVLEWdXjfszf6JtqbichNGmgX52g519jUT3AkWJkF5A/0', 1, '', NULL, 1, 1509283014, NULL, 1509283135),
(218, '石厦学校兰球队', 29, 15, '钟声训练营', 83, '周凯炀', '周浩楠、周宇希、周凯炀', 97, 11, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, '', NULL, 1, 1509272180, NULL, 1509278237),
(219, '石厦学校兰球队', 29, 15, '钟声训练营', 82, '周宇希', '周浩楠、周宇希、周凯炀', 97, 10, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, '', NULL, 1, 1509272077, NULL, 1509272122),
(220, '石厦学校兰球队', 29, 15, '钟声训练营', 81, '周浩楠', '周浩楠、周宇希、周凯炀', 97, 10, 'https://wx.qlogo.cn/mmhead/PiajxSqBRaELkMib3NJJ53Gf5dOlK9cnlO04P2sHb2tv6PibfOM2icgZHQ/0', 1, '', NULL, 1, 1509271960, NULL, 1509272122),
(221, '石厦学校兰球队', 29, 15, '钟声训练营', 80, '朱喆熙', '朱喆熙', 96, 10, 'https://wx.qlogo.cn/mmhead/ZqDaDiccbgkhqudKfypGjYLEng5P9JSdNc6WfGichTYDY76OFtrtyiaZg/0', 1, '', NULL, 1, 1509271845, NULL, 1509272122),
(222, '石厦学校兰球队', 29, 15, '钟声训练营', 79, '方慧妍', 'FANGHUIYAN', 88, 10, 'https://wx.qlogo.cn/mmhead/bVy2VQVTWzbtVlldXFcWqic1ib9ZZa0fHvPloPhBgA6SCicFgUCfqnibWw/0', 1, '', NULL, 1, 1509254479, NULL, 1509256861),
(223, '松坪小学', 32, 15, '钟声训练营', 78, '邓俊伟', '邓俊伟', 95, 14, 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM7fLJDnHuiaObafTXdfngPmhmgU8Oibic4DxUWECOq3RZ5TA/0', 1, '', NULL, 1, 1509246244, NULL, 1509248257),
(224, '松坪小学', 32, 15, '钟声训练营', 70, '李小凡', 'lixiaofang', 90, 13, 'https://wx.qlogo.cn/mmhead/Ib5852jAyb860z7fQb9L9kCSb5ZU8QicSwlB0MXFXJxAz3Bqib1iaGpsw/0', 1, '', NULL, 1, 1509237476, NULL, 1509248257),
(225, '松坪小学', 32, 15, '钟声训练营', 77, '王秉政', '王秉政', 94, 13, 'https://wx.qlogo.cn/mmhead/sTJptKvBQLLibnLPq727HT4qqfl6GE7YibCk1iaJdbBOM7IpfWgIdROVg/0', 1, '', NULL, 1, 1509194924, NULL, 1509195346),
(226, '松坪小学', 32, 15, '钟声训练营', 76, '张致远', '张致远', 93, 12, 'https://wx.qlogo.cn/mmhead/C6nnRGnPbvwxhMnBf6aSBRKAcLpoOuhibqOodQsrO0abWLLVkRQrouQ/0', 1, '', NULL, 1, 1509191189, NULL, 1509193713),
(227, '大热常规班', 13, 9, '大热篮球俱乐部', 75, '薛子豪', '薛子豪', 92, 15, 'https://wx.qlogo.cn/mmhead/78EkX665csCzfpNaaBSvfy1JpmicTLfoh2FtiaNSKK6N5PYicTOeK8wjA/0', 1, '', NULL, 1, 1509180982, NULL, 1509423702),
(228, '平台示例请勿购买', 37, 4, '准行者训练营', 51, '荣', 'wayen', 77, 10, '/0', 1, '', NULL, 1, 1509176780, NULL, 1509176780),
(229, '荣光篮球强化', 25, 5, '荣光训练营', 74, '新学生', 'legend', 6, 17, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', NULL, 1, 1509091585, NULL, 1509091585),
(230, '北大附小一年级', 36, 15, '钟声训练营', 73, '侯皓轩', '小苹果', 91, 11, 'https://wx.qlogo.cn/mmhead/wbKdib81ny6ibpPLZicROqqicQ7l1PrrmPwJmSpKrKG0FzztjmkibjApnwQ/0', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1509086650, NULL, 1509086840),
(231, '松坪小学', 32, 15, '钟声训练营', 69, '李泓', 'Li hong', 89, 13, '/static/default/avatar.png', 1, '系统插入,时间2017年10月27日14:16:02', NULL, 1, 1508947200, NULL, 1509090474),
(232, '前海小学', 31, 15, '钟声训练营', 71, '李浚睿', 'Jerry', 75, 14, 'https://wx.qlogo.cn/mmopen/vi_32/7g6icshVrInKsnnzvMpm7jBVXywRsKHnITNpDYTVPXYEWaYh1sDHPRU2z5YIIJdMvNM9HWOPMKyiakHiaibM9lY6sA/0', 1, '', NULL, 1, 1509079444, NULL, 1509079668),
(233, '北大附小一年级', 36, 15, '钟声训练营', 31, '蒋清奕', '蒋清奕', 65, 13, '/static/default/avatar.png', 1, '系统插入,时间2017年10月27日10:58:40', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1508774400, NULL, 1509073844),
(234, '松坪小学', 32, 15, '钟声训练营', 67, '朱涛', '朱涛', 87, 12, 'https://wx.qlogo.cn/mmhead/uchmtWQh7iaqm9z1QucKESYwDiasve3glVvHvDEEEvZmEBJrp26SDrcA/0', 1, '', NULL, 1, 1509009392, NULL, 1509009518),
(235, '松坪小学', 32, 15, '钟声训练营', 66, '饶宏宇', '饶宏宇', 39, 12, 'https://wx.qlogo.cn/mmopen/vi_32/QiaJBRJFj5Xt3S5WluEumvf6C68fm3U1NBVpSlicePadW44QHt3aDljkr1iaYYZDH2LlXibQfFIlp2oNaxX6dHAasg/0', 1, '', NULL, 1, 1509008230, NULL, 1509009518),
(236, '松坪小学', 32, 15, '钟声训练营', 63, '余永康', '余永康', 84, 12, 'https://wx.qlogo.cn/mmopen/vi_32/AvTOBqK5D0azFkS8BVibFucZyG9z9rLicQYL7FkBl6QicS6z4mdNejuvU4Qial8z9wOfInP4anVMAK7sAeoX5A1tOg/0', 1, '', NULL, 1, 1509006276, NULL, 1509009518),
(237, '北大附小一年级', 36, 15, '钟声训练营', 62, '周子杰', 'rebeccazhangly', 81, 11, 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Dribia5ZQu19qPDlO8LQuwYfbEKvkc4np2NicicpECusbLsAYMLtVn4pT8IcyBibvMnjL6w/0', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1509001966, NULL, 1509018809),
(238, '荣光篮球强化', 25, 5, '荣光训练营', 46, '小woo', 'woo123', 8, 63, 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1, '', NULL, 1, 1508992654, NULL, 1509089966),
(239, '石厦学校兰球队', 29, 15, '钟声训练营', 40, '陈昊阳', 'cjwcyc', 76, 11, 'https://wx.qlogo.cn/mmopen/vi_32/GCNUn1n4CPiaMuVncIvb0u3mCyCNIYOQmjMVuSx5SrGOPe94lWMticoCRn3G2qry302FPPTkcichHEpKrzwIb1TrA/0', 1, '', NULL, 1, 1508989728, NULL, 1508991944),
(240, '前海小学', 31, 15, '钟声训练营', 57, '梁懿', '梁懿', 83, 14, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIZILv4jZfYyLDTSDRic2TicWv1Lqsy7ibgV1LK3PiaycF11vJQ2Ud4PrDa0XvcQEhdaEAEkb2feNbtCQ/0', 1, '', NULL, 1, 1508986588, NULL, 1508992187),
(241, '北大附小一年级', 36, 15, '钟声训练营', 56, '姚定希', '姚定希', 86, 11, 'https://wx.qlogo.cn/mmhead/BfRL3E0G1pdy5s3m2OtzHEbJ0tv6PFPzUu34m3zQ3XzzmlMkMgGMOg/0', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1508986351, NULL, 1508991708),
(242, '荣光篮球强化', 25, 5, '荣光训练营', 52, '苏楠楠', 'legend', 6, 2, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', NULL, 1, 1508985553, NULL, 1509089950),
(243, '北大附小一年级', 36, 15, '钟声训练营', 43, '邓粤天', '13927482132', 82, 11, 'https://wx.qlogo.cn/mmhead/jJSbu4Te5ib9GgS8EBYzj9DGPl5G68qqDVadUWdDKYdNwEibDBUlFaPA/0', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1508850519, NULL, 1508991708),
(244, '高年级班', 13, 9, '大热篮球俱乐部', 42, '陈宛杭', 'kiko', 80, 15, 'https://wx.qlogo.cn/mmopen/vi_32/zocbwtq7yDlo6zSBZ0jmSgpaHaFWmAotUTmzHopaB1Vl8DVWP9Gdd7U37xhdUkg30Z6HE6BzIBKGqEJBRDQOLA/0', 1, '', NULL, 1, 1508849731, NULL, 1509422313),
(245, 'AKcross课程', 38, 13, 'AKcross训练营', 41, '游逸朗', 'Youboy806', 79, 15, 'https://wx.qlogo.cn/mmopen/vi_32/LMPP1EaHUlWoor4A7ibKMl1XM80TcezRI5GgwThYwOHPybVktqd8QicgtYr8svs4LPxP0bmSpszQtricUuCGPtuFg/0', 1, '', NULL, 1, 1508831426, NULL, 1508831426),
(246, '前海小学', 31, 15, '钟声训练营', 39, '饶滨', '饶滨', 58, 14, 'https://wx.qlogo.cn/mmopen/vi_32/3q4wOibh9nZPekaEh1mPpULmJARKuuXRphK7Mak1kTjCNNIibNEjNicoEVtmJLT9G7kjoNZ6vllcLteP8vibyXiaj0A/0', 1, '', NULL, 1, 1508770993, NULL, 1508992187),
(247, '北大附小一年级', 36, 15, '钟声训练营', 38, '林需睦', '13823181560', 74, 13, 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqicTFZcNkXiaVqLpNeiapVYiaItQ1hGcic0s9BCKqx2aDYVMSD9KNkhuVmtZyvCXASgk1I6jH9LbMw4HQ/0', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1508766362, NULL, 1508991708),
(248, '前海小学', 31, 15, '钟声训练营', 36, '邱仁鹏', 'SZQIUJB', 73, 14, 'https://wx.qlogo.cn/mmopen/vi_32/oBJMukfMx9mAfOFLL6oILN4zz1F39lUDnibK34DTlPq3YUq2P7gWk4muj1cDFKMQLlN5ypREzibVJO4yKSEUK62w/0', 1, '', NULL, 1, 1508766196, NULL, 1508992187),
(249, '前海小学', 31, 15, '钟声训练营', 35, '万宇宸', '万宇宸', 61, 14, 'https://wx.qlogo.cn/mmopen/vi_32/pnKFC33CDdnArcQ0ONDFVdlQ1yF6aewh99xgKW3G72iaruRr1oGTIwV8gfpfptb4VpBdicrZ9pJLwpib50cYrfVVw/0', 1, '', NULL, 1, 1508737748, NULL, 1508992187),
(250, '北大附小一年级', 36, 15, '钟声训练营', 34, '刘一凡', 'gaojun', 67, 12, 'https://wx.qlogo.cn/mmopen/vi_32/x7dO3qq2JzUkwK79rS0ZmwrnficUG7mB9bAUOQ7lB52dY5uhUMgBFPQoAsY5w1LWrzYwDROVSKrYoqmq6qgYrcg/0', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1508735154, NULL, 1508991708),
(251, '北大附小一年级', 36, 15, '钟声训练营', 33, '梁峻玮', '20101119', 66, 11, 'https://wx.qlogo.cn/mmopen/vi_32/8x1V2gzQgXsOAskrSxa6Du6wQajIibtJa0SkWurB9LkfK1vR4BQiaZ14GnibibNdUdOG0iaQlVvcthLcx7Qf0mKBBLw/0', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1508732407, NULL, 1508991708),
(252, '北大附小一年级', 36, 15, '钟声训练营', 30, '黄子诺', 'leonhuang', 63, 12, 'https://wx.qlogo.cn/mmopen/vi_32/PH3lR9dDe7o1dzyQIgkpkLhkOchMTwEEqQ3TI2oKPmxGNOKbgicYAV4wORoMLw2NGBaNDjVMv8x38BjJRibThTzg/0', 1, '', '20171107发现课时异常数据做删除处理后补充剩余课时', 1, 1508730453, NULL, 1508991708),
(253, '前海小学', 31, 15, '钟声训练营', 29, '刘宇恒', '刘宇恒', 62, 14, 'https://wx.qlogo.cn/mmopen/vi_32/dg5BzBbk6ialKxBfoWtI9iayIQS6b5pG0QF1ib4YiauZics9fBRksgtWibAcHYEGiaJbjOR4W0jOgGJIb6LAwiapjEkkbg/0', 1, '', NULL, 1, 1508729343, NULL, 1508992187),
(254, '前海小学', 31, 15, '钟声训练营', 28, '王钰龙', '王钰龙', 60, 14, 'https://wx.qlogo.cn/mmopen/vi_32/mpqiaCLKTSkHXZbs2GqFnjoflrkMib2j49z5yM8VHDmmUSicHZI5iak2Tia6ykX7tXT8TOBYB2v9UaYmnJ99Z0FCO0g/0', 1, '', NULL, 1, 1508726144, NULL, 1508992187),
(255, '石厦学校兰球队', 29, 15, '钟声训练营', 27, '张毓楠', '张毓楠', 50, 10, 'https://wx.qlogo.cn/mmopen/vi_32/ywnQfcMqe2uC9KP2fDr6QorLMk8FFkIL3IUpfJn7D8707CEIfcUwLEOLGf85A0C9bY4a29ZkcfkGa3RwSKoMbw/0', 1, '', NULL, 1, 1508726076, NULL, 1508991944),
(256, '前海小学', 31, 15, '钟声训练营', 26, '李语辰', '李语辰', 46, 14, 'https://wx.qlogo.cn/mmopen/vi_32/JVWE6PQ990A8KoicXXxCEzKP2trTcWSkBsW16ibaYbTZHSTA4mOy410wA2u9uuxUB0FiavLiaBkicKCp9icc9Rgry7HQ/0', 1, '', NULL, 1, 1508725787, NULL, 1508992187),
(257, '前海小学', 31, 15, '钟声训练营', 25, '战奕名', '战奕名', 51, 14, 'https://wx.qlogo.cn/mmopen/vi_32/v4IpFsmBcCwGN9D1SzfmfahDia8p8l3saE3DbWnmOY2HCClXCmfibzzw3H3hcnbXAAkcwQH6icJxiabSc03HnXSLlA/0', 1, '', NULL, 1, 1508724642, NULL, 1508992187),
(258, '前海小学', 31, 15, '钟声训练营', 21, '陈高翔', '陈高翔', 59, 14, 'https://wx.qlogo.cn/mmopen/vi_32/yzvxOetibI0IK3Jjwxb8AhFLpiaf8sEqjkhPwXgtr0JRXWJNIVDBvT6QjblpFABBKGCvGryia5xz20zwzEg5BZ6dg/0', 1, '', NULL, 1, 1508723329, NULL, 1508992187),
(259, '前海小学', 31, 15, '钟声训练营', 22, '郑皓畅', '郑皓畅', 56, 14, 'https://wx.qlogo.cn/mmopen/vi_32/6zNQeeicR57x1lcicY9mgX2MBCibf3OkicIKIvEcq1Ec7ibFPRFkEtg8nKeBoiaNfrwoGmvu9Wt5BWo9HicxroYqjRZsw/0', 1, '', NULL, 1, 1508723297, NULL, 1508992187),
(260, '前海小学', 31, 15, '钟声训练营', 20, '唐轩衡', '唐轩衡', 55, 14, 'https://wx.qlogo.cn/mmopen/vi_32/VVyUyM6Q3vHB0kvA47iafepgr2L2vx8nvxzeSIKqJQLGz6qA9RWloXBmvCic1r4pD1chaLOLck0y4r3aibFmEE1YQ/0', 1, '', NULL, 1, 1508676522, NULL, 1508992187),
(261, '石厦学校兰球队', 29, 15, '钟声训练营', 19, '吴师隽', '吴师隽', 52, 11, 'https://wx.qlogo.cn/mmopen/vi_32/NYp0qdFEpicQ36DW8ZpibPCSVAf3NSCNJgwbgKerkcXV3wlXwUdn0XfgBf26eIZ4tqibxT5ScU6el8A1bouRwibcJg/0', 1, '', NULL, 1, 1508661866, NULL, 1508991944),
(262, '石厦学校兰球队', 29, 15, '钟声训练营', 18, '黄浩', '黄浩', 49, 10, 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIn1c0h4Xcn8dISicib3c5qRUsmhvibqvQMY7q3qFUSVw36nw1XW7GEQx1nVkkWQyEyGbtr6JMuBOfyg/0', 1, '', NULL, 1, 1508658059, NULL, 1508991944),
(263, '前海小学', 31, 15, '钟声训练营', 17, '郑肖杰', '郑肖杰', 48, 14, 'https://wx.qlogo.cn/mmopen/vi_32/8B6CScn6mZribr9bTI1RhDEiaQvCtKUKp9BmL1VLoamZWKFF3mHqfOOw2zN5gOIFCBpwsycFWFnr6SulEH2hRLBA/0', 1, '', NULL, 1, 1508639991, NULL, 1508992187),
(264, '前海小学', 31, 15, '钟声训练营', 16, '李润弘', '李润弘', 42, 15, 'https://wx.qlogo.cn/mmopen/vi_32/icD3j8Uhe4xOLJS1zichGLY3rfpJAI4Efd95vMQxlBhSABPWicw4tOHsyY2rnPVAFDbAohTvsMAxoLIo49bA33Z1g/0', 1, '', '20171102修改学员剩余课时', 1, 1508554789, NULL, 1509608799),
(265, '前海小学', 31, 15, '钟声训练营', 15, '陈润宏', '陈润宏', 43, 14, 'https://wx.qlogo.cn/mmopen/vi_32/wCFb3b7CBRJSuXQazfF7N0GIfuhF53JRlkVEq2Z2pUgIMraJI2iaWwCONHk7nkJibrUQiaEyU8yrPxianhMIyuArdg/0', 1, '', '20171102:北大附小改成前海小学', 1, 1508554704, NULL, 1509608798),
(266, '校园兴趣班', 12, 3, '猴赛雷训练营', 2, '陈小准', 'legend', 6, 20, 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, '', NULL, 1, 1508489473, NULL, 1508747575),
(267, '校园兴趣班', 12, 3, '猴赛雷训练营', 6, '刘嘉', '123abc', 5, 1, 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYIDwRM5lic1WWW9mKWFS1a1fYeA/0', 2, '', NULL, 1, 1508396925, NULL, 1508747575),
(268, '猴塞雷课程', 11, 3, '猴赛雷训练营', 6, '刘嘉', '123abc', 5, 2, 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYIDwRM5lic1WWW9mKWFS1a1fYeA/0', 2, '', NULL, 1, 1508396331, NULL, 1508839950),
(269, '前海小学', 31, 15, '钟声训练营', 14, '陈承铭', '陈承铭', 26, 15, '/static/default/avatar.png', 1, '系统插入,时间2017年10月18日17:40:19', '20171102修改学员剩余课时', 1, 1508318976, NULL, 1509608798),
(270, '周六上午十点低年级班', 4, 2, '大热前海训练营', 13, '邓赖迪', '邓赖迪', 22, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1508242055, NULL, 1508242055),
(271, '超级射手班', 6, 4, '准行者训练营', 11, '陈佳佑', 'yanyan', 33, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1508207328, NULL, 1508207328),
(272, '大热高级班', 13, 9, '大热篮球俱乐部', 9, '罗翔宇', '罗翔宇', 25, 30, '/static/default/avatar.png', 1, '系统插入', NULL, 1, 1508141658, NULL, 1509423900),
(273, '大热高级班', 13, 9, '大热篮球俱乐部', 8, '钟欣志', '钟欣志', 23, 15, '/static/default/avatar.png', 1, '系统插入', NULL, 1, 1508141658, NULL, 1509423753),
(274, '校园兴趣班', 12, 3, '猴赛雷训练营', 1, '123', 'woo123', 8, 11, '/static/default/avatar.png', 1, '', NULL, 1, 1508063597, NULL, 1508063597),
(275, '荣光篮球强化', 25, 5, '荣光训练营', 7, '儿童劫', 'wl', 10, 1, '/static/default/avatar.png', 2, '', NULL, 1, 1507947073, NULL, 1509180516),
(276, '超级控球手', 3, 4, '准行者训练营', 6, '刘嘉', '123abc', 5, 1, '/static/default/avatar.png', 2, '', NULL, 1, 1507880297, NULL, 1509085011),
(277, '周日北头高年级初中班', 13, 9, '大热篮球俱乐部', 5, '张晨儒', '13537781797', 15, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1507728830, NULL, 1509424032),
(278, '校园兴趣班', 12, 3, '猴赛雷训练营', 4, '小霖', 'weilin666', 4, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1507630199, NULL, 1507630199),
(279, '超级控球手', 3, 4, '准行者训练营', 1, '123', 'woo123', 8, 1, '/static/default/avatar.png', 2, '', NULL, 1, 1507545041, NULL, 1509090703),
(280, '小学低年级初级班', 2, 3, '猴赛雷训练营', 1, '123', 'woo123', 8, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1507542080, NULL, 1508472456),
(281, '猴塞雷课程', 11, 3, '猴赛雷训练营', 1, '123', 'woo123', 8, 5, '/static/default/avatar.png', 2, '', NULL, 1, 1507540816, NULL, 1508839950),
(282, '超级射手班', 6, 4, '准行者训练营', 1, '123', 'woo123', 8, 2, '/static/default/avatar.png', 2, '', NULL, 1, 1507539335, NULL, 1507539335),
(283, '大热幼儿班', 1, 1, '大热体适能中心', 1, '123', 'woo123', 8, 5, '/static/default/avatar.png', 2, '', NULL, 1, 1507537926, NULL, 1507537926),
(284, '周六上午十点低年级班', 4, 2, '大热前海训练营', 1, '123', 'woo123', 8, 4, '', 2, '', NULL, 1, 1507518508, NULL, 1507518508),
(285, '猴塞雷课程', 11, 3, '猴赛雷训练营', 3, 'Easychen ', 'Greeny', 13, 2, '', 2, '', NULL, 1, 1507355231, NULL, 1508839950),
(286, '周六上午十点低年级班', 4, 2, '大热前海训练营', 2, '陈小准', 'legend', 6, 15, '', 2, '', NULL, 1, 1506569572, NULL, 0),
(287, '周六上午十点低年级班', 4, 2, '大热前海训练营', 2, '陈小准', 'legend', 6, 15, '', 2, '', NULL, 1, 1506569500, NULL, 0),
(289, '平台示例请勿购买', 37, 4, '准行者训练营', 113, '周鸿一', 'jason', 121, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1510044582, NULL, 1510044582),
(290, '平台示例请勿购买', 37, 4, '准行者训练营', 114, '毛毛', '1234', 122, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1510044746, NULL, 1510044746),
(291, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 115, '王孝煊', '065385', 123, 11, '/static/default/avatar.png', 1, '', NULL, 1, 1510059638, NULL, 1510059638),
(292, '平台示例请勿购买', 37, 4, '准行者训练营', 12, '娟', 'HoChen', 1, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1510100359, NULL, 1510100359),
(293, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 118, '邵冠霖', '6222024000065498186', 126, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1510116547, NULL, 1510116547),
(294, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 119, '杨涵', '6222024000065498186', 126, 11, '/static/default/avatar.png', 1, '', NULL, 1, 1510116664, NULL, 1510116664),
(295, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 116, '黄俊豪', '黄俊豪', 124, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1510117401, NULL, 1510117401),
(296, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 120, '关楠萧', '王少华', 117, 11, '/static/default/avatar.png', 1, '', NULL, 1, 1510191105, NULL, 1510191105),
(297, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 121, '袁帅', '6222024000065498186', 126, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1510369090, NULL, 1510369090),
(298, '荣光篮球强化（测试）', 25, 5, '荣光训练营', 4, '小霖', 'weilin666', 4, 3, '/static/default/avatar.png', 1, '', NULL, 1, 1510380785, NULL, 1510380785),
(299, 'AKcross课程', 38, 13, 'AKcross训练营', 4, '小霖', 'weilin666', 4, 30, '/static/default/avatar.png', 1, '', NULL, 1, 1510388218, NULL, 1510388218),
(300, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 122, '张旺鹏', '军歌', 128, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1510388668, NULL, 1510388668),
(301, '龙岗民警子女篮球课程', 15, 9, '大热篮球俱乐部', 117, '李鸣轩', '13825243733', 125, 12, '/static/default/avatar.png', 1, '', '系统插入时间2017年11月11日16:29:21', 1, 1510388877, NULL, 1510388877),
(302, '超级射手［海岸城站］', 1, 3, '猴赛雷训练营', 1, 'HoChen', 'HoChen', 1, 7, '/static/default/avatar.png', 1, '', NULL, 1, 1510391569, NULL, 1510391569),
(303, '大热常规班', 13, 9, '大热篮球俱乐部', 123, '刘俊霖', '红茶????', 129, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1510393607, NULL, 1510393607),
(304, '超级射手［海岸城站］', 1, 3, '猴赛雷训练营', 8, 'woo123', 'woo123', 8, 5, '/static/default/avatar.png', 2, '', NULL, 1, 1510646091, NULL, 1510646091),
(305, '超级射手［海岸城站］', 1, 3, '猴赛雷训练营', 6, 'legend', 'legend', 6, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1510653206, NULL, 1510653206),
(306, '大热常规班', 13, 9, '大热篮球俱乐部', 124, '江晨', '锦华', 130, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1510671523, NULL, 1510671523),
(307, '大热常规班', 13, 9, '大热篮球俱乐部', 129, '饶鹏轩', 'bemyself', 135, 14, '/static/default/avatar.png', 1, '', NULL, 1, 1510819362, NULL, 1510819362),
(308, '大热常规班', 13, 9, '大热篮球俱乐部', 136, '卢宇璠', '卢盛良', 142, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1510825439, NULL, 1510825439),
(309, '大热常规班', 13, 9, '大热篮球俱乐部', 140, '覃诗翔', '言覃多多', 146, 0, '/static/default/avatar.png', 1, '', '20171121:上周出现支付0.01元系统显示支付100元,更新rest_schedule字段值', 1, 1510828278, 1511326123, 1510828278),
(310, '大热常规班', 13, 9, '大热篮球俱乐部', 142, '谢欣桦', 'wiya', 148, 0, '/static/default/avatar.png', 1, '', '20171121:上周出现支付0.01元系统显示支付100元,更新rest_schedule字段值', 1, 1510841933, 1511326123, 1510841933),
(311, '大热常规班', 13, 9, '大热篮球俱乐部', 143, '方泓锴', 'fanghk', 149, 0, '/static/default/avatar.png', 1, '', '20171121:上周出现支付0.01元系统显示支付100元,更新rest_schedule字段值', 1, 1510876936, 1511326123, 1510876936),
(312, '大热常规班', 13, 9, '大热篮球俱乐部', 144, '肖振兴', '中国太保惠霞', 150, 0, '/static/default/avatar.png', 1, '', '20171121:上周出现支付0.01元系统显示支付100元,更新rest_schedule字段值', 1, 1510889749, 0, 1510889749),
(313, '大热常规班', 13, 9, '大热篮球俱乐部', 134, '袁梓钦', '袁梓钦YZQ', 140, 11, '/static/default/avatar.png', 1, '', NULL, 1, 1510890307, NULL, 1510890307),
(314, '大热常规班', 13, 9, '大热篮球俱乐部', 135, '林嘉豪', '鲁秋娟¹⁵⁹²⁰⁰⁸⁵⁹⁶⁰', 141, 1, '/static/default/avatar.png', 1, '', '已申请退款的学生', 4, 1510890324, NULL, 1510890324),
(315, '大热常规班', 13, 9, '大热篮球俱乐部', 133, '杨灿', '杨灿13662559960', 139, 6, '/static/default/avatar.png', 1, '', '', 1, 1510890344, NULL, 1510890344),
(316, '大热常规班', 13, 9, '大热篮球俱乐部', 127, '吴奇朗', '晨曦', 133, 6, '/static/default/avatar.png', 1, '', NULL, 1, 1510890357, NULL, 1510890357),
(317, '大热常规班', 13, 9, '大热篮球俱乐部', 141, '张哲栋', '静', 147, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1510890372, NULL, 1510890372),
(318, '大热常规班', 13, 9, '大热篮球俱乐部', 137, '谢睿轩', '谢睿轩Ryan', 143, 16, '/static/default/avatar.png', 1, '', NULL, 1, 1510890389, NULL, 1510890389),
(319, '大热常规班', 13, 9, '大热篮球俱乐部', 138, '钟铭楷', '丹佛儿', 144, 3, '/static/default/avatar.png', 1, '', NULL, 1, 1510890406, NULL, 1510890406),
(320, '大热常规班', 13, 9, '大热篮球俱乐部', 128, '刘进哲', '刘欣洋', 134, 4, '/static/default/avatar.png', 1, '', NULL, 1, 1510891561, NULL, 1510891561),
(321, '大热常规班', 13, 9, '大热篮球俱乐部', 139, '毕宸君', 'Taily', 145, 17, '/static/default/avatar.png', 1, '', NULL, 1, 1510892291, NULL, 1510892291),
(322, '大热常规班', 13, 9, '大热篮球俱乐部', 135, '林嘉豪', '鲁秋娟¹⁵⁹²⁰⁰⁸⁵⁹⁶⁰', 141, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1510902957, NULL, 1510902957),
(323, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 147, '杨耀斌', 'Yrb801129', 153, 26, '/static/default/avatar.png', 1, '', NULL, 1, 1510919368, NULL, 1510919368),
(324, '大热常规班', 13, 9, '大热篮球俱乐部', 153, '文经纬', 'Lisa Lee(李建平)', 159, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1510996699, NULL, 1510996699),
(325, 'AKcross课程', 38, 13, 'AKcross训练营', 160, '田家福', '雪', 166, 30, '/static/default/avatar.png', 1, '', NULL, 1, 1511073367, NULL, 1511073367),
(326, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 165, '骆九宇', 'luojiuyu', 172, 25, '/static/default/avatar.png', 1, '', NULL, 1, 1511228103, NULL, 1511228103),
(327, '大热常规班', 13, 9, '大热篮球俱乐部', 145, '欧阳宇航', '欧阳宇航的外公', 151, 16, '/static/default/avatar.png', 1, '', NULL, 1, 1511247036, NULL, 1511247036),
(328, '大热常规班', 13, 9, '大热篮球俱乐部', 150, '吴宇昊', 'victor', 156, 4, '/static/default/avatar.png', 1, '', NULL, 1, 1511247071, NULL, 1511247071),
(329, '大热常规班', 13, 9, '大热篮球俱乐部', 130, '李正昊', '18923856665', 136, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511247150, NULL, 1511247150),
(330, '大热常规班', 13, 9, '大热篮球俱乐部', 131, '吴靖宇', '吴靖宇wjy', 137, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511247811, NULL, 1511247811),
(331, '大热常规班', 13, 9, '大热篮球俱乐部', 161, '黄子骞', 'huangzq', 168, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1511247853, NULL, 1511247853),
(332, '大热常规班', 13, 9, '大热篮球俱乐部', 154, '赖德瑞', '张春丽＆', 160, 16, '/static/default/avatar.png', 1, '', NULL, 1, 1511247962, NULL, 1511247962),
(333, '大热常规班', 13, 9, '大热篮球俱乐部', 156, '唐愈翔', '龙船????唐力', 162, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511247988, NULL, 1511247988),
(334, '大热常规班', 13, 9, '大热篮球俱乐部', 157, '刘秉松', 'yolanda传奇', 163, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511248038, NULL, 1511248038),
(335, '大热常规班', 13, 9, '大热篮球俱乐部', 158, '周尹木', 'zhouyinmu', 164, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511248068, NULL, 1511248068),
(336, '大热常规班', 13, 9, '大热篮球俱乐部', 159, '蓝炫皓', '飘', 165, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511248133, NULL, 1511248133),
(337, '大热常规班', 13, 9, '大热篮球俱乐部', 155, '李祖帆', '浪花', 161, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511248207, NULL, 1511248207),
(338, '大热常规班', 13, 9, '大热篮球俱乐部', 125, '刘政翰', 'Dorothy', 131, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511248240, NULL, 1511248240),
(339, '大热常规班', 13, 9, '大热篮球俱乐部', 146, '林子骞', 'Jack123', 152, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511248283, NULL, 1511248283),
(340, '大热常规班', 13, 9, '大热篮球俱乐部', 151, '刘庭彦', '19782174', 157, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511248707, NULL, 1511248707),
(341, '大热常规班', 13, 9, '大热篮球俱乐部', 168, '胡宇菲', '休闲的人²⁰¹⁷', 175, 30, '/static/default/avatar.png', 1, '', NULL, 1, 1511335243, NULL, 1511335243),
(342, '大热常规班', 13, 9, '大热篮球俱乐部', 166, '陈智斌', '????✨Mandy*????', 173, 18, '/static/default/avatar.png', 1, '', NULL, 1, 1511335795, NULL, 1511335795),
(343, '大热常规班', 13, 9, '大热篮球俱乐部', 132, '梁思诚', '听海', 138, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511336015, NULL, 1511336015),
(344, '大热常规班', 13, 9, '大热篮球俱乐部', 167, '黄川越', 'hcyhcy', 174, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511336112, NULL, 1511336112),
(345, '大热常规班', 13, 9, '大热篮球俱乐部', 169, '吴贻然', 'ൠ杨ྉ子ྉൠ', 176, 8, '/static/default/avatar.png', 1, '', NULL, 1, 1511339255, NULL, 1511339255),
(346, '大热常规班', 13, 9, '大热篮球俱乐部', 170, '黄之麓', '黄之麓666', 177, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511339402, NULL, 1511339402),
(347, '大热常规班', 13, 9, '大热篮球俱乐部', 171, '李闻韬', 'liwentao', 178, 23, '/static/default/avatar.png', 1, '', NULL, 1, 1511342456, NULL, 1511342456),
(348, '大热常规班', 13, 9, '大热篮球俱乐部', 164, '林弋骁', 'Lynch', 171, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1511343443, NULL, 1511343443),
(349, '荣光篮球强化（测试）', 25, 5, '荣光训练营', 89, '测试1', 'legend', 6, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1511504768, NULL, 1511504768),
(350, '龙岗民警子女篮球训练课程', 15, 9, '大热篮球俱乐部', 152, '刘永锋', '风格独特见解', 158, 14, '/static/default/avatar.png', 1, '', NULL, 1, 1511579302, NULL, 1511579302),
(351, '大热常规班', 13, 9, '大热篮球俱乐部', 172, '蒙致远', '蒙致远mengzhiyuan', 182, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1511678308, NULL, 1511678308),
(352, '大热常规班', 13, 9, '大热篮球俱乐部', 173, '柯艾锐', '艾望承', 183, 3, '/static/default/avatar.png', 1, '', NULL, 1, 1511921783, NULL, 1511921783),
(353, 'AKcross课程', 38, 13, 'AKcross训练营', 174, '刘羽', '师蓉', 186, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1511929149, NULL, 1511929149),
(354, 'AKcross课程', 38, 13, 'AKcross训练营', 175, '陈仕杰', '娟娟', 190, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1511943480, NULL, 1511943480),
(355, 'AKcross课程', 38, 13, 'AKcross训练营', 176, '陈逸昕', '昕恩', 191, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1511945507, NULL, 1511945507),
(356, 'AKcross课程', 38, 13, 'AKcross训练营', 177, '瞿士杰', '梁妹子', 192, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1511957794, NULL, 1511957794),
(357, '大热常规班', 13, 9, '大热篮球俱乐部', 178, '鄭子軒', '13603032922', 201, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1512095904, NULL, 1512095904),
(358, '大热常规班', 13, 9, '大热篮球俱乐部', 179, '杨熙', '杨熙', 207, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1512270106, NULL, 1512270106),
(359, '荣光篮球强化（测试）', 25, 5, '荣光训练营', 89, '测试1', 'legend', 6, 3, '/static/default/avatar.png', 2, '', NULL, 1, 1512639918, NULL, 1512639918),
(360, 'AKcross课程', 38, 13, 'AKcross训练营', 182, 'hot', 'BINGOZ', 209, 0, '/static/default/avatar.png', 2, '', NULL, 1, 1512715926, NULL, 1512715926),
(361, '平台示例请勿购买', 37, 4, '准行者训练营', 183, '大热', 'BINGOZ', 210, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1512722111, NULL, 1512722111),
(362, '平台示例请勿购买', 37, 4, '准行者训练营', 184, '大热1', 'BINGOZ', 210, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1512722588, NULL, 1512722588),
(363, '平台示例请勿购买', 37, 4, '准行者训练营', 185, '大热2', 'BINGOZ', 210, 0, '/static/default/avatar.png', 2, '', NULL, 1, 1512724532, NULL, 1512724532),
(364, 'AKcross课程', 38, 13, 'AKcross训练营', 186, '刘子豪', '刘子豪', 211, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1512734994, NULL, 1512734994),
(365, 'AKcross课程', 38, 13, 'AKcross训练营', 187, '孟想', '孟想', 212, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1512887691, NULL, 1512887691),
(366, '平台示例请勿购买', 37, 4, '准行者训练营', 188, '大热', 'BINGOZ', 213, 0, '/static/default/avatar.png', 2, '', NULL, 1, 1513050063, NULL, 1513050063),
(367, '大热常规班', 13, 9, '大热篮球俱乐部', 188, '大热', 'BINGOZ', 213, 0, '/static/default/avatar.png', 2, '', NULL, 1, 1513050140, NULL, 1513050140),
(368, '大热常规班', 13, 9, '大热篮球俱乐部', 189, '洪新铠', '洪新铠', 214, 31, '/static/default/avatar.png', 1, '', NULL, 1, 1513053397, NULL, 1513053397),
(369, 'AKcross课程', 38, 13, 'AKcross训练营', 190, '何锦宸', '何锦宸', 215, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1513059123, NULL, 1513059123),
(370, '平台示例请勿购买', 37, 4, '准行者训练营', 191, '陈易', 'HoChen', 1, 0, '/static/default/avatar.png', 2, '', NULL, 1, 1513237699, NULL, 1513237699),
(371, '大热常规班', 13, 9, '大热篮球俱乐部', 192, '蒋成栋', '蒋成栋', 230, 16, '/static/default/avatar.png', 1, '', NULL, 1, 1513399087, NULL, 1513399087),
(372, '大热常规班', 13, 9, '大热篮球俱乐部', 193, '王国宇', '可心', 231, 35, '/static/default/avatar.png', 1, '', NULL, 1, 1513412668, NULL, 1513412668),
(373, '大热常规班', 13, 9, '大热篮球俱乐部', 194, '王昱泽', '王剑平', 232, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1513495704, NULL, 1513495704),
(374, '大热常规班', 13, 9, '大热篮球俱乐部', 195, '牛子儒', '蓝天白云', 233, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1513553778, NULL, 1513553778),
(375, '塘朗追梦队', 43, 13, 'AKcross训练营', 196, '郑明宇', '郑伟军', 234, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1513565032, NULL, 1513565032),
(376, '大热常规班', 13, 9, '大热篮球俱乐部', 197, '谭晟中', '谭晟中谭正中', 235, 8, '/static/default/avatar.png', 1, '', NULL, 1, 1513567576, NULL, 1513567576),
(377, '大热常规班', 13, 9, '大热篮球俱乐部', 144, '肖振兴', '中国太保惠霞', 150, 3, '/static/default/avatar.png', 1, '', NULL, 1, 1513570519, NULL, 1513570519),
(378, '大热常规班', 13, 9, '大热篮球俱乐部', 149, '谭天笑', 'TAN谭天笑', 155, 4, '/static/default/avatar.png', 1, '', NULL, 1, 1513570637, NULL, 1513570637),
(379, '南外文华快艇队', 39, 13, 'AKcross训练营', 198, '孙乐知', '李红', 236, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1513582724, NULL, 1513582724),
(380, '大热常规班', 13, 9, '大热篮球俱乐部', 199, '郭浩麟', '三吉木易', 237, 33, '/static/default/avatar.png', 1, '', NULL, 1, 1513583423, NULL, 1513583423),
(381, '大热常规班', 13, 9, '大热篮球俱乐部', 200, '王珑桥', '王珑桥', 238, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1513585395, NULL, 1513585395),
(382, '南外文华快艇队', 39, 13, 'AKcross训练营', 201, '周润锋', '赵小莉', 239, 18, '/static/default/avatar.png', 1, '', NULL, 1, 1513585638, NULL, 1513585638),
(383, '南外文华快艇队', 39, 13, 'AKcross训练营', 202, '陈米洛', '周香香', 240, 17, '/static/default/avatar.png', 1, '', NULL, 1, 1513585828, NULL, 1513585828),
(384, '大热常规班', 13, 9, '大热篮球俱乐部', 148, '柏成恩', '小福和小小福和小小小福', 154, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1513586377, NULL, 1513586377),
(385, '大热常规班', 13, 9, '大热篮球俱乐部', 203, '朱俊亦', '朱俊亦', 241, 1, '/static/default/avatar.png', 1, '', NULL, 1, 1513587751, NULL, 1513587751),
(386, '大热常规班', 13, 9, '大热篮球俱乐部', 204, '何思源', '何思源', 242, 3, '/static/default/avatar.png', 1, '', NULL, 1, 1513589993, NULL, 1513589993),
(387, '大热常规班', 13, 9, '大热篮球俱乐部', 126, '李昊晟', 'Eva', 132, 4, '/static/default/avatar.png', 1, '', NULL, 1, 1513590932, NULL, 1513590932),
(388, '大热常规班', 13, 9, '大热篮球俱乐部', 205, '卢星丞', '卢星丞', 243, 7, '/static/default/avatar.png', 1, '', NULL, 1, 1513591407, NULL, 1513591407),
(389, '大热常规班', 13, 9, '大热篮球俱乐部', 206, '强亦宸', '强亦宸', 244, 17, '/static/default/avatar.png', 1, '', NULL, 1, 1513592024, NULL, 1513592024),
(390, '大热常规班', 13, 9, '大热篮球俱乐部', 207, '杨鑫财', '杨鑫财', 245, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1513592467, NULL, 1513592467),
(391, '大热常规班', 13, 9, '大热篮球俱乐部', 208, '万博宇', '万博宇', 246, 8, '/static/default/avatar.png', 1, '', NULL, 1, 1513664592, NULL, 1513664592),
(392, '大热常规班', 13, 9, '大热篮球俱乐部', 209, '邱智鸿', '邱智鸿', 247, 22, '/static/default/avatar.png', 1, '', NULL, 1, 1513664663, NULL, 1513664663),
(393, '大热常规班', 13, 9, '大热篮球俱乐部', 210, '王炫程', '王炫程', 248, 19, '/static/default/avatar.png', 1, '', NULL, 1, 1513664789, NULL, 1513664789),
(394, '大热常规班', 13, 9, '大热篮球俱乐部', 211, '刘家琦', '刘家琦', 249, 15, '/static/default/avatar.png', 1, '', NULL, 1, 1513664823, NULL, 1513664823),
(395, '大热常规班', 13, 9, '大热篮球俱乐部', 212, '张文瑄', '张文瑄', 250, 6, '/static/default/avatar.png', 1, '', NULL, 1, 1513664857, NULL, 1513664857),
(396, '大热常规班', 13, 9, '大热篮球俱乐部', 213, '薛若鸿', '薛若鸿', 251, 6, '/static/default/avatar.png', 1, '', NULL, 1, 1513664874, NULL, 1513664874),
(397, '大热常规班', 13, 9, '大热篮球俱乐部', 214, '严振轩', '严振轩', 252, 13, '/static/default/avatar.png', 1, '', NULL, 1, 1513664911, NULL, 1513664911),
(398, '大热常规班', 13, 9, '大热篮球俱乐部', 215, '郭皓晗', '郭皓晗', 253, 12, '/static/default/avatar.png', 1, '', NULL, 1, 1513664988, NULL, 1513664988),
(399, '大热常规班', 13, 9, '大热篮球俱乐部', 216, '周学谦', '周学谦', 254, 5, '/static/default/avatar.png', 1, '', NULL, 1, 1513665046, NULL, 1513665046),
(400, '大热常规班', 13, 9, '大热篮球俱乐部', 217, '冯镇壕', '冯镇壕', 255, 25, '/static/default/avatar.png', 1, '', NULL, 1, 1513665184, NULL, 1513665184),
(401, '大热常规班', 13, 9, '大热篮球俱乐部', 218, '周一泉', '周一泉', 256, 6, '/static/default/avatar.png', 1, '', NULL, 1, 1513665213, NULL, 1513665213),
(402, '大热常规班', 13, 9, '大热篮球俱乐部', 219, '潘乐航', '潘乐航', 257, 7, '/static/default/avatar.png', 1, '', NULL, 1, 1513665244, NULL, 1513665244),
(403, '大热常规班', 13, 9, '大热篮球俱乐部', 220, '汪星辰', '汪星辰', 258, 5, '/static/default/avatar.png', 1, '', NULL, 1, 1513665270, NULL, 1513665270),
(404, '大热常规班', 13, 9, '大热篮球俱乐部', 221, '马明道', '马明道', 259, 33, '/static/default/avatar.png', 1, '', NULL, 1, 1513665326, NULL, 1513665326),
(405, '大热常规班', 13, 9, '大热篮球俱乐部', 222, '谭正中', '谭晟中谭正中', 235, 3, '/static/default/avatar.png', 1, '', NULL, 1, 1513668761, NULL, 1513668761),
(406, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 223, '高燕', 'GaoYan', 9, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1513743469, NULL, 1513743469),
(407, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 4, '小霖', 'weilin666', 4, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1513743651, NULL, 1513743651),
(408, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 101, '哔哔哔', 'MirandaXian', 14, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1513744412, NULL, 1513744412),
(409, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 225, 'Bingo', 'Bingo', 21, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1513744678, NULL, 1513744678),
(410, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 226, 'GT ', 'willng', 12, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1513745162, NULL, 1513745162),
(411, '下午茶篮球课（有赠送课时）', 51, 31, 'woo篮球兴趣训练营', 6, '刘嘉', '+*', 5, 2, '/static/default/avatar.png', 1, '', NULL, 1, 1513746435, NULL, 1513746435),
(412, '大热常规班', 13, 9, '大热篮球俱乐部', 140, '覃诗翔', '言覃多多', 146, 6, '/static/default/avatar.png', 1, '', NULL, 1, 1513760258, NULL, 1513760258),
(413, '大热常规班', 13, 9, '大热篮球俱乐部', 227, '柏泓庚', 'M00100895', 188, 11, '/static/default/avatar.png', 1, '', NULL, 1, 1513765513, NULL, 1513765513),
(414, '塘朗追梦队', 43, 13, 'AKcross训练营', 228, '杜宇轩', '杜宇轩', 260, 17, '/static/default/avatar.png', 1, '', NULL, 1, 1513768032, NULL, 1513768032),
(416, '大热常规班', 13, 9, '大热篮球俱乐部', 254, '康正浩', '康正浩', 286, 10, '/static/default/avatar.png', 1, '', NULL, 1, 1513837922, NULL, 1513837922),
(417, '大热常规班', 13, 9, '大热篮球俱乐部', 253, '崔展豪', '崔展豪', 285, 13, '/static/default/avatar.png', 1, '', NULL, 1, 1513837954, NULL, 1513837954),
(418, '大热常规班', 13, 9, '大热篮球俱乐部', 252, '洪旭林', '洪旭林', 284, 13, '/static/default/avatar.png', 1, '', NULL, 1, 1513837976, NULL, 1513837976),
(419, '大热常规班', 13, 9, '大热篮球俱乐部', 251, '石原炜', '石原炜', 283, 6, '/static/default/avatar.png', 1, '', NULL, 1, 1513837999, NULL, 1513837999),
(420, '大热常规班', 13, 9, '大热篮球俱乐部', 250, '王北鲲', '王北鲲', 282, 28, '/static/default/avatar.png', 1, '', NULL, 1, 1513838039, NULL, 1513838039),
(421, '大热常规班', 13, 9, '大热篮球俱乐部', 249, '唐佳诺', '唐佳诺', 281, 28, '/static/default/avatar.png', 1, '', NULL, 1, 1513838064, NULL, 1513838064),
(422, '大热常规班', 13, 9, '大热篮球俱乐部', 248, '刘炜文', '刘炜文', 280, 9, '/static/default/avatar.png', 1, '', NULL, 1, 1513838082, NULL, 1513838082),
(423, '大热常规班', 13, 9, '大热篮球俱乐部', 247, '罗仕杰', '罗仕杰', 279, 3, '/static/default/avatar.png', 1, '', NULL, 1, 1513838112, NULL, 1513838112),
(424, '大热常规班', 13, 9, '大热篮球俱乐部', 246, '王廖聪', '王廖聪', 278, 8, '/static/default/avatar.png', 1, '', NULL, 1, 1513838139, NULL, 1513838139);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lesson_member`
--
ALTER TABLE `lesson_member`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `lesson_member`
--
ALTER TABLE `lesson_member`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
