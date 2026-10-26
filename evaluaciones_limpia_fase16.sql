-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: evaluaciones
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backup_fase16_dimensiones`
--

DROP TABLE IF EXISTS `backup_fase16_dimensiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_fase16_dimensiones` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `plantilla_id` bigint(20) unsigned NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `factor` varchar(200) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 1,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_fase16_dimensiones`
--

LOCK TABLES `backup_fase16_dimensiones` WRITE;
/*!40000 ALTER TABLE `backup_fase16_dimensiones` DISABLE KEYS */;
INSERT INTO `backup_fase16_dimensiones` VALUES (1,1,'Desempeño orientado a resultados','Cumplimiento de metas y objetivos',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(2,1,'Desempeño conductual','Liderazgo y gestión organizacional',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(3,1,'Desempeño basado en competencias','Competencias gerenciales',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(4,1,'Desempeño contextual','Contribución organizacional',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(5,2,'Comunicación y relación con el equipo',NULL,1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(6,2,'Liderazgo y gestión del equipo',NULL,2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(7,2,'Apoyo y desarrollo del colaborador',NULL,3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(8,2,'Compromiso y gestión organizacional',NULL,4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(9,3,'Comunicación y relación con el equipo',NULL,1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(10,3,'Liderazgo y gestión del equipo',NULL,2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(11,3,'Apoyo y desarrollo del colaborador',NULL,3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(12,3,'Compromiso y gestión organizacional',NULL,4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(13,4,'DESEMPEÑO ORIENTADO A RESULTADOS','Cumplimiento de metas y objetivos',1,1,'2026-06-13 02:14:51','2026-06-13 04:03:51'),(14,4,'DESEMPEÑO CONDUCTUAL','Organización y cumplimiento de procedimientos',2,1,'2026-06-13 02:15:33','2026-06-13 04:04:30'),(15,4,'DESEMPEÑO BASADO EN COMPETENCIAS','Competencias técnicas',3,1,'2026-06-13 02:16:32','2026-06-13 06:08:01'),(16,4,'DESEMPEÑO CONTEXTUAL','Trabajo en equipo y proactividad',4,1,'2026-06-13 02:17:01','2026-06-13 06:08:28'),(17,5,'DESEMPEÑO ORIENTADO A RESULTADOS','Cumplimiento de metas y objetivos',1,1,'2026-06-13 02:45:54','2026-06-13 09:24:30'),(18,5,'DESEMPEÑO CONDUCTUAL','Organización y planificación del trabajo',2,1,'2026-06-13 02:46:23','2026-06-13 05:13:20'),(19,5,'DESEMPEÑO BASADO EN COMPETENCIAS','Conocimientos técnicos y profesionales',3,1,'2026-06-13 02:55:10','2026-06-13 05:13:39'),(20,5,'DESEMPEÑO CONTEXTUAL','Trabajo en equipo y colaboración',4,1,'2026-06-13 02:55:27','2026-06-13 05:13:57'),(21,6,'COMUNICACIÓN Y RELACIÓN CON EL EQUIPO',NULL,1,1,'2026-06-13 03:07:49','2026-06-13 09:31:28'),(22,6,'LIDERAZGO Y GESTIÓN DEL EQUIPO',NULL,2,1,'2026-06-13 03:08:29','2026-06-13 09:32:07'),(23,6,'APOYO Y DESARROLLO DEL COLABORADOR',NULL,3,1,'2026-06-13 03:08:57','2026-06-13 09:32:36'),(24,6,'COMPROMISO Y GESTIÓN ORGANIZACIONAL',NULL,4,1,'2026-06-13 03:09:32','2026-06-13 09:33:30'),(26,7,'LIDERAZGO','Dirección del equipo',1,1,'2026-06-14 02:17:08','2026-06-14 02:17:08'),(27,7,'COMUNICACIÓN Y RELACIONAMIENTO','Comunicación organizacional',2,1,'2026-06-14 02:17:35','2026-06-14 02:17:35'),(28,7,'GESTIÓN DEL TALENTO','Desarrollo de colaboradores',3,1,'2026-06-14 02:18:19','2026-06-14 02:18:19'),(29,7,'TOMA DE DECISIONES Y GESTIÓN','Gestión Gerencial',4,1,'2026-06-14 02:18:45','2026-06-14 02:18:45'),(30,7,'CLIMA ORGANIZACIONAL','Ambiente de trabajo',5,1,'2026-06-14 02:19:14','2026-06-14 02:19:14');
/*!40000 ALTER TABLE `backup_fase16_dimensiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_fase16_evaluaciones`
--

DROP TABLE IF EXISTS `backup_fase16_evaluaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_fase16_evaluaciones` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `empleado_evaluador_id` bigint(20) unsigned NOT NULL,
  `empleado_evaluado_id` bigint(20) unsigned NOT NULL,
  `plantilla_id` bigint(20) unsigned NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente',
  `fecha_finalizacion` timestamp NULL DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_fase16_evaluaciones`
--

LOCK TABLES `backup_fase16_evaluaciones` WRITE;
/*!40000 ALTER TABLE `backup_fase16_evaluaciones` DISABLE KEYS */;
INSERT INTO `backup_fase16_evaluaciones` VALUES (1,1,2,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(2,2,1,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(3,2,3,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(4,3,2,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(5,3,4,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(6,4,3,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(7,4,5,3,'finalizada','2026-06-10 05:15:24','Se finalizo la evaluacion','2026-06-10 01:24:40','2026-06-10 05:15:24'),(8,5,4,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(9,3,6,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(10,6,3,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(11,3,7,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(12,7,3,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(13,7,8,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(14,8,7,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(15,3,9,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(16,9,3,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(17,1,10,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(18,10,1,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(19,10,11,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(20,11,10,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(21,10,12,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(22,12,10,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(23,10,13,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(24,13,10,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(25,13,14,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(26,14,13,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(27,1,15,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(28,15,1,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(29,15,16,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(30,16,15,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(31,15,17,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(32,17,15,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(33,15,18,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(34,18,15,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(35,1,19,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(36,19,1,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(37,19,20,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(38,20,19,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(39,20,21,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(40,21,20,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(41,19,22,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(42,22,19,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(43,19,23,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(44,23,19,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(45,19,24,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(46,24,19,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(47,1,25,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(48,25,1,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(49,25,26,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(50,26,25,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(51,25,27,3,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(52,27,25,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(53,1,28,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(54,28,1,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40');
/*!40000 ALTER TABLE `backup_fase16_evaluaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_fase16_plantillas`
--

DROP TABLE IF EXISTS `backup_fase16_plantillas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_fase16_plantillas` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_fase16_plantillas`
--

LOCK TABLES `backup_fase16_plantillas` WRITE;
/*!40000 ALTER TABLE `backup_fase16_plantillas` DISABLE KEYS */;
INSERT INTO `backup_fase16_plantillas` VALUES (1,'GER','Plantilla para gerentes','Evaluación del desempeño para puestos gerenciales.',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(2,'MM','Plantilla para mandos medios','Evaluación del desempeño para jefaturas y mandos medios.',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(3,'OPE','Plantilla para personal operativo','Evaluación del desempeño para personal operativo.',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(4,'OPT','OPERATIVOS TÉCNICOS','La presente evaluación tiene como objetivo valorar el desempeño del colaborador en función de las responsabilidades y competencias requeridas para su puesto de trabajo.',1,'2026-06-13 02:13:57','2026-06-13 09:21:26'),(5,'OPA','OPERATIVOS ADMINISTRATIVOS','La presente evaluación tiene como objetivo valorar el desempeño del colaborador en función de las responsabilidades y competencias requeridas para su puesto de trabajo.',1,'2026-06-13 02:35:37','2026-06-13 09:23:27'),(6,'LIDERMM','EVALUACIÓN ASCENDENTE PARA LIDERAZGO MANDOS MEDIOS','La presente evaluación tiene como objetivo conocer la percepción de los colaboradores sobre el liderazgo, comunicación, apoyo y gestión de sus jefes inmediatos, con el fin de identificar fortalezas y oportunidades de mejora en la gestión de equipos.',1,'2026-06-13 03:06:48','2026-06-14 03:28:02'),(7,'LIDERGER','EVALUACIÓN ASCENDENDE PARA GERENTES','La presente evaluación tiene como objetivo recopilar la percepción de los mandos medios respecto al liderazgo, comunicación, gestión y contribución organizacional de las gerencias. La información será utilizada para fortalecer los procesos de mejora continua y desarrollo del liderazgo.',1,'2026-06-14 02:15:48','2026-06-14 02:15:48');
/*!40000 ALTER TABLE `backup_fase16_plantillas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_fase16_preguntas`
--

DROP TABLE IF EXISTS `backup_fase16_preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_fase16_preguntas` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `dimension_id` bigint(20) unsigned NOT NULL,
  `texto` text NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 1,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_fase16_preguntas`
--

LOCK TABLES `backup_fase16_preguntas` WRITE;
/*!40000 ALTER TABLE `backup_fase16_preguntas` DISABLE KEYS */;
INSERT INTO `backup_fase16_preguntas` VALUES (1,1,'Cumple las metas comerciales y operativas establecidas para su área.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(2,1,'Da seguimiento oportuno a indicadores y resultados del área bajo su responsabilidad.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(3,1,'Implementa acciones correctivas cuando identifica desviaciones en los resultados esperados.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(4,1,'Prioriza actividades alineadas a los objetivos estratégicos de la empresa.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(5,2,'Coordina y supervisa efectivamente las actividades de su equipo de trabajo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(6,2,'Mantiene comunicación clara y oportuna con colaboradores y otras áreas.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(7,2,'Toma decisiones oportunas ante situaciones operativas o estratégicas.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(8,2,'Promueve el cumplimiento de políticas y lineamientos organizacionales.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(9,3,'Demuestra capacidad de análisis para la toma de decisiones estratégicas.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(10,3,'Gestiona eficientemente recursos financieros, comerciales y operativos.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(11,3,'Desarrolla estrategias orientadas al crecimiento y rentabilidad del negocio.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(12,3,'Demuestra conocimiento técnico y organizacional requerido para el puesto.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(13,4,'Promueve el trabajo colaborativo entre áreas y equipos de trabajo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(14,4,'Propone mejoras para optimizar procesos y resultados organizacionales.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(15,4,'Mantiene disposición para adaptarse a cambios y nuevos retos organizacionales.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(16,4,'Contribuye al fortalecimiento del clima organizacional y desarrollo del personal.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(17,5,'Comunica instrucciones y expectativas de manera clara.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(18,5,'Escucha las opiniones y sugerencias del equipo.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(19,5,'Mantiene una comunicación respetuosa y profesional.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(20,5,'Brinda retroalimentación oportuna sobre el trabajo realizado.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(21,6,'Organiza adecuadamente el trabajo del equipo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(22,6,'Da seguimiento a las actividades y responsabilidades del área.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(23,6,'Apoya al equipo cuando se presentan dificultades laborales.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(24,6,'Promueve un ambiente de trabajo colaborativo y respetuoso.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(25,7,'Brinda orientación cuando se requiere apoyo en el trabajo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(26,7,'Promueve el aprendizaje y desarrollo del equipo.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(27,7,'Reconoce el esfuerzo y desempeño de los colaboradores.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(28,7,'Mantiene disposición para resolver dudas o problemas.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(29,8,'Actúa de forma alineada a los valores de la organización.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(30,8,'Toma decisiones de manera justa y objetiva.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(31,8,'Mantiene una actitud positiva y orientada a resultados.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(32,8,'Promueve el cumplimiento de objetivos y responsabilidades.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(33,9,'Comunica instrucciones y expectativas de manera clara.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(34,9,'Escucha las opiniones y sugerencias del equipo.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(35,9,'Mantiene una comunicación respetuosa y profesional.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(36,9,'Brinda retroalimentación oportuna sobre el trabajo realizado.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(37,10,'Organiza adecuadamente el trabajo del equipo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(38,10,'Da seguimiento a las actividades y responsabilidades del área.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(39,10,'Apoya al equipo cuando se presentan dificultades laborales.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(40,10,'Promueve un ambiente de trabajo colaborativo y respetuoso.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(41,11,'Brinda orientación cuando se requiere apoyo en el trabajo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(42,11,'Promueve el aprendizaje y desarrollo del equipo.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(43,11,'Reconoce el esfuerzo y desempeño de los colaboradores.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(44,11,'Mantiene disposición para resolver dudas o problemas.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(45,12,'Actúa de forma alineada a los valores de la organización.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(46,12,'Toma decisiones de manera justa y objetiva.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(47,12,'Mantiene una actitud positiva y orientada a resultados.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(48,12,'Promueve el cumplimiento de objetivos y responsabilidades.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(49,13,'Cumple con los servicios técnicos asignados dentro del tiempo establecido.',1,1,'2026-06-13 02:18:00','2026-06-13 04:05:58'),(50,13,'Ejecuta mantenimientos y servicios conforme a los requerimientos del cliente.',2,1,'2026-06-13 02:18:22','2026-06-13 04:06:17'),(51,13,'Cumple con los estándares de calidad establecidos en los servicios realizados.',3,1,'2026-06-13 02:18:40','2026-06-13 04:06:51'),(52,13,'Cumple oportunamente con los requerimientos técnicos y actividades asignadas, manteniendo la calidad esperada en los resultados.',4,1,'2026-06-13 02:18:59','2026-06-13 06:09:23'),(53,14,'Sigue los procedimientos y lineamientos técnicos establecidos por la empresa.',1,1,'2026-06-13 02:19:48','2026-06-13 04:08:51'),(54,14,'Mantiene orden y organización en la ejecución de sus actividades.',2,1,'2026-06-13 02:20:07','2026-06-13 04:09:08'),(55,14,'Cumple con las normas de seguridad industrial durante la ejecución de servicios.',3,1,'2026-06-13 02:20:24','2026-06-13 04:09:37'),(56,14,'Mantiene una actitud de servicio y colaboración durante la atención de requerimientos internos y externos.',4,1,'2026-06-13 02:20:44','2026-06-13 06:10:40'),(57,15,'Demuestra dominio técnico en instalación y mantenimiento de equipos industriales.',1,1,'2026-06-13 02:21:17','2026-06-13 04:10:21'),(58,15,'Diagnostica y resuelve fallas técnicas de manera efectiva.',2,1,'2026-06-13 02:21:32','2026-06-13 04:10:40'),(59,15,'Utiliza adecuadamente herramientas y equipos técnicos asignados.',3,1,'2026-06-13 02:21:50','2026-06-13 04:10:59'),(60,15,'Aplica de manera efectiva sus conocimientos técnicos para resolver situaciones relacionadas con su área de trabajo.',4,1,'2026-06-13 02:22:08','2026-06-13 06:11:39'),(61,16,'Colabora con compañeros y áreas relacionadas cuando es necesario.',1,1,'2026-06-13 02:22:33','2026-06-13 04:11:48'),(62,16,'Mantiene disposición para apoyar actividades adicionales del área.',2,1,'2026-06-13 02:22:51','2026-06-13 04:12:09'),(63,16,'Propone mejoras o soluciones ante problemas técnicos identificados.',3,1,'2026-06-13 02:23:08','2026-06-13 04:12:30'),(64,16,'Contribuye activamente a la coordinación y comunicación con otras áreas para facilitar el cumplimiento de los objetivos organizacionales.',4,1,'2026-06-13 02:23:24','2026-06-13 06:12:27'),(65,17,'Cumple con las actividades y responsabilidades asignadas dentro del período evaluado.',1,1,'2026-06-13 02:55:45','2026-06-13 05:15:28'),(66,17,'Mantiene un nivel constante de cumplimiento en sus funciones.',2,1,'2026-06-13 02:56:03','2026-06-13 05:15:52'),(67,17,'Da seguimiento oportuno a tareas pendientes hasta su finalización.',3,1,'2026-06-13 02:56:19','2026-06-13 05:16:14'),(68,17,'Ajusta prioridades cuando identifica retrasos o desviaciones en el trabajo.',4,1,'2026-06-13 02:56:34','2026-06-13 05:17:03'),(69,18,'Prioriza tareas según la urgencia y objetivos del área.',1,1,'2026-06-13 02:57:07','2026-06-13 06:02:30'),(70,18,'Mantiene orden y control en la información y procesos a su cargo.',2,1,'2026-06-13 02:57:21','2026-06-13 06:02:48'),(71,18,'Gestiona el tiempo de manera eficiente para cumplir responsabilidades.',3,1,'2026-06-13 02:57:37','2026-06-13 06:03:06'),(72,18,'Asume responsabilidad por los resultados de su trabajo.',4,1,'2026-06-13 02:57:52','2026-06-13 06:03:23'),(73,19,'Demuestra dominio técnico requerido para el puesto.',1,1,'2026-06-13 02:58:10','2026-06-13 06:04:02'),(74,19,'Aplica correctamente herramientas, procesos y sistemas del área.',2,1,'2026-06-13 02:58:31','2026-06-13 06:04:21'),(75,19,'Analiza información antes de tomar decisiones relacionadas con su trabajo.',3,1,'2026-06-13 02:58:46','2026-06-13 06:04:41'),(76,19,'Da seguimiento adecuado a situaciones pendientes hasta resolverlas.',4,1,'2026-06-13 02:59:03','2026-06-13 06:05:05'),(77,20,'Coopera activamente con compañeros para cumplir objetivos comunes.',1,1,'2026-06-13 02:59:32','2026-06-13 06:05:41'),(78,20,'Comparte información relevante que facilita el trabajo del equipo.',2,1,'2026-06-13 02:59:47','2026-06-13 06:05:59'),(79,20,'Mantiene relaciones laborales respetuosas y colaborativas.',3,1,'2026-06-13 03:00:05','2026-06-13 06:06:17'),(80,20,'Propone mejoras en procesos o actividades de trabajo.',4,1,'2026-06-13 03:00:27','2026-06-13 06:06:35'),(81,21,'Comunica instrucciones y expectativas de manera clara.',1,1,'2026-06-13 03:10:36','2026-06-13 10:02:54'),(82,21,'Escucha las opiniones y sugerencias del equipo.',2,1,'2026-06-13 03:10:53','2026-06-13 10:03:18'),(83,21,'Mantiene una comunicación respetuosa y profesional.',3,1,'2026-06-13 03:11:10','2026-06-13 10:03:34'),(84,21,'Brinda retroalimentación oportuna sobre el trabajo realizado.',4,1,'2026-06-13 03:11:26','2026-06-13 10:03:53'),(85,22,'Organiza adecuadamente el trabajo del equipo.',1,1,'2026-06-13 03:11:54','2026-06-13 10:04:55'),(86,22,'Da seguimiento a las actividades y responsabilidades del área.',2,1,'2026-06-13 03:12:10','2026-06-13 10:05:11'),(87,22,'Apoya al equipo cuando se presentan dificultades laborales.',3,1,'2026-06-13 03:12:28','2026-06-13 10:05:29'),(88,22,'Promueve un ambiente de trabajo colaborativo y respetuoso.',4,1,'2026-06-13 03:12:46','2026-06-13 10:05:46'),(89,23,'Brinda orientación cuando se requiere apoyo en el trabajo.',1,1,'2026-06-13 03:13:07','2026-06-13 10:06:28'),(90,23,'Promueve el aprendizaje y desarrollo del equipo.',2,1,'2026-06-13 03:13:24','2026-06-13 10:06:47'),(91,23,'Reconoce el esfuerzo y desempeño de los colaboradores.',3,1,'2026-06-13 03:13:40','2026-06-13 10:07:43'),(92,23,'Mantiene disposición para resolver dudas o problemas.',4,1,'2026-06-13 03:13:57','2026-06-13 10:08:01'),(93,24,'Actúa de forma alineada a los valores de la organización.',1,1,'2026-06-13 03:14:23','2026-06-13 10:08:25'),(94,24,'Toma decisiones de manera justa y objetiva.',2,1,'2026-06-13 03:14:51','2026-06-13 10:08:57'),(95,24,'Mantiene una actitud positiva y orientada a resultados.',3,1,'2026-06-13 03:15:06','2026-06-13 10:09:12'),(96,24,'Promueve el cumplimiento de objetivos y responsabilidades.',4,1,'2026-06-13 03:15:23','2026-06-13 10:09:30'),(101,26,'Comunica claramente los objetivos y prioridades del área.',1,1,'2026-06-14 02:48:58','2026-06-14 02:48:58'),(102,26,'Proporciona orientación cuando se presentan dificultades.',2,1,'2026-06-14 02:49:28','2026-06-14 02:49:28'),(103,26,'Delega responsabilidades de manera adecuada.',3,1,'2026-06-14 03:09:43','2026-06-14 03:09:43'),(104,26,'Promueve la participación del equipo en la toma de decisiones.',4,1,'2026-06-14 03:10:04','2026-06-14 03:10:04'),(105,27,'Mantiene una comunicación abierta y respetuosa.',1,1,'2026-06-14 03:10:27','2026-06-14 03:10:27'),(106,27,'Escucha las opiniones y sugerencias de los colaboradores.',2,1,'2026-06-14 03:10:41','2026-06-14 03:10:41'),(107,27,'Comparte información relevante de forma oportuna.',3,1,'2026-06-14 03:10:57','2026-06-14 03:10:57'),(108,27,'Facilita la coordinación entre áreas.',4,1,'2026-06-14 03:11:12','2026-06-14 03:11:12'),(109,28,'Brinda retroalimentación oportuna sobre el desempeño.',1,1,'2026-06-14 03:11:33','2026-06-14 03:11:33'),(110,28,'Reconoce los logros y contribuciones del equipo.',2,1,'2026-06-14 03:11:50','2026-06-14 03:11:50'),(111,28,'Apoya el desarrollo profesional de los colaboradores.',3,1,'2026-06-14 03:12:05','2026-06-14 03:12:05'),(112,28,'Promueve un ambiente de respeto y confianza.',4,1,'2026-06-14 03:12:19','2026-06-14 03:12:19'),(113,29,'Toma decisiones oportunas y fundamentadas.',1,1,'2026-06-14 03:12:38','2026-06-14 03:12:38'),(114,29,'Resuelve conflictos de manera objetiva.',2,1,'2026-06-14 03:12:53','2026-06-14 03:12:53'),(115,29,'Da seguimiento a los compromisos adquiridos.',3,1,'2026-06-14 03:13:09','2026-06-14 03:13:09'),(116,29,'Actúa con coherencia entre lo que comunica y lo que ejecuta.',4,1,'2026-06-14 03:13:30','2026-06-14 03:13:30'),(117,30,'Fomenta el trabajo en equipo.',1,1,'2026-06-14 03:13:53','2026-06-14 03:13:53'),(118,30,'Promueve relaciones laborales respetuosas.',2,1,'2026-06-14 03:14:10','2026-06-14 03:14:10'),(119,30,'Maneja adecuadamente situaciones de presión.',3,1,'2026-06-14 03:14:29','2026-06-14 03:14:29'),(120,30,'Contribuye a mantener un ambiente laboral positivo.',4,1,'2026-06-14 03:14:45','2026-06-14 03:14:45');
/*!40000 ALTER TABLE `backup_fase16_preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_fase16_respuestas`
--

DROP TABLE IF EXISTS `backup_fase16_respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_fase16_respuestas` (
  `id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `evaluacion_id` bigint(20) unsigned NOT NULL,
  `pregunta_id` bigint(20) unsigned NOT NULL,
  `calificacion` tinyint(3) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_fase16_respuestas`
--

LOCK TABLES `backup_fase16_respuestas` WRITE;
/*!40000 ALTER TABLE `backup_fase16_respuestas` DISABLE KEYS */;
INSERT INTO `backup_fase16_respuestas` VALUES (1,7,33,3,'2026-06-10 05:12:03','2026-06-10 05:12:03'),(2,7,34,3,'2026-06-10 05:12:03','2026-06-10 05:12:03'),(3,7,35,3,'2026-06-10 05:12:03','2026-06-10 05:12:03'),(4,7,36,3,'2026-06-10 05:12:03','2026-06-10 05:12:03'),(5,7,37,3,'2026-06-10 05:12:03','2026-06-10 05:12:03'),(6,7,38,2,'2026-06-10 05:12:03','2026-06-10 05:12:03'),(7,7,39,2,'2026-06-10 05:12:03','2026-06-10 05:12:03'),(8,7,40,2,'2026-06-10 05:12:03','2026-06-10 05:12:03'),(9,7,41,3,'2026-06-10 05:15:24','2026-06-10 05:15:24'),(10,7,42,3,'2026-06-10 05:15:24','2026-06-10 05:15:24'),(11,7,43,4,'2026-06-10 05:15:24','2026-06-10 05:15:24'),(12,7,44,4,'2026-06-10 05:15:24','2026-06-10 05:15:24'),(13,7,45,4,'2026-06-10 05:15:24','2026-06-10 05:15:24'),(14,7,46,4,'2026-06-10 05:15:24','2026-06-10 05:15:24'),(15,7,47,3,'2026-06-10 05:15:24','2026-06-10 05:15:24'),(16,7,48,4,'2026-06-10 05:15:24','2026-06-10 05:15:24');
/*!40000 ALTER TABLE `backup_fase16_respuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dimensiones`
--

DROP TABLE IF EXISTS `dimensiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dimensiones`
--

LOCK TABLES `dimensiones` WRITE;
/*!40000 ALTER TABLE `dimensiones` DISABLE KEYS */;
INSERT INTO `dimensiones` VALUES (1,1,'Desempeño orientado a resultados','Cumplimiento de metas y objetivos',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(2,1,'Desempeño conductual','Liderazgo y gestión organizacional',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(3,1,'Desempeño basado en competencias','Competencias gerenciales',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(4,1,'Desempeño contextual','Contribución organizacional',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(5,2,'Comunicación y relación con el equipo',NULL,1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(6,2,'Liderazgo y gestión del equipo',NULL,2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(7,2,'Apoyo y desarrollo del colaborador',NULL,3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(8,2,'Compromiso y gestión organizacional',NULL,4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(13,4,'DESEMPEÑO ORIENTADO A RESULTADOS','Cumplimiento de metas y objetivos',1,1,'2026-06-13 02:14:51','2026-06-13 04:03:51'),(14,4,'DESEMPEÑO CONDUCTUAL','Organización y cumplimiento de procedimientos',2,1,'2026-06-13 02:15:33','2026-06-13 04:04:30'),(15,4,'DESEMPEÑO BASADO EN COMPETENCIAS','Competencias técnicas',3,1,'2026-06-13 02:16:32','2026-06-13 06:08:01'),(16,4,'DESEMPEÑO CONTEXTUAL','Trabajo en equipo y proactividad',4,1,'2026-06-13 02:17:01','2026-06-13 06:08:28'),(17,5,'DESEMPEÑO ORIENTADO A RESULTADOS','Cumplimiento de metas y objetivos',1,1,'2026-06-13 02:45:54','2026-06-13 09:24:30'),(18,5,'DESEMPEÑO CONDUCTUAL','Organización y planificación del trabajo',2,1,'2026-06-13 02:46:23','2026-06-13 05:13:20'),(19,5,'DESEMPEÑO BASADO EN COMPETENCIAS','Conocimientos técnicos y profesionales',3,1,'2026-06-13 02:55:10','2026-06-13 05:13:39'),(20,5,'DESEMPEÑO CONTEXTUAL','Trabajo en equipo y colaboración',4,1,'2026-06-13 02:55:27','2026-06-13 05:13:57'),(21,6,'COMUNICACIÓN Y RELACIÓN CON EL EQUIPO',NULL,1,1,'2026-06-13 03:07:49','2026-06-13 09:31:28'),(22,6,'LIDERAZGO Y GESTIÓN DEL EQUIPO',NULL,2,1,'2026-06-13 03:08:29','2026-06-13 09:32:07'),(23,6,'APOYO Y DESARROLLO DEL COLABORADOR',NULL,3,1,'2026-06-13 03:08:57','2026-06-13 09:32:36'),(24,6,'COMPROMISO Y GESTIÓN ORGANIZACIONAL',NULL,4,1,'2026-06-13 03:09:32','2026-06-13 09:33:30'),(26,7,'LIDERAZGO','Dirección del equipo',1,1,'2026-06-14 02:17:08','2026-06-14 02:17:08'),(27,7,'COMUNICACIÓN Y RELACIONAMIENTO','Comunicación organizacional',2,1,'2026-06-14 02:17:35','2026-06-14 02:17:35'),(28,7,'GESTIÓN DEL TALENTO','Desarrollo de colaboradores',3,1,'2026-06-14 02:18:19','2026-06-14 02:18:19'),(29,7,'TOMA DE DECISIONES Y GESTIÓN','Gestión Gerencial',4,1,'2026-06-14 02:18:45','2026-06-14 02:18:45'),(30,7,'CLIMA ORGANIZACIONAL','Ambiente de trabajo',5,1,'2026-06-14 02:19:14','2026-06-14 02:19:14');
/*!40000 ALTER TABLE `dimensiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES (1,1,1,NULL,1,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(2,2,2,1,1,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(3,3,3,2,1,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(4,4,4,3,1,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(5,5,5,4,1,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(6,6,6,3,1,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(7,7,7,3,1,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(8,8,8,7,1,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(9,9,9,3,1,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(10,10,10,1,1,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(12,12,12,10,1,'2026-06-10 01:24:37','2026-06-10 01:24:37'),(13,13,13,10,1,'2026-06-10 01:24:37','2026-06-10 01:24:37'),(14,14,14,13,1,'2026-06-10 01:24:37','2026-06-10 01:24:37'),(15,15,15,1,1,'2026-06-10 01:24:37','2026-06-10 01:24:37'),(16,16,16,15,1,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(17,17,17,15,1,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(18,18,18,15,1,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(19,19,19,1,1,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(20,20,20,19,1,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(21,21,21,20,1,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(22,22,22,19,1,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(23,23,23,19,1,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(24,24,24,19,1,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(25,25,25,1,1,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(26,26,26,25,1,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(27,27,27,25,1,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(28,28,28,1,1,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(29,29,32,10,1,'2026-06-15 03:33:24','2026-06-15 03:33:56'),(30,30,29,1,1,'2026-06-15 04:27:46','2026-06-15 04:27:46'),(31,31,30,3,1,'2026-06-15 04:35:45','2026-06-15 04:35:45'),(32,32,31,3,1,'2026-06-15 04:36:58','2026-06-15 04:36:58');
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluaciones`
--

DROP TABLE IF EXISTS `evaluaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluaciones`
--

LOCK TABLES `evaluaciones` WRITE;
/*!40000 ALTER TABLE `evaluaciones` DISABLE KEYS */;
INSERT INTO `evaluaciones` VALUES (1,1,2,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(2,2,1,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(3,2,3,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(4,3,2,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(6,4,3,6,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(10,6,3,6,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(12,7,3,6,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(16,9,3,6,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(17,1,10,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(18,10,1,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(21,10,12,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(22,12,10,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(23,10,13,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(24,13,10,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(26,14,13,6,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(27,1,15,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(28,15,1,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(30,16,15,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(32,17,15,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(34,18,15,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(35,1,19,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(36,19,1,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(37,19,20,2,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(38,20,19,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(40,21,20,6,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(42,22,19,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(44,23,19,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(46,24,19,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(47,1,25,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(48,25,1,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(50,26,25,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(52,27,25,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-15 05:37:13'),(53,1,28,1,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(54,28,1,7,'pendiente',NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(55,3,4,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(56,4,5,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(57,5,4,6,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(58,3,6,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(59,3,7,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(60,7,8,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(61,8,7,6,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(62,3,9,2,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(63,13,14,4,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(64,15,16,4,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(65,15,17,4,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(66,15,18,4,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(67,20,21,4,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(68,19,22,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(69,19,23,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(70,19,24,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(71,25,26,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(72,25,27,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(73,30,1,7,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(74,1,30,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(75,10,29,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(76,3,31,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13'),(77,3,32,5,'pendiente',NULL,NULL,'2026-06-15 05:37:13','2026-06-15 05:37:13');
/*!40000 ALTER TABLE `evaluaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_01_01_000000_create_passkeys_table',1),(5,'2025_08_14_170933_add_two_factor_columns_to_users_table',1),(6,'2026_06_06_165539_create_plantillas_table',1),(7,'2026_06_06_165804_create_dimensions_table',1),(8,'2026_06_06_170914_create_preguntas_table',1),(9,'2026_06_06_171133_create_puestos_table',1),(10,'2026_06_06_171446_create_empleados_table',1),(11,'2026_06_06_172440_create_relacion_puestos_table',1),(12,'2026_06_06_173038_create_evaluacions_table',1),(13,'2026_06_06_173948_create_respuestas_table',1),(14,'2026_06_06_175450_agregar_factor_a_dimensiones_table',1),(15,'2026_06_06_193058_agregar_observaciones_a_evaluaciones_table',1),(16,'2026_06_07_025643_agregar_es_admin_a_users_table',1),(17,'2026_06_14_184846_agregar_plantilla_y_tipo_relacion_a_relaciones_puestos_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passkeys`
--

DROP TABLE IF EXISTS `passkeys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passkeys`
--

LOCK TABLES `passkeys` WRITE;
/*!40000 ALTER TABLE `passkeys` DISABLE KEYS */;
/*!40000 ALTER TABLE `passkeys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plantillas`
--

DROP TABLE IF EXISTS `plantillas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plantillas`
--

LOCK TABLES `plantillas` WRITE;
/*!40000 ALTER TABLE `plantillas` DISABLE KEYS */;
INSERT INTO `plantillas` VALUES (1,'GER','Plantilla para gerentes','Evaluación del desempeño para puestos gerenciales.',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(2,'MM','Plantilla para mandos medios','Evaluación del desempeño para jefaturas y mandos medios.',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(4,'OPT','OPERATIVOS TÉCNICOS','La presente evaluación tiene como objetivo valorar el desempeño del colaborador en función de las responsabilidades y competencias requeridas para su puesto de trabajo.',1,'2026-06-13 02:13:57','2026-06-13 09:21:26'),(5,'OPA','OPERATIVOS ADMINISTRATIVOS','La presente evaluación tiene como objetivo valorar el desempeño del colaborador en función de las responsabilidades y competencias requeridas para su puesto de trabajo.',1,'2026-06-13 02:35:37','2026-06-13 09:23:27'),(6,'LIDERMM','EVALUACIÓN ASCENDENTE PARA LIDERAZGO MANDOS MEDIOS','La presente evaluación tiene como objetivo conocer la percepción de los colaboradores sobre el liderazgo, comunicación, apoyo y gestión de sus jefes inmediatos, con el fin de identificar fortalezas y oportunidades de mejora en la gestión de equipos.',1,'2026-06-13 03:06:48','2026-06-14 03:28:02'),(7,'LIDERGER','EVALUACIÓN ASCENDENDE PARA GERENTES','La presente evaluación tiene como objetivo recopilar la percepción de los mandos medios respecto al liderazgo, comunicación, gestión y contribución organizacional de las gerencias. La información será utilizada para fortalecer los procesos de mejora continua y desarrollo del liderazgo.',1,'2026-06-14 02:15:48','2026-06-14 02:15:48');
/*!40000 ALTER TABLE `plantillas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas`
--

LOCK TABLES `preguntas` WRITE;
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
INSERT INTO `preguntas` VALUES (1,1,'Cumple las metas comerciales y operativas establecidas para su área.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(2,1,'Da seguimiento oportuno a indicadores y resultados del área bajo su responsabilidad.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(3,1,'Implementa acciones correctivas cuando identifica desviaciones en los resultados esperados.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(4,1,'Prioriza actividades alineadas a los objetivos estratégicos de la empresa.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(5,2,'Coordina y supervisa efectivamente las actividades de su equipo de trabajo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(6,2,'Mantiene comunicación clara y oportuna con colaboradores y otras áreas.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(7,2,'Toma decisiones oportunas ante situaciones operativas o estratégicas.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(8,2,'Promueve el cumplimiento de políticas y lineamientos organizacionales.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(9,3,'Demuestra capacidad de análisis para la toma de decisiones estratégicas.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(10,3,'Gestiona eficientemente recursos financieros, comerciales y operativos.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(11,3,'Desarrolla estrategias orientadas al crecimiento y rentabilidad del negocio.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(12,3,'Demuestra conocimiento técnico y organizacional requerido para el puesto.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(13,4,'Promueve el trabajo colaborativo entre áreas y equipos de trabajo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(14,4,'Propone mejoras para optimizar procesos y resultados organizacionales.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(15,4,'Mantiene disposición para adaptarse a cambios y nuevos retos organizacionales.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(16,4,'Contribuye al fortalecimiento del clima organizacional y desarrollo del personal.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(17,5,'Comunica instrucciones y expectativas de manera clara.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(18,5,'Escucha las opiniones y sugerencias del equipo.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(19,5,'Mantiene una comunicación respetuosa y profesional.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(20,5,'Brinda retroalimentación oportuna sobre el trabajo realizado.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(21,6,'Organiza adecuadamente el trabajo del equipo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(22,6,'Da seguimiento a las actividades y responsabilidades del área.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(23,6,'Apoya al equipo cuando se presentan dificultades laborales.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(24,6,'Promueve un ambiente de trabajo colaborativo y respetuoso.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(25,7,'Brinda orientación cuando se requiere apoyo en el trabajo.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(26,7,'Promueve el aprendizaje y desarrollo del equipo.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(27,7,'Reconoce el esfuerzo y desempeño de los colaboradores.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(28,7,'Mantiene disposición para resolver dudas o problemas.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(29,8,'Actúa de forma alineada a los valores de la organización.',1,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(30,8,'Toma decisiones de manera justa y objetiva.',2,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(31,8,'Mantiene una actitud positiva y orientada a resultados.',3,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(32,8,'Promueve el cumplimiento de objetivos y responsabilidades.',4,1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(49,13,'Cumple con los servicios técnicos asignados dentro del tiempo establecido.',1,1,'2026-06-13 02:18:00','2026-06-13 04:05:58'),(50,13,'Ejecuta mantenimientos y servicios conforme a los requerimientos del cliente.',2,1,'2026-06-13 02:18:22','2026-06-13 04:06:17'),(51,13,'Cumple con los estándares de calidad establecidos en los servicios realizados.',3,1,'2026-06-13 02:18:40','2026-06-13 04:06:51'),(52,13,'Cumple oportunamente con los requerimientos técnicos y actividades asignadas, manteniendo la calidad esperada en los resultados.',4,1,'2026-06-13 02:18:59','2026-06-13 06:09:23'),(53,14,'Sigue los procedimientos y lineamientos técnicos establecidos por la empresa.',1,1,'2026-06-13 02:19:48','2026-06-13 04:08:51'),(54,14,'Mantiene orden y organización en la ejecución de sus actividades.',2,1,'2026-06-13 02:20:07','2026-06-13 04:09:08'),(55,14,'Cumple con las normas de seguridad industrial durante la ejecución de servicios.',3,1,'2026-06-13 02:20:24','2026-06-13 04:09:37'),(56,14,'Mantiene una actitud de servicio y colaboración durante la atención de requerimientos internos y externos.',4,1,'2026-06-13 02:20:44','2026-06-13 06:10:40'),(57,15,'Demuestra dominio técnico en instalación y mantenimiento de equipos industriales.',1,1,'2026-06-13 02:21:17','2026-06-13 04:10:21'),(58,15,'Diagnostica y resuelve fallas técnicas de manera efectiva.',2,1,'2026-06-13 02:21:32','2026-06-13 04:10:40'),(59,15,'Utiliza adecuadamente herramientas y equipos técnicos asignados.',3,1,'2026-06-13 02:21:50','2026-06-13 04:10:59'),(60,15,'Aplica de manera efectiva sus conocimientos técnicos para resolver situaciones relacionadas con su área de trabajo.',4,1,'2026-06-13 02:22:08','2026-06-13 06:11:39'),(61,16,'Colabora con compañeros y áreas relacionadas cuando es necesario.',1,1,'2026-06-13 02:22:33','2026-06-13 04:11:48'),(62,16,'Mantiene disposición para apoyar actividades adicionales del área.',2,1,'2026-06-13 02:22:51','2026-06-13 04:12:09'),(63,16,'Propone mejoras o soluciones ante problemas técnicos identificados.',3,1,'2026-06-13 02:23:08','2026-06-13 04:12:30'),(64,16,'Contribuye activamente a la coordinación y comunicación con otras áreas para facilitar el cumplimiento de los objetivos organizacionales.',4,1,'2026-06-13 02:23:24','2026-06-13 06:12:27'),(65,17,'Cumple con las actividades y responsabilidades asignadas dentro del período evaluado.',1,1,'2026-06-13 02:55:45','2026-06-13 05:15:28'),(66,17,'Mantiene un nivel constante de cumplimiento en sus funciones.',2,1,'2026-06-13 02:56:03','2026-06-13 05:15:52'),(67,17,'Da seguimiento oportuno a tareas pendientes hasta su finalización.',3,1,'2026-06-13 02:56:19','2026-06-13 05:16:14'),(68,17,'Ajusta prioridades cuando identifica retrasos o desviaciones en el trabajo.',4,1,'2026-06-13 02:56:34','2026-06-13 05:17:03'),(69,18,'Prioriza tareas según la urgencia y objetivos del área.',1,1,'2026-06-13 02:57:07','2026-06-13 06:02:30'),(70,18,'Mantiene orden y control en la información y procesos a su cargo.',2,1,'2026-06-13 02:57:21','2026-06-13 06:02:48'),(71,18,'Gestiona el tiempo de manera eficiente para cumplir responsabilidades.',3,1,'2026-06-13 02:57:37','2026-06-13 06:03:06'),(72,18,'Asume responsabilidad por los resultados de su trabajo.',4,1,'2026-06-13 02:57:52','2026-06-13 06:03:23'),(73,19,'Demuestra dominio técnico requerido para el puesto.',1,1,'2026-06-13 02:58:10','2026-06-13 06:04:02'),(74,19,'Aplica correctamente herramientas, procesos y sistemas del área.',2,1,'2026-06-13 02:58:31','2026-06-13 06:04:21'),(75,19,'Analiza información antes de tomar decisiones relacionadas con su trabajo.',3,1,'2026-06-13 02:58:46','2026-06-13 06:04:41'),(76,19,'Da seguimiento adecuado a situaciones pendientes hasta resolverlas.',4,1,'2026-06-13 02:59:03','2026-06-13 06:05:05'),(77,20,'Coopera activamente con compañeros para cumplir objetivos comunes.',1,1,'2026-06-13 02:59:32','2026-06-13 06:05:41'),(78,20,'Comparte información relevante que facilita el trabajo del equipo.',2,1,'2026-06-13 02:59:47','2026-06-13 06:05:59'),(79,20,'Mantiene relaciones laborales respetuosas y colaborativas.',3,1,'2026-06-13 03:00:05','2026-06-13 06:06:17'),(80,20,'Propone mejoras en procesos o actividades de trabajo.',4,1,'2026-06-13 03:00:27','2026-06-13 06:06:35'),(81,21,'Comunica instrucciones y expectativas de manera clara.',1,1,'2026-06-13 03:10:36','2026-06-13 10:02:54'),(82,21,'Escucha las opiniones y sugerencias del equipo.',2,1,'2026-06-13 03:10:53','2026-06-13 10:03:18'),(83,21,'Mantiene una comunicación respetuosa y profesional.',3,1,'2026-06-13 03:11:10','2026-06-13 10:03:34'),(84,21,'Brinda retroalimentación oportuna sobre el trabajo realizado.',4,1,'2026-06-13 03:11:26','2026-06-13 10:03:53'),(85,22,'Organiza adecuadamente el trabajo del equipo.',1,1,'2026-06-13 03:11:54','2026-06-13 10:04:55'),(86,22,'Da seguimiento a las actividades y responsabilidades del área.',2,1,'2026-06-13 03:12:10','2026-06-13 10:05:11'),(87,22,'Apoya al equipo cuando se presentan dificultades laborales.',3,1,'2026-06-13 03:12:28','2026-06-13 10:05:29'),(88,22,'Promueve un ambiente de trabajo colaborativo y respetuoso.',4,1,'2026-06-13 03:12:46','2026-06-13 10:05:46'),(89,23,'Brinda orientación cuando se requiere apoyo en el trabajo.',1,1,'2026-06-13 03:13:07','2026-06-13 10:06:28'),(90,23,'Promueve el aprendizaje y desarrollo del equipo.',2,1,'2026-06-13 03:13:24','2026-06-13 10:06:47'),(91,23,'Reconoce el esfuerzo y desempeño de los colaboradores.',3,1,'2026-06-13 03:13:40','2026-06-13 10:07:43'),(92,23,'Mantiene disposición para resolver dudas o problemas.',4,1,'2026-06-13 03:13:57','2026-06-13 10:08:01'),(93,24,'Actúa de forma alineada a los valores de la organización.',1,1,'2026-06-13 03:14:23','2026-06-13 10:08:25'),(94,24,'Toma decisiones de manera justa y objetiva.',2,1,'2026-06-13 03:14:51','2026-06-13 10:08:57'),(95,24,'Mantiene una actitud positiva y orientada a resultados.',3,1,'2026-06-13 03:15:06','2026-06-13 10:09:12'),(96,24,'Promueve el cumplimiento de objetivos y responsabilidades.',4,1,'2026-06-13 03:15:23','2026-06-13 10:09:30'),(101,26,'Comunica claramente los objetivos y prioridades del área.',1,1,'2026-06-14 02:48:58','2026-06-14 02:48:58'),(102,26,'Proporciona orientación cuando se presentan dificultades.',2,1,'2026-06-14 02:49:28','2026-06-14 02:49:28'),(103,26,'Delega responsabilidades de manera adecuada.',3,1,'2026-06-14 03:09:43','2026-06-14 03:09:43'),(104,26,'Promueve la participación del equipo en la toma de decisiones.',4,1,'2026-06-14 03:10:04','2026-06-14 03:10:04'),(105,27,'Mantiene una comunicación abierta y respetuosa.',1,1,'2026-06-14 03:10:27','2026-06-14 03:10:27'),(106,27,'Escucha las opiniones y sugerencias de los colaboradores.',2,1,'2026-06-14 03:10:41','2026-06-14 03:10:41'),(107,27,'Comparte información relevante de forma oportuna.',3,1,'2026-06-14 03:10:57','2026-06-14 03:10:57'),(108,27,'Facilita la coordinación entre áreas.',4,1,'2026-06-14 03:11:12','2026-06-14 03:11:12'),(109,28,'Brinda retroalimentación oportuna sobre el desempeño.',1,1,'2026-06-14 03:11:33','2026-06-14 03:11:33'),(110,28,'Reconoce los logros y contribuciones del equipo.',2,1,'2026-06-14 03:11:50','2026-06-14 03:11:50'),(111,28,'Apoya el desarrollo profesional de los colaboradores.',3,1,'2026-06-14 03:12:05','2026-06-14 03:12:05'),(112,28,'Promueve un ambiente de respeto y confianza.',4,1,'2026-06-14 03:12:19','2026-06-14 03:12:19'),(113,29,'Toma decisiones oportunas y fundamentadas.',1,1,'2026-06-14 03:12:38','2026-06-14 03:12:38'),(114,29,'Resuelve conflictos de manera objetiva.',2,1,'2026-06-14 03:12:53','2026-06-14 03:12:53'),(115,29,'Da seguimiento a los compromisos adquiridos.',3,1,'2026-06-14 03:13:09','2026-06-14 03:13:09'),(116,29,'Actúa con coherencia entre lo que comunica y lo que ejecuta.',4,1,'2026-06-14 03:13:30','2026-06-14 03:13:30'),(117,30,'Fomenta el trabajo en equipo.',1,1,'2026-06-14 03:13:53','2026-06-14 03:13:53'),(118,30,'Promueve relaciones laborales respetuosas.',2,1,'2026-06-14 03:14:10','2026-06-14 03:14:10'),(119,30,'Maneja adecuadamente situaciones de presión.',3,1,'2026-06-14 03:14:29','2026-06-14 03:14:29'),(120,30,'Contribuye a mantener un ambiente laboral positivo.',4,1,'2026-06-14 03:14:45','2026-06-14 03:14:45');
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puestos`
--

DROP TABLE IF EXISTS `puestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puestos`
--

LOCK TABLES `puestos` WRITE;
/*!40000 ALTER TABLE `puestos` DISABLE KEYS */;
INSERT INTO `puestos` VALUES (1,1,'Gerente General','GER-GEN',1,'2026-06-10 01:24:34','2026-06-15 03:13:23'),(2,1,'Gerente de Operaciones','GER-OPE',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(3,2,'Jefe de Logística','MM-LOG',1,'2026-06-10 01:24:34','2026-06-15 03:16:06'),(4,5,'Facturación y Cobros','OPA-FAC',1,'2026-06-10 01:24:34','2026-06-13 09:50:52'),(5,5,'Mensajero Logística','OPE-MEN-LOG',1,'2026-06-10 01:24:34','2026-06-14 02:40:15'),(6,5,'Servicio al cliente Z.10','OPA-SCZ10',1,'2026-06-10 01:24:34','2026-06-14 02:39:06'),(7,5,'Servicio al cliente y logística','OPA-SCL',1,'2026-06-10 01:24:34','2026-06-13 09:51:41'),(8,5,'Mensajero Bodeja','OPE-MEN-BD',1,'2026-06-10 01:24:34','2026-06-14 02:40:43'),(9,2,'Encargado de bodega','MM-BOD',1,'2026-06-10 01:24:34','2026-06-15 03:18:34'),(10,1,'Gerente Regional de Ventas','GER-VEN',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(12,2,'Product Manager','MM-PRO',1,'2026-06-10 01:24:34','2026-06-15 03:16:25'),(13,2,'Supervisor de Ventas','MM-SUV',1,'2026-06-10 01:24:34','2026-06-15 03:16:42'),(14,4,'Asesor Técnico de Ventas','OPT-ATV',1,'2026-06-10 01:24:34','2026-06-15 04:20:34'),(15,1,'Gerente Centro de Soluciones al Cliente','GER-CSC',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(16,4,'Técnicos de Proyectos','OPT-TPR',1,'2026-06-10 01:24:34','2026-06-13 09:53:48'),(17,4,'Técnicos de Robótica & E-Drives','OPT-ROB',1,'2026-06-10 01:24:34','2026-06-13 09:54:02'),(18,4,'Técnico de Servicios','OPT-TSV',1,'2026-06-10 01:24:34','2026-06-14 02:41:56'),(19,1,'Gerente Administrativo','GER-ADM',1,'2026-06-10 01:24:34','2026-06-14 02:33:33'),(20,2,'Encargado de Sistemas','MM-SIS',1,'2026-06-10 01:24:34','2026-06-15 03:17:02'),(21,4,'Técnico de Sistemas','OPT-SIS',1,'2026-06-10 01:24:34','2026-06-13 09:54:34'),(22,5,'Asistente de Administración','OPA-AAD',1,'2026-06-10 01:24:34','2026-06-13 09:52:06'),(23,5,'Mensajero Administrativo','OPE-MEN-03',1,'2026-06-10 01:24:34','2026-06-14 02:43:11'),(24,5,'Encargada de Limpieza','OPE-LIM',1,'2026-06-10 01:24:34','2026-06-14 02:43:48'),(25,1,'Contador General','GER-CON',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(26,5,'Auxiliar de Contabilidad I','OPA-CO1',1,'2026-06-10 01:24:34','2026-06-13 09:52:30'),(27,5,'Auxiliar de Contabilidad II','OPA-CO2',1,'2026-06-10 01:24:34','2026-06-13 09:52:43'),(28,1,'Encargada de Recursos Humanos','GER-RH',1,'2026-06-10 01:24:34','2026-06-10 01:24:34'),(29,5,'Asistente de Gerencia General','OPA-ADG',1,'2026-06-13 09:48:18','2026-06-15 04:20:58'),(30,5,'Asistente de Importaciones 1','OPA-ADI-1',1,'2026-06-13 09:50:13','2026-06-14 02:38:13'),(31,5,'Asistente de Importaciones 2','OPA-ADI-2',1,'2026-06-14 02:37:57','2026-06-14 02:38:21'),(32,5,'Asistente de Gerencia de Ventas','OPA-AGV',1,'2026-06-15 03:30:42','2026-06-15 03:30:42');
/*!40000 ALTER TABLE `puestos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relaciones_puestos`
--

DROP TABLE IF EXISTS `relaciones_puestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relaciones_puestos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `puesto_evaluador_id` bigint(20) unsigned NOT NULL,
  `puesto_evaluado_id` bigint(20) unsigned NOT NULL,
  `plantilla_id` bigint(20) unsigned DEFAULT NULL,
  `tipo_relacion` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `relacion_puestos_unica` (`puesto_evaluador_id`,`puesto_evaluado_id`),
  KEY `relaciones_puestos_puesto_evaluado_id_foreign` (`puesto_evaluado_id`),
  KEY `relaciones_puestos_plantilla_id_foreign` (`plantilla_id`),
  CONSTRAINT `relaciones_puestos_plantilla_id_foreign` FOREIGN KEY (`plantilla_id`) REFERENCES `plantillas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `relaciones_puestos_puesto_evaluado_id_foreign` FOREIGN KEY (`puesto_evaluado_id`) REFERENCES `puestos` (`id`),
  CONSTRAINT `relaciones_puestos_puesto_evaluador_id_foreign` FOREIGN KEY (`puesto_evaluador_id`) REFERENCES `puestos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relaciones_puestos`
--

LOCK TABLES `relaciones_puestos` WRITE;
/*!40000 ALTER TABLE `relaciones_puestos` DISABLE KEYS */;
INSERT INTO `relaciones_puestos` VALUES (1,1,2,1,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:42:59'),(2,2,1,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 04:49:00'),(3,2,3,2,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:48:21'),(4,3,2,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:01:22'),(5,3,4,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:01:56'),(6,4,3,6,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:07:22'),(7,4,5,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:07:42'),(8,5,4,6,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:08:24'),(9,3,6,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:02:17'),(10,6,3,6,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:14:53'),(11,3,7,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:02:33'),(12,7,3,6,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:08:57'),(13,7,8,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:09:18'),(14,8,7,6,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:09:47'),(15,3,9,2,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:01:38'),(16,9,3,6,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:13:25'),(17,1,10,1,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:43:16'),(18,10,1,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 04:51:05'),(21,10,12,2,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:52:26'),(22,12,10,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:14:38'),(23,10,13,2,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:52:47'),(24,13,10,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:04:40'),(25,13,14,4,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:05:00'),(26,14,13,6,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:10:29'),(27,1,15,1,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:43:33'),(28,15,1,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 04:55:19'),(29,15,16,4,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:55:57'),(30,16,15,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:15:48'),(31,15,17,4,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:56:15'),(32,17,15,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:16:06'),(33,15,18,4,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:55:44'),(34,18,15,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:15:14'),(35,1,19,1,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:43:46'),(36,19,1,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 04:57:29'),(37,19,20,2,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:58:35'),(38,20,19,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:05:55'),(39,20,21,4,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:06:11'),(40,21,20,6,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:15:33'),(41,19,22,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:57:49'),(42,22,19,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:11:00'),(43,19,23,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:58:54'),(44,23,19,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:14:19'),(45,19,24,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:58:16'),(46,24,19,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:12:43'),(47,1,25,1,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:44:05'),(48,25,1,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 04:59:35'),(49,25,26,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:00:05'),(50,26,25,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:11:41'),(51,25,27,5,'descendente',1,'2026-06-10 01:24:40','2026-06-15 05:00:22'),(52,27,25,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:11:56'),(53,1,28,1,'descendente',1,'2026-06-10 01:24:40','2026-06-15 04:44:25'),(54,28,1,7,'ascendente',1,'2026-06-10 01:24:40','2026-06-15 05:12:59'),(55,29,1,7,'ascendente',1,'2026-06-14 02:47:35','2026-06-15 04:41:56'),(56,1,29,5,'descendente',1,'2026-06-15 04:46:07','2026-06-15 04:46:07'),(57,10,32,5,'descendente',1,'2026-06-15 04:52:03','2026-06-15 04:52:03'),(58,3,30,5,'descendente',1,'2026-06-15 05:03:24','2026-06-15 05:03:24'),(59,3,31,5,'descendente',1,'2026-06-15 05:03:44','2026-06-15 05:03:44');
/*!40000 ALTER TABLE `relaciones_puestos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `respuestas`
--

LOCK TABLES `respuestas` WRITE;
/*!40000 ALTER TABLE `respuestas` DISABLE KEYS */;
/*!40000 ALTER TABLE `respuestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('FswdmTWJTtl8BTfJPixUs1h5iFpsgVEpNGYRdvZK',28,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJLUTQxM0tzTUZ3ZFJrNkplS3BvVWNZZGlqTnN3UXVEb0ZFd09OZzVaIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluaXN0cmFjaW9uXC9wdWVzdG9zIiwicm91dGUiOiJhZG1pbmlzdHJhY2lvbi5wdWVzdG9zIn0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoyOH0=',1781480788);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Gerente General','gerente.general@evaluaciones.test',NULL,'$2y$12$BJYX86Rx3/Fs2qtJlLZi.e2yZVwwPIFsoHNCYe2sKsjsTF3kD74j.',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(2,'Gerente de Operaciones','gerente.operaciones@evaluaciones.test',NULL,'$2y$12$TK0/qSk0oGvGoN9kv0miNehf43tS4lzfybGmMjfSjwh4D5g9nCpyi',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(3,'Jefe de Logística','jefe.logistica@evaluaciones.test',NULL,'$2y$12$8dFnTCLg4m3mtbL4giloFuaep.WBWiySFkRHdlTPU1R1DFeV1YYGS',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(4,'Facturación y Cobros','facturacion.cobros@evaluaciones.test',NULL,'$2y$12$7Q6b20O7RRXFxSrRLugF6uyn.RtvinqPjqFZK/V9qV9MPBr0txSiO',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(5,'Mensajero','mensajero.facturacion@evaluaciones.test',NULL,'$2y$12$elG.BIu4b7OeZTPuYdcecefu.TVc.CCBO8i4aFoOsMbWxg4gVhX7G',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:35','2026-06-10 01:24:35'),(6,'Servicio al cliente z.10','servicio.z10@evaluaciones.test',NULL,'$2y$12$ofFYOyEcbKuPP6P6p6Kdeu.yAbCKRq32me3T8/Y1cGwXjItX6dxPS',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(7,'Servicio al cliente y logística','servicio.logistica@evaluaciones.test',NULL,'$2y$12$J5909E8WBQSk/LVZrdlBpuspLB3tTwF1WX88NQ3HbJx.0d2kDKAPK',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(8,'Mensajero','mensajero.logistica@evaluaciones.test',NULL,'$2y$12$wv1xeLmYaCI4pp2.zkbJee.RPJgfwT05oqTmtLxbMowfMXeHgIud6',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(9,'Encargado de bodega','encargado.bodega@evaluaciones.test',NULL,'$2y$12$nv3r8QItJ9RtQR0icfmM0.Wm6fPM0IutS/6KgSo0QRrLeiD2H.P4a',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(10,'Gerente Regional de Ventas','gerente.ventas@evaluaciones.test',NULL,'$2y$12$8fRCbazQ3cZBv1ihCe2p8OsCEw4jtaFkZQnLZ0i2lykxJ7Ok4T4i.',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:36','2026-06-10 01:24:36'),(12,'Product Manager','product.manager@evaluaciones.test',NULL,'$2y$12$aLtaEHFF7slpQgTOmwyzWOb6v9g8KRKjeDdVB23RdfmFItqoSSK2C',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:37','2026-06-10 01:24:37'),(13,'Supervisor de Ventas','supervisor.ventas@evaluaciones.test',NULL,'$2y$12$A517ibP59lT2dB5qwoqZsOnpwkEiOSPNVLU280Jm/vl.uLRGGEkqC',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:37','2026-06-10 01:24:37'),(14,'Asesores Técnicos de Ventas','asesores.ventas@evaluaciones.test',NULL,'$2y$12$tFsEUwr4YAchf7CyEYEt/OrDlJ92505oWd6NK9qA5FQyHEpZrOaaG',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:37','2026-06-10 01:24:37'),(15,'Gerente Centro de Soluciones al Cliente','gerente.soluciones@evaluaciones.test',NULL,'$2y$12$zxc.cPK59ob0dlBOrzX7xeuzibySGjf8b8D5t7ikleLW8HDbcrr5.',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:37','2026-06-10 01:24:37'),(16,'Técnicos de Proyectos','tecnicos.proyectos@evaluaciones.test',NULL,'$2y$12$uQAL0Ym7BIVUinqS3ikPfOyTeLRZjgwobkojQy3NpFpqZBmUv.AZ2',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(17,'Técnicos de Robótica & E-Drives','tecnicos.robotica@evaluaciones.test',NULL,'$2y$12$9rKGGQ9qPpbvjw4BZ4UKdu6w66unr0pTg.IiEit/8UDYe89A9rrCa',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(18,'Técnicos de Servicios','tecnicos.servicios@evaluaciones.test',NULL,'$2y$12$W3dkYksBMZ9J4aG0S/r2g.uHZEW03xEjswkqR1s3x2qvfsZ11CIkG',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(19,'Gerente Administrativa','gerente.administrativa@evaluaciones.test',NULL,'$2y$12$B0PdKhKsk/qqbYLC7jTsEeuqTUbSqtceWFJojNEV.0xom8A7tuiZi',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(20,'Encargada de Sistemas','encargada.sistemas@evaluaciones.test',NULL,'$2y$12$BWKGMqBQBJGNKxQ89ZGPUu8bMA0oA2an.uREHEav55dYeUXecligq',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:38','2026-06-10 01:24:38'),(21,'Técnico de Sistemas','tecnico.sistemas@evaluaciones.test',NULL,'$2y$12$pfxi8UQxmsSu0unwOvzieuwJpol5CowLHPoH5SVF8KPE2PU3eYj7y',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(22,'Asistente de Administración','asistente.administracion@evaluaciones.test',NULL,'$2y$12$Chv6zOwmI0e/R2aaZRdTuuVqX0raGJ1ojMSUO2xbkJXXvDrdKUYJO',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(23,'Mensajero','mensajero.administracion@evaluaciones.test',NULL,'$2y$12$uhwAxUxyWvmJOiGbprTx0evrQDNwY4uTrURKyL1aM0yjkgbvrFLHS',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(24,'Encargada de Limpieza','encargada.limpieza@evaluaciones.test',NULL,'$2y$12$f/0oSmGKAVbJN95ez7bZg.mxelYonvNFTvKH33iQQGSNhpHXkvbju',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(25,'Contador General','contador.general@evaluaciones.test',NULL,'$2y$12$rS/9Ybc6c26k6T81vyjNouJQeaInHwFJRtFFKIdv5mcVGb0JL05iK',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:39','2026-06-10 01:24:39'),(26,'Auxiliar de Contabilidad I','auxiliar.contabilidad1@evaluaciones.test',NULL,'$2y$12$oxWnSu3j/T.5QSPr.0y8FOBNMtOWdXq9KbHMoCUhlrrJI8/KjNJE2',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(27,'Auxiliar de Contabilidad II','auxiliar.contabilidad2@evaluaciones.test',NULL,'$2y$12$EgxBrMHTHVOC00vR1GKFGuaH8Xxm2srmjAouQBx1ZSEqQL4PqCvXe',0,NULL,NULL,NULL,NULL,'2026-06-10 01:24:40','2026-06-10 01:24:40'),(28,'Encargada de Recursos Humanos','recursos.humanos@evaluaciones.test',NULL,'$2y$12$EZSSBuAev5f.RIFDVPSYA.uLKa.h7prbTNortH9o4t7X7AVyTv002',1,NULL,NULL,NULL,'SgELsNXZt1xAbXLKV8bNDzRaFIsZL5Nu5C19DI30gZxzM53UOVINwuBiP9mE','2026-06-10 01:24:40','2026-06-10 01:24:40'),(29,'Asistente de Gerencia de Ventas','asistente.gerencia.ventas@evaluaciones.test',NULL,'$2y$12$q0htVvBs.svtEh8ggA1nK.3ezz4B6NFMMyEEa3LS5CSTFBa.rroIi',0,NULL,NULL,NULL,NULL,'2026-06-15 03:33:24','2026-06-15 03:33:56'),(30,'Asistente de Gerencia General','asistente.gerencia.general@evaluaciones.test',NULL,'$2y$12$TqqaBPMNXzvnndZKrKH4n.vj/Pkgf46bPu5zlSui5EDN4MSYYYAIy',0,NULL,NULL,NULL,NULL,'2026-06-15 04:27:46','2026-06-15 04:27:46'),(31,'Asistente de Importaciones 1','asistente.importaciones.1@evaluaciones.test',NULL,'$2y$12$0a.q/3mSu2yvx/tEfNzByeLjCiw77P03nBqlDnLMY0ByN1iVvn6jm',0,NULL,NULL,NULL,NULL,'2026-06-15 04:35:45','2026-06-15 04:35:45'),(32,'Asistente de Importaciones 2','asistente.importaciones.2@evaluaciones.test',NULL,'$2y$12$.o5qsE8oFOtF1f2gPfsEaeqln39wpodiZ2/3m18Dl9OQJK.BTdN5K',0,NULL,NULL,NULL,NULL,'2026-06-15 04:36:58','2026-06-15 04:36:58');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-14 18:20:51
