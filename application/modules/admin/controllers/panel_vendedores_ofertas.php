<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_ofertas extends ADController {

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

    public function nueva_oferta_paso1() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete->limite_productos != "0") {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->add_js("modules/admin/panel_vendedores/ofertas_listado_productos.js");

            $this->session->unset_userdata('pv_ofertas_incluir_ids_productos');

            $this->template->load_view('admin/panel_vendedores/ofertas/listado_productos');
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
        }
    }

    /**
     * 
     */
    public function nueva_seleccion_clientes() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/ofertas_listado_clientes.js");

        $this->session->unset_userdata('pv_ofertas_incluir_ids_clientes');

        $this->template->load_view('admin/panel_vendedores/ofertas/listado_clientes');
    }

    /**
     * 
     */
    public function detalles_oferta() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $ids_clientes = $this->session->userdata('pv_ofertas_incluir_ids_clientes');
        $ids_productos = $this->session->userdata('pv_ofertas_incluir_ids_productos');

        if ($ids_clientes && $ids_productos) {
            $productos_seleccionados = $ids_productos;
            $mas_de_uno = false;
            if ($productos_seleccionados) {
                if (sizeof($productos_seleccionados) > 1) {
                    $mas_de_uno = true;
                }
            }

            $this->template->add_js("modules/admin/panel_vendedores/ofertas_detalles.js");
            $this->template->load_view('admin/panel_vendedores/ofertas/detalles_oferta', array("mas_de_uno" => $mas_de_uno));
        } else {
            redirect('panel_vendedor');
        }
    }

    /**
     * 
     */
    public function view_listado() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete->limite_productos != "0") {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');

            $this->template->add_js("modules/admin/panel_vendedores/ofertas_listado.js");
            $categorias = $this->categoria_model->get_all();
            $data = array("categorias" => $categorias);
            $this->template->load_view('admin/panel_vendedores/ofertas/listado', $data);
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
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            $oferta_id = $id;

            $res = $this->oferta_model->get_vendedor_id_de_oferta($oferta_id);
            if ($res == $this->identidad->get_vendedor_id()) {
                $this->oferta_model->delete($oferta_id);
                $this->session->set_flashdata('success', 'Tarifa eliminada con exito..');
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
    public function crear_oferta() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "item-crear") {

                $productos_ids = $this->session->userdata('pv_ofertas_incluir_ids_productos');
                $clientes_ids = $this->session->userdata('pv_ofertas_incluir_ids_clientes');

                foreach ($productos_ids as $producto) {
                    $producto_obj = $this->producto_model->get($producto);

                    if ($this->input->post('tipo') == 'porcentaje') {
                        $monto_a_deducir = $producto_obj->precio * ($this->input->post('valor') / 100);
                        $nuevo_costo = $producto_obj->precio - $monto_a_deducir;
                        $porcentaje = $this->input->post('valor');
                    } else {
                        $nuevo_costo = $this->input->post('valor');
                        $porcentaje = 0;
                    }

                    $data_oferta = array(
                        "nombre" => ($this->input->post('comentario') != '') ? $this->input->post('comentario') : null,
                        "descripcion" => ($this->input->post('descripcion') != '') ? $this->input->post('descripcion') : null,
                        "nuevo_costo" => $nuevo_costo,
                        "porcentaje" => $porcentaje,
                        "producto_id" => $producto,
                        "fecha_inicio" => ($this->input->post('fecha_inicio') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_inicio'))) : null,
                        "fecha_finaliza" => ($this->input->post('fecha_finaliza') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_finaliza'))) : null,
                    );

                    $oferta_id = $this->oferta_model->insert($data_oferta);

                    foreach ($clientes_ids as $cliente) {
                        $data_grupo = array(
                            "vendedor_id" => $this->identidad->get_vendedor_id(),
                            "cliente_id" => $cliente
                        );
                        $grupo_id = $this->grupo_model->insert($data_grupo);
                        $grupo_oferta = array(
                            "grupo_id" => $grupo_id,
                            "oferta_id" => $oferta_id);

                        $this->grupo_oferta_model->insert($grupo_oferta);
                    }
                }
                $this->session->unset_userdata('pv_ofertas_incluir_ids_clientes');
                $this->session->unset_userdata('pv_ofertas_incluir_ids_productos');
                redirect('panel_vendedor/ofertas/listado');
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
            }

            $params["usuario_id"] = $this->identidad->usuario->id;
            $params["excluir_admins"] = true;
            $params["usuario_activo"] = "1";
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->cliente_model->get_clientes_ofertas($params, $limit, $offset);
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
            "left_panel" => $flag_left_panel);


        $this->template->load_view("admin/panel_vendedores/ofertas/tabla_resultados_clientes", $data);
    }

    /**
     * 
     */
    public function ajax_get_productos_ofertados() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $params["vendedor_id"] = $this->identidad->get_vendedor_id();
        $flag_left_panel = true;

        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            if ($this->input->post('solo_ofertados') != "") {
                $params["solo_ofertados"] = $this->input->post('solo_ofertados');
            }

            $params["group_by_producto_id"] = true;
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

        $this->template->load_view('admin/panel_vendedores/ofertas/tabla_resultados_oferta_prod', $data);
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

}
