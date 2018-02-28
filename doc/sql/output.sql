/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-02-28 10:26:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `output`
-- ----------------------------
DROP TABLE IF EXISTS `output`;
CREATE TABLE `output` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `output` decimal(12,2) NOT NULL COMMENT '支出金额',
  `camp` varchar(60) NOT NULL,
  `camp_id` int(11) NOT NULL,
  `member` varchar(60) NOT NULL COMMENT '操作人员',
  `member_id` int(11) NOT NULL COMMENT '操作人员id',
  `remarks` varchar(255) NOT NULL COMMENT '备注',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:赠课|2:课时退费|-1:提现|3:课时教练支出|4:平台分成',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(预留字段)',
  `system_remarks` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=332 DEFAULT CHARSET=utf8 COMMENT='训练营支出表';

-- ----------------------------
-- Records of output
-- ----------------------------
INSERT INTO `output` VALUES ('1', '1.00', 'B—Ball 篮球训练营', '33', 'BINGOZ', '427', '您的剩余课时为1, 您的订单总数量为1,因此退您1节课的钱', '2', '-2', '', '1516162361', '1516174297', null);
INSERT INTO `output` VALUES ('2', '1000.00', 'FIT', '17', 'l朱民皓', '320', '您的剩余课时为10, 您的订单总数量为10,因此退您10节课的钱', '2', '-2', '', '1515132064', '1515135203', null);
INSERT INTO `output` VALUES ('3', '1.00', 'B—Ball 篮球训练营', '33', 'woo123', '8', '您的剩余课时为1, 您的订单总数量为1,因此退您1节课的钱', '2', '-2', '', '1514884612', '1516173692', null);
INSERT INTO `output` VALUES ('249', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '200', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('248', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '200', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('247', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '199', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('246', '20.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '199', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('245', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '198', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('244', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '198', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('243', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '197', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('242', '10.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '197', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('241', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '196', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('240', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '196', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('239', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '194', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('238', '20.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '194', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('237', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '193', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('236', '20.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '193', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('235', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '192', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('234', '20.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '192', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('233', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '191', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('232', '10.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '191', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('231', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '190', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('230', '10.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '190', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('229', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '189', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('228', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '189', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('227', '450.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '187', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('226', '140.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '187', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('225', '175.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '185', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('224', '30.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '185', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('223', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '184', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('222', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '184', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('221', '350.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '183', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('220', '100.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '183', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('219', '300.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '182', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('218', '80.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '182', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('217', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '180', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('216', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '180', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('215', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '179', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('214', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '179', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('213', '300.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '178', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('212', '80.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '178', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('211', '175.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '177', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('210', '30.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '177', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('209', '350.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '176', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('208', '100.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '176', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('207', '400.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '175', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('206', '120.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '175', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('205', '175.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '174', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('204', '30.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '174', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('203', '225.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '173', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('202', '50.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '173', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('201', '325.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '172', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('200', '90.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '172', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('199', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '171', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('198', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '171', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('197', '250.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '170', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('196', '60.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '170', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('195', '275.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '169', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('194', '70.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '169', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('193', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '168', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('192', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '168', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('191', '325.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '167', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('190', '90.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '167', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('189', '150.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '166', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('188', '20.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '166', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('187', '300.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '165', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('186', '80.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '165', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('185', '375.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '164', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('184', '110.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '164', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('183', '150.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '163', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('182', '20.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '163', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('181', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '162', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('180', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '162', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('179', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '161', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('178', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '161', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('177', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '160', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('176', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '160', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('175', '150.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '159', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('174', '20.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '159', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('173', '300.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '158', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('172', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '158', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('171', '300.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '157', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('170', '60.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '157', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('169', '200.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '156', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('168', '40.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '156', '1519720309', '1519720309', null);
INSERT INTO `output` VALUES ('250', '20.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '201', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('251', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '201', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('252', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '202', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('253', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '202', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('254', '20.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '203', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('255', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '203', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('256', '40.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '204', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('257', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '204', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('258', '10.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '205', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('259', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '205', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('260', '110.00', '钟声训练营', '15', 'system', '0', '平台提成支出', '4', '1', '206', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('261', '420.00', '钟声训练营', '15', 'system', '0', '课时教练总薪资支出', '3', '1', '206', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('262', '80.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '207', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('263', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '207', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('264', '40.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '208', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('265', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '208', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('266', '60.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '209', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('267', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '209', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('268', '50.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '210', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('269', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '210', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('270', '40.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '211', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('271', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '211', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('272', '60.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '212', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('273', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '212', '1519720310', '1519720310', null);
INSERT INTO `output` VALUES ('274', '80.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '213', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('275', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '213', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('276', '70.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '214', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('277', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '214', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('278', '90.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '216', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('279', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '216', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('280', '70.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '217', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('281', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '217', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('282', '110.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '218', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('283', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '218', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('284', '100.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '219', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('285', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '219', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('286', '50.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '220', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('287', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '220', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('288', '80.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '221', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('289', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '221', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('290', '80.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '222', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('291', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '222', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('292', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '223', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('293', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '223', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('294', '60.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '224', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('295', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '224', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('296', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '225', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('297', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '225', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('298', '40.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '226', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('299', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '226', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('300', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '227', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('301', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '227', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('302', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '228', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('303', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '228', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('304', '30.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '229', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('305', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '229', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('306', '20.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '230', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('307', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '230', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('308', '50.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '231', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('309', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '231', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('310', '90.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '232', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('311', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '232', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('312', '60.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '234', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('313', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '234', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('314', '60.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '235', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('315', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '235', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('316', '60.00', 'AKcross训练营', '13', 'system', '0', '平台提成支出', '4', '1', '236', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('317', '0.00', 'AKcross训练营', '13', 'system', '0', '课时教练总薪资支出', '3', '1', '236', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('318', '40.00', '钟声训练营', '15', 'system', '0', '平台提成支出', '4', '1', '237', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('319', '280.00', '钟声训练营', '15', 'system', '0', '课时教练总薪资支出', '3', '1', '237', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('320', '40.00', '钟声训练营', '15', 'system', '0', '平台提成支出', '4', '1', '238', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('321', '280.00', '钟声训练营', '15', 'system', '0', '课时教练总薪资支出', '3', '1', '238', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('322', '40.00', '钟声训练营', '15', 'system', '0', '平台提成支出', '4', '1', '239', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('323', '280.00', '钟声训练营', '15', 'system', '0', '课时教练总薪资支出', '3', '1', '239', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('324', '30.00', '钟声训练营', '15', 'system', '0', '平台提成支出', '4', '1', '240', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('325', '260.00', '钟声训练营', '15', 'system', '0', '课时教练总薪资支出', '3', '1', '240', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('326', '40.00', '钟声训练营', '15', 'system', '0', '平台提成支出', '4', '1', '241', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('327', '280.00', '钟声训练营', '15', 'system', '0', '课时教练总薪资支出', '3', '1', '241', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('328', '30.00', '钟声训练营', '15', 'system', '0', '平台提成支出', '4', '1', '242', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('329', '260.00', '钟声训练营', '15', 'system', '0', '课时教练总薪资支出', '3', '1', '242', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('330', '100.00', '大热篮球俱乐部', '9', 'system', '0', '平台提成支出', '4', '1', '243', '1519720311', '1519720311', null);
INSERT INTO `output` VALUES ('331', '300.00', '大热篮球俱乐部', '9', 'system', '0', '课时教练总薪资支出', '3', '1', '243', '1519720311', '1519720311', null);
