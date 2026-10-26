/*
SQLyog Professional v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB-log : Database - evaluaciones
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`evaluaciones` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `evaluaciones`;

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

insert  into `cache`(`key`,`value`,`expiration`) values 
('evaluaciones-cache-8348b2416ffe8ade8d9db44355170129','i:1;',1780940245),
('evaluaciones-cache-8348b2416ffe8ade8d9db44355170129:timer','i:1780940245;',1780940245),
('evaluaciones-cache-d72ccfd75f3e7256d7500233e240c5f0','i:2;',1780940186),
('evaluaciones-cache-d72ccfd75f3e7256d7500233e240c5f0:timer','i:1780940186;',1780940186);

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `dimensiones` */

DROP TABLE IF EXISTS `dimensiones`;

CREATE TABLE `dimensiones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `plantilla_id` bigint(20) unsigned NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `factor` varchar(200) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dimensiones_plantilla_id_foreign` (`plantilla_id`),
  CONSTRAINT `dimensiones_plantilla_id_foreign` FOREIGN KEY (`plantilla_id`) REFERENCES `plantillas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `dimensiones` */

insert  into `dimensiones`(`id`,`plantilla_id`,`nombre`,`factor`,`orden`,`activo`,`created_at`,`updated_at`) values 
(1,1,'Desempeño orientado a resultados','Cumplimiento de metas y objetivos',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(2,1,'Desempeño conductual','Liderazgo y gestión organizacional',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(3,1,'Desempeño basado en competencias','Competencias gerenciales',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(4,1,'Desempeño contextual','Contribución organizacional',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(5,2,'Comunicación y relación con el equipo',NULL,1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(6,2,'Liderazgo y gestión del equipo',NULL,2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(7,2,'Apoyo y desarrollo del colaborador',NULL,3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(8,2,'Compromiso y gestión organizacional',NULL,4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(9,3,'Comunicación y relación con el equipo',NULL,1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(10,3,'Liderazgo y gestión del equipo',NULL,2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(11,3,'Apoyo y desarrollo del colaborador',NULL,3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(12,3,'Compromiso y gestión organizacional',NULL,4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46');

/*Table structure for table `empleados` */

DROP TABLE IF EXISTS `empleados`;

CREATE TABLE `empleados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `puesto_id` bigint(20) unsigned NOT NULL,
  `jefe_id` bigint(20) unsigned DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `empleados_user_id_unique` (`user_id`),
  KEY `empleados_puesto_id_foreign` (`puesto_id`),
  KEY `empleados_jefe_id_foreign` (`jefe_id`),
  CONSTRAINT `empleados_jefe_id_foreign` FOREIGN KEY (`jefe_id`) REFERENCES `empleados` (`id`) ON DELETE SET NULL,
  CONSTRAINT `empleados_puesto_id_foreign` FOREIGN KEY (`puesto_id`) REFERENCES `puestos` (`id`),
  CONSTRAINT `empleados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `empleados` */

insert  into `empleados`(`id`,`user_id`,`puesto_id`,`jefe_id`,`activo`,`created_at`,`updated_at`) values 
(1,1,1,NULL,1,'2026-06-06 18:41:06','2026-06-06 18:48:46'),
(2,2,2,1,1,'2026-06-06 18:41:06','2026-06-06 18:48:47'),
(3,3,3,2,1,'2026-06-06 18:41:07','2026-06-07 03:34:10'),
(4,4,4,3,1,'2026-06-06 18:41:07','2026-06-06 18:48:47'),
(5,5,5,4,1,'2026-06-06 18:41:07','2026-06-06 18:48:47'),
(6,6,6,3,1,'2026-06-06 18:41:07','2026-06-06 18:48:47'),
(7,7,7,3,1,'2026-06-06 18:41:07','2026-06-06 18:48:48'),
(8,8,8,7,1,'2026-06-06 18:41:08','2026-06-06 18:48:48'),
(9,9,9,3,1,'2026-06-06 18:41:08','2026-06-06 18:48:48'),
(10,10,10,1,1,'2026-06-06 18:41:08','2026-06-06 18:48:48'),
(11,11,11,10,1,'2026-06-06 18:41:08','2026-06-06 18:48:48'),
(12,12,12,10,1,'2026-06-06 18:41:08','2026-06-06 18:48:49'),
(13,13,13,10,1,'2026-06-06 18:41:09','2026-06-06 18:48:49'),
(14,14,14,13,1,'2026-06-06 18:41:09','2026-06-07 02:54:05'),
(15,15,15,1,1,'2026-06-06 18:41:09','2026-06-06 18:48:49'),
(16,16,16,15,1,'2026-06-06 18:41:09','2026-06-06 18:48:49'),
(17,17,17,15,1,'2026-06-06 18:41:09','2026-06-06 18:48:50'),
(18,18,18,15,1,'2026-06-06 18:41:10','2026-06-06 18:48:50'),
(19,19,19,1,1,'2026-06-06 18:41:10','2026-06-06 18:48:50'),
(20,20,20,19,1,'2026-06-06 18:41:10','2026-06-06 18:48:50'),
(21,21,21,20,1,'2026-06-06 18:41:10','2026-06-06 18:48:50'),
(22,22,22,19,1,'2026-06-06 18:41:10','2026-06-06 18:48:51'),
(23,23,23,19,1,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(24,24,24,19,1,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(25,25,25,1,1,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(26,26,26,25,1,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(27,27,27,25,1,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(28,28,28,1,1,'2026-06-06 18:41:12','2026-06-07 03:33:15');

/*Table structure for table `evaluaciones` */

DROP TABLE IF EXISTS `evaluaciones`;

CREATE TABLE `evaluaciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empleado_evaluador_id` bigint(20) unsigned NOT NULL,
  `empleado_evaluado_id` bigint(20) unsigned NOT NULL,
  `plantilla_id` bigint(20) unsigned NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente',
  `fecha_finalizacion` timestamp NULL DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `evaluacion_empleados_unica` (`empleado_evaluador_id`,`empleado_evaluado_id`),
  KEY `evaluaciones_empleado_evaluado_id_foreign` (`empleado_evaluado_id`),
  KEY `evaluaciones_plantilla_id_foreign` (`plantilla_id`),
  CONSTRAINT `evaluaciones_empleado_evaluado_id_foreign` FOREIGN KEY (`empleado_evaluado_id`) REFERENCES `empleados` (`id`),
  CONSTRAINT `evaluaciones_empleado_evaluador_id_foreign` FOREIGN KEY (`empleado_evaluador_id`) REFERENCES `empleados` (`id`),
  CONSTRAINT `evaluaciones_plantilla_id_foreign` FOREIGN KEY (`plantilla_id`) REFERENCES `plantillas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `evaluaciones` */

insert  into `evaluaciones`(`id`,`empleado_evaluador_id`,`empleado_evaluado_id`,`plantilla_id`,`estado`,`fecha_finalizacion`,`observaciones`,`created_at`,`updated_at`) values 
(1,1,2,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(2,2,1,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(3,2,3,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(4,3,2,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(5,3,4,3,'finalizada','2026-06-06 22:36:06','Esta es una prueba','2026-06-06 18:48:52','2026-06-06 22:36:06'),
(6,4,3,2,'finalizada','2026-06-07 00:17:01','Esta es una prueba','2026-06-06 18:48:52','2026-06-07 00:17:01'),
(7,4,5,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(8,5,4,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(9,3,6,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(10,6,3,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(11,3,7,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(12,7,3,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(13,7,8,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(14,8,7,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(15,3,9,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(16,9,3,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(17,1,10,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(18,10,1,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(19,10,11,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(20,11,10,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(21,10,12,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(22,12,10,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(23,10,13,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(24,13,10,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(25,13,14,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(26,14,13,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(27,1,15,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(28,15,1,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(29,15,16,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(30,16,15,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(31,15,17,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(32,17,15,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(33,15,18,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(34,18,15,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(35,1,19,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(36,19,1,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(37,19,20,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(38,20,19,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(39,20,21,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(40,21,20,2,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(41,19,22,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(42,22,19,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(43,19,23,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(44,23,19,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(45,19,24,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(46,24,19,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(47,1,25,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(48,25,1,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(49,25,26,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(50,26,25,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(51,25,27,3,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(52,27,25,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(53,1,28,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52'),
(54,28,1,1,'pendiente',NULL,NULL,'2026-06-06 18:48:52','2026-06-06 18:48:52');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2024_01_01_000000_create_passkeys_table',1),
(5,'2025_08_14_170933_add_two_factor_columns_to_users_table',1),
(6,'2026_06_06_165539_create_plantillas_table',2),
(7,'2026_06_06_165804_create_dimensions_table',2),
(8,'2026_06_06_170914_create_preguntas_table',2),
(9,'2026_06_06_171133_create_puestos_table',2),
(10,'2026_06_06_171446_create_empleados_table',2),
(11,'2026_06_06_172440_create_relacion_puestos_table',2),
(12,'2026_06_06_173038_create_evaluacions_table',2),
(13,'2026_06_06_173948_create_respuestas_table',2),
(14,'2026_06_06_175450_agregar_factor_a_dimensiones_table',3),
(15,'2026_06_06_193058_agregar_observaciones_a_evaluaciones_table',4),
(16,'2026_06_07_025643_agregar_es_admin_a_users_table',5);

/*Table structure for table `passkeys` */

DROP TABLE IF EXISTS `passkeys`;

CREATE TABLE `passkeys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `credential` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`credential`)),
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `passkeys_credential_id_unique` (`credential_id`),
  KEY `passkeys_user_id_index` (`user_id`),
  CONSTRAINT `passkeys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `passkeys` */

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `plantillas` */

DROP TABLE IF EXISTS `plantillas`;

CREATE TABLE `plantillas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plantillas_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `plantillas` */

insert  into `plantillas`(`id`,`codigo`,`nombre`,`descripcion`,`activo`,`created_at`,`updated_at`) values 
(1,'GER','Plantilla para gerentes','Evaluación del desempeño para puestos gerenciales.',1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(2,'MM','Plantilla para mandos medios','Evaluación del desempeño para jefaturas y mandos medios.',1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(3,'OPE','Plantilla para personal operativo','Evaluación del desempeño para personal operativo.',1,'2026-06-06 18:03:57','2026-06-06 18:48:46');

/*Table structure for table `preguntas` */

DROP TABLE IF EXISTS `preguntas`;

CREATE TABLE `preguntas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dimension_id` bigint(20) unsigned NOT NULL,
  `texto` text NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 1,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preguntas_dimension_id_foreign` (`dimension_id`),
  CONSTRAINT `preguntas_dimension_id_foreign` FOREIGN KEY (`dimension_id`) REFERENCES `dimensiones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `preguntas` */

insert  into `preguntas`(`id`,`dimension_id`,`texto`,`orden`,`activo`,`created_at`,`updated_at`) values 
(1,1,'Cumple las metas comerciales y operativas establecidas para su área.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(2,1,'Da seguimiento oportuno a indicadores y resultados del área bajo su responsabilidad.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(3,1,'Implementa acciones correctivas cuando identifica desviaciones en los resultados esperados.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(4,1,'Prioriza actividades alineadas a los objetivos estratégicos de la empresa.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(5,2,'Coordina y supervisa efectivamente las actividades de su equipo de trabajo.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(6,2,'Mantiene comunicación clara y oportuna con colaboradores y otras áreas.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(7,2,'Toma decisiones oportunas ante situaciones operativas o estratégicas.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(8,2,'Promueve el cumplimiento de políticas y lineamientos organizacionales.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(9,3,'Demuestra capacidad de análisis para la toma de decisiones estratégicas.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(10,3,'Gestiona eficientemente recursos financieros, comerciales y operativos.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(11,3,'Desarrolla estrategias orientadas al crecimiento y rentabilidad del negocio.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(12,3,'Demuestra conocimiento técnico y organizacional requerido para el puesto.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(13,4,'Promueve el trabajo colaborativo entre áreas y equipos de trabajo.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(14,4,'Propone mejoras para optimizar procesos y resultados organizacionales.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(15,4,'Mantiene disposición para adaptarse a cambios y nuevos retos organizacionales.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(16,4,'Contribuye al fortalecimiento del clima organizacional y desarrollo del personal.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(17,5,'Comunica instrucciones y expectativas de manera clara.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(18,5,'Escucha las opiniones y sugerencias del equipo.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(19,5,'Mantiene una comunicación respetuosa y profesional.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(20,5,'Brinda retroalimentación oportuna sobre el trabajo realizado.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(21,6,'Organiza adecuadamente el trabajo del equipo.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(22,6,'Da seguimiento a las actividades y responsabilidades del área.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(23,6,'Apoya al equipo cuando se presentan dificultades laborales.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(24,6,'Promueve un ambiente de trabajo colaborativo y respetuoso.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(25,7,'Brinda orientación cuando se requiere apoyo en el trabajo.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(26,7,'Promueve el aprendizaje y desarrollo del equipo.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(27,7,'Reconoce el esfuerzo y desempeño de los colaboradores.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(28,7,'Mantiene disposición para resolver dudas o problemas.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(29,8,'Actúa de forma alineada a los valores de la organización.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(30,8,'Toma decisiones de manera justa y objetiva.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(31,8,'Mantiene una actitud positiva y orientada a resultados.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(32,8,'Promueve el cumplimiento de objetivos y responsabilidades.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(33,9,'Comunica instrucciones y expectativas de manera clara.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(34,9,'Escucha las opiniones y sugerencias del equipo.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(35,9,'Mantiene una comunicación respetuosa y profesional.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(36,9,'Brinda retroalimentación oportuna sobre el trabajo realizado.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(37,10,'Organiza adecuadamente el trabajo del equipo.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(38,10,'Da seguimiento a las actividades y responsabilidades del área.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(39,10,'Apoya al equipo cuando se presentan dificultades laborales.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(40,10,'Promueve un ambiente de trabajo colaborativo y respetuoso.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(41,11,'Brinda orientación cuando se requiere apoyo en el trabajo.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(42,11,'Promueve el aprendizaje y desarrollo del equipo.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(43,11,'Reconoce el esfuerzo y desempeño de los colaboradores.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(44,11,'Mantiene disposición para resolver dudas o problemas.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(45,12,'Actúa de forma alineada a los valores de la organización.',1,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(46,12,'Toma decisiones de manera justa y objetiva.',2,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(47,12,'Mantiene una actitud positiva y orientada a resultados.',3,1,'2026-06-06 18:03:57','2026-06-06 18:48:46'),
(48,12,'Promueve el cumplimiento de objetivos y responsabilidades.',4,1,'2026-06-06 18:03:57','2026-06-06 18:48:46');

/*Table structure for table `puestos` */

DROP TABLE IF EXISTS `puestos`;

CREATE TABLE `puestos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `plantilla_id` bigint(20) unsigned NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `puestos_codigo_unique` (`codigo`),
  KEY `puestos_plantilla_id_foreign` (`plantilla_id`),
  CONSTRAINT `puestos_plantilla_id_foreign` FOREIGN KEY (`plantilla_id`) REFERENCES `plantillas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `puestos` */

insert  into `puestos`(`id`,`plantilla_id`,`nombre`,`codigo`,`activo`,`created_at`,`updated_at`) values 
(1,1,'Gerente General','GER-GEN',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(2,1,'Gerente de Operaciones','GER-OPE',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(3,2,'Jefe de Logística','MM-LOG',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(4,3,'Facturación y Cobros','OPE-FAC',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(5,3,'Mensajero','OPE-MEN-01',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(6,3,'Servicio al cliente z.10','OPE-SCZ10',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(7,3,'Servicio al cliente y logística','OPE-SCL',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(8,3,'Mensajero','OPE-MEN-02',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(9,3,'Encargado de bodega','OPE-BOD',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(10,1,'Gerente Regional de Ventas','GER-VEN',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(11,3,'Asistente de Ventas','OPE-ASV',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(12,2,'Product Manager','MM-PRO',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(13,2,'Supervisor de Ventas','MM-SUV',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(14,3,'Asesores Técnicos de Ventas','OPE-ATV',1,'2026-06-06 18:41:05','2026-06-07 02:39:44'),
(15,1,'Gerente Centro de Soluciones al Cliente','GER-CSC',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(16,3,'Técnicos de Proyectos','OPE-TPR',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(17,3,'Técnicos de Robótica & E-Drives','OPE-ROB',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(18,3,'Técnicos de Servicios','OPE-TSV',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(19,1,'Gerente Administrativa','GER-ADM',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(20,2,'Encargada de Sistemas','MM-SIS',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(21,3,'Técnico de Sistemas','OPE-SIS',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(22,3,'Asistente de Administración','OPE-AAD',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(23,3,'Mensajero','OPE-MEN-03',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(24,3,'Encargada de Limpieza','OPE-LIM',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(25,1,'Contador General','GER-CON',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(26,3,'Auxiliar de Contabilidad I','OPE-CO1',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(27,3,'Auxiliar de Contabilidad II','OPE-CO2',1,'2026-06-06 18:41:05','2026-06-06 18:48:46'),
(28,1,'Encargada de Recursos Humanos','GER-RH',1,'2026-06-06 18:41:05','2026-06-06 18:48:46');

/*Table structure for table `relaciones_puestos` */

DROP TABLE IF EXISTS `relaciones_puestos`;

CREATE TABLE `relaciones_puestos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `puesto_evaluador_id` bigint(20) unsigned NOT NULL,
  `puesto_evaluado_id` bigint(20) unsigned NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `relacion_puestos_unica` (`puesto_evaluador_id`,`puesto_evaluado_id`),
  KEY `relaciones_puestos_puesto_evaluado_id_foreign` (`puesto_evaluado_id`),
  CONSTRAINT `relaciones_puestos_puesto_evaluado_id_foreign` FOREIGN KEY (`puesto_evaluado_id`) REFERENCES `puestos` (`id`),
  CONSTRAINT `relaciones_puestos_puesto_evaluador_id_foreign` FOREIGN KEY (`puesto_evaluador_id`) REFERENCES `puestos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `relaciones_puestos` */

insert  into `relaciones_puestos`(`id`,`puesto_evaluador_id`,`puesto_evaluado_id`,`activo`,`created_at`,`updated_at`) values 
(1,1,2,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(2,2,1,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(3,2,3,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(4,3,2,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(5,3,4,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(6,4,3,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(7,4,5,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(8,5,4,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(9,3,6,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(10,6,3,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(11,3,7,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(12,7,3,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(13,7,8,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(14,8,7,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(15,3,9,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(16,9,3,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(17,1,10,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(18,10,1,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(19,10,11,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(20,11,10,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(21,10,12,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(22,12,10,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(23,10,13,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(24,13,10,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(25,13,14,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(26,14,13,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(27,1,15,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(28,15,1,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(29,15,16,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(30,16,15,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(31,15,17,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(32,17,15,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(33,15,18,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(34,18,15,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(35,1,19,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(36,19,1,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(37,19,20,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(38,20,19,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(39,20,21,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(40,21,20,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(41,19,22,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(42,22,19,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(43,19,23,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(44,23,19,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(45,19,24,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(46,24,19,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(47,1,25,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(48,25,1,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(49,25,26,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(50,26,25,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(51,25,27,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(52,27,25,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(53,1,28,1,'2026-06-06 18:41:12','2026-06-06 18:48:52'),
(54,28,1,1,'2026-06-06 18:41:12','2026-06-06 18:48:52');

/*Table structure for table `respuestas` */

DROP TABLE IF EXISTS `respuestas`;

CREATE TABLE `respuestas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `evaluacion_id` bigint(20) unsigned NOT NULL,
  `pregunta_id` bigint(20) unsigned NOT NULL,
  `calificacion` tinyint(3) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `respuesta_evaluacion_pregunta_unica` (`evaluacion_id`,`pregunta_id`),
  KEY `respuestas_pregunta_id_foreign` (`pregunta_id`),
  CONSTRAINT `respuestas_evaluacion_id_foreign` FOREIGN KEY (`evaluacion_id`) REFERENCES `evaluaciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `respuestas_pregunta_id_foreign` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `respuestas` */

insert  into `respuestas`(`id`,`evaluacion_id`,`pregunta_id`,`calificacion`,`created_at`,`updated_at`) values 
(1,5,33,3,'2026-06-06 22:21:59','2026-06-06 22:21:59'),
(2,5,35,2,'2026-06-06 22:21:59','2026-06-06 22:21:59'),
(3,5,36,3,'2026-06-06 22:21:59','2026-06-06 22:21:59'),
(4,5,40,4,'2026-06-06 22:21:59','2026-06-06 22:36:06'),
(5,5,34,2,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(6,5,37,2,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(7,5,38,3,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(8,5,39,3,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(9,5,41,4,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(10,5,42,3,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(11,5,43,2,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(12,5,44,1,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(13,5,45,4,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(14,5,46,3,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(15,5,47,2,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(16,5,48,1,'2026-06-06 22:36:06','2026-06-06 22:36:06'),
(17,6,17,3,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(18,6,18,4,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(19,6,19,3,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(20,6,20,4,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(21,6,21,4,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(22,6,22,3,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(23,6,23,4,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(24,6,24,3,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(25,6,25,3,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(26,6,26,3,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(27,6,27,3,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(28,6,28,3,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(29,6,29,2,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(30,6,30,2,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(31,6,31,2,'2026-06-07 00:17:01','2026-06-07 00:17:01'),
(32,6,32,2,'2026-06-07 00:17:01','2026-06-07 00:17:01');

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('ApCV1oA4U2SmpIl4KECerBszBLwMRlKtxwFh4EWu',28,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJoTWMxdTVrU2tkeWxxaW1ZVTFMRkt3VEdXd0VYZ3EyQTg2TXMxY2ZUIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2FkbWluaXN0cmFjaW9uXC9wbGFudGlsbGFzIiwicm91dGUiOiJhZG1pbmlzdHJhY2lvbi5wbGFudGlsbGFzIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyOH0=',1780940231);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT 0,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`es_admin`,`two_factor_secret`,`two_factor_recovery_codes`,`two_factor_confirmed_at`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Gerente General','gerente.general@evaluaciones.test',NULL,'$2y$12$Xj9oxtF/m3bOiydROu938O2rwbIDCEPUht/18dDEfOI76Z43ca/Z6',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:06','2026-06-06 18:48:46'),
(2,'Gerente de Operaciones','gerente.operaciones@evaluaciones.test',NULL,'$2y$12$Rxd3mkDE/IdvkN2KvYnPIugdv7612HVr9qQy2qP2eT.l5jxtdR7m2',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:06','2026-06-06 18:48:47'),
(3,'Jefe de Logística','jefe.logistica@evaluaciones.test',NULL,'$2y$12$Y0WnFlcBx0FZzHqIJmdsh.dwAXY.9qi5.Z5bhOJO96heU3caRrgje',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:07','2026-06-07 03:34:10'),
(4,'Facturación y Cobros','facturacion.cobros@evaluaciones.test',NULL,'$2y$12$7mHKOs8xfZRUmRgccaLXneLMPJrg65RLSOsz57QuIM2lwRfFlqFzq',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:07','2026-06-06 18:48:47'),
(5,'Mensajero','mensajero.facturacion@evaluaciones.test',NULL,'$2y$12$PkBtseMESCRt5Kip1VMFZOxJdgY893/Nyh6ibol4mEDqrrXQegLLa',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:07','2026-06-06 18:48:47'),
(6,'Servicio al cliente z.10','servicio.z10@evaluaciones.test',NULL,'$2y$12$qxUIhnfPJQnUoZeSOaD9BOlnZeqzncFvhBdzuA24Xl8QIyA1AMdZC',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:07','2026-06-06 18:48:47'),
(7,'Servicio al cliente y logística','servicio.logistica@evaluaciones.test',NULL,'$2y$12$BkKTIDqmkfF0cEFa94E/9u8HpFoDjLlE52jKqnZGfDns.dx0pNghi',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:07','2026-06-06 18:48:48'),
(8,'Mensajero','mensajero.logistica@evaluaciones.test',NULL,'$2y$12$J0C4.jImHB3uMhup2yW9iOXxQK.mZ3XLHxuvCy1NQ8fK3Gty7NrIO',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:08','2026-06-06 18:48:48'),
(9,'Encargado de bodega','encargado.bodega@evaluaciones.test',NULL,'$2y$12$hbYJ4AdAFq9rF6AbN3SWUe3eLsLYMwVTUtmGZZwYNM6RMuYt1C4lK',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:08','2026-06-06 18:48:48'),
(10,'Gerente Regional de Ventas','gerente.ventas@evaluaciones.test',NULL,'$2y$12$iiLPd94hOeVj9KHYtkINreGw6gmLranVyEitEZAjZ9Ns2MdYwLLeS',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:08','2026-06-06 18:48:48'),
(11,'Asistente de Ventas','asistente.ventas@evaluaciones.test',NULL,'$2y$12$K0Jw1FnAo9g08lEaJwG1J.jgzm5fic/d0MoSNiPNuLazAYl/WnAgG',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:08','2026-06-06 18:48:48'),
(12,'Product Manager','product.manager@evaluaciones.test',NULL,'$2y$12$2o6N7X5NGK3EUDq3hvZ5o.2ECkGCnDRvkSsV04ff9p6yO5GItWqK.',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:08','2026-06-06 18:48:49'),
(13,'Supervisor de Ventas','supervisor.ventas@evaluaciones.test',NULL,'$2y$12$quH/Ku1khsBFj719goHhW.8v1JXR8x0bJXEvj3ypfCSZA8hME7/6u',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:09','2026-06-06 18:48:49'),
(14,'Asesores Técnicos de Ventas','asesores.ventas@evaluaciones.test',NULL,'$2y$12$44eQO43Wqg.W0w9F08O5H.5V9KtuQPTMfZrtTLrTZAxXpkNtHe.gO',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:09','2026-06-06 18:48:49'),
(15,'Gerente Centro de Soluciones al Cliente','gerente.soluciones@evaluaciones.test',NULL,'$2y$12$H.9xtXCSa9szCHs51Kp0H.7xAc3PsUrQZkHU.aUYte3BE5o/sFQ6O',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:09','2026-06-06 18:48:49'),
(16,'Técnicos de Proyectos','tecnicos.proyectos@evaluaciones.test',NULL,'$2y$12$2j1mypvNrZEb2L9W0QG0oeMl/TxszjeXmBBlzu5U5qVk189QrDn0q',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:09','2026-06-06 18:48:49'),
(17,'Técnicos de Robótica & E-Drives','tecnicos.robotica@evaluaciones.test',NULL,'$2y$12$HhT/hF7pcHs2.VH45GHJsefU8I.ydzuJ.AoF50ojDVsTCsqWZYLHW',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:09','2026-06-06 18:48:50'),
(18,'Técnicos de Servicios','tecnicos.servicios@evaluaciones.test',NULL,'$2y$12$iBsa1k8fhuTE9CSRATtKSuZ.VQVhHgTga0wh/kWvkIS4PH8FApp2G',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:10','2026-06-06 18:48:50'),
(19,'Gerente Administrativa','gerente.administrativa@evaluaciones.test',NULL,'$2y$12$0V8taAm4p1Z7vRA81VPUgeqiMma1058MmXclKDoMcOwEtOvkvuZKS',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:10','2026-06-06 18:48:50'),
(20,'Encargada de Sistemas','encargada.sistemas@evaluaciones.test',NULL,'$2y$12$/jrACsbHPuEa8aYdwkEC8e1yzOU1rtmwmkvtW6u7NdMv2a6WCsppW',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:10','2026-06-06 18:48:50'),
(21,'Técnico de Sistemas','tecnico.sistemas@evaluaciones.test',NULL,'$2y$12$CeinJ6IPAC3NIOYtf2wAXubIKoL7dKQbksrdWZpfdZLzat5LykeGm',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:10','2026-06-06 18:48:50'),
(22,'Asistente de Administración','asistente.administracion@evaluaciones.test',NULL,'$2y$12$2fv8j4WAcWMTfc5v0qxT5ePiWc/HHKwkJQcQeC7q60Tig6v2lMFt2',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:10','2026-06-06 18:48:51'),
(23,'Mensajero','mensajero.administracion@evaluaciones.test',NULL,'$2y$12$bo/XKzAcpEYMbhxgtDN6Wut60DisRAYwR.e7KHmcAG2mCKe5kJrBq',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(24,'Encargada de Limpieza','encargada.limpieza@evaluaciones.test',NULL,'$2y$12$zz6PE5yVo8BGf03Gu1Peiu8jFkC50PB2unBFr0Qj62Kt1z4KkRp3i',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(25,'Contador General','contador.general@evaluaciones.test',NULL,'$2y$12$56.9nN8MuLNdZqqOjdD3jO/OpaAZFgFKjZt/z2IWFkkSA41gn9f1i',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(26,'Auxiliar de Contabilidad I','auxiliar.contabilidad1@evaluaciones.test',NULL,'$2y$12$EPuI6OFNPy.R1mRWEKB55eVVOa5tnZj0AF68RBFQkz/9WNE4ls34m',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(27,'Auxiliar de Contabilidad II','auxiliar.contabilidad2@evaluaciones.test',NULL,'$2y$12$.Cf2xBprtNW.AKRk6iPRDOqrzlYLWAaOpvxC8ClxJn6nTmjyU28JC',0,NULL,NULL,NULL,NULL,'2026-06-06 18:41:11','2026-06-06 18:48:51'),
(28,'Encargada de Recursos Humanos','recursos.humanos@evaluaciones.test',NULL,'$2y$12$CRPS62Kbk1nBX0AhAXOOPOVRIgdU73EBrrATr2NQTzhVaeq.Qix5S',1,NULL,NULL,NULL,NULL,'2026-06-06 18:41:12','2026-06-07 03:33:15');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
