-------------------------------
-- 11/06/2015
--------------------------------

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`paquete` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `limite_productos` INT(11) NOT NULL DEFAULT 0,
  `limite_anuncios` INT(11) NOT NULL DEFAULT 0,
  `duracion` INT(11) NOT NULL COMMENT 'En meses',
  `orden` INT(1) NOT NULL DEFAULT 0,
  `activo` INT(1) NOT NULL DEFAULT 0,
  `costo` FLOAT(10,2) NOT NULL,
  `mostrar` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`vendedor_paquete` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `paquete_id` INT(10) UNSIGNED NOT NULL,
  `vendedor_id` INT(10) UNSIGNED NOT NULL,
  `referencia` VARCHAR(255) NULL DEFAULT NULL,
  `fecha_comprado` DATE NULL DEFAULT NULL,
  `fecha_aprobado` DATE NULL DEFAULT NULL,
  `fecha_terminar` DATE NULL DEFAULT NULL,
  `productos_insertados` INT(11) NOT NULL DEFAULT 0,
  `anuncios_insertados` INT(11) NOT NULL DEFAULT 0,
  `limite_productos` INT(11) NOT NULL,
  `limite_anuncios` INT(11) NOT NULL,
  `monto_a_cancelar` FLOAT(10,2) NOT NULL,
  `aprobado` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_vendedor_paquete_paquete1_idx` (`paquete_id` ASC),
  INDEX `fk_vendedor_paquete_vendedor1_idx` (`vendedor_id` ASC),
  CONSTRAINT `fk_vendedor_paquete_paquete1`
    FOREIGN KEY (`paquete_id`)
    REFERENCES `mercabarato_bd`.`paquete` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vendedor_paquete_vendedor1`
    FOREIGN KEY (`vendedor_id`)
    REFERENCES `mercabarato_bd`.`vendedor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
