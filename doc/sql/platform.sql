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

 Date: 24/05/2018 14:39:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for platform
-- ----------------------------
DROP TABLE IF EXISTS `platform`;
CREATE TABLE `platform`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `platform` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信平台名称',
  `company` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公司名称',
  `camp` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '关联的训练营名称',
  `camp_id` int(11) NOT NULL COMMENT '关联的训练营id',
  `appsecret` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `appid` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登陆账号',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登陆密码',
  `wechat` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '授权的微信号(不管存微信账号密码)',
  `encodingaeskey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `state` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mchid` int(11) NOT NULL,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '注：key为商户平台设置的密钥key',
  `sslcert_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '证书地址',
  `sslkey_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '证书密钥',
  `sms_appid` int(11) NOT NULL COMMENT '短信通道',
  `sms_secret` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信密钥',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `system_remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1:正常|-1:禁用',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '平台表(微信)' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of platform
-- ----------------------------
INSERT INTO `platform` VALUES (1, '1213', '111', '11', 113, '123123', '11121', '1132', '313123', '123213', '13213', '13213', 123123, '13123', '13123', '13213', 13213, '12313', '1313', '13123', 1, 0, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
