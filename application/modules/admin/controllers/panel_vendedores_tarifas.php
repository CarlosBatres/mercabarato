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
        $this->template->add_js("modules/admin/panel_vendedores/tarifas_listado.js");
        $this->template->load_view('admin/panel_vendedores/tarifas/listado_productos');
    }

    public function nueva_tarifa_producto($producto_id) {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);

        $res = $this->producto_model->get_vendedor_id_del_producto($producto_id);
        // Validamos que el vendedor sea dueño de este producto
        if ($res == $vendedor->get_vendedor_id()) {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');

            $this->template->add_js("modules/admin/panel_vendedores/tarifa_listado_clientes.js");
            $this->template->load_view('admin/panel_vendedores/tarifas/listado_clientes');
        } else {
            redirect('404');
        }
    }

    /**
     * 
     */
    public function ajax_get_productos() {
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
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
            "pagination" => $pagination);

        $this->template->load_view('admin/panel_vendedores/tarifas/tabla_resultados_productos', $data);
    }
    

    public function ajax_get_invitados() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        $layout = 'admin/panel_vendedores/invitados/tabla_resultados';
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            if ($this->input->post('sexo') != 'X') {
                $params["sexo"] = $this->input->post('sexo');
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            if ($this->input->post('keywords') != "") {
                $keywords = explode(",", $this->input->post('keywords'));
                $params["keywords"] = $keywords;
            }

            if ($this->input->post('tipo') == "invitaciones_recibidas") {
                $layout = 'admin/panel_vendedores/invitados/tabla_resultados_recibidas';
                $params["from_vendedor"] = "0";
                $params["estado"] = "1";
            } elseif ($this->input->post('tipo') == "invitaciones_aceptadas") {
                $layout = 'admin/panel_vendedores/invitados/tabla_resultados_pendiente';
                $params["estado"] = "2";
            } elseif ($this->input->post('tipo') == "invitaciones_pendientes") {
                $layout = 'admin/panel_vendedores/invitados/tabla_resultados_pendiente';
                $params["from_vendedor"] = "1";
                $params["estado"] = "1";
            }

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
            "pagination" => $pagination);


        $this->template->load_view("admin/panel_vendedores/tarifas/tabla_resultados_clientes", $data);
    }

}
