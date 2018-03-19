/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : hot

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-01-23 17:57:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `abstract` varchar(255) NOT NULL COMMENT '摘要',
  `covers` varchar(255) NOT NULL COMMENT '封面图',
  `content` longtext NOT NULL,
  `member_id` int(11) NOT NULL,
  `member` varchar(11) NOT NULL COMMENT '作者',
  `organization_id` int(11) NOT NULL DEFAULT '0' COMMENT '0:系统文章|其他:组织文章',
  `organization` varchar(60) NOT NULL DEFAULT '篮球管家平台',
  `organization_type` tinyint(11) NOT NULL DEFAULT '1' COMMENT '1:系统文章|2:训练营文章|3:球队文章',
  `hot` tinyint(2) NOT NULL DEFAULT '0' COMMENT '热门排序',
  `hit` int(11) NOT NULL DEFAULT '0' COMMENT '点击率',
  `status` tinyint(2) NOT NULL DEFAULT '-1' COMMENT '1:上架|-1:下架',
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('4', '大热篮球俱乐部', ' 大热篮球俱乐部，位于南山区繁华的南新路，地理位置佳，交通便利。中心七百余平方米的室内活动场地，在有限的空间增大环境的扩张力，特色的环境布局和巧思的摆设，彰显出本俱乐部极具热血的气息，带着绿色环保的理念填充了许多绿色植物，为小朋友带来健康且舒适的环境。', '/uploads/images/article/5a67043d2de62.jpg', '<p>等待更新...</p>', '1', 'HOT', '0', '篮球管家平台', '1', '1', '0', '1', '1516700754', '1516700754', null);
INSERT INTO `article` VALUES ('5', '钟声训练营', '钟声教练团队融合了国外先进的教学方法，根据幼儿的年龄特点，设计了既符合幼儿身心发展需要，又顾及幼儿兴趣需求的活动形式。幼儿在教师启发与带领下通过多种方法锻炼自己，不但增强了体质，提高了幼儿动作的协调性、灵活性，而且培养了幼儿勇敢、坚韧的精神品质和分享合作的团队精神。', '/uploads/images/article/5a6704908d1d2.jpg', '<p>等待更新```<br/></p>', '1', 'HOT', '0', '篮球管家平台', '1', '2', '0', '1', '1516700827', '1516700827', null);
INSERT INTO `article` VALUES ('6', 'AKcross训练营', '我们希望通过实施\"迷你篮球\"的活动概念，全面推广青少年篮球运动，培养幼儿对篮球运动的兴趣，让孩子在体验篮球乐趣的同时，培养从小爱好运动的习惯，从而增强体质，健康成长。', '/uploads/images/article/5a6704e9518b2.jpg', '<p>等待更新</p>', '1', 'HOT', '0', '篮球管家平台', '1', '3', '0', '1', '1516700913', '1516700913', null);
INSERT INTO `article` VALUES ('7', '大热前海训练营', '本俱乐部设有了两个迷你篮球场、两个成人半场（同时可用作学员的训练场地），各种高度各异的篮球框架，适合各年龄段以及各种身高的大小朋友使用；同时还配备温馨昏黄色调的休息区，与悠闲静谧的书籍区进行有机组合，充分发挥了每一个角落的功能。', '/uploads/images/article/5a67053276e5a.jpg', '<p>等待更新<br/></p>', '1', 'HOT', '0', '篮球管家平台', '1', '6', '0', '-1', '1516700986', '1516700986', null);
