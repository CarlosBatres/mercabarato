-------------------------------
-- 25/06/2015
--------------------------------

ALTER TABLE `mercabarato_bd`.`cliente` 
ADD COLUMN `es_vendedor` INT(1) NOT NULL DEFAULT 0 AFTER `keyword`;

ALTER TABLE `mercabarato_bd`.`visita` 
DROP COLUMN `ocurrencia`;


ALTER TABLE `mercabarato_bd`.`visita` 
DROP FOREIGN KEY `fk_visita_cliente1`;

ALTER TABLE `mercabarato_bd`.`visita` 
DROP COLUMN `buscador`,
CHANGE COLUMN `producto_id` `producto_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `cliente_id` `cliente_id` INT(10) UNSIGNED NULL DEFAULT NULL ,
CHANGE COLUMN `vista_producto` `vista_producto` INT(1) NOT NULL DEFAULT 0 ,
ADD COLUMN `anuncio_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `cliente_id`,
ADD COLUMN `vista_anuncio` INT(1) NOT NULL DEFAULT 0 AFTER `vista_producto`,
ADD INDEX `fk_visita_producto1_idx` (`producto_id` ASC),
ADD INDEX `fk_visita_cliente1_idx` (`cliente_id` ASC),
ADD INDEX `fk_visita_anuncio1_idx` (`anuncio_id` ASC),
DROP INDEX `fk_visita_cliente1_idx` ,
DROP INDEX `fk_visita_producto1_idx` ;

ALTER TABLE `mercabarato_bd`.`visita` 
DROP FOREIGN KEY `fk_visita_producto1`;

ALTER TABLE `mercabarato_bd`.`visita` ADD CONSTRAINT `fk_visita_producto1`
  FOREIGN KEY (`producto_id`)
  REFERENCES `mercabarato_bd`.`producto` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_visita_cliente1`
  FOREIGN KEY (`cliente_id`)
  REFERENCES `mercabarato_bd`.`cliente` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_visita_anuncio1`
  FOREIGN KEY (`anuncio_id`)
  REFERENCES `mercabarato_bd`.`anuncio` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mercabarato_bd`.`invitacion` 
CHANGE COLUMN `estado` `estado` INT(1) NOT NULL DEFAULT 0 COMMENT '1=pendiente,2=aceptado,3=rechazado,4=ignorar' ,
ADD INDEX `fk_invitacion_vendedor1_idx` (`vendedor_id` ASC),
ADD INDEX `fk_invitacion_cliente1_idx` (`cliente_id` ASC),
DROP INDEX `fk_invitacion_cliente1_idx` ,
DROP INDEX `fk_invitacion_vendedor1_idx` ;

ALTER TABLE `mercabarato_bd`.`grupo` 
ADD COLUMN `identificacion` VARCHAR(255) NULL DEFAULT NULL AFTER `cliente_id`,
ADD INDEX `fk_grupo_vendedor1_idx` (`vendedor_id` ASC),
ADD INDEX `fk_grupo_cliente1_idx` (`cliente_id` ASC),
DROP INDEX `fk_grupo_cliente1_idx` ,
DROP INDEX `fk_grupo_vendedor1_idx` ;

ALTER TABLE `mercabarato_bd`.`oferta` 
ADD COLUMN `nombre` VARCHAR(255) NULL DEFAULT NULL AFTER `fecha_finaliza`,
ADD COLUMN `descripcion` TEXT NULL DEFAULT NULL AFTER `nombre`,
ADD INDEX `fk_oferta_producto1_idx` (`producto_id` ASC),
DROP INDEX `fk_oferta_producto1_idx` ;
