-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2020 at 01:31 AM
-- Server version: 5.6.47-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `properti`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_kategori`
--

CREATE TABLE `m_kategori` (
  `id` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `akronim` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_kategori`
--

INSERT INTO `m_kategori` (`id`, `nama`, `keterangan`, `akronim`) VALUES
('1', 'Teknologi', 'Teknologi', 'TEK'),
('2', 'Fiksi', 'Fiksi', 'FIK');

-- --------------------------------------------------------

--
-- Table structure for table `m_konten`
--

CREATE TABLE `m_konten` (
  `id_konten` int(255) NOT NULL,
  `isi` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `m_level_user`
--

CREATE TABLE `m_level_user` (
  `id_level_user` int(11) NOT NULL,
  `nama_level_user` varchar(20) NOT NULL,
  `keterangan_level_user` varchar(255) DEFAULT '',
  `aktif` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_level_user`
--

INSERT INTO `m_level_user` (`id_level_user`, `nama_level_user`, `keterangan_level_user`, `aktif`) VALUES
(1, 'Administrator', 'Administrator', 1),
(2, 'Agen', 'Agen', 1),
(3, 'Customer', 'Customer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_menu`
--

CREATE TABLE `m_menu` (
  `id_menu` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `nama_menu` varchar(255) DEFAULT NULL,
  `judul_menu` varchar(255) DEFAULT NULL,
  `link_menu` varchar(255) DEFAULT NULL,
  `icon_menu` varchar(255) DEFAULT NULL,
  `aktif_menu` int(1) DEFAULT NULL,
  `tingkat_menu` int(11) DEFAULT NULL,
  `urutan_menu` int(11) DEFAULT NULL,
  `add_button` int(1) DEFAULT NULL,
  `edit_button` int(1) DEFAULT NULL,
  `delete_button` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_menu`
--

INSERT INTO `m_menu` (`id_menu`, `id_parent`, `nama_menu`, `judul_menu`, `link_menu`, `icon_menu`, `aktif_menu`, `tingkat_menu`, `urutan_menu`, `add_button`, `edit_button`, `delete_button`) VALUES
(1, 0, 'Dashboard', 'Dashboard', 'admin/dashboard', 'fa fa-dashboard', 1, 1, 1, 0, 0, 0),
(2, 4, 'Setting Menu', 'Setting Menu', 'admin/set_menu_adm', NULL, 1, 2, 2, 1, 1, 1),
(3, 4, 'Setting Role', 'Setting Role', 'admin/set_role_adm', '', 1, 2, 1, 1, 1, 1),
(4, 0, 'Setting (Administrator)', 'Setting', NULL, 'fa fa-gear', 1, 1, 5, 0, 0, 0),
(5, 0, 'Data Master', 'Data Master', ' ', 'fa fa-database', 1, 1, 2, 0, 0, 0),
(6, 5, 'Master Produk', 'Master Produk', 'admin/master_produk_adm', '', 0, 2, 1, 1, 1, 1),
(7, 5, 'Master User', 'Master User', 'admin/master_user', '', 1, 2, 2, 1, 1, 1),
(8, 5, 'Master Konten', 'Master Konten', 'admin/master_konten_adm', '', 1, 2, 3, 1, 1, 1),
(9, 0, 'Transaksi', 'Transaksi', ' ', 'fa fa-exchange', 1, 1, 3, 0, 0, 0),
(10, 9, 'Penjualan', 'Penjualan', 'admin/penjualan', '', 1, 2, 1, 1, 1, 1),
(11, 0, 'Laporan', 'Laporan', ' ', 'fa fa-line-chart', 1, 1, 4, 0, 0, 0),
(12, 11, 'Laporan Penjualan', 'Laporan Penjualan', 'admin/lap_penjualan', '', 1, 2, 1, 0, 0, 0),
(13, 9, 'Verifikasi Klaim', 'Verifikaai Klaim', 'admin/verifikasi_klaim', '', 1, 2, 2, 1, 1, 1),
(14, 9, 'Setting Harga', 'Setting Harga', 'admin/set_harga', '', 1, 2, 3, 1, 1, 1),
(15, 11, 'Laporan Komisi Agen', 'Laporan Komisi Agen', 'admin/lap_penjualan_agen', '', 1, 2, 2, 0, 0, 0),
(16, 11, 'Laporan Komisi Per Agen', 'Laporan Komisi Per Agen', 'admin/lap_komisi_agen', '', 1, 2, 3, 0, 0, 0),
(17, 9, 'Cek Kode Referal', 'Cek Kode Referal', 'admin/cek_kode_ref', '', 1, 2, 4, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_produk`
--

CREATE TABLE `m_produk` (
  `id` varchar(255) NOT NULL,
  `id_kategori` varchar(255) DEFAULT NULL,
  `id_satuan` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `dimensi_panjang` double(20,2) DEFAULT NULL,
  `dimensi_lebar` double(20,2) DEFAULT NULL,
  `jumlah_halaman` int(14) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun` varchar(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `is_aktif` int(1) DEFAULT NULL,
  `is_posting` int(1) DEFAULT NULL,
  `gambar_1` varchar(255) DEFAULT NULL,
  `gambar_2` varchar(255) DEFAULT NULL,
  `gambar_3` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_produk`
--

INSERT INTO `m_produk` (`id`, `id_kategori`, `id_satuan`, `kode`, `nama`, `keterangan`, `dimensi_panjang`, `dimensi_lebar`, `jumlah_halaman`, `penerbit`, `tahun`, `created_at`, `updated_at`, `deleted_at`, `is_aktif`, `is_posting`, `gambar_1`, `gambar_2`, `gambar_3`, `thumb`) VALUES
('543d0127-090c-42be-ade1-29c7b5c00f6e', '1', '1', 'TEK00003', '20 MACAM MANTRA CEPAT KAYA', '20 MACAM MANTRA CEPAT KAYA', 67.00, 41.00, 761, 'CV. Anugerah Jaya Sentosa', '2020', '2020-02-02 14:27:26', NULL, NULL, 1, 1, '20-macam-mantra-cepat-kaya-1580650044-0.jpg', '20-macam-mantra-cepat-kaya-1580650044-1.jpg', '20-macam-mantra-cepat-kaya-1580650044-2.jpg', NULL),
('93bb84ec-dd68-4c25-8465-c4493d36e533', '1', '1', 'TEK00002', 'PANDUAN KAYA LEWAT MIMPI', 'PANDUAN KAYA LEWAT MIMPI SESUAI SYARIAH', 27.00, 80.00, 412, 'KI. JOKO SAMUDRO KENCONO', '2020', '2020-02-02 14:25:31', NULL, NULL, 1, 1, 'panduan-kaya-lewat-mimpi-1580649930-0.jpg', 'panduan-kaya-lewat-mimpi-1580649930-1.jpg', 'panduan-kaya-lewat-mimpi-1580649930-2.jpg', NULL),
('9bbc71f3-668c-4fa0-b572-aae222caad4c', '1', '1', 'TEK00001', '10 HARI MENGUASAI ROGO SUKMO', 'EBOOK 10 Hari Menguasai Rogo Sukmo', 40.00, 34.00, 289, 'CV. Anugerah Jaya Sentosa', '2020', '2020-02-01 13:10:30', NULL, NULL, 1, 1, 'ebook-10-hari-menguasai-rogo-sukmo-1580559029-0.jpeg', 'ebook-10-hari-menguasai-rogo-sukmo-1580559029-1.jpg', 'ebook-10-hari-menguasai-rogo-sukmo-1580559029-2.jpeg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_satuan`
--

CREATE TABLE `m_satuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `is_aktif` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_satuan`
--

INSERT INTO `m_satuan` (`id`, `nama`, `is_aktif`) VALUES
(1, 'PCS', 1),
(2, 'BOX', 1),
(3, 'PACK', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `id_user` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `id_level_user` int(11) DEFAULT NULL,
  `id_pegawai` varchar(100) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `kode_agen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`id_user`, `username`, `password`, `id_level_user`, `id_pegawai`, `status`, `last_login`, `created_at`, `updated_at`, `kode_agen`) VALUES
('USR00001', 'dwi_admin', 'hX2fmaWl', 1, NULL, 1, '2020-06-15 18:00:52', '2019-10-05 21:34:14', '2020-06-15 04:00:52', NULL),
('USR00002', 'Atriyani', 'tb/eztXbs82swqaf', 2, NULL, 1, '2020-05-30 21:32:09', '2020-04-14 10:43:04', '2020-05-30 07:32:09', 'H6J33W2'),
('USR00003', 'A_D._Setyoko', 'v73V2OTYvMCxz9LZyoWEo5k=', 2, NULL, 1, '2020-04-16 16:58:46', '2020-04-14 11:22:50', '2020-04-16 02:58:46', 'J6J43J1'),
('USR00004', 'Nyuwardi', 'uLDa2OXihpeB', 2, NULL, 1, '2020-04-27 14:45:59', '2020-04-14 11:47:37', '2020-04-27 00:45:59', 'X6Z43A3'),
('USR00005', 'Lucia Sri Wahyuni', 'zbrT3tHar9G8wp+Z', 2, NULL, 1, '2020-04-29 05:43:08', '2020-04-14 13:58:43', '2020-04-28 15:43:08', 'B6M79B1'),
('USR00006', 'jhardini', 'v6zlxuLQx8CAmQ==', 2, NULL, 1, '2020-04-15 06:03:29', '2020-04-15 02:24:16', '2020-04-14 23:03:29', 'J7B61J0'),
('USR00007', 'Admin', 'ta/Zzt6ggJJ6mq8=', 2, NULL, 1, '2020-06-04 19:41:32', '2020-04-15 04:07:02', '2020-06-04 05:41:32', 'F5M57Z8'),
('USR00008', 'Fendi10', 'xLWdnqCn', 2, NULL, 1, '2020-04-16 14:46:29', '2020-04-15 13:05:51', '2020-04-16 14:50:19', 'C8H43V8'),
('USR00009', 'HESTIWORO SUHARDJONO', 'hX2cmKGf', 2, NULL, 1, '2020-04-16 17:33:57', '2020-04-16 17:15:50', '2020-04-16 03:33:57', 'F2Q36F3'),
('USR00010', 'Teguh', 'trDenqnkr82vmqe7tA==', 2, NULL, 1, '2020-05-30 21:10:20', '2020-05-29 11:41:13', '2020-05-30 07:10:20', 'N3N70R6'),
('USR00011', 'Wiwied', 'tb3gzdHms828xtyblg==', 2, NULL, 1, '2020-06-13 18:53:43', '2020-06-10 17:43:03', '2020-06-13 04:53:43', 'A4J28Z4'),
('USR00012', 'Sriyanti ', 'vb3Nx9vahpGAkw==', 2, NULL, 1, '2020-06-12 17:44:58', '2020-06-12 17:44:58', '2020-06-12 03:44:58', 'A4J38C2'),
('USR00013', 'Maikem', 'wLTYzuCfhw==', 2, NULL, 0, '2020-06-13 16:35:54', '2020-06-13 16:35:54', '2020-06-13 02:38:42', 'E1D32E8');

-- --------------------------------------------------------

--
-- Table structure for table `m_user_detail`
--

CREATE TABLE `m_user_detail` (
  `id_user_detail` int(11) NOT NULL,
  `id_user` varchar(8) NOT NULL,
  `nama_lengkap_user` varchar(100) DEFAULT 'Akun Baru',
  `alamat_user` text,
  `tanggal_lahir_user` date DEFAULT '1970-01-01',
  `jenis_kelamin_user` varchar(10) DEFAULT NULL,
  `no_telp_user` varchar(15) NOT NULL,
  `gambar_user` varchar(250) NOT NULL DEFAULT 'user_default.png',
  `thumb_gambar_user` varchar(100) NOT NULL DEFAULT 'user_default_thumb.png',
  `email` varchar(255) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `rekening` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `m_user_detail`
--

INSERT INTO `m_user_detail` (`id_user_detail`, `id_user`, `nama_lengkap_user`, `alamat_user`, `tanggal_lahir_user`, `jenis_kelamin_user`, `no_telp_user`, `gambar_user`, `thumb_gambar_user`, `email`, `bank`, `rekening`) VALUES
(1, 'USR00001', 'Administrator Aplikasi', 'Jl. Harapan Nusa Dan Bangsa', '1986-11-08', 'L', '0868574548454', 'user_default.png', 'user_default_thumb.png', NULL, NULL, NULL),
(21, 'USR00002', 'Atrie', NULL, '1970-01-01', NULL, '085745628888', 'user_default.png', 'user_default_thumb.png', 'atriyani802@gmail.com', 'MANDIRI', '1370016937647'),
(22, 'USR00003', 'Antonius Dwi', NULL, '1970-01-01', NULL, '087794524152', 'antonius-1586863810.jpg', 'user_default_thumb.png', 'bill_setyoko@yahoo.com', 'BRI', '309301026648531'),
(23, 'USR00004', 'Nyuwardi', NULL, '1970-01-01', NULL, '085139089366', 'user_default.png', 'user_default_thumb.png', 'sinyonyuwardi@gmail.com', 'BNI', '0187475153'),
(24, 'USR00005', 'Lucia', NULL, '1970-01-01', NULL, '082136944194', 'user_default.png', 'user_default_thumb.png', 'lusyyogyakarta@gmail.com', 'MANDIRI', '137-00-1222834-8'),
(25, 'USR00006', 'Hardini', NULL, '1970-01-01', NULL, '081917390999', 'user_default.png', 'user_default_thumb.png', 'jhardini@yahoo.co.id', 'BNI', '0306699251'),
(26, 'USR00007', 'Administrasi', NULL, '1970-01-01', NULL, '081234567892', 'user_default.png', 'user_default_thumb.png', 'siswa.admin@gmail.com', 'BCA', '6789987765'),
(27, 'USR00008', 'Fendi', NULL, '1970-01-01', NULL, '08115759014', 'user_default.png', 'user_default_thumb.png', 'pointtravel88@yahoo.com', 'BCA', '1710682077'),
(28, 'USR00009', 'HESTIWORO', NULL, '1970-01-01', NULL, '08129293771', 'user_default.png', 'user_default_thumb.png', 'hestisuhardjono@gmail.com', 'BCA', '7060051571'),
(29, 'USR00010', 'Teguh Santoso', NULL, '1970-01-01', NULL, '081331650200', 'teguh-santoso-1590727588.jpg', 'user_default_thumb.png', 'ts313109@gmail.com', 'BCA', '3850498317'),
(30, 'USR00011', 'Widiyadari Artha', NULL, '1970-01-01', NULL, '087762852221', 'user_default.png', 'user_default_thumb.png', 'arthasset1945@gmail.com', 'BCA', '8270493883'),
(31, 'USR00012', 'Sriyanti', NULL, '1970-01-01', NULL, '082146275431', 'user_default.png', 'user_default_thumb.png', 'yantidzick@gmail.com', 'MANDIRI', '1440016203355'),
(32, 'USR00013', 'Maikem', NULL, '1970-01-01', NULL, '082179999034', 'user_default.png', 'user_default_thumb.png', 'maikemjkt@gmail.com', 'BCA', '4191473439');

-- --------------------------------------------------------

--
-- Table structure for table `t_checkout`
--

CREATE TABLE `t_checkout` (
  `id` varchar(50) NOT NULL,
  `id_user` varchar(10) DEFAULT NULL,
  `harga_total` double(20,2) DEFAULT NULL,
  `laba_agen_total` double(20,2) DEFAULT '0.00',
  `diskon_total` double(20,2) DEFAULT '0.00',
  `kode_ref` varchar(8) DEFAULT NULL COMMENT 'kode referensi',
  `kode_agen` varchar(255) DEFAULT NULL,
  `is_konfirm` int(1) DEFAULT '0',
  `nama_depan` varchar(255) DEFAULT NULL,
  `nama_belakang` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `status` int(1) DEFAULT '1' COMMENT '1: aktif, 0: nonaktif, 2:batal',
  `is_agen_klaim` int(1) DEFAULT '0' COMMENT '1:sudah, 0:belum diklaim',
  `is_verify_klaim` int(1) NOT NULL DEFAULT '0',
  `id_klaim_agen` varchar(50) DEFAULT NULL,
  `jenis` varchar(10) NOT NULL DEFAULT 'paket'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `t_checkout`
--

INSERT INTO `t_checkout` (`id`, `id_user`, `harga_total`, `laba_agen_total`, `diskon_total`, `kode_ref`, `kode_agen`, `is_konfirm`, `nama_depan`, `nama_belakang`, `email`, `telepon`, `bukti`, `created_at`, `updated_at`, `deleted_at`, `status`, `is_agen_klaim`, `is_verify_klaim`, `id_klaim_agen`, `jenis`) VALUES
('05d8287c-5527-4d5a-8901-bcee8540ade0', NULL, 1200000.00, 0.00, 0.00, 'jjhBC', NULL, 1, 'Sriyanti', '', 'yantidzick@gmail.com', '082146275431', 'bukti-sriyanti-1591958697.jpg', '2020-06-12 17:44:58', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('1556af6c-db15-45bd-88d4-94e5765267ad', NULL, 1200000.00, 0.00, 0.00, 'jOJ20', NULL, 1, 'Atrie', '', 'atriyani802@gmail.com', '085745628888', 'bukti-atrie-1586860984.jpg', '2020-04-14 10:43:04', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('18ab4fd8-b308-47a3-bb2f-d759cbe93e2f', NULL, 1200000.00, 0.00, 0.00, 'jOZKI', NULL, 1, 'Administrasi', '', 'siswa.admin@gmail.com', '081234567892', 'bukti-administrasi-1586923622.jpg', '2020-04-15 04:07:02', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('21cc7e9a-dc82-42dd-b8c4-791fa2236a19', NULL, 3000000.00, 0.00, 0.00, 'jjK3T', NULL, 0, 'Maikem', NULL, 'maikemjkt@gmail.com', '08082179999034', 'bukti-maikem-1591869806.png', '2020-06-11 17:03:27', NULL, NULL, 2, 0, 0, NULL, 'paket'),
('2f07c501-d673-4f4b-8931-dfdeb75501f6', NULL, 3000000.00, 550000.00, 0.00, 'jOa0S', 'F5M57Z8', 1, 'Cobaanak', NULL, 'coba.anak@gmail.com', '086789765432', 'bukti-cobaanak-1586926236.jpeg', '2020-04-15 04:50:36', NULL, NULL, 0, 0, 0, NULL, 'paket'),
('6badde52-1246-4e85-83d1-bcdb0f477081', NULL, 1200000.00, 0.00, 0.00, 'jOJeU', NULL, 1, 'Antonius', '', 'bill_setyoko@yahoo.com', '087794524152', 'bukti-antonius-1586863369.jpg', '2020-04-14 11:22:50', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('8c571ff4-6ef3-4a56-b3ef-b9bcfffb67c0', NULL, 1200000.00, 0.00, 0.00, 'jOM5L', NULL, 1, 'Lucia', '', 'lusyyogyakarta@gmail.com', '082136944194', 'bukti-lucia-1586872722.jpg', '2020-04-14 13:58:43', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('93ea373d-b85b-4495-8c75-b1394244bd26', NULL, 1200000.00, 0.00, 0.00, 'jP1Yk', NULL, 1, 'HESTIWORO', '', 'hestisuhardjono@gmail.com', '08129293771', 'bukti-hestiworo-1587032148.jpg', '2020-04-16 17:15:50', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('983255fa-65a1-4165-a1a0-d38d350c8c06', NULL, 1200000.00, 0.00, 0.00, 'jiyCF', NULL, 1, 'Widiyadari Artha', '', 'arthasset1945@gmail.com', '087762852221', 'bukti-widiyadari-artha-1591785781.jpeg', '2020-06-10 17:43:03', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('b9fb09f0-a62f-41cd-89c3-106ba5412778', NULL, 1200000.00, 0.00, 0.00, 'jOXiq', NULL, 1, 'Hardini', '', 'jhardini@yahoo.co.id', '081917390999', 'bukti-hardini-1586917455.png', '2020-04-15 02:24:16', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('cd2d6850-5d2a-4e92-b592-a15036cf17ba', NULL, 1200000.00, 0.00, 0.00, 'jeWpV', NULL, 1, 'Teguh', '', 'ts313109@gmail.com', '081331650200', 'bukti-teguh-1590727272.jpg', '2020-05-29 11:41:13', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('d215ad83-0d55-40a9-b063-f3b764b5672d', NULL, 1200000.00, 0.00, 0.00, 'jOK2T', NULL, 1, 'Nyuwardi', '', 'sinyonyuwardi@gmail.com', '085139089366', 'bukti-nyuwardi-1586864856.jpg', '2020-04-14 11:47:37', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('d320967b-8ba0-4836-b5c8-5bc404084a82', NULL, 1200000.00, 0.00, 0.00, 'jOhjj', NULL, 1, 'Fendi', '', 'pointtravel88@yahoo.com', '08115759014', 'bukti-fendi-1586955950.png', '2020-04-15 13:05:51', NULL, NULL, 0, 0, 0, NULL, 'affiliate'),
('db9f7363-7ce8-42ca-9e26-76db9b89a68d', NULL, 1200000.00, 0.00, 0.00, 'jk2Zu', NULL, 1, 'Maikem', '', 'maikemjkt@gmail.com', '082179999034', 'bukti-maikem-1592040953.png', '2020-06-13 16:35:54', NULL, NULL, 0, 0, 0, NULL, 'affiliate');

-- --------------------------------------------------------

--
-- Table structure for table `t_hak_akses`
--

CREATE TABLE `t_hak_akses` (
  `id_menu` int(11) NOT NULL,
  `id_level_user` int(11) NOT NULL,
  `add_button` int(1) DEFAULT NULL,
  `edit_button` int(1) DEFAULT NULL,
  `delete_button` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `t_hak_akses`
--

INSERT INTO `t_hak_akses` (`id_menu`, `id_level_user`, `add_button`, `edit_button`, `delete_button`) VALUES
(1, 1, 0, 0, 0),
(5, 1, 0, 0, 0),
(7, 1, 1, 1, 1),
(8, 1, 1, 1, 1),
(9, 1, 0, 0, 0),
(10, 1, 1, 1, 1),
(13, 1, 1, 1, 1),
(14, 1, 1, 1, 1),
(17, 1, 1, 1, 1),
(11, 1, 0, 0, 0),
(12, 1, 0, 0, 0),
(15, 1, 0, 0, 0),
(16, 1, 0, 0, 0),
(4, 1, 0, 0, 0),
(3, 1, 1, 1, 1),
(2, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_klaim_agen`
--

CREATE TABLE `t_klaim_agen` (
  `id` varchar(50) NOT NULL,
  `id_agen` varchar(255) DEFAULT NULL,
  `id_user_verify` varchar(255) DEFAULT NULL,
  `saldo_sebelum` double(20,2) DEFAULT '0.00' COMMENT 'uang yg sudah diklaim ke agen',
  `jumlah_klaim` double(20,2) DEFAULT '0.00' COMMENT 'jumlah uang yg akan diklem oleh agen',
  `saldo_sesudah` double(20,2) DEFAULT '0.00' COMMENT 'uang yg sudah diklaim + jumlah uang yg akan di klem',
  `datetime_klaim` datetime DEFAULT NULL,
  `datetime_verify` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `kode_klaim` varchar(255) DEFAULT NULL COMMENT 'sebagai kode refferal'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `t_klaim_verify`
--

CREATE TABLE `t_klaim_verify` (
  `id` varchar(50) NOT NULL,
  `id_klaim_agen` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `tanggal_verify` datetime NOT NULL,
  `bank` varchar(50) NOT NULL,
  `rekening` varchar(100) NOT NULL,
  `bukti` varchar(100) NOT NULL,
  `nilai_transfer` double(20,2) NOT NULL DEFAULT '0.00',
  `is_aktif` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_log_harga`
--

CREATE TABLE `t_log_harga` (
  `id` varchar(50) NOT NULL,
  `harga_satuan` double(20,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `diskon_agen` int(3) DEFAULT NULL COMMENT 'besaran potongan agen',
  `harga_diskon_agen` double(20,2) DEFAULT NULL COMMENT 'nilai potongan agen',
  `is_aktif` int(1) DEFAULT '1',
  `diskon_paket` int(3) DEFAULT NULL COMMENT 'besaran diskon',
  `harga_diskon_paket` double(20,2) DEFAULT NULL COMMENT 'nilai diskon',
  `tanggal_berlaku` timestamp NULL DEFAULT NULL,
  `jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `t_log_harga`
--

INSERT INTO `t_log_harga` (`id`, `harga_satuan`, `created_at`, `diskon_agen`, `harga_diskon_agen`, `is_aktif`, `diskon_paket`, `harga_diskon_paket`, `tanggal_berlaku`, `jenis`) VALUES
('ceda0b5a-7a02-46f1-9030-ff38c88fd157', 3000000.00, '2020-04-13 00:59:49', 18, 550000.00, 1, 0, 3000000.00, '2020-04-13 19:00:00', 'paket'),
('efefed31-2f8e-4954-98d6-03359b3d067e', 1200000.00, '2020-04-13 01:00:16', 0, 0.00, 1, 0, 1200000.00, '2020-04-13 19:00:00', 'affiliate');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_kategori`
--
ALTER TABLE `m_kategori`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_konten`
--
ALTER TABLE `m_konten`
  ADD PRIMARY KEY (`id_konten`) USING BTREE;

--
-- Indexes for table `m_level_user`
--
ALTER TABLE `m_level_user`
  ADD PRIMARY KEY (`id_level_user`) USING BTREE;

--
-- Indexes for table `m_menu`
--
ALTER TABLE `m_menu`
  ADD PRIMARY KEY (`id_menu`) USING BTREE;

--
-- Indexes for table `m_produk`
--
ALTER TABLE `m_produk`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_satuan`
--
ALTER TABLE `m_satuan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- Indexes for table `m_user_detail`
--
ALTER TABLE `m_user_detail`
  ADD PRIMARY KEY (`id_user_detail`) USING BTREE,
  ADD UNIQUE KEY `id_user` (`id_user`) USING BTREE;

--
-- Indexes for table `t_checkout`
--
ALTER TABLE `t_checkout`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `t_hak_akses`
--
ALTER TABLE `t_hak_akses`
  ADD KEY `f_level_user` (`id_level_user`) USING BTREE,
  ADD KEY `id_menu` (`id_menu`) USING BTREE;

--
-- Indexes for table `t_klaim_agen`
--
ALTER TABLE `t_klaim_agen`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `t_klaim_verify`
--
ALTER TABLE `t_klaim_verify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_log_harga`
--
ALTER TABLE `t_log_harga`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_konten`
--
ALTER TABLE `m_konten`
  MODIFY `id_konten` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_level_user`
--
ALTER TABLE `m_level_user`
  MODIFY `id_level_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_user_detail`
--
ALTER TABLE `m_user_detail`
  MODIFY `id_user_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_hak_akses`
--
ALTER TABLE `t_hak_akses`
  ADD CONSTRAINT `f_level_user` FOREIGN KEY (`id_level_user`) REFERENCES `m_level_user` (`id_level_user`),
  ADD CONSTRAINT `t_hak_akses_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `m_menu` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
