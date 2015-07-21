
CREATE VIEW `productos_precios` AS select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,`ta`.`nuevo_costo` AS `tarifa_costo`,`g`.`cliente_id` AS `cliente_id` from (((`producto` `p` join `tarifa` `ta` on((`ta`.`producto_id` = `p`.`id`))) join `grupo_tarifa` `gta` on((`gta`.`tarifa_id` = `ta`.`id`))) join `grupo` `g` on((`g`.`id` = `gta`.`grupo_id`))) union select `p`.`id` AS `id`,`p`.`categoria_id` AS `categoria_id`,`p`.`vendedor_id` AS `vendedor_id`,`p`.`nombre` AS `nombre`,`p`.`descripcion` AS `descripcion`,`p`.`referencia` AS `referencia`,`p`.`precio` AS `precio`,`p`.`mostrar_precio` AS `mostrar_precio`,`p`.`mostrar_producto` AS `mostrar_producto`,`p`.`habilitado` AS `habilitado`,`p`.`fecha_insertado` AS `fecha_insertado`,`p`.`link_externo` AS `link_externo`,`p`.`unique_slug` AS `unique_slug`,NULL AS `NULL`,NULL AS `NULL` from `producto` `p`;

/* FALTAN por poner*/

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







