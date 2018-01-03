-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-01-03 15:48:25
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
-- 表的结构 `follow`
--

CREATE TABLE `follow` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '关注实体:1会员|2训练营|3班级|4球队',
  `follow_id` int(11) NOT NULL DEFAULT '0' COMMENT '被关注实体id',
  `follow_name` varchar(100) NOT NULL COMMENT '被关注实体name',
  `follow_avatar` varchar(255) NOT NULL COMMENT '被关注实体头像',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `member` varchar(100) NOT NULL COMMENT '会员名',
  `member_avatar` varchar(200) DEFAULT NULL COMMENT '会员头像',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:关注|-1取消关注',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员关注表';

--
-- 转存表中的数据 `follow`
--

INSERT INTO `follow` (`id`, `type`, `follow_id`, `follow_name`, `follow_avatar`, `member_id`, `member`, `member_avatar`, `status`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 1, 18, '18566201712', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3oGkQMmHhLG7AE2Zh7Jog/0', 0, '戒驕戒躁', 'https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEKhPI49B5FOlFDiaBpFeibibm9MKokGIbFDS62fakBxmMAlYRkuicsjlJ', 1, 1511591264, 1511591264, NULL),
(2, 1, 18, '18566201712', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3oGkQMmHhLG7AE2Zh7Jog/0', 180, '戒驕戒躁', 'https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEKhPI49B5FOlFDiaBpFeibibm9MKokGIbFDS62fakBxmMAlYRkuicsjlJ', 1, 1511591485, 1511591485, NULL),
(3, 1, 18, '18566201712', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3oGkQMmHhLG7AE2Zh7Jog/0', 181, '康庄', 'https://wx.qlogo.cn/mmopen/vi_32/w2iaPb2jRdAJcAVILBArvq1LmIBEdm7FicP4e3R03tj6V0buYibrrdke8wIBwlKwTIe', 1, 1511591496, 1511591496, NULL),
(4, 2, 13, 'AKcross训练营', '/static/frontend/images/uploadDefault.jpg', 180, '戒驕戒躁', 'https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEKhPI49B5FOlFDiaBpFeibibm9MKokGIbFDS62fakBxmMAlYRkuicsjlJ', 1, 0, 1511591594, NULL),
(5, 1, 16, 'andy.lin', 'https://wx.qlogo.cn/mmopen/vi_32/IolbUoRiaibzjwML7wBHb3QWHVRSDcNQ27jlY2NyaWC0nib62dOic5ZrLRSOVIa24aO8F56icBwKa4oIZha00VibXBwA/0', 0, '游客', '/static/default/avatar.png', 1, 1511600454, 1511600496, 1511600496),
(6, 2, 18, '劉嘉興', '/uploads/images/banner/2017/11/5a069d9a6be7c.jpg', 7, 'wayen_z', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJsb6yF8nF3I5eGmQT8zoRicAaF9QjfTbHwBofiaa5tIHUpRqMicicth5S', -1, 1511620364, 1511620368, NULL),
(7, 1, 6, 'legend', 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 7, 'wayen_z', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJsb6yF8nF3I5eGmQT8zoRicAaF9QjfTbHwBofiaa5tIHUpRqMicicth5S', -1, 1511620400, 1511620402, NULL),
(8, 2, 15, '钟声训练营', '/uploads/images/banner/2017/11/5a1457b0a10dc.jpeg', 19, '钟声', 'https://wx.qlogo.cn/mmopen/vi_32/GYJRqVSbrHfNr7k1CeGBmBuklcV9AsrabdT7L2ocyibnk3ooib4zuJnHN1pviakXZic', -1, 1511785996, 1511786027, NULL),
(9, 2, 9, '大热篮球俱乐部', '/uploads/images/banner/2017/09/59ce0f0bb2253.JPG', 184, '涵叔', 'https://wx.qlogo.cn/mmopen/vi_32/cqBEzwNofgU0q5AibEBVP9liaTtO9icWMIN52Q5XQibbdpDjE6KKxezn502D5bicxN6', 1, 0, 0, NULL),
(10, 2, 5, '荣光训练营', '/uploads/images/banner/2017/09/59cc5d0d7ab73.jpg', 7, 'wayen_z', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJsb6yF8nF3I5eGmQT8zoRicAaF9QjfTbHwBofiaa5tIHUpRqMicicth5S', 1, 1512393375, 1512393375, NULL),
(11, 2, 3, '猴赛雷训练营', '/uploads/images/banner/2017/09/59ca09d5916c4.jpg', 6, 'legend', 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOX', 1, 1512531587, 1512531587, NULL),
(12, 2, 5, '荣光训练营', '/uploads/images/banner/2017/09/59cc5d0d7ab73.jpg', 4, 'weilin666', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJXZOE1LAocibpESZQmicYIiaV9xNgKdLRgdL4Hn7omXHdFTwqJTphdHFh', 1, 1512959800, 1512959800, NULL),
(13, 2, 5, '荣光训练营', '/uploads/images/banner/2017/09/59cc5d0d7ab73.jpg', 216, 'BINGOZ', 'https://wx.qlogo.cn/mmopen/vi_32/8rMmB8svaRUPd4cQwGMccYnsafQkCbhYRTvXFJXp8jsH326oAMicMuceNLiarlLjlWm', 1, 0, 0, NULL),
(14, 2, 3, '猴赛雷训练营', '/uploads/images/banner/2017/09/59ca09d5916c4.jpg', 217, 'BINGOZ', 'https://wx.qlogo.cn/mmopen/vi_32/8rMmB8svaRUPd4cQwGMccYnsafQkCbhYRTvXFJXp8jsH326oAMicMuceNLiarlLjlWm', 1, 0, 0, NULL),
(15, 2, 13, 'AKcross训练营', '/static/frontend/images/uploadDefault.jpg', 18, '18566201712', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3', 1, 1513134076, 1513134076, NULL),
(16, 2, 19, '17体适能', '/uploads/images/banner/2017/12/5a30c7af9672b.jpeg', 18, '18566201712', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3', 1, 0, 0, NULL),
(17, 2, 19, '17体适能', '/uploads/images/banner/2017/12/5a30c7af9672b.jpeg', 16, 'andy.lin', 'https://wx.qlogo.cn/mmopen/vi_32/IolbUoRiaibzjwML7wBHb3QWHVRSDcNQ27jlY2NyaWC0nib62dOic5ZrLRSOVIa24aO', 1, 0, 0, NULL),
(18, 2, 3, '猴赛雷训练营', '/uploads/images/banner/2017/09/59ca09d5916c4.jpg', 219, 'BINGOZ', 'https://wx.qlogo.cn/mmopen/vi_32/8rMmB8svaRUPd4cQwGMccYnsafQkCbhYRTvXFJXp8jsH326oAMicMuceNLiarlLjlWm', 1, 0, 0, NULL),
(19, 2, 2, '大热前海训练营', '/uploads/images/banner/2017/09/59ca0937e193b.jpg', 2, 'Hot-basketball2', 'https://wx.qlogo.cn/mmopen/vi_32/hRnMzjwHkMNhoQiaP1tATWgTvEvsNTQibWEysfJnEQ9hS50ZiatuR7XkPjdCzIib5Zj', 1, 0, 0, NULL),
(20, 2, 19, '17体适能', '/uploads/images/banner/2017/12/5a30c7af9672b.jpeg', 1, 'HoChen', 'https://wx.qlogo.cn/mmopen/vi_32/SibkSPyDCsQgsldCSicKXvqPNPvb17ibRBGl7sEWGx9ZUXYjuIRavp1UDiaMGRyC0J5', -1, 1513224135, 1513224140, NULL),
(21, 2, 4, '准行者训练营', '/uploads/images/banner/2017/09/59ca142b31f86.JPG', 1, 'HoChen', 'https://wx.qlogo.cn/mmopen/vi_32/SibkSPyDCsQgsldCSicKXvqPNPvb17ibRBGl7sEWGx9ZUXYjuIRavp1UDiaMGRyC0J5', 1, 1513237962, 1513237962, NULL),
(22, 2, 3, '猴赛雷训练营', '/uploads/images/banner/2017/09/59ca09d5916c4.jpg', 227, 'BINGOZ', 'https://wx.qlogo.cn/mmopen/vi_32/8rMmB8svaRUPd4cQwGMccYnsafQkCbhYRTvXFJXp8jsH326oAMicMuceNLiarlLjlWm', 1, 0, 0, NULL),
(23, 2, 13, 'AKcross训练营', '/static/frontend/images/uploadDefault.jpg', 3, 'Hot Basketball 1', 'https://wx.qlogo.cn/mmopen/vi_32/vJYBxqAI4qV7pRBsbHSBUw83PrV2BH8hkY1vV4LebwTKe2GRPvwRDF8LlpjuRS5rBBg', 1, 0, 0, NULL),
(24, 2, 9, '大热篮球俱乐部', '/uploads/images/banner/2017/09/59ce0f0bb2253.JPG', 229, 'BINGOZ', 'https://wx.qlogo.cn/mmopen/vi_32/8rMmB8svaRUPd4cQwGMccYnsafQkCbhYRTvXFJXp8jsH326oAMicMuceNLiarlLjlWm', 1, 0, 0, NULL),
(25, 2, 29, '深圳市南山区桃源街道篮球协会', '/uploads/images/banner/2017/12/5a337f0ddd3fe.jpg', 18, 'AK', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3', 1, 1513740507, 1513740507, NULL),
(26, 2, 29, '深圳市南山区桃源街道篮球协会', '/uploads/images/banner/2017/12/5a337f0ddd3fe.jpg', 18, 'AK', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3', 1, 0, 0, NULL),
(27, 2, 17, 'FIT', '/static/frontend/images/uploadDefault.jpg', 18, 'AK', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3', 1, 0, 1513740573, NULL),
(28, 2, 14, 'Ball  is  life', '/uploads/images/banner/2017/10/59e1839a81d25.jpeg', 18, 'AK', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3', 1, 1513740606, 1513740606, NULL),
(29, 2, 14, 'Ball  is  life', '/uploads/images/banner/2017/10/59e1839a81d25.jpeg', 18, 'AK', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3', 1, 0, 0, NULL),
(30, 2, 13, 'AKcross训练营', '/static/frontend/images/uploadDefault.jpg', 16, 'andy.lin', 'https://wx.qlogo.cn/mmopen/vi_32/IolbUoRiaibzjwML7wBHb3QWHVRSDcNQ27jlY2NyaWC0nib62dOic5ZrLRSOVIa24aO', 1, 0, 0, NULL),
(31, 2, 13, 'AKcross训练营', '/static/frontend/images/uploadDefault.jpg', 17, 'Bruce.Dong', 'https://wx.qlogo.cn/mmopen/vi_32/hcLPwracBdo0ciclAv1D5nFykDibNOSMzIwRicn3N8mNsu9HQrNWSS1S0cGy5EwXfqF', 1, 0, 0, NULL),
(32, 2, 17, 'FIT', '/static/frontend/images/uploadDefault.jpg', 17, 'Bruce.Dong', 'https://wx.qlogo.cn/mmopen/vi_32/hcLPwracBdo0ciclAv1D5nFykDibNOSMzIwRicn3N8mNsu9HQrNWSS1S0cGy5EwXfqF', 1, 0, 0, NULL),
(33, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 18, 'AK', 'https://wx.qlogo.cn/mmopen/vi_32/52eZlEWhZMmfqDH2kqBDicDAqBeq5ryLR8X6RyOZb2D3SVCEJWLTw90fOW2CVeoncA3', 1, 0, 0, NULL),
(34, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 2, 'Hot-basketball2', 'https://wx.qlogo.cn/mmopen/vi_32/hRnMzjwHkMNhoQiaP1tATWgTvEvsNTQibWEysfJnEQ9hS50ZiatuR7XkPjdCzIib5Zj', -1, 1513742511, 1513742516, NULL),
(35, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 5, '+*', 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYID', 1, 1513742512, 1513742512, NULL),
(36, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 78, '张雅璐', 'https://wx.qlogo.cn/mmopen/vi_32/WPDdAKibD9e6HTQM38lcVmEPCSOljciaUwicgN1eyzApz83nDpFHna5asP62Gx3kGVy', 1, 1513742696, 1513742696, NULL),
(37, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 17, 'Bruce.Dong', 'https://wx.qlogo.cn/mmopen/vi_32/hcLPwracBdo0ciclAv1D5nFykDibNOSMzIwRicn3N8mNsu9HQrNWSS1S0cGy5EwXfqF', 1, 0, 0, NULL),
(40, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 21, 'Bingo', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTL2ZoHxVIic5SlydeEBSayd4F29BFSmGIYicWlOChxbsA3TCAiczib043F', 1, 1513743119, 1513743119, NULL),
(41, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 12, 'willng', 'https://wx.qlogo.cn/mmopen/vi_32/u0hn2SHI1D1dbhYlZibicIjWzySCmtmiaaW5ta7PLc3DsDV6Ks90OBGUtMKbwTnZ2Av', 1, 0, 0, NULL),
(42, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 7, 'wayen_z', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJsb6yF8nF3I5eGmQT8zoRicAaF9QjfTbHwBofiaa5tIHUpRqMicicth5S', 1, 1513743191, 1513743191, NULL),
(43, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 21, 'Bingo', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTL2ZoHxVIic5SlydeEBSayd4F29BFSmGIYicWlOChxbsA3TCAiczib043F', 1, 0, 0, NULL),
(44, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 8, 'woo123', 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDs', 1, 1513743285, 1513743285, NULL),
(45, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 9, 'GaoYan', 'https://wx.qlogo.cn/mmopen/vi_32/ctgjGIoTXvGgGdMuicTg0JJ06laxfIjySYQxxibQdj62ORwYuBOA5dJJMJ1XDmVTyzg', 1, 1513743330, 1513743330, NULL),
(47, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 5, '+*', 'https://wx.qlogo.cn/mmopen/vi_32/4wmcUneiaLIZeia25x7p78ZflJibmte1q1p4td6PVoj9Tib9tghV8g3c3qd3VUNHYID', 1, 0, 0, NULL),
(48, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 16, 'andy.lin', 'https://wx.qlogo.cn/mmopen/vi_32/IolbUoRiaibzjwML7wBHb3QWHVRSDcNQ27jlY2NyaWC0nib62dOic5ZrLRSOVIa24aO', -1, 1513744477, 1513744479, NULL),
(52, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 4, 'weilin666', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJXZOE1LAocibpESZQmicYIiaV9xNgKdLRgdL4Hn7omXHdFTwqJTphdHFh', 1, 1513757680, 1513757680, NULL),
(54, 2, 31, 'woo篮球兴趣训练营', '/uploads/images/banner/2017/12/5a39dd299e3ee.jpeg', 6, 'legend', 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', -1, 1513758021, 1514948265, NULL),
(55, 2, 1, '大热体适能中心', '/uploads/images/banner/2017/09/59ca092820279.JPG', 307, 'chupa', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83era0ibfHEVq9vA0C8icJttsvVWMwg07MOxibzR7vddtaqIUAStzJKP6dbsBatQeq9hmp9SRfrhpsjgiag/0', 1, 1514005243, 1514005243, NULL),
(56, 2, 34, 'BALON篮球训练营', '/static/frontend/images/uploadDefault.jpg', 2, 'Hot-basketball2', 'https://wx.qlogo.cn/mmopen/vi_32/hRnMzjwHkMNhoQiaP1tATWgTvEvsNTQibWEysfJnEQ9hS50ZiatuR7XkPjdCzIib5ZjE4CxXUXo7eAwnnWZZhqGTJQ/0', 1, 1514259397, 1514259397, NULL),
(57, 2, 9, '大热篮球俱乐部', '/uploads/images/banner/2017/09/59ce0f0bb2253.JPG', 317, '秋雨', 'https://wx.qlogo.cn/mmopen/vi_32/SIwmgwavmFcoyaWfgricbvryiakPxxvmn0rGcZZ6AqaWDic94tQHal6B86ffPXHlwO86ibs3IyDatwiahZZWXMKC4yA/0', 1, 1514288786, 1514288786, NULL),
(58, 2, 13, 'AKcross训练营', '/uploads/images/banner/2017/12/5a39ddf63d709.jpeg', 78, '张雅璐', 'https://wx.qlogo.cn/mmopen/vi_32/WPDdAKibD9e6HTQM38lcVmEPCSOljciaUwicgN1eyzApz83nDpFHna5asP62Gx3kGVylCRbvFAibarypnc5Rue3Y7Q/0', 1, 1514289001, 1514289001, NULL),
(59, 4, 1, '丽山篮球队', '/uploads/images/team/2017/12/5a33d47e4874a.jpg', 257, '潘乐航', '/static/default/avatar.png', 1, 1514464855, 1514464855, NULL),
(60, 2, 32, '燕子Happy篮球训练营', '/uploads/images/banner/2017/12/5a3a304600acf.jpeg', 1, 'HoChen', 'https://wx.qlogo.cn/mmopen/vi_32/SibkSPyDCsQgsldCSicKXvqPNPvb17ibRBGl7sEWGx9ZUXYjuIRavp1UDiaMGRyC0J57ulsAOxQCvn0eBhP8UXp4UA/0', -1, 1514513260, 1514960784, NULL),
(61, 2, 13, 'AKcross训练营', '/uploads/images/banner/2017/12/5a39ddf63d709.jpeg', 14, 'MirandaXian', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKic6bHKticocJYeku4Tvq5O8EKy3dSct1zibMw9lsE2zKqSjd9QGnw3732LUT1crga45puTKrE7W74w/0', 1, 1514538363, 1514538363, NULL),
(62, 2, 33, 'B—Ball 篮球训练营', '/uploads/images/banner/2017/12/5a41ba64170ac.jpg', 229, 'BINGOZ', 'https://wx.qlogo.cn/mmopen/vi_32/8rMmB8svaRUPd4cQwGMccYnsafQkCbhYRTvXFJXp8jsH326oAMicMuceNLiarlLjlWmh8Fb7fVUNxTmPyicz5Yg6Q/0', 1, 1514884769, 1514884769, NULL),
(63, 2, 33, 'B—Ball 篮球训练营', '/uploads/images/banner/2017/12/5a41ba64170ac.jpg', 6, 'legend', 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, 1514885968, 1514885968, NULL),
(64, 1, 33, 'B—Ball 篮球训练营', '/uploads/images/banner/2017/12/5a41ba64170ac.jpg', 6, 'legend', 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, 1514886100, 0, NULL),
(65, 1, 33, 'B—Ball 篮球训练营', '/uploads/images/banner/2017/12/5a41ba64170ac.jpg', 229, 'BINGOZ', 'https://wx.qlogo.cn/mmopen/vi_32/8rMmB8svaRUPd4cQwGMccYnsafQkCbhYRTvXFJXp8jsH326oAMicMuceNLiarlLjlWmh8Fb7fVUNxTmPyicz5Yg6Q/0', 1, 1514886934, 0, NULL),
(66, 2, 34, 'BALON篮球训练营', '/static/frontend/images/uploadDefault.jpg', 8, 'woo123', 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1, 1514950451, 1514950451, NULL),
(67, 1, 34, 'BALON篮球训练营', '/static/frontend/images/uploadDefault.jpg', 8, 'woo123', 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1, 1514950515, 0, NULL),
(68, 2, 15, '钟声训练营', '/uploads/images/banner/2018/01/5a4b65ee091ec.jpeg', 8, 'woo123', 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1, 1514950616, 1514950616, NULL),
(71, 2, 32, '燕子Happy篮球训练营', '/uploads/images/banner/2017/12/5a3a304600acf.jpeg', 6, 'legend', 'https://wx.qlogo.cn/mmopen/vi_32/kPQuy2sgweMDtTBHQ63ngsZXARzt6w4j9b9Gl0vwOz68tBBxmLicsRZWKNLXazMDhOXMvCy3g8flBBgAqjLzGMg/0', 1, 1514961006, 1514961006, NULL),
(72, 2, 4, '准行者训练营', '/uploads/images/banner/2017/09/59ca142b31f86.JPG', 8, 'woo123', 'https://wx.qlogo.cn/mmopen/vi_32/7hqMZOicFZ04xvw7WR5WgVg5SzczBuzkrmXeWQnCfTvIc0bvAMy1dfFFHOMCqUIQFDslM2x6Iq8n0zv9eG3gtLw/0', 1, 1514964224, 1514964375, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `follow`
--
ALTER TABLE `follow`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
