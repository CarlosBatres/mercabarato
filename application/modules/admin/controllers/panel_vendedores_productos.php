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
                        "transporte" => ($this->input->post('transporte') != '') ? $this->input->post('transporte') : null,
                        "impuesto" => ($this->input->post('impuesto') != '') ? $this->input->post('impuesto') : null,
                        "grupo_txt" => ($this->input->post('grupo_txt') != '') ? strtolower($this->input->post('grupo_txt')) : null,                        
                        "familia_txt" => ($this->input->post('familia_txt') != '') ? strtolower($this->input->post('familia_txt')) : null,                        
                        "subfamilia_txt" => ($this->input->post('subfamilia_txt') != '') ? strtolower($this->input->post('subfamilia_txt')) : null,                        
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

                    $precio_extra1 = $this->input->post('precio_extra1');
                    $precio_extra1_cantidad = $this->input->post('precio_extra1_cantidad');

                    if ($precio_extra1 != "" && $precio_extra1_cantidad != "") {
                        $data_extra = array(
                            "producto_id" => $producto_id,
                            "nombre" => $precio_extra1_cantidad,
                            "value" => $precio_extra1,
                            "tipo" => 1
                        );
                        $this->producto_extra_model->insert($data_extra);
                    }

                    $precio_extra2 = $this->input->post('precio_extra2');
                    $precio_extra2_cantidad = $this->input->post('precio_extra2_cantidad');

                    if ($precio_extra2 != "" && $precio_extra2_cantidad != "") {
                        $data_extra = array(
                            "producto_id" => $producto_id,
                            "nombre" => $precio_extra2_cantidad,
                            "value" => $precio_extra2,
                            "tipo" => 1
                        );
                        $this->producto_extra_model->insert($data_extra);
                    }

                    $precio_extra3 = $this->input->post('precio_extra3');
                    $precio_extra3_cantidad = $this->input->post('precio_extra3_cantidad');

                    if ($precio_extra3 != "" && $precio_extra3_cantidad != "") {
                        $data_extra = array(
                            "producto_id" => $producto_id,
                            "nombre" => $precio_extra3_cantidad,
                            "value" => $precio_extra3,
                            "tipo" => 1
                        );
                        $this->producto_extra_model->insert($data_extra);
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
                    'id' => 'content',
                    'path' => 'assets/js/ckeditor',                    
                    'config' => array(
                        'customConfig'=>assets_url('js/ckeditor_config_sm.js'),
                        'height' => '200px', 
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
                        "transporte" => ($this->input->post('transporte') != '') ? $this->input->post('transporte') : null,
                        "impuesto" => ($this->input->post('impuesto') != '') ? $this->input->post('impuesto') : null,
                        "grupo_txt" => ($this->input->post('grupo_txt') != '') ? strtolower($this->input->post('grupo_txt')) : null,                        
                        "familia_txt" => ($this->input->post('familia_txt') != '') ? strtolower($this->input->post('familia_txt')) : null,                        
                        "subfamilia_txt" => ($this->input->post('subfamilia_txt') != '') ? strtolower($this->input->post('subfamilia_txt')) : null,                        
                    );

                    $this->producto_model->verificar_cambio_precio($producto_id, $data["precio"]);
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

                    $this->producto_extra_model->delete_by(array("producto_id" => $producto_id, "tipo" => "1"));

                    $precio_extra1 = $this->input->post('precio_extra1');
                    $precio_extra1_cantidad = $this->input->post('precio_extra1_cantidad');

                    if ($precio_extra1 != "" && $precio_extra1_cantidad != "") {
                        $data_extra = array(
                            "producto_id" => $producto_id,
                            "nombre" => $precio_extra1_cantidad,
                            "value" => $precio_extra1,
                            "tipo" => 1
                        );
                        $this->producto_extra_model->insert($data_extra);
                    }

                    $precio_extra2 = $this->input->post('precio_extra2');
                    $precio_extra2_cantidad = $this->input->post('precio_extra2_cantidad');

                    if ($precio_extra2 != "" && $precio_extra2_cantidad != "") {
                        $data_extra = array(
                            "producto_id" => $producto_id,
                            "nombre" => $precio_extra2_cantidad,
                            "value" => $precio_extra2,
                            "tipo" => 1
                        );
                        $this->producto_extra_model->insert($data_extra);
                    }

                    $precio_extra3 = $this->input->post('precio_extra3');
                    $precio_extra3_cantidad = $this->input->post('precio_extra3_cantidad');

                    if ($precio_extra3 != "" && $precio_extra3_cantidad != "") {
                        $data_extra = array(
                            "producto_id" => $producto_id,
                            "nombre" => $precio_extra3_cantidad,
                            "value" => $precio_extra3,
                            "tipo" => 1
                        );
                        $this->producto_extra_model->insert($data_extra);
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
                    $producto_extras = $this->producto_extra_model->get_many_by(array("producto_id" => $producto->id, "tipo" => "1"));
                    if (!$producto_extras) {
                        $producto_extras = array();
                    }

                    $categorias_tree = $this->categoria_model->get_full_tree();
                    $categorias_tree_html = $this->_build_categorias_tree($categorias_tree, $producto->categoria_id);

                    $data = array(
                        "categorias_tree_html" => $categorias_tree_html,
                        "producto" => $producto,
                        "vendedor" => $vendedor,
                        "producto_imagenes" => $producto_imagenes,
                        "producto_extras" => $producto_extras);

                    $this->load->helper('ckeditor');

                    $data['ckeditor'] = array(
                        //ID of the textarea that will be replaced
                        'id' => 'content',
                        'path' => 'assets/js/ckeditor',
                        //Optionnal values
                        'config' => array(
                            'customConfig'=>assets_url('js/ckeditor_config_sm.js'),
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

    public function borrar_multi() {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);

            $formValues = $this->input->post();
            if ($formValues !== false) {
                $producto_ids = $this->input->post('producto_ids');
                $ids = explode(";;", $producto_ids);

                $flag = 0;
                foreach ($ids as $id) {
                    $res = $this->producto_model->get_vendedor_id_del_producto($id);
                    if ($res == $vendedor->get_vendedor_id()) {
                        $this->producto_model->delete($id);
                    } else {
                        $flag=1;
                    }
                }
                if ($flag==0) {
                    $this->session->set_flashdata('success', 'Productos eliminados con exito..');
                } elseif($flag==1) {
                    $this->session->set_flashdata('error', 'Ha ocurrido un error durante la operacion.');
                }

                echo json_encode(array("success" => true));
            }
        } else {
            show_404();
        }
    }

    /**
     * 
     */
    public function ajax_get_listado_resultados() {
        //$this->show_profiler();
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

    public function agregar_varios() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $config['upload_path'] = './assets/uploads/temporal/';
            $config['allowed_types'] = 'xls';
            $config['max_size'] = '1024';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                $file_name = null;
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('panel_vendedor/producto/agregar-varios');
                die();
            } else {
                $data_upload = $this->upload->data();
                $file_name = $data_upload["full_path"];

                $this->load->library('excel');
                $objPHPExcel = PHPExcel_IOFactory::load($file_name);
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                $productos_array = array();

                for ($row = 1; $row <= $highestRow; $row++) {
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    $flag = true;
                    if ($row == 1) {
                        /* $flag = true;
                          if (strcmp(strtolower($rowData[0][0]), "nombre")) {
                          $flag = false;
                          }
                          if (strcmp(strtolower($rowData[0][1]), "descripcion")) {
                          $flag = false;
                          }
                          if (strcmp(strtolower($rowData[0][2]), "precio")) {
                          $flag = false;
                          }
                          if (strcmp(strtolower($rowData[0][3]), "mostrar_precio")) {
                          $flag = false;
                          }
                          if (strcmp(strtolower($rowData[0][4]), "mostrar_producto")) {
                          $flag = false;
                          }
                          if (strcmp(strtolower($rowData[0][5]), "habilitado")) {
                          $flag = false;
                          }
                          if (strcmp(strtolower($rowData[0][6]), "link_externo")) {
                          $flag = false;
                          }
                          if (strcmp(strtolower($rowData[0][7]), "categoria_id")) {
                          $flag = false;
                          } */
                    } else {

                        $flag_empty = true;
                        for ($i = 0; $i < 8; $i++) {
                            if ($rowData[0][$i] == null && ($i != 1 && $i != 6)) {
                                $flag_empty = false;
                            }
                        }

                        if ($flag_empty) {
                            $rowArray = array(
                                "nombre" => $rowData[0][0],
                                "descripcion" => $rowData[0][1],
                                "precio" => $rowData[0][2],
                                "mostrar_precio" => $rowData[0][3],
                                "mostrar_producto" => $rowData[0][4],
                                "habilitado" => $rowData[0][5],
                                "link_externo" => $rowData[0][6],
                                "categoria_id" => $rowData[0][7],
                            );
                            $productos_array[] = $rowArray;
                        }
                    }

                    if (!$flag) {
                        break;
                    }
                }

                if (sizeof($productos_array) > 0) {
                    $this->load->library('rest');
                    $config = array('server' => site_url('webservice'),
                        'http_user' => $this->identidad->usuario->email,
                        'http_pass' => "nopass",
                        'http_auth' => 'basic');

                    $this->rest->initialize($config);

                    $test = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?><mercabarato></mercabarato>");
                    $productos_xml = $test->addChild("productos");

                    foreach ($productos_array as $producto) {
                        $producto_xml = $productos_xml->addChild("producto");
                        $producto_xml->addChild("nombre", $producto["nombre"]);
                        $producto_xml->addChild("descripcion", $producto["descripcion"]);
                        $producto_xml->addChild("precio", $producto["precio"]);
                        $producto_xml->addChild("mostrar_precio", $producto["mostrar_precio"]);
                        $producto_xml->addChild("mostrar_producto", $producto["mostrar_producto"]);
                        $producto_xml->addChild("habilitado", $producto["habilitado"]);
                        $producto_xml->addChild("link_externo", $producto["link_externo"]);
                        $producto_xml->addChild("categoria_id", $producto["categoria_id"]);
                    }

                    $response = $this->rest->post('upload_products_local', $test->asXML(), "xml");
                    $this->rest->debug();
                } else {
                    $flag = false;
                }


                unlink($file_name);
                if (!$flag) {
                    $this->session->set_flashdata('error', "El formato del excel es invalido");
                    redirect('panel_vendedor/producto/agregar-varios');
                } else {
                    $array = SimpleXML2Array($response);
                    $this->session->set_userdata(array('pvp_temp' => $array));
                    redirect('panel_vendedor/producto/agregar-varios-resumen');
                }
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/producto/producto_agregar_multi');
        }
    }

    public function agregar_varios_resumen() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $dat = $this->session->userdata('pvp_temp');

        if ($dat) {
            $data = array("data" => $dat);
            $this->session->unset_userdata('pvp_temp');
            $this->template->load_view('admin/panel_vendedores/producto/producto_agregar_multi_resumen', $data);
        } else {
            redirect('panel_vendedor/producto/listado');
        }
    }

}
