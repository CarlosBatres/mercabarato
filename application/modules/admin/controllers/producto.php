<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producto extends MY_Controller {

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

    public function view_listado() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/productos.js");        
        $categorias = $this->categoria_model->get_all();
        
        $data = array(
            "categorias" => $categorias,            
            "search_params" => array(
                "nombre" => "",
                "pagina" => "1"));

        $this->template->load_view('admin/producto/listado', $data);
    }

    public function view_nuevo() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $categorias = $this->categoria_model->get_all();

        $data = array("categorias" => $categorias);

        $this->template->load_view('admin/producto/nuevo', $data);
    }

    public function crear() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $vendedor_id = $this->input->post('vendedor_id');
            $vendedor = $this->vendedor_model->get($vendedor_id);

            if ($vendedor) {
                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "descripcion" => $this->input->post('descripcion'),
                    "precio_venta_publico" => $this->input->post('precio_venta_publico'),
                    "mostrar_publico" => $this->input->post('mostrar_publico'),
                    "mostrar_precio_venta_publico" => $this->input->post('mostrar_precio'),
                    "vendedor_id" => $vendedor_id,
                    "categoria_id" => $this->input->post('categoria'),
                );

                $this->producto_model->insert($data);
                redirect('admin/productos');
            } else {
                $this->session->set_flashdata('error', 'El vendedor no existe.');
                redirect('admin/productos/nuevo');
            }
        } else {
            redirect('admin/productos');
        }
    }

    public function ajax_get_listado_resultados() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $nombre_producto = $this->input->post('nombre');
            $pagina = $this->input->post('pagina');
        } else {
            $nombre_producto = '';
            $pagina = 1;
        }

        $limit = 2;
        $offset = $limit * ($pagina - 1);                
        $productos_array = $this->producto_model->get_admin_search($nombre_producto, $limit, $offset);        
        $flt = (float)($productos_array["total"]/$limit);
        $ent = (int)($productos_array["total"]/$limit);
        if($flt > $ent || $flt < $ent){
          $paginas = $ent+1;  
        }else{
            $paginas = $ent;
        }
        // TODO: Falta testear mas
        
        if ($productos_array["total"] == 0) {
            $productos_array["productos"] = array();
            // TODO: Resultados vacio
        }
        $data = array(            
            "productos" => $productos_array["productos"],
            "search_params" => array(
                "nombre" => $nombre_producto,
                "pagina" => $pagina,
                "total_paginas" => $paginas));

        $this->template->load_view('admin/producto/tabla_resultados', $data);
    }

}
