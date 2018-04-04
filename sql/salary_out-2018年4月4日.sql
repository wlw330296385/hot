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

 Date: 04/04/2018 14:07:35
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for salary_out
-- ----------------------------
DROP TABLE IF EXISTS `salary_out`;
CREATE TABLE `salary_out`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `salary` decimal(8, 2) NOT NULL COMMENT '佣金',
  `tid` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '交易单号',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `realname` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名',
  `telephone` bigint(11) NOT NULL,
  `ident` bigint(20) NOT NULL COMMENT '身份证号',
  `openid` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bank_card` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '银行卡号',
  `bank` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '账号类型,如农业银行|支付宝',
  `fee` decimal(6, 2) NOT NULL COMMENT '手续费',
  `pay_time` int(10) NOT NULL COMMENT '支付时间',
  `bank_type` tinyint(4) NOT NULL COMMENT '1:银行卡|2:支付宝',
  `is_pay` tinyint(4) NOT NULL DEFAULT 0,
  `buffer` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '冻结资金',
  `s_balance` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '当前余额',
  `e_balance` decimal(12, 2) NULL DEFAULT 0.00 COMMENT '数据后余额',
  `callback_str` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付回调',
  `system_remarks` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `create_time` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:申请中|1:已支付|2:取消|-1:对冲',
  `update_time` int(11) NOT NULL,
  `delete_time` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '佣金提现申请' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of salary_out
-- ----------------------------
INSERT INTO `salary_out` VALUES (1, 1.00, '20171226162014000', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 1509724800, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1509724800, 1, 0, 1515306527);
INSERT INTO `salary_out` VALUES (2, 50.00, '2.0171227114617E+21', 8, 'woo123', '吴丽文', 18507717466, 0, 'o83291CzkRqonKdTVSJLGhYoU98Q', '18507717466', '支付宝', 0.00, 0, 1, 0, 0.00, NULL, NULL, '', '', 1514346379, 0, 0, NULL);
INSERT INTO `salary_out` VALUES (3, 50.00, '20171227120030136890306367', 8, 'woo123', '吴丽文', 18507717466, 0, 'o83291CzkRqonKdTVSJLGhYoU98Q', '12480864311268909', '农业银行', 0.00, 0, 2, 0, 0.00, NULL, NULL, '', '', 1514347235, 0, 0, NULL);
INSERT INTO `salary_out` VALUES (4, 21209.00, '20180101222552851333422241', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 0, 1, 0, 0.00, NULL, NULL, '', '', 1514816778, 0, 0, 1515306527);
INSERT INTO `salary_out` VALUES (5, 4850.00, '20180107143242256933422241', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 1509292800, 1, 1, 0.00, NULL, NULL, '', '[系统拒绝提现申请]id:2,admin:yalu;', 1509292800, 1, 1509292800, NULL);
INSERT INTO `salary_out` VALUES (6, 7230.00, '20180107143256404433422241', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 1511971200, 1, 1, 0.00, NULL, NULL, '', '[系统拒绝提现申请]id:2,admin:yalu;', 1511971200, 1, 1511971200, NULL);
INSERT INTO `salary_out` VALUES (7, 8520.00, '20180107143306951833422241', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 1514563200, 1, 1, 0.00, NULL, NULL, '', '[系统拒绝提现申请]id:2,admin:yalu;', 1514563200, 1, 1514563200, NULL);
INSERT INTO `salary_out` VALUES (11, 4.00, '2018013010554279812', 8, 'woo123', '吴丽文', 18507717466, 0, 'o83291CzkRqonKdTVSJLGhYoU98Q', '12480864311268909', '农业银行', 0.00, 1517281261, 2, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517280942, 1, 1517281261, NULL);
INSERT INTO `salary_out` VALUES (12, 4.00, '2018013010571715022', 8, 'woo123', '吴丽文', 18507717466, 0, 'o83291CzkRqonKdTVSJLGhYoU98Q', '12480864311268909', '农业银行', 0.00, 1517281050, 2, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517281037, 1, 1517281050, NULL);
INSERT INTO `salary_out` VALUES (13, 600.00, '2018020611253072082', 16, 'andy.lin', '林泽铭', 13717147667, 0, 'o83291NnmXYmtzw-FGuPP-rDxFc0', '6212264000053206005', '中国工商银行', 0.00, 1517887615, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517887530, 1, 1517887615, NULL);
INSERT INTO `salary_out` VALUES (14, 900.00, '2018020611275396272', 16, 'andy.lin', '林泽铭', 13717147667, 0, 'o83291NnmXYmtzw-FGuPP-rDxFc0', '6212264000053206005', '中国工商银行', 0.00, 1517887685, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517887673, 1, 1517887685, NULL);
INSERT INTO `salary_out` VALUES (15, 125.00, '2018020611571780312', 36, 'Gavin.zhuang', '庄贵钦', 18576475234, 0, 'o83291PGocc_Bwa-1J7pB9ApCFmM', '6212264000014578286', '中国工商银行', 0.00, 1517889547, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517889437, 1, 1517889547, NULL);
INSERT INTO `salary_out` VALUES (16, 525.00, '2018020611574672582', 36, 'Gavin.zhuang', '庄贵钦', 18576475234, 0, 'o83291PGocc_Bwa-1J7pB9ApCFmM', '6212264000014578286', '中国工商银行', 0.00, 1517889558, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517889466, 1, 1517889558, NULL);
INSERT INTO `salary_out` VALUES (17, 860.00, '2018020611581246152', 36, 'Gavin.zhuang', '庄贵钦', 18576475234, 0, 'o83291PGocc_Bwa-1J7pB9ApCFmM', '6212264000014578286', '中国工商银行', 0.00, 1517889567, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517889492, 1, 1517889567, NULL);
INSERT INTO `salary_out` VALUES (18, 700.00, '2018020611582722202', 36, 'Gavin.zhuang', '庄贵钦', 18576475234, 0, 'o83291PGocc_Bwa-1J7pB9ApCFmM', '6212264000014578286', '中国工商银行', 0.00, 1517889879, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517889507, 1, 1517889879, NULL);
INSERT INTO `salary_out` VALUES (19, 300.00, '2018020612002117972', 184, '涵叔', '张嘉涵', 13528781343, 0, 'o83291FHVUyK1HGKF6xIrWTJAS2I', '6217007200007699740', '中国建设银行股份有限公司总行', 0.00, 1517889727, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517889621, 1, 1517889727, NULL);
INSERT INTO `salary_out` VALUES (20, 600.00, '2018020612003568092', 184, '涵叔', '张嘉涵', 13528781343, 0, 'o83291FHVUyK1HGKF6xIrWTJAS2I', '6217007200007699740', '中国建设银行股份有限公司总行', 0.00, 1517889758, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517889635, 1, 1517889758, NULL);
INSERT INTO `salary_out` VALUES (21, 900.00, '2018020612005875542', 184, '涵叔', '张嘉涵', 13528781343, 0, 'o83291FHVUyK1HGKF6xIrWTJAS2I', '6217007200007699740', '中国建设银行股份有限公司总行', 0.00, 1517889783, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1517889658, 1, 1517889783, NULL);
INSERT INTO `salary_out` VALUES (22, 810.00, '2018020811061742722', 18, 'AK', '安凯翔', 18566201712, 0, 'o83291A1ANguB2ziQFNuNZfVNqpY', '6217214000020106072', '中国工商银行', 0.00, 1518059191, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1518059177, 1, 1518059191, NULL);
INSERT INTO `salary_out` VALUES (23, 2346.00, '2018020811064845302', 18, 'AK', '安凯翔', 18566201712, 0, 'o83291A1ANguB2ziQFNuNZfVNqpY', '6217214000020106072', '中国工商银行', 0.00, 1518059219, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1518059208, 1, 1518059219, NULL);
INSERT INTO `salary_out` VALUES (24, 14747.00, '2018020811073784922', 18, 'AK', '安凯翔', 18566201712, 0, 'o83291A1ANguB2ziQFNuNZfVNqpY', '6217214000020106072', '中国工商银行', 0.00, 0, 1, 0, 0.00, NULL, NULL, '', '[系统拒绝提现申请]id:2,admin:yalu;', 1518059257, 2, 1518059298, NULL);
INSERT INTO `salary_out` VALUES (25, 14747.00, '2018020811090415932', 18, 'AK', '安凯翔', 18566201712, 0, 'o83291A1ANguB2ziQFNuNZfVNqpY', '6217214000020106072', '中国工商银行', 0.00, 1518059356, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1518059344, 1, 1518059356, NULL);
INSERT INTO `salary_out` VALUES (26, 10995.00, '2018022512144965672', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 1519619235, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1519532089, 1, 1519619235, NULL);
INSERT INTO `salary_out` VALUES (27, 1600.00, '2018022512171122562', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 0, 1, 0, 0.00, NULL, NULL, '', '[系统拒绝提现申请]id:2,admin:yalu;', 1519532231, 2, 1519618197, NULL);
INSERT INTO `salary_out` VALUES (28, 10995.00, '2018022612285679612', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 1519619345, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1519619336, 1, 1519619345, NULL);
INSERT INTO `salary_out` VALUES (29, 1600.00, '2018022612291722432', 19, '钟声', '钟声', 15999557852, 0, 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', 0.00, 1519619392, 1, 1, 0.00, NULL, NULL, '', '[系统出账]id:2,admin:yalu;', 1519619357, 1, 1519619392, NULL);

SET FOREIGN_KEY_CHECKS = 1;
