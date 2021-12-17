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
  `notes` text,
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
  ('0123456789123456', 'Test', 'Test'),
  ('PLARVN00S55H234X', 'Paola', 'Rivanetti'),
  ('BRNRNT22S53H251H', 'Bruno', 'Ornato');

INSERT INTO 
  company(ID,name,open_at,close_at,days,book_before,book_after,owner)
VALUES
  (1, 'Scissorhands', 28800, 75600, 'Tue', 1209600, 3600, '0123456789123456'),
  (2, 'Rivanetti Parrucchiere', 32400, 75600, 'Mon,Tue', 1209600, 3600, 'PLARVN00S55H234X'),
  (3, 'Forbici di diamante', 28800, 79200, 'Tue,Wed,Sat,Sun', 1209600, 3600, 'BRNRNT22S53H251H');

INSERT INTO
  service(ID, duration, price, name, description, company)
VALUES 
  (1, 2400, 19.00, "Lavaggio + Taglio", "", 1),
  (2, 1800, 19.00, "Taglio", "", 1),
  (3, 3600, 19.00, "Lavaggio + Taglio + Barba", "", 1),
  (4, 2400, 19.00, "Lavaggio + Taglio", "", 2),
  (5, 1800, 19.00, "Taglio", "", 2),
  (6, 3600, 19.00, "Lavaggio + Taglio + Colore", "", 2),
  (7, 1800, 19.00, "Trattamento ricrescita", "Trattamento specializzato con prodotti appositi per inibire la caduta dei capelli e favorirne la ricrescita", 2), 
  (8, 1800, 19.00, "Lavaggio + Taglio", "", 3),
  (9, 1200, 19.00, "Taglio", "", 3),
  (10, 3600, 19.00, "Lavaggio + Taglio + Barba", "", 3);
  
INSERT INTO
  customer(ID, surname, name, date_of_birth, sex) 
VALUES 
  ('CCC1CCC1CCC1CCC1', 'Fake1', 'Customer1', '1111-11-11', 'M'),
  ('CCC2CCC2CCC2CCC2', 'Fake2', 'Customer2', '1212-12-12', 'F'),
  ('PEPCNK97I22T699H', 'Timmi', 'Burrus', '1970-10-31', 'F'),
  ('OTTQSD53P80T988H', 'Giffy', 'Feild', '1966-03-26', 'M'),
  ('LRNNZO44L12T680H', 'Oliviero', 'Sarre', '1969-03-23', 'M'),
  ('HZXTJB22S82F294H', 'Cindy', 'Reignould', '1997-10-22', 'F'),
  ('OOURSO29U02V674H', 'Frederica', 'Fereday', '1972-11-21', 'F'),
  ('SDVHUK36F76R573H', 'Barton', 'Blest', '1983-09-13', 'M'),
  ('KXCVBT43F37C291H', 'Ripley', 'Krauss', '1989-09-20', 'M'),
  ('EDCIEO66R23F467H', 'Valentijn', 'Haldon', '1979-07-20', 'M'),
  ('LXZOZK28V43V867H', 'Tammy', 'Gooders', '1975-03-22', 'M'),
  ('UWAIYG87F63L810H', 'Nicola', 'Rosenstein', '1978-08-18', 'M');
  

INSERT INTO 
  staff(ID, surname, name, date_of_birth, sex, company)
VALUES
  ('AAAAAAAAAAAAAAAA','Rivazzi','Gaetana','1994-05-12','F',1),
  ('BBBBBBBBBBBBBBBB','Ginnati','Roberto','1998-11-22','M',1),
  ('CCCCCCCCCCCCCCCC','Jillett','Ramirez','1993-01-14','M',2),
  ('DDDDDDDDDDDDDDDD','Ginnati','Alberta','1988-04-17','F',2),
  ('EEEEEEEEEEEEEEEE','Prateschi','Monico','1978-11-29','M',3);