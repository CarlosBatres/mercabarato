<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

/* Front */
$route[''] = 'home/producto/view_principal';
$route['login'] = 'home/usuario/login';
$route['logout'] = 'home/usuario/logout';
$route['olvido-password'] = 'home/usuario/olvido_password';
$route['cambio-password/(:any)'] = 'home/usuario/olvido_cambio_password/$1';
$route['cambio-password'] = 'home/usuario/modificar_password_olvido';
$route['cambio-password-realizado'] = 'home/usuario/cambio_password_realizado';
$route['registro'] = 'home/usuario/view_registro';
$route['confirmar_registro/(:any)'] = 'home/usuario/verificar_email/$1';
$route['registro_exitoso'] = 'home/usuario/view_registro_exito';
$route['registrar_cliente'] = 'home/cliente/crear';
$route['registrar_vendedor'] = 'home/vendedor/new_vendedor';
$route['vendedores'] = 'home/vendedor/view_buscador';
$route['acceso_restringido'] = 'home/main/acceso_restringido';
$route['productos/enviar_mensaje/(:num)'] = 'home/producto/enviar_mensaje/$1';
$route['productos/buscar'] = 'home/producto/ajax_get_listado_resultados';
$route['productos/buscar_producto/(:any)'] = 'home/producto/buscar_producto/$1';
$route['productos/(:any)'] = 'home/producto/ver_producto/$1';
$route['vendedores/buscar'] = 'home/vendedor/ajax_get_listado_resultados';
$route['anuncios/(:num)'] = 'home/anuncio/ver_anuncio/$1';

$route['seguros'] = 'home/seguro/view_seguros';
$route['seguros/registrar'] = 'home/seguro/registrar_seguro';
$route['seguros/enviar'] = 'home/seguro/crear_solicitud_seguro';
$route['seguros/buscar_prestadores'] = 'home/seguro/ajax_get_listado_resultados_prestadores';
$route['seguros/finalizar'] = 'home/seguro/finalizar';
$route['usuario/perfil'] = 'home/usuario/view_perfil';
$route['usuario/datos-personales'] = 'home/usuario/view_datos_personales';
$route['usuario/datos-personales/modificar'] = 'home/usuario/modificar_datos';
$route['usuario/datos-vendedor'] = 'home/vendedor/view_datos_vendedor';
$route['usuario/datos-vendedor/modificar'] = 'home/vendedor/modificar_datos';
$route['usuario/password'] = 'home/usuario/view_password';
$route['usuario/password/modificar'] = 'home/usuario/modificar_password';
$route['usuario/afiliacion'] = 'home/vendedor/view_afiliarse';
$route['usuario/afiliacion/registrar'] = 'home/vendedor/cliente_a_vendedor';
$route['usuario/afiliacion-paso2'] = 'home/vendedor/view_seleccionar_paquete';
$route['usuario/afiliacion-final/(:num)'] = 'home/vendedor/submit_afiliacion/$1';
$route['usuario/completado'] = 'home/vendedor/view_completado';
$route['usuario/panel_vendedor'] = 'home/vendedor/ir_panel_vendedor';
$route['usuario/contactos'] = 'home/cliente/view_invitaciones';
$route['usuario/contactos/aceptar_invitacion'] = 'home/cliente/aceptar_invitacion';
$route['usuario/contactos/rechazar_invitacion'] = 'home/cliente/rechazar_invitacion';
$route['usuario/contactos/eliminar'] = 'home/cliente/eliminar_invitacion';
$route['usuario/contactos/sin_notificaciones'] = 'home/cliente/sin_notificaciones';
$route['usuario/contactos/con_notificaciones'] = 'home/cliente/con_notificaciones';
$route['usuario/enviar_invitacion'] = 'home/cliente/enviar_invitacion';
$route['usuario/mis-paquetes'] = 'home/vendedor/mis_paquetes';
$route['usuario/paquetes/comprar'] = 'home/vendedor/comprar_paquetes';
$route['usuario/paquetes/comprar_paquete/(:any)'] = 'home/vendedor/submit_comprar_paquetes/$1';
$route['usuario/paquetes/renovar'] = 'home/vendedor/renovar_paquetes';
$route['usuario/paquetes/renovar_paquete/(:any)'] = 'home/vendedor/submit_renovar_paquetes/$1';
$route['usuario/buscar_invitaciones'] = 'home/cliente/ajax_get_listado_resultados_invitaciones';
$route['usuario/infocompras-seguros'] = 'home/cliente/view_infocompras_seguros';
$route['usuario/infocompras-seguros/respuesta/(:num)'] = 'home/cliente/view_seguros_respuesta/$1';
$route['usuario/infocompras-seguros/descargar_respuesta/(:any)'] = 'home/cliente/seguros_download_respuesta/$1';
$route['usuario/buscar-solicitudes-seguros'] = 'home/cliente/ajax_get_listado_seguros';

$route['util/verificar_email'] = 'home/usuario/check_email';
$route['util/verificar_nombre'] = 'home/main/verificar_palabra';
$route['util/get_poblaciones'] = 'home/poblacion/ajax_get_poblaciones_htmlselect';
$route['util/get_provincias'] = 'home/provincia/ajax_get_provincias_htmlselect';
$route['util/upload_vendedor_image'] = 'home/vendedor/upload_image';

$route['site/contacto'] = 'home/main/contacto';
$route['site/contacto/submit'] = 'home/main/contacto_submit';
$route['site/quienes-somos'] = 'home/main/quienes_somos';
$route['site/como-funciona'] = 'home/main/como_funciona';
$route['site/aviso-legal'] = 'home/main/aviso_legal';
$route['site/terminos-de-uso'] = 'home/main/terminos_de_uso';
$route['site/politica-de-cookies'] = 'home/main/cookies';

/* Apartado para vendedores */

$route['panel_vendedor'] = 'admin/panel_vendedores/resumen';
$route['panel_vendedor/resumen'] = 'admin/panel_vendedores/resumen';
$route['panel_vendedor/regresar'] = 'admin/panel_vendedores/regresar';
$route['panel_vendedor/login'] = 'admin/panel_vendedores/login';
$route['panel_vendedor/logout'] = 'admin/panel_vendedores/logout';
$route['panel_vendedor/visitas/get_estadisticas'] = 'admin/panel_vendedores/get_visitas_estadisticas';
$route['panel_vendedor/invitaciones/buscar'] = 'admin/panel_vendedores_invitaciones/buscador';
$route['panel_vendedor/invitaciones/get_mensaje_invitacion/(:num)'] = 'admin/panel_vendedores_invitaciones/get_mensaje_invitacion/$1';
$route['panel_vendedor/invitaciones/pendientes'] = 'admin/panel_vendedores_invitaciones/pendientes';
$route['panel_vendedor/invitaciones/recibidas'] = 'admin/panel_vendedores_invitaciones/recibidas';
$route['panel_vendedor/invitaciones/aceptadas'] = 'admin/panel_vendedores_invitaciones/aceptadas';
$route['panel_vendedor/invitaciones/envio_email'] = 'admin/panel_vendedores_invitaciones/enviar_invitacion_email';
$route['panel_vendedor/invitaciones/aceptar/(:num)'] = 'admin/panel_vendedores_invitaciones/aceptar_invitacion/$1';
$route['panel_vendedor/invitaciones/rechazar/(:num)'] = 'admin/panel_vendedores_invitaciones/rechazar_invitacion/$1';
$route['panel_vendedor/invitaciones/enviar/(:num)'] = 'admin/panel_vendedores_invitaciones/enviar_invitacion/$1';
$route['panel_vendedor/invitaciones/ajax_invitaciones_aceptadas'] = 'admin/panel_vendedores_invitaciones/ajax_invitaciones_aceptadas';
$route['panel_vendedor/invitaciones/ajax_invitaciones_pendientes'] = 'admin/panel_vendedores_invitaciones/ajax_invitaciones_pendientes';
$route['panel_vendedor/invitaciones/ajax_invitaciones_recibidas'] = 'admin/panel_vendedores_invitaciones/ajax_invitaciones_recibidas';

$route['panel_vendedor/invitaciones/ajax_get_listado_clientes'] = 'admin/panel_vendedores_invitaciones/ajax_get_listado_clientes';
$route['panel_vendedor/producto/listado'] = 'admin/panel_vendedores_productos/listado';
$route['panel_vendedor/producto/agregar'] = 'admin/panel_vendedores_productos/agregar';
$route['panel_vendedor/producto/agregar-varios'] = 'admin/panel_vendedores_productos/agregar_varios';
$route['panel_vendedor/producto/agregar-varios-resumen'] = 'admin/panel_vendedores_productos/agregar_varios_resumen';
$route['panel_vendedor/producto/borrar/(:num)'] = 'admin/panel_vendedores_productos/borrar/$1';
$route['panel_vendedor/producto/editar/(:num)'] = 'admin/panel_vendedores_productos/editar/$1';
$route['panel_vendedor/producto/habilitar/(:num)'] = 'admin/panel_vendedores_productos/habilitar/$1';
$route['panel_vendedor/producto/inhabilitar/(:num)'] = 'admin/panel_vendedores_productos/inhabilitar/$1';
$route['panel_vendedor/producto/upload_image'] = 'admin/panel_vendedores/upload_image';
$route['panel_vendedor/producto/ajax_get_listado_resultados'] = 'admin/panel_vendedores_productos/ajax_get_listado_resultados';
$route['panel_vendedor/anuncio/listado'] = 'admin/panel_vendedores_anuncios/listado';
$route['panel_vendedor/anuncio/agregar'] = 'admin/panel_vendedores_anuncios/agregar';
$route['panel_vendedor/anuncio/borrar/(:num)'] = 'admin/panel_vendedores_anuncios/borrar/$1';
$route['panel_vendedor/anuncio/editar/(:num)'] = 'admin/panel_vendedores_anuncios/editar/$1';
$route['panel_vendedor/anuncio/habilitar/(:num)'] = 'admin/panel_vendedores_anuncios/habilitar/$1';
$route['panel_vendedor/anuncio/inhabilitar/(:num)'] = 'admin/panel_vendedores_anuncios/inhabilitar/$1';
$route['panel_vendedor/anuncio/ajax_get_listado_resultados'] = 'admin/panel_vendedores_anuncios/ajax_get_listado_resultados';
$route['panel_vendedor/tarifas/nueva'] = 'admin/panel_vendedores_tarifas/nueva_tarifa_paso1';
$route['panel_vendedor/tarifas/seleccion_clientes'] = 'admin/panel_vendedores_tarifas/nueva_seleccion_clientes';
$route['panel_vendedor/tarifas/detalles'] = 'admin/panel_vendedores_tarifas/detalles_tarifa';
$route['panel_vendedor/tarifas/crear'] = 'admin/panel_vendedores_tarifas/crear_tarifa';
$route['panel_vendedor/tarifas/borrar/(:num)'] = 'admin/panel_vendedores_tarifas/borrar/$1';
$route['panel_vendedor/tarifas/ver-tarifa/(:num)'] = 'admin/panel_vendedores_tarifas/ver_tarifa/$1';
$route['panel_vendedor/tarifas/modificar-clientes/(:num)'] = 'admin/panel_vendedores_tarifas/modificar_clientes/$1';
$route['panel_vendedor/tarifas/modificar-productos/(:num)'] = 'admin/panel_vendedores_tarifas/modificar_productos/$1';
$route['panel_vendedor/tarifas/listado'] = 'admin/panel_vendedores_tarifas/view_listado';
$route['panel_vendedor/tarifas/ajax_get_productos'] = 'admin/panel_vendedores_tarifas_helper/ajax_get_productos';
$route['panel_vendedor/tarifas/ajax_get_clientes'] = 'admin/panel_vendedores_tarifas_helper/ajax_get_clientes';
$route['panel_vendedor/tarifas/ajax_get_productos_tarifados'] = 'admin/panel_vendedores_tarifas_helper/ajax_get_productos_tarifados';
$route['panel_vendedor/tarifas/ajax_get_clientes_tarifados'] = 'admin/panel_vendedores_tarifas_helper/ajax_get_clientes_tarifados';
$route['panel_vendedor/tarifas/ajax_get_tarifas'] = 'admin/panel_vendedores_tarifas_helper/ajax_get_tarifas';
$route['panel_vendedor/tarifas/ajax_get_tarifa_detalles'] = 'admin/panel_vendedores_tarifas_helper/ajax_get_tarifa_detalles';
$route['panel_vendedor/tarifas/ajax_incluir_clientes'] = 'admin/panel_vendedores_tarifas_helper/ajax_incluir_clientes';
$route['panel_vendedor/tarifas/ajax_remover_clientes'] = 'admin/panel_vendedores_tarifas_helper/ajax_remover_clientes';
$route['panel_vendedor/tarifas/ajax_incluir_productos'] = 'admin/panel_vendedores_tarifas_helper/ajax_incluir_productos';
$route['panel_vendedor/tarifas/ajax_remover_productos'] = 'admin/panel_vendedores_tarifas_helper/ajax_remover_productos';
$route['panel_vendedor/tarifas/ajax_modificar_costo_tarifa'] = 'admin/panel_vendedores_tarifas_helper/ajax_modificar_costo_tarifa';
$route['panel_vendedor/tarifas/ajax_modificar_productos'] = 'admin/panel_vendedores_tarifas_helper/ajax_modificar_productos';
$route['panel_vendedor/tarifas/incluir_todos_productos'] = 'admin/panel_vendedores_tarifas_helper/incluir_todos_productos';
$route['panel_vendedor/tarifas/incluir_todos_clientes'] = 'admin/panel_vendedores_tarifas_helper/incluir_todos_clientes';

$route['panel_vendedor/infocompras/seguros'] = 'admin/panel_vendedores_infocompras/view_listado_seguros';
$route['panel_vendedor/infocompras/seguros/responder/(:num)'] = 'admin/panel_vendedores_infocompras/responder_seguros/$1';
$route['panel_vendedor/infocompras/ajax_get_seguros'] = 'admin/panel_vendedores_infocompras/ajax_get_seguros';

$route['panel_vendedor/ofertas/listado'] = 'admin/panel_vendedores_ofertas2/view_listado';
$route['panel_vendedor/ofertas/nueva'] = 'admin/panel_vendedores_ofertas2/nueva_oferta';
$route['panel_vendedor/ofertas/crear'] = 'admin/panel_vendedores_ofertas2/crear_oferta';
$route['panel_vendedor/ofertas/ver-oferta/(:num)'] = 'admin/panel_vendedores_ofertas2/ver_oferta/$1';
$route['panel_vendedor/ofertas/ver-oferta-clientes/(:num)'] = 'admin/panel_vendedores_ofertas2/ver_oferta_clientes/$1';
$route['panel_vendedor/ofertas/ajax_get_productos_ofertados'] = 'admin/panel_vendedores_ofertas2_helper/ajax_get_productos_ofertados';
$route['panel_vendedor/ofertas/ajax_get_requisitos'] = 'admin/panel_vendedores_ofertas2_helper/ajax_get_requisitos';
$route['panel_vendedor/ofertas/ajax_get_requisitos_disponibles'] = 'admin/panel_vendedores_ofertas2_helper/ajax_get_requisitos_disponibles';
$route['panel_vendedor/ofertas/modificar-productos/(:num)'] = 'admin/panel_vendedores_ofertas2/modificar_productos/$1';
$route['panel_vendedor/ofertas/ajax_get_productos'] = 'admin/panel_vendedores_ofertas2_helper/ajax_get_productos';
$route['panel_vendedor/ofertas/ajax_incluir_productos'] = 'admin/panel_vendedores_ofertas2_helper/ajax_incluir_productos';
$route['panel_vendedor/ofertas/ajax_remover_productos'] = 'admin/panel_vendedores_ofertas2_helper/ajax_remover_productos';
$route['panel_vendedor/ofertas/ajax_incluir_clientes'] = 'admin/panel_vendedores_ofertas2_helper/ajax_incluir_clientes';
$route['panel_vendedor/ofertas/ajax_remover_clientes'] = 'admin/panel_vendedores_ofertas2_helper/ajax_remover_clientes';
$route['panel_vendedor/ofertas/ajax_modificar_costo_oferta'] = 'admin/panel_vendedores_ofertas2_helper/ajax_modificar_costo_oferta';
$route['panel_vendedor/ofertas/ajax_modificar_productos'] = 'admin/panel_vendedores_ofertas2_helper/ajax_modificar_productos';
$route['panel_vendedor/ofertas/ajax_get_ofertas'] = 'admin/panel_vendedores_ofertas2_helper/ajax_get_ofertas';
$route['panel_vendedor/ofertas/borrar/(:num)'] = 'admin/panel_vendedores_ofertas2/borrar/$1';
$route['panel_vendedor/ofertas/modificar-datos/(:num)'] = 'admin/panel_vendedores_ofertas2/modificar_datos/$1';
$route['panel_vendedor/ofertas/modificar-requisitos/(:num)'] = 'admin/panel_vendedores_ofertas2/modificar_requisitos/$1';
$route['panel_vendedor/ofertas/ajax_incluir_requisitos'] = 'admin/panel_vendedores_ofertas2_helper/ajax_incluir_requisitos';
$route['panel_vendedor/ofertas/ajax_remover_requisitos'] = 'admin/panel_vendedores_ofertas2_helper/ajax_remover_requisitos';
$route['panel_vendedor/ofertas/ajax_get_clientes_oferta'] = 'admin/panel_vendedores_ofertas2_helper/ajax_get_clientes_oferta';

//$route['panel_vendedor/ofertas/seleccion_clientes'] = 'admin/panel_vendedores_ofertas/nueva_seleccion_clientes';
//$route['panel_vendedor/ofertas/detalles'] = 'admin/panel_vendedores_ofertas/detalles_oferta';
//$route['panel_vendedor/ofertas/ajax_get_clientes'] = 'admin/panel_vendedores_ofertas_helper/ajax_get_clientes';
//$route['panel_vendedor/ofertas/ajax_get_clientes_ofertados'] = 'admin/panel_vendedores_ofertas_helper/ajax_get_clientes_ofertados';
//$route['panel_vendedor/ofertas/ajax_get_oferta_detalles'] = 'admin/panel_vendedores_ofertas_helper/ajax_get_oferta_detalles';
//$route['panel_vendedor/ofertas/modificar-clientes/(:num)'] = 'admin/panel_vendedores_ofertas/modificar_clientes/$1';

$route['panel_vendedor/ofertas/incluir_todos_productos'] = 'admin/panel_vendedores_ofertas_helper/incluir_todos_productos';
$route['panel_vendedor/ofertas/incluir_todos_clientes'] = 'admin/panel_vendedores_ofertas_helper/incluir_todos_clientes';




 

/* Admin */
$route['admin'] = 'admin/main';
$route['admin/resumen'] = 'admin/main/dashboard';
$route['admin/login'] = 'admin/usuario/login';
$route['admin/logout'] = 'admin/usuario/logout';
$route['admin/sin_permiso'] = 'admin/usuario/sin_permiso';
$route['admin/productos'] = 'admin/producto/view_listado';
$route['admin/productos/crear'] = 'admin/producto/crear';
$route['admin/productos/editar/(:num)'] = 'admin/producto/editar/$1';
$route['admin/productos/borrar/(:num)'] = 'admin/producto/borrar/$1';
$route['admin/producto/ajax_get_listado_resultados'] = 'admin/producto/ajax_get_listado_resultados';
$route['admin/usuarios'] = 'admin/cliente/view_listado';
$route['admin/usuarios/crear'] = 'admin/cliente/crear';
$route['admin/usuarios/editar/(:num)'] = 'admin/cliente/editar/$1';
$route['admin/usuarios/borrar/(:num)'] = 'admin/cliente/borrar/$1';
$route['admin/usuarios/inhabilitar/(:num)'] = 'admin/cliente/inhabilitar/$1';
$route['admin/usuarios/habilitar/(:num)'] = 'admin/cliente/habilitar/$1';
$route['admin/cliente/ajax_get_listado_resultados'] = 'admin/cliente/ajax_get_listado_resultados';
$route['admin/vendedores'] = 'admin/vendedor/view_listado';
$route['admin/vendedores/crear'] = 'admin/vendedor/crear';
$route['admin/vendedores/editar/(:num)'] = 'admin/vendedor/editar/$1';
$route['admin/vendedores/borrar/(:num)'] = 'admin/vendedor/borrar/$1';
$route['admin/vendedores/inhabilitar/(:num)'] = 'admin/vendedor/inhabilitar/$1';
$route['admin/vendedores/habilitar/(:num)'] = 'admin/vendedor/habilitar/$1';
$route['admin/vendedores/autocomplete'] = 'admin/vendedor/autocomplete';
$route['admin/vendedores_lista_control'] = 'admin/vendedor/view_listado_control';
$route['admin/vendedor/ajax_get_listado_resultados'] = 'admin/vendedor/ajax_get_listado_resultados';
$route['admin/categorias'] = 'admin/categoria/view_listado';
$route['admin/categorias/crear'] = 'admin/categoria/crear/0';
$route['admin/categorias/crear/(:num)'] = 'admin/categoria/crear/$1';
$route['admin/categorias/editar/(:num)'] = 'admin/categoria/editar/$1';
$route['admin/categorias/borrar/(:num)'] = 'admin/categoria/borrar/$1';
$route['admin/categoria/ajax_get_listado_resultados'] = 'admin/categoria/ajax_get_listado_resultados';
$route['admin/categoria/upload_image'] = 'admin/categoria/upload_image';
$route['admin/categoria/(:any)'] = 'admin/categoria/view_listado_subcategorias/$1';
$route['admin/anuncios'] = 'admin/anuncio/view_listado';
$route['admin/anuncios/crear'] = 'admin/anuncio/crear';
$route['admin/anuncios/editar/(:num)'] = 'admin/anuncio/editar/$1';
$route['admin/anuncios/borrar/(:num)'] = 'admin/anuncio/borrar/$1';
$route['admin/anuncio/ajax_get_listado_resultados'] = 'admin/anuncio/ajax_get_listado_resultados';
$route['admin/paquetes'] = 'admin/paquete/view_listado';
$route['admin/paquetes/crear'] = 'admin/paquete/crear';
$route['admin/paquetes/borrar/(:num)'] = 'admin/paquete/borrar/$1';
$route['admin/vendedor_paquetes/listado_por_activar'] = 'admin/vendedor_paquete/view_listado_por_activar';
$route['admin/vendedor_paquetes/aprobar/(:num)'] = 'admin/vendedor_paquete/aprobar/$1';
$route['admin/vendedor_paquete/ajax_get_listado_resultados'] = 'admin/vendedor_paquete/ajax_get_listado_resultados';
$route['admin/vendedor_paquete/ajax_get_paquete_info'] = 'admin/vendedor_paquete/ajax_get_paquete_info';
$route['admin/paquete/ajax_get_listado_resultados'] = 'admin/paquete/ajax_get_listado_resultados';
$route['admin/vendedores_admin/asignar_listado'] = 'admin/vendedores_admin/asignar_listado';
$route['admin/vendedores_admin/asignar/(:num)'] = 'admin/vendedores_admin/asignar/$1';
$route['admin/vendedores_admin/listado_actual'] = 'admin/vendedores_admin/listado_actual';
$route['admin/vendedores_admin/cancelar/(:num)'] = 'admin/vendedores_admin/cancelar/$1';
$route['admin/vendedores_admin/ver_informacion/(:num)'] = 'admin/vendedores_admin/ver_informacion/$1';
$route['admin/vendedores_admin/ajax_get_listado_resultados'] = 'admin/vendedores_admin/ajax_get_listado_resultados';
$route['admin/vendedores_admin/ajax_find_paquetes'] = 'admin/vendedores_admin/ajax_find_paquetes';
$route['admin/acceso_restringido'] = 'admin/main/acceso_restringido';

$route['cron_task/validar_paquetes'] = 'admin/cron_controller/validar_paquetes';
$route['cron_task/productos_novedades'] = 'admin/cron_controller/productos_novedades';

$route['webservice'] = 'webservice/main/index';
$route['webservice/upload_products'] = 'webservice/main/upload_products';
$route['webservice/upload_products_local'] = 'webservice/main/upload_products_local';
$route['webservice/categorias'] = 'webservice/main/categorias';
$route['webservice/categorias_local'] = 'webservice/main/categorias_local';


$route['default_controller'] = 'home/producto/view_principal';
$route['404_override'] = 'home/main/not_found';
$route['pagina-no-existe'] = 'home/main/not_found';

$route['test-url'] = 'home/main/test_url';

$route['(:any)'] = 'home/vendedor/ver_vendedor/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
