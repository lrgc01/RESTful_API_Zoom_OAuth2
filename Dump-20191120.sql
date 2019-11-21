-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 192.168.56.179    Database: SystemEventManager
-- ------------------------------------------------------
-- Server version	10.1.38-MariaDB-0+deb9u1

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
-- Table structure for table `Candidate`
--

DROP TABLE IF EXISTS `Candidate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Candidate` (
  `Id` int(32) NOT NULL,
  `isPremium` tinyint(1) DEFAULT '0',
  `EnglishLevel` enum('Basic','Intermediate','Advanced','Fluent') DEFAULT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `fk_AttendeeId` FOREIGN KEY (`Id`) REFERENCES `Person` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Candidate`
--

LOCK TABLES `Candidate` WRITE;
/*!40000 ALTER TABLE `Candidate` DISABLE KEYS */;
INSERT INTO `Candidate` VALUES (1,1,'Fluent'),(2,1,NULL),(3,0,'Advanced'),(4,0,NULL),(5,1,'Basic');
/*!40000 ALTER TABLE `Candidate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event`
--

DROP TABLE IF EXISTS `Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event` (
  `Id` int(32) NOT NULL AUTO_INCREMENT,
  `MeetingId` int(32) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `StartUrl` varchar(255) NOT NULL,
  `RoomLink` varchar(255) NOT NULL,
  `Type` enum('chat','class','pep talk','speech','workshop') DEFAULT 'class',
  `CreatorId` int(32) DEFAULT NULL,
  `SpanTime` int(32) DEFAULT '3600',
  `StartDate` datetime NOT NULL,
  `isPremiumOnly` tinyint(1) DEFAULT '0',
  `WhatToVerify` enum('code','country','EnglishLevel') DEFAULT 'EnglishLevel',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event`
--

LOCK TABLES `Event` WRITE;
/*!40000 ALTER TABLE `Event` DISABLE KEYS */;
INSERT INTO `Event` VALUES (1,470341324,'Test Meeting 3','https://us04web.zoom.us/s/470341324?zak=eyJ6bV9za20iOiJ6bV9vMm0iLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJjbGllbnQiLCJ1aWQiOiJtYThLd09Bc1RKeVFNRkhzcHpIa3FBIiwiaXNzIjoid2ViIiwic3R5IjoxLCJ3Y2QiOiJ1czA0IiwiY2x0IjowLCJzdGsiOiI0SjBmZ0w5N0RkNU8ySEFIc0hFRF','https://us04web.zoom.us/j/470341324?pwd=ekpsbG1kZk9OOWJPeW05M1lMYVYwZz09','class',NULL,25,'2019-11-20 20:10:00',0,'EnglishLevel'),(2,919112751,'Test Meeting 4','https://us04web.zoom.us/s/919112751?zak=eyJ6bV9za20iOiJ6bV9vMm0iLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJjbGllbnQiLCJ1aWQiOiJtYThLd09Bc1RKeVFNRkhzcHpIa3FBIiwiaXNzIjoid2ViIiwic3R5IjoxLCJ3Y2QiOiJ1czA0IiwiY2x0IjowLCJzdGsiOiJ6Zk04S3F5bEQyYWQ2b0t4VUZmbD','https://us04web.zoom.us/j/919112751?pwd=bGlUSjJoZ3lyZ0EwTVJ1dkVTQXJTZz09','class',NULL,25,'2019-11-20 20:10:00',0,'EnglishLevel');
/*!40000 ALTER TABLE `Event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EventAttendee`
--

DROP TABLE IF EXISTS `EventAttendee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EventAttendee` (
  `EventId` int(32) NOT NULL,
  `AttendeeId` int(32) NOT NULL,
  `isActive` tinyint(1) DEFAULT '0',
  UNIQUE KEY `uk_EventAttendee_Id` (`EventId`,`AttendeeId`),
  KEY `AttendeeId` (`AttendeeId`),
  CONSTRAINT `EventAttendee_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`Id`),
  CONSTRAINT `EventAttendee_ibfk_2` FOREIGN KEY (`AttendeeId`) REFERENCES `Person` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EventAttendee`
--

LOCK TABLES `EventAttendee` WRITE;
/*!40000 ALTER TABLE `EventAttendee` DISABLE KEYS */;
INSERT INTO `EventAttendee` VALUES (1,1,1),(1,5,1),(2,1,1),(2,5,0);
/*!40000 ALTER TABLE `EventAttendee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EventPresenter`
--

DROP TABLE IF EXISTS `EventPresenter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EventPresenter` (
  `EventId` int(32) NOT NULL,
  `PresenterId` int(32) NOT NULL,
  UNIQUE KEY `uk_EventPresenter_Id` (`EventId`,`PresenterId`),
  KEY `PresenterId` (`PresenterId`),
  CONSTRAINT `EventPresenter_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`Id`),
  CONSTRAINT `EventPresenter_ibfk_2` FOREIGN KEY (`PresenterId`) REFERENCES `Presenter` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EventPresenter`
--

LOCK TABLES `EventPresenter` WRITE;
/*!40000 ALTER TABLE `EventPresenter` DISABLE KEYS */;
/*!40000 ALTER TABLE `EventPresenter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Person`
--

DROP TABLE IF EXISTS `Person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Person` (
  `Id` int(32) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(32) NOT NULL,
  `MiddleName` varchar(255) DEFAULT NULL,
  `LastName` varchar(32) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Role` enum('candidate','presenter','staff','teacher') DEFAULT 'candidate',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `idx_email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Person`
--

LOCK TABLES `Person` WRITE;
/*!40000 ALTER TABLE `Person` DISABLE KEYS */;
INSERT INTO `Person` VALUES (1,'User1',NULL,'surname','user1@gmail.com','candidate'),(2,'User2',NULL,'surname','user2@gmail.com','candidate'),(3,'User3',NULL,'surname','user3@gmail.com','candidate'),(4,'User4',NULL,'surname','user4@gmail.com','candidate'),(5,'User5',NULL,'surname','user5@gmail.com','candidate'),(6,'Teacher1',NULL,'surname','teacher1@gmail.com','teacher'),(7,'Teacher2',NULL,'surname','teacher2@gmail.com','teacher'),(8,'Teacher3',NULL,'surname','teacher3@gmail.com','teacher'),(9,'Teacher4',NULL,'surname','teacher4@gmail.com','teacher'),(10,'Staff1',NULL,'surname','staff1@gmail.com','staff'),(11,'Staff2',NULL,'surname','staff2@gmail.com','staff'),(12,'Staff3',NULL,'surname','staff3@gmail.com','staff');
/*!40000 ALTER TABLE `Person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Presenter`
--

DROP TABLE IF EXISTS `Presenter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Presenter` (
  `Id` int(32) NOT NULL,
  `EventCreator` tinyint(1) DEFAULT '0',
  `Company` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `fk_PresenterId` FOREIGN KEY (`Id`) REFERENCES `Person` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Presenter`
--

LOCK TABLES `Presenter` WRITE;
/*!40000 ALTER TABLE `Presenter` DISABLE KEYS */;
INSERT INTO `Presenter` VALUES (6,0,'Lingocentre'),(7,0,'Lingocentre'),(8,0,'Lingocentre'),(9,0,'Lingocentre'),(10,0,'VanHack'),(11,0,'VanHack'),(12,0,'VanHack');
/*!40000 ALTER TABLE `Presenter` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-20 23:46:27
