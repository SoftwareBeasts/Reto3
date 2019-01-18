-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema pedidosHosteleria
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `pedidosHosteleria` ;

-- -----------------------------------------------------
-- Schema pedidosHosteleria
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `pedidosHosteleria` DEFAULT CHARACTER SET utf8 ;
USE `pedidosHosteleria` ;

-- -----------------------------------------------------
-- Table `pedidosHosteleria`.`admin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedidosHosteleria`.`admin` ;

CREATE TABLE IF NOT EXISTS `pedidosHosteleria`.`admin` (
  `idadmin` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `pass` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`idadmin`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedidosHosteleria`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedidosHosteleria`.`categoria` ;

CREATE TABLE IF NOT EXISTS `pedidosHosteleria`.`categoria` (
  `idcategoria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idcategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedidosHosteleria`.`producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedidosHosteleria`.`producto` ;

CREATE TABLE IF NOT EXISTS `pedidosHosteleria`.`producto` (
  `idproducto` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` VARCHAR(200) NOT NULL,
  `precio` DECIMAL(6) NOT NULL,
  `rutaImg` VARCHAR(150) NOT NULL,
  `pedidoMin` INT NULL DEFAULT 1,
  `categoria_idcategoria` INT NOT NULL,
  PRIMARY KEY (`idproducto`),
  CONSTRAINT `fk_producto_categoria`
    FOREIGN KEY (`categoria_idcategoria`)
    REFERENCES `pedidosHosteleria`.`categoria` (`idcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedidosHosteleria`.`cliente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedidosHosteleria`.`cliente` ;

CREATE TABLE IF NOT EXISTS `pedidosHosteleria`.`cliente` (
  `idcliente` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `telefono` INT(9) NOT NULL,
  PRIMARY KEY (`idcliente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedidosHosteleria`.`pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedidosHosteleria`.`pedido` ;

CREATE TABLE IF NOT EXISTS `pedidosHosteleria`.`pedido` (
  `idpedido` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `estado` VARCHAR(50) NOT NULL,
  `precioTotal` DECIMAL(6) NOT NULL,
  `cliente_idcliente` INT NOT NULL,
  PRIMARY KEY (`idpedido`),
  CONSTRAINT `fk_pedido_cliente1`
    FOREIGN KEY (`cliente_idcliente`)
    REFERENCES `pedidosHosteleria`.`cliente` (`idcliente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pedidosHosteleria`.`pedido_has_producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedidosHosteleria`.`pedido_has_producto` ;

CREATE TABLE IF NOT EXISTS `pedidosHosteleria`.`pedido_has_producto` (
  `pedido_idpedido` INT NOT NULL,
  `producto_idproducto` INT NOT NULL,
  `cantidad` INT NOT NULL,
  PRIMARY KEY (`pedido_idpedido`, `producto_idproducto`),
  CONSTRAINT `fk_pedido_has_producto_pedido1`
    FOREIGN KEY (`pedido_idpedido`)
    REFERENCES `pedidosHosteleria`.`pedido` (`idpedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_has_producto_producto1`
    FOREIGN KEY (`producto_idproducto`)
    REFERENCES `pedidosHosteleria`.`producto` (`idproducto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;