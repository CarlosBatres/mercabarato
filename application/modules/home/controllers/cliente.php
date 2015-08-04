<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Crear un nuevo cliente     
     * POST
     */
    public function crear() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $password = $this->input->post('password');
            $username = $this->input->post('email');

            $user_id = $this->authentication->create_user($username, $password);

            if ($user_id !== FALSE) {
                $secret_key = substr(md5(uniqid(mt_rand(), true)), 0, 30);

                $ip_address = $this->session->userdata('ip_address');
                $usuario = $this->usuario_model->get($user_id);
                $usuario->ip_address = $ip_address;
                $usuario->fecha_creado = date("Y-m-d H:i:s");
                $usuario->ultimo_acceso = date("Y-m-d H:i:s");
                $usuario->activo = 0;
                //$usuario->is_admin = 0;
                $usuario->temporal = 0;
                $usuario->secret_key = $secret_key;
//                $usuario->nickname = ($this->input->post('nickname') != '') ? $this->input->post('nickname') : null;

                $this->usuario_model->update($user_id, $usuario);

                $keywords = $this->input->post('keywords');
                if ($keywords) {
                    $keywords_text = '';
                    foreach ($keywords as $key) {
                        $keywords_text.=$key . ';';
                    }
                    $keywords_text = substr($keywords_text, 0, -1);
                } else {
                    $keywords_text = null;
                }

                $data = array(
                    "usuario_id" => $user_id,
                    "nombres" => ($this->input->post('nombres') != '') ? $this->input->post('nombres') : null,
                    "apellidos" => ($this->input->post('apellidos') != '') ? $this->input->post('apellidos') : '',
                    "sexo" => ($this->input->post('sexo') != 'X') ? $this->input->post('sexo') : null,
                    "fecha_nacimiento" => ($this->input->post('fecha_nacimiento') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_nacimiento'))) : null,
                    "codigo_postal" => ($this->input->post('codigo_postal') != '') ? $this->input->post('codigo_postal') : null,
                    "direccion" => ($this->input->post('direccion') != '') ? $this->input->post('direccion') : null,
                    "telefono_fijo" => ($this->input->post('telefono_fijo') != '') ? $this->input->post('telefono_fijo') : null,
                    "telefono_movil" => ($this->input->post('telefono_movil') != '') ? $this->input->post('telefono_movil') : null,
                    "keyword" => $keywords_text
                );

                $this->cliente_model->insert($data);

                $pais = $this->input->post('pais');
                $provincia = $this->input->post('provincia');
                $poblacion = $this->input->post('poblacion');

                if ($pais != "0") {
                    $data_localizacion = array(
                        "usuario_id" => $user_id,
                        "pais_id" => $pais,
                        "provincia_id" => ($provincia == "0") ? null : $provincia,
                        "poblacion_id" => ($poblacion == "0") ? null : $poblacion
                    );
                    $this->localizacion_model->insert($data_localizacion);
                }

                //$this->authentication->login($username, $password);
                if ($this->config->item('emails_enabled')) {
                    $this->load->library('email');
                    $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                    $this->email->to($username);

                    $this->email->subject('Active su cuenta');
                    $data_email = array("link" => site_url('confirmar_registro') . '/' . $secret_key);
                    $this->email->message($this->load->view('home/emails/confirmar_registro', $data_email, true));
                    $this->email->send();
                }
                redirect('registro_exitoso');
            } else {
                $usuario = $this->usuario_model->get_by(array("email" => $username));
                if ($usuario) {
                    $cliente = $this->cliente_model->get_by(array("usuario_id" => $usuario->id));
                    $this->usuario_model->update($usuario->id, array("temporal" => "0"));
                    $this->authentication->change_password($password, $usuario->id);

                    $keywords = $this->input->post('keywords');
                    if ($keywords) {
                        $keywords_text = '';
                        foreach ($keywords as $key) {
                            $keywords_text.=$key . ';';
                        }
                        $keywords_text = substr($keywords_text, 0, -1);
                    } else {
                        $keywords_text = null;
                    }

                    $data = array(
                        "usuario_id" => $usuario->id,
                        "nombres" => ($this->input->post('nombres') != '') ? $this->input->post('nombres') : null,
                        "apellidos" => ($this->input->post('apellidos') != '') ? $this->input->post('apellidos') : '',
                        "sexo" => ($this->input->post('sexo') != 'X') ? $this->input->post('sexo') : null,
                        "fecha_nacimiento" => ($this->input->post('fecha_nacimiento') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_nacimiento'))) : null,
                        "codigo_postal" => ($this->input->post('codigo_postal') != '') ? $this->input->post('codigo_postal') : null,
                        "direccion" => ($this->input->post('direccion') != '') ? $this->input->post('direccion') : null,
                        "telefono_fijo" => ($this->input->post('telefono_fijo') != '') ? $this->input->post('telefono_fijo') : null,
                        "telefono_movil" => ($this->input->post('telefono_movil') != '') ? $this->input->post('telefono_movil') : null,
                        "keyword" => $keywords_text
                    );

                    $this->cliente_model->update($cliente->id, $data);

                    $pais = $this->input->post('pais');
                    $provincia = $this->input->post('provincia');
                    $poblacion = $this->input->post('poblacion');

                    if ($pais != "0") {
                        $data_localizacion = array(
                            "usuario_id" => $usuario->id,
                            "pais_id" => $pais,
                            "provincia_id" => ($provincia == "0") ? null : $provincia,
                            "poblacion_id" => ($poblacion == "0") ? null : $poblacion
                        );
                        $this->localizacion_model->insert($data_localizacion);
                    }

                    //$this->authentication->login($username, $password);
                    if ($this->config->item('emails_enabled')) {
                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($username);

                        $this->email->subject('Active su cuenta');
                        $data_email = array("link" => site_url('confirmar_registro') . '/' . $usuario->secret_key);
                        $this->email->message($this->load->view('home/emails/confirmar_registro', $data_email, true));
                        $this->email->send();
                    }
                    redirect('registro_exitoso');
                } else {
                    redirect('');
                }
            }
        } else {
            redirect('');
        }
    }

    public function view_invitaciones() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            if (!$cliente_es_vendedor) {
                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                $this->template->add_js('modules/home/invitaciones.js');
                $this->template->load_view('home/cliente/invitaciones', array("html_options" => $html_options));
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    public function aceptar_invitacion() {
        if ($this->authentication->is_loggedin()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $invitacion_id = $this->input->post('invitacion_id');
                $user_id = $this->authentication->read('identifier');
                $this->invitacion_model->aceptar_invitacion($invitacion_id, $user_id);
                echo json_encode(array("success" => true));
            }
        } else {
            redirect('');
        }
    }

    public function rechazar_invitacion() {
        if ($this->authentication->is_loggedin()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $invitacion_id = $this->input->post('invitacion_id');
                $user_id = $this->authentication->read('identifier');
                $this->invitacion_model->rechazar_invitacion($invitacion_id, $user_id);
                echo json_encode(array("success" => true));
            }
        } else {
            redirect('');
        }
    }

    public function eliminar_invitacion() {
        if ($this->authentication->is_loggedin()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $invitacion_id = $this->input->post('invitacion_id');
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
                $this->invitacion_model->rechazar_invitacion($invitacion_id, $cliente->id);
                echo json_encode(array("success" => true));
            }
        } else {
            redirect('');
        }
    }

    public function ajax_get_listado_resultados_invitaciones() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $user_id = $this->authentication->read('identifier');

        $params = array();
        if ($formValues !== false) {
            $pagina = $this->input->post('pagina');

            $params["pagina"] = $pagina;
            $params["usuario_id"] = $user_id;

            $limit = 5;
            $offset = $limit * ($pagina - 1);
            $invitaciones = $this->invitacion_model->find_mis_invitaciones($params, $limit, $offset);
            $flt = (float) ($invitaciones["total"] / $limit);
            $ent = (int) ($invitaciones["total"] / $limit);
            if ($flt > $ent || $flt < $ent) {
                $paginas = $ent + 1;
            } else {
                $paginas = $ent;
            }

            if ($invitaciones["total"] == 0) {
                $invitaciones["invitaciones"] = array();
            }

            $search_params = array(
                "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina" => $limit,
                "total" => $invitaciones["total"],
                "hasta" => ($pagina * $limit < $invitaciones["total"]) ? $pagina * $limit : $invitaciones["total"],
                "desde" => (($pagina * $limit) - $limit) + 1);

            $pagination = build_paginacion($search_params);
            $data = array(
                "invitaciones" => $invitaciones["invitaciones"],
                "pagination" => $pagination);

            $this->template->load_view('home/cliente/tabla_invitaciones', $data);
        }
    }

    public function enviar_invitacion() {
        if ($this->authentication->is_loggedin()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $vendedor_id = $this->input->post('vendedor_id');
                $vendedor = $this->vendedor_model->get($vendedor_id);
                $cliente = $this->cliente_model->get($vendedor->cliente_id);

                $user_id = $this->authentication->read('identifier');

                $data = array(
                    "invitar_desde" => $user_id,
                    "invitar_para" => $cliente->usuario_id,
                    "titulo" => ($this->input->post('titulo') != '') ? $this->input->post('titulo') : null,
                    "comentario" => ($this->input->post('mensaje') != '') ? $this->input->post('mensaje') : null,
                    "estado" => "1"
                );

                if ($this->config->item('emails_enabled')) {
                    $usuario = $this->usuario_model->get($cliente->usuario_id);
                    $this->load->library('email');
                    $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                    $this->email->to($usuario->email);
                    $this->email->subject('Invitacion de Mercabarato.com');
                    $data_email = array("titulo" => $data["titulo"], "comentario" => $data["comentario"]);
                    $this->email->message($this->load->view('home/emails/invitacion_email_cliente', $data_email, true));
                    $this->email->send();
                }

                $this->invitacion_model->insert($data);
                redirect($vendedor->unique_slug);
            }
        } else {
            redirect('');
        }
    }

    public function view_infocompras_seguros() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            //$invitaciones = $this->invitacion_model->get_invitaciones_pendientes($cliente->id);

            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            $this->template->add_js('modules/home/infocompras_seguros.js');
            $this->template->load_view('home/cliente/infocompras_seguros', array("html_options" => $html_options));
        } else {
            redirect('');
        }
    }

    public function ajax_get_listado_seguros() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $user_id = $this->authentication->read('identifier');
        $cliente = $this->usuario_model->get_full_identidad($user_id);
        $params = array();
        if ($formValues !== false) {
            $pagina = $this->input->post('pagina');

            $params["pagina"] = $pagina;
            $params["cliente_id"] = $cliente->cliente->id;

            $limit = 5;
            $offset = $limit * ($pagina - 1);
            $resultado = $this->solicitud_seguro_model->get_solicitudes_seguro_cliente($params, $limit, $offset);
            $flt = (float) ($resultado["total"] / $limit);
            $ent = (int) ($resultado["total"] / $limit);
            if ($flt > $ent || $flt < $ent) {
                $paginas = $ent + 1;
            } else {
                $paginas = $ent;
            }

            if ($resultado["total"] == 0) {
                $resultado["solicitud_seguros"] = array();
            }

            $search_params = array(
                "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina" => $limit,
                "total" => $resultado["total"],
                "hasta" => ($pagina * $limit < $resultado["total"]) ? $pagina * $limit : $resultado["total"],
                "desde" => (($pagina * $limit) - $limit) + 1);

            $pagination = build_paginacion($search_params);
            $data = array(
                "solicitud_seguros" => $resultado["solicitud_seguros"],
                "pagination" => $pagination);

            $this->template->load_view('home/cliente/infocompras_seguros_tabla', $data);
        }
    }

    public function view_seguros_respuesta($solicitud_seguro_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            $solicitud_seguro = $this->solicitud_seguro_model->get($solicitud_seguro_id);
            // TODO : Validar que yo pueda acceder a esta
            if ($solicitud_seguro) {
                //$this->template->add_js('modules/home/infocompras_seguros.js');
                $this->template->load_view('home/cliente/infocompras_seguros_respuesta', array("seguro" => $solicitud_seguro));
            } else {
                redirect('');
            }
        } else {
            redirect('');
        }
    }

    public function seguros_download_respuesta() {
        $this->load->helper('download');
        $data = file_get_contents(assets_url('uploads/seguros/')  .'/'.$this->uri->segment(4)); // Read the file's contents
        $name = $this->uri->segment(4);
        force_download($name, $data);
    }

}
