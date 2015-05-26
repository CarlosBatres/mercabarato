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
$route['home'] = 'home/main';
$route['login'] = 'home/user/login';
$route['logout'] = 'home/user/logout';
$route['registro'] = 'home/user/view_registro';
$route['registrar_comprador'] = 'home/comprador/new_comprador';
$route['registrar_vendedor'] = 'home/vendedor/new_vendedor';
$route['productos'] = 'home/producto/view_listado';


/* Admin */
$route['admin'] = 'admin/main';
$route['admin/login'] = 'admin/user/view_login'; // Vista
$route['admin/do_login'] = 'admin/user/login'; // Ejecutar Login
$route['admin/do_logout'] = 'admin/user/logout'; // Ejecutar Logout
$route['admin/sin_permiso'] = 'admin/user/sin_permiso'; // Vista
$route['admin/productos'] = 'admin/producto/view_listado'; // Vista
$route['admin/productos/nuevo'] = 'admin/producto/view_nuevo'; // Vista
$route['admin/productos/crear'] = 'admin/producto/crear'; // Crear

$route['admin/vendedores/autocomplete'] = 'admin/vendedor/autocomplete';

$route['default_controller'] = "home/main";
$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */