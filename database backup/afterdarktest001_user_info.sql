-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: afterdarktest001
-- ------------------------------------------------------
-- Server version	5.5.49-log

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
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info` (
  `User_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `User_Name` varchar(45) DEFAULT NULL,
  `User_Password` varchar(45) DEFAULT NULL,
  `User_Email` varchar(45) DEFAULT NULL,
  `User_Contact` varchar(45) DEFAULT NULL,
  `User_Gender` varchar(45) DEFAULT NULL,
  `User_Birthday` varchar(45) DEFAULT NULL,
  `User_Firstname` varchar(45) DEFAULT NULL,
  `User_Lastname` varchar(45) DEFAULT NULL,
  `User_LoyaltyPts` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (1,'mooselliot','S9728155f','elliot_koh_1997@yahoo.com.sg',NULL,NULL,NULL,NULL,NULL,100),(6,'llpofwy','123456','e@g.c','90286294','Female','16/09/1997','Wanyi','Tan',0),(8,'hello','hello','h@g.c','99999999','Male','01/01/2000','test','test',200),(9,'AppleDemoAccount','Apple123','apple@apple.com','90000000','Male','01/01/1990','Apple','Inc',100),(10,'jj94','speedkillz','justinsurin@gmail.com','94654261','Male','25/05/1994','justin','surin',0),(11,'jprabha','ICZ3V4','jprabhag@yahoo.com','97546485','Male','01/01/1990','J','P',0),(12,'Rahul','PogoPogo1997','rahul.jprabha@yahoo.com.sg','91514447','Male','28/08/1997','Rahul','Jayaprabha',0),(13,'Jprabha1','care4aft','jprabha1@yahoo.com','97546485','Male','01/01/1990','Jaya','p',0),(14,'lukiluki','sass11','andreas@lukin.ee','0928324309','Male','02/02/1970','andreas','lukin',0);
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-05 23:24:25
