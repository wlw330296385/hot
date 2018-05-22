/*
 Navicat Premium Data Transfer

 Source Server         : 32
 Source Server Type    : MySQL
 Source Server Version : 100126
 Source Host           : 127.0.0.1:3306
 Source Schema         : hot

 Target Server Type    : MySQL
 Target Server Version : 100126
 File Encoding         : 65001

 Date: 22/05/2018 16:18:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for template
-- ----------------------------
DROP TABLE IF EXISTS `template`;
CREATE TABLE `template`  (
  `id` int(11) NOT NULL,
  `template` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '主模板名称,如:客户取消退款通知',
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '模板编号,用于搜索模板,如:TM00002',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '\r\n{{first.DATA}}\r\n退款金额：{{keyword1.DATA}}\r\n商品名称：{{keyword2.DATA}}\r\n订单编号：{{keyword3.DATA}}\r\n取消时间：{{keyword4.DATA}}\r\n{{remark.DATA}}\r\n\r\n内容示例:\r\n客户已取消退款申请\r\n退款金额：200.00\r\n商品名称：七匹狼正品 牛皮男士钱包 真皮钱…\r\n订单编号：32401560307008\r\n取消时间：2016年1月9日 16:03\r\n订单已还原成支付状态，请及时发货，',
  `scene` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '使用场景,如:订单页面客户取消退款\\admin页面管理员取消退款',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1:正常|-1:失效',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
