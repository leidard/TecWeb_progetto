-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.6.5-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for scissorhands
CREATE DATABASE IF NOT EXISTS `scissorhands` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `scissorhands`;

-- Dumping structure for table scissorhands.company
CREATE TABLE IF NOT EXISTS `company` (
  `ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `open_at` time NOT NULL,
  `close_at` time NOT NULL,
  `days` set('Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica') NOT NULL,
  `book_before` time NOT NULL,
  `book_after` time NOT NULL,
  `owner` char(16) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__owner_azienda` (`owner`) USING BTREE,
  CONSTRAINT `FK__owner_azienda` FOREIGN KEY (`owner`) REFERENCES `owner` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.credential
CREATE TABLE IF NOT EXISTS `credential` (
  `ID` char(16) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '0',
  `pass` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  CONSTRAINT `FK_credential_customer` FOREIGN KEY (`ID`) REFERENCES `customer` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_credential_owner` FOREIGN KEY (`ID`) REFERENCES `owner` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `ID` char(16) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` enum('M','F') NOT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `FK__credential` FOREIGN KEY (`ID`) REFERENCES `credential` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.owner
CREATE TABLE IF NOT EXISTS `owner` (
  `ID` char(16) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `FK__credential_owner` FOREIGN KEY (`ID`) REFERENCES `credential` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.reservation
CREATE TABLE IF NOT EXISTS `reservation` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Int *probably* would''ve been fine. Bigint is definitely fine.',
  `start_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `confirmed` enum('S','N') NOT NULL DEFAULT 'N',
  `price` decimal(7,2) NOT NULL,
  `notes` text NOT NULL,
  `staff` char(16) NOT NULL DEFAULT '0',
  `customer` char(16) NOT NULL DEFAULT '',
  `service` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_prenotazione_servizio` (`service`) USING BTREE,
  KEY `FK__customer_reservation` (`customer`) USING BTREE,
  KEY `FK__staff_reservation` (`staff`) USING BTREE,
  CONSTRAINT `FK__customer_reservation` FOREIGN KEY (`customer`) REFERENCES `customer` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `FK__staff_reservation` FOREIGN KEY (`staff`) REFERENCES `staff` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `FK_reservation_service` FOREIGN KEY (`service`) REFERENCES `service` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.service
CREATE TABLE IF NOT EXISTS `service` (
  `ID` int(10) unsigned NOT NULL DEFAULT 0,
  `duration` time NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `company` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_servizio_azienda` (`company`) USING BTREE,
  CONSTRAINT `FK_service_company` FOREIGN KEY (`company`) REFERENCES `company` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `ID` char(16) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` enum('M','F') NOT NULL,
  `company` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__azienda` (`company`) USING BTREE,
  CONSTRAINT `FK__company` FOREIGN KEY (`company`) REFERENCES `company` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
