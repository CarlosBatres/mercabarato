CREATE VIEW `productos_precios` AS
select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`of`.`nuevo_costo` AS `nuevo_costo`,`g`.`cliente_id` AS `cliente_id` , "oferta" as tipo, `of`.`fecha_inicio` as `fecha_inicio` , `of`.`fecha_finaliza` as `fecha_finaliza` 
from `producto` `p` 
join `oferta` `of` on `of`.`producto_id` = `p`.`id` 
join `grupo_oferta` `gof` on `gof`.`oferta_id` = `of`.`id`
join `grupo` `g` on `g`.`id` = `gof`.`grupo_id`

union all

select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`ta`.`nuevo_costo` AS `nuevo_costo`,`g`.`cliente_id` AS `cliente_id` , "tarifa" as tipo, NULL AS `NULL`,NULL AS `NULL` 
from `producto` `p` 
join `tarifa` `ta` on `ta`.`producto_id` = `p`.`id` 
join `grupo_tarifa` `gta` on `gta`.`tarifa_id` = `ta`.`id`
join `grupo` `g` on `g`.`id` = `gta`.`grupo_id`

union all

select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,"9999999",NULL AS `NULL` , "normal" as tipo,NULL AS `NULL`,NULL AS `NULL` 
from `producto` `p`



/* FALTAN por poner*/


ALTER TABLE `mercabarato_bd`.`grupo` 
ADD COLUMN `tarifa_general_id` INT(10) UNSIGNED NOT NULL AFTER `cliente_id`,
ADD INDEX `fk_grupo_tarifa_general1_idx` (`tarifa_general_id` ASC);

ALTER TABLE `mercabarato_bd`.`tarifa` 
DROP COLUMN `comentario`,
DROP COLUMN `nombre`,
DROP COLUMN `porcentaje`,
ADD COLUMN `tarifa_general_id` INT(10) UNSIGNED NOT NULL AFTER `producto_id`,
ADD INDEX `fk_tarifa_tarifa_general1_idx` (`tarifa_general_id` ASC);

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`tarifa_general` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `fecha_creado` DATE NULL DEFAULT NULL,
  `porcentaje` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `mercabarato_bd`.`grupo_tarifa` ;

ALTER TABLE `mercabarato_bd`.`grupo` 
ADD CONSTRAINT `fk_grupo_tarifa_general1`
  FOREIGN KEY (`tarifa_general_id`)
  REFERENCES `mercabarato_bd`.`tarifa_general` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mercabarato_bd`.`tarifa` 
ADD CONSTRAINT `fk_tarifa_tarifa_general1`
  FOREIGN KEY (`tarifa_general_id`)
  REFERENCES `mercabarato_bd`.`tarifa_general` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

/* Segunda parte*/

ALTER TABLE `mercabarato_bd`.`grupo_oferta` 
DROP FOREIGN KEY `fk_grupo_oferta_oferta1`,
DROP FOREIGN KEY `fk_grupo_oferta_grupo1`;

ALTER TABLE `mercabarato_bd`.`grupo` 
ADD INDEX `fk_grupo_tarifa_general1_idx` (`tarifa_general_id` ASC),
DROP INDEX `fk_grupo_tarifa_general1_idx` , RENAME TO  `mercabarato_bd`.`grupo_tarifa` ;

ALTER TABLE `mercabarato_bd`.`oferta` 
DROP COLUMN `descripcion`,
DROP COLUMN `nombre`,
DROP COLUMN `fecha_finaliza`,
DROP COLUMN `fecha_inicio`,
DROP COLUMN `porcentaje`,
ADD COLUMN `oferta_general_id` INT(10) UNSIGNED NOT NULL AFTER `producto_id`,
ADD INDEX `fk_oferta_oferta_general1_idx` (`oferta_general_id` ASC);

ALTER TABLE `mercabarato_bd`.`grupo_oferta` 
DROP COLUMN `oferta_id`,
DROP COLUMN `grupo_id`,
ADD COLUMN `vendedor_id` INT(10) UNSIGNED NOT NULL AFTER `id`,
ADD COLUMN `cliente_id` INT(10) UNSIGNED NOT NULL AFTER `vendedor_id`,
ADD COLUMN `oferta_general_id` INT(10) UNSIGNED NOT NULL AFTER `cliente_id`,
ADD INDEX `fk_grupo_oferta_vendedor1_idx` (`vendedor_id` ASC),
ADD INDEX `fk_grupo_oferta_cliente1_idx` (`cliente_id` ASC),
ADD INDEX `fk_grupo_oferta_oferta_general1_idx` (`oferta_general_id` ASC),
DROP INDEX `fk_grupo_oferta_oferta1_idx` ,
DROP INDEX `fk_grupo_oferta_grupo1_idx` ;

ALTER TABLE `mercabarato_bd`.`tarifa` 
ADD INDEX `fk_tarifa_tarifa_general1_idx` (`tarifa_general_id` ASC),
DROP INDEX `fk_tarifa_tarifa_general1_idx` ;

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`oferta_general` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NULL DEFAULT NULL,
  `descripcion` TEXT NULL DEFAULT NULL,
  `porcentaje` INT(11) NULL DEFAULT NULL,
  `fecha_inicio` DATE NULL DEFAULT NULL,
  `fecha_finaliza` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

ALTER TABLE `mercabarato_bd`.`oferta` 
ADD CONSTRAINT `fk_oferta_oferta_general1`
  FOREIGN KEY (`oferta_general_id`)
  REFERENCES `mercabarato_bd`.`oferta_general` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mercabarato_bd`.`grupo_oferta` 
ADD CONSTRAINT `fk_grupo_oferta_vendedor1`
  FOREIGN KEY (`vendedor_id`)
  REFERENCES `mercabarato_bd`.`vendedor` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_grupo_oferta_cliente1`
  FOREIGN KEY (`cliente_id`)
  REFERENCES `mercabarato_bd`.`cliente` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_grupo_oferta_oferta_general1`
  FOREIGN KEY (`oferta_general_id`)
  REFERENCES `mercabarato_bd`.`oferta_general` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

/*  Tercera parte la View*/

CREATE VIEW `productos_precios` AS
select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`of`.`nuevo_costo` AS `nuevo_costo`,`g`.`cliente_id` AS `cliente_id` , "oferta" as tipo, `og`.`fecha_inicio` as `fecha_inicio` , `og`.`fecha_finaliza` as `fecha_finaliza` 
from `producto` `p` 
join `oferta` `of` on `of`.`producto_id` = `p`.`id` 
join `oferta_general` `og` on `og`.`id` = `of`.`oferta_general_id` 
join `grupo_oferta` `g` on `g`.`oferta_general_id` = `og`.`id`


union all

select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`ta`.`nuevo_costo` AS `nuevo_costo`,`g`.`cliente_id` AS `cliente_id` , "tarifa" as tipo, NULL AS `NULL`,NULL AS `NULL` 
from `producto` `p` 
join `tarifa` `ta` on `ta`.`producto_id` = `p`.`id` 
join `tarifa_general` `tg` on `tg`.`id` = `ta`.`tarifa_general_id`
join `grupo_tarifa` `g` on `g`.`tarifa_general_id` = `tg`.`id`

union all

select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,"9999999",NULL AS `NULL` , "normal" as tipo,NULL AS `NULL`,NULL AS `NULL` 
from `producto` `p`


/* */

ALTER TABLE `mercabarato_bd`.`grupo_oferta` 
DROP FOREIGN KEY `fk_grupo_oferta_vendedor1`;

ALTER TABLE `mercabarato_bd`.`grupo_oferta` 
DROP FOREIGN KEY `fk_grupo_oferta_vendedor1`;

ALTER TABLE `grupo_tarifa` DROP INDEX `fk_grupo_vendedor1_idx`
ALTER TABLE `grupo_tarifa` DROP `vendedor_id`