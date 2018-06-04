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

 Date: 04/06/2018 12:01:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for apps_apply
-- ----------------------------
DROP TABLE IF EXISTS `apps_apply`;
CREATE TABLE `apps_apply`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户填写的其他html',
  `member` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL COMMENT '关联外键',
  `realname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '类型',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态',
  `remarks` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户备注',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of apps_apply
-- ----------------------------
INSERT INTO `apps_apply` VALUES (1, '<ul class=\"diyList\"><li><span class=\"fTitle\">性别</span><span class=\"fValue\">男</span></li><li><span class=\"fTitle\">所属社区</span><span class=\"fValue\">广东省深圳市阳光文体中心</span></li><li><span class=\"fTitle\">居住地</span><span class=\"fValue\">广东省深圳市阳光文体中心</span></li><li><span class=\"fTitle\">籍贯</span><span class=\"fValue\">广东省深圳市阳光文体中心</span></li><li><span class=\"fTitle\">身份证号码</span><span class=\"fValue\">14156465465</span></li><li><span class=\"fTitle\">身份证</span><span class=\"fValue\">/uploads/images/cert/2018/06/thumb_5b14b92c46371.jpg</span></li></ul>', 'woo123', 8, 0, '', 1, 1, '', 1528084781, 1528084781, NULL);
INSERT INTO `apps_apply` VALUES (2, '<ul class=\"diyList\"><li><span class=\"fTitle\">性别</span><span class=\"fValue\">男</span></li><li><span class=\"fTitle\">所属社区</span><span class=\"fValue\">大热篮球</span></li><li><span class=\"fTitle\">居住地</span><span class=\"fValue\">广东省深圳市</span></li><li><span class=\"fTitle\">籍贯</span><span class=\"fValue\">广东省深圳市阳光文体中心</span></li><li><span class=\"fTitle\">身份证号码</span><span class=\"fValue\">14156465465</span></li><li><span class=\"fTitle\">身份证</span><span class=\"fValue\"></span></li></ul>', 'woo123', 8, 0, '', 1, 1, '', 1528084850, 1528084850, NULL);

SET FOREIGN_KEY_CHECKS = 1;
