<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
$route['home'] = 'home/producto/view_principal';
$route['acceso_invalido'] = 'home/main/acceso_invalido';
$route['usuario/perfil'] = 'home/usuario/view_perfil';
$route['usuario/datos-personales'] = 'home/usuario/view_datos_personales';
$route['usuario/datos-personales/modificar'] = 'home/usuario/modificar_datos';
$route['usuario/password'] = 'home/usuario/view_password';
$route['usuario/password/modificar'] = 'home/usuario/modificar_password';
$route['usuario/afiliacion'] = 'home/vendedor/view_afiliarse';
$route['usuario/afiliacion/registrar'] = 'home/vendedor/cliente_a_vendedor';
$route['usuario/afiliacion-paso2'] = 'home/vendedor/view_seleccionar_paquete';
$route['usuario/afiliacion-final/(:num)'] = 'home/vendedor/submit_afiliacion/$1';
$route['usuario/completado'] = 'home/vendedor/view_completado';
$route['usuario/panel_vendedor'] = 'home/vendedor/ir_panel_vendedor';
$route['usuario/invitaciones'] = 'home/cliente/view_invitaciones';

$route['usuario/mis-paquetes'] = 'home/vendedor/mis_paquetes';
$route['usuario/paquetes/comprar'] = 'home/vendedor/comprar_paquetes';
$route['usuario/paquetes/comprar_paquete/(:any)'] = 'home/vendedor/submit_comprar_paquetes/$1';

$route['login'] = 'home/usuario/login';
$route['logout'] = 'home/usuario/logout';
$route['registro'] = 'home/usuario/view_registro';
$route['registrar_cliente'] = 'home/cliente/crear';
$route['registrar_vendedor'] = 'home/vendedor/new_vendedor';
$route['vendedores'] = 'home/vendedor/view_buscador';
$route['vendedores/ficha/(:any)'] = 'home/vendedor/ver_vendedor/$1';

$route['productos/ficha/(:any)'] = 'home/producto/ver_producto/$1';
$route['productos/buscar/(:any)'] = 'home/producto/buscar_producto/$1';

/* Apartado para vendedores */
 
$route['panel_vendedor'] = 'admin/panel_vendedores/resumen';
$route['panel_vendedor/resumen'] = 'admin/panel_vendedores/resumen';
$route['panel_vendedor/regresar'] = 'admin/panel_vendedores/regresar';
$route['panel_vendedor/login'] = 'admin/panel_vendedores/login';
$route['panel_vendedor/logout'] = 'admin/panel_vendedores/logout';

$route['panel_vendedor/visitas/get_estadisticas'] = 'admin/panel_vendedores/get_visitas_estadisticas';

$route['panel_vendedor/invitaciones/buscar'] = 'admin/panel_vendedores_invitaciones/buscador';
$route['panel_vendedor/invitaciones/pendientes'] = 'admin/panel_vendedores_invitaciones/pendientes';
$route['panel_vendedor/invitaciones/aceptadas'] = 'admin/panel_vendedores_invitaciones/aceptadas';
$route['panel_vendedor/invitaciones/envio_email'] = 'admin/panel_vendedores_invitaciones/enviar_invitacion_email';
$route['panel_vendedor/invitaciones/enviar/(:num)'] = 'admin/panel_vendedores_invitaciones/enviar_invitacion/$1'; 
$route['panel_vendedor/invitaciones/ajax_get_listado_resultados'] = 'admin/panel_vendedores_invitaciones/ajax_get_listado_resultados';

$route['panel_vendedor/producto/listado'] = 'admin/panel_vendedores_productos/listado';
$route['panel_vendedor/producto/agregar'] = 'admin/panel_vendedores_productos/agregar';
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


/* Admin */
$route['admin'] = 'admin/main';
$route['admin/resumen'] = 'admin/main/dashboard';
$route['admin/login'] = 'admin/usuario/view_login'; 
$route['admin/do_login'] = 'admin/usuario/login'; 
$route['admin/do_logout'] = 'admin/usuario/logout'; 
$route['admin/sin_permiso'] = 'admin/usuario/sin_permiso'; 

$route['admin/productos'] = 'admin/producto/view_listado'; 
$route['admin/productos/crear'] = 'admin/producto/crear';
$route['admin/productos/editar/(:num)'] = 'admin/producto/editar/$1'; 
$route['admin/productos/borrar/(:num)'] = 'admin/producto/borrar/$1'; 

$route['admin/usuarios'] = 'admin/cliente/view_listado'; 
$route['admin/usuarios/crear'] = 'admin/cliente/crear';
$route['admin/usuarios/editar/(:num)'] = 'admin/cliente/editar/$1'; 
$route['admin/usuarios/borrar/(:num)'] = 'admin/cliente/borrar/$1'; 

$route['admin/vendedores'] = 'admin/vendedor/view_listado'; 
$route['admin/vendedores/crear'] = 'admin/vendedor/crear';
$route['admin/vendedores/editar/(:num)'] = 'admin/vendedor/editar/$1'; 
$route['admin/vendedores/borrar/(:num)'] = 'admin/vendedor/borrar/$1'; 
$route['admin/vendedores/autocomplete'] = 'admin/vendedor/autocomplete';
$route['admin/vendedores_lista_control'] = 'admin/vendedor/view_listado_control'; 

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

$route['admin/paquetes'] = 'admin/paquete/view_listado'; 
$route['admin/paquetes/crear'] = 'admin/paquete/crear';
$route['admin/paquetes/borrar/(:num)'] = 'admin/paquete/borrar/$1'; 

$route['admin/vendedor_paquetes/listado_por_activar'] = 'admin/vendedor_paquete/view_listado_por_activar'; 
$route['admin/vendedor_paquetes/aprobar/(:num)'] = 'admin/vendedor_paquete/aprobar/$1'; 

$route['default_controller'] = 'home/producto/view_principal';
$route['404_override'] = 'home/main/not_found';

/* End of file routes.php */
/* Location: ./application/config/routes.php */