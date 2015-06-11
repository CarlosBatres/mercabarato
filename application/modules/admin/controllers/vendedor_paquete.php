<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendedor_paquete extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->authentication->is_loggedin()) {
            redirect('admin/login');
        } else {
            if (!$this->authentication->user_is_admin()) {
                redirect('admin/sin_permiso');
            }
        }
    } 
    
    /**
     *  Listado
     */
    public function view_listado_por_activar() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/vendedor_paquete_listado.js");
        $this->template->load_view('admin/vendedor_paquete/listado_por_activar');
    }
    /**
     * 
     * @param type $id
     */
    public function aprobar($id){
        $this->vendedor_paquete_model->aprobar_paquete($id);
        redirect('admin/vendedor_paquetes/listado_por_activar');
    }
    
    /**
     *  AJAX Productos / Listado
     */
    public function ajax_get_listado_resultados() {
        $formValues = $this->input->post();

        $params = array();
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
        $vendedor_paquetes_array = $this->vendedor_paquete_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($vendedor_paquetes_array["total"] / $limit);
        $ent = (int) ($vendedor_paquetes_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }
        // TODO: Falta testear mas

        if ($vendedor_paquetes_array["total"] == 0) {
            $vendedor_paquetes_array["vendedor_paquetes"] = array();
            // TODO: Resultados vacio
        }
        $data = array(
            "vendedor_paquetes" => $vendedor_paquetes_array["vendedor_paquetes"],
            "search_params" => array(
                "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina" => $limit,
                "total" => $vendedor_paquetes_array["total"],
                "hasta" => ($pagina * $limit < $vendedor_paquetes_array["total"]) ? $pagina * $limit : $vendedor_paquetes_array["total"],
                "desde" => (($pagina * $limit) - $limit) + 1));

        $this->template->load_view('admin/vendedor_paquete/tabla_resultados', $data);
    }

    
    
}