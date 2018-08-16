/*
 Navicat Premium Data Transfer

 Source Server         : 29
 Source Server Type    : MySQL
 Source Server Version : 100123
 Source Host           : localhost:3306
 Source Schema         : hot

 Target Server Type    : MySQL
 Target Server Version : 100123
 File Encoding         : 65001

 Date: 16/08/2018 11:59:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for group_member
-- ----------------------------
DROP TABLE IF EXISTS `group_member`;
CREATE TABLE `group_member`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group_id` int(11) NOT NULL,
  `member` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '-2|退出-1:被剔除|1:正常',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 61 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '社群-会员关系表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group_member
-- ----------------------------
INSERT INTO `group_member` VALUES (14, '老表运动圈', 6, 'legend', 6, '/uploads/images/avatar/f5edb7fdb3aa16a70927cc43c82b4784f707f4b7', 1, 1528359789, 1528359789, NULL);
INSERT INTO `group_member` VALUES (15, '荣光社', 7, 'wayen_z', 7, '/uploads/images/avatar/c65ece035fcfc2de5e3c38f7bb70d69834f28f25', 1, 1528361202, 1528361202, NULL);
INSERT INTO `group_member` VALUES (33, '钱海行动', 11, 'MirandaXian', 14, '/uploads/images/avatar/f59313feb572efc0c1ec424dd39182afead51d1a', 1, 1530072834, 1530072834, NULL);
INSERT INTO `group_member` VALUES (32, '钱海行动', 11, 'GaoYan', 9, '/uploads/images/avatar/37888177e4e87437ef5bc4c1be431fe1a09648d3', 1, 1530072805, 1530072805, NULL);
INSERT INTO `group_member` VALUES (31, '钱海行动', 11, 'Bingo', 21, '/uploads/images/avatar/98e0b71065fe2c1039734ddb24e0be30887b1be4', 1, 1530072790, 1530072790, NULL);
INSERT INTO `group_member` VALUES (30, '钱海行动', 11, 'HoChen', 1, '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', 1, 1530072542, 1530072542, NULL);
INSERT INTO `group_member` VALUES (29, '燕子运动圈', 10, 'GaoYan', 9, '/uploads/images/avatar/37888177e4e87437ef5bc4c1be431fe1a09648d3', 1, 1530071111, 1530071111, NULL);
INSERT INTO `group_member` VALUES (28, '时代骄子运动一族', 9, 'HoChen', 1, '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', 1, 1529401115, 1529401115, NULL);
INSERT INTO `group_member` VALUES (27, 'F18 OneSport', 8, 'legend', 6, '/uploads/images/avatar/f5edb7fdb3aa16a70927cc43c82b4784f707f4b7', -1, 1528941239, 1528941239, NULL);
INSERT INTO `group_member` VALUES (26, 'F18 OneSport', 8, 'HoChen', 1, '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', -1, 1528877589, 1528877589, NULL);
INSERT INTO `group_member` VALUES (25, '老表运动圈', 6, 'HoChen', 1, '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', -2, 1528873519, 1533112624, NULL);
INSERT INTO `group_member` VALUES (34, '钱海行动', 11, 'AK', 18, '/uploads/images/avatar/04a034ac3911fa4b9b06fb9087a7223812696411', 1, 1530072884, 1530072884, NULL);
INSERT INTO `group_member` VALUES (35, '钱海行动', 11, 'weilin666', 4, '/uploads/images/avatar/1c0865e9aa84139d7294a48abbc4a3b9c92fe886', 1, 1530072889, 1530072889, NULL);
INSERT INTO `group_member` VALUES (36, '钱海行动', 11, 'wayen_z', 7, '/uploads/images/avatar/c65ece035fcfc2de5e3c38f7bb70d69834f28f25', 1, 1530073198, 1530073198, NULL);
INSERT INTO `group_member` VALUES (37, '钱海行动', 11, '+*', 5, '/uploads/images/avatar/efc3b69888316da98781b7911bdbd197cb060746', 1, 1530073204, 1530073204, NULL);
INSERT INTO `group_member` VALUES (38, 'woo运动群', 12, 'woo123', 8, '/uploads/images/avatar/560cafc1e4fc13031bdd73b48c7821bc22564e76', 1, 1530073272, 1530073272, NULL);
INSERT INTO `group_member` VALUES (39, '燕子运动圈', 10, '大灰狼', 0, 'https://thirdwx.qlogo.cn/mmopen/vi_32/kqicIkIbWGHEO5Ju37q3PN9uVYF9oHWlr67Wwgs7ViccbTMZLXCC7pc69bqNZvWshAQMYFibI5e5Bovd5CwaomCdg/132', 1, 1530073469, 1530073469, 1533789861);
INSERT INTO `group_member` VALUES (40, 'woo运动群', 12, 'GaoYan', 9, '/uploads/images/avatar/37888177e4e87437ef5bc4c1be431fe1a09648d3', 1, 1530105220, 1530105220, NULL);
INSERT INTO `group_member` VALUES (41, '荣光社', 7, '筱晓曦', 0, 'https://thirdwx.qlogo.cn/mmopen/vi_32/DYAIOgq83eolTQ926hibYfSZGx0C4iccQ8X9PoT2Bs5o5X3eG1S7IiadkdN4wOAa3xjvcgUb9HPQk3KaNcq15XsUA/132', 1, 1530105640, 1530105640, 1533789861);
INSERT INTO `group_member` VALUES (42, '钱海行动', 11, '张雅璐', 78, '/uploads/images/avatar/0b81dc5b5c34df50995cd8c600b5efeb2318ab60', 1, 1530109668, 1530109668, NULL);
INSERT INTO `group_member` VALUES (43, '钱海行动', 11, 'woo123', 8, '/uploads/images/avatar/560cafc1e4fc13031bdd73b48c7821bc22564e76', 1, 1530109674, 1530109674, NULL);
INSERT INTO `group_member` VALUES (44, '燕子运动圈', 10, 'woo123', 8, '/uploads/images/avatar/560cafc1e4fc13031bdd73b48c7821bc22564e76', 1, 1530113131, 1530113131, NULL);
INSERT INTO `group_member` VALUES (45, 'woo运动群', 12, '淡大发', 654, 'https://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIxPCR6O1ZYtaRtpAUarsbXkPttbmerSic1U5z692jXiaib5UCLrT1ytwMt8dGR9sG0l4aibak4O9pRXg/132', 1, 1530153840, 1530153840, NULL);
INSERT INTO `group_member` VALUES (46, 'F18 OneSport', 8, 'Wing', 673, '/uploads/images/cert/2018/08/cd53526a2a94f68b82199a115efa18eac6dd54a6.jpeg', -1, 1531294573, 1531294573, NULL);
INSERT INTO `group_member` VALUES (47, '打虎英雄群', 13, 'HoChen', 1, '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', 1, 1531296559, 1531296559, NULL);
INSERT INTO `group_member` VALUES (48, '打虎英雄群', 13, 'davy爷', 544, '/uploads/images/avatar/5be492daed414054ff4ac32081af9bc581f08952', 1, 1531299594, 1531299594, NULL);
INSERT INTO `group_member` VALUES (49, 'woo运动群', 12, 'legend333', 677, '/uploads/images/avatar/0ee223ae2faa2f5f9c07fae9acdfcab4e93f1fb0', 1, 1531303733, 1531303733, NULL);
INSERT INTO `group_member` VALUES (50, '打虎英雄群', 13, 'Dom®', 0, 'https://thirdwx.qlogo.cn/mmopen/vi_32/3MHwxMhtxRI7HLKyXCePCcJ35mYNvCBpiaIjCZzf935jW0ck3XTxp2bm6evpgjBq0DaZedMAyOUPnczvVBvkyzw/132', 1, 1531316116, 1531316116, 1533789861);
INSERT INTO `group_member` VALUES (51, '打虎英雄群', 13, 'Don宽', 1108, '/uploads/images/avatar/062c0295df1cc481273e530b410934c8aa11a590', 1, 1532335824, 1532335824, NULL);
INSERT INTO `group_member` VALUES (52, '铁友', 14, 'zehanw', 34, '/uploads/images/avatar/9cab6e71d856bbfc6c7e71f1ca81baf85dd0d081', 1, 1532336108, 1532336108, NULL);
INSERT INTO `group_member` VALUES (53, '钱海行动', 11, 'legend', 6, '/uploads/images/avatar/f5edb7fdb3aa16a70927cc43c82b4784f707f4b7', 1, 1533022804, 1533022804, NULL);
INSERT INTO `group_member` VALUES (54, 'One Sport Club ', 15, 'Wing', 673, '/uploads/images/cert/2018/08/cd53526a2a94f68b82199a115efa18eac6dd54a6.jpeg', 1, 1533050476, 1533050476, NULL);
INSERT INTO `group_member` VALUES (55, 'One Sport Club ', 15, 'legend', 6, '/uploads/images/avatar/f5edb7fdb3aa16a70927cc43c82b4784f707f4b7', 1, 1533090001, 1533090001, NULL);
INSERT INTO `group_member` VALUES (56, 'One Sport Club ', 15, 'HoChen', 1, '/uploads/images/avatar/47eef542eb24b26b7923772d52aa1b4d9ac412eb', 1, 1533090006, 1533090006, NULL);
INSERT INTO `group_member` VALUES (57, 'One Sport Club ', 15, 'Kimi 李伟雄', 1213, 'https://thirdwx.qlogo.cn/mmopen/vi_32/uHskAsnK1e3B4yf3BJ0yAGSIM4CzHeZ3xiaLO4ibfYRKiaEjhZialLib8jaavEGSceRF03geEDjUr3AhukadmcI4PbA/132', 1, 1533123889, 1533123889, NULL);
INSERT INTO `group_member` VALUES (58, 'One Sport Club ', 15, '靓坤', 1180, '/uploads/images/avatar/8bbba3e2c464ac0b75b8d93cbe87d8c414451e1b', 1, 1533132114, 1533132114, NULL);
INSERT INTO `group_member` VALUES (59, 'One Sport Club ', 15, 'MAX1212', 1181, '/uploads/images/avatar/db9ec0135364737ea5a3288a9e6f3eadde682513', 1, 1533132119, 1533132119, NULL);
INSERT INTO `group_member` VALUES (60, 'One Sport Club ', 15, 'jason', 121, '/uploads/images/avatar/c24e5a5315cdacde86ce8e4a23ebc87ab3ef9f20', 1, 1533132125, 1533132125, NULL);

SET FOREIGN_KEY_CHECKS = 1;
