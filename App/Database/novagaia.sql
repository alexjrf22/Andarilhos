-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema novagaia
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `novagaia` ;

-- -----------------------------------------------------
-- Schema novagaia
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `novagaia` ;
USE `novagaia` ;

-- -----------------------------------------------------
-- Table `novagaia`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `novagaia`.`admin` (
  `admin_id` INT NOT NULL AUTO_INCREMENT,
  `admin_name` VARCHAR(16) NOT NULL,
  `admin_mail` VARCHAR(255) NOT NULL,
  `admin_pass` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`admin_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `novagaia`.`video`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `novagaia`.`video` (
  `video_id` INT NOT NULL AUTO_INCREMENT,
  `video_title` VARCHAR(45) NULL,
  `video_url` VARCHAR(255) NULL,
  `video_sinopse` TEXT NULL,
  `video_data` DATE NULL,
  `admin_admin_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`video_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE INDEX `video_id` ON `novagaia`.`video` (`video_id` ASC) VISIBLE;


-- -----------------------------------------------------
-- Table `novagaia`.`waterfall`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `novagaia`.`waterfall` (
  `waterfall_id` INT NOT NULL AUTO_INCREMENT,
  `waterfall_name` VARCHAR(45) NULL,
  `waterfall_text` VARCHAR(45) NOT NULL,
  `waterfall_trail` DOUBLE NOT NULL,
  `waterfall_difficulty` CHAR(1) NOT NULL,
  `waterfall_date` DATE NOT NULL,
  `admin_admin_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`waterfall_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `novagaia`.`contact`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `novagaia`.`contact` (
  `contact_id` INT NOT NULL AUTO_INCREMENT,
  `contact_title` VARCHAR(45) NOT NULL,
  `contact_text` VARCHAR(45) NULL,
  `contato_email` VARCHAR(255) NULL,
  PRIMARY KEY (`contact_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `novagaia`.`shirt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `novagaia`.`shirt` (
  `shirt_id` INT NOT NULL AUTO_INCREMENT,
  `shirt_title` VARCHAR(45) NULL,
  `shirt_text` VARCHAR(45) NULL,
  `shirt_gender` CHAR(1) NOT NULL,
  `shirt_price` DOUBLE NULL,
  PRIMARY KEY (`shirt_id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
