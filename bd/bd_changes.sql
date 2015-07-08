-------------------------------
-- Vistra productos_localizacion
--------------------------------

ALTER TABLE `mercabarato_bd`.`grupo` 
DROP COLUMN `identificacion`;

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`tarifa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` INT(10) UNSIGNED NOT NULL,
  `nuevo_costo` FLOAT(10,2) NOT NULL,
  `porcentaje` INT(11) NULL DEFAULT NULL,
  `comentario` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tarifa_producto1_idx` (`producto_id` ASC),
  CONSTRAINT `fk_tarifa_producto1`
    FOREIGN KEY (`producto_id`)
    REFERENCES `mercabarato_bd`.`producto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`grupo_tarifa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tarifa_id` INT(10) UNSIGNED NOT NULL,
  `grupo_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_grupo_tarifa_tarifa1_idx` (`tarifa_id` ASC),
  INDEX `fk_grupo_tarifa_grupo1_idx` (`grupo_id` ASC),
  CONSTRAINT `fk_grupo_tarifa_tarifa1`
    FOREIGN KEY (`tarifa_id`)
    REFERENCES `mercabarato_bd`.`tarifa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_tarifa_grupo1`
    FOREIGN KEY (`grupo_id`)
    REFERENCES `mercabarato_bd`.`grupo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;