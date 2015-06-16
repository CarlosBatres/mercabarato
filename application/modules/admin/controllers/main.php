<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->authentication->is_loggedin()) {
            redirect('admin/login');
        } else {
            if (!$this->authentication->user_is_admin()) {
                redirect('admin/sin_permiso');
            }
        }
    }

    public function index() {
        redirect('admin/dashboard');
    }

    public function dashboard() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $paquetes_por_aprobacion=$this->vendedor_paquete_model->count_by("aprobado",'0');
        $usuarios=$this->usuario_model->count_by("activo","1");
        $productos=$this->producto_model->count_by("habilitado","1");
        $vendedores=$this->vendedor_model->count_by("habilitado","1");
        
        $data=array(
            "paquetes_por_aprobacion"=>$paquetes_por_aprobacion,
            "usuarios_activos_en_sistema"=>$usuarios,
            "productos_activos_en_sistema"=>$productos,
            "vendedores_activos_en_sistema"=>$vendedores
                );
        $this->template->load_view('admin/dashboard/index',$data);
    }

}
