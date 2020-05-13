/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100129
 Source Host           : localhost:3306
 Source Schema         : properti

 Target Server Type    : MySQL
 Target Server Version : 100129
 File Encoding         : 65001

 Date: 13/05/2020 14:19:10
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
INSERT INTO `m_menu` VALUES (6, 5, 'Master Produk', 'Master Produk', 'admin/master_produk_adm', '', 0, 2, 1, 1, 1, 1);
INSERT INTO `m_menu` VALUES (7, 5, 'Master User', 'Master User', 'admin/master_user', '', 1, 2, 2, 1, 1, 1);
INSERT INTO `m_menu` VALUES (8, 5, 'Master Konten', 'Master Konten', 'admin/master_konten_adm', '', 1, 2, 3, 1, 1, 1);
INSERT INTO `m_menu` VALUES (9, 0, 'Transaksi', 'Transaksi', ' ', 'fa fa-exchange', 1, 1, 3, 0, 0, 0);
INSERT INTO `m_menu` VALUES (10, 9, 'Penjualan', 'Penjualan', 'admin/penjualan', '', 1, 2, 1, 1, 1, 1);
INSERT INTO `m_menu` VALUES (11, 0, 'Laporan', 'Laporan', ' ', 'fa fa-line-chart', 1, 1, 4, 0, 0, 0);
INSERT INTO `m_menu` VALUES (12, 11, 'Laporan Penjualan', 'Laporan Penjualan', 'admin/lap_penjualan', '', 1, 2, 1, 0, 0, 0);
INSERT INTO `m_menu` VALUES (13, 9, 'Verifikasi Klaim', 'Verifikaai Klaim', 'admin/verifikasi_klaim', '', 1, 2, 2, 1, 1, 1);
INSERT INTO `m_menu` VALUES (14, 9, 'Setting Harga', 'Setting Harga', 'admin/set_harga', '', 1, 2, 3, 1, 1, 1);
INSERT INTO `m_menu` VALUES (15, 11, 'Laporan Komisi Agen', 'Laporan Komisi Agen', 'admin/lap_penjualan_agen', '', 1, 2, 2, 0, 0, 0);
INSERT INTO `m_menu` VALUES (16, 11, 'Laporan Komisi Per Agen', 'Laporan Komisi Per Agen', 'admin/lap_komisi_agen', '', 1, 2, 3, 0, 0, 0);
INSERT INTO `m_menu` VALUES (17, 9, 'Cek Kode Ref', 'Cek Kode Ref', 'admin/cek_kode_ref', '', 1, 2, 5, 1, 1, 1);

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
INSERT INTO `m_user` VALUES ('USR00001', 'dwi_admin', 'hX2fmaWl', 1, NULL, 1, '2020-05-13 13:49:25', '2019-10-05 21:34:14', '2020-05-13 13:49:25', NULL);
INSERT INTO `m_user` VALUES ('USR00002', 'Atriyani', 'tb/eztXbs82swqaf', 2, NULL, 1, '2020-04-28 16:49:56', '2020-04-14 10:43:04', '2020-04-28 02:49:56', 'H6J33W2');
INSERT INTO `m_user` VALUES ('USR00003', 'A_D._Setyoko', 'v73V2OTYvMCxz9LZyoWEo5k=', 2, NULL, 1, '2020-04-16 16:58:46', '2020-04-14 11:22:50', '2020-04-16 02:58:46', 'J6J43J1');
INSERT INTO `m_user` VALUES ('USR00004', 'Nyuwardi', 'uLDa2OXihpeB', 2, NULL, 1, '2020-04-27 14:45:59', '2020-04-14 11:47:37', '2020-04-27 00:45:59', 'X6Z43A3');
INSERT INTO `m_user` VALUES ('USR00005', 'Lucia Sri Wahyuni', 'zbrT3tHar9G8wp+Z', 2, NULL, 1, '2020-04-29 05:43:08', '2020-04-14 13:58:43', '2020-04-28 15:43:08', 'B6M79B1');
INSERT INTO `m_user` VALUES ('USR00006', 'jhardini', 'v6zlxuLQx8CAmQ==', 2, NULL, 1, '2020-04-15 06:03:29', '2020-04-15 02:24:16', '2020-04-14 23:03:29', 'J7B61J0');
INSERT INTO `m_user` VALUES ('USR00007', 'Admin', 'ta/Zzt6ggJJ6mq8=', 2, NULL, 1, '2020-04-16 17:19:21', '2020-04-15 04:07:02', '2020-04-16 03:19:21', 'F5M57Z8');
INSERT INTO `m_user` VALUES ('USR00008', 'Fendi10', 'xLWdnqCn', 2, NULL, 1, '2020-05-13 14:06:54', '2020-04-15 13:05:51', '2020-05-13 14:06:54', 'C8H43V8');
INSERT INTO `m_user` VALUES ('USR00009', 'HESTIWORO SUHARDJONO', 'hX2cmKGf', 2, NULL, 1, '2020-04-16 17:33:57', '2020-04-16 17:15:50', '2020-04-16 03:33:57', 'F2Q36F3');

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
  `bank` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `rekening` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user_detail`) USING BTREE,
  UNIQUE INDEX `id_user`(`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of m_user_detail
-- ----------------------------
INSERT INTO `m_user_detail` VALUES (1, 'USR00001', 'Administrator Aplikasi', 'Jl. Harapan Nusa Dan Bangsa', '1986-11-08', 'L', '0868574548454', 'user_default.png', 'user_default_thumb.png', NULL, NULL, NULL);
INSERT INTO `m_user_detail` VALUES (21, 'USR00002', 'Atrie', NULL, '1970-01-01', NULL, '085745628888', 'user_default.png', 'user_default_thumb.png', 'atriyani802@gmail.com', 'MANDIRI', '1370016937647');
INSERT INTO `m_user_detail` VALUES (22, 'USR00003', 'Antonius Dwi', NULL, '1970-01-01', NULL, '087794524152', 'antonius-1586863810.jpg', 'user_default_thumb.png', 'bill_setyoko@yahoo.com', 'BRI', '309301026648531');
INSERT INTO `m_user_detail` VALUES (23, 'USR00004', 'Nyuwardi', NULL, '1970-01-01', NULL, '085139089366', 'user_default.png', 'user_default_thumb.png', 'sinyonyuwardi@gmail.com', 'BNI', '0187475153');
INSERT INTO `m_user_detail` VALUES (24, 'USR00005', 'Lucia', NULL, '1970-01-01', NULL, '082136944194', 'user_default.png', 'user_default_thumb.png', 'lusyyogyakarta@gmail.com', 'MANDIRI', '137-00-1222834-8');
INSERT INTO `m_user_detail` VALUES (25, 'USR00006', 'Hardini', NULL, '1970-01-01', NULL, '081917390999', 'user_default.png', 'user_default_thumb.png', 'jhardini@yahoo.co.id', 'BNI', '0306699251');
INSERT INTO `m_user_detail` VALUES (26, 'USR00007', 'Administrasi', NULL, '1970-01-01', NULL, '081234567892', 'user_default.png', 'user_default_thumb.png', 'siswa.admin@gmail.com', 'BCA', '6789987765');
INSERT INTO `m_user_detail` VALUES (27, 'USR00008', 'Fendi', NULL, '1970-01-01', NULL, '08115759014', 'user_default.png', 'user_default_thumb.png', 'pointtravel88@yahoo.com', 'BCA', '1710682077');
INSERT INTO `m_user_detail` VALUES (28, 'USR00009', 'HESTIWORO', NULL, '1970-01-01', NULL, '08129293771', 'user_default.png', 'user_default_thumb.png', 'hestisuhardjono@gmail.com', 'BCA', '7060051571');

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
  `is_verify_klaim` int(1) NOT NULL DEFAULT 0,
  `id_klaim_agen` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jenis` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'paket',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_checkout
-- ----------------------------
INSERT INTO `t_checkout` VALUES ('1556af6c-db15-45bd-88d4-94e5765267ad', NULL, 1200000.00, 0.00, 0.00, 'jOJ20', NULL, 1, 'Atrie', '', 'atriyani802@gmail.com', '085745628888', 'bukti-atrie-1586860984.jpg', '2020-04-14 10:43:04', NULL, NULL, 0, 0, 0, NULL, 'affiliate');
INSERT INTO `t_checkout` VALUES ('166255dc-dc56-4409-ba4b-2e4e259ea651', NULL, 3000000.00, 550000.00, 0.00, 'jYl7E', 'J6J43J1', 0, 'johanes marfuah', '', 'johan@fuah.com', '0454845435350', 'bukti-johanes-marfuah-1589352220.jpg', '2020-05-13 13:43:40', NULL, NULL, 1, 0, 0, NULL, 'paket');
INSERT INTO `t_checkout` VALUES ('18ab4fd8-b308-47a3-bb2f-d759cbe93e2f', NULL, 1200000.00, 0.00, 0.00, 'jOZKI', NULL, 1, 'Administrasi', '', 'siswa.admin@gmail.com', '081234567892', 'bukti-administrasi-1586923622.jpg', '2020-04-15 04:07:02', NULL, NULL, 0, 0, 0, NULL, 'affiliate');
INSERT INTO `t_checkout` VALUES ('2f07c501-d673-4f4b-8931-dfdeb75501f6', NULL, 3000000.00, 550000.00, 0.00, 'jOa0S', 'F5M57Z8', 1, 'Cobaanak', NULL, 'coba.anak@gmail.com', '086789765432', 'bukti-cobaanak-1586926236.jpeg', '2020-04-15 04:50:36', NULL, NULL, 0, 0, 0, NULL, 'paket');
INSERT INTO `t_checkout` VALUES ('4c5e686f-8436-4fef-9c02-f9741273b350', NULL, 3000000.00, 550000.00, 0.00, 'jYPFh', 'C8H43V8', 1, 'coba_1', '', 'coba1@gmail.com', '111111111', 'bukti-coba-1-1589268176.png', '2020-05-12 14:22:57', NULL, NULL, 0, 1, 0, 'fd3def5f-751f-478e-be12-6243affa4a36', 'paket');
INSERT INTO `t_checkout` VALUES ('6badde52-1246-4e85-83d1-bcdb0f477081', NULL, 1200000.00, 0.00, 0.00, 'jOJeU', NULL, 1, 'Antonius', '', 'bill_setyoko@yahoo.com', '087794524152', 'bukti-antonius-1586863369.jpg', '2020-04-14 11:22:50', NULL, NULL, 0, 0, 0, NULL, 'affiliate');
INSERT INTO `t_checkout` VALUES ('8c571ff4-6ef3-4a56-b3ef-b9bcfffb67c0', NULL, 1200000.00, 0.00, 0.00, 'jOM5L', NULL, 1, 'Lucia', '', 'lusyyogyakarta@gmail.com', '082136944194', 'bukti-lucia-1586872722.jpg', '2020-04-14 13:58:43', NULL, NULL, 0, 0, 0, NULL, 'affiliate');
INSERT INTO `t_checkout` VALUES ('93ea373d-b85b-4495-8c75-b1394244bd26', NULL, 1200000.00, 0.00, 0.00, 'jP1Yk', NULL, 1, 'HESTIWORO', '', 'hestisuhardjono@gmail.com', '08129293771', 'bukti-hestiworo-1587032148.jpg', '2020-04-16 17:15:50', NULL, NULL, 0, 0, 0, NULL, 'affiliate');
INSERT INTO `t_checkout` VALUES ('aa943578-2269-400d-bc39-df4490608844', NULL, 3000000.00, 550000.00, 0.00, 'jYlFP', 'J7B61J0', 0, 'Cendol Dawet', '', 'cendol@dawet.com', '128918209812981', 'bukti-cendol-dawet-1589352727.png', '2020-05-13 13:52:07', NULL, NULL, 1, 0, 0, NULL, 'paket');
INSERT INTO `t_checkout` VALUES ('b9fb09f0-a62f-41cd-89c3-106ba5412778', NULL, 1200000.00, 0.00, 0.00, 'jOXiq', NULL, 1, 'Hardini', '', 'jhardini@yahoo.co.id', '081917390999', 'bukti-hardini-1586917455.png', '2020-04-15 02:24:16', NULL, NULL, 0, 0, 0, NULL, 'affiliate');
INSERT INTO `t_checkout` VALUES ('d215ad83-0d55-40a9-b063-f3b764b5672d', NULL, 1200000.00, 0.00, 0.00, 'jOK2T', NULL, 1, 'Nyuwardi', '', 'sinyonyuwardi@gmail.com', '085139089366', 'bukti-nyuwardi-1586864856.jpg', '2020-04-14 11:47:37', NULL, NULL, 0, 0, 0, NULL, 'affiliate');
INSERT INTO `t_checkout` VALUES ('d320967b-8ba0-4836-b5c8-5bc404084a82', NULL, 1200000.00, 0.00, 0.00, 'jOhjj', NULL, 1, 'Fendi', '', 'pointtravel88@yahoo.com', '08115759014', 'bukti-fendi-1586955950.png', '2020-04-15 13:05:51', NULL, NULL, 0, 0, 0, NULL, 'affiliate');

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
INSERT INTO `t_hak_akses` VALUES (7, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (8, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (9, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (10, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (13, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (14, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (17, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (11, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (12, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (15, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (16, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (4, 1, 0, 0, 0);
INSERT INTO `t_hak_akses` VALUES (3, 1, 1, 1, 1);
INSERT INTO `t_hak_akses` VALUES (2, 1, 1, 1, 1);

-- ----------------------------
-- Table structure for t_klaim_agen
-- ----------------------------
DROP TABLE IF EXISTS `t_klaim_agen`;
CREATE TABLE `t_klaim_agen`  (
  `id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_agen` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_user_verify` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `saldo_sebelum` double(20, 2) NULL DEFAULT 0.00 COMMENT 'uang yg sudah diklaim ke agen',
  `jumlah_klaim` double(20, 2) NULL DEFAULT 0.00 COMMENT 'jumlah uang yg akan diklem oleh agen',
  `saldo_sesudah` double(20, 2) NULL DEFAULT 0.00 COMMENT 'uang yg sudah diklaim + jumlah uang yg akan di klem',
  `datetime_klaim` datetime(0) NULL DEFAULT NULL,
  `datetime_verify` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `deleted_at` datetime(0) NULL DEFAULT NULL,
  `kode_klaim` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'sebagai kode refferal',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_klaim_agen
-- ----------------------------
INSERT INTO `t_klaim_agen` VALUES ('fd3def5f-751f-478e-be12-6243affa4a36', 'C8H43V8', NULL, 0.00, 550000.00, 550000.00, '2020-05-13 14:07:11', NULL, '2020-05-13 14:07:11', NULL, 'C-TGgA0');

-- ----------------------------
-- Table structure for t_klaim_verify
-- ----------------------------
DROP TABLE IF EXISTS `t_klaim_verify`;
CREATE TABLE `t_klaim_verify`  (
  `id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_klaim_agen` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_user` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tanggal_verify` datetime(0) NOT NULL,
  `bank` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `rekening` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bukti` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nilai_transfer` double(20, 2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for t_log_harga
-- ----------------------------
DROP TABLE IF EXISTS `t_log_harga`;
CREATE TABLE `t_log_harga`  (
  `id` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `harga_satuan` double(20, 2) NULL DEFAULT 0.00,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `diskon_agen` int(3) NULL DEFAULT NULL COMMENT 'besaran potongan agen',
  `harga_diskon_agen` double(20, 2) NULL DEFAULT NULL COMMENT 'nilai potongan agen',
  `is_aktif` int(1) NULL DEFAULT 1,
  `diskon_paket` int(3) NULL DEFAULT NULL COMMENT 'besaran diskon',
  `harga_diskon_paket` double(20, 2) NULL DEFAULT NULL COMMENT 'nilai diskon',
  `tanggal_berlaku` timestamp(0) NULL DEFAULT NULL,
  `jenis` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of t_log_harga
-- ----------------------------
INSERT INTO `t_log_harga` VALUES ('ceda0b5a-7a02-46f1-9030-ff38c88fd157', 3000000.00, '2020-04-13 07:59:49', 18, 550000.00, 1, 0, 3000000.00, '2020-04-14 02:00:00', 'paket');
INSERT INTO `t_log_harga` VALUES ('efefed31-2f8e-4954-98d6-03359b3d067e', 1200000.00, '2020-04-13 08:00:16', 0, 0.00, 1, 0, 1200000.00, '2020-04-14 02:00:00', 'affiliate');

SET FOREIGN_KEY_CHECKS = 1;
