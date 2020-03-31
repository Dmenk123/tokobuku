/*
 Navicat Premium Data Transfer

 Source Server         : lokal
 Source Server Type    : MySQL
 Source Server Version : 100131
 Source Host           : localhost:3306
 Source Schema         : properti

 Target Server Type    : MySQL
 Target Server Version : 100131
 File Encoding         : 65001

 Date: 31/03/2020 20:35:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_kategori
-- ----------------------------
DROP TABLE IF EXISTS `m_kategori`;
CREATE TABLE `m_kategori`  (
  `id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `akronim` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_kategori
-- ----------------------------
INSERT INTO `m_kategori` VALUES ('1', 'Teknologi', 'Teknologi', 'TEK');
INSERT INTO `m_kategori` VALUES ('2', 'Fiksi', 'Fiksi', 'FIK');

-- ----------------------------
-- Table structure for m_konten
-- ----------------------------
DROP TABLE IF EXISTS `m_konten`;
CREATE TABLE `m_konten`  (
  `id_konten` int(255) NOT NULL AUTO_INCREMENT,
  `isi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id_konten`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for m_level_user
-- ----------------------------
DROP TABLE IF EXISTS `m_level_user`;
CREATE TABLE `m_level_user`  (
  `id_level_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_level_user` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan_level_user` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '',
  `aktif` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_level_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_level_user
-- ----------------------------
INSERT INTO `m_level_user` VALUES (1, 'Administrator', 'Administrator', 1);
INSERT INTO `m_level_user` VALUES (2, 'Agen', 'Agen', 1);
INSERT INTO `m_level_user` VALUES (3, 'Customer', 'Customer', 1);

-- ----------------------------
-- Table structure for m_menu
-- ----------------------------
DROP TABLE IF EXISTS `m_menu`;
CREATE TABLE `m_menu`  (
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
-- Records of m_menu
-- ----------------------------
INSERT INTO `m_menu` VALUES (1, 0, 'Dashboard', 'Dashboard', 'admin/dashboard', 'fa fa-dashboard', 1, 1, 1, 0, 0, 0);
INSERT INTO `m_menu` VALUES (2, 4, 'Setting Menu', 'Setting Menu', 'admin/set_menu_adm', NULL, 1, 2, 2, 1, 1, 1);
INSERT INTO `m_menu` VALUES (3, 4, 'Setting Role', 'Setting Role', 'admin/set_role_adm', '', 1, 2, 1, 1, 1, 1);
INSERT INTO `m_menu` VALUES (4, 0, 'Setting (Administrator)', 'Setting', NULL, 'fa fa-gear', 1, 1, 5, 0, 0, 0);
INSERT INTO `m_menu` VALUES (5, 0, 'Data Master', 'Data Master', ' ', 'fa fa-database', 1, 1, 2, 0, 0, 0);
INSERT INTO `m_menu` VALUES (6, 5, 'Master Produk', 'Master Produk', 'admin/master_produk_adm', '', 1, 2, 1, 1, 1, 1);
INSERT INTO `m_menu` VALUES (7, 5, 'Mster Agen', 'Mster Agen', 'admin/master_agen', '', 1, 2, 2, 1, 1, 1);
INSERT INTO `m_menu` VALUES (8, 5, 'Master Konten', 'Master Konten', 'admin/master_konten_adm', '', 1, 2, 3, 1, 1, 1);
INSERT INTO `m_menu` VALUES (9, 0, 'Transaksi', 'Transaksi', ' ', 'fa fa-exchange', 1, 1, 3, 0, 0, 0);
INSERT INTO `m_menu` VALUES (10, 9, 'Penjualan', 'Penjualan', 'admin/penjualan', '', 1, 2, 1, 1, 1, 1);
INSERT INTO `m_menu` VALUES (11, 0, 'Laporan', 'Laporan', ' ', 'fa fa-line-chart', 1, 1, 4, 0, 0, 0);
INSERT INTO `m_menu` VALUES (12, 11, 'Laporan Penjualan', 'Laporan Penjualan', 'admin/lap_penjualan', '', 1, 2, 1, 0, 0, 0);

-- ----------------------------
-- Table structure for m_produk
-- ----------------------------
DROP TABLE IF EXISTS `m_produk`;
CREATE TABLE `m_produk`  (
  `id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_kategori` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_satuan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `dimensi_panjang` double(20, 2) NULL DEFAULT NULL,
  `dimensi_lebar` double(20, 2) NULL DEFAULT NULL,
  `jumlah_halaman` int(14) NULL DEFAULT NULL,
  `penerbit` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tahun` varchar(4) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `is_aktif` int(1) NULL DEFAULT NULL,
  `is_posting` int(1) NULL DEFAULT NULL,
  `gambar_1` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gambar_2` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gambar_3` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `thumb` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_produk
-- ----------------------------
INSERT INTO `m_produk` VALUES ('543d0127-090c-42be-ade1-29c7b5c00f6e', '1', '1', 'TEK00003', '20 MACAM MANTRA CEPAT KAYA', '20 MACAM MANTRA CEPAT KAYA', 67.00, 41.00, 761, 'CV. Anugerah Jaya Sentosa', '2020', '2020-02-02 14:27:26', NULL, NULL, 1, 1, '20-macam-mantra-cepat-kaya-1580650044-0.jpg', '20-macam-mantra-cepat-kaya-1580650044-1.jpg', '20-macam-mantra-cepat-kaya-1580650044-2.jpg', NULL);
INSERT INTO `m_produk` VALUES ('93bb84ec-dd68-4c25-8465-c4493d36e533', '1', '1', 'TEK00002', 'PANDUAN KAYA LEWAT MIMPI', 'PANDUAN KAYA LEWAT MIMPI SESUAI SYARIAH', 27.00, 80.00, 412, 'KI. JOKO SAMUDRO KENCONO', '2020', '2020-02-02 14:25:31', NULL, NULL, 1, 1, 'panduan-kaya-lewat-mimpi-1580649930-0.jpg', 'panduan-kaya-lewat-mimpi-1580649930-1.jpg', 'panduan-kaya-lewat-mimpi-1580649930-2.jpg', NULL);
INSERT INTO `m_produk` VALUES ('9bbc71f3-668c-4fa0-b572-aae222caad4c', '1', '1', 'TEK00001', '10 HARI MENGUASAI ROGO SUKMO', 'EBOOK 10 Hari Menguasai Rogo Sukmo', 40.00, 34.00, 289, 'CV. Anugerah Jaya Sentosa', '2020', '2020-02-01 13:10:30', NULL, NULL, 1, 1, 'ebook-10-hari-menguasai-rogo-sukmo-1580559029-0.jpeg', 'ebook-10-hari-menguasai-rogo-sukmo-1580559029-1.jpg', 'ebook-10-hari-menguasai-rogo-sukmo-1580559029-2.jpeg', NULL);

-- ----------------------------
-- Table structure for m_satuan
-- ----------------------------
DROP TABLE IF EXISTS `m_satuan`;
CREATE TABLE `m_satuan`  (
  `id` int(11) NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_aktif` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_satuan
-- ----------------------------
INSERT INTO `m_satuan` VALUES (1, 'PCS', 1);
INSERT INTO `m_satuan` VALUES (2, 'BOX', 1);
INSERT INTO `m_satuan` VALUES (3, 'PACK', 1);

-- ----------------------------
-- Table structure for m_user
-- ----------------------------
DROP TABLE IF EXISTS `m_user`;
CREATE TABLE `m_user`  (
  `id_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_level_user` int(11) NULL DEFAULT NULL,
  `id_pegawai` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT NULL,
  `last_login` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `kode_agen` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_user
-- ----------------------------
INSERT INTO `m_user` VALUES ('USR00001', 'masnur', 'hX2fmaWl', 1, NULL, 1, '2020-03-31 06:09:12', '2019-10-05 21:34:14', '2020-03-31 11:09:12', NULL);
INSERT INTO `m_user` VALUES ('USR00002', 'agen', 'hX2fmaWl', 2, NULL, 1, '2020-03-31 13:00:14', '2019-11-09 19:36:13', '2020-03-31 18:00:14', 'Ioa2fmaCuS');
INSERT INTO `m_user` VALUES ('USR00003', 'customer', 'hX2fmaWl', 3, NULL, 1, '2019-12-03 08:41:40', '2019-11-09 19:43:19', '2020-02-17 15:29:42', NULL);
INSERT INTO `m_user` VALUES ('USR00004', 'coba', 'hX2fmaWl', 3, NULL, 1, '2020-03-15 17:23:51', '2020-02-07 13:28:03', '2020-03-15 23:23:51', NULL);
INSERT INTO `m_user` VALUES ('USR00005', 'jono', 'hX2fmaWl', 3, NULL, 1, '2020-03-23 17:56:57', '2020-03-11 13:20:26', '2020-03-23 23:56:57', NULL);
INSERT INTO `m_user` VALUES ('USR00006', 'dwi', 'hX2fmaWl', 2, NULL, 1, '2020-03-31 14:33:18', '2020-03-11 13:40:48', '2020-03-31 19:33:18', 'S8N45T9');

-- ----------------------------
-- Table structure for m_user_detail
-- ----------------------------
DROP TABLE IF EXISTS `m_user_detail`;
CREATE TABLE `m_user_detail`  (
  `id_user_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_lengkap_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Akun Baru',
  `alamat_user` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `tanggal_lahir_user` date NULL DEFAULT '1970-01-01',
  `jenis_kelamin_user` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_telp_user` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gambar_user` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'user_default.png',
  `thumb_gambar_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'user_default_thumb.png',
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user_detail`) USING BTREE,
  UNIQUE INDEX `id_user`(`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_user_detail
-- ----------------------------
INSERT INTO `m_user_detail` VALUES (1, 'USR00001', 'Masnur Ganteng', 'Jl. Harapan Nusa Dan Bangsa', '1986-11-08', 'L', '0868574548454', 'admin-1573576263.jpg', 'admin-1573576263_thumb.jpg', NULL);
INSERT INTO `m_user_detail` VALUES (2, 'USR00002', 'Agen', 'aifudf nisduf sidufis ndudrs', '1945-10-09', 'L', '0819218129121', 'kepsek-1573302973.jpg', 'kepsek-1573302973_thumb.jpg', NULL);
INSERT INTO `m_user_detail` VALUES (3, 'USR00003', 'Customer', 'asfsd', '1963-02-14', 'L', '121312', 'keuangan-1573303398.jpg', 'keuangan-1573303398_thumb.jpg', NULL);
INSERT INTO `m_user_detail` VALUES (8, 'USR00004', 'coba,cobalah', NULL, '1970-01-01', NULL, '121212', 'coba-1581928536-.jpg', 'coba-1581928536-.jpg', 'coba@gmail.com');
INSERT INTO `m_user_detail` VALUES (9, 'USR00005', 'jono,joni', NULL, '1970-01-01', NULL, '08973633444', 'user_default.png', 'user_default_thumb.png', 'jono@gmail.com');
INSERT INTO `m_user_detail` VALUES (10, 'USR00006', 'dwi,siswanto', NULL, '1970-01-01', NULL, '08575847474', 'coba-1581928536-.jpg', 'user_default_thumb.png', 'dwi@gmail.com');

-- ----------------------------
-- Table structure for t_checkout
-- ----------------------------
DROP TABLE IF EXISTS `t_checkout`;
CREATE TABLE `t_checkout`  (
  `id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_user` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga_total` double(20, 2) NULL DEFAULT NULL,
  `laba_agen_total` double(20, 2) NULL DEFAULT 0.00,
  `diskon_total` double(20, 2) NULL DEFAULT 0.00,
  `kode_ref` varchar(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'kode referensi',
  `kode_agen` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_konfirm` int(1) NULL DEFAULT 0,
  `nama_depan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_belakang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bukti` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1 COMMENT '1: aktif, 0: nonaktif, 2:batal',
  `is_agen_klaim` int(1) NULL DEFAULT 0 COMMENT '1:sudah, 0:belum diklaim',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_checkout
-- ----------------------------
INSERT INTO `t_checkout` VALUES ('1bceaad4-cdd3-442d-b3ca-7011384131e6', NULL, 2700000.00, 0.00, 300000.00, 'jJCvN', NULL, 1, 'coba', 'coba', 'klepon@asa.com', '141212121312', 'bukti-coba-1585645868.jpg', '2020-02-29 11:11:09', NULL, NULL, 0, 0);
INSERT INTO `t_checkout` VALUES ('5f5702e8-1851-4525-8089-3b3700f134f6', NULL, 2700000.00, 0.00, 300000.00, 'jJEYu', NULL, 1, 'karyono', 'soponyono', 'karyo@gmail.com', '0812371212', 'bukti-karyono-1585652164.jpg', '2020-02-29 12:56:04', NULL, NULL, 0, 0);
INSERT INTO `t_checkout` VALUES ('e38fd69d-6e5d-4abc-8ef6-944a339ced1c', NULL, 2700000.00, 270000.00, 300000.00, 'jJ7NZ', 'S8N45T9', 1, 'asasa', 'asasas', 'asa@klkl.com', '121313131', 'bukti-asasa-1585624553.jpg', '2020-03-31 05:15:53', NULL, NULL, 0, 0);
INSERT INTO `t_checkout` VALUES ('fdcb174d-478f-4a93-be74-ff0ab3575207', NULL, 2700000.00, 270000.00, 300000.00, 'jJ7Kl', 'S8N45T9', 1, 'cas', '12', 'asa@sas.com', '131212', 'bukti-cas-1585624378.jpg', '2020-03-31 05:12:59', NULL, NULL, 0, 0);

-- ----------------------------
-- Table structure for t_hak_akses
-- ----------------------------
DROP TABLE IF EXISTS `t_hak_akses`;
CREATE TABLE `t_hak_akses`  (
  `id_menu` int(11) NOT NULL,
  `id_level_user` int(11) NOT NULL,
  `add_button` int(1) NULL DEFAULT NULL,
  `edit_button` int(1) NULL DEFAULT NULL,
  `delete_button` int(1) NULL DEFAULT NULL,
  INDEX `f_level_user`(`id_level_user`) USING BTREE,
  INDEX `id_menu`(`id_menu`) USING BTREE,
  CONSTRAINT `f_level_user` FOREIGN KEY (`id_level_user`) REFERENCES `m_level_user` (`id_level_user`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `t_hak_akses_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `m_menu` (`id_menu`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_hak_akses
-- ----------------------------
INSERT INTO `t_hak_akses` VALUES (1, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (5, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (6, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (7, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (8, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (9, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (10, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (11, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (12, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (4, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (3, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (2, 1, 1, 1, 1);

-- ----------------------------
-- Table structure for t_klaim_agen
-- ----------------------------
DROP TABLE IF EXISTS `t_klaim_agen`;
CREATE TABLE `t_klaim_agen`  (
  `id` int(11) NOT NULL,
  `id_agen` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_user_verify` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `saldo_sebelum` double(20, 2) NULL DEFAULT NULL,
  `jumlah_kalim` double(20, 2) NULL DEFAULT NULL,
  `saldo_sesudah` double(20, 2) NULL DEFAULT NULL,
  `datetime_klaim` datetime(0) NULL DEFAULT NULL,
  `datetime_verify` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for t_log_harga
-- ----------------------------
DROP TABLE IF EXISTS `t_log_harga`;
CREATE TABLE `t_log_harga`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `harga_satuan` double(20, 2) NULL DEFAULT 0.00,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `diskon_agen` int(3) NULL DEFAULT NULL COMMENT 'besaran potongan agen',
  `harga_diskon_agen` double(20, 2) NULL DEFAULT NULL COMMENT 'nilai potongan agen',
  `is_aktif` int(1) NULL DEFAULT 1,
  `diskon_paket` int(3) NULL DEFAULT NULL COMMENT 'besaran diskon',
  `harga_diskon_paket` double(20, 2) NULL DEFAULT NULL COMMENT 'nilai diskon',
  `tanggal_berlaku` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_log_harga
-- ----------------------------
INSERT INTO `t_log_harga` VALUES (1, 3000000.00, '2020-02-01 13:10:30', 10, 270000.00, 1, 10, 2700000.00, '2020-02-01 13:10:30');

-- ----------------------------
-- Function structure for uuid_v4
-- ----------------------------
DROP FUNCTION IF EXISTS `uuid_v4`;
delimiter ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `uuid_v4`() RETURNS char(36) CHARSET latin1
BEGIN
    -- Generate 8 2-byte strings that we will combine into a UUIDv4
    SET @h1 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
    SET @h2 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
    SET @h3 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
    SET @h6 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
    SET @h7 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');
    SET @h8 = LPAD(HEX(FLOOR(RAND() * 0xffff)), 4, '0');

    -- 4th section will start with a 4 indicating the version
    SET @h4 = CONCAT('4', LPAD(HEX(FLOOR(RAND() * 0x0fff)), 3, '0'));

    -- 5th section first half-byte can only be 8, 9 A or B
    SET @h5 = CONCAT(HEX(FLOOR(RAND() * 4 + 8)),
                LPAD(HEX(FLOOR(RAND() * 0x0fff)), 3, '0'));

    -- Build the complete UUID
    RETURN LOWER(CONCAT(
        @h1, @h2, '-', @h3, '-', @h4, '-', @h5, '-', @h6, @h7, @h8
    ));
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
