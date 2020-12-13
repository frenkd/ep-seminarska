-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sneakers
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sneakers
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sneakers` DEFAULT CHARACTER SET utf8 COLLATE utf8_slovenian_ci ;
USE `sneakers` ;

-- -----------------------------------------------------
-- Table `sneakers`.`Address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Address` (
  `idAddress` INT NOT NULL AUTO_INCREMENT,
  `street` VARCHAR(45) NOT NULL,
  `street_number` INT NOT NULL,
  `post_name` VARCHAR(45) NOT NULL,
  `post_number` INT(4) NOT NULL,
  PRIMARY KEY (`idAddress`),
  UNIQUE INDEX `idAddress_UNIQUE` (`idAddress` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Role` (
  `idRole` INT NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRole`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`User` (
  `idUser` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `active` TINYINT NOT NULL DEFAULT 1,
  `idAddress` INT NULL,
  `idRole` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`idUser`),
  INDEX `fk_Users_Address1_idx` (`idAddress` ASC) VISIBLE,
  INDEX `fk_User_Role1_idx` (`idRole` ASC) VISIBLE,
  CONSTRAINT `idAddress`
    FOREIGN KEY (`idAddress`)
    REFERENCES `sneakers`.`Address` (`idAddress`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idRole`
    FOREIGN KEY (`idRole`)
    REFERENCES `sneakers`.`Role` (`idRole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Company` (
  `idCompany` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCompany`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Order` (
  `idOrder` INT NOT NULL AUTO_INCREMENT,
  `status` INT NOT NULL,
  `amount` DOUBLE NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `idUser` INT NOT NULL,
  PRIMARY KEY (`idOrder`, `idUser`),
  INDEX `fk_Order_User1_idx` (`idUser` ASC) VISIBLE,
  CONSTRAINT `fk_Order_User1`
    FOREIGN KEY (`idUser`)
    REFERENCES `sneakers`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Color`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Color` (
  `idColor` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idColor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Product` (
  `idProduct` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `size` INT(5) NOT NULL,
  `price` DOUBLE NOT NULL DEFAULT 1,
  `active` TINYINT NOT NULL DEFAULT 1,
  `idCompany` INT NOT NULL,
  `idColor` INT NOT NULL,
  `image` VARCHAR(255) NULL,
  PRIMARY KEY (`idProduct`, `idCompany`, `idColor`),
  INDEX `fk_Product_Company1_idx` (`idCompany` ASC) VISIBLE,
  INDEX `fk_Product_Color1_idx` (`idColor` ASC) VISIBLE,
  CONSTRAINT `fk_Product_Company1`
    FOREIGN KEY (`idCompany`)
    REFERENCES `sneakers`.`Company` (`idCompany`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Product_Color1`
    FOREIGN KEY (`idColor`)
    REFERENCES `sneakers`.`Color` (`idColor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`OrderItem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`OrderItem` (
  `amount` DOUBLE NOT NULL,
  `quantity` INT NOT NULL,
  `idOrder` INT NOT NULL,
  `idProduct` INT NOT NULL,
  PRIMARY KEY (`idOrder`, `idProduct`),
  INDEX `fk_OrderItem_Product1_idx` (`idProduct` ASC) VISIBLE,
  CONSTRAINT `fk_OrderItem_Order1`
    FOREIGN KEY (`idOrder`)
    REFERENCES `sneakers`.`Order` (`idOrder`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OrderItem_Product1`
    FOREIGN KEY (`idProduct`)
    REFERENCES `sneakers`.`Product` (`idProduct`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
