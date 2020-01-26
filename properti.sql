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

 Date: 26/01/2020 23:31:18
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
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_user
-- ----------------------------
INSERT INTO `m_user` VALUES ('USR00001', 'masnur', 'kmJnZmZo', 1, NULL, 1, '2020-01-26 16:25:54', '2019-10-05 21:34:14', '2020-01-26 22:25:54');
INSERT INTO `m_user` VALUES ('USR00002', 'agen', 'kmJnZmZo', 2, NULL, 1, '2019-12-03 08:42:33', '2019-11-09 19:36:13', '2020-01-21 15:03:27');
INSERT INTO `m_user` VALUES ('USR00003', 'customer', 'kmJnZmZo', 3, NULL, 1, '2019-12-03 08:41:40', '2019-11-09 19:43:19', '2020-01-21 15:03:52');

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
  PRIMARY KEY (`id_user_detail`) USING BTREE,
  UNIQUE INDEX `id_user`(`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_user_detail
-- ----------------------------
INSERT INTO `m_user_detail` VALUES (1, 'USR00001', 'Masnur Ganteng', 'Jl. Harapan Nusa Dan Bangsa', '1986-11-08', 'L', '0868574548454', 'admin-1573576263.jpg', 'admin-1573576263_thumb.jpg');
INSERT INTO `m_user_detail` VALUES (2, 'USR00002', 'Agen', 'aifudf nisduf sidufis ndudrs', '1945-10-09', 'L', '0819218129121', 'kepsek-1573302973.jpg', 'kepsek-1573302973_thumb.jpg');
INSERT INTO `m_user_detail` VALUES (3, 'USR00003', 'Customer', 'asfsd', '1963-02-14', 'L', '121312', 'keuangan-1573303398.jpg', 'keuangan-1573303398_thumb.jpg');

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
INSERT INTO `t_hak_akses` VALUES (4, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (3, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (2, 1, 1, 1, 1);

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
