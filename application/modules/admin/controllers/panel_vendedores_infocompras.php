<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_infocompras extends ADController {

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
    
    public function view_listado_seguros(){
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());        

        if ($paquete->infocompra == "1") {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');

            $this->template->add_js("modules/admin/panel_vendedores/seguros_listado.js");                        
            $this->template->load_view('admin/panel_vendedores/infocompras/seguros/listado');
            
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/infocompras/sin_acceso');
        }
    }
    
    public function ajax_get_seguros() {
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
        $detalles_array = $this->solicitud_seguro_model->get_solicitudes_seguro($params, $limit, $offset);
        $flt = (float) ($detalles_array["total"] / $limit);
        $ent = (int) ($detalles_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($detalles_array["total"] == 0) {
            $detalles_array["solicitud_seguros"] = array();
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
            "solicitud_seguros" => $detalles_array["solicitud_seguros"],
            "pagination" => $pagination);

        $this->template->load_view('admin/panel_vendedores/infocompras/seguros/tabla_resultados', $data);
    }
    
}