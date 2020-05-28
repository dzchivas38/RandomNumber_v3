/*
Navicat MySQL Data Transfer

Source Server         : DataBase
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : randomnumber

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-11-08 20:37:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_actiontype
-- ----------------------------
DROP TABLE IF EXISTS `tbl_actiontype`;
CREATE TABLE `tbl_actiontype` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `ActionTypeLevel` int(11) DEFAULT NULL,
  `InCoin` int(11) DEFAULT NULL,
  `OutCoin` int(11) DEFAULT NULL,
  `IsFirstChirld` bit(1) DEFAULT b'0',
  `Description` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `Code` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

-- ----------------------------
-- Records of tbl_actiontype
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_cashout
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cashout`;
CREATE TABLE `tbl_cashout` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PlayerId` int(11) DEFAULT NULL,
  `ActionTypeId` int(11) DEFAULT NULL,
  `Ratio` decimal(10,0) DEFAULT NULL COMMENT 'tỉ lệ',
  `Description` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL COMMENT 'Mô tả',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

-- ----------------------------
-- Records of tbl_cashout
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_player
-- ----------------------------
DROP TABLE IF EXISTS `tbl_player`;
CREATE TABLE `tbl_player` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `PhoneNumber` varchar(100) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `PlayerTypeId` int(11) DEFAULT NULL,
  `IsDelete` bit(4) DEFAULT b'0',
  `Description` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

-- ----------------------------
-- Records of tbl_player
-- ----------------------------
INSERT INTO `tbl_player` VALUES ('1', 'Nguyễn Việt Dũng', '0972763643', '1', '\0', 'Dũng icon');
INSERT INTO `tbl_player` VALUES ('7', 'hello new', null, null, '\0', null);

-- ----------------------------
-- Table structure for tbl_playertype
-- ----------------------------
DROP TABLE IF EXISTS `tbl_playertype`;
CREATE TABLE `tbl_playertype` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `RuleAction` int(11) DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

-- ----------------------------
-- Records of tbl_playertype
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_result_number
-- ----------------------------
DROP TABLE IF EXISTS `tbl_result_number`;
CREATE TABLE `tbl_result_number` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `PubDate` datetime DEFAULT NULL,
  `isDelete` bit(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

-- ----------------------------
-- Records of tbl_result_number
-- ----------------------------
INSERT INTO `tbl_result_number` VALUES ('1', 'KẾT QUẢ XỔ SỐ MIỀN BẮC NGÀY 25/10 (Thứ Tư)', null, null, null);
INSERT INTO `tbl_result_number` VALUES ('2', 'KẾT QUẢ XỔ SỐ MIỀN BẮC NGÀY 25/10 (Thứ Tư)', '\nĐB: 22622\n1: 91205\n2: 87862 - 97691\n3: 72125 - 61485 - 42384 - 93393 - 32436 - 80813\n4: 0889 - 3371 - 1023 - 8980\n5: 2652 - 7672 - 8816 - 0937 - 9703 - 5014\n6: 768 - 185 - 739\n7: 53 - 63 - 00 - 14', '0000-00-00 00:00:00', null);
INSERT INTO `tbl_result_number` VALUES ('3', 'KẾT QUẢ XỔ SỐ MIỀN BẮC NGÀY 26/10 (Thứ Năm)', '\nĐB: 42282\n1: 77277\n2: 20897 - 00962\n3: 07409 - 42685 - 84581 - 07044 - 62999 - 65370\n4: 4477 - 9785 - 7355 - 4320\n5: 8196 - 7551 - 8567 - 5662 - 2879 - 0938\n6: 953 - 000 - 385\n7: 34 - 51 - 92 - 58', '0000-00-00 00:00:00', null);
INSERT INTO `tbl_result_number` VALUES ('4', 'KẾT QUẢ XỔ SỐ MIỀN BẮC NGÀY 26/10 (Thứ Năm)', '\nĐB: 42282\n1: 77277\n2: 20897 - 00962\n3: 07409 - 42685 - 84581 - 07044 - 62999 - 65370\n4: 4477 - 9785 - 7355 - 4320\n5: 8196 - 7551 - 8567 - 5662 - 2879 - 0938\n6: 953 - 000 - 385\n7: 34 - 51 - 92 - 58', '2017-10-26 12:58:11', null);

-- ----------------------------
-- Table structure for tbl_syntax
-- ----------------------------
DROP TABLE IF EXISTS `tbl_syntax`;
CREATE TABLE `tbl_syntax` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `ActionTypeId` int(11) DEFAULT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

-- ----------------------------
-- Records of tbl_syntax
-- ----------------------------
