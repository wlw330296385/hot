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

 Date: 30/10/2018 18:01:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sys_output
-- ----------------------------
DROP TABLE IF EXISTS `sys_output`;
CREATE TABLE `sys_output`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `output` decimal(12, 2) NOT NULL DEFAULT 0.00,
  `camp_id` int(11) NOT NULL,
  `camp` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `f_id` int(11) NOT NULL DEFAULT 1 COMMENT '外键id,比如income.id或者salary_in.id或者refund.id',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '[0=>\'未知\',1=>\'课时教练支出\',2=>\'训练营课时支出\',3=>\'退款支出\',4=>\'训练营提现支出\'];',
  `system_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2167 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of sys_output
-- ----------------------------
INSERT INTO `sys_output` VALUES (1843, 101.00, 9, 'GaoYan', 33, 1, '个人余额提现支出', 1539763296, 0, NULL);
INSERT INTO `sys_output` VALUES (1844, 1280.00, 17, 'Bruce.Dong', 32, 1, '个人余额提现支出', 1539326586, 0, NULL);
INSERT INTO `sys_output` VALUES (1845, 200.00, 1289, 'zl凌泽馨', 31, 1, '个人余额提现支出', 1539335883, 0, NULL);
INSERT INTO `sys_output` VALUES (1846, 1.00, 18, 'AK', 30, 1, '个人余额提现支出', 1534331701, 0, NULL);
INSERT INTO `sys_output` VALUES (1847, 1600.00, 19, '钟声', 29, 1, '个人余额提现支出', 1519619392, 0, NULL);
INSERT INTO `sys_output` VALUES (1848, 10995.00, 19, '钟声', 28, 1, '个人余额提现支出', 1519619345, 0, NULL);
INSERT INTO `sys_output` VALUES (1849, 10995.00, 19, '钟声', 26, 1, '个人余额提现支出', 1519619235, 0, NULL);
INSERT INTO `sys_output` VALUES (1850, 14747.00, 18, 'AK', 25, 1, '个人余额提现支出', 1518059356, 0, NULL);
INSERT INTO `sys_output` VALUES (1851, 2346.00, 18, 'AK', 23, 1, '个人余额提现支出', 1518059219, 0, NULL);
INSERT INTO `sys_output` VALUES (1852, 810.00, 18, 'AK', 22, 1, '个人余额提现支出', 1518059191, 0, NULL);
INSERT INTO `sys_output` VALUES (1853, 900.00, 184, '涵叔', 21, 1, '个人余额提现支出', 1517889783, 0, NULL);
INSERT INTO `sys_output` VALUES (1854, 600.00, 184, '涵叔', 20, 1, '个人余额提现支出', 1517889758, 0, NULL);
INSERT INTO `sys_output` VALUES (1855, 300.00, 184, '涵叔', 19, 1, '个人余额提现支出', 1517889727, 0, NULL);
INSERT INTO `sys_output` VALUES (1856, 700.00, 36, 'Gavin.zhuang', 18, 1, '个人余额提现支出', 1517889879, 0, NULL);
INSERT INTO `sys_output` VALUES (1857, 860.00, 36, 'Gavin.zhuang', 17, 1, '个人余额提现支出', 1517889567, 0, NULL);
INSERT INTO `sys_output` VALUES (1858, 525.00, 36, 'Gavin.zhuang', 16, 1, '个人余额提现支出', 1517889558, 0, NULL);
INSERT INTO `sys_output` VALUES (1859, 125.00, 36, 'Gavin.zhuang', 15, 1, '个人余额提现支出', 1517889547, 0, NULL);
INSERT INTO `sys_output` VALUES (1860, 900.00, 16, 'andy.lin', 14, 1, '个人余额提现支出', 1517887685, 0, NULL);
INSERT INTO `sys_output` VALUES (1861, 600.00, 16, 'andy.lin', 13, 1, '个人余额提现支出', 1517887615, 0, NULL);
INSERT INTO `sys_output` VALUES (1862, 4.00, 8, 'woo123', 12, 1, '个人余额提现支出', 1517281050, 0, NULL);
INSERT INTO `sys_output` VALUES (1863, 4.00, 8, 'woo123', 11, 1, '个人余额提现支出', 1517281261, 0, NULL);
INSERT INTO `sys_output` VALUES (1864, 8520.00, 19, '钟声', 7, 1, '个人余额提现支出', 1514563200, 0, NULL);
INSERT INTO `sys_output` VALUES (1865, 7230.00, 19, '钟声', 6, 1, '个人余额提现支出', 1511971200, 0, NULL);
INSERT INTO `sys_output` VALUES (1866, 4850.00, 19, '钟声', 5, 1, '个人余额提现支出', 1509292800, 0, NULL);
INSERT INTO `sys_output` VALUES (1867, 1.00, 19, '钟声', 1, 1, '个人余额提现支出', 1509724800, 0, NULL);
INSERT INTO `sys_output` VALUES (2152, 260.00, 32, '燕子Happy篮球训练营', 53, 2, '课时版训练营余额提现支出', 1539763289, 0, NULL);
INSERT INTO `sys_output` VALUES (2153, 7229.60, 13, 'AKcross训练营', 51, 2, '课时版训练营余额提现支出', 1539312401, 0, NULL);
INSERT INTO `sys_output` VALUES (2154, 3676.80, 13, 'AKcross训练营', 48, 2, '课时版训练营余额提现支出', 1537528727, 0, NULL);
INSERT INTO `sys_output` VALUES (2155, 2320.00, 17, 'FIT', 47, 2, '课时版训练营余额提现支出', 1535945140, 0, NULL);
INSERT INTO `sys_output` VALUES (2156, 2290.00, 17, 'FIT', 46, 2, '课时版训练营余额提现支出', 1535945085, 0, NULL);
INSERT INTO `sys_output` VALUES (2157, 3563.20, 13, 'AKcross训练营', 44, 2, '课时版训练营余额提现支出', 1535538928, 0, NULL);
INSERT INTO `sys_output` VALUES (2158, 8030.40, 13, 'AKcross训练营', 41, 2, '课时版训练营余额提现支出', 1535538940, 0, NULL);
INSERT INTO `sys_output` VALUES (2159, 20.00, 31, 'wow篮球兴趣训练营', 36, 2, '课时版训练营余额提现支出', 1532504825, 0, NULL);
INSERT INTO `sys_output` VALUES (2160, 10.00, 31, 'wow篮球兴趣训练营', 34, 2, '课时版训练营余额提现支出', 1532504894, 0, NULL);
INSERT INTO `sys_output` VALUES (2161, 10.00, 31, 'wow篮球兴趣训练营', 25, 2, '课时版训练营余额提现支出', 1528885026, 0, NULL);
INSERT INTO `sys_output` VALUES (2162, 9738.20, 13, 'AKcross训练营', 15, 2, '课时版训练营余额提现支出', 1528878796, 0, NULL);
INSERT INTO `sys_output` VALUES (2163, 3480.20, 13, 'AKcross训练营', 11, 2, '课时版训练营余额提现支出', 1528876784, 0, NULL);
INSERT INTO `sys_output` VALUES (2164, 45377.60, 13, 'AKcross训练营', 10, 2, '课时版训练营余额提现支出', 1528876791, 0, NULL);
INSERT INTO `sys_output` VALUES (2165, 1.00, 31, 'wow篮球兴趣训练营', 9, 2, '课时版训练营余额提现支出', 1526987751, 0, NULL);
INSERT INTO `sys_output` VALUES (2166, 2.00, 31, 'wow篮球兴趣训练营', 7, 2, '课时版训练营余额提现支出', 1526987654, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
