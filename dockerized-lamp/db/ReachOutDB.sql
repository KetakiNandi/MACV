-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ReachOutDB
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `body` varchar(500) DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` varchar(500) DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `attendance_type` int(11) NOT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,'hi',5,1,'2018-01-31 14:33:56'),(2,'',5,1,'2018-02-01 14:37:36');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `time` datetime NOT NULL,
  `senior_id` int(11) DEFAULT NULL,
  `junior_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_comment_latitude` (`latitude`),
  KEY `ix_comment_longitude` (`longitude`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,3,'Visit','Working in Mumbai Suburb, There is stock out situation in Malad',0,0,'2018-01-31 10:17:14',2,5),(2,5,'Miscellaneous','good',0,0,'2018-02-01 14:40:05',NULL,NULL);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_type`
--

DROP TABLE IF EXISTS `contact_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `tier` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_type`
--

LOCK TABLES `contact_type` WRITE;
/*!40000 ALTER TABLE `contact_type` DISABLE KEYS */;
INSERT INTO `contact_type` VALUES (1,'Super Distributor',1,1,'2018-01-13 12:01:35'),(2,'Distributor',2,1,'2018-01-13 12:01:48'),(3,'Retailer',3,1,'2018-01-13 12:02:02');
/*!40000 ALTER TABLE `contact_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `mobile_no` varchar(11) NOT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `time` datetime NOT NULL,
  `contact_person` varchar(160) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `last_visited` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cp_dob` datetime DEFAULT NULL,
  `cp_anniversary` datetime DEFAULT NULL,
  `gstin` varchar(15) DEFAULT NULL,
  `pan` varchar(10) DEFAULT NULL,
  `aadhar_no` varchar(20) DEFAULT NULL,
  `super_distributor_id` int(11) DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile_no` (`mobile_no`),
  KEY `ix_contacts_longitude` (`longitude`),
  KEY `ix_contacts_latitude` (`latitude`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,1,3,'Test Himadri',NULL,'himadri@algorismanalytics.com','9867719661',19.2075,72.8787,'2018-01-14 17:17:15','Himadri Roy',0,'2018-01-14 17:17:15','9867719661.jpeg',NULL,NULL,NULL,'AAYRT9954Q','1234567890',NULL,NULL),(2,2,3,'Test Distributor','Thakur Village','himadri@royanalytics.com','98677196',19.2075,72.8787,'2018-01-14 17:21:18',NULL,0,'2018-01-14 17:21:18',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL),(3,3,5,'RS Jain Saab',NULL,NULL,'09324043348',19.2192,72.8657,'2018-01-18 17:52:23',NULL,0,'2018-01-18 17:52:23',NULL,NULL,NULL,NULL,NULL,NULL,1,2),(4,3,5,'Test Bala',NULL,NULL,'09004651997',22.5862,88.4076,'2018-01-19 14:48:47',NULL,0,'2018-01-19 14:48:47',NULL,NULL,NULL,NULL,NULL,NULL,1,2),(5,2,3,'Test Canara Bank','BKC',NULL,'123',19.0535,72.8471,'2018-01-22 11:43:51',NULL,0,'2018-01-22 11:43:51',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL),(6,3,3,'Test Ashish',NULL,NULL,'09004315053',19.2192,72.8657,'2018-01-24 16:47:20',NULL,0,'2018-01-24 16:47:20',NULL,NULL,NULL,NULL,NULL,NULL,1,5),(7,2,5,'Ta','Fghh','cgg','85',22.5862,88.4076,'2018-01-31 12:48:17','ccg',0,'2018-01-31 12:48:17',NULL,'2018-01-31 00:00:00','2018-01-31 00:00:00','GGG','GGG','566',1,NULL),(8,3,3,'Test Peter Glanbia',NULL,NULL,'09967113065',19.1059,72.8683,'2018-02-01 13:00:30',NULL,0,'2018-02-01 13:00:30','09967113065.jpeg',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,3,5,'Tanmoy','Ec146','dish CV nd an','6545798',22.5861,88.4076,'2018-02-01 14:37:08','chhkk',0,'2018-02-01 14:37:08',NULL,NULL,'2018-02-01 00:00:00','NC DM IF AN','COD AN CM','997965989858',1,5);
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `type_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `count` int(11) DEFAULT NULL,
  `value` float DEFAULT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_order_latitude` (`latitude`),
  KEY `ix_order_longitude` (`longitude`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,3,'ORD140120180001',1,1,'2018-01-14 17:17:32',7,9450,19.2075,72.8787),(2,5,'ORD140120180002',2,2,'2018-01-14 17:22:33',5,6250,19.2075,72.8787),(3,6,'ORD180120180001',1,1,'2018-01-18 16:10:12',7,10850,22.5862,88.4076),(4,6,'ORD180120180002',1,1,'2018-01-18 16:18:21',5,7600,22.5862,88.4076),(5,6,'ORD180120180003',1,1,'2018-01-18 16:29:39',3,3750,22.5862,88.4076),(6,6,'ORD180120180004',1,1,'2018-01-18 16:30:13',4,5700,22.5862,88.4076),(7,6,'ORD180120180005',1,1,'2018-01-18 16:45:46',4,5700,22.5862,88.4076),(8,5,'ORD180120180006',3,3,'2018-01-18 17:52:46',6,7500,19.2192,72.8657),(9,6,'ORD180120180007',1,1,'2018-01-18 22:36:03',4,5700,22.5926,88.367),(10,6,'ORD180120180008',2,2,'2018-01-18 22:37:59',6,8850,22.5926,88.367),(11,6,'ORD180120180009',1,1,'2018-01-18 22:49:42',4,5700,22.5926,88.367),(12,6,'ORD180120180010',2,2,'2018-01-18 23:20:00',4,5700,22.5926,88.367),(13,6,'ORD190120180001',2,2,'2018-01-19 06:22:44',4,5700,22.5926,88.367),(14,6,'ORD190120180002',2,2,'2018-01-19 06:30:44',4,5700,22.5926,88.367),(15,6,'ORD190120180003',2,2,'2018-01-19 06:33:15',4,5700,22.5926,88.367),(16,6,'ORD190120180004',2,2,'2018-01-19 06:37:02',4,5700,22.5926,88.367),(17,6,'ORD190120180005',2,2,'2018-01-19 06:40:49',4,5700,22.5926,88.367),(18,6,'ORD190120180006',2,2,'2018-01-19 06:42:00',4,5700,22.5926,88.367),(19,6,'ORD190120180007',2,2,'2018-01-19 06:44:19',4,5700,22.5926,88.367),(20,6,'ORD190120180008',2,2,'2018-01-19 06:55:19',4,5700,22.5926,88.367),(21,6,'ORD190120180009',2,2,'2018-01-19 06:57:31',4,5700,22.5926,88.367),(22,6,'ORD190120180010',2,2,'2018-01-19 06:59:02',4,5700,22.5926,88.367),(23,6,'ORD190120180011',2,2,'2018-01-19 07:13:56',3,4400,22.5926,88.367),(24,6,'ORD190120180012',2,2,'2018-01-19 07:17:34',4,5700,22.5926,88.367),(25,6,'ORD190120180013',2,2,'2018-01-19 07:29:35',4,5700,22.5926,88.367),(26,6,'ORD190120180014',2,2,'2018-01-19 07:31:30',4,5700,22.5926,88.367),(27,6,'ORD190120180015',2,2,'2018-01-19 07:37:04',4,5700,22.5926,88.367),(28,6,'ORD190120180016',2,2,'2018-01-19 07:38:43',4,5700,22.5926,88.367),(29,6,'ORD190120180017',2,2,'2018-01-19 07:41:35',3,4400,22.5926,88.367),(30,6,'ORD190120180018',2,2,'2018-01-19 07:45:19',4,5700,22.5926,88.367),(31,6,'ORD190120180019',2,2,'2018-01-19 07:45:54',3,3750,22.5926,88.367),(32,5,'ORD190120180020',3,4,'2018-01-19 14:49:41',2,2400,19.0069,72.8324),(33,3,'ORD220120180001',2,5,'2018-01-22 11:44:00',6,7500,19.0535,72.8471),(34,3,'ORD240120180001',3,6,'2018-01-24 16:47:38',6,7500,19.2192,72.8657),(35,6,'ORD240120180002',1,1,'2018-01-24 16:59:28',5,7650,22.5861,88.4076),(36,6,'ORD240120180003',1,1,'2018-01-24 17:01:26',5,7650,22.5861,88.4076),(37,6,'ORD240120180004',1,1,'2018-01-24 17:03:56',5,7650,22.5861,88.4076),(38,6,'ORD240120180005',1,1,'2018-01-24 17:05:13',4,5700,22.5862,88.4076),(39,6,'ORD240120180006',2,2,'2018-01-24 17:06:57',3,4400,22.5862,88.4076),(40,1,'ORD270120180001',1,1,'2018-01-27 03:00:15',7,10250,22.9461,88.4461),(41,1,'ORD270120180002',1,1,'2018-01-27 03:12:25',6,9450,22.946,88.4461),(42,1,'ORD270120180003',1,1,'2018-01-27 03:13:29',3,4450,22.946,88.4461),(43,3,'ORD270120180004',1,1,'2018-01-27 12:29:04',8,11400,19.2075,72.8788),(44,5,'ORD310120180001',2,7,'2018-01-31 15:24:47',21,29900,22.5862,88.4075),(45,3,'ORD010220180001',3,8,'2018-02-01 13:01:21',3,5850,19.1059,72.8683),(46,5,'ORD010220180002',3,9,'2018-02-01 14:37:26',2,3900,22.5861,88.4076),(47,5,'ORD010220180003',1,1,'2018-02-01 18:05:38',3,5850,22.5862,88.4075);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty_details` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES (1,'1',1,'{\"1\": 2, \"2\": 2, \"3\": 2}'),(2,'1',2,'{\"7\": 1}'),(3,'2',1,'{\"1\": 2, \"2\": 1, \"3\": 2}'),(4,'3',2,'{\"7\": 3}'),(5,'3',1,'{\"1\": 1, \"2\": 2, \"3\": 1}'),(6,'4',2,'{\"7\": 2}'),(7,'4',1,'{\"1\": 1, \"2\": 2, \"3\": 0}'),(8,'5',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(9,'6',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(10,'6',2,'{\"7\": 1}'),(11,'7',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(12,'7',2,'{\"7\": 1}'),(13,'8',1,'{\"1\": 2, \"2\": 2, \"3\": 2}'),(14,'9',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(15,'9',2,'{\"7\": 1}'),(16,'10',1,'{\"1\": 2, \"2\": 1, \"3\": 1}'),(17,'10',2,'{\"7\": 2}'),(18,'11',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(19,'11',2,'{\"7\": 1}'),(20,'12',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(21,'12',2,'{\"7\": 1}'),(22,'13',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(23,'13',2,'{\"7\": 1}'),(24,'14',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(25,'14',2,'{\"7\": 1}'),(26,'15',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(27,'15',2,'{\"7\": 1}'),(28,'16',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(29,'16',2,'{\"7\": 1}'),(30,'17',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(31,'17',2,'{\"7\": 1}'),(32,'18',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(33,'18',2,'{\"7\": 1}'),(34,'19',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(35,'19',2,'{\"7\": 1}'),(36,'20',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(37,'20',2,'{\"7\": 1}'),(38,'21',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(39,'21',2,'{\"7\": 1}'),(40,'22',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(41,'22',2,'{\"7\": 1}'),(42,'23',1,'{\"1\": 1, \"2\": 1, \"3\": 0}'),(43,'23',2,'{\"7\": 1}'),(44,'24',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(45,'24',2,'{\"7\": 1}'),(46,'25',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(47,'25',2,'{\"7\": 1}'),(48,'26',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(49,'26',2,'{\"7\": 1}'),(50,'27',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(51,'27',2,'{\"7\": 1}'),(52,'28',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(53,'28',2,'{\"7\": 1}'),(54,'29',1,'{\"1\": 1, \"2\": 1, \"3\": 0}'),(55,'29',2,'{\"7\": 1}'),(56,'30',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(57,'30',2,'{\"7\": 1}'),(58,'31',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(59,'32',1,'{\"1\": 2, \"2\": 0, \"3\": 0}'),(60,'33',1,'{\"1\": 2, \"2\": 2, \"3\": 2}'),(61,'34',1,'{\"1\": 2, \"2\": 2, \"3\": 2}'),(62,'35',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(63,'35',2,'{\"7\": 2}'),(64,'36',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(65,'36',2,'{\"7\": 2}'),(66,'37',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(67,'37',2,'{\"7\": 2}'),(68,'38',1,'{\"1\": 1, \"2\": 1, \"3\": 1}'),(69,'38',2,'{\"7\": 1}'),(70,'39',1,'{\"1\": 1, \"2\": 1, \"3\": 0}'),(71,'39',2,'{\"7\": 1}'),(72,'40',2,'{\"7\": 2}'),(73,'40',1,'{\"1\": 1, \"2\": 1, \"3\": 3}'),(74,'41',2,'{\"7\": 3}'),(75,'41',1,'{\"1\": 3, \"2\": 0, \"3\": 0}'),(76,'42',2,'{\"7\": 1}'),(77,'42',1,'{\"1\": 0, \"2\": 2, \"3\": 0}'),(78,'43',2,'{\"7\": 2}'),(79,'43',1,'{\"1\": 2, \"2\": 2, \"3\": 2}'),(80,'44',1,'{\"1\": 4, \"2\": 5, \"3\": 7}'),(81,'44',2,'{\"7\": 5}'),(82,'45',2,'{\"7\": 3}'),(83,'46',2,'{\"7\": 2}'),(84,'47',2,'{\"7\": 3}');
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `price` float DEFAULT NULL,
  `hsn` varchar(20) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `margin` float DEFAULT NULL,
  `margin_character` varchar(20) DEFAULT NULL,
  `volume_character` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `staff_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `popular` tinyint(1) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,1,'CAKE BITES',NULL,'A-0001',1365,NULL,'a',0,NULL,NULL,NULL,1,'2018-01-13 20:54:07',0,0,10000),(2,2,'SYNTHA-6',NULL,'A-0002',1500,NULL,NULL,0,NULL,NULL,NULL,1,'2018-01-13 21:18:57',0,0,10000);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (1,'Optimum Nutrition','2018-01-13 20:51:13',1),(2,'BSN Supplements','2018-01-13 20:51:32',1);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_margin_character`
--

DROP TABLE IF EXISTS `product_margin_character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_margin_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_margin_character`
--

LOCK TABLES `product_margin_character` WRITE;
/*!40000 ALTER TABLE `product_margin_character` DISABLE KEYS */;
INSERT INTO `product_margin_character` VALUES (1,'High'),(3,'Low'),(4,'Not Relevant'),(2,'Standard');
/*!40000 ALTER TABLE `product_margin_character` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_measurement_units`
--

DROP TABLE IF EXISTS `product_measurement_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_measurement_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_measurement_units`
--

LOCK TABLES `product_measurement_units` WRITE;
/*!40000 ALTER TABLE `product_measurement_units` DISABLE KEYS */;
INSERT INTO `product_measurement_units` VALUES (1,'a'),(2,'b'),(3,'c'),(4,'d'),(5,'e'),(6,'f');
/*!40000 ALTER TABLE `product_measurement_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_sub_category`
--

DROP TABLE IF EXISTS `product_sub_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_sub_category`
--

LOCK TABLES `product_sub_category` WRITE;
/*!40000 ALTER TABLE `product_sub_category` DISABLE KEYS */;
INSERT INTO `product_sub_category` VALUES (1,1,'WHEY','2018-01-13 20:51:58',1),(2,2,'Protein','2018-01-13 21:17:06',1);
/*!40000 ALTER TABLE `product_sub_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variant`
--

DROP TABLE IF EXISTS `product_variant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`,`variant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variant`
--

LOCK TABLES `product_variant` WRITE;
/*!40000 ALTER TABLE `product_variant` DISABLE KEYS */;
INSERT INTO `product_variant` VALUES (1,1,2,1250),(2,1,3,1300),(3,1,1,1200),(4,2,7,1950);
/*!40000 ALTER TABLE `product_variant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_volume_character`
--

DROP TABLE IF EXISTS `product_volume_character`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_volume_character` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_volume_character`
--

LOCK TABLES `product_volume_character` WRITE;
/*!40000 ALTER TABLE `product_volume_character` DISABLE KEYS */;
INSERT INTO `product_volume_character` VALUES (2,'Follower'),(1,'Leader'),(3,'Not Relevant');
/*!40000 ALTER TABLE `product_volume_character` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(30) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `headquarters` varchar(120) DEFAULT NULL,
  `zone` varchar(120) NOT NULL,
  `dob` datetime DEFAULT NULL,
  `joining` datetime DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `time` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `area` varchar(500) DEFAULT NULL,
  `manager` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `joint_working` tinyint(1) DEFAULT NULL,
  `super_distributor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `mobile_no` (`mobile_no`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,1,'admin_reachout','$xdf2A34!','Administrator',NULL,NULL,NULL,NULL,'All',NULL,NULL,NULL,'2018-01-13 00:10:02',0,NULL,NULL,NULL,NULL,NULL),(2,2,'emp_test','password','TestEmployee','DEG','1','a@b.c','HQ','ZONE',NULL,NULL,NULL,'2018-01-14 15:07:15',0,'AREA',NULL,36,0,NULL),(3,3,'himadri','himadri','Himadri Roy','Chief Marketing Manager','9867719661','himadri@algorismanalytics.com','Mumbai','West',NULL,NULL,NULL,'2018-01-14 17:14:24',0,'Mumbai Suburban',2,21,0,NULL),(5,3,'demo','demo','Demo Employee','Demo','986771966','support@algorismanalytics.com','Mumbai','West',NULL,NULL,NULL,'2018-01-14 17:19:56',0,'Mumbai',3,21,0,1),(6,3,'ketaki','ketaki1982','Ketaki Nandi','PSO','9433307719','ketakinandi@gmail.com','HQ1','Zone1',NULL,NULL,NULL,'2018-01-18 16:05:52',0,'Area1',3,36,0,1);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_role`
--

DROP TABLE IF EXISTS `staff_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_role`
--

LOCK TABLES `staff_role` WRITE;
/*!40000 ALTER TABLE `staff_role` DISABLE KEYS */;
INSERT INTO `staff_role` VALUES (1,'SuperAdmin',NULL),(2,'Admin',NULL),(3,'Employee',NULL);
/*!40000 ALTER TABLE `staff_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(2) NOT NULL,
  `tin_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state`
--

LOCK TABLES `state` WRITE;
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
INSERT INTO `state` VALUES (1,'Andaman and Nicobar Islands','AN',35),(2,'Andhra Pradesh','AD',37),(3,'Arunachal Pradesh','AR',12),(4,'Assam','AS',18),(5,'Bihar','BR',10),(6,'Chandigarh','CH',4),(7,'Chattisgarh','CG',22),(8,'Dadra and Nagar Haveli','DN',26),(9,'Daman and Diu','DD',25),(10,'Delhi','DL',7),(11,'Goa','GA',30),(12,'Gujarat','GJ',24),(13,'Haryana','HR',6),(14,'Himachal Pradesh','HP',2),(15,'Jammu and Kashmir','JK',1),(16,'Jharkhand','JH',20),(17,'Karnataka','KA',29),(18,'Kerala','KL',32),(19,'Lakshadweep Islands','LD',31),(20,'Madhya Pradesh','MP',23),(21,'Maharashtra','MH',27),(22,'Manipur','MN',14),(23,'Meghalaya','ML',17),(24,'Mizoram','MZ',15),(25,'Nagaland','NL',13),(26,'Odisha','OD',21),(27,'Pondicherry','PY',34),(28,'Punjab','PB',3),(29,'Rajasthan','RJ',8),(30,'Sikkim','SK',11),(31,'Tamil Nadu','TN',33),(32,'Telangana','TS',36),(33,'Tripura','TR',16),(34,'Uttar Pradesh','UP',9),(35,'Uttarakhand','UK',5),(36,'West Bengal','WB',19);
/*!40000 ALTER TABLE `state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `super_distributor_details`
--

DROP TABLE IF EXISTS `super_distributor_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `super_distributor_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `state` int(11) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `super_distributor_details`
--

LOCK TABLES `super_distributor_details` WRITE;
/*!40000 ALTER TABLE `super_distributor_details` DISABLE KEYS */;
INSERT INTO `super_distributor_details` VALUES (1,1,21,NULL,NULL);
/*!40000 ALTER TABLE `super_distributor_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variants`
--

DROP TABLE IF EXISTS `variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variants`
--

LOCK TABLES `variants` WRITE;
/*!40000 ALTER TABLE `variants` DISABLE KEYS */;
INSERT INTO `variants` VALUES (1,'S',NULL),(2,'M',NULL),(3,'L',NULL),(4,'XL',NULL),(5,'XXL',NULL),(6,'XXXL',NULL),(7,'ULTRA-PREMIUM PROTEI',1);
/*!40000 ALTER TABLE `variants` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-01 12:56:58
