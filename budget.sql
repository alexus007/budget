-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: budget
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu1

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
-- Table structure for table `budget`
--

DROP TABLE IF EXISTS `budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `costs_limit` decimal(9,2) DEFAULT NULL,
  `income_limit` decimal(9,2) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_budget_user` (`user_id`),
  CONSTRAINT `fk_budget_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget`
--

LOCK TABLES `budget` WRITE;
/*!40000 ALTER TABLE `budget` DISABLE KEYS */;
INSERT INTO `budget` VALUES (2,1,'Семейный',20000.00,50000.00,'2015-11-22 23:31:01','2015-11-22 23:31:01',1);
/*!40000 ALTER TABLE `budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budget_history`
--

DROP TABLE IF EXISTS `budget_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budget_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `budget_item_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `ammount` decimal(9,2) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_budget_history_user` (`user_id`),
  KEY `fk_budget_history_budget` (`budget_id`),
  KEY `fk_budget_history_budget_item` (`budget_item_id`),
  KEY `fk_budget_history_currency` (`currency_id`),
  CONSTRAINT `fk_budget_history_budget` FOREIGN KEY (`budget_id`) REFERENCES `budget` (`id`),
  CONSTRAINT `fk_budget_history_budget_item` FOREIGN KEY (`budget_item_id`) REFERENCES `budget_item` (`id`),
  CONSTRAINT `fk_budget_history_currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  CONSTRAINT `fk_budget_history_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget_history`
--

LOCK TABLES `budget_history` WRITE;
/*!40000 ALTER TABLE `budget_history` DISABLE KEYS */;
INSERT INTO `budget_history` VALUES (22,1,2,1,1,10000.00,'2015-11-25 00:00:00'),(23,1,2,2,1,40000.00,'2015-11-10 00:00:00'),(24,1,2,3,1,1800.00,'2015-11-02 00:00:00'),(25,1,2,4,1,350.00,'2015-11-02 00:00:00'),(26,1,2,5,1,850.00,'2015-11-02 00:00:00'),(27,1,2,6,1,650.00,'2015-11-02 00:00:00'),(28,1,2,7,1,550.00,'2015-11-01 00:00:00'),(29,1,2,7,1,450.00,'2015-11-06 00:00:00'),(30,1,2,11,1,2000.00,'2015-11-11 00:00:00'),(31,1,2,12,1,4500.00,'2015-11-21 00:00:00'),(32,1,2,10,11,150.00,'2015-11-04 00:00:00');
/*!40000 ALTER TABLE `budget_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budget_item`
--

DROP TABLE IF EXISTS `budget_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budget_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `type_budget_item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ammount` decimal(9,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_budget_item_currency` (`currency_id`),
  KEY `fk_budget_item_patent` (`parent_id`),
  KEY `fk_budget_item_user` (`user_id`),
  KEY `fk_budget_item_type_budget_item` (`type_budget_item_id`),
  CONSTRAINT `fk_budget_item_currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  CONSTRAINT `fk_budget_item_patent` FOREIGN KEY (`parent_id`) REFERENCES `budget_item` (`id`),
  CONSTRAINT `fk_budget_item_type_budget_item` FOREIGN KEY (`type_budget_item_id`) REFERENCES `type_budget_item` (`id`),
  CONSTRAINT `fk_budget_item_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget_item`
--

LOCK TABLES `budget_item` WRITE;
/*!40000 ALTER TABLE `budget_item` DISABLE KEYS */;
INSERT INTO `budget_item` VALUES (1,NULL,1,1,1,'Аванс',NULL,NULL,1),(2,NULL,1,1,1,'Окончаловка',NULL,NULL,1),(3,NULL,1,1,2,'Квартплата (Сысольская)',NULL,NULL,1),(4,NULL,1,1,2,'Газ',NULL,NULL,1),(5,NULL,1,1,2,'Вода',NULL,NULL,1),(6,NULL,1,1,2,'Телевидение интернет',NULL,NULL,1),(7,NULL,1,1,2,'Еда продукты',NULL,NULL,1),(8,7,1,1,2,'Овощи, фрукты',NULL,NULL,1),(9,7,1,1,2,'Мясо, колбаса',NULL,NULL,1),(10,NULL,1,1,1,'Доп. зароботок',NULL,NULL,1),(11,NULL,1,1,2,'Другие траты',500.00,NULL,1),(12,NULL,1,1,2,'Одежда',NULL,NULL,1);
/*!40000 ALTER TABLE `budget_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` int(11) NOT NULL,
  `chCode` varchar(255) NOT NULL,
  `sign` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
INSERT INTO `currency` VALUES (1,'Российский Рубль',643,'RUB','₽',1),(2,'Австралийский доллар                                                                                                                                                                                                                                          ',36,'AUD','',0),(3,'Азербайджанский манат                                                                                                                                                                                                                                         ',944,'AZN','',0),(4,'Фунт стерлингов Соединенного королевства                                                                                                                                                                                                                      ',826,'GBP','',0),(5,'Армянский драм                                                                                                                                                                                                                                                ',51,'AMD','',0),(6,'Белорусский рубль                                                                                                                                                                                                                                             ',974,'BYR','',0),(7,'Болгарский лев                                                                                                                                                                                                                                                ',975,'BGN','',0),(8,'Бразильский реал                                                                                                                                                                                                                                              ',986,'BRL','',0),(9,'Венгерский форинт                                                                                                                                                                                                                                             ',348,'HUF','',0),(10,'Датская крона                                                                                                                                                                                                                                                 ',208,'DKK','',0),(11,'Доллар США                                                                                                                                                                                                                                                    ',840,'USD','$',1),(12,'Евро                                                                                                                                                                                                                                                          ',978,'EUR','',0),(13,'Индийская рупия                                                                                                                                                                                                                                               ',356,'INR','',0),(14,'Казахстанский тенге                                                                                                                                                                                                                                           ',398,'KZT','',0),(15,'Канадский доллар                                                                                                                                                                                                                                              ',124,'CAD','',0),(16,'Киргизский сом                                                                                                                                                                                                                                                ',417,'KGS','',0),(17,'Китайский юань                                                                                                                                                                                                                                                ',156,'CNY','',0),(18,'Молдавский лей                                                                                                                                                                                                                                                ',498,'MDL','',0),(19,'Норвежская крона                                                                                                                                                                                                                                              ',578,'NOK','',0),(20,'Польский злотый                                                                                                                                                                                                                                               ',985,'PLN','',0),(21,'Румынский лей                                                                                                                                                                                                                                                 ',946,'RON','',0),(22,'СДР (специальные права заимствования)                                                                                                                                                                                                                         ',960,'XDR','',0),(23,'Сингапурский доллар                                                                                                                                                                                                                                           ',702,'SGD','',0),(24,'Таджикский сомони                                                                                                                                                                                                                                             ',972,'TJS','',0),(25,'Турецкая лира                                                                                                                                                                                                                                                 ',949,'TRY','',0),(26,'Новый туркменский манат                                                                                                                                                                                                                                       ',934,'TMT','',0),(27,'Узбекский сум                                                                                                                                                                                                                                                 ',860,'UZS','',0),(28,'Украинская гривна                                                                                                                                                                                                                                             ',980,'UAH','',0),(29,'Чешская крона                                                                                                                                                                                                                                                 ',203,'CZK','',0),(30,'Шведская крона                                                                                                                                                                                                                                                ',752,'SEK','',0),(31,'Швейцарский франк                                                                                                                                                                                                                                             ',756,'CHF','',0),(32,'Южноафриканский рэнд                                                                                                                                                                                                                                          ',710,'ZAR','',0),(33,'Вон Республики Корея                                                                                                                                                                                                                                          ',410,'KRW','',0),(34,'Японская иена                                                                                                                                                                                                                                                 ',392,'JPY','',0);
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency_curs`
--

DROP TABLE IF EXISTS `currency_curs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency_curs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_id` int(11) NOT NULL,
  `nom` int(11) NOT NULL,
  `curs` float NOT NULL,
  `rate` float NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_currency_curs_currency` (`currency_id`),
  CONSTRAINT `fk_currency_curs_currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency_curs`
--

LOCK TABLES `currency_curs` WRITE;
/*!40000 ALTER TABLE `currency_curs` DISABLE KEYS */;
INSERT INTO `currency_curs` VALUES (1,2,1,46.659,46.659,'2015-11-22 18:33:32'),(2,3,1,61.9791,61.9791,'2015-11-22 18:33:32'),(3,4,1,99.0718,99.0718,'2015-11-22 18:33:32'),(4,5,100,13.4635,0.134635,'2015-11-22 18:33:32'),(5,6,10000,36.168,0.0036168,'2015-11-22 18:33:32'),(6,7,1,35.3944,35.3944,'2015-11-22 18:33:32'),(7,8,1,17.2428,17.2428,'2015-11-22 18:33:32'),(8,9,100,22.3334,0.223334,'2015-11-22 18:33:32'),(9,10,10,92.8161,9.28161,'2015-11-22 18:33:32'),(10,11,1,64.8673,64.8673,'2015-11-22 18:33:32'),(11,12,1,69.3886,69.3886,'2015-11-22 18:33:32'),(12,13,100,97.9499,0.979499,'2015-11-22 18:33:32'),(13,14,100,21.1054,0.211054,'2015-11-22 18:33:32'),(14,15,1,48.6699,48.6699,'2015-11-22 18:33:32'),(15,16,100,93.7321,0.937321,'2015-11-22 18:33:32'),(16,17,1,10.16,10.16,'2015-11-22 18:33:32'),(17,18,10,32.4093,3.24093,'2015-11-22 18:33:32'),(18,19,10,75.1544,7.51544,'2015-11-22 18:33:32'),(19,20,1,16.3024,16.3024,'2015-11-22 18:33:32'),(20,21,1,15.5882,15.5882,'2015-11-22 18:33:32'),(21,22,1,89.5733,89.5733,'2015-11-22 18:33:32'),(22,23,1,45.9173,45.9173,'2015-11-22 18:33:32'),(23,24,1,10.0914,10.0914,'2015-11-22 18:33:32'),(24,25,1,22.8045,22.8045,'2015-11-22 18:33:32'),(25,26,1,18.5335,18.5335,'2015-11-22 18:33:32'),(26,27,1000,24.0695,0.0240695,'2015-11-22 18:33:32'),(27,28,10,27.1411,2.71411,'2015-11-22 18:33:32'),(28,29,10,25.616,2.5616,'2015-11-22 18:33:32'),(29,30,10,74.4634,7.44634,'2015-11-22 18:33:32'),(30,31,1,63.8206,63.8206,'2015-11-22 18:33:32'),(31,32,10,46.3835,4.63835,'2015-11-22 18:33:32'),(32,33,1000,56.1138,0.0561138,'2015-11-22 18:33:32'),(33,34,100,52.7527,0.527527,'2015-11-22 18:33:32');
/*!40000 ALTER TABLE `currency_curs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1447617388),('m151115_064101_base_migrate',1448199188);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_budget_item`
--

DROP TABLE IF EXISTS `type_budget_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_budget_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_budget_item`
--

LOCK TABLES `type_budget_item` WRITE;
/*!40000 ALTER TABLE `type_budget_item` DISABLE KEYS */;
INSERT INTO `type_budget_item` VALUES (1,'Доход'),(2,'Расход');
/*!40000 ALTER TABLE `type_budget_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `email_confirm_token` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_user_username` (`username`),
  KEY `idx_user_email` (`email`),
  KEY `idx_user_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'2015-11-22 18:37:23','2015-11-22 18:39:09','test','WSVu1j08OEcKcz8MLcFozkGYT2Tk4ci_',NULL,'$2y$13$/vCnSAJv16zZSpi86bNNre4Njr6CLcuHU1IV8dQyJlYLJLpnOg4Em',NULL,'test@example.com',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-23  3:11:46
