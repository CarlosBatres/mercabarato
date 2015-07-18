<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    public function index() {
        redirect('admin/resumen');
    }

    public function dashboard() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
                
        $restriccion = $this->restriccion_model->get_by("usuario_id", $user_id);
        $params = array("pagina" => "1");
        if ($restriccion) {
            if ($restriccion->pais_id != null) {
                $params["pais_id"] = $restriccion->pais_id;
            }
            if ($restriccion->provincia_id != null) {
                unset($params["pais_id"]);
                $params["provincia_id"] = $restriccion->provincia_id;
            }
            if ($restriccion->poblacion_id != null) {
                unset($params["pais_id"]);
                unset($params["provincia_id"]);
                $params["poblacion_id"] = $restriccion->poblacion_id;
            }
        }        
        $vendedor_paquetes_array = $this->vendedor_paquete_model->get_admin_search($params, 1, 0);
        $paquetes_por_aprobacion = $vendedor_paquetes_array['total'];

        //$paquetes_por_aprobacion = $this->vendedor_paquete_model->count_by("aprobado", '0');
        $paquetes_comprados = $this->vendedor_paquete_model->count_by("aprobado", '1');
        $usuarios = $this->usuario_model->count_by("activo", "1");
        $productos = $this->producto_model->count_by("habilitado", "1");
        $vendedores = $this->vendedor_model->count_by("habilitado", "1");

        

        $data = array(
            "paquetes_por_aprobacion" => $paquetes_por_aprobacion,
            "usuarios_activos_en_sistema" => $usuarios,
            "productos_activos_en_sistema" => $productos,
            "vendedores_activos_en_sistema" => $vendedores,
            "paquetes_comprados" => $paquetes_comprados,
            "vendedor_logged" => $vendedor
        );
        $this->template->load_view('admin/dashboard/index', $data);
    }

    public function acceso_restringido() {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $this->template->load_view('admin/acceso_restringido');
    }

}
