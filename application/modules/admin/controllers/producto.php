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

    /**
     *  Productos / Listado
     */
    public function view_listado() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/productos_listado.js");
        $categorias = $this->categoria_model->get_all();
        $data = array("categorias" => $categorias);
        $this->template->load_view('admin/producto/listado', $data);
    }

    /**
     * Productos / Crear
     * 
     * 
     */
    public function crear() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "producto-crear") {
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

                    $producto_id=$this->producto_model->insert($data);
                    
                    $data_img=array(
                        "producto_id"=>$producto_id,
                        "nombre"=>"Imagen del Producto",
                        "descripcion"=>"Imagen del Producto",
                        "tipo"=>"imagen",
                        "url_path"=>$this->input->post('file_name'),
                        "orden"=>0,
                    );
                    
                    $this->producto_resources_model->insert($data_img);
                    
                    redirect('admin/productos');
                } else {
                    $this->session->set_flashdata('error', 'El vendedor no existe.');
                    redirect('admin/productos/crear');
                }
            } else {
                redirect('admin');
            }
        } else {
            $this->template->set_title("Panel de Administracion - Mercabarato.com");
            $this->template->add_js("fileupload.js");            
            $this->template->add_js("modules/admin/productos.js");            
            $categorias = $this->categoria_model->get_all();

            $data = array("categorias" => $categorias);

            $this->template->load_view('admin/producto/nuevo', $data);
        }
    }

    /**
     * Productos / Borrar
     * 
     * @param type $id
     */
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            $this->producto_model->delete($id);
            redirect('admin/productos');
        }
    }

    /**
     * Productos / Editar
     * @param type $id
     */
    public function editar($id) {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "producto-editar") {
                $vendedor_id = $this->input->post('vendedor_id');
                $vendedor = $this->vendedor_model->get($vendedor_id);
                $producto_id = $this->input->post('id');

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

                    $this->producto_model->update($data, $producto_id);
                    $this->session->set_flashdata('success', 'Producto modificado con exito');
                    redirect('admin/productos');
                } else {
                    $this->session->set_flashdata('error', 'El vendedor no existe.');
                    redirect('admin/productos/editar/' . $producto_id);
                }
            } else {
                redirect('admin');
            }
        } else {
            $producto = $this->producto_model->get($id);
            if ($producto) {
                $this->template->set_title("Panel de Administracion - Mercabarato.com");
                $this->template->add_js("modules/admin/productos.js");
                $categorias = $this->categoria_model->get_all();
                $vendedor = $this->vendedor_model->get($producto->vendedor_id);

                $data = array("categorias" => $categorias, "producto" => $producto, "vendedor" => $vendedor);

                $this->template->load_view('admin/producto/editar', $data);
            } else {
                //TODO : No se encuentra el producto
            }
        }
    }

    /**
     *  AJAX Productos / Listado
     */
    public function ajax_get_listado_resultados() {
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            if ($this->input->post('categoria') != 0) {
                $params["categoria_id"] = $this->input->post('categoria');
            }
            if ($this->input->post('vendedor') != "") {
                $params["vendedor"] = $this->input->post('vendedor');
            }
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = 15;
        $offset = $limit * ($pagina - 1);
        $productos_array = $this->producto_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($productos_array["total"] / $limit);
        $ent = (int) ($productos_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
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
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina"=>$limit,
                "total"=>$productos_array["total"],
                "hasta"=>($pagina*$limit<$productos_array["total"])?$pagina*$limit:$productos_array["total"],
                "desde"=>(($pagina*$limit)-$limit)+1));

        $this->template->load_view('admin/producto/tabla_resultados', $data);
    }

}
