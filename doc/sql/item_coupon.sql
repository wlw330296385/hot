-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-02-27 10:48:26
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
-- 表的结构 `item_coupon`
--

CREATE TABLE `item_coupon` (
  `id` int(11) UNSIGNED NOT NULL,
  `coupon` varchar(69) NOT NULL COMMENT '卡券名称',
  `target_type` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '-1:活动促销送|1:购买课程赠送 |2:购买活动赠送 |3:产生订单赠送',
  `image_url` varchar(255) NOT NULL DEFAULT '/uploads/images/coupon/woo.jpg' COMMENT '卡片背景图片',
  `price` decimal(8,0) NOT NULL COMMENT '价值',
  `target_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id:赠送的 活动|课程 ',
  `target` varchar(60) NOT NULL COMMENT '对象名称',
  `coupon_des` text NOT NULL COMMENT '卡券描述',
  `contact` varchar(60) NOT NULL DEFAULT '篮球管家' COMMENT '联系人',
  `max` int(10) NOT NULL COMMENT '发布数量',
  `publish` int(11) NOT NULL DEFAULT '0' COMMENT '已发行数量',
  `used` int(11) NOT NULL DEFAULT '0' COMMENT '已使用数量',
  `start` int(11) NOT NULL COMMENT '开始有效期',
  `end` int(11) NOT NULL COMMENT '截止日期',
  `publish_start` int(11) NOT NULL COMMENT '开始发行时间',
  `publish_end` int(11) NOT NULL COMMENT '结束发行时间',
  `organization` varchar(60) NOT NULL COMMENT '平台系统',
  `organization_id` int(11) NOT NULL COMMENT '0:平台',
  `organization_type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1:平台|2:训练营|3:球队',
  `telephone` varchar(40) NOT NULL,
  `member` varchar(60) NOT NULL COMMENT '编辑人|发布人',
  `member_id` int(11) NOT NULL COMMENT '编辑人|发布人',
  `remarks` varchar(255) NOT NULL,
  `system_remarks` varchar(255) NOT NULL,
  `is_max` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否被领取完   1:未被领取完|2:达到max被领取完',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:正常|-1:删除',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='物品卡券';

--
-- 转存表中的数据 `item_coupon`
--

INSERT INTO `item_coupon` (`id`, `coupon`, `target_type`, `image_url`, `price`, `target_id`, `target`, `coupon_des`, `contact`, `max`, `publish`, `used`, `start`, `end`, `publish_start`, `publish_end`, `organization`, `organization_id`, `organization_type`, `telephone`, `member`, `member_id`, `remarks`, `system_remarks`, `is_max`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '佳得乐饮料卡', 1, '/uploads/images/coupon/woo.jpg', '5', 13, '', '<p>-----------------------------------------------------------------</p>系统赠送,使用方法:凭此卷找HO领取饮料一瓶,过期不保!!!<p>-----------------------------------------</p><p>-----------------------------------------------------------------</p>系统赠送,使用方法:凭此卷找HO领取饮料一瓶,过期不保!!!<p>-----------------------------------------</p><p>-----------------------------------------------------------------</p>系统赠送,使用方法:凭此卷找HO领取饮料一瓶,过期不保!!!<p>-----------------------------------------</p><p>-----------------------------------------------------------------</p>系统赠送,使用方法:凭此卷找HO领取饮料一瓶,过期不保!!!<p>-----------------------------------------</p><p>-----------------------------------------------------------------</p>系统赠送,使用方法:凭此卷找HO领取饮料一瓶,过期不保!!!<p>-----------------------------------------</p><p>-----------------------------------------------------------------</p>系统赠送,使用方法:凭此卷找HO领取饮料一瓶,过期不保!!!<p>-----------------------------------------</p>', '篮球管家', 20, 0, 3, 1515321948, 1515427200, 0, 0, '篮球管家', 0, 1, '18507717466', '', 0, '系统赠送', '系统赠送', 1, 1, 0, 0, NULL),
(2, '课程全部', 1, '', '5', 0, '全部课程', '<div class=\"operationDiv\"><h5>佳得乐饮料卡</h5></div>', 'woo', 2, 1, 1, 1516377600, 1516723199, 1516550400, 1516723199, 'wow篮球兴趣训练营', 31, 2, '18507717466', 'woo123', 8, '测试', '', 1, 1, 1516433548, 1516605591, NULL),
(3, '全部活动', 2, '/uploads/images/event/2018/01/thumb_5a62f0b0b05ca.jpg', '5', 0, '全部活动', '<div class=\"operationDiv\"><h5>饮料</h5></div>', 'woo', 2, 0, 0, 1516377600, 1516636799, 1516377600, 1516550399, 'wow篮球兴趣训练营', 31, 2, '18507717466', 'woo123', 8, '测试', '', 1, 1, 1516433602, 1516433602, NULL),
(4, '下午茶课程', 1, '', '5', 51, '下午茶篮球课（有赠送课时）', '<div class=\"operationDiv\"><h5>佳得乐饮料</h5></div>', 'woo', 2, 1, 1, 1516377600, 1516723199, 1516377600, 1516550399, 'wow篮球兴趣训练营', 31, 2, '18507717466', 'woo123', 8, '测试', '', 1, 1, 1516433651, 1516605554, NULL),
(5, '全部订单', 3, '/uploads/images/event/2018/01/thumb_5a62f11d7699c.jpg', '5', 0, '', '<div class=\"operationDiv\"><h5>佳得乐饮料</h5></div>', 'woo', 2, 1, 0, 1516377600, 1516550399, 1516291200, 1516550399, 'wow篮球兴趣训练营', 31, 2, '18507717466', 'woo123', 8, '测试', '', 1, 1, 1516433792, 1516433792, NULL),
(6, '军牌', 2, '/uploads/images/event/2018/01/thumb_5a62fd68c5d8b.JPG', '100', 9, 'KHOT世界花式篮球技巧挑战赛青少年大赛', '<div class=\"operationDiv\"><h5>测试</h5></div><div class=\"operationDiv\"><p>请输入正文</p></div>', '张', 2, 0, 0, 1516377600, 1516550399, 1516377600, 1516351300, '大热篮球俱乐部', 9, 2, '15820474833', 'Hot Basketball 1', 3, '', '', 1, 1, 1516436858, 1516436858, NULL),
(7, '军牌', 2, '/uploads/images/event/2018/01/thumb_5a62feef33b11.JPG', '100', 21, '测试', '<div class=\"operationDiv\"><h5>测试</h5></div>', '张', 2, 1, 1, 1516377600, 1516550399, 1516377600, 1516351297, '大热篮球俱乐部', 9, 2, '15820474833', 'Hot Basketball 1', 3, '', '', 1, 1, 1516437238, 1516437238, NULL),
(8, '测试', 2, '/uploads/images/event/2018/01/thumb_5a6300d5ded2b.JPG', '100', 0, '全部活动', '<div class=\"operationDiv\"><h5>测试</h5></div>', '张', 2, 1, 1, 1516377600, 1516550399, 1516377600, 1516351309, '大热篮球俱乐部', 9, 2, '15820474733', 'Hot Basketball 1', 3, '', '', 1, 1, 1516437728, 1516437728, NULL),
(9, '订制军牌', 1, '/uploads/images/event/2018/01/thumb_5a6a9af5a21aa.jpg', '129', 13, '大热常规班', '<div class=\"operationDiv\"><h5>军牌（可定制名字和号码）</h5></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/01/thumb_5a65b7ff66b71.jpg\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/01/thumb_5a65ba940a57d.jpg\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/01/thumb_5a65ba93b4982.jpg\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div>', '张老师', 10, 3, 0, 1516636800, 1522511999, 1516636800, 1517673599, '大热篮球俱乐部', 9, 2, '15820474733', 'Hot Basketball 1', 3, '抵用券需在有效期内使用', '', 1, 1, 1516604084, 1516935927, NULL),
(10, '测试券', 3, '/uploads/images/event/2018/01/thumb_5a65bb6377dc6.jpeg', '200', 0, '全部课程', '<div class=\"operationDiv\"><h5>测试标题1</h5></div><div class=\"operationDiv\"><p>正文2</p></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/01/thumb_5a65b6a5a14a5.jpeg\" style=\"padding-top: 5px; -webkit-touch-callout: none; -webkit-user-select: none;\"></div>', '叶问', 10, 0, 0, 1516550400, 1529683199, 1516550400, 1534953599, '准行者训练营', 4, 2, '13822555666', 'legend', 6, '测试', '', 1, 1, 1516615338, 1516616550, NULL),
(11, '私人订制军牌', 1, '/uploads/images/event/2018/01/thumb_5a65bc80c11f1.jpg', '129', 0, '全部课程', '<div class=\"operationDiv\"><h5>私人定制军牌</h5></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/01/thumb_5a65bca3cdb72.jpg\" style=\"padding-top:5px\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/01/thumb_5a65bca4114bd.jpg\" style=\"padding-top:5px\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/01/thumb_5a65bca410e5d.jpg\" style=\"padding-top:5px\"></div>', '张老师', 1, 1, 0, 1516550400, 1522511999, 1516550400, 1516530998, '大热篮球俱乐部', 9, 2, '15820474733', 'Hot Basketball 1', 3, '', '', 1, 1, 1516616913, 1516616913, NULL),
(12, '测试', -1, '/uploads/images/coupon/woo.jpg', '1', 1, '', '<p>卡片描述</p>\r\n', '篮球管家', 15, 9, 1, 1517760000, 1517932800, 1517760000, 1517932800, '篮球管家平台', 0, 1, '15820474733', '', 5, '', '', 1, 1, 1517817115, 1517817115, NULL),
(13, '测试', -1, '/uploads/images/coupon/woo.jpg', '999', 2, '', '<p>测试</p>\r\n', '篮球管家', 9999999, 0, 0, 1518192000, 1518192000, 1518192000, 1518192000, '篮球管家平台', 0, 1, '15820474733', '', 5, '', '张老师', 1, -1, 1518247961, 1518247961, NULL),
(14, '定制军牌', 1, '/uploads/images/event/2018/02/thumb_5a94c2616a13f.jpg', '129', 59, '大热常规班', '<div class=\"operationDiv\"><h5>军牌（可定制名字和号码）</h5></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/02/thumb_5a94c2aa472e5.jpg\" style=\"padding-top:5px\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/02/thumb_5a94c2db26d33.jpg\" style=\"padding-top:5px\"></div><div class=\"operationDiv\"><img class=\"desimg\" src=\"/uploads/images/event/2018/02/thumb_5a94c2dae39a8.jpg\" style=\"padding-top:5px\"></div>', '张老师', 10, 0, 0, 1519660800, 1522511999, 1519660800, 1520265599, '大热篮球俱乐部', 9, 2, '15820474733', 'Hot Basketball 1', 3, '抵用券需在有效期内使用', '', 1, 1, 1519698657, 1519698657, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_coupon`
--
ALTER TABLE `item_coupon`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `item_coupon`
--
ALTER TABLE `item_coupon`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
