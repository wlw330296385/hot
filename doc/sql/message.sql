-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-22 12:15:06
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
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(240) NOT NULL,
  `content` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_system` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:系统消息:2训练营消息',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1未读|0过期|2已读'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`id`, `title`, `content`, `url`, `is_system`, `create_time`, `update_time`, `delete_time`, `status`) VALUES
(1, '课程大热幼儿班已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091826474260<br /> 金额:0<br /> 商品信息:123预约体验大热幼儿班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/17', 2, 1507544809, 1507544809, 1509443938, 1),
(2, '课程超级控球手已被申请体验,请及时处理', '用户名:123<br /> 订单编号:1201710091830393947<br /> 金额:0<br /> 商品信息:123预约体验超级控球手', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/18', 2, 1507545041, 1507545041, 1509443938, 1),
(3, '订单支付成功通知', '用户名:小霖<br /> 订单编号:1201710101809377908<br /> 金额:10元<br /> 商品信息:小霖购买校园兴趣班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/19', 2, 1507630200, 1507630200, 1509443938, 1),
(4, '您好,您所发布的荣光场场地资源被选为平台公开场地', '您好,您所发布的荣光场场地资源被选为平台公开场地', 'https://m.hot-basketball.com/frontend/camp/courtlistofcamp/camp_id/5', 1, 1507718136, 0, 1509443938, 1),
(5, '您好,您所发布的阳光文体中心迷你场场地资源被选为平台公开场地', '您好,您所发布的阳光文体中心迷你场场地资源被选为平台公开场地', 'https://m.hot-basketball.com/frontend/camp/courtlistofcamp/camp_id/4', 1, 1507718142, 0, 1509443938, 1),
(6, '订单支付成功通知', '用户名:张晨儒<br /> 订单编号:1201710112133332733<br /> 金额:1500元<br /> 商品信息:张晨儒购买周日北头高年级初中班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/20', 2, 1507728831, 1507728831, 1509443938, 1),
(7, '体验课预约申请成功', '用户名:刘嘉<br /> 订单编号:1201710131538143724<br /> 金额:0元<br /> 商品信息:刘嘉预约体验超级控球手', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/21', 2, 1507880298, 1507880298, 1509443938, 1),
(8, '加入训练营申请', '会员 weilin666申请加入荣光训练营 成为 教练, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/5/status/0', 2, 1507890574, 0, 1509443938, 1),
(9, '体验课预约申请成功', '用户名:儿童劫<br /> 订单编号:1201710141011107532<br /> 金额:0元<br /> 商品信息:儿童劫预约体验荣光篮球强化', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/22', 2, 1507947074, 1507947074, 1509443938, 1),
(10, '加入训练营申请', '会员 weilin666申请加入荣光训练营 成为 教练, 请及时处理', '/frontend/camp/coachlistofcamp/camp_id/5/status/0/openid/o83291GqxP1FCqmfVncltkGVWPaY', 2, 1507948855, 0, 1509443938, 1),
(11, '加入训练营申请', '会员 weilin666申请加入荣光训练营 成为 教练, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/5/status/0/openid/o83291GqxP1FCqmfVncltkGVWPaY', 2, 1507948896, 0, 1509443938, 1),
(12, '加入训练营申请', '会员 Hot777申请加入齐天大热 成为 教练, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/coachlistofcamp/camp_id/3/status/0/openid/o83291IEM6JPXsCe5bIT_XRt2oes', 2, 1507972577, 0, 1509443938, 1),
(13, '加入训练营申请', '会员 HoChen申请加入热风学校 成为 管理员, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/16/status/0/openid/o83291I0HI28QoLyldPwvPnPExQQ', 2, 1508040916, 0, 1509443938, 1),
(14, '加入训练营申请', '会员 legend申请加入大热篮球俱乐部 成为 管理员, 请及时处理', 'https://m.hot-basketball.com/frontend/camp/teachlistofcamp/camp_id/9/status/0/openid/o83291FaVoul_quMxTYAOHt-NmHg', 2, 1508055043, 0, 1509443938, 1),
(15, '订单支付成功通知', '用户名:123<br /> 订单编号:1201710151832555913<br /> 金额:10元<br /> 商品信息:123购买校园兴趣班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/23', 2, 1508063598, 1508063598, 1509443938, 1),
(16, '订单支付成功通知', '用户名:陈佳佑<br /> 订单编号:1201710171017193132<br /> 金额:1元<br /> 商品信息:陈佳佑购买超级射手班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/26', 2, 1508206651, 1508206651, 1509443938, 1),
(17, '订单支付成功通知', '用户名:陈佳佑<br /> 订单编号:1201710171027563375<br /> 金额:1元<br /> 商品信息:陈佳佑购买超级射手班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/27', 2, 1508207329, 1508207329, 1509443938, 1),
(18, '订单支付成功通知', '用户名:邓赖迪<br /> 订单编号:1201710172007052272<br /> 金额:1500元<br /> 商品信息:邓赖迪购买周六上午十点低年级班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/28', 2, 1508242057, 1508242057, 1509443938, 1),
(19, '体验课预约申请成功', '用户名:123<br /> 订单编号:1201710191424259051<br /> 金额:0元<br /> 商品信息:123预约体验校园兴趣班', 'https://m.hot-basketball.com/frontend/bill/billinfo/bill_id/31', 2, 1508394269, 1508394269, 1509443938, 1),
(20, '退款申请-超级射手班', '订单号: 1201710171027563375<br/>退款金额: 1元<br/>退款理由:申请退款测试', '/frontend/bill/billinfoofcamp/id/29', 1, 1508409464, 1508409464, 1509443938, 1),
(22, '退款申请-超级射手班', '订单号: 1201710171027563375<br/>退款金额: 1元<br/>退款理由:申请退款测试', '/frontend/bill/billinfoofcamp/id/29', 1, 1508409464, 1508409464, 1509443938, 1),
(24, '退款申请-超级射手班', '订单号: 1201710171027563375<br/>退款金额: 1元<br/>退款理由:申请退款测试', '/frontend/bill/billinfoofcamp/id/29', 1, 1508409464, 1508409464, 1509443938, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
