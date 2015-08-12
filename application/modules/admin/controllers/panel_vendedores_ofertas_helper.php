<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_ofertas_helper extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }

    /**
     * 
     */
    public function ajax_get_productos() {
        $formValues = $this->input->post();
        $params = array();
        $params["vendedor_id"] = $this->identidad->get_vendedor_id();
        $flag_left_panel = true;

        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
                $ids_old = $this->session->userdata('pv_ofertas_incluir_ids_productos');
                if ($ids_old) {
                    $params["excluir_ids"] = $ids_old;
                }
            }

            if ($this->input->post('incluir_ids') != "") {
                if ($this->input->post('incluir_ids') != "false") {
                    $ids = explode(";;", $this->input->post('incluir_ids'));
                    $ids_old = $this->session->userdata('pv_ofertas_incluir_ids_productos');
                    if ($ids_old) {
                        $ids = array_unique(array_merge($ids, $ids_old));
                    }
                    $params["incluir_ids"] = $ids;
                    $this->session->set_userdata(array('pv_ofertas_incluir_ids_productos' => $ids));
                } else {
                    $ids_old = $this->session->userdata('pv_ofertas_incluir_ids_productos');
                    if (!$ids_old) {
                        $params["incluir_ids"] = array("0");
                    } else {
                        $params["incluir_ids"] = $ids_old;
                    }
                }
            }


            if ($this->input->post('excluir_ids') != "") {
                $ids = explode(";;", $this->input->post('excluir_ids'));
                $ids_old = $this->session->userdata('pv_ofertas_incluir_ids_productos');
                if ($ids_old) {
                    $ids = array_unique(array_merge($ids, $ids_old));
                }
                $params["excluir_ids"] = $ids;
            }

            if ($this->input->post('search_main') != "") {
                $check_ids_old = $this->session->userdata('pv_ofertas_incluir_ids_productos');
                if ($check_ids_old && !isset($params["excluir_ids"])) {
                    $params["excluir_ids"] = $check_ids_old;
                }
                $flag_left_panel = true;
            } else {
                $check_ids_old = $this->session->userdata('pv_ofertas_incluir_ids_productos');
                if ($check_ids_old && !isset($params["incluir_ids"])) {
                    $params["incluir_ids"] = $check_ids_old;
                }
                $flag_left_panel = false;
            }
            
            if ($this->input->post('show_checkboxes') != '') {
                $flag_left_panel = true;
            }

            if ($this->input->post('ignore_oferta_general_id') != '') {
                $prod_ids = $this->oferta_general_model->get_productos_ids(array("oferta_general_id" => $this->input->post('ignore_oferta_general_id')));
                $clie_ids = $this->oferta_general_model->get_clientes_ids(array("oferta_general_id" => $this->input->post('ignore_oferta_general_id')));
                $prod_ids2 = $this->oferta_general_model->get_productos_ids_from_clientes(array("clientes_ids" => $clie_ids, "vendedor_id" => $this->identidad->get_vendedor_id()));

                $params["excluir_ids"] = array_unique(array_merge($prod_ids, $prod_ids2));
            }


            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }



        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $productos_array = $this->producto_model->get_ofertas_search($params, $limit, $offset);
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
            "left_panel" => $flag_left_panel);

        $this->template->load_view('admin/panel_vendedores/ofertas/tabla_resultados_productos', $data);
    }

    /**
     * ajax_get_clientes
     */
    public function ajax_get_clientes() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $flag_left_panel = true;
        $flag_query = false;

        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
                $params["nombre_vendedor"] = $this->input->post('nombre');
                $flag_query = true;
            }
            if ($this->input->post('sexo') != 'X' && $this->input->post('sexo')) {
                $params["sexo"] = $this->input->post('sexo');
                $flag_query = true;
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
                $flag_query = true;
            }
            if ($this->input->post('keywords') != "") {
                $keywords = explode(",", $this->input->post('keywords'));
                $params["keywords"] = $keywords;
                $flag_query = true;
            }

            if ($flag_query) {
                $ids_old = $this->session->userdata('pv_ofertas_incluir_ids_clientes');
                if ($ids_old) {
                    $params["excluir_ids_clientes"] = $ids_old;
                }
            }

            if ($this->input->post('incluir_ids') != "") {
                if ($this->input->post('incluir_ids') != "false") {
                    $ids = explode(";;", $this->input->post('incluir_ids'));
                    $ids_old = $this->session->userdata('pv_ofertas_incluir_ids_clientes');
                    if ($ids_old) {
                        $ids = array_unique(array_merge($ids, $ids_old));
                    }
                    $params["incluir_ids_clientes"] = $ids;
                    $this->session->set_userdata(array('pv_ofertas_incluir_ids_clientes' => $ids));
                } else {
                    $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                    if (!$ids_old) {
                        $params["incluir_ids_clientes"] = array("0");
                    } else {
                        $params["incluir_ids_clientes"] = $ids_old;
                    }
                }
            }

            if ($this->input->post('excluir_ids') != "") {
                $ids = explode(";;", $this->input->post('excluir_ids'));
                $ids_old = $this->session->userdata('pv_ofertas_incluir_ids_clientes');
                if ($ids_old) {
                    $ids = array_unique(array_merge($ids, $ids_old));
                }
                $params["excluir_ids_clientes"] = $ids;
            }

            if ($this->input->post('search_main') != "") {
                $check_ids_old = $this->session->userdata('pv_ofertas_incluir_ids_clientes');
                if ($check_ids_old && !isset($params["excluir_ids"])) {
                    $params["excluir_ids_clientes"] = $check_ids_old;
                }
                $flag_left_panel = true;
            } else {
                $check_ids_old = $this->session->userdata('pv_ofertas_incluir_ids_clientes');
                if ($check_ids_old && !isset($params["incluir_ids"])) {
                    $params["incluir_ids_clientes"] = $check_ids_old;
                }
                $flag_left_panel = false;
            }

            $producto_seleccionado_ids = $this->session->userdata('pv_ofertas_incluir_ids_productos');
            if ($producto_seleccionado_ids) {
                $clientes_arr = $this->oferta_model->get_clientes_for_productos($producto_seleccionado_ids);
                if (isset($params['excluir_ids_clientes']) && $clientes_arr) {
                    $params['excluir_ids_clientes'] = array_unique(array_merge($params['excluir_ids_clientes'], $clientes_arr));
                }

                $params["visitas_producto_id"] = $producto_seleccionado_ids;
            }

            if ($this->input->post('show_checkboxes') != '') {
                $show_checkboxes = true;
            } else {
                $show_checkboxes = false;
            }

            /**
             * IMPORTANTE!!
             * Ignoramos todos los clientes ya presentes en esta oferta_general y los que ya tienen tarifas asignadas a los productos
             * SOLO UNA OFERTA POR CLIENTE->PRODUCTO
             */
            if ($this->input->post('ignore_oferta_general_id') != '') {
                $params["excluir_ids_clientes"] = $this->oferta_general_model->get_clientes_ids(array("oferta_general_id" => $this->input->post('ignore_oferta_general_id')));
                $producto_ids = $this->oferta_general_model->get_productos_ids(array("oferta_general_id" => $this->input->post('ignore_oferta_general_id')));
                $clientes_arr = $this->oferta_model->get_clientes_for_productos($producto_ids);
                if (isset($params['excluir_ids_clientes']) && $clientes_arr) {
                    $params['excluir_ids_clientes'] = array_unique(array_merge($params['excluir_ids_clientes'], $clientes_arr));
                }
            }

            $params["es_vendedor"] = "0";
            $params["ignore_cliente_id"] = $this->identidad->cliente->id;
            $params["excluir_admins"] = true;
            $params["usuario_activo"] = "1";
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->visita_model->get_visitantes($params, $limit, $offset);
        $flt = (float) ($clientes_array["total"] / $limit);
        $ent = (int) ($clientes_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($clientes_array["total"] == 0) {
            $clientes_array["clientes"] = array();
        } else {
            $clientes_array["clientes"] = $clientes_array["clientes"];
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $clientes_array["total"],
            "hasta" => ($pagina * $limit < $clientes_array["total"]) ? $pagina * $limit : $clientes_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "clientes" => $clientes_array["clientes"],
            "pagination" => $pagination,
            "left_panel" => $flag_left_panel,
            "show_checkboxes" => $show_checkboxes);


        $this->template->load_view("admin/panel_vendedores/ofertas/tabla_resultados_clientes", $data);
    }

    /**
     * 
     */
    public function ajax_get_productos_ofertados() {
        $formValues = $this->input->post();
        $params = array();

        if ($formValues !== false) {
            $params["vendedor_id"] = $this->identidad->get_vendedor_id();
            $params["oferta_general_id"] = $this->input->post('oferta_general_id');
            $pagina = $this->input->post('pagina');

            if ($this->input->post('show_checkboxes') != '') {
                $show_checkboxes = true;
            } else {
                $show_checkboxes = false;
            }
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $productos_array = $this->oferta_general_model->get_productos($params, $limit, $offset);
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
            "show_checkboxes" => $show_checkboxes);

        $this->template->load_view('admin/panel_vendedores/ofertas/tabla_resultados_productos_oferta', $data);
    }

    /**
     * 
     */
    public function ajax_get_oferta_detalles() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $params["vendedor_id"] = $this->identidad->get_vendedor_id();
        $flag_left_panel = false;

        if ($formValues !== false) {
            if ($this->input->post('producto_id') != "") {
                $params["producto_id"] = $this->input->post('producto_id');
            }

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $detalles_array = $this->oferta_model->get_ofertas_detalles($params, $limit, $offset);
        $flt = (float) ($detalles_array["total"] / $limit);
        $ent = (int) ($detalles_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($detalles_array["total"] == 0) {
            $detalles_array["ofertas"] = array();
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $detalles_array["total"],
            "hasta" => ($pagina * $limit < $detalles_array["total"]) ? $pagina * $limit : $detalles_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "ofertas" => $detalles_array["ofertas"],
            "pagination" => $pagination,
            "left_panel" => $flag_left_panel);

        $this->template->load_view('admin/panel_vendedores/ofertas/tabla_resultados_oferta_prod', $data);
    }

    public function ajax_get_ofertas() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $params["vendedor_id"] = $this->identidad->get_vendedor_id();

        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $results_array = $this->oferta_general_model->get_ofertas($params, $limit, $offset);
        $flt = (float) ($results_array["total"] / $limit);
        $ent = (int) ($results_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($results_array["total"] == 0) {
            $results_array["ofertas"] = array();
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $results_array["total"],
            "hasta" => ($pagina * $limit < $results_array["total"]) ? $pagina * $limit : $results_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "ofertas" => $results_array["ofertas"],
            "pagination" => $pagination);

        $this->template->load_view('admin/panel_vendedores/ofertas/tabla_resultados_oferta_prod', $data);
    }

    /**
     * 
     */
    public function ajax_get_clientes_ofertados() {
        $formValues = $this->input->post();
        $params = array();

        if ($formValues !== false) {
            $params["vendedor_id"] = $this->identidad->get_vendedor_id();
            $params["oferta_general_id"] = $this->input->post('oferta_general_id');
            $pagina = $this->input->post('pagina');

            if ($this->input->post('show_checkboxes') != '') {
                $show_checkboxes = true;
            } else {
                $show_checkboxes = false;
            }
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $results_array = $this->oferta_general_model->get_clientes($params, $limit, $offset);
        $flt = (float) ($results_array["total"] / $limit);
        $ent = (int) ($results_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($results_array["total"] == 0) {
            $results_array["clientes"] = array();
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $results_array["total"],
            "hasta" => ($pagina * $limit < $results_array["total"]) ? $pagina * $limit : $results_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "clientes" => $results_array["clientes"],
            "pagination" => $pagination,
            "show_checkboxes" => $show_checkboxes);

        $this->template->load_view("admin/panel_vendedores/ofertas/tabla_resultados_clientes_oferta", $data);
    }
    
    public function ajax_incluir_clientes() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $oferta_general_id = $this->input->post("oferta_general_id");
                $clientes_ids = explode(";;", $this->input->post("clientes_ids"));

                foreach ($clientes_ids as $cliente) {
                    $data_grupo = array(
                        "cliente_id" => $cliente,
                        "oferta_general_id" => $oferta_general_id
                    );
                    $this->grupo_oferta_model->insert($data_grupo);
                }
            }
            echo json_encode(array("success" => "true"));
        }
    }

    public function ajax_remover_clientes() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $oferta_general_id = $this->input->post("oferta_general_id");
                $clientes_ids = explode(";;", $this->input->post("clientes_ids"));
                $clientes_actuales = $this->oferta_general_model->get_clientes_ids(array("oferta_general_id" => $oferta_general_id));

                if (sizeof($clientes_actuales) - sizeof($clientes_ids) > 0) {
                    foreach ($clientes_ids as $cliente) {
                        $this->grupo_oferta_model->delete_by(array("cliente_id" => $cliente, "oferta_general_id" => $oferta_general_id));
                    }
                    echo json_encode(array("success" => "true"));
                } else {
                    echo json_encode(array("success" => "false", "error" => "No puedes eliminar todos los clientes de una oferta."));
                }
            }
        }
    }

    public function ajax_incluir_productos() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $oferta_general_id = $this->input->post("oferta_general_id");
                $productos_ids = explode(";;", $this->input->post("productos_ids"));
                $nuevos_costos = explode(";;", $this->input->post("nuevos_costos"));

                foreach ($productos_ids as $key => $producto) {
                    $data_tarifa = array(
                        "producto_id" => $producto,
                        "oferta_general_id" => $oferta_general_id,
                        "nuevo_costo" => $nuevos_costos[$key]
                    );
                    $this->oferta_model->insert($data_tarifa);
                }
            }
            echo json_encode(array("success" => "true"));
        }
    }

    public function ajax_remover_productos() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $oferta_general_id = $this->input->post("oferta_general_id");
                $productos_ids = explode(";;", $this->input->post("productos_ids"));
                $productos_actuales = $this->oferta_general_model->get_productos_ids(array("oferta_general_id" => $oferta_general_id));

                if (sizeof($productos_actuales) - sizeof($productos_ids) > 0) {
                    foreach ($productos_ids as $producto) {
                        $this->oferta_model->delete_by(array("producto_id" => $producto, "oferta_general_id" => $oferta_general_id));
                    }
                    echo json_encode(array("success" => "true"));
                } else {
                    echo json_encode(array("success" => "false", "error" => "No puedes eliminar todos los productos de una oferta."));
                }
            }
        }
    }
    
    public function ajax_modificar_costo_oferta() {
        $productos_ids = explode(";;", $this->input->post("productos_ids"));
        $productos = $this->producto_model->get_many_by(array("id" => $productos_ids));
        $data = array("productos" => $productos);
        echo $this->load->view('admin/panel_vendedores/ofertas/ofertas_modificar_monto', $data, true);
    }
    
    public function ajax_modificar_productos() {
        $oferta_general_id = $this->input->post("oferta_general_id");
        $productos_ids = explode(";;", $this->input->post("productos_ids"));
        $nuevos_costos = explode(";;", $this->input->post("nuevos_costos"));

        foreach ($productos_ids as $key => $producto) {                        
            $this->oferta_model->update_by(array("oferta_general_id"=>$oferta_general_id,"producto_id"=>$producto),array("nuevo_costo"=>$nuevos_costos[$key]));
        }
        echo json_encode(array("success"=>"true"));
    }

}
