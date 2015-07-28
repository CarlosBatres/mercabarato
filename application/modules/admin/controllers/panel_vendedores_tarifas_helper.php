<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_tarifas_helper extends ADController {

    var $identidad;

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->get_identidad();
    }

    /**
     * 
     */
    private function get_identidad() {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        $this->identidad = $vendedor;
    }

    /*
     * AJAX productos tarifados
     */

    public function ajax_get_productos_tarifados() {
        $formValues = $this->input->post();
        $params = array();

        if ($formValues !== false) {
            $params["vendedor_id"] = $this->identidad->get_vendedor_id();
            $params["tarifa_general_id"] = $this->input->post('tarifa_general_id');
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
        $productos_array = $this->tarifa_general_model->get_productos($params, $limit, $offset);
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

        $this->template->load_view('admin/panel_vendedores/tarifas/tabla_resultados_productos_tarifa', $data);
    }

    /**
     * AJAX Clientes Tarifados
     */
    public function ajax_get_clientes_tarifados() {
        $formValues = $this->input->post();
        $params = array();

        if ($formValues !== false) {
            $params["vendedor_id"] = $this->identidad->get_vendedor_id();
            $params["tarifa_general_id"] = $this->input->post('tarifa_general_id');
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
        $results_array = $this->tarifa_general_model->get_clientes($params, $limit, $offset);
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

        $this->template->load_view("admin/panel_vendedores/tarifas/tabla_resultados_clientes_tarifa", $data);
    }

    /**
     * 
     */
    public function incluir_todos_productos() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $params = array();
                $params["vendedor_id"] = $this->identidad->get_vendedor_id();
                $params["group_by_producto_id"] = true;
                $productos_array = $this->producto_model->get_tarifas_search($params, false, false);

                if ($productos_array["total"] > 0) {
                    $ids = array();
                    foreach ($productos_array["productos"] as $producto) {
                        $ids[] = $producto->id;
                    }
                    $this->session->set_userdata(array('pv_tarifas_incluir_ids_productos' => $ids));
                }

                echo json_encode(array("success" => true));
            }
        }
    }

    /**
     * 
     */
    public function incluir_todos_clientes() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $params = array();
                $params["usuario_id"] = $this->identidad->usuario->id;
                $params["excluir_admins"] = true;

                $producto_seleccionado_ids = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                if ($producto_seleccionado_ids) {
                    $clientes_arr = $this->tarifa_model->get_clientes_for_productos($producto_seleccionado_ids);
                    if ($clientes_arr) {
                        $params['excluir_ids_clientes'] = $clientes_arr;
                    }
                }

                $clientes_array = $this->invitacion_model->get_invitaciones_aceptadas($params, false, false);
                if ($clientes_array["total"] > 0) {
                    $clientes_array["clientes"] = $clientes_array["invitaciones"];
                    $ids = array();
                    foreach ($clientes_array["clientes"] as $cliente) {
                        $ids[] = $cliente->id;
                    }
                    $this->session->set_userdata(array('pv_tarifas_incluir_ids_clientes' => $ids));
                }

                echo json_encode(array("success" => true));
            }
        }
    }

    /**
     * 
     */
    public function ajax_get_tarifas() {
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
        $results_array = $this->tarifa_general_model->get_tarifas($params, $limit, $offset);
        $flt = (float) ($results_array["total"] / $limit);
        $ent = (int) ($results_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($results_array["total"] == 0) {
            $results_array["tarifas"] = array();
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
            "tarifas" => $results_array["tarifas"],
            "pagination" => $pagination);

        $this->template->load_view('admin/panel_vendedores/tarifas/tabla_resultados_tarifa_prod', $data);
    }

    /**
     * 
     */
    public function ajax_get_tarifa_detalles() {
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
        $detalles_array = $this->tarifa_model->get_tarifas_detalles($params, $limit, $offset);
        $flt = (float) ($detalles_array["total"] / $limit);
        $ent = (int) ($detalles_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($detalles_array["total"] == 0) {
            $detalles_array["tarifas"] = array();
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
            "tarifas" => $detalles_array["tarifas"],
            "pagination" => $pagination,
            "left_panel" => $flag_left_panel);

        $this->template->load_view('admin/panel_vendedores/tarifas/tabla_resultados_tarifa_prod', $data);
    }

    /**
     * 
     */
    public function ajax_get_productos() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $params["vendedor_id"] = $this->identidad->get_vendedor_id();
        $flag_left_panel = true;

        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
                $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                if ($ids_old) {
                    $params["excluir_ids"] = $ids_old;
                }
            }

            if ($this->input->post('incluir_ids') != "") {
                if ($this->input->post('incluir_ids') != 'false') {
                    $ids = explode(";;", $this->input->post('incluir_ids'));
                    $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                    if ($ids_old) {
                        $ids = array_unique(array_merge($ids, $ids_old));
                    }
                    $params["incluir_ids"] = $ids;
                    $this->session->set_userdata(array('pv_tarifas_incluir_ids_productos' => $ids));
                } else {
                    $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                    if (!$ids_old) {
                        $params["incluir_ids"] = array("0");
                    } else {
                        $params["incluir_ids"] = $ids_old;
                    }
                }
            }


            if ($this->input->post('excluir_ids') != "") {
                $ids = explode(";;", $this->input->post('excluir_ids'));
                $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                if ($ids_old) {
                    $ids = array_unique(array_merge($ids, $ids_old));
                }
                $params["excluir_ids"] = $ids;
            }

            if ($this->input->post('search_main') != "") {
                $check_ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                if ($check_ids_old && !isset($params["excluir_ids"])) {
                    $params["excluir_ids"] = $check_ids_old;
                }
                $flag_left_panel = true;
            } else {
                $check_ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                if ($check_ids_old && !isset($params["incluir_ids"])) {
                    $params["incluir_ids"] = $check_ids_old;
                }
                $flag_left_panel = false;
            }

            if ($this->input->post('show_checkboxes') != '') {
                $flag_left_panel = true;
            }

            if ($this->input->post('ignore_tarifa_general_id') != '') {
                $prod_ids = $this->tarifa_general_model->get_productos_ids(array("tarifa_general_id" => $this->input->post('ignore_tarifa_general_id')));
                $clie_ids = $this->tarifa_general_model->get_clientes_ids(array("tarifa_general_id" => $this->input->post('ignore_tarifa_general_id')));
                $prod_ids2 = $this->tarifa_general_model->get_productos_ids_from_clientes(array("clientes_ids" => $clie_ids, "vendedor_id" => $this->identidad->get_vendedor_id()));

                $params["excluir_ids"] = array_unique(array_merge($prod_ids, $prod_ids2));
            }


            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }



        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $productos_array = $this->producto_model->get_tarifas_search($params, $limit, $offset);
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

        $this->template->load_view('admin/panel_vendedores/tarifas/tabla_resultados_productos', $data);
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
            if ($this->input->post('sexo') != 'X') {
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
                $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_clientes');
                if ($ids_old) {
                    $params["excluir_ids_clientes"] = $ids_old;
                }
            }

            if ($this->input->post('incluir_ids') != "") {
                if ($this->input->post('incluir_ids') != 'false') {
                    $ids = explode(";;", $this->input->post('incluir_ids'));
                    $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_clientes');
                    if ($ids_old) {
                        $ids = array_unique(array_merge($ids, $ids_old));
                    }
                    $params["incluir_ids_clientes"] = $ids;
                    $this->session->set_userdata(array('pv_tarifas_incluir_ids_clientes' => $ids));
                } else {
                    $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_clientes');
                    if (!$ids_old) {
                        $params["incluir_ids_clientes"] = array("0");
                    } else {
                        $params["incluir_ids_clientes"] = $ids_old;
                    }
                }
            }

            if ($this->input->post('excluir_ids') != "") {
                $ids = explode(";;", $this->input->post('excluir_ids'));
                $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_clientes');
                if ($ids_old) {
                    $ids = array_unique(array_merge($ids, $ids_old));
                }
                $params["excluir_ids_clientes"] = $ids;
            }

            if ($this->input->post('search_main') != "") {
                $check_ids_old = $this->session->userdata('pv_tarifas_incluir_ids_clientes');
                if ($check_ids_old && !isset($params["excluir_ids"])) {
                    $params["excluir_ids_clientes"] = $check_ids_old;
                }
                $flag_left_panel = true;
            } else {
                $check_ids_old = $this->session->userdata('pv_tarifas_incluir_ids_clientes');
                if ($check_ids_old && !isset($params["incluir_ids"])) {
                    $params["incluir_ids_clientes"] = $check_ids_old;
                }
                $flag_left_panel = false;
            }

            $producto_seleccionado_ids = $this->session->userdata('pv_tarifas_incluir_ids_productos');
            if ($producto_seleccionado_ids) {
                $clientes_arr = $this->tarifa_model->get_clientes_for_productos($producto_seleccionado_ids);
                if (isset($params['excluir_ids_clientes']) && $clientes_arr) {
                    $params['excluir_ids_clientes'] = array_unique(array_merge($params['excluir_ids_clientes'], $clientes_arr));
                }
            }

            if ($this->input->post('show_checkboxes') != '') {
                $show_checkboxes = true;
            } else {
                $show_checkboxes = false;
            }

            /**
             * IMPORTANTE!!
             * Ignoramos todos los clientes ya presentes en esta tarifa_general y los que ya tienen tarifas asignadas a los productos
             * SOLO UNA TARIFA POR CLIENTE->PRODUCTO
             */
            if ($this->input->post('ignore_tarifa_general_id') != '') {
                $params["excluir_ids_clientes"] = $this->tarifa_general_model->get_clientes_ids(array("tarifa_general_id" => $this->input->post('ignore_tarifa_general_id')));
                $producto_ids = $this->tarifa_general_model->get_productos_ids(array("tarifa_general_id" => $this->input->post('ignore_tarifa_general_id')));
                $clientes_arr = $this->tarifa_model->get_clientes_for_productos($producto_ids);
                if (isset($params['excluir_ids_clientes']) && $clientes_arr) {
                    $params['excluir_ids_clientes'] = array_unique(array_merge($params['excluir_ids_clientes'], $clientes_arr));
                }
            }


            $params["usuario_id"] = $this->identidad->usuario->id;
            $params["excluir_admins"] = true;
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->invitacion_model->get_invitaciones_aceptadas($params, $limit, $offset, "invitacion_id", "asc");
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
            $clientes_array["clientes"] = $clientes_array["invitaciones"];
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


        $this->template->load_view("admin/panel_vendedores/tarifas/tabla_resultados_clientes", $data);
    }

    public function ajax_incluir_clientes() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $tarifa_general_id = $this->input->post("tarifa_general_id");
                $clientes_ids = explode(";;", $this->input->post("clientes_ids"));

                foreach ($clientes_ids as $cliente) {
                    $data_grupo = array(
                        "cliente_id" => $cliente,
                        "tarifa_general_id" => $tarifa_general_id
                    );
                    $this->grupo_tarifa_model->insert($data_grupo);
                }
            }
            echo json_encode(array("success" => "true"));
        }
    }

    public function ajax_remover_clientes() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $tarifa_general_id = $this->input->post("tarifa_general_id");
                $clientes_ids = explode(";;", $this->input->post("clientes_ids"));
                $clientes_actuales = $this->tarifa_general_model->get_clientes_ids(array("tarifa_general_id" => $tarifa_general_id));

                if (sizeof($clientes_actuales) - sizeof($clientes_ids) > 0) {
                    foreach ($clientes_ids as $cliente) {
                        $this->grupo_tarifa_model->delete_by(array("cliente_id" => $cliente, "tarifa_general_id" => $tarifa_general_id));
                    }
                    echo json_encode(array("success" => "true"));
                } else {
                    echo json_encode(array("success" => "false", "error" => "No puedes eliminar todos los clientes de una tarifa."));
                }
            }
        }
    }

    public function ajax_incluir_productos() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $tarifa_general_id = $this->input->post("tarifa_general_id");
                $productos_ids = explode(";;", $this->input->post("productos_ids"));
                $nuevos_costos = explode(";;", $this->input->post("nuevos_costos"));

                foreach ($productos_ids as $key => $producto) {
                    $data_tarifa = array(
                        "producto_id" => $producto,
                        "tarifa_general_id" => $tarifa_general_id,
                        "nuevo_costo" => $nuevos_costos[$key]
                    );
                    $this->tarifa_model->insert($data_tarifa);
                }
            }
            echo json_encode(array("success" => "true"));
        }
    }

    public function ajax_remover_productos() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $tarifa_general_id = $this->input->post("tarifa_general_id");
                $productos_ids = explode(";;", $this->input->post("productos_ids"));
                $productos_actuales = $this->tarifa_general_model->get_productos_ids(array("tarifa_general_id" => $tarifa_general_id));

                if (sizeof($productos_actuales) - sizeof($productos_ids) > 0) {
                    foreach ($productos_ids as $producto) {
                        $this->tarifa_model->delete_by(array("producto_id" => $producto, "tarifa_general_id" => $tarifa_general_id));
                    }
                    echo json_encode(array("success" => "true"));
                } else {
                    echo json_encode(array("success" => "false", "error" => "No puedes eliminar todos los productos de una tarifa."));
                }
            }
        }
    }

    public function ajax_modificar_costo_tarifa() {
        $productos_ids = explode(";;", $this->input->post("productos_ids"));
        $productos = $this->producto_model->get_many_by(array("id" => $productos_ids));
        $data = array("productos" => $productos);
        echo $this->load->view('admin/panel_vendedores/tarifas/tarifas_modificar_monto', $data, true);
    }

    public function ajax_modificar_productos() {
        $tarifa_general_id = $this->input->post("tarifa_general_id");
        $productos_ids = explode(";;", $this->input->post("productos_ids"));
        $nuevos_costos = explode(";;", $this->input->post("nuevos_costos"));

        foreach ($productos_ids as $key => $producto) {                        
            $this->tarifa_model->update_by(array("tarifa_general_id"=>$tarifa_general_id,"producto_id"=>$producto),array("nuevo_costo"=>$nuevos_costos[$key]));
        }
        echo json_encode(array("success"=>"true"));
    }

}
