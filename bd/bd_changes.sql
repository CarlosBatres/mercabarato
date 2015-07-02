-------------------------------
-- 
--------------------------------

ALTER TABLE `mercabarato_bd`.`producto` 
ADD COLUMN `link_externo` VARCHAR(255) NULL DEFAULT NULL AFTER `fecha_insertado`;