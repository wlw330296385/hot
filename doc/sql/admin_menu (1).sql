-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-13 16:14:42
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
-- 转存表中的数据 `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `pid`, `module`, `title`, `icon`, `url_type`, `url_value`, `url_target`, `online_hide`, `sort`, `status`, `create_time`, `update_time`) VALUES
(27, 23, 'admin', '平台设置', 'fa fa-cog', 0, 'admin/system/index', '_self', 1, 0, 1, 0, 0),
(2, 0, 'admin', '微信管理', 'fa fa-cog', 0, '', '_self', 1, 0, 1, 0, 0),
(3, 0, 'admin', '训练营', 'fa fa-group', 0, '', '_self', 1, 1, 1, 0, 0),
(4, 0, 'admin', '财务管理', 'fa fa-flag', 0, '', '_self', 1, 2, 1, 0, 0),
(5, 0, 'admin', '会员管理', 'fa fa-user', 0, '', '_self', 1, 3, 1, 0, 0),
(6, 2, 'admin', '菜单管理', 'fa fa-cog', 0, 'admin/weixin/menu', '_self', 1, 0, 1, 0, 0),
(7, 3, 'admin', '训练营管理', 'fa fa-cog', 0, 'admin/camp/index', '_self', 1, 1, 1, 0, 0),
(8, 3, 'admin', '教练管理', 'fa fa-cog', 0, 'admin/coach/index', '_self', 1, 2, 1, 0, 0),
(9, 3, 'admin', '学员管理', 'fa fa-cog', 0, 'admin/student/index', '_self', 1, 3, 1, 0, 0),
(10, 3, 'admin', '班级管理', 'fa fa-cog', 0, 'admin/grade/index', '_self', 1, 4, 1, 0, 0),
(15, 4, 'admin', '支付订单', 'fa fa-cog', 0, 'admin/finance/billlist', '_self', 1, 1, 1, 0, 0),
(11, 3, 'admin', '课程管理', 'fa fa-cog', 0, 'admin/lesson/index', '_self', 1, 5, 1, 0, 0),
(12, 3, 'admin', '课时管理', 'fa fa-cog', 0, 'admin/schedule/index', '_self', 1, 6, 1, 0, 0),
(13, 3, 'admin', '教案管理', 'fa fa-cog', 0, 'admin/plan/index', '_self', 1, 7, 1, 0, 0),
(14, 3, 'admin', '训练项目管理', 'fa fa-cog', 0, 'admin/exercise/index', '_self', 1, 8, 1, 0, 0),
(16, 4, 'admin', '工资收入', 'fa fa-cog', 0, 'admin/finance/salaryinlist', '_self', 1, 2, 1, 0, 0),
(17, 4, 'admin', '提现管理', 'fa fa-cog', 0, 'admin/finance/salaryinlist', '_self', 1, 3, 1, 0, 0),
(18, 4, 'admin', '订单对账', 'fa fa-cog', 0, 'admin/finance/reconciliation', '_self', 1, 4, 1, 0, 0),
(19, 4, 'admin', '缴费统计', 'fa fa-cog', 0, 'admin/finance/tuitionstatis', '_self', 1, 5, 1, 0, 0),
(20, 4, 'admin', '收益统计', 'fa fa-cog', 0, 'admin/finance/earings', '_self', 1, 6, 1, 0, 0),
(21, 5, 'admin', '会员列表', 'fa fa-cog', 0, 'admin/member/memberlist', '_self', 1, 1, 1, 0, 0),
(22, 3, 'admin', '场地管理', 'fa fa-cog', 0, 'admin/court/index', '_self', 1, 0, 1, 0, 0),
(23, 0, 'admin', '系统设置', 'fa fa-cog', 0, 'admin/system/index', '_self', 1, 0, 1, 0, 0),
(24, 0, 'admin', '管理员', 'fa fa-cog', 0, '', '_self', 1, 0, 1, 0, 0),
(25, 24, 'admin', '管理员列表', 'fa fa-cog', 0, 'admin/user/index', '_self', 1, 0, 1, 0, 0),
(1, 0, 'admin', '平台首页', 'fa fa-cog', 0, 'admin/index/index', '_self', 1, 0, 1, 0, 0),
(28, 24, 'admin', '添加管理员', 'fa fa-cog', 0, 'admin/user/create', '_self', 1, 0, 1, 0, 0),
(29, 24, 'admin', '添加管理员接口', 'fa fa-cog', 0, 'admin/user/store', '_self', 0, 0, 1, 0, 0),
(30, 24, 'admin', '查看管理员详情', 'fa fa-cog', 0, 'admin/user/edit', '_self', 0, 0, 1, 0, 0),
(31, 23, 'admin', '平台设置接口', 'fa fa-cog', 0, 'admin/system/editinfo', '_self', 0, 0, 1, 0, 0),
(32, 23, 'admin', '平台banner接口', 'fa fa-cog', 0, 'admin/system/editbanner', '_self', 0, 0, 1, 0, 0),
(33, 23, 'admin', '会员积分设置接口', 'fa fa-cog', 0, 'admin/system/editscore', '_self', 0, 0, 1, 0, 0),
(34, 3, 'admin', '训练营详情', 'fa fa-cog', 0, 'admin/camp/show', '_self', 0, 0, 1, 0, 0),
(35, 3, 'admin', '修改训练营信息', 'fa fa-cog', 0, 'admin/camp/edit', '_self', 0, 0, 1, 0, 0),
(36, 3, 'admin', '审核训练营申请', 'fa fa-cog', 0, 'admin/camp/audit', '_self', 0, 0, 1, 0, 0),
(37, 3, 'admin', '软删除', 'fa fa-cog', 0, 'admin/camp/sdel', '_self', 0, 0, 1, 0, 0),
(38, 3, 'admin', '设置当前查看训练营', 'fa fa-cog', 0, 'admin/camp/setcur', '_self', 0, 0, 1, 0, 0),
(39, 3, 'admin', '清理缓存', 'fa fa-cog', 0, 'admin/camp/clearcur', '_self', 0, 0, 1, 0, 0),
(40, 3, 'admin', '修改训练营状态', 'fa fa-cog', 0, 'admin/camp/editstatus', '_self', 0, 0, 1, 0, 0),
(41, 3, 'admin', '教练详情', 'fa fa-cog', 0, 'admin/coach/show', '_self', 0, 0, 1, 0, 0),
(42, 3, 'admin', '教练审核', 'fa fa-cog', 0, 'admin/coach/edit', '_self', 0, 0, 1, 0, 0),
(43, 3, 'admin', '软删除教练', 'fa fa-cog', 0, 'admin/coach/sdel', '_self', 0, 0, 1, 0, 0),
(44, 3, 'admin', '修改教练信息', 'fa fa-cog', 0, 'admin/camp/edit', '_self', 0, 0, 1, 0, 0),
(45, 3, 'admin', '场地详情', 'fa fa-cog', 0, 'admin/court/detail', '_self', 0, 0, 1, 0, 0),
(46, 3, 'admin', '场地审核', 'fa fa-cog', 0, 'admin/court/audit', '_self', 0, 0, 1, 0, 0),
(47, 3, 'admin', ' 管理 训练营/教练发布 训练项目', 'fa fa-cog', 0, 'admin/exercise/lists', '_self', 0, 0, 1, 0, 0),
(48, 3, 'admin', '创建项目视图', 'fa fa-cog', 0, 'admin/exercise/create', '_self', 0, 0, 1, 0, 0),
(49, 3, 'admin', '项目详情视图', 'fa fa-cog', 0, 'admin/exercise/show', '_self', 0, 0, 1, 0, 0),
(50, 3, 'admin', '储存项目数据', 'fa fa-cog', 0, 'admin/exercise/store', '_self', 0, 0, 1, 0, 0),
(51, 3, 'admin', '更新项目', 'fa fa-cog', 0, 'admin/exercise/update', '_self', 0, 0, 1, 0, 0),
(52, 3, 'admin', '(软)删除项目数据', 'fa fa-cog', 0, 'admin/exercise/del', '_self', 0, 0, 1, 0, 0),
(53, 3, 'admin', '审核训练项目(不单独)', 'fa fa-cog', 0, 'admin/exercise/audit', '_self', 0, 0, 1, 0, 0),
(54, 3, 'admin', '教案训练项目列表', 'fa fa-cog', 0, 'admin/plan/exerciseLsit', '_self', 0, 0, 1, 0, 0),
(55, 3, 'admin', '创建教案', 'fa fa-cog', 0, 'admin/plan/create', '_self', 0, 0, 1, 0, 0),
(56, 3, 'admin', '教案发布列表', 'fa fa-cog', 0, 'admin/plan/manage', '_self', 1, 0, 1, 0, 0),
(57, 3, 'admin', '训练项目html', 'fa fa-cog', 0, 'admin/plan/exercise_setected_html', '_self', 0, 0, 1, 0, 0),
(58, 3, 'admin', '处理组合所选项目', 'fa fa-cog', 0, 'admin/plan/headleselected', '_self', 0, 0, 1, 0, 0),
(59, 3, 'admin', 'ajax训练项目', 'fa fa-cog', 0, 'admin/plan/ajaxselected', '_self', 0, 0, 1, 0, 0),
(60, 3, 'admin', '存储教案', 'fa fa-cog', 0, 'admin/plan/store', '_self', 0, 0, 1, 0, 0),
(61, 3, 'admin', '教案详情', 'fa fa-cog', 0, 'admin/plan/show', '_self', 0, 0, 1, 0, 0),
(62, 3, 'admin', '教案更新', 'fa fa-cog', 0, 'admin/plan/update', '_self', 0, 0, 1, 0, 0),
(63, 3, 'admin', '教案审核', 'fa fa-cog', 0, 'admin/plan/audit', '_self', 0, 0, 1, 0, 0),
(64, 4, 'admin', '订单详情', 'fa fa-cog', 0, 'admin/finance/bill', '_self', 0, 0, 1, 0, 0),
(65, 4, 'admin', '收入记录列表', 'fa fa-cog', 0, 'admin/finance/salaryinlist', '_self', 0, 0, 1, 0, 0),
(66, 4, 'admin', '收入详情记录', 'fa fa-cog', 0, 'admin/finance/salaryin', '_self', 0, 0, 1, 0, 0),
(67, 4, 'admin', '提现记录列表', 'fa fa-cog', 0, 'admin/finance/salaryoutlist', '_self', 0, 0, 1, 0, 0),
(68, 4, 'admin', '提现详情', 'fa fa-cog', 0, 'admin/finance/salaryout', '_self', 0, 0, 1, 0, 0),
(69, 4, 'admin', '订单对账', 'fa fa-cog', 0, 'admin/finance/reconciliation', '_self', 0, 0, 1, 0, 0),
(70, 4, 'admin', '缴费统计', 'fa fa-cog', 0, 'admin/finance/tuitionstatis', '_self', 0, 0, 1, 0, 0),
(71, 4, 'admin', '收益统计', 'fa fa-cog', 0, 'admin/finance/earings', '_self', 0, 0, 1, 0, 0),
(72, 3, 'admin', '班级详情', 'fa fa-cog', 0, 'admin/grade/show', '_self', 0, 0, 1, 0, 0),
(73, 3, 'admin', '课程详情', 'fa fa-cog', 0, 'admin/lesson/detail', '_self', 0, 0, 1, 0, 0),
(74, 3, 'admin', '课程编辑', 'fa fa-cog', 0, 'admin/lesson/audit', '_self', 0, 0, 1, 0, 0),
(75, 3, 'admin', '课程软删除', 'fa fa-cog', 0, 'admin/lesson/del', '_self', 0, 0, 1, 0, 0),
(76, 3, 'admin', 'acalendar', 'fa fa-cog', 0, 'admin/schedule/calendar', '_self', 0, 0, 1, 0, 0),
(77, 3, 'admin', '课时详情', 'fa fa-cog', 0, 'admin/schedule/detail', '_self', 0, 0, 1, 0, 0),
(78, 3, 'admin', '学生详情', 'fa fa-cog', 0, 'admin/student/show', '_self', 0, 0, 1, 0, 0),
(79, 2, 'admin', 'menu', 'fa fa-cog', 0, 'admin/wechat/menu', '_self', 0, 0, 1, 0, 0),
(80, 24, 'admin', '修改管理员', 'fa fa-cog', 0, 'admin/user/update', '_self', 0, 0, 1, 0, 0),
(81, 3, 'admin', '购买课程', 'fa fa-cog', 0, 'admin/lesson/buyLesson', '_self', 0, 0, 1, 0, 0),
(82, 5, 'admin', '创建会员', 'fa fa-cog', 0, 'admin/member/createMmeber', '_self', 0, 0, 1, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
