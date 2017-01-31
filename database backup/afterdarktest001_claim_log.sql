-- MySQL dump 10.13  Distrib 5.7.12, for osx10.9 (x86_64)
--
-- Host: localhost    Database: afterdarktest001
-- ------------------------------------------------------
-- Server version	5.7.17

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
-- Table structure for table `claim_log`
--

DROP TABLE IF EXISTS `claim_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `claim_log` (
  `claim_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) DEFAULT NULL,
  `User_Name` varchar(45) DEFAULT NULL,
  `Bar_ID` varchar(45) DEFAULT NULL,
  `Discount_Description` text,
  `Discount_Amount` varchar(45) DEFAULT NULL,
  `Discount_Deal` varchar(45) DEFAULT NULL,
  `CodeGeneratedDate` text,
  PRIMARY KEY (`claim_ID`),
  UNIQUE KEY `claim_ID_UNIQUE` (`claim_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `claim_log`
--

LOCK TABLES `claim_log` WRITE;
/*!40000 ALTER TABLE `claim_log` DISABLE KEYS */;
INSERT INTO `claim_log` VALUES (8,0,'mooselliot','0',NULL,'50','5%','1293'),(9,1,'rahul','1',NULL,'100','2%','1300'),(10,0,'mooselliot','0',NULL,'60','3%','1302'),(11,0,'mooselliot','0',NULL,'200','1 for 1','1308'),(16,1,'mooselliot','1','Receive 10% discount at any AfterDark registered Bar!','100','50%','1');
/*!40000 ALTER TABLE `claim_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-31 22:23:35
