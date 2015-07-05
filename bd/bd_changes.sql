-------------------------------
-- Vistra productos_localizacion
--------------------------------

create view `productos_localizacion` 
AS select `p`.`id` AS `producto_id`,`v`.`id` AS `vendedor_id`,`pa`.`id` AS `pais_id`,`pr`.`id` AS `provincia_id`,`pb`.`id` AS `poblacion_id` 
from (((((((`producto` `p` join `vendedor` `v` on((`v`.`id` = `p`.`vendedor_id`))) 
join `cliente` `c` on((`c`.`id` = `v`.`cliente_id`))) 
join `usuario` `u` on((`u`.`id` = `c`.`usuario_id`))) 
left join `localizacion` `l` on((`l`.`usuario_id` = `u`.`id`))) 
left join `pais` `pa` on((`pa`.`id` = `l`.`pais_id`))) 
left join `provincia` `pr` on((`pr`.`id` = `l`.`provincia_id`))) 
left join `poblacion` `pb` on((`pb`.`id` = `l`.`poblacion_id`)));



ALTER TABLE `mercabarato_bd`.`vendedor` 
ADD COLUMN `filename` VARCHAR(255) NULL DEFAULT NULL AFTER `keyword`;


CREATE TABLE IF NOT EXISTS `mercabarato_bd`.`tarifa` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` INT(10) UNSIGNED NOT NULL,  
  `monto` FLOAT(10,2) NULL DEFAULT NULL,
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