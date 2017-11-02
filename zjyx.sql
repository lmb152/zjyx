/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50635
 Source Host           : localhost
 Source Database       : zjyx

 Target Server Type    : MySQL
 Target Server Version : 50635
 File Encoding         : utf-8

 Date: 11/02/2017 14:12:56 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `tp_position`
-- ----------------------------
DROP TABLE IF EXISTS `tp_position`;
CREATE TABLE `tp_position` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(255) DEFAULT NULL COMMENT '职位名称',
  `company` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `salary` float DEFAULT NULL COMMENT '薪资  单位元',
  `pub_time` int(11) DEFAULT NULL COMMENT '发布时间 时间戳',
  `bright_spot` varchar(255) DEFAULT NULL COMMENT '职位亮点',
  `description` varchar(255) DEFAULT NULL COMMENT '职位描述',
  `company_info` varchar(255) DEFAULT NULL COMMENT '公司简介',
  `location` varchar(255) DEFAULT NULL COMMENT '地点 保存省即可',
  `industry` varchar(255) DEFAULT NULL COMMENT '行业',
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tp_user`
-- ----------------------------
DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE `tp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `pwd` varchar(200) NOT NULL,
  `role` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `address` varchar(500) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `idcard` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `tp_user`
-- ----------------------------
BEGIN;
INSERT INTO `tp_user` VALUES ('5', 'superadmin', 'eafcf585b3b2c742c4a5fa6832c3ed51', 'admin', '', '', '', '', '');
COMMIT;

-- ----------------------------
--  Table structure for `tp_user_army`
-- ----------------------------
DROP TABLE IF EXISTS `tp_user_army`;
CREATE TABLE `tp_user_army` (
  `edu_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) DEFAULT NULL COMMENT '外键，用户id',
  `start_time` int(11) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `department` varchar(255) DEFAULT NULL COMMENT '部门',
  `position` varchar(255) DEFAULT NULL COMMENT '职位',
  PRIMARY KEY (`edu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tp_user_education`
-- ----------------------------
DROP TABLE IF EXISTS `tp_user_education`;
CREATE TABLE `tp_user_education` (
  `edu_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL COMMENT '开始时间 时间戳',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间 时间戳',
  `school` varchar(255) DEFAULT NULL COMMENT '学校',
  `degree` varchar(255) DEFAULT NULL COMMENT '学位',
  PRIMARY KEY (`edu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tp_user_profile`
-- ----------------------------
DROP TABLE IF EXISTS `tp_user_profile`;
CREATE TABLE `tp_user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `male` int(11) DEFAULT NULL COMMENT '性别 0 男 1 女',
  `political` varchar(255) DEFAULT NULL COMMENT '政治面貌',
  `marriage` int(11) DEFAULT NULL COMMENT '婚姻 0 未婚 1 已婚',
  `birthday` int(11) DEFAULT NULL COMMENT '出生年月  保存为 时间戳',
  `native_place` varchar(255) DEFAULT NULL COMMENT '籍贯',
  `ethnic` varchar(255) DEFAULT NULL COMMENT '民族',
  `education` varchar(255) DEFAULT NULL COMMENT '学历',
  `height` float DEFAULT NULL COMMENT '身高，保存为 170.5',
  `weight` float DEFAULT NULL COMMENT '体重，保存为 70.8kg',
  `service_start` int(11) DEFAULT NULL COMMENT '服役开始时间  时间戳',
  `service_end` int(11) DEFAULT NULL COMMENT '服役结束时间 保存为时间戳',
  `badge_number` varchar(255) DEFAULT NULL COMMENT '退伍证号',
  `openid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `mobile` int(11) DEFAULT NULL COMMENT '手机号码',
  `target_position` varchar(255) DEFAULT NULL COMMENT '目标岗位',
  `expected_salary` decimal(10,0) DEFAULT NULL COMMENT '期望薪资 单位K',
  `duty_time` int(11) DEFAULT NULL COMMENT '到岗时间  时间戳',
  `honor` varchar(255) DEFAULT NULL COMMENT '获得荣誉',
  `self_evaluation` varchar(255) DEFAULT NULL COMMENT '自我评价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
