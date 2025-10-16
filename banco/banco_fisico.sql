-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema PSI
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema PSI
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `PSI` DEFAULT CHARACTER SET utf8 ;
USE `PSI` ;

-- -----------------------------------------------------
-- Table `PSI`.`Nacionalidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PSI`.`Nacionalidade` (
  `id_Nacionalidade` INT NOT NULL AUTO_INCREMENT,
  `nacionalidade` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_Nacionalidade`),
  UNIQUE INDEX `idNacionalidade_UNIQUE` (`id_Nacionalidade` ASC) VISIBLE,
  UNIQUE INDEX `nacionalidade_UNIQUE` (`nacionalidade` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PSI`.`Atores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PSI`.`Atores` (
  `id_Atores` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `sobrenome` VARCHAR(255) NULL,
  `nascimento` DATE NULL,
  `sexo` ENUM('masculino', 'feminino') NOT NULL,
  `Nacionalidade_idNacionalidade` INT NOT NULL,
  PRIMARY KEY (`id_Atores`),
  UNIQUE INDEX `idAtores_UNIQUE` (`id_Atores` ASC) VISIBLE,
  INDEX `fk_Atores_Nacionalidade1_idx` (`Nacionalidade_idNacionalidade` ASC) VISIBLE,
  CONSTRAINT `fk_Atores_Nacionalidade1`
    FOREIGN KEY (`Nacionalidade_idNacionalidade`)
    REFERENCES `PSI`.`Nacionalidade` (`id_Nacionalidade`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PSI`.`Categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PSI`.`Categoria` (
  `id_Categoria` INT NOT NULL AUTO_INCREMENT,
  `categoria` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_Categoria`),
  UNIQUE INDEX `idCategoria_UNIQUE` (`id_Categoria` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PSI`.`Filmes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PSI`.`Filmes` (
  `id_Filmes` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `descricao` VARCHAR(500) NULL,
  `ano` YEAR(4) NOT NULL,
  `classificacao` ENUM('L', '10', '12', '14', '16', '18') NOT NULL,
  `Categoria_idCategoria` INT NOT NULL,
  `Nacionalidade_id_Nacionalidade` INT NULL,
  PRIMARY KEY (`id_Filmes`),
  UNIQUE INDEX `idFilmes_UNIQUE` (`id_Filmes` ASC) VISIBLE,
  INDEX `fk_Filmes_Categoria_idx` (`Categoria_idCategoria` ASC) VISIBLE,
  INDEX `fk_Filmes_Nacionalidade1_idx` (`Nacionalidade_id_Nacionalidade` ASC) VISIBLE,
  CONSTRAINT `fk_Filmes_Categoria`
    FOREIGN KEY (`Categoria_idCategoria`)
    REFERENCES `PSI`.`Categoria` (`id_Categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Filmes_Nacionalidade1`
    FOREIGN KEY (`Nacionalidade_id_Nacionalidade`)
    REFERENCES `PSI`.`Nacionalidade` (`id_Nacionalidade`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PSI`.`Filmes_has_Atores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PSI`.`Filmes_has_Atores` (
  `Filmes_id_Filmes` INT NOT NULL,
  `Atores_id_Atores` INT NOT NULL,
  PRIMARY KEY (`Filmes_id_Filmes`, `Atores_id_Atores`),
  INDEX `fk_Filmes_has_Atores_Atores1_idx` (`Atores_id_Atores` ASC) VISIBLE,
  INDEX `fk_Filmes_has_Atores_Filmes1_idx` (`Filmes_id_Filmes` ASC) VISIBLE,
  CONSTRAINT `fk_Filmes_has_Atores_Filmes1`
    FOREIGN KEY (`Filmes_id_Filmes`)
    REFERENCES `PSI`.`Filmes` (`id_Filmes`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Filmes_has_Atores_Atores1`
    FOREIGN KEY (`Atores_id_Atores`)
    REFERENCES `PSI`.`Atores` (`id_Atores`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PSI`.`idioma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PSI`.`idioma` (
  `id_idioma` INT NOT NULL AUTO_INCREMENT,
  `idioma` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_idioma`),
  UNIQUE INDEX `ididioma_UNIQUE` (`id_idioma` ASC) VISIBLE,
  UNIQUE INDEX `idioma_UNIQUE` (`idioma` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PSI`.`Filmes_has_idioma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PSI`.`Filmes_has_idioma` (
  `Filmes_id_Filmes` INT NOT NULL,
  `idioma_id_idioma` INT NOT NULL,
  PRIMARY KEY (`Filmes_id_Filmes`, `idioma_id_idioma`),
  INDEX `fk_Filmes_has_idioma_idioma1_idx` (`idioma_id_idioma` ASC) VISIBLE,
  INDEX `fk_Filmes_has_idioma_Filmes1_idx` (`Filmes_id_Filmes` ASC) VISIBLE,
  CONSTRAINT `fk_Filmes_has_idioma_Filmes1`
    FOREIGN KEY (`Filmes_id_Filmes`)
    REFERENCES `PSI`.`Filmes` (`id_Filmes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Filmes_has_idioma_idioma1`
    FOREIGN KEY (`idioma_id_idioma`)
    REFERENCES `PSI`.`idioma` (`id_idioma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
