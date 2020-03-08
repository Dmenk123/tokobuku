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

 Date: 09/03/2020 00:04:47
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
INSERT INTO `m_menu` VALUES (7, 5, 'Mster Agen', 'Mster Agen', 'master_agen', '', 1, 2, 2, 1, 1, 1);
INSERT INTO `m_menu` VALUES (8, 5, 'Master Konten', 'Master Konten', 'master_konten', '', 1, 2, 3, 1, 1, 1);

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
INSERT INTO `m_user` VALUES ('USR00001', 'masnur', 'hX2fmaWl', 1, NULL, 1, '2020-02-17 09:29:53', '2019-10-05 21:34:14', '2020-02-17 15:29:53', NULL);
INSERT INTO `m_user` VALUES ('USR00002', 'agen', 'hX2fmaWl', 2, NULL, 1, '2019-12-03 08:42:33', '2019-11-09 19:36:13', '2020-02-17 15:37:28', 'Ioa2fmaCuS');
INSERT INTO `m_user` VALUES ('USR00003', 'customer', 'hX2fmaWl', 3, NULL, 1, '2019-12-03 08:41:40', '2019-11-09 19:43:19', '2020-02-17 15:29:42', NULL);
INSERT INTO `m_user` VALUES ('USR00004', 'coba', 'hX2fmaWl', 3, NULL, 1, '2020-03-08 16:59:09', '2020-02-07 13:28:03', '2020-03-08 22:59:09', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_user_detail
-- ----------------------------
INSERT INTO `m_user_detail` VALUES (1, 'USR00001', 'Masnur Ganteng', 'Jl. Harapan Nusa Dan Bangsa', '1986-11-08', 'L', '0868574548454', 'admin-1573576263.jpg', 'admin-1573576263_thumb.jpg', NULL);
INSERT INTO `m_user_detail` VALUES (2, 'USR00002', 'Agen', 'aifudf nisduf sidufis ndudrs', '1945-10-09', 'L', '0819218129121', 'kepsek-1573302973.jpg', 'kepsek-1573302973_thumb.jpg', NULL);
INSERT INTO `m_user_detail` VALUES (3, 'USR00003', 'Customer', 'asfsd', '1963-02-14', 'L', '121312', 'keuangan-1573303398.jpg', 'keuangan-1573303398_thumb.jpg', NULL);
INSERT INTO `m_user_detail` VALUES (8, 'USR00004', 'coba,cobalah', NULL, '1970-01-01', NULL, '121212', 'coba-1581928536-.jpg', 'coba-1581928536-.jpg', 'coba@gmail.com');

-- ----------------------------
-- Table structure for t_checkout
-- ----------------------------
DROP TABLE IF EXISTS `t_checkout`;
CREATE TABLE `t_checkout`  (
  `id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_user` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga_total` double(20, 2) NULL DEFAULT NULL,
  `is_konfirm` int(1) NULL DEFAULT 0,
  `nama_depan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_belakang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telepon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `catatan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `bukti` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1 COMMENT '1: aktif, 0: nonaktif',
  `kode_ref` varchar(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'kode referensi',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_checkout
-- ----------------------------
INSERT INTO `t_checkout` VALUES ('09fe5a96-a6f8-4e8e-aebf-33150a829b4c', 'USR00004', 5000000.00, 0, 'coba', 'cobalah', 'coba@gmail.com', '', '', 'coba-1581928536-.jpg', '2020-02-17 09:35:36', NULL, NULL, 0, NULL);
INSERT INTO `t_checkout` VALUES ('3d80cebc-5130-48dd-9c1c-29badd14d438', 'USR00004', 500000.00, 0, 'coba', 'cobalah', 'coba@gmail.com', '', '', 'coba-1583082087-.jpg', '2020-03-01 18:01:28', NULL, NULL, 0, NULL);
INSERT INTO `t_checkout` VALUES ('6bc96039-9dc4-4ef7-97e9-f42beb8bbd3a', 'USR00004', 1200000.00, 0, 'coba', 'cobalah', 'coba@gmail.com', '', '', 'coba-1583683834-.jpg', '2020-03-08 17:10:34', NULL, NULL, 1, 'jAyVe');
INSERT INTO `t_checkout` VALUES ('cafbbb17-4686-4635-87d0-2f591929efc3', 'USR00004', 2850000.00, 0, 'coba', 'cobalah', 'coba@gmail.com', '', '', 'coba-1581784821-.jpg', '2020-02-15 17:40:22', NULL, NULL, 0, NULL);
INSERT INTO `t_checkout` VALUES ('edb467fe-3eda-4a40-a67f-02474ed4834f', 'USR00004', 250000.00, 0, 'coba', 'cobalah', 'coba@gmail.com', '', '', 'coba-1583633717-.jpg', '2020-03-08 03:15:17', NULL, NULL, 1, 'Mak12');

-- ----------------------------
-- Table structure for t_checkout_detail
-- ----------------------------
DROP TABLE IF EXISTS `t_checkout_detail`;
CREATE TABLE `t_checkout_detail`  (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `id_checkout` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_satuan` int(12) NULL DEFAULT NULL,
  `qty` int(12) NULL DEFAULT NULL,
  `harga_satuan` double(20, 2) NULL DEFAULT NULL,
  `harga_subtotal` double(20, 2) NULL DEFAULT NULL,
  `id_agen` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_checkout_detail
-- ----------------------------
INSERT INTO `t_checkout_detail` VALUES (1, 'cafbbb17-4686-4635-87d0-2f591929efc3', '93bb84ec-dd68-4c25-8465-c4493d36e533', 1, 5, 250000.00, 1250000.00, 'AGN001');
INSERT INTO `t_checkout_detail` VALUES (2, 'cafbbb17-4686-4635-87d0-2f591929efc3', '9bbc71f3-668c-4fa0-b572-aae222caad4c', 1, 8, 200000.00, 1600000.00, 'AGN001');
INSERT INTO `t_checkout_detail` VALUES (3, '09fe5a96-a6f8-4e8e-aebf-33150a829b4c', '9bbc71f3-668c-4fa0-b572-aae222caad4c', 1, 4, 200000.00, 800000.00, 'AGN001');
INSERT INTO `t_checkout_detail` VALUES (4, '09fe5a96-a6f8-4e8e-aebf-33150a829b4c', '543d0127-090c-42be-ade1-29c7b5c00f6e', 1, 7, 600000.00, 4200000.00, 'AGN001');
INSERT INTO `t_checkout_detail` VALUES (5, '3d80cebc-5130-48dd-9c1c-29badd14d438', '93bb84ec-dd68-4c25-8465-c4493d36e533', 1, 2, 250000.00, 500000.00, 'AGN001');
INSERT INTO `t_checkout_detail` VALUES (6, 'edb467fe-3eda-4a40-a67f-02474ed4834f', '93bb84ec-dd68-4c25-8465-c4493d36e533', 1, 1, 250000.00, 250000.00, 'AGN001');
INSERT INTO `t_checkout_detail` VALUES (7, '6bc96039-9dc4-4ef7-97e9-f42beb8bbd3a', '543d0127-090c-42be-ade1-29c7b5c00f6e', 1, 1, 600000.00, 600000.00, 'Ioa2fmaCuS');
INSERT INTO `t_checkout_detail` VALUES (8, '6bc96039-9dc4-4ef7-97e9-f42beb8bbd3a', '9bbc71f3-668c-4fa0-b572-aae222caad4c', 1, 3, 200000.00, 600000.00, 'Ioa2fmaCuS');

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
INSERT INTO `t_hak_akses` VALUES (4, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (3, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (2, 1, 1, 1, 1);

-- ----------------------------
-- Table structure for t_log_harga
-- ----------------------------
DROP TABLE IF EXISTS `t_log_harga`;
CREATE TABLE `t_log_harga`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `harga_satuan` double(20, 2) NULL DEFAULT 0.00,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `potongan` int(3) NULL DEFAULT NULL,
  `harga_potongan` double(20, 2) NULL DEFAULT NULL,
  `is_aktif` int(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_log_harga
-- ----------------------------
INSERT INTO `t_log_harga` VALUES (5, '9bbc71f3-668c-4fa0-b572-aae222caad4c', 200000.00, '2020-02-01 13:10:30', 10, 20000.00, 1);
INSERT INTO `t_log_harga` VALUES (6, '93bb84ec-dd68-4c25-8465-c4493d36e533', 250000.00, '2020-02-02 14:25:31', 10, 25000.00, 1);
INSERT INTO `t_log_harga` VALUES (7, '543d0127-090c-42be-ade1-29c7b5c00f6e', 600000.00, '2020-02-02 14:27:26', 10, 60000.00, 1);

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
