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

-- Dumping structure for table scissorhands.azienda
CREATE TABLE IF NOT EXISTS `azienda` (
  `ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `open_at` time NOT NULL,
  `close_at` time NOT NULL,
  `days` set('Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica') NOT NULL,
  `book_before` time NOT NULL,
  `book_after` time NOT NULL,
  `Owner` char(16) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__owner_azienda` (`Owner`),
  CONSTRAINT `FK__owner_azienda` FOREIGN KEY (`Owner`) REFERENCES `owner` (`ID`) ON UPDATE CASCADE
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
  `Surname` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Date_of_birth` date NOT NULL,
  `Sex` enum('M','F') NOT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `FK__credential` FOREIGN KEY (`ID`) REFERENCES `credential` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.owner
CREATE TABLE IF NOT EXISTS `owner` (
  `ID` char(16) NOT NULL,
  `Surname` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Date_of_birth` date NOT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT `FK__credential_owner` FOREIGN KEY (`ID`) REFERENCES `credential` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.prenotazione
CREATE TABLE IF NOT EXISTS `prenotazione` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Int *probably* would''ve been fine. Bigint is definitely fine.',
  `start_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `confirmed` enum('S','N') NOT NULL DEFAULT 'N',
  `price` decimal(7,2) NOT NULL,
  `note` text NOT NULL,
  `Azienda` mediumint(8) unsigned NOT NULL DEFAULT 0,
  `Staff` char(16) NOT NULL DEFAULT '0',
  `Customer` char(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `FK__azienda_prenotazione` (`Azienda`),
  KEY `FK__staff_prenotazione` (`Staff`),
  KEY `FK__customer_prenotazione` (`Customer`),
  CONSTRAINT `FK__azienda_prenotazione` FOREIGN KEY (`Azienda`) REFERENCES `azienda` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `FK__customer_prenotazione` FOREIGN KEY (`Customer`) REFERENCES `customer` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `FK__staff_prenotazione` FOREIGN KEY (`Staff`) REFERENCES `staff` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.servizio
CREATE TABLE IF NOT EXISTS `servizio` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `duration` time NOT NULL,
  `name` varchar(100) NOT NULL,
  `descrizione` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.servizi_azienda
CREATE TABLE IF NOT EXISTS `servizi_azienda` (
  `ID` int(10) unsigned NOT NULL,
  `Azienda` mediumint(8) unsigned NOT NULL,
  `Servizio` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__azienda_servizio` (`Azienda`),
  KEY `FK__servizio_azienda` (`Servizio`),
  CONSTRAINT `FK__azienda_servizio` FOREIGN KEY (`Azienda`) REFERENCES `azienda` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `FK__servizio_azienda` FOREIGN KEY (`Servizio`) REFERENCES `servizio` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Che servizi offre l''azienda';

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.servizi_prenotazione
CREATE TABLE IF NOT EXISTS `servizi_prenotazione` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Prenotazione` bigint(20) unsigned NOT NULL DEFAULT 0,
  `Servizio` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `FK__prenotazione` (`Prenotazione`),
  KEY `FK__servizio` (`Servizio`),
  CONSTRAINT `FK__prenotazione` FOREIGN KEY (`Prenotazione`) REFERENCES `prenotazione` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `FK__servizio` FOREIGN KEY (`Servizio`) REFERENCES `servizio` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Servizi in una prenotazione.\r\nUna pk sola per semplificare query.';

-- Data exporting was unselected.

-- Dumping structure for table scissorhands.staff
CREATE TABLE IF NOT EXISTS `staff` (
  `ID` char(16) NOT NULL,
  `Surname` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Date_of_birth` date NOT NULL,
  `Sex` enum('M','F') NOT NULL,
  `Azienda` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__azienda` (`Azienda`),
  CONSTRAINT `FK__azienda` FOREIGN KEY (`Azienda`) REFERENCES `azienda` (`ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
