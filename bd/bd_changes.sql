

/* Cambios por implementar*/

UPDATE  `mercabarato_bd`.`permisos` SET  `controllers` = '{"admin": {"panel_vendedores": "*","panel_vendedores_anuncios": "*","panel_vendedores_productos": "*","panel_vendedores_invitaciones": "*","panel_vendedores_tarifas": "*","panel_vendedores_tarifas_helper":"*","panel_vendedores_infocompras":"*","panel_vendedores_ofertas":"*","panel_vendedores_ofertas_helper":"*"}}' WHERE  `permisos`.`id` =3;
