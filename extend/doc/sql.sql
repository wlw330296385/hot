

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`(
	`id` 		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`openid` 	varchar(64) NOT NULL COMMENT '微信授权即产生',
	`member`	varchar(60) NOT NULL COMMENT '用户名',
	`nickname`	varchar(60) NOT NULL COMMENT '微信授权即产生',
	`avatar`	varchar(60) NOT NULL COMMENT '微信授权即产生',
	`telephone`	bigint(11)	NOT NULL COMMENT '电话号码',
	`password`	varchar(64)	NOT NULL COMMENT '密码',
	`email`		varchar(60) NOT NULL COMMENT '电子邮箱',
	`realname`	varchar(30)	NOT NULL COMMENT '真实姓名',
	`province`	varchar(60)	NOT NULL COMMENT '省',
	`city`		varchar(60) NOT NULL COMMENT '市',
	`location`	varchar(255) NOT NULL COMMENT '居住地址',
	`sex`		tinyint(4) NOT NULL DEFAULT 0 COMMENT '性别',
	`height`	decimal(4,1) NOT NULL COMMENT '身高,单位cm',
	`weight`	decimal(4,1) NOT NULL COMMENT '体重,单位cm',
	`shoe_code`	decimal(4,1) NOT NULL COMMENT '鞋码,单位mm',
	`birthday`	date NOT NULL COMMENT '生日',
	`sign_time`	datetime NOT NULL COMMENT '注册时间',
	`update_time`	int(10) NOT NULL COMMENT '更新时间',
	`level`		tinyint(4) NOT NULL DEFAULT 1 COMMENT '根据流量自动分',
	`pid`		int(10) NOT NULL DEFAULT 0 COMMENT '推荐人',
	`cert_id`	int(10) NOT NULL COMMENT '证件id',
	`score`		int(10) NOT NULL DEFAULT 0 COMMENT '积分',
	`flow`		int(10) NOT NULL COMMENT '流量',
	`balance`	decimal(8,2) NOT NULL DEFAULT 0 COMMENT '人民币余额',
	`remarks`	varchar(255) NOT NULL COMMENT 'remarks',
	PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `camp`;
CREATE TABLE `camp`(
	`id`		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`camp_name`	varchar(60) NOT NULL,
	`member_id`	int(10) NOT NULL COMMENT 'member表id',
	`member`	varchar(60) NOT NULL COMMENT 'member表member',
	`max_member`	int(10) NOT NULL DEFAULT 0 COMMENT '最大会员上限,0不限',
	PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `lesson`;
CREATE TABLE `lesson`(
	`id` 		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`lesson`	varchar(60) NOT NULL COMMENT '课程名称',
	`leader_id`	int(10) NOT NULL COMMENT '负责财务的老大',
	`leader`	varchar(60) NOT NULL COMMENT 'leader',
	`lessontype`	varchar(60) NOT NULL COMMENT '课程类型',
	`lessontype_id` int(10) NOT NULL COMMENT '选择类型',
	`camp`		varchar(60) NOT NULL COMMENT '所属训练营名称',
	`camp_id`	int(10) NOT NULL COMMENT '所属训练营id',
	`cost`		decimal(6,2) NOT NULL DEFAULT 0 COMMENT '每个课时单价',
	`total`		tinyint(10)	NOT NULL DEFAULT 1 COMMENT '总课时数量',
	`score`		int(10) NOT NULL DEFAULT 0 COMMENT '购买课程需要积分',
	`coach_name`	varchar(60) NOT NULL COMMENT '主教练',
	`coach_id`	int(10) NOT NULL COMMENT '副教练',
	`assistant` varchar(255) NOT NULL COMMENT '副教练',
	`assistant_ids` varchar(255) NOT NULL COMMENT '副教练id集合',
	`min`		int(10)	NOT NULL DEFAULT 1 COMMENT '最少开课学生数量',
	`max`		int(10) NOT NULL COMMENT '最大开课学生数量',
	`week`		varchar(60) NOT NULL COMMENT '周六,周三',
	`start`		date NOT NULL COMMENT '开始日期',
	`end`		date NOT NULL COMMENT '结束日期',
	`lesson_time` time NOT NULL COMMENT '具体上课时间',
	`province`	varchar(60) NOT NULL COMMENT '省',
	`city`		varchar(60) NOT NULL COMMENT '市',
	`area`		varchar(60) NOT NULL COMMENT '区',
	`field_id`	int(10) NOT NULL COMMENT '场地id',
	`field`		varchar(255) NOT NULL COMMENT '场地名称',
	`remarks`	varchar(255) NOT NULL COMMENT '备注',
	`status`	tinyint(4)	NOT NULL DEFAULT 0 COMMENT '0:未审核;1:正常;-1:禁止',
	PRIMARY KEY (`id`)
)ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade`(
	`id`		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`grade`		varchar(60) NOT NULL COMMENT '班级名称',
	`camp_id`	int(10) NOT NULL COMMENT '训练营id',
	`camp`		varchar(60) NOT NULL COMMENT '所属训练营',
	`leader`	varchar(60) NOT NULL COMMENT '领队',
	`leader_id`	int(10) NOT NULL COMMENT '对应member表,领队id',
	`teacher`	varchar(60) NOT NULL COMMENT '班主任',
	`teacher_id`	int(10) NOT NULL COMMENT '对应member表id',
	`coach`		varchar(255) NOT NULL COMMENT '主教练',
	`coach_id`	int(10) NOT NULL COMMENT 'id',
	`assistant_ids` varchar(255) NOT NULL COMMENT '副教练id集合',
	`assistant`	varchar(255) NOT NULL COMMENT '副教练',
	`students`	int(10) NOT NULL COMMENT '学生数量',
	`week`		varchar(60) NOT NULL COMMENT '周一/周六',
	`lesson_time`	varchar(60) NOT NULL COMMENT '10:50:40-11:50:48,10:50:40-11:50:48',
	`province`	varchar(60) NOT NULL COMMENT '默认为课程地址',
	`city`		varchar(60) NOT NULL COMMENT '默认为课程地址',
	`area`		varchar(60) NOT NULL COMMENT '默认为课程地址',
	`plan`	varchar(255) NOT NULL COMMENT '教案',
	`plan_ids`	varchar(255) NOT NULL COMMENT '教案id',
	`court`		varchar(255) NOT NULL COMMENT '球场',
	`court_id`	int(10)	NOT NULL COMMENT '场地id',
	`remarks`	varchar(255) NOT NULL COMMENT '备注',
	`status`	tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:下架;1:正常',
	PRIMARY KEY (`id`)
)ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `coach`;
CREATE TABLE `coach`(
	`id`		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`member_id`	int(10) NOT NULL COMMENT '对应member表id',
	`student_flow`	int(10) NOT NULL COMMENT '学员流量',
	`lesson_flow`	int(10) NOT NULL COMMENT '课程流量',
	`kps`		decimal(3,1) NOT NULL COMMENT '评分',
	`create_time`	datetime NOT NULL COMMENT '注册日期',
	`coach_rank`	tinyint(4) NOT NULL DEFAULT 1 COMMENT '阶衔',
	`cert_id`		int(10) NOT NULL COMMENT '资质证书',
	`tag1`		varchar(30) NOT NULL COMMENT '标签',
	`tag2`		varchar(30) NOT NULL COMMENT '标签',
	`tag3`		varchar(30) NOT NULL COMMENT '标签',
	`tag4`		varchar(30) NOT NULL COMMENT '标签',
	`tag5`		varchar(30) NOT NULL COMMENT '标签',
	`coach_year`	tinyint(4) NOT NULL COMMENT '教龄',
	`experience`	varchar(255) NOT NULL COMMENT '教学经验描述',
	`remarks`	varchar(255) NOT NULL COMMENT 'remarks',
	`remarks_admin`	varchar(255) NOT NULL COMMENT '系统备注',
	`portraits`	varchar(255) NOT NULL COMMENT '肖像',
	`description`	varchar(255) NOT NULL COMMENT '个人宣言',
	`coach_level`	tinyint(4) NOT NULL COMMENT '教练等级,按学员流量算',
	`status`	tinyint(4) NOT NULL COMMENT '0:未完善信息|1:正常|2:不通过|-1:禁用',
	PRIMARY KEY (`id`)
)ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`(
	`id`		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`member_id`	int(10) NOT NULL COMMENT '对应member表id',
	`parent`	varchar(60) NOT NULL COMMENT '家长姓名',
	`emergency_telephone`	bigint(11) NOT NULL COMMENT '紧急电话',
	`school`	varchar(255) NOT NULL COMMENT '学校',
	`total_lesson`	int(10) NOT NULL DEFAULT 0 COMMENT '全部课程',
	`finish_total`	int(10) NOT NULL COMMENT '已上课程',
	PRIMARY KEY (`id`)
)ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `exercise`;
CREATE TABLE `exercise`(
	`id`		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`exercise`	varchar(60) NOT NULL COMMENT '训练项目',
	`status`	tinyint(4) NOT NULL COMMENT '1:启用|0:待审核|>1 用户自己的',
	PRIMARY KEY (`id`)
)ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET =utf8;

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule`(
	`id`		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`camp_id`	int(10) NOT NULL COMMENT '所属训练营',
	`camp`		int(10) NOT NULL COMMENT '训练营',
	`lesson`	varchar(255) NOT NULL COMMENT '课程名称',
	`lesson_id`	int(10) NOT NULL COMMENT '课程id',
	`grade`		varchar(255) NOT NULL COMMENT '班级',
	`grade_id`	int(10) NOT NULL COMMENT '班级id',
	`teacher`	varchar(60) NOT NULL COMMENT '班主任',
	`teacher_id`	int(10) NOT NULL COMMENT 'id',
	`coach`		varchar(60) NOT NULL COMMENT '教练',
	`coach_id`	int(10) NOT NULL COMMENT 'member表id',
	`assistant_ids`	varchar(255) NOT NULL COMMENT 'ids',
	`assistant`	varchar(255) NOT NULL COMMENT '助教',
	`leave_ids` varchar(255) NOT NULL COMMENT 'ids',
	`leave`		varchar(255) NOT NULL COMMENT '请假人员',
	`lesson_date`	date NOT NULL COMMENT '训练日期',
	`teacher_plan_id`	int(10) NOT NULL COMMENT 'id',
	`teacher_plan`	varchar(255) NOT NULL COMMENT '教案',
	`lesson_time`	datetime NOT NULL COMMENT '上课时间',
	`province`	varchar(60) NOT NULL COMMENT '默认为课程地址',
	`city`		varchar(60) NOT NULL COMMENT '默认为课程地址',
	`area`		varchar(60) NOT NULL COMMENT '默认为课程地址',
	`location`	varchar(255) NOT NULL COMMENT '默认为课程地址',
	`rent`		decimal(6,2) NOT NULL COMMENT '场地租金',
	`remarks`	varchar(255) NOT NULL COMMENT '备注',
	`status`	tinyint(4) NOT NULL DEFAULT 0 COMMENT '1:正常|0:草稿|-1:删除',
	PRIMARY KEY (`id`)
)ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting`(
	`id`		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`sitename`	varchar(255) NOT NULL,
	`level1`	decimal(6,2) NOT NULL,
	`level2`	decimal(6,2) NOT NULL,
	`vip1`		int(10) NOT NULL,
	`vip2`		int(10) NOT NULL,
	`vip3`		int(10) NOT NULL,
	`vip4`		int(10) NOT NULL,
	`vip5`		int(10) NOT NULL,
	`keywords`	varchar(255)  NOT NULL DEFAULT '关键词',
	`description`	varchar(255)  NOT NULL DEFAULT '大热篮球',
	`footer`	varchar(255)  NOT NULL DEFAULT 'copyright@2016,备案111', 
	`title`		varchar(255) NOT NULL DEFAULT 'HOT',
	`wxappid`	varchar(64) NOT NULL,
	`wxsecret`	varchar(255) NOT NULL,
	`logo`		varchar(255) NOT NULL DEFAULT 'logo',
	`lrss`		int(10) NOT NULL COMMENT '上一节课平台奖励积分',
	`lrcs`		int(10) NOT NULL COMMENT 'lesion_return_coach_score',
	`status`	tinyint(4) NOT NULL DEFAULT 1 COMMENT '0:不启用|1:启用',
	PRIMARY KEY (`id`)
)ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;

DROP TABLE IF EXISTS `cert`(
	`id`		int(10) unsigned NOT NULL AUTO_INCREMENT,
	`camp_id`	int(10)	unsigned NOT NULL,
	`member_id`	int(10)	unsigned NOT NULL,
	`cert_no`	int(10) NOT NULL,
	`cert_type`	tinyint(10) unsigned NOT NULL,
	`photo_positive`	varchar(255) NOT NULL,
	`photo_back`	varchar(255) NOT NULL,
	`portraits`		varchar(255) NOT NULL COMMENT '任务肖像',
	`status`	tinyint(4) NOT NULL COMMENT '0:无效|1:有效',
	PRIMARY KEY (`id`)
)ENGINE = MyISAM AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8;