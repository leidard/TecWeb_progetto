CREATE DATABASE IF NOT EXISTS `scissorhands`;
USE `scissorhands`;

-- DROP TABLES
DROP TABLE IF EXISTS credential CASCADE;
DROP TABLE IF EXISTS reservation CASCADE;
DROP TABLE IF EXISTS service CASCADE;
DROP TABLE IF EXISTS staff CASCADE;
DROP TABLE IF EXISTS company CASCADE;
DROP TABLE IF EXISTS owner CASCADE;
DROP TABLE IF EXISTS customer CASCADE;


-- CREATE TABLES
CREATE TABLE IF NOT EXISTS `owner` (
  `ID` char(16) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `date_of_birth` date,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS `customer` (
  `ID` char(16) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` enum('M', 'F') NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS `credential` (
  `ID` char(16) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '0',
  `pass` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  CONSTRAINT `FK_credential_customer` FOREIGN KEY (`ID`) REFERENCES `customer` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_credential_owner` FOREIGN KEY (`ID`) REFERENCES `owner` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS `company` (
  `ID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `open_at` INT UNSIGNED NOT NULL,
  `close_at` INT UNSIGNED NOT NULL,
  `days`
  set(
      'Mon',
      'Tue',
      'Wed',
      'Thu',
      'Fri',
      'Sat',
      'Sun'
    ) NOT NULL,
    `book_before` INT UNSIGNED NOT NULL,
    `book_after` INT UNSIGNED NOT NULL,
    `owner` char(16) NOT NULL,
    PRIMARY KEY (`ID`),
    KEY `FK__owner_azienda` (`owner`) USING BTREE,
    CONSTRAINT `FK__owner_azienda` FOREIGN KEY (`owner`) REFERENCES `owner` (`ID`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `service` (
  `ID` int(10) unsigned NOT NULL DEFAULT 0,
  `duration` INT UNSIGNED NOT NULL,
  `price` DECIMAL(7,2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `company` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_servizio_azienda` (`company`) USING BTREE,
  CONSTRAINT `FK_service_company` FOREIGN KEY (`company`) REFERENCES `company` (`ID`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `staff` (
  `ID` char(16) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` enum('M', 'F') NOT NULL,
  `company` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK__azienda` (`company`) USING BTREE,
  CONSTRAINT `FK__company` FOREIGN KEY (`company`) REFERENCES `company` (`ID`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `reservation` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Int *probably* would''ve been fine. Bigint is definitely fine.',
  `start_at` INT UNSIGNED NOT NULL,
  `end_at` INT UNSIGNED NOT NULL,
  `confirmed` BOOLEAN NOT NULL DEFAULT FALSE,
  `price` decimal(7, 2) NOT NULL,
  `notes` text NOT NULL DEFAULT '',
  `staff` char(16) NOT NULL,
  `customer` char(16) NOT NULL,
  `service` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_prenotazione_servizio` (`service`) USING BTREE,
  KEY `FK__customer_reservation` (`customer`) USING BTREE,
  KEY `FK__staff_reservation` (`staff`) USING BTREE,
  CONSTRAINT `FK__customer_reservation` FOREIGN KEY (`customer`) REFERENCES `customer` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `FK__staff_reservation` FOREIGN KEY (`staff`) REFERENCES `staff` (`ID`) ON UPDATE CASCADE,
  CONSTRAINT `FK_reservation_service` FOREIGN KEY (`service`) REFERENCES `service` (`ID`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;



-- Popolazione database

INSERT INTO
  owner(ID, name, surname)
VALUES
  ('0123456789123456', 'Test', 'Test');

INSERT INTO 
  company(ID,name,open_at,close_at,days,book_before,book_after,owner)
VALUES
  (1, 'Scissorhands', 28800, 75600, 'Tue', 1209600, 3600, '0123456789123456');

INSERT INTO
  service(ID, duration, price, name, description, company)
VALUES 
  (1, 2400, 19.00, "Lavaggio + Taglio", "", 1),
  (2, 1800, 19.00, "Taglio", "", 1),
  (3, 3600, 19.00, "Lavaggio + Taglio + Barba", "", 1);