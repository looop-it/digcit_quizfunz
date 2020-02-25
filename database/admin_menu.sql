/*
Navicat MySQL Data Transfer

Source Server         : loop
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : competition

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-12-04 11:32:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('1', '0', '1', 'Index', 'fa-bar-chart', '/', null, null);
INSERT INTO `admin_menu` VALUES ('2', '0', '22', '系統', 'fa-tasks', null, null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('3', '2', '23', 'Users', 'fa-users', 'auth/users', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('4', '2', '24', 'Roles', 'fa-user', 'auth/roles', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('5', '2', '25', 'Permission', 'fa-ban', 'auth/permissions', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('6', '2', '26', 'Menu', 'fa-bars', 'auth/menu', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('7', '2', '27', 'Operation log', 'fa-history', 'auth/logs', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('8', '2', '29', 'Helpers', 'fa-gears', '', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('9', '8', '30', 'Scaffold', 'fa-keyboard-o', 'helpers/scaffold', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('10', '8', '31', 'Database terminal', 'fa-database', 'helpers/terminal/database', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('11', '8', '32', 'Laravel artisan', 'fa-terminal', 'helpers/terminal/artisan', null, '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('12', '0', '6', '賽事資訊設定', 'fa-newspaper-o', 'admin/article', '2017-03-03 11:46:19', '2018-11-01 18:37:09');
INSERT INTO `admin_menu` VALUES ('13', '12', '7', '最新消息', 'fa-newspaper-o', 'posts', '2017-03-03 11:50:10', '2018-12-03 14:41:14');
INSERT INTO `admin_menu` VALUES ('15', '0', '17', '廣告', 'fa-tasks', null, '2017-03-03 16:00:42', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('16', '29', '4', '資訊分類', 'fa-list-ol', 'categories', '2017-03-03 16:14:54', '2017-04-16 03:21:04');
INSERT INTO `admin_menu` VALUES ('17', '15', '19', '廣告位設定', 'fa-puzzle-piece', 'adv-type', '2017-03-03 17:44:28', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('18', '15', '18', '廣告列表', 'fa-calculator', 'adv-list', '2017-03-03 18:27:16', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('20', '0', '14', '推廣文章', 'fa-gittip', null, '2017-03-06 17:59:23', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('21', '20', '16', '推廣位設定', 'fa-align-center', 'promo-setting', '2017-03-06 18:03:08', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('22', '20', '15', '推廣管理', 'fa-star', 'promo-articles', '2017-03-08 21:26:44', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('25', '0', '20', '會員', 'fa-users', null, '2017-04-07 10:20:15', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('26', '25', '21', '會員', 'fa-user', 'users', '2017-04-07 10:20:43', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('29', '0', '2', '網站設定', 'fa-gear', 'general-setting', '2017-04-08 00:29:40', '2018-10-31 20:36:32');
INSERT INTO `admin_menu` VALUES ('30', '29', '3', '全局設定', 'fa-bars', 'general-setting', '2017-04-16 03:20:15', '2017-04-16 03:21:04');
INSERT INTO `admin_menu` VALUES ('41', '29', '5', '資料頁', 'fa-bullhorn', 'pages', '2017-10-12 21:50:12', '2017-11-02 21:59:35');
INSERT INTO `admin_menu` VALUES ('42', '2', '28', 'Log viwer', 'fa-database', 'logs', '2017-11-02 21:59:04', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('43', '12', '9', '賽程賽規', 'fa-bars', 'competition-info', '2018-11-01 02:38:29', '2018-11-01 19:01:01');
INSERT INTO `admin_menu` VALUES ('45', '0', '11', '賽題管理', 'fa-bars', null, '2018-11-01 18:37:46', '2018-11-01 19:01:01');
INSERT INTO `admin_menu` VALUES ('46', '0', '13', '答題卷管理', 'fa-bars', null, '2018-11-01 18:37:58', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('47', '12', '10', '贊助商管理', 'fa-gift', 'sponsors', null, '2018-11-01 19:01:01');
INSERT INTO `admin_menu` VALUES ('48', '12', '8', '參考資料', 'fa-paperclip', 'references', '2018-11-01 19:00:14', '2018-11-01 19:01:01');
INSERT INTO `admin_menu` VALUES ('49', '45', '12', '賽題分類', 'fa-bars', 'question-categories', '2018-11-01 20:08:21', '2018-11-01 20:08:36');
INSERT INTO `admin_menu` VALUES ('50', '45', '0', '範疇管理', 'fa-bars', 'scopes', '2018-11-29 19:50:13', '2018-11-29 19:50:13');
INSERT INTO `admin_menu` VALUES ('51', '45', '0', '賽題管理', 'fa-bars', 'questions', '2018-11-29 20:14:13', '2018-11-29 20:14:13');
INSERT INTO `admin_menu` VALUES ('53', '46', '16', '賽季', 'fa-adjust', 'seasons', null, null);
INSERT INTO `admin_menu` VALUES ('54', '46', '17', '答題卷', 'fa-align-justify', 'papers', null, null);
INSERT INTO `admin_menu` VALUES ('55', '0', '11', '數據收集', 'fa-bank', null, null, '2018-12-03 14:37:10');
INSERT INTO `admin_menu` VALUES ('56', '55', '0', '學校登記', 'fa-building', 'schools', null, '2018-12-03 14:37:26');
INSERT INTO `admin_menu` VALUES ('57', '55', '0', '學生登記', 'fa-user', 'students', null, '2018-12-03 14:37:40');
INSERT INTO `admin_menu` VALUES ('58', '55', '0', '聯絡我們', 'fa-bars', 'inquire', '2018-12-03 14:36:33', '2018-12-03 14:36:33');
