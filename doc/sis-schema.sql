-- MySQL dump 10.11
--
-- Host: localhost    Database: sis
-- ------------------------------------------------------
-- Server version	5.0.67

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
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `classes` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text collate utf8_unicode_ci COMMENT 'Klassenname',
  `sectionFK` int(11) default NULL COMMENT 'Abteilung(ID)',
  `teacherFK` int(11) default NULL COMMENT 'Klassenvorstand(ID)',
  `roomFK` int(11) default NULL COMMENT 'Stammklasse(ID)',
  `invisible` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `displayMode`
--

DROP TABLE IF EXISTS `displayMode`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `displayMode` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `hours`
--

DROP TABLE IF EXISTS `hours`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `hours` (
  `ID` int(11) NOT NULL auto_increment,
  `weekday` text collate utf8_unicode_ci,
  `weekdayShort` text collate utf8_unicode_ci,
  `hour` int(11) default NULL,
  `startTime` time default NULL COMMENT 'Start-Zeit',
  `endTime` time default NULL COMMENT 'End-Zeit',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lessons` (
  `ID` int(11) NOT NULL auto_increment,
  `lessonBaseFK` int(11) default NULL COMMENT 'LessonsBase(ID)',
  `roomFK` int(11) default NULL COMMENT 'Raum(ID)',
  `teachersFK` int(11) default NULL COMMENT 'Lehrer(ID)',
  `subjectFK` int(11) default NULL COMMENT 'Fach(ID)',
  `comment` text collate utf8_unicode_ci,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=699 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `lessonsBase`
--

DROP TABLE IF EXISTS `lessonsBase`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lessonsBase` (
  `ID` int(11) NOT NULL auto_increment,
  `startHourFK` int(11) default NULL COMMENT 'Start-Stunde(ID)',
  `endHourFK` int(11) default NULL COMMENT 'End-Stunde(ID)',
  `classFK` int(11) default NULL COMMENT 'Klasse(ID)',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=439 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `logsLogins`
--

DROP TABLE IF EXISTS `logsLogins`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `logsLogins` (
  `ID` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL,
  `user` text NOT NULL,
  `userAgent` text NOT NULL,
  `ip` text NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `logsMain`
--

DROP TABLE IF EXISTS `logsMain`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `logsMain` (
  `ID` int(11) NOT NULL auto_increment,
  `time` int(11) default NULL,
  `connFK` int(11) NOT NULL,
  `site` text NOT NULL,
  `params` text,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=419 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `logsSessions`
--

DROP TABLE IF EXISTS `logsSessions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `logsSessions` (
  `ID` int(11) NOT NULL auto_increment,
  `time` int(11) default NULL,
  `PhpSessIDOrig` text,
  `userAgent` text NOT NULL,
  `PhpSessIDAct` text,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `logsUSConn`
--

DROP TABLE IF EXISTS `logsUSConn`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `logsUSConn` (
  `ID` int(11) NOT NULL auto_increment,
  `time` int(11) default NULL,
  `sessionFK` int(11) NOT NULL,
  `userFK` int(11) NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `logsUsers`
--

DROP TABLE IF EXISTS `logsUsers`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `logsUsers` (
  `ID` int(11) NOT NULL auto_increment,
  `LDAP` text NOT NULL,
  `classesFK` int(11) NOT NULL,
  `sectionsFK` int(11) NOT NULL,
  `isTeacher` tinyint(1) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `missingClasses`
--

DROP TABLE IF EXISTS `missingClasses`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `missingClasses` (
  `ID` int(11) NOT NULL auto_increment,
  `classFK` int(11) default NULL COMMENT 'Klasse(ID)',
  `startDay` date default NULL COMMENT 'Startdatum',
  `startHourFK` int(11) default NULL COMMENT 'Start-Stune(ID)',
  `endDay` date default NULL COMMENT 'Enddatum',
  `endHourFK` int(11) default NULL COMMENT 'End-Stunde(ID)',
  `reason` text collate utf8_unicode_ci COMMENT 'Grund',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `missingTeachers`
--

DROP TABLE IF EXISTS `missingTeachers`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `missingTeachers` (
  `ID` int(11) NOT NULL auto_increment,
  `teacherFK` int(11) default NULL COMMENT 'Lehrer(ID)',
  `startDay` date default NULL COMMENT 'Starttag',
  `startHourFK` int(11) default NULL COMMENT 'Start-Stune(ID)',
  `endDay` date default NULL COMMENT 'Endtag',
  `endHourFK` int(11) default NULL COMMENT 'End-Stunde(ID)',
  `reason` text collate utf8_unicode_ci COMMENT 'Grund',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `monitorMode`
--

DROP TABLE IF EXISTS `monitorMode`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `monitorMode` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text collate utf8_unicode_ci COMMENT 'Modus',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `monitors`
--

DROP TABLE IF EXISTS `monitors`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `monitors` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text collate utf8_unicode_ci COMMENT 'Bezeichnung',
  `text` text collate utf8_unicode_ci,
  `modeFK` int(11) default NULL COMMENT 'Modus(ID)',
  `file` text collate utf8_unicode_ci COMMENT 'Datei',
  `roomFK` int(11) default NULL COMMENT 'Raum(ID)',
  `sectionFK` int(11) default NULL,
  `time` int(11) NOT NULL,
  `displayModeFK` int(11) NOT NULL,
  `displayStartDaytime` int(11) NOT NULL,
  `displayEndDaytime` int(11) NOT NULL,
  `ip` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `news` (
  `ID` int(11) NOT NULL auto_increment,
  `title` text collate utf8_unicode_ci COMMENT 'Titel',
  `text` text collate utf8_unicode_ci COMMENT 'Text',
  `startDay` date default NULL COMMENT 'Starttag',
  `endDay` date default NULL COMMENT 'Endtag',
  `display` tinyint(1) default NULL,
  `sectionFK` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rooms` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text collate utf8_unicode_ci NOT NULL COMMENT 'Raumbezeichnung',
  `teacherFK` int(11) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sections` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text collate utf8_unicode_ci COMMENT 'Abteilungsname',
  `short` text collate utf8_unicode_ci,
  `teacherFK` int(11) default NULL COMMENT 'Abteilungsleiter(ID)',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `subjects` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text collate utf8_unicode_ci COMMENT 'Name',
  `short` text collate utf8_unicode_ci,
  `invisible` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=290 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `substitudes`
--

DROP TABLE IF EXISTS `substitudes`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `substitudes` (
  `ID` int(11) NOT NULL auto_increment,
  `move` tinyint(1) default NULL,
  `lessonFK` int(11) NOT NULL,
  `subjectFK` int(11) default NULL COMMENT 'Fach(ID)',
  `teacherFK` int(11) default NULL COMMENT 'Lehrer(ID)',
  `time` date default NULL COMMENT 'Datum',
  `roomFK` int(11) default NULL COMMENT 'Raum(ID)',
  `startHourFK` int(11) default NULL COMMENT 'Start-Stunde(ID)',
  `endHourFK` int(11) default NULL COMMENT 'End-Stunde(ID)',
  `hidden` tinyint(1) default NULL COMMENT 'Sichtbar?',
  `display` tinyint(4) default NULL,
  `comment` text collate utf8_unicode_ci COMMENT 'Kommentar',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `teachers` (
  `ID` int(11) NOT NULL auto_increment,
  `name` text collate utf8_unicode_ci COMMENT 'Voller Name',
  `short` text collate utf8_unicode_ci COMMENT 'Kürzel',
  `display` text collate utf8_unicode_ci COMMENT 'verkürzter Name',
  `sectionFK` int(11) default NULL COMMENT 'Stammabteilung(ID)',
  `invisible` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=201 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET character_set_client = @saved_cs_client;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-19  8:15:04
