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
-- Table `sneakers`.`Post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Post` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idAddress_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Address` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `street` VARCHAR(45) NOT NULL,
  `idPost` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idAddress_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_Address_Post1_idx` (`idPost` ASC) VISIBLE,
  CONSTRAINT `fk_Address_Post1`
    FOREIGN KEY (`idPost`)
    REFERENCES `sneakers`.`Post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`User` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `active` TINYINT NOT NULL DEFAULT 1,
  `idAddress` INT NULL,
  `idRole` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_Users_Address1_idx` (`idAddress` ASC) VISIBLE,
  INDEX `fk_User_Role1_idx` (`idRole` ASC) VISIBLE,
  CONSTRAINT `idAddress`
    FOREIGN KEY (`idAddress`)
    REFERENCES `sneakers`.`Address` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idRole`
    FOREIGN KEY (`idRole`)
    REFERENCES `sneakers`.`Role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Company`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Company` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status` INT NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `idUser` INT NOT NULL,
  PRIMARY KEY (`id`, `idUser`),
  INDEX `fk_Order_User1_idx` (`idUser` ASC) VISIBLE,
  CONSTRAINT `fk_Order_User1`
    FOREIGN KEY (`idUser`)
    REFERENCES `sneakers`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Color`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Color` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Product` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `size` INT(5) NOT NULL,
  `price` DOUBLE NOT NULL DEFAULT 1,
  `active` TINYINT NOT NULL DEFAULT 1,
  `idCompany` INT NOT NULL,
  `idColor` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Product_Company1_idx` (`idCompany` ASC) VISIBLE,
  INDEX `fk_Product_Color1_idx` (`idColor` ASC) VISIBLE,
  CONSTRAINT `fk_Product_Company1`
    FOREIGN KEY (`idCompany`)
    REFERENCES `sneakers`.`Company` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Product_Color1`
    FOREIGN KEY (`idColor`)
    REFERENCES `sneakers`.`Color` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`OrderItem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`OrderItem` (
  `quantity` INT NOT NULL,
  `idOrder` INT NOT NULL,
  `idProduct` INT NOT NULL,
  `price` DOUBLE NOT NULL,
  PRIMARY KEY (`idOrder`, `idProduct`),
  INDEX `fk_OrderItem_Product1_idx` (`idProduct` ASC) VISIBLE,
  CONSTRAINT `fk_OrderItem_Order1`
    FOREIGN KEY (`idOrder`)
    REFERENCES `sneakers`.`Orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_OrderItem_Product1`
    FOREIGN KEY (`idProduct`)
    REFERENCES `sneakers`.`Product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sneakers`.`Image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sneakers`.`Image` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(100) NOT NULL,
  `alt_text` TEXT NULL,
  `idProduct` INT NOT NULL,
  PRIMARY KEY (`id`, `idProduct`),
  INDEX `fk_Image_Product1_idx` (`idProduct` ASC) VISIBLE,
  CONSTRAINT `fk_Image_Product1`
    FOREIGN KEY (`idProduct`)
    REFERENCES `sneakers`.`Product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sneakers`.`Post`
-- -----------------------------------------------------
START TRANSACTION;
USE `sneakers`;
INSERT INTO `sneakers`.`Post` (`id`, `name`) VALUES (1000, 'Ljubljana');
INSERT INTO `sneakers`.`Post` (`id`, `name`) VALUES (2000, 'Maribor');
INSERT INTO `sneakers`.`Post` (`id`, `name`) VALUES (3000, 'Celje');
INSERT INTO `sneakers`.`Post` (`id`, `name`) VALUES (4000, 'Kranj');
INSERT INTO `sneakers`.`Post` (`id`, `name`) VALUES (5000, 'Nova Gorica');
INSERT INTO `sneakers`.`Post` (`id`, `name`) VALUES (6000, 'Koper');
INSERT INTO `sneakers`.`Post` (`id`, `name`) VALUES (8000, 'Novo mesto');
INSERT INTO `sneakers`.`Post` (`id`, `name`) VALUES (9000, 'Murska Sobota');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sneakers`.`Address`
-- -----------------------------------------------------
START TRANSACTION;
USE `sneakers`;
INSERT INTO `sneakers`.`Address` (`id`, `street`, `idPost`) VALUES (1, 'Celovška 1', 1000);
INSERT INTO `sneakers`.`Address` (`id`, `street`, `idPost`) VALUES (2, 'Celovška 2', 1000);
INSERT INTO `sneakers`.`Address` (`id`, `street`, `idPost`) VALUES (3, 'Celovška 3', 1000);
INSERT INTO `sneakers`.`Address` (`id`, `street`, `idPost`) VALUES (4, 'Celovška 4', 1000);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sneakers`.`Role`
-- -----------------------------------------------------
START TRANSACTION;
USE `sneakers`;
INSERT INTO `sneakers`.`Role` (`id`, `role`) VALUES (1, 'Registred customer');
INSERT INTO `sneakers`.`Role` (`id`, `role`) VALUES (2, 'Salesman');
INSERT INTO `sneakers`.`Role` (`id`, `role`) VALUES (3, 'Administrator');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sneakers`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `sneakers`;
INSERT INTO `sneakers`.`User` (`id`, `name`, `surname`, `email`, `password`, `active`, `idAddress`, `idRole`) VALUES (DEFAULT, 'Andrej', 'Adminkovič', 'aa@mail.net', '$2y$10$C77MaUw0yrJS6sDs/X/88OuKjIVg7Jx//IX/R50WvOgBQ2kwBfTtC', 1, 1, 3);
INSERT INTO `sneakers`.`User` (`id`, `name`, `surname`, `email`, `password`, `active`, `idAddress`, `idRole`) VALUES (DEFAULT, 'Brane', 'Blažič', 'bb@mail.net', '$2y$10$C77MaUw0yrJS6sDs/X/88OuKjIVg7Jx//IX/R50WvOgBQ2kwBfTtC', 1, 2, 2);
INSERT INTO `sneakers`.`User` (`id`, `name`, `surname`, `email`, `password`, `active`, `idAddress`, `idRole`) VALUES (DEFAULT, 'Cene', 'Cenilec', 'cc@mail.net', '$2y$10$C77MaUw0yrJS6sDs/X/88OuKjIVg7Jx//IX/R50WvOgBQ2kwBfTtC', 1, 3, 2);
INSERT INTO `sneakers`.`User` (`id`, `name`, `surname`, `email`, `password`, `active`, `idAddress`, `idRole`) VALUES (DEFAULT, 'Zdravko', 'Zapravljivec', 'zz@mail.net', '$2y$10$C77MaUw0yrJS6sDs/X/88OuKjIVg7Jx//IX/R50WvOgBQ2kwBfTtC', 1, 4, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sneakers`.`Company`
-- -----------------------------------------------------
START TRANSACTION;
USE `sneakers`;
INSERT INTO `sneakers`.`Company` (`id`, `name`) VALUES (1, 'Adidas');
INSERT INTO `sneakers`.`Company` (`id`, `name`) VALUES (2, 'Nike');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sneakers`.`Color`
-- -----------------------------------------------------
START TRANSACTION;
USE `sneakers`;
INSERT INTO `sneakers`.`Color` (`id`, `name`) VALUES (1, 'White');
INSERT INTO `sneakers`.`Color` (`id`, `name`) VALUES (2, 'Black');
INSERT INTO `sneakers`.`Color` (`id`, `name`) VALUES (3, 'Red');
INSERT INTO `sneakers`.`Color` (`id`, `name`) VALUES (4, 'Green');
INSERT INTO `sneakers`.`Color` (`id`, `name`) VALUES (5, 'Blue');
INSERT INTO `sneakers`.`Color` (`id`, `name`) VALUES (6, 'Purple');
INSERT INTO `sneakers`.`Color` (`id`, `name`) VALUES (7, 'Beige');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sneakers`.`Product`
-- -----------------------------------------------------
START TRANSACTION;
USE `sneakers`;
INSERT INTO `sneakers`.`Product` (`id`, `title`, `description`, `size`, `price`, `active`, `idCompany`, `idColor`) VALUES (1, 'Adidas Model M', 'Najjači šuhi na vasi.', 42, 50, 1, 1, 1);
INSERT INTO `sneakers`.`Product` (`id`, `title`, `description`, `size`, `price`, `active`, `idCompany`, `idColor`) VALUES (2, 'Nike Model S', 'Kul zadevca.', 42, 500, 1, 2, 2);

COMMIT;

