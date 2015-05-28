<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comprador extends MY_Controller {

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

    /**
     * 
     */
    public function view_listado() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        //$this->template->add_js("modules/admin/productos_listado.js");
        //$categorias = $this->categoria_model->get_all();
        //$data = array("categorias" => $categorias);
        //$this->template->load_view('admin/producto/listado', $data);
    }

}
