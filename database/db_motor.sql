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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

-- Dumping structure for table db_motor.level
CREATE TABLE IF NOT EXISTS `level` (
  `id_level` int(11) NOT NULL AUTO_INCREMENT,
  `nama_level` varchar(100) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_level`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

-- Dumping structure for table db_motor.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_modul` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL DEFAULT '0',
  `nama_menu` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `urutan` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

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
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

-- Dumping structure for table db_motor.modul_akses
CREATE TABLE IF NOT EXISTS `modul_akses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_modul` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `baca` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `level` (`id_modul`,`id_level`) USING BTREE,
  CONSTRAINT `fk_modul_akses` FOREIGN KEY (`id_modul`) REFERENCES `modul` (`id_modul`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

-- Dumping structure for table db_motor.tbrefa
CREATE TABLE IF NOT EXISTS `tbrefa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referensi` varchar(30) DEFAULT NULL,
  `idxref` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `k1_tbrefa_ref` (`referensi`) USING BTREE,
  UNIQUE KEY `idxref` (`idxref`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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
  PRIMARY KEY (`id_angsuran`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table db_motor.tb_formulir_pp
CREATE TABLE IF NOT EXISTS `tb_formulir_pp` (
  `id_fpp` int(11) NOT NULL AUTO_INCREMENT,
  `no_fpp` int(11) DEFAULT '0',
  `tgl_permohonan` date DEFAULT NULL,
  `jlh_permohonan` int(11) DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_fpp`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

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
  `tgl_tempo` int(11) DEFAULT NULL,
  `status` enum('Open','Lunas') DEFAULT NULL,
  `angsuran` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `sisa_tenor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pinjaman`),
  UNIQUE KEY `no_pinjaman` (`no_pinjaman`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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
	`tgl_tempo` INT(11) NULL,
	`status` ENUM('Open','Lunas') NULL COLLATE 'latin1_swedish_ci',
	`angsuran` INT(11) NULL,
	`total` INT(11) NULL,
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
