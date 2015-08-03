<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_productos extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }

    /**
     * 
     */
    public function agregar() {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        $cantidad = $this->vendedor_model->get_cantidad_productos_disp($vendedor->get_vendedor_id());

        if ($cantidad > 0) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $accion = $this->input->post('accion');
                if ($accion === "producto-crear") {
                    $data = array(
                        "nombre" => $this->input->post('nombre'),
                        "descripcion" => $this->input->post('descripcion'),
                        "precio" => $this->input->post('precio'),
                        "mostrar_producto" => $this->input->post('mostrar_producto'),
                        "mostrar_precio" => $this->input->post('mostrar_precio'),
                        "vendedor_id" => $vendedor->get_vendedor_id(),
                        "categoria_id" => $this->input->post('categoria_id'),
                    );

                    $producto_id = $this->producto_model->insert($data);

                    if ($this->input->post('file_name') != "") {
                        $filenames = explode(";;", $this->input->post('file_name'));
                        if (sizeof($filenames) > 0) {
                            foreach ($filenames as $key => $filename) {
                                if ($key == 0) {
                                    $data_img = array(
                                        "producto_id" => $producto_id,
                                        "nombre" => "Producto: " . $data["nombre"],
                                        "descripcion" => "Imagen principal del producto " . $data["nombre"],
                                        "tipo" => "imagen_principal",
                                        "filename" => $filename,
                                        "orden" => 0,
                                    );
                                    $this->producto_resource_model->insert($data_img);
                                } else {
                                    $data_img = array(
                                        "producto_id" => $producto_id,
                                        "nombre" => "Producto: " . $data["nombre"],
                                        "descripcion" => "Imagen del producto " . $data["nombre"],
                                        "tipo" => "imagen_alternativas",
                                        "filename" => $filename,
                                        "orden" => $key,
                                    );
                                    $this->producto_resource_model->insert($data_img);
                                }
                            }
                        }
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

                $categorias_tree = $this->categoria_model->get_full_tree();
                $categorias_tree_html = $this->_build_categorias_tree($categorias_tree, false);

                $this->load->helper('ckeditor');

                $data = array("categorias_tree_html" => $categorias_tree_html);
                $data['ckeditor'] = array(
                    //ID of the textarea that will be replaced
                    'id' => 'content',
                    'path' => 'assets/js/ckeditor',
                    //Optionnal values
                    'config' => array(
                        'toolbar' => "Full", //Using the Full toolbar                        
                        'height' => '200px', //Setting a custom height
                    ),
                );
                $this->template->load_view('admin/panel_vendedores/producto/producto_agregar', $data);
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
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
        // Validamos que el vendedor sea dueño de este producto
        if ($res == $vendedor->get_vendedor_id()) {
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
                        "vendedor_id" => $vendedor->get_vendedor_id(),
                        "categoria_id" => $this->input->post('categoria_id'),
                    );

                    $this->producto_model->update($producto_id, $data);

                    if ($this->input->post('file_name') != "") {
                        $this->producto_resource_model->cleanup_resources($producto_id);

                        $filenames = explode(";;", $this->input->post('file_name'));
                        if (sizeof($filenames) > 0) {
                            foreach ($filenames as $key => $filename) {
                                if ($key == 0) {
                                    $data_img = array(
                                        "producto_id" => $producto_id,
                                        "nombre" => "Producto: " . $data["nombre"],
                                        "descripcion" => "Imagen principal del producto " . $data["nombre"],
                                        "tipo" => "imagen_principal",
                                        "filename" => $filename,
                                        "orden" => 0,
                                    );
                                    $this->producto_resource_model->insert($data_img);
                                } else {
                                    $data_img = array(
                                        "producto_id" => $producto_id,
                                        "nombre" => "Producto: " . $data["nombre"],
                                        "descripcion" => "Imagen del producto " . $data["nombre"],
                                        "tipo" => "imagen_alternativas",
                                        "filename" => $filename,
                                        "orden" => $key,
                                    );
                                    $this->producto_resource_model->insert($data_img);
                                }
                            }
                        }
                    }

                    $this->session->set_flashdata('success', 'Producto modificado con exito');
                    redirect('panel_vendedor/producto/listado');
                } else {
                    redirect('panel_vendedor');
                }
            } else {
                $producto = $this->producto_model->get($id);
                if ($producto) {
                    $this->template->set_title("Panel de Control - Mercabarato.com");
                    $this->template->set_layout('panel_vendedores');
                    $this->template->add_js("modules/admin/panel_vendedores/productos.js");
                    $vendedor = $this->vendedor_model->get($producto->vendedor_id);
                    $producto_imagenes = $this->producto_resource_model->get_producto_imagenes($producto->id);

                    $categorias_tree = $this->categoria_model->get_full_tree();
                    $categorias_tree_html = $this->_build_categorias_tree($categorias_tree, $producto->categoria_id);

                    $data = array(
                        "categorias_tree_html" => $categorias_tree_html,
                        "producto" => $producto,
                        "vendedor" => $vendedor,
                        "producto_imagenes" => $producto_imagenes);

                    $this->load->helper('ckeditor');

                    $data['ckeditor'] = array(
                        //ID of the textarea that will be replaced
                        'id' => 'content',
                        'path' => 'assets/js/ckeditor',
                        //Optionnal values
                        'config' => array(
                            'toolbar' => "Full", //Using the Full toolbar                        
                            'height' => '200px', //Setting a custom height
                        ),
                    );

                    $this->template->load_view('admin/panel_vendedores/producto/producto_editar', $data);
                } else {
                    redirect('panel_vendedor/producto/listado');
                }
            }
        } else {
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
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $producto_id = $id;

            $res = $this->producto_model->get_vendedor_id_del_producto($producto_id);
            if ($res == $vendedor->get_vendedor_id()) {
                $this->producto_model->delete($id);
                $this->session->set_flashdata('success', 'Producto eliminado con exito..');
            } else {
                $this->session->set_flashdata('error', 'No puedes realizar esta accion.');
            }
            echo json_encode(array("success" => true));
        } else {
            show_404();
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
            $params["vendedor_id"] = $vendedor->get_vendedor_id();

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

        if ($productos_array["total"] == 0) {
            $productos_array["productos"] = array();
        }

        $paquete_en_curso = $this->vendedor_model->get_paquete_en_curso($vendedor->get_vendedor_id());
        $ilimitado = false;
        $limite_productos = 0;
        if ($paquete_en_curso) {
            if ($paquete_en_curso->limite_productos == -1) {
                $ilimitado = true;
            } else {
                $limite_productos = $paquete_en_curso->limite_productos;
            }
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $productos_array["total"],
            "hasta" => ($pagina * $limit < $productos_array["total"]) ? $pagina * $limit : $productos_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "productos" => $productos_array["productos"],
            "pagination" => $pagination,
            "productos_total" => $productos_array["total"],
            "ilimitado" => $ilimitado,
            "limite_productos" => $limite_productos);

        $this->template->load_view('admin/panel_vendedores/producto/producto_tabla_resultados', $data);
    }

    /**
     * 
     * @param type $categorias_tree
     * @return string
     */
    private function _build_categorias_tree($categorias_tree, $selected) {
        $html = "<ul>";
        foreach ($categorias_tree as $categoria) {
            $class = '';
            if ($categoria["id"] == $selected) {
                $class = '{ "selected" : true ,';
            } else {
                $class = '{';
            }
            if (isset($categoria["children"])) {
                $class .= '"icon":"glyphicon glyphicon-list-alt"}';
                $html.="<li data-id='" . $categoria["id"] . "' data-jstree='" . $class . "'>" . $categoria["nombre"];
                $html.=$this->_build_categorias_tree($categoria["children"], $selected);
            } else {
                $class .= '"icon":"glyphicon glyphicon-unchecked"}';
                $html.="<li data-id='" . $categoria["id"] . "' data-jstree='" . $class . "'>" . $categoria["nombre"];
            }
            $html.="</li>";
        }

        $html.="</ul>";
        return $html;
    }

    public function inhabilitar($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $producto_id = $id;

            $res = $this->producto_model->get_vendedor_id_del_producto($producto_id);
            if ($res == $vendedor->get_vendedor_id()) {
                $this->producto_model->inhabilitar($id);
                $this->session->set_flashdata('success', 'Producto inhabilitado con exito..');
            } else {
                $this->session->set_flashdata('error', 'No puedes realizar esta accion.');
            }
        } else {
            show_404();
        }
    }

    public function habilitar($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $producto_id = $id;

            $res = $this->producto_model->get_vendedor_id_del_producto($producto_id);
            if ($res == $vendedor->get_vendedor_id()) {
                $cant = $this->vendedor_model->get_cantidad_productos_por_habilitar($vendedor->get_vendedor_id());
                if ($cant >= 1) {
                    $this->producto_model->habilitar($id);
                    $this->session->set_flashdata('success', 'Producto habilitado con exito..');
                } else {
                    $this->session->set_flashdata('error', 'Has llegado al limite de productos.');
                }
            } else {
                $this->session->set_flashdata('error', 'No puedes realizar esta accion.');
            }
        } else {
            show_404();
        }
    }

}
