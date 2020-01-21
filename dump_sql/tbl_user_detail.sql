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

 Date: 21/01/2020 15:01:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_user_detail
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_detail`;
CREATE TABLE `tbl_user_detail`  (
  `id_user_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_lengkap_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Akun Baru',
  `alamat_user` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `tanggal_lahir_user` date NULL DEFAULT '1970-01-01',
  `jenis_kelamin_user` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_telp_user` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gambar_user` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'user_default.png',
  `thumb_gambar_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'user_default_thumb.png',
  PRIMARY KEY (`id_user_detail`) USING BTREE,
  UNIQUE INDEX `id_user`(`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_user_detail
-- ----------------------------
INSERT INTO `tbl_user_detail` VALUES (1, 'USR00001', 'Rizky Yuanda', 'Jl. Ngagel Tirto IIB/6 Surabaya, Jawa Timur, Indonesia', '1991-04-03', 'L', '081703403473', 'admin-1573576263.jpg', 'admin-1573576263_thumb.jpg');
INSERT INTO `tbl_user_detail` VALUES (8, 'USR00002', 'Kepala Sekolah', 'aifudf nisduf sidufis ndudrs', '1945-10-09', 'L', '0819218129121', 'kepsek-1573302973.jpg', 'kepsek-1573302973_thumb.jpg');
INSERT INTO `tbl_user_detail` VALUES (9, 'USR00003', 'Keuangan', 'asfsd', '1963-02-14', 'L', '121312', 'keuangan-1573303398.jpg', 'keuangan-1573303398_thumb.jpg');
INSERT INTO `tbl_user_detail` VALUES (10, 'USR00004', 'Tata Usaha', 'dsdsdfs', '1945-01-01', 'P', '7397293892', 'tatausaha-1573303518.png', 'tatausaha-1573303518_thumb.png');

SET FOREIGN_KEY_CHECKS = 1;
