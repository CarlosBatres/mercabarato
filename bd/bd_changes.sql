
CREATE VIEW `productos_precios` AS select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`ta`.`nuevo_costo` AS `tarifa_costo`,`g`.`cliente_id` AS `cliente_id` from (((`producto` `p` join `tarifa` `ta` on((`ta`.`producto_id` = `p`.`id`))) join `grupo_tarifa` `gta` on((`gta`.`tarifa_id` = `ta`.`id`))) join `grupo` `g` on((`g`.`id` = `gta`.`grupo_id`))) union select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,NULL AS `NULL`,NULL AS `NULL` from `producto` `p`;

ALTER TABLE `mercabarato_bd`.`producto` 
ADD COLUMN `unique_slug` VARCHAR(255) NULL DEFAULT NULL AFTER `link_externo`;


ALTER TABLE `mercabarato_bd`.`invitacion` 
DROP COLUMN `from_vendedor`,
ADD COLUMN `enviado_por` INT(11) NOT NULL AFTER `cliente_id`;

/* ULTIMO FALTA */

ALTER TABLE `mercabarato_bd`.`invitacion` 
DROP FOREIGN KEY `fk_invitacion_vendedor1`,
DROP FOREIGN KEY `fk_invitacion_cliente1`;

ALTER TABLE `mercabarato_bd`.`invitacion` 
DROP COLUMN `enviado_por`,
DROP COLUMN `cliente_id`,
DROP COLUMN `vendedor_id`,
ADD COLUMN `invitar_desde` INT(11) NOT NULL AFTER `estado`,
ADD COLUMN `invitar_para` INT(11) NOT NULL AFTER `invitar_desde`,
DROP INDEX `fk_invitacion_cliente1_idx` ,
DROP INDEX `fk_invitacion_vendedor1_idx` ;