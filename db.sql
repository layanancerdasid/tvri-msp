/*
SQLyog Enterprise v12.09 (64 bit)
MySQL - 10.4.10-MariaDB : Database - tvri
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tvri` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `tvri`;

/*Table structure for table `app_menu` */

DROP TABLE IF EXISTS `app_menu`;

CREATE TABLE `app_menu` (
  `idmenu` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(100) NOT NULL,
  `url_menu` varchar(100) NOT NULL,
  `Keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

/*Data for the table `app_menu` */

insert  into `app_menu`(`idmenu`,`nama_menu`,`url_menu`,`Keterangan`) values (1,'Master Propinsi','master/provinsi',NULL),(2,'Master Kabupaten/Kota','master/kabupaten',NULL),(3,'Master Kategori Pengadaan','master/kat_pengadaan',NULL),(4,'Master Klasifikasi Pengujian','master/kategoriuji',NULL),(5,'Master Sumber Dana','master/sumberdana',NULL),(6,'Master Vendor Pelaksana','master/vendor',NULL),(7,'Master Pengguna','auth',NULL),(8,'Master Group Pengguna','auth/groups',NULL),(9,'Transaksi Paket Pekerjaan (Non Lelang)','transaksi/paket?lelang=0',NULL),(10,'Transaksi Milestone (Non Lelang)','transaksi/activity?lelang=0',NULL),(11,'Approval Kegiatan','approval/activity',NULL),(12,'Allow PPHP','approval/alowpphp',NULL),(13,'Report PPHP','pphp/progress',NULL),(14,'Master Satuan','master/satuan',NULL),(15,'Daftar Lokasi Survei','survei/lokasisurvei',NULL),(16,'Daftar Kegiatan Survei','survei/kegiatan',NULL),(17,'Daftar Kuesioner Survei','survei/kuesioner',NULL),(18,'Daftar Penugasan Survei','survei/penugasan',NULL),(19,'Daftar Penerima Bantuan','fbb/listpenetapan',NULL),(20,'Laporan Penerima Bantuan','fbb/report',NULL),(21,'Laporan Kegiatan Survei','survei/report',NULL),(22,'Monitoring Lokasi FBB','fbb/monitoring',NULL),(23,'Transaksi Paket Pekerjaan (Lelang)','transaksi/paket?lelang=X1Z1',NULL),(24,'Transaksi Milestone (Lelang)','transaksi/activity?lelang=X1Z1',NULL),(25,'Daftar Penerima Bantuan Headend','headend/listpenetapan',NULL),(26,'Link Apps Pelaporan Headend','apps/headend',NULL),(27,'Laporan Kondisi Headend','headend/report',NULL),(28,'Monitoring Kondisi Headend','headend/monitoring',NULL),(29,'Master Minutes Of Meeting','g2/mom',NULL),(30,'Nota Dinas','g2/nodin',NULL),(31,'Laporan Kegiatan','g2/repkegiatan',NULL),(32,'Surat Tugas','g2/srttugas',NULL),(33,'Dok. Prakontrak Kegiatan','g2/prapaket',NULL),(34,'Master Internal Pegawai','master/intpegawai',NULL),(35,'Master External Pegawai','master/extpegawai',NULL),(36,'Master Subdit','master/subdit',NULL),(37,'Master Program Subdir','master/subditprogram',NULL),(38,'Apps Bantuan FBB','apps/fbb',NULL),(39,'Apps Bantuan Headend','apps/headend',NULL),(40,'Tools Konfig System','apps/settings',NULL),(41,'Tools Search Geotag','map/geolocation/search',NULL);

/*Table structure for table `app_menu_priv` */

DROP TABLE IF EXISTS `app_menu_priv`;

CREATE TABLE `app_menu_priv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idmenu` int(11) NOT NULL,
  `idgroup` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`,`idmenu`,`idgroup`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8;

/*Data for the table `app_menu_priv` */

insert  into `app_menu_priv`(`id`,`idmenu`,`idgroup`) values (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(9,9,1),(10,10,1),(11,9,2),(12,10,2),(13,9,3),(14,10,3),(17,11,2),(18,12,2),(20,13,5),(21,14,2),(23,16,1),(24,17,1),(25,15,2),(26,16,2),(27,17,2),(28,1,2),(29,2,2),(30,3,2),(31,4,2),(32,5,2),(33,6,2),(34,7,1),(35,18,2),(36,18,1),(37,19,1),(38,15,1),(39,20,1),(40,21,1),(41,21,2),(42,21,7),(43,19,2),(44,20,2),(45,22,2),(46,22,1),(47,15,9),(48,16,9),(49,17,9),(50,18,9),(51,21,9),(52,19,10),(53,20,10),(54,22,10),(55,23,2),(56,23,1),(57,24,1),(58,24,2),(59,23,3),(60,24,3),(61,9,5),(62,23,5),(63,14,1),(64,25,2),(65,26,2),(66,27,2),(67,28,2),(68,25,1),(69,26,1),(70,27,1),(71,28,1),(72,29,1),(73,29,2),(74,30,1),(75,31,1),(76,32,1),(77,30,2),(78,31,2),(79,32,2),(80,9,11),(81,23,11),(82,13,11),(83,29,12),(84,30,12),(85,31,12),(86,32,12),(87,33,1),(88,33,2),(89,1,13),(90,2,13),(91,3,13),(92,4,13),(93,5,13),(94,6,13),(95,9,13),(96,10,13),(97,16,13),(98,17,13),(100,18,13),(101,19,13),(102,15,13),(103,20,13),(104,21,13),(105,22,13),(106,23,13),(107,24,13),(108,14,13),(109,25,13),(110,26,13),(111,27,13),(112,28,13),(113,29,13),(114,30,13),(115,31,13),(116,32,13),(117,33,13),(120,19,14),(121,20,14),(122,22,14),(127,8,1),(128,29,9),(129,30,9),(130,31,9),(131,32,9),(132,33,9);

/*Table structure for table `auth_groups` */

DROP TABLE IF EXISTS `auth_groups`;

CREATE TABLE `auth_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `auth_groups` */

insert  into `auth_groups`(`id`,`name`,`description`) values (1,'admin','Super Administrator Dit. PPI'),(2,'users','Pejabat Pembuat Komitmen - Kominfo');

/*Table structure for table `auth_login_attempts` */

DROP TABLE IF EXISTS `auth_login_attempts`;

CREATE TABLE `auth_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `auth_login_attempts` */

/*Table structure for table `auth_users` */

DROP TABLE IF EXISTS `auth_users`;

CREATE TABLE `auth_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT 1,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `device_id` varchar(255) NOT NULL,
  `iduser_ppk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

/*Data for the table `auth_users` */

insert  into `auth_users`(`id`,`ip_address`,`username`,`password`,`salt`,`email`,`activation_code`,`forgotten_password_code`,`forgotten_password_time`,`remember_code`,`created_on`,`last_login`,`active`,`first_name`,`last_name`,`company`,`phone`,`token`,`device_id`,`iduser_ppk`) values (1,'127.0.0.1','administrator','$2y$08$CaxVpUOZecG6V2ZHbI3HXeEZ/Wq2OI9HDtlLdktep95JPvUzstgm.',NULL,'admin@admin.com','',NULL,NULL,NULL,1,1602664161,1,'Admin','Aplikasi','Direktorat Pengembangan Pitalebar, Kemkominfo','0778326507','08501ee5e43cf4e4eff212f4c19bfaca','b58f717bf121c17b',NULL);

/*Table structure for table `auth_users_groups` */

DROP TABLE IF EXISTS `auth_users_groups`;

CREATE TABLE `auth_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`) USING BTREE,
  KEY `fk_users_groups_users1_idx` (`user_id`) USING BTREE,
  KEY `fk_users_groups_groups1_idx` (`group_id`) USING BTREE,
  CONSTRAINT `auth_users_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `auth_users_groups_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `auth_users_groups` */

insert  into `auth_users_groups`(`id`,`user_id`,`group_id`) values (1,1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
