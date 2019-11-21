
/* database SystemEventManager */

DROP TABLE IF EXISTS `EventPresenter`;
DROP TABLE IF EXISTS `EventAttendee`;
DROP TABLE IF EXISTS `Candidate`;
DROP TABLE IF EXISTS `Presenter`;
DROP TABLE IF EXISTS `Person`;
DROP TABLE IF EXISTS `Event`;

CREATE TABLE `Person` (
  `Id` int(32) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(32) NOT NULL,
  `MiddleName` varchar(255) DEFAULT NULL,
  `LastName` varchar(32) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Role` enum ('candidate','presenter','staff','teacher') DEFAULT 'candidate',
  PRIMARY KEY (`Id`),
  UNIQUE KEY idx_email (`Email`)
) ENGINE=InnoDB;

CREATE TABLE `Event` (
  `Id` int(32) NOT NULL AUTO_INCREMENT,
  `MeetingId` int(32) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `StartUrl` varchar(255) NOT NULL,
  `RoomLink` varchar(255) NOT NULL,
  `Type` enum ('chat','class','pep talk','speech','workshop') DEFAULT 'class',
  `CreatorId` int(32) DEFAULT NULL,
  `SpanTime` int(32) DEFAULT '3600',
  `StartDate` datetime NOT NULL,
  `isPremiumOnly` boolean DEFAULT false,
  `WhatToVerify` enum ('code','country','EnglishLevel') DEFAULT 'EnglishLevel',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Presenter` (
  `Id` int(32) NOT NULL,
  `EventCreator` boolean DEFAULT false,
  `Company` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `fk_PresenterId` FOREIGN KEY (`Id`) REFERENCES `Person` (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Candidate` (
  `Id` int(32) NOT NULL,
  `isPremium` boolean DEFAULT false,
  `EnglishLevel` enum ("Basic","Intermediate","Advanced","Fluent")  DEFAULT NULL,
  PRIMARY KEY (`Id`),
  CONSTRAINT `fk_AttendeeId` FOREIGN KEY (`Id`) REFERENCES `Person` (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `EventPresenter` (
  `EventId` int(32) NOT NULL ,
  `PresenterId` int(32) NOT NULL ,
  FOREIGN KEY (`EventId`) REFERENCES `Event` (`Id`),
  FOREIGN KEY (`PresenterId`) REFERENCES `Presenter` (`Id`),
  UNIQUE KEY uk_EventPresenter_Id (`EventId`,`PresenterId`)
) ENGINE=InnoDB;

CREATE TABLE `EventAttendee` (
  `EventId` int(32) NOT NULL ,
  `AttendeeId` int(32) NOT NULL ,
  `isActive` boolean DEFAULT false,
  FOREIGN KEY (`EventId`) REFERENCES `Event` (`Id`),
  FOREIGN KEY (`AttendeeId`) REFERENCES `Person` (`Id`),
  UNIQUE KEY uk_EventAttendee_Id (`EventId`,`AttendeeId`)
) ENGINE=InnoDB;
