-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_motor
CREATE DATABASE IF NOT EXISTS `db_motor` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_motor`;

-- Dumping structure for table db_motor.config_menu
CREATE TABLE IF NOT EXISTS `config_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL DEFAULT '0',
  `nama_menu` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `urutan` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.config_menu: ~6 rows (approximately)
/*!40000 ALTER TABLE `config_menu` DISABLE KEYS */;
INSERT INTO `config_menu` (`id_menu`, `id_parent`, `nama_menu`, `link`, `urutan`) VALUES
	(1, 0, 'Modul & Menu', 'modul', 1),
	(2, 0, 'Level & Akses', 'akses', 2),
	(3, 1, 'Modul', 'config/modul', 1),
	(4, 1, 'Menu', 'config/menu', 2),
	(5, 2, 'Level', 'config/level', 1),
	(6, 2, 'Akses', 'config/akses', 2);
/*!40000 ALTER TABLE `config_menu` ENABLE KEYS */;

-- Dumping structure for table db_motor.identitas
CREATE TABLE IF NOT EXISTS `identitas` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `tingkat` enum('SD','SMP','SMA','SMK') NOT NULL,
  `instansi` varchar(200) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota` varchar(30) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `web` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `wa` varchar(15) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `api` varchar(200) NOT NULL,
  `yt` varchar(100) NOT NULL,
  `footer` varchar(255) NOT NULL,
  `deskripsi` varchar(700) NOT NULL,
  `keyword` varchar(200) NOT NULL,
  `about` mediumtext NOT NULL,
  `uid` varchar(32) NOT NULL,
  `pa4` varchar(200) NOT NULL,
  `la4` varchar(200) NOT NULL,
  `lf4` varchar(200) NOT NULL,
  `nomor_surat` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.identitas: ~1 rows (approximately)
/*!40000 ALTER TABLE `identitas` DISABLE KEYS */;
INSERT INTO `identitas` (`id`, `kode`, `tingkat`, `instansi`, `nama`, `alamat`, `kota`, `telp`, `web`, `email`, `logo`, `wa`, `fb`, `tw`, `api`, `yt`, `footer`, `deskripsi`, `keyword`, `about`, `uid`, `pa4`, `la4`, `lf4`, `nomor_surat`) VALUES
	(1, '10260901', 'SMP', 'KOPERASI ', 'KOPERASI PUMASARI', 'Kota Pematangsiantar, <br> Sumatera Utara', 'Batu Bara', '-', '-', 'admin@gmail.com', 'koperasi.png', '', 'https://www.facebook.com/-', 'https://twitter.com/-', 'https://disdik.batubarakab.go.id/', 'https://www.youtube.com/-', 'copyright @ 2021 - | -', '', '', '<p style="text-align:justify"><span style="color:#000000"><span style="font-size:14px"><strong>SIMPEL BOS</strong>&nbsp;(Sistem Informasi Pelaporan Dana BOS) adalah aplikasi&nbsp; berbasis web yang dirancang untuk membantu sekolah dalam menyusun dan mengelola laporan keuangan tingkat sekolah.&nbsp; Aplikasi ini&nbsp; dikembangkan atas salah satu program Dinas Pendidikan Kabupaten Labuhanbatu Selatan. Aplikasi ini bermanfaat untuk memudahkan sekolah dalam penyusunan format laporan keuangan yang ada dalam Petunjuk Pelaksanaan program BOS. Salah satu hasil akhir dari aplikasi ini adalah format BOS yang selanjutnya digunakan untuk diisikan di Laporan Penggunaan Dana BOS secara online. Aplikasi ini disertai dengan pedoman penggunaannya sehingga setiap sekolah dapat belajar mandiri.</span></span></p>\r\n\r\n<p style="text-align:justify"><span style="color:#000000"><span style="font-size:14px">Untuk melihat Peraturan Terbaru klik <strong><a href="http://bos-labusel.indosistem.com/web/peraturan">Disini</a>.</strong></span></span></p>\r\n\r\n<p style="text-align:justify"><span style="color:#000000"><span style="font-size:14px">Untuk melihat Berita Terbaru klik <a href="http://bos-labusel.indosistem.com/web/berita"><strong>Disini.</strong></a></span></span></p>\r\n\r\n<p style="text-align:justify">&nbsp;</p>\r\n', 'obATxEkk9b9RVAqJHV2uA1mAuAdaFTYN', '', '', '', '');
/*!40000 ALTER TABLE `identitas` ENABLE KEYS */;

-- Dumping structure for table db_motor.level
CREATE TABLE IF NOT EXISTS `level` (
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `nama_level` varchar(100) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_level`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.level: ~2 rows (approximately)
/*!40000 ALTER TABLE `level` DISABLE KEYS */;
INSERT INTO `level` (`id_level`, `nama_level`, `created_date`) VALUES
	(1, 'Super Administrator', '2020-03-20 11:30:13'),
	(2, 'Admin', '2020-03-20 12:27:35');
/*!40000 ALTER TABLE `level` ENABLE KEYS */;

-- Dumping structure for table db_motor.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_modul` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL DEFAULT '0',
  `nama_menu` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `urutan` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.menu: ~55 rows (approximately)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id_menu`, `id_modul`, `id_parent`, `nama_menu`, `link`, `urutan`) VALUES
	(3, 3, 0, 'Kode Aplikasi', 'referensi/kode', 1),
	(4, 4, 0, 'Identitas Website', 'setting/identitas', 1),
	(6, 5, 0, 'Berita', 'website/berita', 1),
	(7, 3, 0, 'Kategori Berita', 'referensi/kategoriberita', 3),
	(8, 5, 0, 'Halaman', 'website/halaman', 2),
	(9, 5, 0, 'Slider', 'website/slider', 3),
	(10, 5, 0, 'Gallery', 'website/gallery', 4),
	(11, 5, 10, 'Foto', 'website/albumfoto', 1),
	(12, 5, 10, 'Video', 'website/albumvideo', 2),
	(13, 5, 0, 'Agenda', 'website/agenda', 5),
	(14, 5, 0, 'Pengumuman', 'website/pengumuman', 6),
	(15, 5, 0, 'Download', 'website/download', 7),
	(16, 5, 0, 'Kerjasama', 'website/kerjasama', 8),
	(17, 5, 0, 'Prestasi', 'website/prestasi', 9),
	(18, 5, 0, 'Pesan Pengunjung', 'website/pesan', 10),
	(20, 4, 0, 'User', 'setting/user', 3),
	(21, 6, 0, 'Akademik Siswa', 'layanan/akadsiswa', 1),
	(22, 6, 0, 'Akademik Guru & Pegawai', 'layanan/akadguru', 2),
	(23, 6, 21, 'Surat Keterangan Siswa', 'layanan/keterangansiswa', 1),
	(25, 6, 21, 'Surat Rekomendasi Siswa', 'layanan/rekomendasisiswa', 3),
	(27, 6, 21, 'Surat Keterangan Berkelakuan Baik', 'layanan/skbb', 2),
	(32, 6, 22, 'Surat Tugas', 'layanan/surattugas', 1),
	(33, 6, 22, 'Surat Keterangan Sebagai Guru', 'layanan/keteranganguru', 2),
	(34, 6, 22, 'Usulan Kenaikan Gaji Berkala', 'layanan/gajiberkala', 3),
	(35, 5, 0, 'Fasilitas', 'website/fasilitas', 11),
	(36, 7, 0, 'Daftar Permintaan', 'permintaan/daftar', 1),
	(37, 7, 0, 'Histori Pengiriman Data', 'permintaan/histori', 2),
	(38, 8, 0, 'Profil', 'informasidinas/profil', 1),
	(39, 8, 0, 'Berita', 'informasidinas/berita', 2),
	(40, 8, 0, 'Pengumuman', 'informasidinas/pengumuman', 3),
	(41, 8, 0, 'Download', 'informasidinas/download', 4),
	(42, 9, 0, 'Sekolah', 'surat/sekolah', 1),
	(43, 9, 0, 'Dinas Pendidikan', 'surat/dinas', 2),
	(44, 9, 42, 'Surat Masuk', 'surat/suratmasuk', 1),
	(45, 9, 42, 'Surat Keluar', 'surat/suratkeluar', 2),
	(46, 9, 43, 'Surat Masuk', 'surat/dinasmasuk', 1),
	(47, 9, 43, 'Surat Keluar', 'surat/dinaskeluar', 2),
	(49, 6, 0, 'Layanan Eksternal', 'layanan/eksternal', 3),
	(50, 6, 0, 'Buku Tamu', 'layanan/bukutamu', 4),
	(51, 6, 0, 'Penandatangan', 'layanan/penandatangan', 5),
	(52, 6, 49, 'Keterangan Penelitian', 'layanan/keteranganpenelitian', 1),
	(53, 6, 49, 'Izin Penelitian', 'layanan/izinpenelitian', 2),
	(54, 6, 49, 'Penyerahan Skripsi', 'layanan/penyerahanskripsi', 3),
	(55, 10, 0, 'Tahun Penerimaan', 'ppdb/tahun', 1),
	(56, 10, 0, 'Jurusan', 'ppdb/jurusan', 2),
	(57, 10, 0, 'Data Pendaftar', 'ppdb/pendaftar', 3),
	(58, 10, 0, 'Data Siswa Lulus', 'ppdb/lulus', 4),
	(59, 10, 0, 'Registrasi Siswa Baru', 'ppdb/registrasi', 5),
	(60, 11, 0, 'Data Anggota', 'anggota/data', 1),
	(61, 12, 0, 'Formulir Pinjaman', 'formulir/data', 1),
	(62, 13, 0, 'Pinjam', 'transaksi/pinjamtambah', 1),
	(63, 13, 0, 'Angsuran', 'transaksi/angsuran', 2),
	(64, 14, 0, 'Pinjaman', 'laporan/pinjaman', 1),
	(65, 14, 0, 'Angsuran', 'laporan/angsuran', 2);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Dumping structure for table db_motor.menu_akses
CREATE TABLE IF NOT EXISTS `menu_akses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_level` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `baca` tinyint(1) NOT NULL DEFAULT '0',
  `tulis` tinyint(1) NOT NULL DEFAULT '0',
  `ubah` tinyint(1) NOT NULL DEFAULT '0',
  `hapus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `level_menu` (`id_level`,`id_menu`) USING BTREE,
  KEY `fk_menu_akses` (`id_menu`) USING BTREE,
  CONSTRAINT `fk_menu_akses` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.menu_akses: ~106 rows (approximately)
/*!40000 ALTER TABLE `menu_akses` DISABLE KEYS */;
INSERT INTO `menu_akses` (`id`, `id_level`, `id_menu`, `baca`, `tulis`, `ubah`, `hapus`) VALUES
	(5, 1, 3, 1, 1, 1, 1),
	(6, 2, 3, 0, 0, 0, 0),
	(7, 1, 4, 1, 1, 1, 1),
	(8, 2, 4, 0, 0, 0, 0),
	(11, 1, 6, 1, 1, 1, 1),
	(12, 2, 6, 1, 1, 1, 1),
	(13, 1, 7, 1, 1, 1, 1),
	(14, 2, 7, 0, 0, 0, 0),
	(15, 1, 8, 1, 1, 1, 1),
	(16, 2, 8, 0, 0, 0, 0),
	(17, 1, 9, 1, 1, 1, 1),
	(18, 2, 9, 0, 0, 0, 0),
	(19, 1, 10, 1, 1, 1, 1),
	(20, 2, 10, 0, 0, 0, 0),
	(21, 1, 11, 1, 1, 1, 1),
	(22, 2, 11, 0, 0, 0, 0),
	(23, 1, 12, 1, 1, 1, 1),
	(24, 2, 12, 0, 0, 0, 0),
	(25, 1, 13, 1, 1, 1, 1),
	(26, 2, 13, 0, 0, 0, 0),
	(27, 1, 14, 1, 1, 1, 1),
	(28, 2, 14, 0, 0, 0, 0),
	(29, 1, 15, 1, 1, 1, 1),
	(30, 2, 15, 0, 0, 0, 0),
	(31, 1, 16, 1, 1, 1, 1),
	(32, 2, 16, 0, 0, 0, 0),
	(33, 1, 17, 1, 1, 1, 1),
	(34, 2, 17, 0, 0, 0, 0),
	(35, 1, 18, 1, 1, 1, 1),
	(36, 2, 18, 0, 0, 0, 0),
	(39, 1, 20, 1, 1, 1, 1),
	(40, 2, 20, 0, 0, 0, 0),
	(41, 1, 21, 1, 1, 1, 1),
	(42, 2, 21, 0, 0, 0, 0),
	(43, 1, 22, 1, 1, 1, 1),
	(44, 2, 22, 0, 0, 0, 0),
	(45, 1, 23, 1, 1, 1, 1),
	(46, 2, 23, 0, 0, 0, 0),
	(49, 1, 25, 1, 1, 1, 1),
	(50, 2, 25, 0, 0, 0, 0),
	(53, 1, 27, 1, 1, 1, 1),
	(54, 2, 27, 0, 0, 0, 0),
	(63, 1, 32, 1, 1, 1, 1),
	(64, 2, 32, 0, 0, 0, 0),
	(65, 1, 33, 1, 1, 1, 1),
	(66, 2, 33, 0, 0, 0, 0),
	(67, 1, 34, 1, 1, 1, 1),
	(68, 2, 34, 0, 0, 0, 0),
	(69, 1, 35, 1, 1, 1, 1),
	(70, 2, 35, 0, 0, 0, 0),
	(71, 1, 36, 1, 1, 1, 1),
	(72, 2, 36, 0, 0, 0, 0),
	(73, 1, 37, 0, 0, 0, 0),
	(74, 2, 37, 0, 0, 0, 0),
	(75, 1, 38, 1, 1, 1, 1),
	(76, 2, 38, 0, 0, 0, 0),
	(77, 1, 39, 1, 1, 1, 1),
	(78, 2, 39, 0, 0, 0, 0),
	(79, 1, 40, 1, 1, 1, 1),
	(80, 2, 40, 0, 0, 0, 0),
	(81, 1, 41, 1, 1, 1, 1),
	(82, 2, 41, 0, 0, 0, 0),
	(83, 1, 42, 1, 1, 1, 1),
	(84, 2, 42, 0, 0, 0, 0),
	(85, 1, 43, 1, 1, 1, 1),
	(86, 2, 43, 0, 0, 0, 0),
	(87, 1, 44, 1, 1, 1, 1),
	(88, 2, 44, 0, 0, 0, 0),
	(89, 1, 45, 1, 1, 1, 1),
	(90, 2, 45, 0, 0, 0, 0),
	(91, 1, 46, 1, 1, 1, 1),
	(92, 2, 46, 0, 0, 0, 0),
	(93, 1, 47, 1, 1, 1, 1),
	(94, 2, 47, 0, 0, 0, 0),
	(97, 1, 49, 1, 1, 1, 1),
	(98, 2, 49, 0, 0, 0, 0),
	(99, 1, 50, 1, 1, 1, 1),
	(100, 2, 50, 0, 0, 0, 0),
	(101, 1, 51, 1, 1, 1, 1),
	(102, 2, 51, 0, 0, 0, 0),
	(103, 1, 52, 1, 1, 1, 1),
	(104, 2, 52, 0, 0, 0, 0),
	(105, 1, 53, 1, 1, 1, 1),
	(106, 2, 53, 0, 0, 0, 0),
	(107, 1, 54, 1, 1, 1, 1),
	(108, 2, 54, 0, 0, 0, 0),
	(109, 1, 55, 1, 1, 1, 1),
	(110, 2, 55, 0, 0, 0, 0),
	(111, 1, 56, 1, 1, 1, 1),
	(112, 2, 56, 0, 0, 0, 0),
	(113, 1, 57, 1, 1, 1, 1),
	(114, 2, 57, 0, 0, 0, 0),
	(115, 1, 58, 1, 1, 1, 1),
	(116, 2, 58, 0, 0, 0, 0),
	(117, 1, 59, 1, 1, 1, 1),
	(118, 2, 59, 0, 0, 0, 0),
	(119, 1, 60, 1, 1, 1, 1),
	(120, 2, 60, 1, 1, 1, 1),
	(121, 1, 61, 1, 1, 1, 1),
	(122, 2, 61, 0, 0, 0, 0),
	(123, 1, 62, 1, 1, 1, 1),
	(124, 2, 62, 1, 1, 1, 1),
	(125, 1, 63, 1, 1, 1, 1),
	(126, 2, 63, 1, 1, 1, 1),
	(127, 1, 64, 0, 0, 0, 0),
	(128, 2, 64, 1, 1, 1, 1),
	(129, 1, 65, 0, 0, 0, 0),
	(130, 2, 65, 1, 1, 1, 1);
/*!40000 ALTER TABLE `menu_akses` ENABLE KEYS */;

-- Dumping structure for table db_motor.modul
CREATE TABLE IF NOT EXISTS `modul` (
  `id_modul` int(11) NOT NULL AUTO_INCREMENT,
  `nama_modul` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `urutan` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `modify_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_modul`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.modul: ~6 rows (approximately)
/*!40000 ALTER TABLE `modul` DISABLE KEYS */;
INSERT INTO `modul` (`id_modul`, `nama_modul`, `controller`, `urutan`, `icon`, `created_at`, `modify_at`) VALUES
	(1, 'Dashboard', 'dashboard', 1, 'nav-icon fas fa-tachometer-alt', '2020-03-21 09:39:36', '2020-03-21 09:39:36'),
	(3, 'Referensi', 'referensi', 19, 'book', '2020-03-21 10:04:44', '2020-03-21 10:04:44'),
	(4, 'Setting', 'setting', 20, 'cogs', '2020-03-21 10:05:01', '2020-03-21 10:05:01'),
	(11, 'Anggota', 'anggota', 1, 'nav-icon fas fa-solid fa-users', '2021-10-27 12:07:44', '2021-10-27 12:07:44'),
	(12, 'Formulir', 'formulir', 3, 'nav-icon fa fa-book', '2021-10-27 18:18:00', '2021-10-27 18:18:00'),
	(13, 'Tansaksi', 'transaksi', 2, 'nav-icon fa fa-nav-icon fa fa-book', '2021-10-30 10:41:35', '2021-10-30 10:41:35'),
	(14, 'Laporan', 'laporan', 6, 'nav-icon fa fa-nav-icon fa fa-book', '2021-11-03 14:10:36', '2021-11-03 14:10:36');
/*!40000 ALTER TABLE `modul` ENABLE KEYS */;

-- Dumping structure for table db_motor.modul_akses
CREATE TABLE IF NOT EXISTS `modul_akses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_modul` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `baca` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `level` (`id_modul`,`id_level`) USING BTREE,
  CONSTRAINT `fk_modul_akses` FOREIGN KEY (`id_modul`) REFERENCES `modul` (`id_modul`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.modul_akses: ~10 rows (approximately)
/*!40000 ALTER TABLE `modul_akses` DISABLE KEYS */;
INSERT INTO `modul_akses` (`id`, `id_modul`, `id_level`, `baca`) VALUES
	(1, 1, 1, 1),
	(2, 1, 2, 1),
	(5, 3, 1, 1),
	(6, 3, 2, 0),
	(7, 4, 1, 1),
	(8, 4, 2, 0),
	(21, 11, 1, 1),
	(22, 11, 2, 1),
	(23, 12, 1, 0),
	(24, 12, 2, 0),
	(25, 13, 1, 1),
	(26, 13, 2, 1),
	(27, 14, 1, 0),
	(28, 14, 2, 1);
/*!40000 ALTER TABLE `modul_akses` ENABLE KEYS */;

-- Dumping structure for table db_motor.tbrefa
CREATE TABLE IF NOT EXISTS `tbrefa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referensi` varchar(30) DEFAULT NULL,
  `idxref` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `k1_tbrefa_ref` (`referensi`) USING BTREE,
  UNIQUE KEY `idxref` (`idxref`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.tbrefa: ~6 rows (approximately)
/*!40000 ALTER TABLE `tbrefa` DISABLE KEYS */;
INSERT INTO `tbrefa` (`id`, `referensi`, `idxref`) VALUES
	(1, 'Jenjang Pendidikan', 'PENDIDIKAN'),
	(2, 'Jenis Kelamin', 'KELAMIN'),
	(3, 'Agama', 'AGAMA'),
	(4, 'Golongan / Pangkat', 'GOL'),
	(5, 'Status Guru dan Pegawai', 'STSPEG'),
	(6, 'Pekerjaan', 'PEKERJAAN'),
	(7, 'Tenor  Angsuran', 'TENOR');
/*!40000 ALTER TABLE `tbrefa` ENABLE KEYS */;

-- Dumping structure for table db_motor.tbrefb
CREATE TABLE IF NOT EXISTS `tbrefb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idxref` varchar(20) DEFAULT NULL,
  `kderef` varchar(5) DEFAULT NULL,
  `nmaref1` varchar(50) DEFAULT NULL,
  `nmaref2` varchar(50) DEFAULT NULL,
  `nmaref3` varchar(50) DEFAULT NULL,
  `kdedikti` varchar(50) DEFAULT NULL,
  `stsrek` enum('Aktif','Tidak') DEFAULT 'Aktif',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `k1_tbrefb_idxref` (`idxref`,`kderef`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.tbrefb: ~45 rows (approximately)
/*!40000 ALTER TABLE `tbrefb` DISABLE KEYS */;
INSERT INTO `tbrefb` (`id`, `idxref`, `kderef`, `nmaref1`, `nmaref2`, `nmaref3`, `kdedikti`, `stsrek`) VALUES
	(1, 'PENDIDIKAN', 'S3', 'Doktoral', '', '', '', 'Aktif'),
	(2, 'PENDIDIKAN', 'S2', 'Magister', '', '', '', 'Aktif'),
	(3, 'PENDIDIKAN', 'S1', 'Sarjana', '', '', '', 'Aktif'),
	(4, 'PENDIDIKAN', 'D4', 'Diploma IV', '', '', '', 'Aktif'),
	(5, 'PENDIDIKAN', 'D3', 'Diploma 3', '', '', '', 'Aktif'),
	(6, 'PENDIDIKAN', 'D2', 'Diploma II', '', '', '', 'Aktif'),
	(7, 'PENDIDIKAN', 'D1', 'Diploma 1', '', '', '', 'Aktif'),
	(8, 'PENDIDIKAN', 'SPG', 'SPG', '', '', '', 'Aktif'),
	(9, 'PENDIDIKAN', 'SMA', 'SMA Sederajat', '', '', '', 'Aktif'),
	(10, 'PENDIDIKAN', 'SMP', 'SMP Sederajat', '', '', '', 'Aktif'),
	(11, 'PENDIDIKAN', 'SD', 'SD Sederajat', '', '', '', 'Aktif'),
	(12, 'KELAMIN', 'L', 'Laki-laki', '', '', '', 'Aktif'),
	(13, 'KELAMIN', 'P', 'Perempuan', '', '', '', 'Aktif'),
	(14, 'AGAMA', 'I', 'Islam', '', '', '', 'Aktif'),
	(15, 'AGAMA', 'K', 'Katholik', '', '', '', 'Aktif'),
	(16, 'AGAMA', 'P', 'Kristen', '', '', '', 'Aktif'),
	(17, 'AGAMA', 'H', 'Hindu', '', '', '', 'Aktif'),
	(18, 'AGAMA', 'B', 'Budha', '', '', '', 'Aktif'),
	(19, 'AGAMA', 'C', 'Konghuchu', '', '', '', 'Aktif'),
	(20, 'GOL', '4E', 'IV/e', 'Pembina Utama', '', '', 'Aktif'),
	(21, 'GOL', '4D', 'IV/d', 'Pembina Utama Madya', '', '', 'Aktif'),
	(22, 'GOL', '4C', 'IV/c', 'Pembina Utama Muda', '', '', 'Aktif'),
	(23, 'GOL', '4B', 'IV/b', 'Pembina Tk. 1', '', '', 'Aktif'),
	(24, 'GOL', '4A', 'IV/a', 'Pembina', '', '', 'Aktif'),
	(25, 'GOL', '3D', 'III/d', 'Penata Tk. 1', '', '', 'Aktif'),
	(26, 'GOL', '3C', 'III/c', 'Penata', '', '', 'Aktif'),
	(27, 'GOL', '3B', 'III/b', 'Penata Muda Tk. 1', '', '', 'Aktif'),
	(28, 'GOL', '3A', 'III/a', 'Penata Muda', '', '', 'Aktif'),
	(29, 'GOL', '2D', 'II/d', 'Pengatur Tk. 1', '', '', 'Aktif'),
	(30, 'GOL', '2C', 'II/c', 'Pengatur', '', '', 'Aktif'),
	(31, 'GOL', '2B', 'II/b', 'Pengatur Muda Tk. 1', '', '', 'Aktif'),
	(32, 'GOL', '2A', 'II/a', 'Pengatur Muda', '', '', 'Aktif'),
	(33, 'GOL', '1D', 'I/d', 'Juru Tk. 1', '', '', 'Aktif'),
	(34, 'GOL', '1C', 'I/c', 'Juru', '', '', 'Aktif'),
	(35, 'GOL', '1B', 'I/b', 'Juru Muda Tk.1', '', '', 'Aktif'),
	(36, 'GOL', '1A', 'I/a', 'Juru Muda', '', '', 'Aktif'),
	(37, 'GOL', 'CPNS', 'CPNS', '', '', '', 'Aktif'),
	(38, 'GOL', '0', '-', '', '', '', 'Aktif'),
	(39, 'STSPEG', 'A', 'PNS', '', '', '', 'Aktif'),
	(40, 'STSPEG', 'B', 'Honor Daerah', '', '', '', 'Aktif'),
	(41, 'STSPEG', 'C', 'Honor Sekolah', '', '', '', 'Aktif'),
	(42, 'PEKERJAAN', 'A', 'PNS', '', '', '', 'Aktif'),
	(43, 'PEKERJAAN', 'B', 'TNI/ POLRI', '', '', '', 'Aktif'),
	(44, 'PEKERJAAN', 'C', 'BUMN', '', '', '', 'Aktif'),
	(45, 'PEKERJAAN', 'D', 'Nelayan', '', '', '', 'Aktif'),
	(46, 'TENOR', '6', '6 Bulan', '', '', '', 'Aktif'),
	(47, 'TENOR', '12', '12 Bulan (1 Tahun)', '', '', '', 'Aktif'),
	(48, 'TENOR', '18', '18 Bulan', '', '', '', 'Aktif'),
	(49, 'TENOR', '24', '24 Bulan (2 Tahun)', '', '', '', 'Aktif'),
	(50, 'TENOR', '36', '36 Bulan', '', '', '', 'Aktif'),
	(51, 'TENOR', '48', '48 Bulan (3 Tahun)', '', '', '', 'Aktif');
/*!40000 ALTER TABLE `tbrefb` ENABLE KEYS */;

-- Dumping structure for table db_motor.tb_anggota
CREATE TABLE IF NOT EXISTS `tb_anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `no_anggota` int(11) NOT NULL DEFAULT '0',
  `nama_anggota` varchar(255) NOT NULL DEFAULT '0',
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(225) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` varchar(225) DEFAULT NULL,
  `pekerjaan` varchar(225) DEFAULT NULL,
  `agama` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telp` varchar(13) DEFAULT NULL,
  `no_identitas` int(11) DEFAULT NULL,
  `tgl_daftar` date DEFAULT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table db_motor.tb_anggota: ~2 rows (approximately)
/*!40000 ALTER TABLE `tb_anggota` DISABLE KEYS */;
INSERT INTO `tb_anggota` (`id_anggota`, `no_anggota`, `nama_anggota`, `jenis_kelamin`, `tempat_lahir`, `tgl_lahir`, `alamat`, `pekerjaan`, `agama`, `email`, `telp`, `no_identitas`, `tgl_daftar`) VALUES
	(2, 123156154, 'Ida Samosir', 'Perempuan', 'Samosir', '2021-01-01', 'JL. BERINGIN - TANJUNG GADING, PERK. SIPAREPARE', 'Programmer', 'K', 'idasamosir@gmail.com', '08132164578', 121315468, '2021-01-01'),
	(3, 127721250, 'Patar Chims', 'Laki-laki', 'Pematangsiantar', '2021-11-01', 'JL. BERINGIN - TANJUNG GADING, PERK. SIPAREPARE', 'Programmer', 'K', 'patarchims@gmail.com', '0811121654', 813165, '2021-11-01');
/*!40000 ALTER TABLE `tb_anggota` ENABLE KEYS */;

-- Dumping structure for table db_motor.tb_angsuran
CREATE TABLE IF NOT EXISTS `tb_angsuran` (
  `id_angsuran` int(11) NOT NULL AUTO_INCREMENT,
  `no_pinjaman` varchar(50) DEFAULT NULL,
  `no_angsuran` varchar(50) DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `denda` int(11) DEFAULT NULL,
  `angsuran_ke` int(11) DEFAULT NULL,
  `keterangan` varchar(225) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jlh_bayar` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_angsuran`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table db_motor.tb_angsuran: ~6 rows (approximately)
/*!40000 ALTER TABLE `tb_angsuran` DISABLE KEYS */;
INSERT INTO `tb_angsuran` (`id_angsuran`, `no_pinjaman`, `no_angsuran`, `id_anggota`, `denda`, `angsuran_ke`, `keterangan`, `tanggal`, `jlh_bayar`) VALUES
	(1, 'P-20211102193133', 'AG- 20211103130942', 2, 1667, 1, '', '2021-11-03', 168334),
	(2, 'P-20211102193133', 'AG- 20211103131616', 2, 1667, 2, '', '2021-11-03', 168334),
	(3, 'P-20211102193133', 'AG- 20211103131930', 2, 1667, 3, '', '2021-11-03', 168334),
	(4, 'P-20211102193133', 'AG- 20211103132034', 2, 1667, 4, '', '2021-11-03', 168334),
	(5, 'P-20211102193133', 'AG- 20211103132116', 2, 1667, 5, '', '2021-11-03', 168334),
	(6, 'P-20211102193133', 'AG- 20211103134551', 2, 1667, 6, '', '2021-11-03', 168334);
/*!40000 ALTER TABLE `tb_angsuran` ENABLE KEYS */;

-- Dumping structure for table db_motor.tb_formulir_pp
CREATE TABLE IF NOT EXISTS `tb_formulir_pp` (
  `id_fpp` int(11) NOT NULL AUTO_INCREMENT,
  `no_fpp` int(11) DEFAULT '0',
  `tgl_permohonan` date DEFAULT NULL,
  `jlh_permohonan` int(11) DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_fpp`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_motor.tb_formulir_pp: ~2 rows (approximately)
/*!40000 ALTER TABLE `tb_formulir_pp` DISABLE KEYS */;
INSERT INTO `tb_formulir_pp` (`id_fpp`, `no_fpp`, `tgl_permohonan`, `jlh_permohonan`, `id_anggota`) VALUES
	(5, 121212, '2021-01-01', 2700000, 2);
/*!40000 ALTER TABLE `tb_formulir_pp` ENABLE KEYS */;

-- Dumping structure for table db_motor.tb_pinjaman
CREATE TABLE IF NOT EXISTS `tb_pinjaman` (
  `id_pinjaman` int(11) NOT NULL AUTO_INCREMENT,
  `id_anggota` int(11) NOT NULL,
  `no_pinjaman` varchar(100) DEFAULT NULL,
  `jlh_pinjam` int(11) NOT NULL DEFAULT '0',
  `bunga` int(11) NOT NULL DEFAULT '0',
  `tenor` int(11) NOT NULL DEFAULT '0',
  `administrasi` int(11) NOT NULL DEFAULT '0',
  `keterangan` varchar(255) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `status` enum('Open','Lunas') DEFAULT NULL,
  `angsuran` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `sisa_tenor` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pinjaman`),
  UNIQUE KEY `no_pinjaman` (`no_pinjaman`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table db_motor.tb_pinjaman: ~2 rows (approximately)
/*!40000 ALTER TABLE `tb_pinjaman` DISABLE KEYS */;
INSERT INTO `tb_pinjaman` (`id_pinjaman`, `id_anggota`, `no_pinjaman`, `jlh_pinjam`, `bunga`, `tenor`, `administrasi`, `keterangan`, `tgl_pinjam`, `status`, `angsuran`, `total`, `sisa_tenor`) VALUES
	(32, 2, 'P-20211102193133', 20000000, 10, 12, 20000, 'OK', '2021-11-02', 'Open', 166667, 2000000, 6),
	(33, 3, 'P-20211103114233', 15000000, 10, 12, 15000, 'OK', '2022-11-04', 'Open', 125000, 1500000, 0);
/*!40000 ALTER TABLE `tb_pinjaman` ENABLE KEYS */;

-- Dumping structure for table db_motor.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `token` varchar(64) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `hp` varchar(15) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `level` int(11) NOT NULL,
  `login_terakhir` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE KEY `username` (`username`,`email`) USING BTREE,
  KEY `fk_level` (`level`) USING BTREE,
  CONSTRAINT `fk_level` FOREIGN KEY (`level`) REFERENCES `level` (`id_level`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table db_motor.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `username`, `password`, `salt`, `token`, `email`, `nama`, `hp`, `gambar`, `level`, `login_terakhir`, `status`) VALUES
	(1, 'hottuarealy@gmail.com', 'e1594bb9652971bd9f94b9e2e50c77ff2e3d6a6b', '6VDaUeGk', 'eNbIMHbN4r3oBhISiQoaCB0DTX379KQJa3qHjQgH2nyv92gf9yUBVfphzdnzEWxQ', 'hottuarealy@gmail.com', 'Administrator', '081360275177', 'logolabusel.png', 1, '2020-03-10 23:09:51', 'Y'),
	(2, 'admin', '70461276fc05cac114e7528761b61d17eed8277b', 'rCQvWUKM', '', 'admin@gmail.com', 'admin', '123', 'avatar.png', 2, '0000-00-00 00:00:00', 'Y');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- Dumping structure for view db_motor.view_formulir_pp
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_formulir_pp` (
	`id_fpp` INT(11) NOT NULL,
	`no_fpp` INT(11) NULL,
	`tgl_permohonan` DATE NULL,
	`jlh_permohonan` INT(11) NULL,
	`id_anggota` INT(11) NULL,
	`nama_anggota` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci',
	`no_anggota` INT(11) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_motor.view_menu
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_menu` (
	`id_menu` INT(11) NOT NULL,
	`id_modul` INT(11) NOT NULL,
	`id_parent` INT(11) NOT NULL,
	`nama_menu` VARCHAR(200) NOT NULL COLLATE 'utf8_general_ci',
	`link` VARCHAR(200) NOT NULL COLLATE 'utf8_general_ci',
	`urutan` INT(11) NOT NULL,
	`id_level` INT(11) NOT NULL,
	`baca` TINYINT(1) NOT NULL,
	`tulis` TINYINT(1) NOT NULL,
	`ubah` TINYINT(1) NOT NULL,
	`hapus` TINYINT(1) NOT NULL,
	`id` INT(11) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_motor.view_modul
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_modul` (
	`id_modul` INT(11) NOT NULL,
	`nama_modul` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`controller` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`urutan` INT(11) NOT NULL,
	`icon` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	`id_level` INT(11) NOT NULL,
	`baca` TINYINT(1) NOT NULL,
	`id` INT(11) NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view db_motor.view_pinjaman
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_pinjaman` (
	`id_pinjaman` INT(11) NOT NULL,
	`id_anggota` INT(11) NOT NULL,
	`no_pinjaman` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci',
	`jlh_pinjam` INT(11) NOT NULL,
	`bunga` INT(11) NOT NULL,
	`tenor` INT(11) NOT NULL,
	`administrasi` INT(11) NOT NULL,
	`keterangan` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci',
	`tgl_pinjam` DATE NULL,
	`status` ENUM('Open','Lunas') NULL COLLATE 'latin1_swedish_ci',
	`angsuran` INT(11) NULL,
	`total` INT(11) NULL,
	`sisa_tenor` INT(11) NOT NULL,
	`nama_anggota` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dumping structure for view db_motor.view_formulir_pp
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_formulir_pp`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_formulir_pp` AS SELECT tb_formulir_pp.*, tb_anggota.nama_anggota, tb_anggota.no_anggota 
FROM tb_formulir_pp 
INNER JOIN tb_anggota ON tb_formulir_pp.id_anggota = tb_anggota.id_anggota ;

-- Dumping structure for view db_motor.view_menu
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_menu`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_menu` AS SELECT `a`.`id_menu` AS `id_menu`, `a`.`id_modul` AS `id_modul`, `a`.`id_parent` AS `id_parent`, `a`.`nama_menu` AS `nama_menu`, `a`.`link` AS `link`, `a`.`urutan` AS `urutan`, `b`.`id_level` AS `id_level`, `b`.`baca` AS `baca`, `b`.`tulis` AS `tulis`, `b`.`ubah` AS `ubah`, `b`.`hapus` AS `hapus`, `b`.`id` AS `id` FROM (`menu` `a` join `menu_akses` `b` on(`a`.`id_menu` = `b`.`id_menu`)) ;

-- Dumping structure for view db_motor.view_modul
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_modul`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_modul` AS SELECT `a`.`id_modul` AS `id_modul`, `a`.`nama_modul` AS `nama_modul`, `a`.`controller` AS `controller`, `a`.`urutan` AS `urutan`, `a`.`icon` AS `icon`, `b`.`id_level` AS `id_level`, `b`.`baca` AS `baca`, `b`.`id` AS `id` FROM (`modul` `a` join `modul_akses` `b` on(`a`.`id_modul` = `b`.`id_modul`)) ;

-- Dumping structure for view db_motor.view_pinjaman
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_pinjaman`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_pinjaman` AS SELECT tb_pinjaman.*, tb_anggota.nama_anggota
FROM tb_pinjaman
INNER JOIN tb_anggota
ON tb_anggota.id_anggota = tb_pinjaman.id_anggota ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
