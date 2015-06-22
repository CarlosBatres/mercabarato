-------------------------------
-- 21/06/2015
--------------------------------

ALTER TABLE `mercabarato_bd`.`vendedor_paquete` 
DROP FOREIGN KEY `fk_vendedor_paquete_paquete1`;

ALTER TABLE `mercabarato_bd`.`vendedor_paquete` 
DROP COLUMN `anuncios_insertados`,
DROP COLUMN `productos_insertados`,
DROP COLUMN `paquete_id`,
ADD COLUMN `nombre_paquete` VARCHAR(255) NOT NULL AFTER `vendedor_id`,
ADD COLUMN `duracion_paquete` INT(11) NOT NULL AFTER `nombre_paquete`,
ADD INDEX `fk_vendedor_paquete_vendedor1_idx` (`vendedor_id` ASC),
DROP INDEX `fk_vendedor_paquete_vendedor1_idx` ,
DROP INDEX `fk_vendedor_paquete_paquete1_idx` ;
