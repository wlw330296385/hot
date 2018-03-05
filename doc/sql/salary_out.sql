/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-03-05 12:05:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `salary_out`
-- ----------------------------
DROP TABLE IF EXISTS `salary_out`;
CREATE TABLE `salary_out` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salary` decimal(8,2) NOT NULL COMMENT '佣金',
  `tid` varchar(100) NOT NULL COMMENT '交易单号',
  `member_id` int(10) NOT NULL,
  `member` varchar(60) NOT NULL,
  `realname` varchar(60) NOT NULL COMMENT '真实姓名',
  `telephone` bigint(11) NOT NULL,
  `ident` bigint(20) NOT NULL COMMENT '身份证号',
  `openid` varchar(64) NOT NULL,
  `bank_card` varchar(64) NOT NULL COMMENT '银行卡号',
  `bank` varchar(30) NOT NULL COMMENT '账号类型,如农业银行|支付宝',
  `fee` decimal(6,2) NOT NULL COMMENT '手续费',
  `pay_time` int(10) NOT NULL,
  `bank_type` tinyint(4) NOT NULL COMMENT '1:银行卡|2:支付宝',
  `is_pay` tinyint(4) NOT NULL DEFAULT '0',
  `buffer` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '冻结资金',
  `callback_str` text NOT NULL COMMENT '支付回调',
  `system_remarks` text NOT NULL,
  `create_time` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0:申请中|1:已支付|2:取消|-1:对冲',
  `update_time` int(11) NOT NULL,
  `delete_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='佣金提现申请';

-- ----------------------------
-- Records of salary_out
-- ----------------------------
INSERT INTO `salary_out` VALUES ('1', '90000.00', '2017122614562527572', '27', 'coachj', '黄万瑞', '13760379341', '0', 'o83291L2DtT9rOnVagr0B9Y07YYs', '6212264000037559362', '中国工商银行', '0.00', '0', '1', '0', '0.00', '', '[系统拒绝提现申请]id:2,admin:yalu;', '1512308430', '2', '0', null);
INSERT INTO `salary_out` VALUES ('2', '999999.99', '10', '27', 'coachj', '黄万瑞', '13760379341', '0', 'o83291L2DtT9rOnVagr0B9Y07YYs', '6212264000037559362', '中国工商银行', '0.00', '1514274866', '1', '1', '0.00', '', '[系统出账]id:2,admin:yalu;', '1514452782', '1', '0', null);
INSERT INTO `salary_out` VALUES ('3', '50.00', '12124541515645615315613515', '8', 'woo123', '344', '18507717466', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', '123', '支付宝', '0.00', '0', '1', '0', '50.10', '', '', '1512909362', '0', '0', null);
INSERT INTO `salary_out` VALUES ('4', '50.00', '2551245415341515674841564874', '8', 'woo123', '344', '18507717466', '0', 'o83291CzkRqonKdTVSJLGhYoU98Q', '123', '支付宝', '0.00', '0', '1', '0', '50.20', '', '', '1514311203', '0', '0', null);
INSERT INTO `salary_out` VALUES ('5', '1000.00', '2018012915502375472', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '0', '0.00', '', '[系统拒绝提现申请]id:2,admin:yalu;', '1512990667', '2', '1517213480', null);
INSERT INTO `salary_out` VALUES ('6', '2000.00', '2018012915515613882', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '1517217727', '1', '1', '0.00', '', '[系统出账]id:2,admin:yalu;', '1512550468', '1', '1517217727', null);
INSERT INTO `salary_out` VALUES ('7', '1500.00', '2018012916203950862', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '0', '0.00', '', '[系统拒绝提现申请]id:2,admin:yalu;', '1514311077', '2', '1517217643', null);
INSERT INTO `salary_out` VALUES ('8', '3000.00', '2018012917534598302', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '0', '0.00', '', '[系统拒绝提现申请]id:2,admin:yalu;', '1514066722', '2', '1517281688', null);
INSERT INTO `salary_out` VALUES ('9', '2000.00', '2018012917563024782', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '0', '0.00', '', '[系统拒绝提现申请]id:2,admin:yalu;', '1512747116', '2', '1517219803', null);
INSERT INTO `salary_out` VALUES ('10', '1000.00', '2018012917565479842', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '1517219821', '1', '1', '0.00', '', '[系统出账]id:2,admin:yalu;', '1512066155', '1', '1517219821', null);
INSERT INTO `salary_out` VALUES ('11', '3000.00', '2018012917571837912', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '1517219958', '1', '1', '0.00', '', '[系统出账]id:2,admin:yalu;', '1512620165', '1', '1517219958', null);
INSERT INTO `salary_out` VALUES ('12', '100.00', '201801301108168522', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '1', '100.00', '', '2018-01月', '1512249103', '0', '1517281696', null);
INSERT INTO `salary_out` VALUES ('13', '200.00', '201801301108252862', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '1', '200.00', '', '2018-01月', '1513915756', '0', '1517281705', null);
INSERT INTO `salary_out` VALUES ('14', '300.00', '2018013011084664902', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '1', '300.00', '', '2018-01月', '1512994213', '0', '1517281726', null);
INSERT INTO `salary_out` VALUES ('15', '400.00', '2018013011085238452', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '1', '400.00', '', '2018-01月', '1513754535', '0', '1517281732', null);
INSERT INTO `salary_out` VALUES ('16', '500.00', '201801301109224162', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '1', '500.00', '', '2018-01月', '1512544776', '0', '1517281762', null);
INSERT INTO `salary_out` VALUES ('17', '600.00', '201801301109281772', '19', '钟声', '钟声', '15999557852', '0', 'o83291FErHA03raoSlWaWQTtl1Jo', '6212264000045738313', '中国工商银行', '0.00', '0', '1', '1', '600.00', '', '2018-01月', '1514583014', '0', '1517281768', null);
