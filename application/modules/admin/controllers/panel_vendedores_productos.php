<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_productos extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     * 
     */
    public function agregar() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "producto-crear") {
                $user_id = $this->authentication->read('identifier');
                $vendedor = $this->usuario_model->get_full_identidad($user_id);

                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "descripcion" => $this->input->post('descripcion'),
                    "precio" => $this->input->post('precio'),
                    "mostrar_producto" => $this->input->post('mostrar_producto'),
                    "mostrar_precio" => $this->input->post('mostrar_precio'),
                    "vendedor_id" => $vendedor['vendedor']->id,
                    "categoria_id" => $this->input->post('categoria'),
                );

                $producto_id = $this->producto_model->insert($data);

                if ($this->input->post('file_name') !== "") {
                    $data_img = array(
                        "producto_id" => $producto_id,
                        "nombre" => "Producto: " . $data["nombre"],
                        "descripcion" => "Imagen principal del producto " . $data["nombre"],
                        "tipo" => "imagen_principal",
                        "filename" => $this->input->post('file_name'),
                        "orden" => 0,
                    );

                    $this->producto_resource_model->insert($data_img);
                }
                redirect('panel_vendedor/producto/listado');
            } else {
                redirect('panel_vendedor');
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->add_js("fileupload.js");
            $this->template->add_js("modules/admin/panel_vendedores/productos.js");
            $categorias = $this->categoria_model->get_all();

            $data = array("categorias" => $categorias);
            $this->template->load_view('admin/panel_vendedores/producto/producto_agregar', $data);
        }
    }

    /**
     * 
     * @param type $id
     */
    public function editar($id) {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        $producto_id = $id;

        $res = $this->producto_model->get_vendedor_id_del_producto($producto_id);
        if ($res == $vendedor["vendedor"]->id) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $accion = $this->input->post('accion');

                if ($accion === "producto-editar") {
                    $data = array(
                        "nombre" => $this->input->post('nombre'),
                        "descripcion" => $this->input->post('descripcion'),
                        "precio" => $this->input->post('precio'),
                        "mostrar_producto" => $this->input->post('mostrar_producto'),
                        "mostrar_precio" => $this->input->post('mostrar_precio'),
                        "vendedor_id" => $vendedor['vendedor']->id,
                        "categoria_id" => $this->input->post('categoria'),
                    );

                    $this->producto_model->update($producto_id, $data);

                    if ($this->input->post('file_name') !== "") {
                        $producto_imagen = $this->producto_resource_model->get_producto_imagen($producto_id);
                        if ($producto_imagen) {
                            $this->producto_resource_model->delete($producto_imagen->id);
                        }

                        $data_img = array(
                            "producto_id" => $producto_id,
                            "nombre" => "Imagen principal del producto",
                            "descripcion" => "Idealmente esta imagen seria lo mas grande posible.",
                            "tipo" => "imagen_principal",
                            "filename" => $this->input->post('file_name'),
                            "orden" => 0,
                        );

                        $this->producto_resource_model->insert($data_img);
                    }

                    $this->session->set_flashdata('success', 'Producto modificado con exito');
                    redirect('panel_vendedor/producto/listado');
                } else {
                    redirect('panel_vendedor');
                }
            } else {
                $producto = $this->producto_model->get($id);
                if ($producto) {
                    $this->template->set_title("Panel de Administracion - Mercabarato.com");
                    $this->template->add_js("modules/admin/panel_vendedores/productos.js");
                    $categorias = $this->categoria_model->get_all();
                    $vendedor = $this->vendedor_model->get($producto->vendedor_id);
                    $producto_imagen = $this->producto_resource_model->get_producto_imagen($producto->id);

                    $data = array(
                        "categorias" => $categorias,
                        "producto" => $producto,
                        "vendedor" => $vendedor,
                        "producto_imagen" => $producto_imagen);

                    $this->template->set_layout('panel_vendedores');
                    $this->template->load_view('admin/panel_vendedores/producto/producto_editar', $data);
                } else {
                    //TODO : No se encuentra el producto
                }
            }
        } else {
            // TODO : Este no es tu producto PAGINA DE ERROR
            redirect('panel_vendedor/producto/listado');
        }
    }

    /**
     * 
     */
    public function listado() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/productos_listado.js");
        $this->template->load_view('admin/panel_vendedores/producto/producto_listado');
    }

    /**
     * 
     */
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            $this->producto_resource_model->cleanup_resources($id);
            $this->producto_model->delete($id);
            redirect('panel_vendedor/producto/listado');
        }
    }

    /**
     * 
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
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $params["vendedor_id"] = $vendedor["vendedor"]->id;

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
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
                "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina" => $limit,
                "total" => $productos_array["total"],
                "hasta" => ($pagina * $limit < $productos_array["total"]) ? $pagina * $limit : $productos_array["total"],
                "desde" => (($pagina * $limit) - $limit) + 1));

        $this->template->load_view('admin/panel_vendedores/producto/producto_tabla_resultados', $data);
    }

    /**
     * Verifico si un producto pertenece al vendedor actualmente logeado
     * @param type $producto_id
     * @return boolean
     */
    private function _verificar_producto_dueño($producto_id) {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);

        $res = $this->producto_model->get_vendedor_id_del_producto($producto_id);
        if ($res == $vendedor["vendedor"]->id) {
            return true;
        } else {
            return false;
        }
    }

}
