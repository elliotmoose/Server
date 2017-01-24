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
-- Table structure for table `bar_info`
--

DROP TABLE IF EXISTS `bar_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bar_info` (
  `Bar_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Bar_Name` varchar(50) NOT NULL,
  `Bar_Description` text,
  `Bar_Location_Latitude` double NOT NULL DEFAULT '0',
  `Bar_Location_Longitude` double NOT NULL DEFAULT '0',
  `Bar_Address` text,
  `Bar_OpeningClosingHours` text,
  `OH_Monday` varchar(45) NOT NULL DEFAULT 'closed',
  `OH_Tuesday` varchar(45) NOT NULL DEFAULT 'closed',
  `OH_Wednesday` varchar(45) NOT NULL DEFAULT 'closed',
  `OH_Thursday` varchar(45) NOT NULL DEFAULT 'closed',
  `OH_Friday` varchar(45) NOT NULL DEFAULT 'closed',
  `OH_Saturday` varchar(45) NOT NULL DEFAULT 'closed',
  `OH_Sunday` varchar(45) NOT NULL DEFAULT 'closed',
  `Bar_Rating_Price` float NOT NULL DEFAULT '0',
  `Bar_Rating_Ambience` float DEFAULT '0',
  `Bar_Rating_Service` float DEFAULT '0',
  `Bar_Rating_Food` float DEFAULT '0',
  `Bar_Rating_Avg` float DEFAULT '0',
  `Bar_Contact` varchar(15) DEFAULT NULL,
  `Bar_Website` varchar(45) DEFAULT NULL,
  `Booking_Available` tinyint(4) DEFAULT '0',
  `Bar_Tags` text,
  `Bar_PriceDeterminant` int(11) DEFAULT '0',
  `lastUpdate` varchar(45) DEFAULT '0',
  `Bar_Rating_Count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Bar_ID`),
  UNIQUE KEY `Bar_ID_UNIQUE` (`Bar_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bar_info`
--

LOCK TABLES `bar_info` WRITE;
/*!40000 ALTER TABLE `bar_info` DISABLE KEYS */;
INSERT INTO `bar_info` VALUES (0,'Elliot\'s Bar','this is the first bar',1.2956819292150505,103.78170626492638,'bar 1 address','Open Daily 6pm - 12am','6pm-1am','7pm-12am','8pm-12am','9pm-12am','10pm-12am','11pm-12am','12am-1am',2.24999,3.00001,3.00001,3.74999,3.00001,'6123 4567','www.bar1.com',1,'Modern,Contemp',3,'0',3),(1,'Rahul\'s Bar','This is Rahul\'s bar yo',1.3353980862595003,103.67920429226866,'rahul bar address',NULL,'6pm-12am','6am-11pm','closed','closed','closed','closed','closed',1,0.75,1,1.25,4,'61074914','www.bar2.com',0,'',4,'0',5),(2,'New Bar','Brand new opening',1.3333333333,103.333333333,'new address','open','1','2','3','4','5','6','7',3,3,3,3,3,'61111111','www.newBar.com',0,'new',2,'0',1),(3,'test','hi',0,0,NULL,NULL,'closed','closed','closed','closed','closed','closed','closed',4,4,4,4,4,NULL,NULL,0,NULL,0,'0',2);
/*!40000 ALTER TABLE `bar_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-24 17:01:26
