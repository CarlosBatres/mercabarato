<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_invitaciones extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
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
        $this->template->add_js("modules/admin/panel_vendedores/invitaciones_pendientes_listado.js");

        $this->template->load_view('admin/panel_vendedores/invitados/pendientes');
    }

    /**
     * 
     */
    public function recibidas() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/invitaciones_recibidas_listado.js");
        $this->template->load_view('admin/panel_vendedores/invitados/recibidas');
    }

    public function get_mensaje_invitacion($invitacion_id) {
        $invitacion = $this->invitacion_model->get($invitacion_id);
        if ($invitacion) {
            echo "<p><strong>" . $invitacion->titulo . "</strong></p>";
            echo "<br>";
            echo "<p>" . $invitacion->comentario . "</p>";
            echo "<hr>";
        }
    }

    public function aceptadas() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/invitaciones_aceptadas_listado.js");

        $this->template->load_view('admin/panel_vendedores/invitados/aceptadas');
    }

    /**
     * 
     * @param type $id
     */
    public function enviar_invitacion($id) {
        $cliente = $this->cliente_model->get($id);

        $exists = $this->invitacion_model->invitacion_existe($this->identidad->usuario->id, $cliente->usuario_id);

        if ($cliente && !$exists) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $accion = $this->input->post('accion');
                if ($accion == "send-invitacion") {
                    $data = array(
                        "titulo" => ($this->input->post('titulo') != '') ? $this->input->post('titulo') : null,
                        "comentario" => ($this->input->post('comentario') != '') ? $this->input->post('comentario') : null,
                        "invitar_desde" => $this->identidad->usuario->id,
                        "invitar_para" => $cliente->usuario_id,
                        "estado" => "1"
                    );
                    // estado=1 - Pendiente  

                    if ($this->config->item('emails_enabled')) {
                        $usuario=$this->usuario_model->get($cliente->usuario_id);
                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Invitacion de Mercabarato.com');
                        $data_email = array("titulo" => $data["titulo"], "comentario" => $data["comentario"] ,"sin_registro"=>true);
                        $this->email->message($this->load->view('home/emails/invitacion_email', $data_email, true));
                        $this->email->send();
                    }                    

                    $this->invitacion_model->insert($data);
                    $this->session->set_flashdata('success', 'Invitacion Enviada');
                    redirect('panel_vendedor/invitaciones/buscar');
                } else {
                    redirect('panel_vendedor/invitaciones/buscar');
                }
            } else {
                $this->template->set_title("Panel de Administracion - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $this->load->helper('ckeditor');

                $data = array("cliente" => $cliente);
                $data['ckeditor'] = array(
                    //ID of the textarea that will be replaced
                    'id' => 'content',
                    'path' => 'assets/js/ckeditor',
                    //Optionnal values
                    'config' => array(
                        'toolbar' => "Full", //Using the Full toolbar                        
                        'height' => '200px', //Setting a custom height
                    ),
                );


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
                $titulo = $this->input->post('titulo');
                $comentario = $this->input->post('comentario');

                /**
                 * Creo un cliente temporal para que se pueda registrar despues
                 */
                $user_id = $this->authentication->create_user($email, "passwordtemporal");
                if ($user_id !== FALSE) {
                    $secret_key = substr(md5(uniqid(mt_rand(), true)), 0, 30);
                    $ip_address = $this->session->userdata('ip_address');
                    $usuario = $this->usuario_model->get($user_id);
                    $usuario->ip_address = $ip_address;
                    $usuario->fecha_creado = date("Y-m-d H:i:s");
                    $usuario->ultimo_acceso = date("Y-m-d H:i:s");
                    $usuario->activo = 0;
                    //$usuario->is_admin = 0;
                    $usuario->temporal = 1;
                    $usuario->secret_key = $secret_key;
                    $this->usuario_model->update($user_id, $usuario);
                }

                $data = array(
                    "usuario_id" => $user_id,
                    "nombres" => null,
                    "apellidos" => null,
                    "sexo" => null,
                    "fecha_nacimiento" => null,
                    "codigo_postal" => null,
                    "direccion" => null,
                    "telefono_fijo" => null,
                    "telefono_movil" => null,
                    "keyword" => null
                );

                $this->cliente_model->insert($data);

                $data_inv = array(
                    "titulo" => $titulo,
                    "comentario" => $comentario,
                    "invitar_desde" => $this->identidad->usuario->id,
                    "invitar_para" => $user_id,
                    "estado" => "2"
                );


                $this->invitacion_model->insert($data_inv);

                if ($this->config->item('emails_enabled')) {
                    $this->load->library('email');
                    $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                    $this->email->to($email);
                    $this->email->subject('Invitacion de Mercabarato.com');
                    $data_email = array("titulo" => $titulo, "comentario" => $comentario);
                    $this->email->message($this->load->view('home/emails/invitacion_email', $data_email, true));
                    $this->email->send();
                }

                $this->session->set_flashdata('success', 'Invitacion Enviada');
                redirect('panel_vendedor/invitaciones/buscar');
            } else {
                redirect('panel_vendedor/invitaciones/buscar');
            }
        } else {
            $this->template->set_title("Panel de Administracion - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->add_js("modules/admin/panel_vendedores/enviar_invitacion_email.js");
            $this->load->helper('ckeditor');

            $data = array();
            $data['ckeditor'] = array(
                //ID of the textarea that will be replaced
                'id' => 'content',
                'path' => 'assets/js/ckeditor',
                //Optionnal values
                'config' => array(
                    'toolbar' => "Full", //Using the Full toolbar                        
                    'height' => '200px', //Setting a custom height
                ),
            );

            $this->template->load_view('admin/panel_vendedores/invitados/enviar_invitacion_email', $data);
        }
    }

    /**
     * 
     */
    public function ajax_get_listado_clientes() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $invitar_desde = $this->invitacion_model->get_many_by("invitar_desde", $this->identidad->usuario->id);
        $invitar_para = $this->invitacion_model->get_many_by("invitar_para", $this->identidad->usuario->id);

        $ids_array = array();
        $ids_array[] = $this->identidad->usuario->id;
        if ($invitar_desde) {
            foreach ($invitar_desde as $val) {
                $ids_array[] = $val->invitar_para;
            }
        }
        if ($invitar_para) {
            foreach ($invitar_para as $val) {
                $ids_array[] = $val->invitar_desde;
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
                $params["excluir_usuarios_ids"] = $ids_array;
            }

            $params["usuario_activo"] = "1"; // Solo usuarios activos                        
            $params["excluir_admins"] = true;
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->cliente_model->get_clientes_invitados($params, $limit, $offset, "v.nombre", "asc");
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

    /**
     * 
     * @param type $id
     */
    public function aceptar_invitacion($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $this->invitacion_model->aceptar_invitacion($id, $user_id);
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

    /**
     * 
     */
    public function ajax_invitaciones_pendientes() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            if ($this->input->post('sexo') != 'X' && $this->input->post('sexo')) {
                $params["sexo"] = $this->input->post('sexo');
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            if ($this->input->post('keywords') != "") {
                $keywords = explode(",", $this->input->post('keywords'));
                $params["keywords"] = $keywords;
            }
            $params["invitar_desde"] = $this->identidad->usuario->id;
            $params['usuario_activo'] = "1";
            $params["excluir_admins"] = true;
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->invitacion_model->get_invitaciones_pendientes($params, $limit, $offset);
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


        $this->template->load_view('admin/panel_vendedores/invitados/tabla_resultados_pendiente', $data);
    }

    /**
     * 
     */
    public function ajax_invitaciones_recibidas() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            if ($this->input->post('sexo') != 'X' && $this->input->post('sexo')) {
                $params["sexo"] = $this->input->post('sexo');
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            if ($this->input->post('keywords') != "") {
                $keywords = explode(",", $this->input->post('keywords'));
                $params["keywords"] = $keywords;
            }
            $params["invitar_para"] = $this->identidad->usuario->id;

            $params['usuario_activo'] = "1";
            $params["excluir_admins"] = true;
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->invitacion_model->get_invitaciones_recibidas($params, $limit, $offset);
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


        $this->template->load_view('admin/panel_vendedores/invitados/tabla_resultados_recibidas', $data);
    }

    /**
     * 
     */
    public function ajax_invitaciones_aceptadas() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            if ($this->input->post('sexo') != 'X' && $this->input->post('sexo')) {
                $var = $this->input->post('sexo');
                $params["sexo"] = $this->input->post('sexo');
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            if ($this->input->post('keywords') != "") {
                $keywords = explode(",", $this->input->post('keywords'));
                $params["keywords"] = $keywords;
            }
            $params['usuario_activo'] = "1";
            $params["usuario_id"] = $this->identidad->usuario->id;
            $params["excluir_admins"] = true;
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->invitacion_model->get_invitaciones_aceptadas($params, $limit, $offset);
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


        $this->template->load_view('admin/panel_vendedores/invitados/tabla_resultados_aceptadas', $data);
    }

}
