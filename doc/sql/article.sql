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

 Date: 03/04/2018 16:25:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:使用手册',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `abstract` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '摘要',
  `covers` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '封面图',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `author` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '佚名' COMMENT '作者',
  `member_id` int(11) NOT NULL,
  `member` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发布者',
  `organization_id` int(11) NOT NULL DEFAULT 0 COMMENT '0:系统文章|其他:组织文章',
  `organization` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '篮球管家',
  `organization_type` tinyint(11) NOT NULL DEFAULT 1 COMMENT '1:系统文章|2:训练营文章|3:球队文章',
  `hot` tinyint(2) NOT NULL DEFAULT 0 COMMENT '热门排序',
  `hit` int(11) NOT NULL DEFAULT 0 COMMENT '点击率',
  `likes` int(11) NOT NULL COMMENT '点赞数',
  `comments` int(11) NOT NULL DEFAULT 0 COMMENT '评论数',
  `collects` int(11) NOT NULL DEFAULT 0 COMMENT '当前收藏数',
  `status` tinyint(2) NOT NULL DEFAULT -1 COMMENT '1:上架|-1:下架',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES (4, 1, '大热篮球俱乐部', ' 大热篮球俱乐部，位于南山区繁华的南新路，地理位置佳，交通便利。中心七百余平方米的室内活动场地，在有限的空间增大环境的扩张力，特色的环境布局和巧思的摆设，彰显出本俱乐部极具热血的气息，带着绿色环保的理念填充了许多绿色植物，为小朋友带来健康且舒适的环境。', '/uploads/images/article/5a670a1c61e51.jpg', '<p>更新中</p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 1, 0, 0, 0, 0, 1, 1516700754, 1516702240, NULL);
INSERT INTO `article` VALUES (5, 1, '钟声训练营', '钟声教练团队融合了国外先进的教学方法，根据幼儿的年龄特点，设计了既符合幼儿身心发展需要，又顾及幼儿兴趣需求的活动形式。幼儿在教师启发与带领下通过多种方法锻炼自己，不但增强了体质，提高了幼儿动作的协调性、灵活性，而且培养了幼儿勇敢、坚韧的精神品质和分享合作的团队精神。', '/uploads/images/article/5a670a0427bb7.jpg', '<p>更新中</p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 2, 0, 0, 0, 0, 1, 1516700827, 1516702216, NULL);
INSERT INTO `article` VALUES (6, 1, 'AKcross训练营', '我们希望通过实施', '/uploads/images/article/5a6709eae29b2.jpg', '<p>更新``</p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 3, 0, 0, 0, 0, 1, 1516700913, 1516702192, NULL);
INSERT INTO `article` VALUES (7, 1, '大热前海训练营', '本俱乐部设有了两个迷你篮球场、两个成人半场（同时可用作学员的训练场地），各种高度各异的篮球框架，适合各年龄段以及各种身高的大小朋友使用；同时还配备温馨昏黄色调的休息区，与悠闲静谧的书籍区进行有机组合，充分发挥了每一个角落的功能。', '/uploads/images/article/5a6709d90083b.jpg', '<p>更新中</p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 6, 0, 0, 0, 0, 1, 1516700986, 1516702176, NULL);
INSERT INTO `article` VALUES (8, 1, '篮球管家 | 预约体验课 ', '欢迎使用篮球管家线上服务平台，首次使用请先注册成为篮球管家会员，再进行其他操作', '/uploads/images/article/5a7ab2b583931.jpg', '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20180207/1517987439294837.jpg\" title=\"1517987439294837.jpg\" alt=\"预约体验课.jpg\"/></p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 0, 0, 0, 0, 0, -1, 1517987656, 1517990593, NULL);
INSERT INTO `article` VALUES (9, 1, '篮球管家 | 剩余课时查询', '欢迎使用篮球管家线上服务平台，首次使用请先注册成为篮球管家会员，再进行其他操作', '/uploads/images/article/5a7ab29fef8a6.jpg', '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20180207/1517988629161046.jpg\" title=\"1517988629161046.jpg\" alt=\"剩余课时查询.jpg\"/></p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 0, 0, 0, 0, 0, -1, 1517988652, 1517990566, NULL);
INSERT INTO `article` VALUES (10, 1, '篮球管家 | 课程购买', '欢迎使用篮球管家线上服务平台，首次使用请先注册成为篮球管家会员，再进行其他操作', '/uploads/images/article/5a7aaea72a84c.jpg', '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20180207/1517990483509504.jpg\" title=\"1517990483509504.jpg\" alt=\"关注购买课程.jpg\"/></p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 0, 0, 0, 0, 0, -1, 1517990497, 1517990497, NULL);
INSERT INTO `article` VALUES (11, 1, '篮球管家 | 申请退费', '欢迎使用篮球管家线上服务平台，首次使用请先注册成为篮球管家会员，再进行其他操作', '/uploads/images/article/5a7abe3521f1f.jpg', '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20180207/1517993623135386.jpg\" title=\"1517993623135386.jpg\" alt=\"课时申请退费.jpg\"/></p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 0, 0, 0, 0, 0, -1, 1517993637, 1517993637, NULL);
INSERT INTO `article` VALUES (12, 1, '篮球管家 | 注册训练营', '欢迎使用篮球管家线上服务平台，首次使用请先注册成为篮球管家会员，再进行其他操作', '/uploads/images/article/5a7ac22f1c29b.jpg', '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20180207/1517995759261020.jpg\" title=\"1517995759261020.jpg\" alt=\"注册训练营.jpg\"/></p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 0, 0, 0, 0, 0, -1, 1517995782, 1517995782, NULL);
INSERT INTO `article` VALUES (13, 1, '篮球管家 | 添加训练营课程', '欢迎使用篮球管家线上服务平台，首次使用请先注册成为篮球管家会员，再进行其他操作', '/uploads/images/article/5a7bf1ce114c1.jpg', '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20180207/1517996056727208.jpg\" title=\"1517996056727208.jpg\" alt=\"创建课程.jpg\"/></p>', '佚名', 5, 'bingo', 0, '篮球管家平台', 1, 0, 0, 0, 0, 0, 1, 1517996314, 1518072279, NULL);
INSERT INTO `article` VALUES (14, 1, '篮球管家 | 活动创建', '欢迎使用篮球管家线上服务平台，首次使用请先注册成为篮球管家会员，再进行其他操作', '/uploads/images/article/5a7d4a9a62eff.jpg', '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20180209/1518160598565867.jpg\" title=\"1518160598565867.jpg\" alt=\"活动创建.jpg\"/></p>', '佚名', 5, 'bingo', 0, '篮球管家', 1, 0, 1, 0, 0, 0, 1, 1518160694, 1518160694, NULL);
INSERT INTO `article` VALUES (15, 1, '篮球管家 | 教练员注册及加入训练营', '欢迎使用篮球管家线上服务平台，首次使用请先注册成为篮球管家会员，再进行其他操作', '/uploads/images/article/5a7ebed3d6be7.jpg', '<p style=\"text-align: center;\"><img src=\"/ueditor/php/upload/image/20180210/1518255807667702.jpg\" title=\"1518255807667702.jpg\" alt=\"申请教练及加入训练营_meitu_4_meitu_1.jpg\"/></p>', '佚名', 5, 'bingo', 0, '篮球管家', 1, 0, 0, 0, 0, 0, 1, 1518255890, 1518255890, NULL);
INSERT INTO `article` VALUES (16, 1, '5454', '21445', '', '<div class=\"operationDiv\"><h5>eqeqeqeq</h5></div><div class=\"operationDiv\"><p>eqeqweqwewqeqw</p></div>', '佚名', 6, 'legend', 5, '荣光训练营', 2, 0, 0, 0, 0, 0, -1, 1522311391, 1522311391, NULL);

SET FOREIGN_KEY_CHECKS = 1;
