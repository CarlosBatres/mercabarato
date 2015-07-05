<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_tarifas extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    public function listado() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/tarifas_listado.js");
        $this->template->load_view('admin/panel_vendedores/tarifas/listado');
    }

    public function ajax_get_listado_resultados() {
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

        $this->template->load_view('admin/panel_vendedores/tarifas/tabla_resultados', $data);
    }

    /**
     * 
     */
    public function modificar() {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $producto_id = $this->input->post("producto_id");
            $monto = $this->input->post("monto");

            $res = $this->producto_model->get_vendedor_id_del_producto($producto_id);
            if ($res == $vendedor->get_vendedor_id()) {
                $producto = $this->producto_model->get($producto_id);

                if ($monto < $producto->precio) {
                    $tarifa = $this->tarifa_model->get_by(array("producto_id" => $producto_id));
                    if ($tarifa) {
                        $this->tarifa_model->update($tarifa->id,array("monto"=>$monto));                        
                    } else {
                        $data = array(
                            "producto_id" => $producto_id,
                            "monto" => $monto);
                        $this->tarifa_model->insert($data);
                    }

                    $this->session->set_flashdata('success', 'Se modifico la tarifa asociada a este producto con exito..');
                } else {
                    $this->session->set_flashdata('error', 'El valor para la tarifa no puede ser igual o mayor al precio original.');
                }
            } else {
                $this->session->set_flashdata('error', 'No puedes realizar esta accion.');
            }
            echo json_encode(array("success" => true));
        } else {
            redirect('404');
        }
    }

}
