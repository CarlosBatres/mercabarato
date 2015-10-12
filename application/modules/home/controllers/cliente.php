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

                if ($keywords_text != null) {
                    $keyword_id = $this->keyword_model->insert(array("keywords" => $keywords_text));
                } else {
                    $keyword_id = null;
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
                    "keyword" => $keyword_id
                );

                $this->cliente_model->insert($data);

                //$pais = $this->input->post('pais');
                $pais = "70";
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
                    $this->email->initialize($this->config->item('email_info'));
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

                    if ($keywords_text != null) {
                        $keyword_id = $this->keyword_model->insert(array("keywords" => $keywords_text));
                    } else {
                        $keyword_id = null;
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
                        "keyword" => $keyword_id
                    );

                    $this->cliente_model->update($cliente->id, $data);

                    //$pais = $this->input->post('pais');
                    $pais = "70";
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
                        $this->email->initialize($this->config->item('email_info'));
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

            //if (!$cliente_es_vendedor) {
            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            $this->template->add_js('modules/home/invitaciones.js');
            $this->template->load_view('home/cliente/invitaciones', array("html_options" => $html_options));
            //} else {
            //    redirect('usuario/perfil');
            //}
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

                if ($this->config->item('emails_enabled')) {
                    $invitacion = $this->invitacion_model->get($invitacion_id);
                    if ($invitacion->invitar_desde != $user_id) {
                        $usr = $this->usuario_model->get($invitacion->invitar_desde);
                        $email = $usr->email;
                    } else {
                        $usr = $this->usuario_model->get($invitacion->invitar_para);
                        $email = $usr->email;
                    }

                    $clt = $this->cliente_model->get_by(array("usuario_id" => $user_id));
                    $nombre = $clt->nombres . ' ' . $clt->apellidos;
                    // TODO: Aqui en vez del nombre podria ser el apodo o nickname en un futuro.
                    $data_mail = array("identidad" => $nombre);

                    $this->load->library('email');
                    $this->email->initialize($this->config->item('email_info'));
                    $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                    $this->email->to($email);
                    $this->email->subject('Invitacion Aceptada');
                    $this->email->message($this->load->view('home/emails/aceptar_invitacion_cliente', $data_mail, true));
                    $this->email->send();
                }
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
                $this->invitacion_model->rechazar_invitacion($invitacion_id, $user_id);
                echo json_encode(array("success" => true));
            }
        } else {
            redirect('');
        }
    }

    public function sin_notificaciones() {
        if ($this->authentication->is_loggedin()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $invitacion_id = $this->input->post('invitacion_id');
                $user_id = $this->authentication->read('identifier');
                $this->invitacion_model->update($invitacion_id, array("recibir_notificaciones" => "0"));
                echo json_encode(array("success" => true));
            }
        } else {
            redirect('');
        }
    }

    public function con_notificaciones() {
        if ($this->authentication->is_loggedin()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $invitacion_id = $this->input->post('invitacion_id');
                $user_id = $this->authentication->read('identifier');
                $this->invitacion_model->update($invitacion_id, array("recibir_notificaciones" => "1"));
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
                    $identidad = $this->usuario_model->get_full_identidad($user_id);
                    $usuario = $this->usuario_model->get($cliente->usuario_id);

                    if ($identidad->cliente->nombres != "") {
                        $identificador = $identidad->cliente->nombres . ' ' . $identidad->cliente->apellidos;
                    } else {
                        $identificador = $identidad->usuario->email;
                    }

                    $this->load->library('email');
                    $this->email->initialize($this->config->item('email_info'));
                    $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                    $this->email->to($usuario->email);
                    $this->email->subject('Invitacion de Mercabarato.com');
                    $data_email = array(
                    "titulo" => $data["titulo"],
                    "comentario" => $data["comentario"],
                    "identidad" => $identificador,
                    "link" => site_url("auth").'?email='.$usuario->email.'&continue='.site_url("panel_vendedor/invitaciones/recibidas"));
                    $this->email->message($this->load->view('home/emails/invitacion_email_a_vendedor', $data_email, true));
                    $this->email->send();
                }

                $this->invitacion_model->insert($data);
                redirect($vendedor->unique_slug);
            }
        } else {
            redirect('');
        }
    }

    /**
     * Infocompras Seguros
     */
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
            $resultado = $this->infocompra_model->get_solicitudes_seguro_cliente($params, $limit, $offset);
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
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            $solicitud_seguro = $this->infocompra_model->get($solicitud_seguro_id);
            $mensaje = $this->mensaje_model->get_ultimo_mensaje($solicitud_seguro_id, true);
            if ($solicitud_seguro) {
                if ($solicitud_seguro->estado != "0" && $cliente->id == $solicitud_seguro->cliente_id) {
                    //$this->template->add_js('modules/home/infocompras_seguros.js');
                    $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                    $this->template->load_view('home/cliente/infocompras_seguros_respuesta', array("html_options" => $html_options, "seguro" => $solicitud_seguro, "mensaje" => $mensaje));
                } else {
                    redirect('404');
                }
            } else {
                redirect('404');
            }
        } else {
            redirect('');
        }
    }

    public function seguros_download_respuesta() {
        $this->load->helper('download');
        $data = file_get_contents(assets_url('uploads/seguros/') . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5)); // Read the file's contents
        $name = $this->uri->segment(5);
        force_download($name, $data);
    }

    public function infocompra_download_respuesta() {
        $this->load->helper('download');
        $data = file_get_contents(assets_url('uploads/infocompras/') . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5)); // Read the file's contents
        $name = $this->uri->segment(5);
        force_download($name, $data);
    }

    public function view_seguros_pregunta($solicitud_seguro_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            $solicitud_seguro = $this->infocompra_model->get($solicitud_seguro_id);

            if ($solicitud_seguro) {
                if ($solicitud_seguro->estado == "1" && $cliente->id == $solicitud_seguro->cliente_id) {
                    $this->load->helper('ckeditor');

                    $data = array("seguro" => $solicitud_seguro);
                    $data['ckeditor'] = array(
                        'id' => 'pregunta',
                        'path' => 'assets/js/ckeditor',
                        'config' => array(
                            'customConfig' => assets_url('js/ckeditor_config_sm.js'),
                            'height' => '300px',
                        ),
                    );
                    $data["solicitud_seguro_id"] = $solicitud_seguro->id;
                    //$this->template->add_js('modules/home/infocompras_seguros.js');
                    $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                    $data["html_options"] = $html_options;
                    $this->template->load_view('home/cliente/infocompras_seguros_pregunta', $data);
                } else {
                    redirect('404');
                }
            } else {
                redirect('404');
            }
        } else {
            redirect('');
        }
    }

    public function seguro_enviar_pregunta() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $solicitud_seguro_id = $this->input->post("solicitud_seguro_id");
            $solicitud_seguro = $this->infocompra_model->get($solicitud_seguro_id);

            if ($solicitud_seguro) {
                $pregunta = $this->input->post("pregunta");
                if ($pregunta != "") {

                    $data_msg = array(
                        "mensaje" => $pregunta,
                        "infocompra_id" => $solicitud_seguro_id,
                        "enviado_por" => "1",
                        "fecha" => date("Y-m-d")
                    );
                    $this->mensaje_model->insert($data_msg);
                    $this->infocompra_model->update($solicitud_seguro_id, array("estado" => "0"));

                    if ($this->config->item('emails_enabled')) {
                        $vendedor = $this->vendedor_model->get($solicitud_seguro->vendedor_id);
                        $cliente = $this->cliente_model->get($vendedor->cliente_id);
                        $usuario = $this->usuario_model->get($cliente->usuario_id);

                        $this->load->library('email');
                        $this->email->initialize($this->config->item('email_info'));
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Nueva solicitud de presupuesto');
                        //$data_email = array("solicitud_id" => $solicitud_seguro_id);
                        //$link=site_url('panel_vendedor/infocompras/seguros/responder/'.$solicitud_seguro_id);
                        $data_email = array("link" => site_url("auth") . '?email=' . $usuario->email . '&continue=' . site_url('panel_vendedor/infocompras/seguros/responder/' . $solicitud_seguro_id));
                        $this->email->message($this->load->view('home/emails/solicitud_presupuesto_mensaje_vendedor', $data_email, true));
                        $this->email->send();
                    }
                }
            }
        }
        redirect('usuario/infocompras-seguros');
    }

    /**
     * Infocompras General
     */
    public function view_infocompras_general() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            //$invitaciones = $this->invitacion_model->get_invitaciones_pendientes($cliente->id);

            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            $this->template->add_js('modules/home/infocompras_generales.js');
            $this->template->load_view('home/cliente/infocompras_generales', array("html_options" => $html_options));
        } else {
            redirect('');
        }
    }

    public function ajax_get_listado_infocompras() {
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
            $resultado = $this->infocompra_model->get_solicitudes_infocompras_cliente($params, $limit, $offset);
            $flt = (float) ($resultado["total"] / $limit);
            $ent = (int) ($resultado["total"] / $limit);
            if ($flt > $ent || $flt < $ent) {
                $paginas = $ent + 1;
            } else {
                $paginas = $ent;
            }

            if ($resultado["total"] == 0) {
                $resultado["infocompras"] = array();
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
                "infocompras_generales" => $resultado["infocompras"],
                "pagination" => $pagination);

            $this->template->load_view('home/cliente/infocompras_generales_tabla', $data);
        }
    }

    public function view_infocompras_respuesta($solicitud_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            $solicitud = $this->infocompra_model->get($solicitud_id);
            $mensaje = $this->mensaje_model->get_ultimo_mensaje($solicitud_id, true);
            if ($solicitud) {
                if ($solicitud->estado != "0" && $cliente->id == $solicitud->cliente_id) {
                    //$this->template->add_js('modules/home/infocompras_seguros.js');
                    $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                    $this->template->load_view('home/cliente/infocompras_generales_respuesta', array("html_options" => $html_options, "infocompra" => $solicitud, "mensaje" => $mensaje));
                } else {
                    redirect('404');
                }
            } else {
                redirect('404');
            }
        } else {
            redirect('');
        }
    }

    public function view_infocompras_pregunta($solicitud_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            $solicitud = $this->infocompra_model->get($solicitud_id);

            if ($solicitud) {
                if ($solicitud->estado == "1" && $cliente->id == $solicitud->cliente_id) {
                    $this->load->helper('ckeditor');

                    $data = array("infocompra" => $solicitud);
                    $data['ckeditor'] = array(
                        'id' => 'pregunta',
                        'path' => 'assets/js/ckeditor',
                        'config' => array(
                            'customConfig' => assets_url('js/ckeditor_config_sm.js'),
                            'height' => '300px',
                        ),
                    );
                    $data["solicitud_id"] = $solicitud->id;
                    //$this->template->add_js('modules/home/infocompras_seguros.js');
                    $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                    $data["html_options"] = $html_options;
                    $this->template->load_view('home/cliente/infocompras_generales_pregunta', $data);
                } else {
                    redirect('404');
                }
            } else {
                redirect('404');
            }
        } else {
            redirect('');
        }
    }

    public function infocompra_enviar_pregunta() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $solicitud_id = $this->input->post("solicitud_id");
            $solicitud = $this->infocompra_model->get($solicitud_id);

            if ($solicitud) {
                $pregunta = $this->input->post("pregunta");
                if ($pregunta != "") {

                    $data_msg = array(
                        "mensaje" => $pregunta,
                        "infocompra_id" => $solicitud_id,
                        "enviado_por" => "1",
                        "fecha" => date("Y-m-d")
                    );
                    $this->mensaje_model->insert($data_msg);
                    $this->infocompra_model->update($solicitud_id, array("estado" => "0"));

                    if ($this->config->item('emails_enabled')) {
                        $vendedor = $this->vendedor_model->get($solicitud->vendedor_id);
                        $cliente = $this->cliente_model->get($vendedor->cliente_id);
                        $usuario = $this->usuario_model->get($cliente->usuario_id);

                        $this->load->library('email');
                        $this->email->initialize($this->config->item('email_info'));
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Nueva solicitud de presupuesto');
                        //$data_email = array("solicitud_id" => $solicitud_id);
                        //$link=site_url('panel_vendedor/infocompras/seguros/responder/'.$solicitud_id);
                        $data_email = array("link" => site_url("auth") . '?email=' . $usuario->email . '&continue=' . site_url('panel_vendedor/infocompras/generales/responder/' . $solicitud_id));
                        $this->email->message($this->load->view('home/emails/solicitud_presupuesto_mensaje_vendedor', $data_email, true));
                        $this->email->send();
                    }
                }
            }
        }
        redirect('usuario/infocompras-general');
    }

    public function extender_infocompra($solicitud_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            $solicitud = $this->infocompra_model->get($solicitud_id);
            if ($solicitud) {
                if ($solicitud->extendido == "0" && $cliente->id == $solicitud->cliente_id) {
                    $this->infocompra_model->update($solicitud_id, array("fecha_solicitud" => date("Y-m-d"), "extendido" => "1"));
                    $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                    $this->template->load_view('home/cliente/infocompras_extendido', array("html_options" => $html_options, "infocompra" => $solicitud));
                } else {
                    redirect('404');
                }
            } else {
                redirect('404');
            }
        } else {
            redirect('');
        }
    }

}
