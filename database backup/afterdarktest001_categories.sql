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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `Category_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Category_Name` varchar(45) DEFAULT NULL,
  `Bar_IDs` text,
  `ImagePath` text,
  `Category_Description` text NOT NULL,
  `lastUpdate` varchar(45) NOT NULL,
  PRIMARY KEY (`Category_ID`),
  UNIQUE KEY `Category_ID_UNIQUE` (`Category_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'CRAFT BEERS','[1]','/Applications/MAMP/htdocs/AfterDarkServer/Category_Images/Craft Beers.jpg','savor the flavor','0'),(2,'GIRLS NIGHT OUT','[0]','/Applications/MAMP/htdocs/AfterDarkServer/Category_Images/Girls Night Out.jpg','','0'),(3,'PRE-DRINKS','[0,1]','/Applications/MAMP/htdocs/AfterDarkServer/Category_Images/Pre-Drinks.jpg','starting the night right','0'),(4,'CLASSY',' ','/Applications/MAMP/htdocs/AfterDarkServer/Category_Images/Classy.jpg','the perfect date night','0'),(6,'COSY','[2]','/Applications/MAMP/htdocs/AfterDarkServer/Category_Images/Cosy.jpg','the best chill out spots','0'),(7,'DATE',' ','/Applications/MAMP/htdocs/AfterDarkServer/Category_Images/Date.jpg','','0'),(10,'SPORTS','[0]','/Applications/MAMP/htdocs/AfterDarkServer/Category_Images/Sports.JPG','','0');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-15 12:16:41
