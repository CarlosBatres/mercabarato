<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_ofertas2_helper extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
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

        $this->template->load_view('admin/panel_vendedores/ofertas2/tabla_resultados_productos_oferta', $data);
    }

    public function ajax_get_productos() {
        $formValues = $this->input->post();
        $params = array();
        $params["vendedor_id"] = $this->identidad->get_vendedor_id();
        $flag_left_panel = true;

        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }

            if ($this->input->post('incluir_ids') != "") {
                if ($this->input->post('incluir_ids') != "false") {
                    $ids = explode(";;", $this->input->post('incluir_ids'));
                    $params["incluir_ids"] = $ids;
                } else {
                    $params["incluir_ids"] = array("0");
                }
            }

            if ($this->input->post('excluir_ids') != "") {
                $ids = explode(";;", $this->input->post('excluir_ids'));
                $params["excluir_ids"] = $ids;
            }

            if ($this->input->post('show_checkboxes') != '') {
                $flag_left_panel = true;
            } else {
                $flag_left_panel = false;
            }

            if ($this->input->post('ignore_oferta_general_id') != '') {
                $prod_ids = $this->oferta_general_model->get_productos_ids(array("oferta_general_id" => $this->input->post('ignore_oferta_general_id')));
                if ($prod_ids) {
                    if (isset($params['excluir_ids'])) {
                        $params['excluir_ids'] = array_unique(array_merge($prod_ids, $params['excluir_ids']));
                    } else {
                        $params['excluir_ids'] = $prod_ids;
                    }
                }
                $prod_ids_otras_ofertas = $this->oferta_general_model->get_productos_ids(array("vendedor_id" => $params["vendedor_id"]));
                if ($prod_ids_otras_ofertas) {
                    if (isset($params['excluir_ids'])) {
                        $params['excluir_ids'] = array_unique(array_merge($prod_ids_otras_ofertas, $params['excluir_ids']));
                    } else {
                        $params['excluir_ids'] = $prod_ids_otras_ofertas;
                    }
                }
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

        $this->template->load_view('admin/panel_vendedores/ofertas2/tabla_resultados_productos', $data);
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
        echo $this->load->view('admin/panel_vendedores/ofertas2/oferta_modificar_monto', $data, true);
    }

    public function ajax_modificar_productos() {
        $oferta_general_id = $this->input->post("oferta_general_id");
        $productos_ids = explode(";;", $this->input->post("productos_ids"));
        $nuevos_costos = explode(";;", $this->input->post("nuevos_costos"));

        foreach ($productos_ids as $key => $producto) {
            $this->oferta_model->update_by(array("oferta_general_id" => $oferta_general_id, "producto_id" => $producto), array("nuevo_costo" => $nuevos_costos[$key]));
        }
        echo json_encode(array("success" => "true"));
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

    public function ajax_get_ofertas() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $params["owner_vendedor_id"] = $this->identidad->get_vendedor_id();

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
        $results_array = $this->oferta_general_model->get_ofertasv2($params, $limit, $offset);
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

        $this->template->load_view('admin/panel_vendedores/ofertas2/tabla_resultados_oferta_prod', $data);
    }

    public function ajax_get_requisitos() {
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
        $productos_array = $this->oferta_general_model->get_requisitos($params, $limit, $offset);
        $flt = (float) ($productos_array["total"] / $limit);
        $ent = (int) ($productos_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($productos_array["total"] == 0) {
            $productos_array["requisitos"] = array();
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
            "requisitos" => $productos_array["requisitos"],
            "pagination" => $pagination,
            "show_checkboxes" => $show_checkboxes);

        $this->template->load_view('admin/panel_vendedores/ofertas2/tabla_resultados_requisitos_oferta', $data);
    }

    public function ajax_get_requisitos_disponibles() {
        //$this->show_profiler();
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
        $productos_array = $this->oferta_general_model->get_requisitos_disponibles($params, $limit, $offset);
        $flt = (float) ($productos_array["total"] / $limit);
        $ent = (int) ($productos_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($productos_array["total"] == 0) {
            $productos_array["requisitos"] = array();
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
            "requisitos" => $productos_array["requisitos"],
            "pagination" => $pagination,
            "show_checkboxes" => $show_checkboxes);

        $this->template->load_view('admin/panel_vendedores/ofertas2/tabla_resultados_requisitos_oferta', $data);
    }

    public function ajax_incluir_requisitos() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $oferta_general_id = $this->input->post("oferta_general_id");
                $productos_ids = explode(";;", $this->input->post("productos_ids"));

                foreach ($productos_ids as $key => $producto) {
                    $data = array(
                        "producto_id" => $producto,
                        "oferta_general_id" => $oferta_general_id,
                        "visitas" => "1"
                    );
                    $this->requisito_visitas_model->insert($data);
                }
            }
            echo json_encode(array("success" => "true"));
        }
    }

    public function ajax_remover_requisitos() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $oferta_general_id = $this->input->post("oferta_general_id");
                $productos_ids = explode(";;", $this->input->post("productos_ids"));
                $productos_actuales = $this->oferta_general_model->get_requisitos_ids(array("oferta_general_id" => $oferta_general_id));

                if (sizeof($productos_actuales) - sizeof($productos_ids) > 0) {
                    foreach ($productos_ids as $producto) {
                        $this->requisito_visitas_model->delete_by(array("producto_id" => $producto, "oferta_general_id" => $oferta_general_id));
                    }
                    echo json_encode(array("success" => "true"));
                } else {
                    echo json_encode(array("success" => "false", "error" => "No puedes eliminar todos los productos de una oferta."));
                }
            }
        }
    }

    public function ajax_get_clientes_oferta() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();

        if ($formValues !== false) {
            $params["vendedor_id"] = $this->identidad->get_vendedor_id();
            $params["oferta_general_id"] = $this->input->post('oferta_general_id');
            $pagina = $this->input->post('pagina');            
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $productos_array = $this->oferta_general_model->get_clientes($params, $limit, $offset);
        $flt = (float) ($productos_array["total"] / $limit);
        $ent = (int) ($productos_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($productos_array["total"] == 0) {
            $productos_array["clientes"] = array();
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
            "clientes" => $productos_array["clientes"],
            "pagination" => $pagination);

        $this->template->load_view('admin/panel_vendedores/ofertas2/tabla_resultados_clientes_oferta', $data);
    }

}
