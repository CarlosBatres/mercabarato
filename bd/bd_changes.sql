
ALTER TABLE `mercabarato_bd`.`vendedor` 
ADD COLUMN `nif_cif` VARCHAR(255) NULL DEFAULT NULL AFTER `filename`;

ALTER TABLE `mercabarato_bd`.`usuario` 
ADD COLUMN `secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `is_admin`;
