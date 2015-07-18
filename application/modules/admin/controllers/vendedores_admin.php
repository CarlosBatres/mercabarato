<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendedores_admin extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     * 
     */
    public function asignar_listado() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/vendedores_admin_listado.js");
        $this->template->load_view('admin/vendedores_admin/listado_nuevo');
    }

    public function asignar($id) {
        if ($this->input->is_ajax_request()) {
            $usuario = $this->usuario_model->get($id);
            $this->permisos_model->convertir_a_vendedor_admin($usuario->id);            
        }
    }
    
    public function cancelar($id) {
        if ($this->input->is_ajax_request()) {
            $usuario = $this->usuario_model->get($id);
            $this->permisos_model->convertir_a_usuario($usuario->id);            
        }
    }
    
    public function listado_actual() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/vendedores_admin_listado_actual.js");
        $this->template->load_view('admin/vendedores_admin/listado_actual');
    }

    public function ajax_get_listado_resultados() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();        
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            if ($this->input->post('actividad') != "No Especificada") {
                $params["actividad"] = $this->input->post('actividad');
            }
            if ($this->input->post('sitio_web') != "") {
                $params["sitio_web"] = $this->input->post('sitio_web');
            }
            
            if ($this->input->post('listado_actual') != "") {
                $layout='admin/vendedores_admin/tabla_resultados_actual';
                $params["permisos_id"] = "2";
            }else{
                $params["permisos_id"] = "4";
                $layout='admin/vendedores_admin/tabla_resultados_nuevo';
            }
            
            $params["usuario_activo"]=true;
            
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $result_array = $this->permisos_model->buscar_clientes($params, $limit, $offset);
        $flt = (float) ($result_array["total"] / $limit);
        $ent = (int) ($result_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($result_array["total"] == 0) {
            $result_array["clientes"] = array();
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $result_array["total"],
            "hasta" => ($pagina * $limit < $result_array["total"]) ? $pagina * $limit : $result_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "clientes" => $result_array["clientes"],
            "pagination" => $pagination);

        $this->template->load_view($layout, $data);
    }

}
