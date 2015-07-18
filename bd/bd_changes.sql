
CREATE VIEW `productos_precios` AS select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`ta`.`nuevo_costo` AS `tarifa_costo`,`g`.`cliente_id` AS `cliente_id` from (((`producto` `p` join `tarifa` `ta` on((`ta`.`producto_id` = `p`.`id`))) join `grupo_tarifa` `gta` on((`gta`.`tarifa_id` = `ta`.`id`))) join `grupo` `g` on((`g`.`id` = `gta`.`grupo_id`))) union select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,NULL AS `NULL`,NULL AS `NULL` from `producto` `p`;

/* FALTAN por poner*/

ALTER TABLE `mercabarato_bd`.`usuario` 
ADD COLUMN `nickname` VARCHAR(255) NULL DEFAULT NULL AFTER `secret_key`;

ALTER TABLE `mercabarato_bd`.`usuario` 
ADD COLUMN `permisos_id` INT(10) UNSIGNED NOT NULL AFTER `nickname`,
ADD INDEX `fk_usuario_permisos1_idx` (`permisos_id` ASC);

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`permisos` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NULL DEFAULT NULL,
  `nivel` INT(11) NULL DEFAULT NULL,
  `controllers` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

ALTER TABLE `mercabarato_bd`.`usuario` 
ADD CONSTRAINT `fk_usuario_permisos1`
  FOREIGN KEY (`permisos_id`)
  REFERENCES `mercabarato_bd`.`permisos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mercabarato_bd`.`usuario` 
DROP COLUMN `is_admin`;

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`restriccion` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(10) UNSIGNED NOT NULL,
  `localizacion_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_restriccion_usuario1_idx` (`usuario_id` ASC),
  INDEX `fk_restriccion_localizacion1_idx` (`localizacion_id` ASC),
  CONSTRAINT `fk_restriccion_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `mercabarato_bd`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_restriccion_localizacion1`
    FOREIGN KEY (`localizacion_id`)
    REFERENCES `mercabarato_bd`.`localizacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;