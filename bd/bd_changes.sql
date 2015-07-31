/*VISTAS*/


CREATE VIEW `productos_precios` AS select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`of`.`nuevo_costo` AS `nuevo_costo`,`g`.`cliente_id` AS `cliente_id`,'oferta' AS `tipo`,`og`.`fecha_inicio` AS `fecha_inicio`,`og`.`fecha_finaliza` AS `fecha_finaliza`,`of`.`id` AS `grupo_o_tarifa_id`,`og`.`grupo` AS `oferta_grupo` from (((`producto` `p` join `oferta` `of` on((`of`.`producto_id` = `p`.`id`))) join `oferta_general` `og` on((`og`.`id` = `of`.`oferta_general_id`))) left join `grupo_oferta` `g` on((`g`.`oferta_general_id` = `og`.`id`))) union all select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`ta`.`nuevo_costo` AS `nuevo_costo`,`g`.`cliente_id` AS `cliente_id`,'tarifa' AS `tipo`,NULL AS `NULL`,NULL AS `NULL`,`ta`.`id` AS `grupo_o_tarifa_id`,NULL AS `NULL` from (((`producto` `p` join `tarifa` `ta` on((`ta`.`producto_id` = `p`.`id`))) join `tarifa_general` `tg` on((`tg`.`id` = `ta`.`tarifa_general_id`))) join `grupo_tarifa` `g` on((`g`.`tarifa_general_id` = `tg`.`id`))) union all select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,'9999999' AS `9999999`,NULL AS `NULL`,'normal' AS `tipo`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL`,NULL AS `NULL` from `producto` `p`;

/* Cambios por implementar*/

UPDATE  `mercabarato_bd`.`permisos` SET  `controllers` = '{"admin": {"panel_vendedores": "*","panel_vendedores_anuncios": "*","panel_vendedores_productos": "*","panel_vendedores_invitaciones": "*","panel_vendedores_tarifas": "*","panel_vendedores_tarifas_helper":"*","panel_vendedores_infocompras":"*","panel_vendedores_ofertas":"*","panel_vendedores_ofertas_helper":"*","panel_vendedores_ofertas2":"*","panel_vendedores_ofertas2_helper":"*"}}' WHERE  `permisos`.`id` =3;


ALTER TABLE `mercabarato_bd`.`grupo_oferta` 
ADD COLUMN `codigo` VARCHAR(100) NULL DEFAULT NULL AFTER `oferta_general_id`;

ALTER TABLE `mercabarato_bd`.`visita` 
CHANGE COLUMN `cliente_id` `cliente_id` INT(10) UNSIGNED NOT NULL ;

CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`requisito_visitas` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` INT(11) NULL DEFAULT NULL,
  `visitas` INT(11) NULL DEFAULT NULL,
  `oferta_general_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_requisito_visitas_oferta_general1_idx` (`oferta_general_id` ASC),
  CONSTRAINT `fk_requisito_visitas_oferta_general1`
    FOREIGN KEY (`oferta_general_id`)
    REFERENCES `mercabarato_bd`.`oferta_general` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

ALTER TABLE `mercabarato_bd`.`visita` 
DROP FOREIGN KEY `fk_visita_cliente1`;

ALTER TABLE `mercabarato_bd`.`visita` ADD CONSTRAINT `fk_visita_cliente1`
  FOREIGN KEY (`cliente_id`)
  REFERENCES `mercabarato_bd`.`cliente` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `mercabarato_bd`.`invitacion` 
CHANGE COLUMN `invitar_desde` `invitar_desde` INT(11) NOT NULL COMMENT 'usuario_id' ,
CHANGE COLUMN `invitar_para` `invitar_para` INT(11) NOT NULL COMMENT 'usuario_id' ;

ALTER TABLE `mercabarato_bd`.`oferta_general` 
ADD COLUMN `grupo` INT(11) NULL DEFAULT 0 COMMENT '0=todos,1=invitados,2=no invitados' AFTER `fecha_finaliza`;

ALTER TABLE `mercabarato_bd`.`oferta_general` 
ADD COLUMN `owner_vendedor_id` INT(11) NULL DEFAULT NULL AFTER `grupo`;
