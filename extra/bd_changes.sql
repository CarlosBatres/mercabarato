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


DELIMITER $$
  DROP FUNCTION IF EXISTS `DBName`.`getWorkingday`$$
  CREATE  FUNCTION `getWorkingday`(d1 datetime,d2 datetime, retType varchar(20)) RETURNS varchar(255) CHARSET utf8
  BEGIN
 DECLARE dow1, dow2,daydiff,workdays, weekenddays, retdays,hourdiff INT;
    declare newstrt_dt datetime;
   SELECT dd.iDiff, dd.iDiff - dd.iWeekEndDays AS iWorkDays, dd.iWeekEndDays into daydiff, workdays, weekenddays
  FROM (
   SELECT
     dd.iDiff,
     ((dd.iWeeks * 2) + 
      IF(dd.iSatDiff >= 0 AND dd.iSatDiff < dd.iDays, 1, 0) + 
      IF (dd.iSunDiff >= 0 AND dd.iSunDiff < dd.iDays, 1, 0)) AS iWeekEndDays
       FROM (
      SELECT  dd.iDiff, FLOOR(dd.iDiff / 7) AS iWeeks, dd.iDiff % 7 iDays, 5 - dd.iStartDay AS iSatDiff,  6 - dd.iStartDay AS iSunDiff
     FROM (
      SELECT
        1 + DATEDIFF(d2, d1) AS iDiff,
        WEEKDAY(d1) AS iStartDay
      ) AS dd
    ) AS dd
  ) AS dd ;
  if(retType = 'day_diffs') then
  set retdays = daydiff; 
 elseif(retType = 'work_days') then
  set retdays = workdays; 
 elseif(retType = 'weekend_days') then  
  set retdays = weekenddays; 
 end if; 
    RETURN retdays; 
    END$$
  DELIMITER ;


/* ---------------------------------------------- */
/*                                                */
/*             CAMBIOS POR IMPLEMENTAR            */
/*                                                */
/* -----------------------------------------------*/

/*ALTER TABLE `mercabarato_bd`.`vendedor_paquete` 
ADD COLUMN `anuncios_publicados` INT(11) NULL DEFAULT 0 AFTER `limite_anuncios`;*/

ALTER TABLE `infocompra`
ADD COLUMN `extendido` INT(1) NULL DEFAULT 0 AFTER `infocompra_general`;