<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }

    /**
     * Vista - Panel Vendedor
     */
    public function resumen() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/resumen.js");

        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);

        $mis_productos = $this->producto_model->get_many_by("vendedor_id", $vendedor->get_vendedor_id());
        $mis_anuncios = $this->anuncio_model->get_many_by("vendedor_id", $vendedor->get_vendedor_id());

        $invitar_desde = $this->invitacion_model->get_many_by(array("invitar_desde" => $vendedor->usuario->id, "estado" => "2"));
        $invitar_para = $this->invitacion_model->get_many_by(array("invitar_para" => $vendedor->usuario->id, "estado" => "2"));
        $mis_clientes = array_merge($invitar_desde, $invitar_para);

        $paquete_vigente = $this->vendedor_model->get_paquete_en_curso($vendedor->get_vendedor_id());
        $paquete_pendiente = $this->vendedor_model->get_paquete_pendiente($vendedor->get_vendedor_id());
        if ($paquete_vigente) {
            $paquete = $paquete_vigente;
            $paquete_vigente = true;
            $paquete_pendiente = false;
        } elseif ($paquete_pendiente) {
            $paquete = $paquete_pendiente;
            $paquete_pendiente = true;
            $paquete_vigente = false;
        } else {
            $paquete = array();
            $paquete_pendiente = false;
            $paquete_vigente = false;
        }

        $localizacion = $this->localizacion_model->get_by("usuario_id", $vendedor->cliente->usuario_id);

        if ($localizacion) {
            $full_localizacion = $this->localizacion_model->get_full_localizacion($localizacion->id);
        } else {
            $full_localizacion = false;
        }

        $code_snippet = $this->load->view('home/paginas/compartir_code', array(), true);

        $data = array(
            "mis_productos" => sizeof($mis_productos),
            "mis_anuncios" => sizeof($mis_anuncios),
            "mis_clientes" => sizeof($mis_clientes),
            "paquete_vigente" => $paquete_vigente,
            "paquete_pendiente" => $paquete_pendiente,
            "paquete" => $paquete,
            "info" => $vendedor,
            "full_localizacion" => $full_localizacion,
            "code_snippet" => $code_snippet
        );

        $this->template->load_view('admin/panel_vendedores/resumen', $data);
    }

    /**
     * LOGIN al panel de vendedores
     */
    public function login() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $password = $this->input->post('password');
            $username = $this->input->post('email');
            // LOGOUT por si estaba en el sitio principal
            $this->authentication->logout();

            if ($this->authentication->login($username, $password, false)) {
                $ip_address = $this->session->userdata('ip_address');
                $user_id = $this->authentication->read('identifier');
                $usuario = $this->usuario_model->get($user_id);
                $usuario->ip_address = $ip_address;
                $usuario->ultimo_acceso = date("Y-m-d H:i:s");

                $this->usuario_model->update($user_id, $usuario);
                //$this->session->set_userdata(array('one_time_login' => true));
                redirect('panel_vendedor');
            } else {
                redirect('panel_vendedor/login');
            }
        } else {
            $this->template->set_layout('login_page');
            $this->template->load_view('admin/panel_vendedores/login');
        }
    }

    /**
     * 
     */
    public function logout() {
        $this->authentication->logout();
        redirect('');
    }

    /**
     * 
     */
    public function upload_image() {
        $this->load->config('upload', TRUE);
        $this->load->library('UploadHandler', $this->config->item('producto', 'upload'));
    }

    /**
     *  Esto es un hack para evitar un problema con el menu.
     */
    public function regresar() {
        redirect('');
    }

    public function get_visitas_estadisticas() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $tipo = $this->input->post('tipo');

                $user_id = $this->authentication->read('identifier');
                $vendedor = $this->usuario_model->get_full_identidad($user_id);

                if ($tipo == "mensual") {
                    $visitas = $this->visita_model->generar_estadisticas_visitas(date("Y-m-1"), date("Y-m-t"), $vendedor->get_vendedor_id(), false, false);
                    if ($visitas) {
                        $data = $visitas;
                    } else {
                        $data = "empty";
                    }
                } elseif ($tipo == "anual") {
                    $visitas = $this->visita_model->generar_estadisticas_visitas(date("Y-1-1"), date("Y-12-31"), $vendedor->get_vendedor_id(), false, true);
                    $data = array();
                    if ($visitas) {
                        $data = $visitas;
                    } else {
                        $data = "empty";
                    }
                }
            }
            echo json_encode($data);
        }
    }

    public function get_visitas_estadisticas_afiliados() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            //$this->show_profiler();
            if ($formValues !== false) {
                $tipo = $this->input->post('tipo');

                $user_id = $this->authentication->read('identifier');
                $vendedor = $this->usuario_model->get_full_identidad($user_id);

                if ($tipo == "mensual") {
                    $visitas = $this->visita_model->generar_estadisticas_visitas(date("Y-m-1"), date("Y-m-t"), $vendedor->get_vendedor_id(), true, false);
                    if ($visitas) {
                        $data = $visitas;
                    } else {
                        $data = "empty";
                    }
                } elseif ($tipo == "anual") {
                    $visitas = $this->visita_model->generar_estadisticas_visitas(date("Y-1-1"), date("Y-12-31"), $vendedor->get_vendedor_id(), true, true);
                    $data = array();
                    if ($visitas) {
                        $data = $visitas;
                    } else {
                        $data = "empty";
                    }
                }
            }
            echo json_encode($data);
        }
    }

    public function ajax_get_productos_visitas() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $params["vendedor_id"] = $vendedor->get_vendedor_id();
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $productos_array = $this->producto_model->get_visitas_search($params, $limit, $offset);
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

        $paquete_en_curso = $this->vendedor_model->get_paquete_en_curso($vendedor->get_vendedor_id());
        $ilimitado = false;
        $limite_productos = 0;
        if ($paquete_en_curso) {
            if ($paquete_en_curso->limite_productos == -1) {
                $ilimitado = true;
            } else {
                $limite_productos = $paquete_en_curso->limite_productos;
            }
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
            "productos_total" => $productos_array["total"],
            "ilimitado" => $ilimitado,
            "limite_productos" => $limite_productos);

        $this->template->load_view('admin/panel_vendedores/producto/resumen_tabla_resultados', $data);
    }

    /**
     * 
     */
    public function view_estadisticas() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/estadisticas.js");

        $year = date('Y');
        $mes = date('m');
        $data = array('mes_actual' => $mes, 'year_actual' => $year);

        $this->template->load_view('admin/panel_vendedores/estadisticas/estadisticas', $data);
    }

    /**
     * 
     */
    public function ajax_get_estadisticas() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        if ($formValues !== false) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);

            $params["vendedor_identidad"] = $vendedor;

            if ($this->input->post('mes') != "" && $this->input->post('year') != "") {
                $timestamp1 = mktime(0, 0, 0, $this->input->post('mes'), "1", $this->input->post('year'));
                $date_from = date('Y-m-01', $timestamp1);  // Primer Dia
                $date_to = date('Y-m-t', $timestamp1);    // Ultimo dia
                $params["date_from"] = $date_from;
                $params["date_to"] = $date_to;
            }

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");        
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->cliente_model->get_estadisticas($params, $limit, $offset);
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


        $this->template->load_view('admin/panel_vendedores/estadisticas/tabla_resultados', $data);
    }

    /**
     * 
     * @param type $cliente_id
     */
    public function view_estadisticas_cliente($cliente_id) {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/estadisticas_cliente.js");
        $cliente = $this->cliente_model->get($cliente_id);
        if ($cliente) {

            $data = array(
                "cliente_id" => $cliente_id,
                "cliente"=>$cliente
            );

            $this->template->load_view('admin/panel_vendedores/estadisticas/estadisticas_cliente', $data);
        } else {
            redirect('panel_vendedor');
        }
    }

    /**
     * 
     */
    public function ajax_get_estadisticas_cliente() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        if ($formValues !== false) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);

            $params["vendedor_identidad"] = $vendedor;
            
            if($this->input->post('cliente_id')){
                $params["cliente_id"]=$this->input->post('cliente_id');
            }            

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");        
        $offset = $limit * ($pagina - 1);
        $producto_array = $this->cliente_model->get_estadisticas_por_productos($params, $limit, $offset);
        $flt = (float) ($producto_array["total"] / $limit);
        $ent = (int) ($producto_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($producto_array["total"] == 0) {
            $producto_array["productos"] = array();
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $producto_array["total"],
            "hasta" => ($pagina * $limit < $producto_array["total"]) ? $pagina * $limit : $producto_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "productos" => $producto_array["productos"],
            "pagination" => $pagination);


        $this->template->load_view('admin/panel_vendedores/estadisticas/tabla_resultados_cliente', $data);
    }

}
