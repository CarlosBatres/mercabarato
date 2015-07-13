
ALTER TABLE `mercabarato_bd`.`vendedor` 
ADD COLUMN `nif_cif` VARCHAR(255) NULL DEFAULT NULL AFTER `filename`;

ALTER TABLE `mercabarato_bd`.`usuario` 
ADD COLUMN `secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `is_admin`;

ALTER TABLE `mercabarato_bd`.`usuario` 
ADD COLUMN `temporal` INT(1) NOT NULL DEFAULT 0 AFTER `is_admin`;

ALTER TABLE `mercabarato_bd`.`vendedor` 
ADD COLUMN `unique_slug` VARCHAR(255) NULL DEFAULT NULL AFTER `nif_cif`