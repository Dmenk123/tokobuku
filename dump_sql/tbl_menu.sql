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

 Date: 21/01/2020 14:03:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_menu
-- ----------------------------
DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE `tbl_menu`  (
  `id_menu` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `nama_menu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `judul_menu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `link_menu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `icon_menu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `aktif_menu` int(1) NULL DEFAULT NULL,
  `tingkat_menu` int(11) NULL DEFAULT NULL,
  `urutan_menu` int(11) NULL DEFAULT NULL,
  `add_button` int(1) NULL DEFAULT NULL,
  `edit_button` int(1) NULL DEFAULT NULL,
  `delete_button` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tbl_menu
-- ----------------------------
INSERT INTO `tbl_menu` VALUES (1, 0, 'Dashboard', 'Dashboard', 'home', 'fa fa-dashboard', 1, 1, 1, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (97, 99, 'Setting Menu', 'Setting Menu', 'set_menu_adm', NULL, 1, 2, 2, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (98, 99, 'Setting Role', 'Setting Role', 'set_role_adm', '', 1, 2, 1, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (99, 0, 'Setting (Administrator)', 'Setting', NULL, 'fa fa-gear', 1, 1, 5, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (100, 0, 'Transaksi', 'Transaksi', ' ', 'fa fa-retweet', 1, 1, 3, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (101, 100, 'Pengeluaran Harian', 'Pengeluaran Harian', 'pengeluaran', '', 1, 2, 1, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (102, 100, 'Verifikasi Pengeluaran', 'Verifikasi Pengeluaran', 'verifikasi_out', '', 1, 2, 2, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (103, 100, 'Penerimaan', 'Transaksi Penerimaan', 'penerimaan', '', 1, 2, 3, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (104, 0, 'Master', 'Master', ' ', 'fa fa-database', 1, 1, 2, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (105, 104, 'Master Satuan', 'Master Satuan', 'master_satuan', '', 1, 2, 1, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (106, 104, 'Master Akun Internal', 'Master Akun Internal', 'master_akun_internal', '', 1, 2, 2, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (107, 104, 'Master Akun Eksternal', 'Master Akun Eksternal', 'master_akun_eksternal', '', 1, 2, 3, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (108, 0, 'Laporan', 'Laporan', ' ', 'fa fa-line-chart', 1, 1, 5, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (109, 108, 'Buku Kas Umum', 'Buku Kas Umum', 'lap_bku', '', 1, 2, 2, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (110, 0, 'Penggajian', 'Penggajian', ' ', 'fa fa-money', 1, 1, 4, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (111, 110, 'Setting Gaji Guru / Karyawan', 'Setting Gaji Guru / Karyawan', 'set_gaji_guru', '', 1, 2, 1, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (112, 110, 'Setting Gaji Karyawan', 'Setting Gaji Karyawan', 'set_gaji_karyawan', '', 0, 2, 2, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (113, 110, 'Proses Penggajian', 'Proses Penggajian', 'proses_gaji', '', 1, 2, 3, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (114, 104, 'Master Guru dan Staff', 'Master Guru dan Staff', 'master_guru', '', 1, 2, 4, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (115, 104, 'Master Karyawan', 'Master Karyawan', 'master_karyawan', '', 0, 2, 5, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (116, 104, 'Master User', 'Master User', 'master_user', '', 1, 2, 6, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (117, 104, 'Master Jabatan', 'Master Jabatan', 'master_jabatan', NULL, 1, 2, 7, 1, NULL, NULL);
INSERT INTO `tbl_menu` VALUES (118, 110, 'Konfirmasi Penggajian', 'Konfirmasi Penggajian', 'konfirm_gaji', '', 1, 2, 3, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (119, 108, 'Laporan Slip Gaji', 'Laporan Slip Gaji', 'slip_gaji', ' ', 1, 2, 1, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (120, 0, 'Profil', 'Profil', 'profil', 'fa fa-user', 1, 1, 6, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (121, 108, 'Laporan K7', 'Laporan K7', 'lap_k7', '', 1, 2, 3, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (122, 108, 'Kunci Laporan', 'Kunci Laporan', 'kunci_lap', '', 1, 2, 20, 1, 1, 1);
INSERT INTO `tbl_menu` VALUES (123, 108, 'Laporan K2', 'Laporan K2', 'lap_k2', ' ', 1, 2, 4, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (124, 108, 'Laporan K1', 'Laporan K1', 'lap_k1', '', 1, 2, 5, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (125, 108, 'Laporan Pengeluaran', 'Laporan Pengeluaran', 'lap_keluar', ' ', 1, 2, 6, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (126, 108, 'Laporan Penerimaan', 'Laporan Penerimaan', 'lap_masuk', ' ', 1, 2, 7, 0, 0, 0);
INSERT INTO `tbl_menu` VALUES (127, 100, 'RAPBS', 'RAPBS', 'trans_rapbs', ' ', 1, 2, 4, 1, 1, 1);

SET FOREIGN_KEY_CHECKS = 1;
