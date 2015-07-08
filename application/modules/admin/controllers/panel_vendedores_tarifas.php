<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_tarifas extends MY_Controller {

    var $identidad;

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->get_identidad();
    }

    private function get_identidad() {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        $this->identidad = $vendedor;
    }

    public function nueva_tarifa_paso1() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/tarifa_listado_productos.js");

        $this->session->unset_userdata('pv_tarifas_incluir_ids_productos');

        $this->template->load_view('admin/panel_vendedores/tarifas/listado_productos');
    }

    public function nueva_seleccion_clientes() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/tarifa_listado_clientes.js");

        $this->session->unset_userdata('pv_tarifas_incluir_ids_clientes');

        $this->template->load_view('admin/panel_vendedores/tarifas/listado_clientes');
    }

    public function detalles_tarifa() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/tarifa_detalles.js");

        $this->template->load_view('admin/panel_vendedores/tarifas/detalles_tarifa');
    }

    public function crear_tarifa() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "item-crear") {

                $productos_ids = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                $clientes_ids = $this->session->userdata('pv_tarifas_incluir_ids_clientes');

                foreach ($productos_ids as $producto) {
                    $data_tarifa = array(
                        "comentario" => ($this->input->post('comentario') != '') ? $this->input->post('comentario') : null,
                        "nuevo_costo" => ($this->input->post('nuevo_costo') != '') ? $this->input->post('nuevo_costo') : "0",
                        "porcentaje" => ($this->input->post('porcentaje') != '') ? $this->input->post('porcentaje') : null,
                        "producto_id" => $producto
                    );

                    $tarifa_id = $this->tarifa_model->insert($data_tarifa);

                    foreach ($clientes_ids as $cliente) {
                        $data_grupo = array(
                            "vendedor_id" => $this->identidad->get_vendedor_id(),
                            "cliente_id" => $cliente
                        );
                        $grupo_id = $this->grupo_model->insert($data_grupo);
                        $grupo_tarifa = array(
                            "grupo_id" => $grupo_id,
                            "tarifa_id" => $tarifa_id);

                        $this->grupo_tarifa_model->insert($grupo_tarifa);
                    }
                }
                redirect('panel_vendedor');
            }
        }
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
                $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                if ($ids_old) {
                    $params["excluir_ids"] = $ids_old;
                }
            }

            if ($this->input->post('incluir_ids') != "") {
                $ids = explode(";;", $this->input->post('incluir_ids'));
                $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                if ($ids_old) {
                    $ids = array_unique(array_merge($ids, $ids_old));
                }
                $params["incluir_ids"] = $ids;
                $this->session->set_userdata(array('pv_tarifas_incluir_ids_productos' => $ids));
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
     * 
     */
    public function ajax_get_invitados() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $flag_left_panel = true;
        $flag_query = false;

        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
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
                $ids = explode(";;", $this->input->post('incluir_ids'));
                $ids_old = $this->session->userdata('pv_tarifas_incluir_ids_clientes');
                if ($ids_old) {
                    $ids = array_unique(array_merge($ids, $ids_old));
                }
                $params["incluir_ids_clientes"] = $ids;
                $this->session->set_userdata(array('pv_tarifas_incluir_ids_clientes' => $ids));
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

            $params["estado"] = "2";
            $params["vendedor_id"] = $this->identidad->get_vendedor_id();
            $params["excluir_admins"] = true;
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->invitacion_model->get_admin_search($params, $limit, $offset);
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
            "left_panel" => $flag_left_panel);


        $this->template->load_view("admin/panel_vendedores/tarifas/tabla_resultados_clientes", $data);
    }

}
