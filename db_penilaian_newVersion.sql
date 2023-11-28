/*
SQLyog Enterprise
MySQL - 8.0.30 : Database - db_penilaian
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `fakultas` */

DROP TABLE IF EXISTS `fakultas`;

CREATE TABLE `fakultas` (
  `kode_fakultas` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_fakultas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_web` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kode_fakultas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `fakultas` */

insert  into `fakultas`(`kode_fakultas`,`nama_fakultas`,`link_web`,`created_at`,`updated_at`) values 
('FK-001','VOKASI','https://vokasi.unpak.ac.id/','2023-09-11 12:50:07','2023-09-11 12:50:07'),
('FK-002','HUKUM','https://fhukum.unpak.ac.id/','2023-09-11 12:50:29','2023-09-11 12:50:29'),
('FK-003','EKONOMI DAN BISNIS','https://feb.ui.ac.id/','2023-09-11 12:51:20','2023-09-11 12:51:54'),
('FK-004','KEGURUAN DAN ILMU PENDIDIKAN','https://fkip.unpak.ac.id/','2023-09-11 12:52:45','2023-09-11 12:52:45'),
('FK-005','ILMU SOSIAL DAN BUDAYA','https://fisib.unpak.ac.id/','2023-09-11 12:53:49','2023-09-11 12:53:49'),
('FK-006','TEKNIK','https://ft.unpak.ac.id/','2023-09-11 12:54:21','2023-09-11 12:54:21'),
('FK-007','MATEMATIKA DAN ILMU PENGETAHUAN ALAM','https://fmipa.unpak.ac.id/','2023-09-11 12:54:56','2023-09-11 12:54:56'),
('FK-008','PASCASARJANA','https://pasca.unpak.ac.id/','2023-09-11 12:55:33','2023-09-11 12:55:33');

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlahbobot` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `kategori` */

insert  into `kategori`(`id`,`nama_kategori`,`jumlahbobot`,`created_at`,`updated_at`) values 
(2,'TIM PENGELOLAAN','15','2023-09-12 22:55:50','2023-09-12 22:55:50'),
(3,'ARSITEKTUR WEB DESIGN','15','2023-09-12 22:56:32','2023-09-12 22:56:32'),
(4,'ARSITEKTUR WEB TATA KELOLA','40','2023-09-12 22:57:04','2023-09-12 22:57:04'),
(5,'VISITOR WEBSITE','20','2023-09-12 22:57:33','2023-09-12 22:57:55'),
(6,'MEDIA SOSIAL','10','2023-09-12 22:58:22','2023-09-12 22:58:22');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2023_08_15_031948_create_fakultas_table',1),
(6,'2023_08_15_041313_create_prodi_table',1),
(7,'2023_08_22_114216_create_bobot_nilai_table',1),
(8,'2023_08_25_190831_add_column_link__fakultas',1),
(9,'2023_08_25_192026_add_column_link_in_prodi',1),
(10,'2023_08_25_192945_add_table_detail_kategori',1),
(11,'2023_08_31_163508_table-penilaian-fakultas',1),
(12,'2023_09_06_170257_table-penilaian-prodi',1);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `penilaian_fakultas` */

DROP TABLE IF EXISTS `penilaian_fakultas`;

CREATE TABLE `penilaian_fakultas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penilaian_kode` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penilaian_tgl` date NOT NULL,
  `penilaian_kodefakultas` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penilaian_idkategori` bigint unsigned NOT NULL,
  `penilaian_idsubkategori` bigint unsigned NOT NULL,
  `masuk_nilai` int NOT NULL,
  `score` double(11,2) DEFAULT '0.00',
  `iduser` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_fakultas_penilaian_idfakultas_foreign` (`penilaian_kodefakultas`),
  KEY `penilaian_fakultas_penilaian_iddetailkategori_foreign` (`penilaian_idkategori`),
  KEY `penilaian_fakultas_penilaian_idbobot_foreign` (`penilaian_idsubkategori`),
  CONSTRAINT `penilaian_fakultas_ibfk_1` FOREIGN KEY (`penilaian_kodefakultas`) REFERENCES `fakultas` (`kode_fakultas`) ON UPDATE CASCADE,
  CONSTRAINT `penilaian_fakultas_ibfk_2` FOREIGN KEY (`penilaian_idkategori`) REFERENCES `kategori` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `penilaian_fakultas_ibfk_3` FOREIGN KEY (`penilaian_idsubkategori`) REFERENCES `sub_kategori` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penilaian_fakultas` */

insert  into `penilaian_fakultas`(`id`,`penilaian_kode`,`penilaian_tgl`,`penilaian_kodefakultas`,`penilaian_idkategori`,`penilaian_idsubkategori`,`masuk_nilai`,`score`,`iduser`,`created_at`,`updated_at`) values 
(295,'PLF-5097100001','2023-11-04','FK-001',2,3,80,4.00,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(296,'PLF-5097100001','2023-11-04','FK-001',2,4,70,7.00,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(297,'PLF-5097100001','2023-11-04','FK-001',3,6,70,2.10,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(298,'PLF-5097100001','2023-11-04','FK-001',3,7,80,5.60,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(299,'PLF-5097100001','2023-11-04','FK-001',3,8,70,3.50,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(300,'PLF-5097100001','2023-11-04','FK-001',4,9,70,2.10,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(301,'PLF-5097100001','2023-11-04','FK-001',4,10,80,2.40,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(302,'PLF-5097100001','2023-11-04','FK-001',4,11,60,1.80,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(303,'PLF-5097100001','2023-11-04','FK-001',4,12,70,10.50,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(304,'PLF-5097100001','2023-11-04','FK-001',4,13,80,2.40,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(305,'PLF-5097100001','2023-11-04','FK-001',4,14,80,7.20,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(306,'PLF-5097100001','2023-11-04','FK-001',4,15,70,2.80,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(307,'PLF-5097100001','2023-11-04','FK-001',5,16,60,12.00,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(308,'PLF-5097100001','2023-11-04','FK-001',5,19,70,10.50,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(309,'PLF-5097100001','2023-11-04','FK-001',6,17,80,4.00,5,'2023-11-04 14:55:35','2023-11-04 14:55:35'),
(310,'PLF-5097100001','2023-11-04','FK-001',6,18,60,3.00,5,'2023-11-04 14:55:35','2023-11-04 14:55:35');

/*Table structure for table `penilaian_prodi` */

DROP TABLE IF EXISTS `penilaian_prodi`;

CREATE TABLE `penilaian_prodi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `penilaian_kode` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penilaian_tgl` date NOT NULL,
  `penilaian_kodeprodi` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penilaian_idkategori` bigint unsigned NOT NULL,
  `penilaian_idsubkategori` bigint unsigned NOT NULL,
  `masuk_nilaip` int NOT NULL,
  `score` double(11,2) DEFAULT '0.00',
  `iduser` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_prodi_penilaian_idprodi_foreign` (`penilaian_kodeprodi`),
  KEY `penilaian_prodi_penilaian_iddetailkategori_foreign` (`penilaian_idkategori`),
  KEY `penilaian_prodi_penilaian_idbobot_foreign` (`penilaian_idsubkategori`),
  CONSTRAINT `penilaian_prodi_ibfk_1` FOREIGN KEY (`penilaian_kodeprodi`) REFERENCES `prodi` (`kode_prodi`) ON UPDATE CASCADE,
  CONSTRAINT `penilaian_prodi_ibfk_2` FOREIGN KEY (`penilaian_idkategori`) REFERENCES `kategori` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `penilaian_prodi_ibfk_3` FOREIGN KEY (`penilaian_idsubkategori`) REFERENCES `sub_kategori` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `penilaian_prodi` */

insert  into `penilaian_prodi`(`id`,`penilaian_kode`,`penilaian_tgl`,`penilaian_kodeprodi`,`penilaian_idkategori`,`penilaian_idsubkategori`,`masuk_nilaip`,`score`,`iduser`,`created_at`,`updated_at`) values 
(123,'PLP-5107070001','2023-11-04','PR-014',2,3,90,4.50,5,'2023-11-04 15:12:11','2023-11-04 15:12:11'),
(124,'PLP-5107070001','2023-11-04','PR-014',2,4,80,8.00,5,'2023-11-04 15:12:11','2023-11-04 15:12:11'),
(125,'PLP-5107070001','2023-11-04','PR-014',3,6,80,2.40,5,'2023-11-04 15:12:11','2023-11-04 15:12:11'),
(126,'PLP-5107070001','2023-11-04','PR-014',3,7,90,6.30,5,'2023-11-04 15:12:11','2023-11-04 15:12:11'),
(127,'PLP-5107070001','2023-11-04','PR-014',3,8,80,4.00,5,'2023-11-04 15:12:11','2023-11-04 15:12:11'),
(128,'PLP-5107070001','2023-11-04','PR-014',4,9,90,2.70,5,'2023-11-04 15:12:11','2023-11-04 15:12:11'),
(129,'PLP-5107070001','2023-11-04','PR-014',4,10,90,2.70,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(130,'PLP-5107070001','2023-11-04','PR-014',4,11,80,2.40,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(131,'PLP-5107070001','2023-11-04','PR-014',4,12,80,12.00,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(132,'PLP-5107070001','2023-11-04','PR-014',4,13,80,2.40,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(133,'PLP-5107070001','2023-11-04','PR-014',4,14,90,8.10,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(134,'PLP-5107070001','2023-11-04','PR-014',4,15,90,3.60,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(135,'PLP-5107070001','2023-11-04','PR-014',5,16,90,18.00,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(136,'PLP-5107070001','2023-11-04','PR-014',5,19,80,12.00,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(137,'PLP-5107070001','2023-11-04','PR-014',6,17,80,4.00,5,'2023-11-04 15:12:12','2023-11-04 15:12:12'),
(138,'PLP-5107070001','2023-11-04','PR-014',6,18,80,4.00,5,'2023-11-04 15:12:12','2023-11-04 15:12:12');

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `prodi` */

DROP TABLE IF EXISTS `prodi`;

CREATE TABLE `prodi` (
  `kode_prodi` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi_kodefakultas` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_web` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kode_prodi`),
  KEY `prodi_id_fakultas_foreign` (`prodi_kodefakultas`),
  CONSTRAINT `prodi_ibfk_1` FOREIGN KEY (`prodi_kodefakultas`) REFERENCES `fakultas` (`kode_fakultas`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `prodi` */

insert  into `prodi`(`kode_prodi`,`prodi_kodefakultas`,`nama_prodi`,`link_web`,`created_at`,`updated_at`) values 
('PR-001','FK-001','AKUNTANSI D3','https://d3akuntansi.unpak.ac.id/','2023-09-11 13:01:54','2023-09-11 13:01:54'),
('PR-002','FK-001','MANAJEMEN PAJAK D3','https://d3tk.unpak.ac.id/','2023-09-11 13:03:40','2023-10-04 23:14:15'),
('PR-003','FK-001','MANAJEMEN INFORMATIKA D3','https://d3mi.unpak.ac.id/','2023-09-11 13:05:02','2023-10-04 23:14:36'),
('PR-004','FK-003','MANAJEMEN','https://manajemen.unpak.ac.id/','2023-10-04 23:18:57','2023-10-04 23:18:57'),
('PR-005','FK-003','AKUNTANSI','https://akuntansi.unpak.ac.id/','2023-10-04 23:20:49','2023-10-04 23:20:49'),
('PR-006','FK-003','DIGITAL BISNIS','https://bisnisdigital.unpak.ac.id/','2023-10-04 23:23:02','2023-10-04 23:23:02'),
('PR-007','FK-004','BAHASA SASTRA INDONESIA','https://pbindo-fkip.unpak.ac.id/','2023-10-04 23:25:29','2023-10-04 23:25:29'),
('PR-008','FK-004','BAHASA INGGRIS','https://englishedu-fkip.unpak.ac.id/','2023-10-04 23:28:23','2023-10-04 23:28:23'),
('PR-009','FK-004','PENDIDIKAN BIOLOGI','https://biologi-fkip.unpak.ac.id/','2023-10-04 23:35:03','2023-10-04 23:35:03'),
('PR-010','FK-004','PGSD','https://pgsd-fkip.unpak.ac.id/','2023-10-04 23:36:27','2023-10-04 23:36:27'),
('PR-011','FK-004','PENDIDIKAN IPA','https://ipa-fkip.unpak.ac.id/','2023-10-04 23:37:36','2023-10-04 23:37:36'),
('PR-012','FK-004','PPG FKIP','https://ppg-fkip.unpak.ac.id/','2023-10-04 23:39:10','2023-10-04 23:39:10'),
('PR-013','FK-005','BAHASA & SASTRA INGGRIS','https://sastrainggris-fisib.unpak.ac.id/','2023-10-04 23:41:14','2023-10-04 23:41:14'),
('PR-014','FK-005','BAHASA & SASTRA JEPANG','https://sastrajepang-fisib.unpak.ac.id/','2023-10-04 23:42:07','2023-10-04 23:42:07'),
('PR-015','FK-005','BAHASA & SASTRA INDONESIA','https://sastraindonesia-fisib.unpak.ac.id/','2023-10-04 23:43:37','2023-10-04 23:43:37'),
('PR-016','FK-005','ILMU KOMUNIKASI','https://ilmukomunikasi-fisib.unpak.ac.id/','2023-10-04 23:44:28','2023-10-04 23:44:28'),
('PR-017','FK-006','GEOLOGI','https://ft.unpak.ac.id/program-studi/prodi-geologi','2023-10-04 23:45:38','2023-10-04 23:45:38'),
('PR-018','FK-006','PERENCANAAN WILAYAH KOTA','https://ft.unpak.ac.id/program-studi/prodi-pwk','2023-10-04 23:50:23','2023-10-04 23:50:23'),
('PR-019','FK-006','SIPIL','https://ft.unpak.ac.id/program-studi/prodi-sipil','2023-10-04 23:51:01','2023-10-04 23:51:01'),
('PR-020','FK-006','TEKNIK ELEKTRO','https://ft.unpak.ac.id/program-studi/prodi-teknik-elektro','2023-10-04 23:52:02','2023-10-04 23:52:02'),
('PR-021','FK-006','GEODESI','https://ft.unpak.ac.id/program-studi/prodi-teknik-geodesi','2023-10-04 23:52:56','2023-10-04 23:52:56'),
('PR-022','FK-007','BIOLOGI','https://biologi.unpak.ac.id/','2023-10-04 23:53:49','2023-10-04 23:53:49'),
('PR-023','FK-007','KIMIA','https://kimia.unpak.ac.id/index.php?page=home','2023-10-04 23:54:18','2023-10-04 23:54:18'),
('PR-024','FK-007','MATEMATIKA','https://math.unpak.ac.id/','2023-10-04 23:55:05','2023-10-04 23:55:05'),
('PR-025','FK-007','ILMU KOMPUTER','https://ilkom.unpak.ac.id/','2023-10-04 23:55:36','2023-10-04 23:55:36'),
('PR-026','FK-007','FARMASI','https://farmasi.unpak.ac.id/','2023-10-04 23:56:13','2023-10-04 23:56:13'),
('PR-027','FK-008','ADMINISTRASI PENDIDIKAN S2','https://ap-pasca.unpak.ac.id/','2023-10-04 23:57:19','2023-10-04 23:57:19'),
('PR-028','FK-008','MANAJEMEN LUNGKUNGAN S2','https://ml-pasca.unpak.ac.id/','2023-10-04 23:58:20','2023-10-04 23:58:20'),
('PR-029','FK-008','ILMU HUKUM S2','https://hukum-pasca.unpak.ac.id/','2023-10-04 23:59:09','2023-10-04 23:59:09'),
('PR-030','FK-008','MANAJEMEN S2','https://mm-pasca.unpak.ac.id/','2023-10-04 23:59:57','2023-10-04 23:59:57'),
('PR-031','FK-008','PENDIDIKAN ILMU PENGETAHUAN ALAM S2','https://ipa-pasca.unpak.ac.id/','2023-10-05 00:00:56','2023-10-05 00:00:56'),
('PR-032','FK-008','PERENCANA WILAYAH DAN KOTA S2','https://pwk-pasca.unpak.ac.id/','2023-10-05 00:01:45','2023-10-05 00:01:45'),
('PR-033','FK-008','PENDIDIKAN DASAR S2','https://pendas-pasca.unpak.ac.id/','2023-10-05 00:02:21','2023-10-05 00:02:21'),
('PR-034','FK-008','MANAJEMEN PENDIDIKAN S3','https://s3mp-pasca.unpak.ac.id/','2023-10-05 00:03:01','2023-10-05 00:03:01'),
('PR-035','FK-008','ILMU MANAJEMEN S3','https://im-pasca.unpak.ac.id/','2023-10-05 00:03:57','2023-10-05 00:03:57'),
('PR-036','FK-002','ILMU HUKUM','https://fhukum.unpak.ac.id/','2023-10-05 00:17:46','2023-10-05 00:17:46');

/*Table structure for table `sub_kategori` */

DROP TABLE IF EXISTS `sub_kategori`;

CREATE TABLE `sub_kategori` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_kategori` bigint unsigned NOT NULL,
  `kategori_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bobot_id_kategori_foreign` (`id_kategori`),
  CONSTRAINT `sub_kategori_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sub_kategori` */

insert  into `sub_kategori`(`id`,`id_kategori`,`kategori_detail`,`bobot`,`created_at`,`updated_at`) values 
(3,2,'Dibentuknya tim pengelola Website di Fakultas dan program studi (SK Dekan/ SK Kaprodi)',5,'2023-09-12 22:59:48','2023-09-20 18:42:08'),
(4,2,'adanya jobdesk description unit/team pengelola website dan media sosial',10,'2023-09-12 23:01:24','2023-09-12 23:01:54'),
(6,3,'Penggunaan Huruf yang baik dan benar, seperti : Tidak menggunakan HURUF BESAR pada seluruh judul atau deskripsi.',3,'2023-09-20 18:43:30','2023-09-20 18:43:30'),
(7,3,'Jarak antara konten (tulisan, gambar) proporsional. Tidak terlalu rapat dan renggang.',7,'2023-09-20 18:48:13','2023-09-20 18:48:13'),
(8,3,'Gambar atau foto tidak blur, tidak gelap, harus proporsional dan konsisten.',5,'2023-09-20 18:48:36','2023-09-20 18:48:36'),
(9,4,'Website Bilingual (Bahasa Indonesia dan Bahasa Inggris)',3,'2023-09-20 18:48:49','2023-09-20 18:48:49'),
(10,4,'Terdapat keterangan pada gambar yang berisi informasi berita.',3,'2023-09-20 18:49:32','2023-09-20 18:49:32'),
(11,4,'Terdapat keterangan tanggal pada semua berita, artikel dan dokumen yang dipublikasi.',3,'2023-09-20 18:49:43','2023-09-20 18:49:43'),
(12,4,'Ada Pembaharuan Berita dan Kegiatan disertai tanggal pembaharuannya minimal 1 (satu) minggu sekali.',15,'2023-09-20 18:49:56','2023-09-20 18:49:56'),
(13,4,'Konten unduh (download) seperti pdf, zip harus disertai judul, deskripsi/abstrak yang jelas dan mudah  dipahami pengunjung sebelum mereka mengunduh.',3,'2023-09-20 18:51:00','2023-09-20 18:51:00'),
(14,4,'Update Informasi Pengumuman, jadwal kuliah atau informasi kegiatan akademik dan non akademik.',9,'2023-09-20 18:54:22','2023-09-20 18:54:22'),
(15,4,'Update Konten Profil meliputi Sejarah/Profil Singkat, Visi dan Misi, Struktur Organisasi, Informasi Pejabat, Lokasi Kantor yang  diletakkan di menu Profil.',4,'2023-09-20 18:54:33','2023-09-20 18:54:33'),
(16,5,'Jumlah Pengunjung dari Januari s.d Oktober 2023',20,'2023-09-20 18:56:08','2023-09-20 18:56:08'),
(17,6,'Official Media Sosial (Instagram, Tiktok, Youtube Channel, Facebook)',5,'2023-09-20 18:56:18','2023-09-20 18:56:18'),
(18,6,'Manajemen Pengelolaan dan Konten Media Sosial',5,'2023-09-20 18:56:28','2023-09-20 18:56:28'),
(19,5,'Melihat Jumlah Visitor Website yang dikunjungi',15,'2023-11-04 07:58:58','2023-11-04 08:03:10');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','juri') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`fullname`,`email`,`email_verified_at`,`password`,`role`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Administrator','admin@admin.com',NULL,'$2y$10$xS8xLE9mR/ltqAeqXyARheu7VVknGBiMu836mRb7LtagcU/aOvCJu','admin',NULL,NULL,NULL),
(5,'Juri 1','juri1@gmail.com',NULL,'$2y$10$Gy/aWlBMlTVNHhqtexdekusRBk0kbiFN0jmM6OnOx2unFRoJpBYni','juri',NULL,'2023-09-20 19:29:31','2023-11-04 11:15:41'),
(6,'Juri 2','juri2@gmail.com',NULL,'$2y$10$3GLbRyoaRZhADmy5nEm1Zukd1uGuO9WQ28lpwGdHiNkKZpoU02.MC','juri',NULL,'2023-09-21 16:19:30','2023-09-21 16:19:30'),
(7,'Juri 3','juri3@gmail.com',NULL,'$2y$10$8xT8iE9u.PbH7wDCItk26e.KKOzYl4JXOonKMLgSRnXgqrpKC2ygK','juri',NULL,'2023-09-21 16:19:45','2023-09-21 16:19:45');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
