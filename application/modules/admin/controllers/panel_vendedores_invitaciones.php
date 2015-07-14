<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_invitaciones extends MY_Controller {

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

    /**
     * 
     */
    public function buscador() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/busqueda_clientes.js");

        $this->template->load_view('admin/panel_vendedores/invitados/buscador');
    }
    /**
     * 
     */
    public function pendientes() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/invitaciones_listado.js");

        $this->template->load_view('admin/panel_vendedores/invitados/pendientes');
    }

    public function aceptadas() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/invitaciones_listado.js");

        $this->template->load_view('admin/panel_vendedores/invitados/aceptadas');
    }

    /**
     * 
     * @param type $id
     */
    public function enviar_invitacion($id) {
        $cliente = $this->cliente_model->get($id);
        $exists = $this->invitacion_model->get_by(array("cliente_id" => $id, "vendedor_id" => $this->identidad->get_vendedor_id()));

        if ($cliente && !$exists) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $accion = $this->input->post('accion');
                if ($accion == "send-invitacion") {
                    $data = array(
                        "titulo" => ($this->input->post('titulo') != '') ? $this->input->post('titulo') : null,
                        "comentario" => ($this->input->post('comentario') != '') ? $this->input->post('comentario') : null,
                        "cliente_id" => $cliente->id,
                        "vendedor_id" => $this->identidad->get_vendedor_id(),
                        "from_vendedor" => "1",
                        "estado" => "1"
                    );
                    // estado=1 - Pendiente                    

                    $this->invitacion_model->insert($data);
                    $this->session->set_flashdata('success', 'Invitacion Enviada');
                    redirect('panel_vendedor/invitaciones/buscar');
                } else {
                    redirect('panel_vendedor/invitaciones/buscar');
                }
            } else {
                $this->template->set_title("Panel de Administracion - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');

                $data = array("cliente" => $cliente);
                $this->template->load_view('admin/panel_vendedores/invitados/enviar_invitacion', $data);
            }
        } else {
            redirect('panel_vendedor/invitaciones/buscar');
        }
    }

    public function enviar_invitacion_email() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion == "send-invitacion") {
                $email = $this->input->post('email');

                //TODO : Enviar invitacion al email , crear el usuario/cliente con el correo y crear la invitacion

                $this->session->set_flashdata('success', 'Invitacion Enviada');
                redirect('panel_vendedor/invitaciones/buscar');
            } else {
                redirect('panel_vendedor/invitaciones/buscar');
            }
        } else {
            $this->template->set_title("Panel de Administracion - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');

            $this->template->load_view('admin/panel_vendedores/invitados/enviar_invitacion_email');
        }
    }

    /**
     * 
     */
    public function ajax_get_listado_clientes() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $invitaciones = $this->invitacion_model->get_many_by(array("vendedor_id" => $this->identidad->get_vendedor_id()));
        $ids_array = array();
        $ids_array[]=$this->identidad->cliente->id;
        if ($invitaciones) {
            foreach ($invitaciones as $val) {
                $ids_array[] = $val->cliente_id;
            }
        }
        $params = array();        
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
                $params["nombre_vendedor"] = $this->input->post('nombre');
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

            if (sizeof($ids_array) > 0) {
                $params["excluir_cliente_ids"] = $ids_array;
            }
            
            $params["usuario_activo"] = "1"; // Solo usuarios activos
            //$params["es_vendedor"] = "0";
            $params["join_vendedor"] =true;
            $params["excluir_admins"] = true;
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->cliente_model->get_admin_search($params, $limit, $offset,"vendedor.nombre","asc");
        $flt = (float) ($clientes_array["total"] / $limit);
        $ent = (int) ($clientes_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($clientes_array["total"] == 0) {
            $clientes_array["clientes"] = array();
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


        $this->template->load_view('admin/panel_vendedores/invitados/tabla_resultados', $data);
    }

    public function ajax_get_listado_resultados() {
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


        $this->template->load_view($layout, $data);
    }

    /**
     * 
     */
    public function recibidas() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/invitaciones_listado.js");
        $this->template->load_view('admin/panel_vendedores/invitados/recibidas');
    }

    /**
     * 
     * @param type $id
     */
    public function aceptar_invitacion($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);

            $invitacion = $this->invitacion_model->get($id);
            if ($invitacion->vendedor_id == $vendedor->get_vendedor_id()) {
                $this->invitacion_model->update($id, array("estado" => "2"));
            } else {
                
            }
        }
    }

    /**
     * 
     * @param type $id
     */
    public function rechazar_invitacion($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);

            $invitacion = $this->invitacion_model->get($id);
            if ($invitacion->vendedor_id == $vendedor->get_vendedor_id()) {
                $this->invitacion_model->update($id, array("estado" => "3"));
            } else {
                
            }
        }
    }

}
