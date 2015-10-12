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

    /**
     * 
     * @param type $invitacion_id
     */
    public function get_mensaje_invitacion($invitacion_id) {
        $invitacion = $this->invitacion_model->get($invitacion_id);
        if ($invitacion) {
            $html = '<div class="modal-header">';
            $html.='<h4 class="modal-title">Invitacion Recibida</h4>';
            $html.='</div>';
            $html.='<div class = "modal-body">';
            $html.='<p><strong>' . $invitacion->titulo . '</strong></p>';
            $html.='<br>';
            $html.='<p>' . $invitacion->comentario . '</p>';
            $html.='</div>';
            $html.='<div class="modal-footer">';
            $html.='<input type="hidden" name="invitacion_id" value="' . $invitacion_id . '">';
            $html.='<button class = "btn btn-success" type = "button" id = "yes"><i class = "fa fa-check"></i> Aceptar</button>';
            $html.='<button class = "btn btn-danger" type = "button" id = "no"><i class = "fa fa-close"></i> Rechazar</button>';
            $html.='</div>';
            $html.='</div>';
        }

        echo $html;
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
                        "comentario" => ($this->input->post('contenido') != '') ? $this->input->post('contenido') : null,
                        "invitar_desde" => $this->identidad->usuario->id,
                        "invitar_para" => $cliente->usuario_id,
                        "estado" => "1",
                        "fecha_envio" => date("Y-m-d H:i:s")
                    );
                    // estado=1 - Pendiente  

                    if ($this->config->item('emails_enabled')) {
                        $usuario = $this->usuario_model->get($cliente->usuario_id);
                        $this->load->library('email');
                        $this->email->initialize($this->config->item('email_info'));
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Invitacion de Mercabarato.com');
                        $data_email = array(
                            "titulo" => $data["titulo"], 
                            "comentario" => $data["comentario"],
                            "identidad" => $this->identidad->vendedor->nombre,
                            "link"=>site_url("auth").'?email='.$usuario->email.'&continue='.site_url("usuario/contactos"));
                        $this->email->message($this->load->view('home/emails/invitacion_nueva_email', $data_email, true));
                        $this->email->send();
                    }

                    $this->invitacion_model->insert($data);
                    $this->session->set_flashdata('success', 'Invitacion Enviada');
                    redirect('panel_vendedor/invitaciones/buscar');
                } else {
                    redirect('panel_vendedor/invitaciones/buscar');
                }
            } else {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $this->template->add_js("modules/admin/panel_vendedores/form_validation.js");
                $this->load->helper('ckeditor');

                $data = array("cliente" => $cliente);
                $data['ckeditor'] = array(
                    'id' => 'content',
                    'path' => 'assets/js/ckeditor',
                    'config' => array(
                        'customConfig' => assets_url('js/ckeditor_config_sm.js'),
                        'height' => '400px',
                    ),
                );
                $this->template->load_view('admin/panel_vendedores/invitados/enviar_invitacion', $data);
            }
        } else {
            redirect('panel_vendedor/invitaciones/buscar');
        }
    }

    /**
     * 
     */
    public function enviar_invitacion_email() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion == "send-invitacion") {
                $email = $this->input->post('email');
                $titulo = $this->input->post('titulo');
                $comentario = $this->input->post('contenido');

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
                        "estado" => "1",
                        "fecha_envio" => date("Y-m-d H:i:s")
                    );


                    $this->invitacion_model->insert($data_inv);

                    if ($this->config->item('emails_enabled')) {
                        $this->load->library('email');
                        $this->email->initialize($this->config->item('email_info'));
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($email);
                        $this->email->subject('Invitacion de Mercabarato.com');
                        $data_email = array(
                            "titulo" => $titulo,
                            "comentario" => $comentario,
                            "identidad" => $this->identidad->vendedor->nombre,
                            "link" => site_url('usuario/identificar/' . $secret_key)
                        );

                        $this->email->message($this->load->view('home/emails/invitacion_email', $data_email, true));
                        $this->email->send();
                    }

                    $this->session->set_flashdata('success', 'Invitacion Enviada');
                } else {
                    $usuario = $this->usuario_model->get_by("email", $email);
                    if ($usuario) {
                        if ($this->invitacion_model->invitacion_existe($usuario->id, $this->identidad->usuario->id)) {
                            $invitacion = $this->invitacion_model->get_invitacion($usuario->id, $this->identidad->usuario->id);
                            if ($invitacion->fecha_envio != null) {
                                $now = new DateTime;
                                $ago = new DateTime($invitacion->fecha_envio);
                                $diff = $now->diff($ago);

                                $diff->w = floor($diff->d / 7);
                                $diff->d -= $diff->w * 7;

                                if ($diff->d > 0) {
                                    $dat = array(
                                        "titulo" => $titulo,
                                        "comentario" => $comentario,
                                        "fecha_envio" => date("Y-m-d H:i:s")
                                    );
                                    $this->invitacion_model->update($invitacion->id, $dat);

                                    if ($this->config->item('emails_enabled')) {
                                        $this->load->library('email');
                                        $this->email->initialize($this->config->item('email_info'));
                                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                                        $this->email->to($email);
                                        $this->email->subject('Invitacion de Mercabarato.com');

                                        if ($usuario->activo == "1") {
                                            $link = false;
                                        } else {
                                            if ($usuario->secret_key != '') {
                                                $link = site_url('usuario/identificar/' . $usuario->secret_key);
                                            } else {
                                                $link = false;
                                            }
                                        }

                                        $data_email = array(
                                            "titulo" => $titulo,
                                            "comentario" => $comentario,
                                            "identidad" => $this->identidad->vendedor->nombre,
                                            "link" => $link
                                        );

                                        $this->email->message($this->load->view('home/emails/invitacion_email', $data_email, true));
                                        $this->email->send();
                                    }
                                    $this->session->set_flashdata('success', 'Invitacion Enviada');
                                } else {
                                    $this->session->set_flashdata('error', 'Ya le has enviado una invitacion a este email. Espera al menos un dia para volver a hacerlo');
                                }
                            } else {
                                $dat = array(
                                    "titulo" => $titulo,
                                    "comentario" => $comentario,
                                    "fecha_envio" => date("Y-m-d H:i:s")
                                );
                                $this->invitacion_model->update($invitacion->id, $dat);

                                if ($this->config->item('emails_enabled')) {
                                    $this->load->library('email');
                                    $this->email->initialize($this->config->item('email_info'));
                                    $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                                    $this->email->to($email);
                                    $this->email->subject('Invitacion de Mercabarato.com');

                                    if ($usuario->activo == "1") {
                                        $link = false;
                                    } else {
                                        if ($usuario->secret_key != '') {
                                            $link = site_url('usuario/identificar/' . $usuario->secret_key);
                                        } else {
                                            $link = false;
                                        }
                                    }

                                    $data_email = array(
                                        "titulo" => $titulo,
                                        "comentario" => $comentario,
                                        "identidad" => $this->identidad->vendedor->nombre,
                                        "link" => $link
                                    );

                                    $this->email->message($this->load->view('home/emails/invitacion_email', $data_email, true));
                                    $this->email->send();
                                }
                                $this->session->set_flashdata('success', 'Invitacion Enviada');
                            }
                        } else {
                            $data_inv = array(
                                "titulo" => $titulo,
                                "comentario" => $comentario,
                                "invitar_desde" => $this->identidad->usuario->id,
                                "invitar_para" => $usuario->id,
                                "estado" => "1",
                                "fecha_envio" => date("Y-m-d H:i:s")
                            );

                            $this->invitacion_model->insert($data_inv);

                            if ($this->config->item('emails_enabled')) {
                                $this->load->library('email');
                                $this->email->initialize($this->config->item('email_info'));
                                $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                                $this->email->to($email);
                                $this->email->subject('Invitacion de Mercabarato.com');

                                if ($usuario->activo == "1") {
                                    $link = false;
                                } else {
                                    if ($usuario->secret_key != '') {
                                        $link = site_url('usuario/identificar/' . $usuario->secret_key);
                                    } else {
                                        $link = false;
                                    }
                                }

                                $data_email = array(
                                    "titulo" => $titulo,
                                    "comentario" => $comentario,
                                    "identidad" => $this->identidad->vendedor->nombre,
                                    "link" => $link
                                );

                                $this->email->message($this->load->view('home/emails/invitacion_email', $data_email, true));
                                $this->email->send();
                            }
                            $this->session->set_flashdata('success', 'Invitacion Enviada');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Ocurrio un problema durante el envio de esta invitacion.');
                    }
                }

                redirect('panel_vendedor/invitaciones/pendientes');
            } else {
                redirect('panel_vendedor/invitaciones/pendientes');
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->add_js("modules/admin/panel_vendedores/enviar_invitacion_email.js");
            $this->load->helper('ckeditor');

            $data = array();
            $data['ckeditor'] = array(
                'id' => 'content',
                'path' => 'assets/js/ckeditor',
                'config' => array(
                    'customConfig' => assets_url('js/ckeditor_config_sm.js'),
                    'height' => '400px',
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

            if ($this->config->item('emails_enabled')) {
                $invitacion = $this->invitacion_model->get($id);
                if ($invitacion->invitar_desde != $user_id) {
                    $usr = $this->usuario_model->get($invitacion->invitar_desde);
                    $email = $usr->email;
                } else {
                    $usr = $this->usuario_model->get($invitacion->invitar_para);
                    $email = $usr->email;
                }
                $clt = $this->cliente_model->get_by(array("usuario_id" => $user_id));
                $vdr = $this->vendedor_model->get_by(array("cliente_id" => $clt->id));
                $nombre = $vdr->nombre;
                //TODO : Aqui en vez del $nombre podria y el apodo.
                $data_email = array("identidad" => $nombre);

                $this->load->library('email');
                $this->email->initialize($this->config->item('email_info'));
                $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                $this->email->to($email);
                $this->email->subject('Invitacion Aceptada');
                $this->email->message($this->load->view('home/emails/aceptar_invitacion_vendedor', $data_email, true));
                $this->email->send();
            }
            echo json_encode(array("success" => true));
        }
    }

    /**
     * 
     * @param type $id
     */
    public function rechazar_invitacion($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $this->invitacion_model->rechazar_invitacion($id, $user_id);
            echo json_encode(array("success" => true));
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
            //$params['usuario_activo'] = "1";
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
