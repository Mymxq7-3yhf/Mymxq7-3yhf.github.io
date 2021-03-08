/*
 Navicat Premium Data Transfer

 Source Server         : 111
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : admin_database

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 19/11/2020 09:59:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for data_admin
-- ----------------------------
DROP TABLE IF EXISTS `data_admin`;
CREATE TABLE `data_admin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `login_name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `token` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `tokentime` int(11) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `lasttime` datetime DEFAULT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;
insert into data_admin(guid,login_name,password,status,addtime)
       values("a5bfc9e07964f8dddeb95fc584cd965d","admin",111111,1,now());
-- ----------------------------
-- Table structure for data_admin_info
-- ----------------------------
DROP TABLE IF EXISTS `data_admin_info`;
CREATE TABLE `data_admin_info`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `nickname` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `rolename` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;
insert into data_admin_info(guid,nickname,rolename,img)
       values("a5bfc9e07964f8dddeb95fc584cd965d","小七家的皮卡丘呀","超级管理员","https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=1968847207,1385464631&fm=26&gp=0.jpg");
-- ----------------------------
-- Table structure for data_answer
-- ----------------------------
DROP TABLE IF EXISTS `data_answer`;
CREATE TABLE `data_answer`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question_guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '判断题时，内容为right和wrong',
  `isright` tinyint(1) DEFAULT NULL COMMENT '1  正确   2  错误',
  `status` tinyint(1) DEFAULT NULL COMMENT '1   启用   2  禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for data_question
-- ----------------------------
DROP TABLE IF EXISTS `data_question`;
CREATE TABLE `data_question`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1  单选   2  判断',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1  启用   2  禁用',
  `add_user` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '管理员guid',
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for data_theme
-- ----------------------------
DROP TABLE IF EXISTS `data_theme`;
CREATE TABLE `data_theme`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1   启用   2  禁用',
  `adduser` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '题目类型' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for data_user
-- ----------------------------
DROP TABLE IF EXISTS `data_user`;
CREATE TABLE `data_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `openID` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '头像',
  `nickname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `addtime` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1 正常  2 冻结  3 删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for log_user_question
-- ----------------------------
DROP TABLE IF EXISTS `log_user_question`;
CREATE TABLE `log_user_question`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '冗余用户表的名称',
  `theme_title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '冗余考试题的标题字段',
  `json` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '题目，答案，用户选择的答案',
  `result_json` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '总题数，答对的题数，答错的题数',
  `addtime` int(11) DEFAULT NULL COMMENT '提交答案的时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for rel_theme_question
-- ----------------------------
DROP TABLE IF EXISTS `rel_theme_question`;
CREATE TABLE `rel_theme_question`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `question_guid` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
