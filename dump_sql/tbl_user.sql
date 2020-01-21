/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100129
 Source Host           : localhost:3306
 Source Schema         : db_simkeu

 Target Server Type    : MySQL
 Target Server Version : 100129
 File Encoding         : 65001

 Date: 21/01/2020 15:01:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_level_user` int(11) NULL DEFAULT NULL,
  `id_pegawai` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT NULL,
  `last_login` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('USR00001', 'ADMIN', 'kmJnZmZo', 1, NULL, 1, '2019-12-30 15:22:51', '2019-10-05 21:34:14', '2019-12-30 15:22:51');
INSERT INTO `tbl_user` VALUES ('USR00002', 'KEPSEK', 'kmJnZmZo', 4, NULL, 1, '2019-12-03 08:42:33', '2019-11-09 19:36:13', '2019-12-03 08:42:33');
INSERT INTO `tbl_user` VALUES ('USR00003', 'KEUANGAN', 'kmJnZmZo', 3, NULL, 1, '2019-12-03 08:41:40', '2019-11-09 19:43:19', '2019-12-03 08:41:40');
INSERT INTO `tbl_user` VALUES ('USR00004', 'TATAUSAHA', 'kmJnZmZo', 2, NULL, 1, '2019-12-03 08:41:10', '2019-11-09 19:45:18', '2019-12-03 08:41:10');

SET FOREIGN_KEY_CHECKS = 1;
