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
  `cf` char(16) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `date_of_birth` date,
  PRIMARY KEY (`cf`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS `customer` (
  `cf` char(16) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` ENUM('M', 'F') NOT NULL,
  PRIMARY KEY (`cf`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS `credential` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` ENUM('USER', 'OWNER') NOT NULL,
  `customer_ref` char(16) DEFAULT NULL,
  `owner_ref` char(16) DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

ALTER TABLE `credential` ADD CONSTRAINT `FK_credential_customer` FOREIGN KEY (`customer_ref`) REFERENCES `customer` (`cf`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `credential` ADD CONSTRAINT `FK_credential_owner` FOREIGN KEY (`owner_ref`) REFERENCES `owner` (`cf`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `company` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
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
    PRIMARY KEY (`_id`),
    KEY `FK__owner_azienda` (`owner`) USING BTREE,
    CONSTRAINT `FK__owner_azienda` FOREIGN KEY (`owner`) REFERENCES `owner` (`cf`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `service` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `duration` INT UNSIGNED NOT NULL,
  `price` DECIMAL(7,2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `company` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `FK_servizio_azienda` (`company`) USING BTREE,
  CONSTRAINT `FK_service_company` FOREIGN KEY (`company`) REFERENCES `company` (`_id`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `staff` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `sex` enum('M', 'F') NOT NULL,
  `company` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `FK__azienda` (`company`) USING BTREE,
  CONSTRAINT `FK__company` FOREIGN KEY (`company`) REFERENCES `company` (`_id`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `reservation` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `start_at` INT UNSIGNED NOT NULL,
  `end_at` INT UNSIGNED NOT NULL,
  `confirmed` BOOLEAN NOT NULL DEFAULT FALSE,
  `price` decimal(7, 2) NOT NULL,
  `notes` text,
  `staff` INT UNSIGNED NOT NULL,
  `customer` char(16) NOT NULL,
  `service` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `FK_reservation_service` (`service`) USING BTREE,
  KEY `FK__customer_reservation` (`customer`) USING BTREE,
  KEY `FK__staff_reservation` (`staff`) USING BTREE,
  CONSTRAINT `FK__customer_reservation` FOREIGN KEY (`customer`) REFERENCES `customer` (`cf`) ON UPDATE CASCADE,
  CONSTRAINT `FK__staff_reservation` FOREIGN KEY (`staff`) REFERENCES `staff` (`_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_reservation_service` FOREIGN KEY (`service`) REFERENCES `service` (`_id`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;



-- Popolazione database

INSERT INTO
  owner(cf, name, surname)
VALUES
  ('0123456789123456', 'Test', 'Test');

INSERT INTO
  credential(_id, owner_ref, email, password, type)
VALUES 
  (1,'0123456789123456', 'mariorossi@email.com', 'supersecure123', 'OWNER');

INSERT INTO 
  company(_id,name,open_at,close_at,days,book_before,book_after,owner)
VALUES
  (1, 'Scissorhands', 28800, 75600, "Tue,Wed,Thu,Fri,Sat", 1209600, 3600, '0123456789123456');

INSERT INTO
  service(_id, duration, price, name, description, company)
VALUES 
  (1, 2400, 19.00, "Lavaggio + Taglio", "", 1),
  (2, 1800, 19.00, "Taglio", "", 1),
  (3, 3600, 19.00, "Lavaggio + Taglio + Barba", "", 1),
  (4, 1800, 19.00, "Trattamento ricrescita", "Trattamento specializzato con prodotti appositi per inibire la caduta dei capelli e favorirne la ricrescita", 1);

  
INSERT INTO
  customer(cf, surname, name, date_of_birth, sex) 
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
  staff(_id, surname, name, date_of_birth, sex, company)
VALUES
  (1, 'Rivazzi','Gaetana','1994-05-12','F',1),
  (2, 'Ginnati','Roberto','1998-11-22','M',1);