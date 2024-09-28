-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: yarn
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

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
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (1,'Amol2','2024-07-28 02:50:02','2024-07-28 05:35:09'),(2,'Nikhil','2024-07-28 02:50:10','2024-07-28 02:50:10'),(3,'Chetan','2024-07-28 03:25:03','2024-07-28 03:25:03'),(4,'Tom','2024-07-28 17:21:33','2024-07-28 17:21:33');
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deniers`
--

DROP TABLE IF EXISTS `deniers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deniers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `den` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deniers`
--

LOCK TABLES `deniers` WRITE;
/*!40000 ALTER TABLE `deniers` DISABLE KEYS */;
INSERT INTO `deniers` VALUES (1,100,'2024-07-28 02:50:53','2024-07-28 02:50:53'),(2,120,'2024-07-28 04:36:51','2024-07-28 04:36:51'),(3,130,'2024-07-28 04:37:00','2024-07-28 04:37:00');
/*!40000 ALTER TABLE `deniers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designs`
--

DROP TABLE IF EXISTS `designs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designs`
--

LOCK TABLES `designs` WRITE;
/*!40000 ALTER TABLE `designs` DISABLE KEYS */;
INSERT INTO `designs` VALUES (1,'123','2024-07-28 02:51:30','2024-07-28 17:17:16'),(2,'1002','2024-07-28 02:51:42','2024-07-28 17:18:02'),(3,'1111','2024-07-28 17:17:35','2024-07-28 17:17:35'),(4,'1001','2024-07-28 17:17:46','2024-07-28 17:17:46');
/*!40000 ALTER TABLE `designs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatch_stock_sales`
--

DROP TABLE IF EXISTS `dispatch_stock_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispatch_stock_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `length_id` int(11) NOT NULL,
  `design_id` int(11) NOT NULL,
  `total_no_rolls` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatch_stock_sales`
--

LOCK TABLES `dispatch_stock_sales` WRITE;
/*!40000 ALTER TABLE `dispatch_stock_sales` DISABLE KEYS */;
INSERT INTO `dispatch_stock_sales` VALUES (1,'2024-07-27',1,1,10,'2024-07-28 03:23:05','2024-07-28 13:33:50'),(2,'2024-07-28',2,2,30,'2024-07-28 04:56:58','2024-07-28 04:56:58'),(3,'2024-07-30',1,1,22,'2024-07-28 13:30:53','2024-07-28 13:30:53'),(4,'2024-07-30',1,1,100,'2024-07-28 17:22:31','2024-07-28 17:22:31'),(5,'2024-08-02',1,2,100,'2024-08-01 17:14:17','2024-08-01 17:14:17');
/*!40000 ALTER TABLE `dispatch_stock_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatch_to_own_factories`
--

DROP TABLE IF EXISTS `dispatch_to_own_factories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispatch_to_own_factories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `pick_id` int(11) NOT NULL,
  `factory_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatch_to_own_factories`
--

LOCK TABLES `dispatch_to_own_factories` WRITE;
/*!40000 ALTER TABLE `dispatch_to_own_factories` DISABLE KEYS */;
INSERT INTO `dispatch_to_own_factories` VALUES (1,'2024-07-28',1,'Shree Ram Tower',50000,'2024-07-28 04:57:38','2024-07-28 04:57:38');
/*!40000 ALTER TABLE `dispatch_to_own_factories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foldings`
--

DROP TABLE IF EXISTS `foldings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foldings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `length_id` int(11) NOT NULL,
  `design_id` int(11) NOT NULL,
  `mtrperroll_id` int(11) NOT NULL,
  `total_rolls` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foldings`
--

LOCK TABLES `foldings` WRITE;
/*!40000 ALTER TABLE `foldings` DISABLE KEYS */;
INSERT INTO `foldings` VALUES (1,'2024-07-29',2,2,1,55,'2024-07-28 13:36:33','2024-07-28 13:41:10');
/*!40000 ALTER TABLE `foldings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grey_remainings`
--

DROP TABLE IF EXISTS `grey_remainings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grey_remainings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `picks` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grey_remainings`
--

LOCK TABLES `grey_remainings` WRITE;
/*!40000 ALTER TABLE `grey_remainings` DISABLE KEYS */;
INSERT INTO `grey_remainings` VALUES (1,'2024-08-03','25','2000','2024-08-03 22:25:55',NULL);
/*!40000 ALTER TABLE `grey_remainings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lengths`
--

DROP TABLE IF EXISTS `lengths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lengths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `L` varchar(100) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lengths`
--

LOCK TABLES `lengths` WRITE;
/*!40000 ALTER TABLE `lengths` DISABLE KEYS */;
INSERT INTO `lengths` VALUES (1,'50','2024-07-28 03:00:21','2024-07-28 03:00:21'),(2,'40','2024-07-28 03:00:31','2024-07-28 03:00:31'),(3,'125','2024-07-28 17:18:22','2024-07-28 17:18:22'),(4,'100','2024-07-28 17:19:01','2024-07-28 17:19:01');
/*!40000 ALTER TABLE `lengths` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mtrperrolls`
--

DROP TABLE IF EXISTS `mtrperrolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mtrperrolls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mtrperrolls`
--

LOCK TABLES `mtrperrolls` WRITE;
/*!40000 ALTER TABLE `mtrperrolls` DISABLE KEYS */;
INSERT INTO `mtrperrolls` VALUES (1,20,'2024-07-28 03:01:35','2024-07-28 03:01:35'),(2,125,'2024-07-28 04:58:14','2024-07-28 04:58:14');
/*!40000 ALTER TABLE `mtrperrolls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `picks`
--

DROP TABLE IF EXISTS `picks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `picks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `denier_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `picks`
--

LOCK TABLES `picks` WRITE;
/*!40000 ALTER TABLE `picks` DISABLE KEYS */;
INSERT INTO `picks` VALUES (1,'25',2,'2024-07-28 04:38:41','2024-07-28 13:49:44'),(2,'Pantery',2,'2024-07-28 17:24:05','2024-07-28 17:24:36');
/*!40000 ALTER TABLE `picks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `printed_stock_entries`
--

DROP TABLE IF EXISTS `printed_stock_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `printed_stock_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `pick_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printed_stock_entries`
--

LOCK TABLES `printed_stock_entries` WRITE;
/*!40000 ALTER TABLE `printed_stock_entries` DISABLE KEYS */;
INSERT INTO `printed_stock_entries` VALUES (1,'2024-07-28',1,100,'2024-07-28 04:58:54','2024-07-28 04:58:54'),(2,'2024-07-31',2,20,'2024-07-28 17:24:55','2024-07-28 17:24:55');
/*!40000 ALTER TABLE `printed_stock_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@test.com','$2y$10$1bVXW6JzAhUsWgF.ezM6/uBVCGA.hIZu0/L8wrpWoCLMQC2HlrRPC','admin@test.com','admin','','2024-06-11 23:52:37','2024-06-11');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waterjets`
--

DROP TABLE IF EXISTS `waterjets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `waterjets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `pick_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waterjets`
--

LOCK TABLES `waterjets` WRITE;
/*!40000 ALTER TABLE `waterjets` DISABLE KEYS */;
INSERT INTO `waterjets` VALUES (1,'2024-07-28',1,20000,'2024-07-28 04:59:22','2024-07-28 04:59:22'),(2,'2024-08-03',1,220000,'2024-08-03 18:36:11','2024-08-03 18:36:11');
/*!40000 ALTER TABLE `waterjets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yarn_stocks`
--

DROP TABLE IF EXISTS `yarn_stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yarn_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denier_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `boxes` int(11) NOT NULL,
  `kg` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yarn_stocks`
--

LOCK TABLES `yarn_stocks` WRITE;
/*!40000 ALTER TABLE `yarn_stocks` DISABLE KEYS */;
INSERT INTO `yarn_stocks` VALUES (1,3,1,'2024-07-29',10,300.00,'2024-07-28 05:00:25','2024-07-28 13:58:05','');
/*!40000 ALTER TABLE `yarn_stocks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-14 10:36:09
