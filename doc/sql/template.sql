/*
 Navicat Premium Data Transfer

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : hot

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 24/05/2018 14:39:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for template
-- ----------------------------
DROP TABLE IF EXISTS `template`;
CREATE TABLE `template`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `template` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主模板名称,如:客户取消退款通知',
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板编号,用于搜索模板,如:TM00002',
  `t_id` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '默认平台id,即大热管家的模板id',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '\r\n{{first.DATA}}\r\n退款金额：{{keyword1.DATA}}\r\n商品名称：{{keyword2.DATA}}\r\n订单编号：{{keyword3.DATA}}\r\n取消时间：{{keyword4.DATA}}\r\n{{remark.DATA}}\r\n\r\n内容示例:\r\n客户已取消退款申请\r\n退款金额：200.00\r\n商品名称：七匹狼正品 牛皮男士钱包 真皮钱…\r\n订单编号：32401560307008\r\n取消时间：2016年1月9日 16:03\r\n订单已还原成支付状态，请及时发货，',
  `scene` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '使用场景,如:订单页面客户取消退款\\admin页面管理员取消退款',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1:正常|-1:失效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of template
-- ----------------------------
INSERT INTO `template` VALUES (1, '订单支付成功通知', 'xxx?', '', '<p>格式内容：<br />\r\n{{first.DATA}}<br />\r\n用户名：{{keyword1.DATA}}<br />\r\n订单号：{{keyword2.DATA}}<br />\r\n订单金额：{{keyword3.DATA}}<br />\r\n商品信息：{{keyword4.DATA}}<br />\r\n{{remark.DATA}}</p>\r\n\r\n<p>内容示例：<br />\r\n您的订单已支付成功。 &amp;gt;&amp;gt;查看订单详情<br />\r\n用户名：123456789@qingpinji.com<br />\r\n订单号：2015698571200<br />\r\n订单金额：￥98.80<br />\r\n商品信息：星冰乐（焦糖味） &nbsp;家乐氏香甜玉米片*2 &nbsp;乐天七彩爱情糖*3<br />\r\n如有问题请致电xxx客服热线400-8070028或直接在微信留言，客服在线时间为工作日10:00&mdash;&mdash;18:00.客服人员将第一时间为您服务。<br />\r\n&nbsp;</p>\r\n', '<p>app/service/billService/finishBill</p>\r\n\r\n<p>app/service/billService/finishBillNoNotice</p>\r\n\r\n<p>app/service/billService/finishBillSchool</p>\r\n', '<p>支付成功通知用户和训练营管理员/营主</p>\r\n', 1, 1527057325, 1527057325, NULL);
INSERT INTO `template` VALUES (2, '订单支付成功通知', 'xxx??', '', '<p>格式内容：<br />\r\n{{first.DATA}}<br />\r\n用户名：{{keyword1.DATA}}<br />\r\n订单号：{{keyword2.DATA}}<br />\r\n订单金额：{{keyword3.DATA}}<br />\r\n商品信息：{{keyword4.DATA}}<br />\r\n{{remark.DATA}}</p>\r\n\r\n<p>内容示例：<br />\r\n您的订单已支付成功。 &gt;&gt;查看订单详情<br />\r\n用户名：123456789@qingpinji.com<br />\r\n订单号：2015698571200<br />\r\n订单金额：￥98.80<br />\r\n商品信息：星冰乐（焦糖味） &nbsp;家乐氏香甜玉米片*2 &nbsp;乐天七彩爱情糖*3<br />\r\n如有问题请致电xxx客服热线400-8070028或直接在微信留言，客服在线时间为工作日10:00&mdash;&mdash;18:00.客服人员将第一时间为您服务。<br />\r\n&nbsp;</p>\r\n', '<p>app/service/billService/finishBill</p>\r\n\r\n<p>app/service/billService/finishBillNoNotice</p>\r\n\r\n<p>app/service/billService/finishBillSchool</p>\r\n', '<p>支付成功通知用户和训练营管理员/营主</p>\r\n', 1, 1527057407, 1527057541, NULL);

SET FOREIGN_KEY_CHECKS = 1;
