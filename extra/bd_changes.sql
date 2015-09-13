/*VISTAS*/

CREATE VIEW `productos_precios` AS 
select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` 
AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` 
AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` 
AS `unique_slug`,`of`.`nuevo_costo` AS `nuevo_costo`,`g`.`cliente_id` AS `cliente_id`,'oferta' COLLATE utf8_general_ci AS `tipo`  ,`og`.`fecha_inicio` AS `fecha_inicio`,`og`.`fecha_finaliza` 
AS `fecha_finaliza`,`of`.`id` AS `grupo_o_tarifa_id`,`og`.`grupo` AS `oferta_grupo` , `p`.`precio_anterior` AS `precio_anterior`,`p`.`fecha_precio_modificar` AS `fecha_precio_modificar` , `grupo_txt` AS `grupo_txt` , `familia_txt` AS `familia_txt` , `subfamilia_txt` AS `subfamilia_txt`
from (((`producto` `p` 
join `oferta` `of` on((`of`.`producto_id` = `p`.`id`))) 
join `oferta_general` `og` on((`og`.`id` = `of`.`oferta_general_id`))) 
left join `grupo_oferta` `g` on((`g`.`oferta_general_id` = `og`.`id`))) 
union all 
select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` 
AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` 
AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`ta`.`nuevo_costo` 
AS `nuevo_costo`,`g`.`cliente_id` AS `cliente_id`,'tarifa' COLLATE utf8_general_ci AS `tipo` , NULL AS `NULL`,NULL AS `NULL`,`ta`.`id` AS `grupo_o_tarifa_id`,NULL AS `NULL`
, `p`.`precio_anterior` AS `precio_anterior`,`p`.`fecha_precio_modificar` AS `fecha_precio_modificar` , `grupo_txt` AS `grupo_txt` , `familia_txt` AS `familia_txt` , `subfamilia_txt` AS `subfamilia_txt`
from (((`producto` `p` 
join `tarifa` `ta` on((`ta`.`producto_id` = `p`.`id`))) 
join `tarifa_general` `tg` on((`tg`.`id` = `ta`.`tarifa_general_id`))) 
join `grupo_tarifa` `g` on((`g`.`tarifa_general_id` = `tg`.`id`))) 
union all 
select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia`
AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` 
AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,'9999999' 
AS `9999999`,NULL AS `NULL`,'normal' COLLATE utf8_general_ci AS `tipo` ,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL`, `p`.`precio_anterior` AS `precio_anterior`
,`p`.`fecha_precio_modificar` AS `fecha_precio_modificar` , `grupo_txt` AS `grupo_txt` , `familia_txt` AS `familia_txt` , `subfamilia_txt` AS `subfamilia_txt`
from `producto` `p`;


CREATE VIEW `productos_localizacion` AS 
select `p`.`id` AS `producto_id`,`v`.`id` AS `vendedor_id`,`pa`.`id` AS `pais_id`,`pr`.`id` AS `provincia_id`,`pb`.`id` AS `poblacion_id` 
from (((((((`producto` `p` 
join `vendedor` `v` on((`v`.`id` = `p`.`vendedor_id`))) 
join `cliente` `c` on((`c`.`id` = `v`.`cliente_id`))) 
join `usuario` `u` on((`u`.`id` = `c`.`usuario_id`))) 
left join `localizacion` `l` on((`l`.`usuario_id` = `u`.`id`))) 
left join `pais` `pa` on((`pa`.`id` = `l`.`pais_id`))) 
left join `provincia` `pr` on((`pr`.`id` = `l`.`provincia_id`))) 
left join `poblacion` `pb` on((`pb`.`id` = `l`.`poblacion_id`)));

/* ---------------------------------------------- */
/*                                                */
/*             CAMBIOS POR IMPLEMENTAR            */
/*                                                */
/* -----------------------------------------------*/

/*  VOLVER A INSERTAR LA VIEW DE PRODUCTOS PRECIOS PORQUE CAMBIO*/

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `keywords` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

ALTER TABLE `keyword` ADD FULLTEXT INDEX `SEARCH`(`keywords`);

ALTER TABLE `cliente` 
CHANGE COLUMN `keyword` `keyword` INT(11) NULL DEFAULT NULL ;

ALTER TABLE `vendedor` 
CHANGE COLUMN `keyword` `keyword` INT(11) NULL DEFAULT NULL ;

ALTER TABLE `mercabarato_bd`.`producto` 
ADD COLUMN `transporte` INT(1) NULL DEFAULT NULL AFTER `unique_slug`,
ADD COLUMN `impuesto` INT(1) NULL DEFAULT NULL AFTER `transporte`,
ADD COLUMN `precio_anterior` FLOAT(10,2) NULL DEFAULT NULL AFTER `impuesto`,
ADD COLUMN `fecha_precio_modificar` DATE NULL DEFAULT NULL AFTER `precio_anterior`;


CREATE TABLE IF NOT EXISTS `punto_venta` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(255) NULL DEFAULT NULL,
  `direccion` VARCHAR(255) NULL DEFAULT NULL,
  `vendedor_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_punto_venta_vendedor1_idx` (`vendedor_id` ASC),
  CONSTRAINT `fk_punto_venta_vendedor1`
    FOREIGN KEY (`vendedor_id`)
    REFERENCES `mercabarato_bd`.`vendedor` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `producto_extra` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` INT(10) UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NULL DEFAULT NULL,
  `value` VARCHAR(255) NULL DEFAULT NULL,
  `tipo` INT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_producto_extra_producto1_idx` (`producto_id` ASC),
  CONSTRAINT `fk_producto_extra_producto1`
    FOREIGN KEY (`producto_id`)
    REFERENCES `mercabarato_bd`.`producto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


UPDATE  `permisos` SET  `controllers` =  '{"admin": {"main": "*","usuario": "*","vendedor":{"view_listado":"*","ajax_get_listado_resultados":"*","habilitar":"*","inhabilitar":"*","borrar":"*"},"cliente": "*","producto": "*","anuncio": "*"}}' WHERE `permisos`.`id` =2;


ALTER TABLE `mensaje` 
DROP COLUMN `visto`,
DROP COLUMN `contenido`,
DROP COLUMN `asunto`,
DROP COLUMN `para`,
DROP COLUMN `desde`,
ADD COLUMN `solicitud_seguro_id` INT(10) UNSIGNED NOT NULL AFTER `id`,
ADD COLUMN `numero` INT(1) NULL DEFAULT 1 COMMENT 'Orden de los mensajes' AFTER `solicitud_seguro_id`,
ADD COLUMN `enviado_por` INT(1) NULL DEFAULT 0 COMMENT '0=Vendedor,1=Cliente' AFTER `numero`,
ADD COLUMN `mensaje` TEXT NULL DEFAULT NULL AFTER `enviado_por`,
ADD COLUMN `fecha` DATE NULL DEFAULT NULL AFTER `mensaje`,
ADD INDEX `fk_mensaje_solicitud_seguro1_idx` (`solicitud_seguro_id` ASC);

ALTER TABLE `solicitud_seguro` 
DROP COLUMN `fecha_respuesta`,
DROP COLUMN `respuesta`,
CHANGE COLUMN `estado` `estado` INT(1) NULL DEFAULT 0 COMMENT '0=Enviada,1=Respondida,2=Cerrada' ,
ADD COLUMN `ventajas` TEXT NULL DEFAULT NULL AFTER `datos`,
ADD COLUMN `precio` FLOAT(10,2) NULL DEFAULT NULL AFTER `estado`;

ALTER TABLE `mensaje` 
ADD CONSTRAINT `fk_mensaje_solicitud_seguro1`
  FOREIGN KEY (`solicitud_seguro_id`)
  REFERENCES `mercabarato_bd`.`solicitud_seguro` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `producto` 
ADD COLUMN `grupo_txt` VARCHAR(23) NULL DEFAULT NULL AFTER `fecha_precio_modificar`,
ADD COLUMN `familia_txt` VARCHAR(23) NULL DEFAULT NULL AFTER `grupo_txt`,
ADD COLUMN `subfamilia_txt` VARCHAR(23) NULL DEFAULT NULL AFTER `familia_txt`;
