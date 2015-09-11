<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mensaje extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     * 
     */
    public function view_redactar_mensaje() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->load->helper('ckeditor');

        $data['ckeditor'] = array(
            'id' => 'mensaje',
            'path' => 'assets/js/ckeditor',
            'config' => array(
                'toolbar' => "Full",
                'height' => '300px',
            ),
        );
        $this->session->unset_userdata('enviar_mensaje_ignore_list');
        $this->session->unset_userdata('enviar_mensaje');
        $this->template->load_view('admin/mensaje/nuevo_mensaje', $data);
    }

    /**
     * 
     */
    public function guardar_mensaje() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $titulo = $this->input->post("titulo");
            $mensaje = $this->input->post("mensaje");

            if ($titulo != "" && $mensaje != "") {
                $data = array("titulo" => $titulo, "mensaje" => $mensaje);
                $this->session->set_userdata(array('enviar_mensaje' => $data));
                redirect('admin/mensajes/listado');
            } else {
                redirect('admin/mensajes');
            }
        }
    }

    public function enviar_mensaje() {
        if ($this->input->is_ajax_request()) {
            $this->ajax_header();
            $formValues = $this->input->post();

            $mensaje = $this->session->userdata('enviar_mensaje');

            if ($formValues !== false && $mensaje) {
                $temp_mails = array();
                $ignore_list = array();

                if ($this->input->post("enviar_todos") != "") {
                    $params = array();
                    $ignore_list = $this->session->userdata('enviar_mensaje_ignore_list');
                    if ($ignore_list) {
                        $params["ignore_usuario_id"] = $ignore_list;
                    }

                    $params["excluir_admins"] = "1";
                    $params["usuario_activo"] = "1";

                    $result_array = $this->cliente_model->get_mensajes_search($params, -1, -1);
                    if ($result_array["total"] > 0) {
                        $usuarios = array();
                        foreach ($result_array["usuarios"] as $result) {
                            $usuarios[] = $result->usuario_id;
                            $temp_mails[] = $result->email;
                            $ignore_list[] = $result->usuario_id;
                        }
                    }
                } else {
                    $usuario_ids = $this->input->post("usuario_ids");
                    $usuarios = explode(";;", $usuario_ids);

                    foreach ($usuarios as $usuario) {
                        $email = $this->usuario_model->get_email($usuario);
                        $temp_mails[] = $email;
                        $ignore_list[] = $usuario;
                    }
                }
                
                if ($this->config->item('emails_enabled')) {
                    $this->load->library('email');
                }
                foreach ($temp_mails as $email) {
                    if ($this->config->item('emails_enabled')) {
                        $this->email->clear(TRUE);
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($email);
                        $this->email->subject($mensaje["titulo"]);
                        $data_mail = array("mensaje" => $mensaje["mensaje"]);
                        $this->email->message($this->load->view('home/emails/mensaje_admin', $data_mail, true));
                        $this->email->send();
                    }
                }

                $old_ignore_list = $this->session->userdata('enviar_mensaje_ignore_list');
                if ($old_ignore_list) {
                    $ignore_list = array_unique(array_merge($ignore_list, $old_ignore_list));
                }
                $this->session->set_userdata(array('enviar_mensaje_ignore_list' => $ignore_list));
            }
            echo json_encode(array("success" => true));
        }
    }

    /**
     * 
     */
    public function view_listado() {
        $mensaje = $this->session->userdata('enviar_mensaje');
        if ($mensaje) {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->add_js("modules/admin/mensaje_listado.js");
            $this->template->load_view('admin/mensaje/listado');
        } else {
            redirect("admin/mensajes");
        }
    }

    /**
     * 
     */
    public function ajax_get_listado_resultados() {
        if ($this->input->is_ajax_request()) {
            $this->ajax_header();
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
                if ($this->input->post('tipo_usuario') != "0") {
                    $params["tipo_usuario"] = $this->input->post('tipo_usuario');
                }
                if ($this->input->post('ultimo_acceso') != "0") {
                    $params["ultimo_acceso"] = $this->input->post('ultimo_acceso');
                }
                $ignore_list = $this->session->userdata('enviar_mensaje_ignore_list');
                if ($ignore_list) {
                    $params["ignore_usuario_id"] = $ignore_list;
                }

                $params["excluir_admins"] = "1";
                $params["usuario_activo"] = "1";
                $pagina = $this->input->post('pagina');
            } else {
                $pagina = 1;
            }

            $limit = $this->config->item("admin_default_per_page");
            $offset = $limit * ($pagina - 1);
            $result_array = $this->cliente_model->get_mensajes_search($params, $limit, $offset);
            $flt = (float) ($result_array["total"] / $limit);
            $ent = (int) ($result_array["total"] / $limit);
            if ($flt > $ent || $flt < $ent) {
                $paginas = $ent + 1;
            } else {
                $paginas = $ent;
            }

            if ($result_array["total"] == 0) {
                $result_array["usuarios"] = array();
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
                "usuarios" => $result_array["usuarios"],
                "pagination" => $pagination);

            $this->template->load_view('admin/mensaje/tabla_resultados', $data);
        }
    }

}
