<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_infocompras extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }
    /**
     * Seguros
     */
    public function view_listado_seguros() {
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

    public function responder_seguros($solicitud_seguro_id) {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $solicitud_seguro = $this->infocompra_model->get($solicitud_seguro_id);
        if ($solicitud_seguro) {
            $mensajes = $this->mensaje_model->get_mensajes($solicitud_seguro->id);

            if ($solicitud_seguro->vendedor_id == $this->identidad->get_vendedor_id()) {
                $formValues = $this->input->post();
                if ($formValues !== false) {
                    $config['upload_path'] = './assets/uploads/seguros/' . $this->identidad->get_vendedor_id();
                    $config['allowed_types'] = 'jpg|pdf|word|doc|docx';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if (!is_dir('./assets/uploads/seguros/' . $this->identidad->get_vendedor_id())) {
                        mkdir('./assets/uploads/seguros/' . $this->identidad->get_vendedor_id(), 0777, true);
                    }

                    if ($_FILES AND $_FILES['userfile']['name']) {
                        if (!$this->upload->do_upload()) {
                            $file_name = null;
                            $this->session->set_flashdata('error', $this->upload->display_errors());
                            redirect('panel_vendedor/infocompras/seguros/responder/' . $solicitud_seguro_id);
                            die();
                        } else {
                            $data_upload = $this->upload->data();
                            $file_name = $data_upload["file_name"];
                        }
                    } else {
                        $file_name = null;
                    }

                    $ventajas = "<ul>";
                    $flag = true;
                    if ($this->input->post('ventaja1') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja1') . "</li>";
                    }
                    if ($this->input->post('ventaja2') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja2') . "</li>";
                    }
                    if ($this->input->post('ventaja3') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja3') . "</li>";
                    }
                    if ($this->input->post('ventaja4') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja4') . "</li>";
                    }
                    if ($this->input->post('ventaja5') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja5') . "</li>";
                    }
                    $ventajas.="</ul>";

                    if ($flag) {
                        $ventajas = "";
                    }

                    $precio = $this->input->post('precio');
                    $link_file = ($file_name != null) ? $this->identidad->get_vendedor_id() . '/' . $file_name : null;

                    if (!$mensajes) {
                        $data = array(
                            "estado" => "1",
                            "ventajas" => $ventajas,
                            "precio" => $precio,
                            "link_file" => $link_file
                        );
                    } else {
                        $data = array(
                            "estado" => "1",
                            "precio" => $precio
                        );
                    }

                    $this->infocompra_model->update($solicitud_seguro->id, $data);

                    $respuesta = $this->input->post('respuesta');


                    $data_mensaje = array(
                        "infocompra_id" => $solicitud_seguro->id,
                        "mensaje" => $respuesta,
                        "fecha" => date("Y-m-d"),
                        "enviado_por" => "0",
                    );

                    $this->mensaje_model->insert($data_mensaje);

                    if ($this->config->item('emails_enabled')) {
                        $cliente = $this->cliente_model->get($solicitud_seguro->cliente_id);
                        $usuario = $this->usuario_model->get($cliente->usuario_id);

                        $this->load->library('email');
                        $this->email->initialize($this->config->item('email_info'));
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Se ha respondido a tu solicitud de presupuesto');
                        //$data_mail = array("solicitud_id"=>$solicitud_seguro->id);
                        //$link=site_url('usuario/infocompras-seguros/respuesta/'.$solicitud_seguro->id);
                        $data_mail = array(
                            "link"=>site_url("auth").'?email='.$usuario->email.'&continue='.site_url('usuario/infocompras-seguros/respuesta/'.$solicitud_seguro->id),
                            "identidad"=>$this->identidad->vendedor->nombre);        
                        
                        if($usuario->temporal=="1"){
                            $this->email->message($this->load->view('home/emails/solicitud_presupuesto_registro', $data_mail, true));
                        }else{
                            $this->email->message($this->load->view('home/emails/solicitud_presupuesto_2', $data_mail, true));
                        }                                                
                        $this->email->send();
                    }

                    redirect("panel_vendedor/infocompras/seguros");
                } else {
                    $this->load->helper('ckeditor');

                    $data = array("solicitud_seguro" => $solicitud_seguro);
                    $data['ckeditor'] = array(
                        'id' => 'content',
                        'path' => 'assets/js/ckeditor',
                        'config' => array(
                            'customConfig'=>assets_url('js/ckeditor_config_sm.js'),
                            'height' => '300px',
                        ),
                    );
                    $data["informacion"] = unserialize($solicitud_seguro->datos);
                    $data["mensajes"] = $mensajes;

                    $this->template->add_js("modules/admin/panel_vendedores/form_validation.js");
                    $this->template->load_view('admin/panel_vendedores/infocompras/seguros/responder_seguro', $data);
                }
            } else {
                redirect('panel_vendedor/infocompras/seguros');
            }
        } else {
            redirect('panel_vendedor/infocompras/seguros');
        }
    }

    public function ajax_get_seguros() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $params["vendedor_id"] = $this->identidad->get_vendedor_id();

        if ($formValues !== false) {

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $detalles_array = $this->infocompra_model->get_solicitudes_seguro($params, $limit, $offset);
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

    public function cerrar_seguros($solicitud_seguro_id) {
        if ($this->input->is_ajax_request()) {
            $this->ajax_header();
            $solicitud_seguro = $this->infocompra_model->get($solicitud_seguro_id);
            if ($solicitud_seguro) {
                if ($solicitud_seguro->vendedor_id == $this->identidad->get_vendedor_id()) {
                    $this->infocompra_model->update($solicitud_seguro_id, array("estado" => "2"));
                    echo json_encode(array("success" => true));
                }else{
                    echo json_encode(array("error" => true));
                }
            }else{
                echo json_encode(array("error" => true));
            }            
        } else {
            redirect('404');
        }
    }

    public function borrar_seguros($solicitud_seguro_id) {
         if ($this->input->is_ajax_request()) {
            $this->ajax_header();
            $solicitud_seguro = $this->infocompra_model->get($solicitud_seguro_id);
            if ($solicitud_seguro) {
                if ($solicitud_seguro->vendedor_id == $this->identidad->get_vendedor_id()) {
                    $this->infocompra_model->delete($solicitud_seguro_id);
                    echo json_encode(array("success" => true));
                }else{
                    echo json_encode(array("error" => true));
                }
            }else{
                echo json_encode(array("error" => true));
            }            
        } else {
            redirect('404');
        }
    }
    
    /**
     * Generales
     */
    public function view_listado_generales() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete->limite_productos != "0") {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');

            $this->template->add_js("modules/admin/panel_vendedores/infocompras_listado.js");
            $this->template->load_view('admin/panel_vendedores/infocompras/general/listado');
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/infocompras/sin_acceso');
        }
    }
    
    public function ajax_get_generales() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        $params["vendedor_id"] = $this->identidad->get_vendedor_id();

        if ($formValues !== false) {

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $detalles_array = $this->infocompra_model->get_solicitudes_infocompras($params, $limit, $offset);
        $flt = (float) ($detalles_array["total"] / $limit);
        $ent = (int) ($detalles_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($detalles_array["total"] == 0) {
            $detalles_array["infocompras"] = array();
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
            "infocompras_generales" => $detalles_array["infocompras"],
            "pagination" => $pagination);

        $this->template->load_view('admin/panel_vendedores/infocompras/general/tabla_resultados', $data);
    }
    
    public function cerrar_generales($solicitud_id) {
        if ($this->input->is_ajax_request()) {
            $this->ajax_header();
            $solicitud = $this->infocompra_model->get($solicitud_id);
            if ($solicitud) {
                if ($solicitud->vendedor_id == $this->identidad->get_vendedor_id()) {
                    $this->infocompra_model->update($solicitud_id, array("estado" => "2"));
                    echo json_encode(array("success" => true));
                }else{
                    echo json_encode(array("error" => true));
                }
            }else{
                echo json_encode(array("error" => true));
            }            
        } else {
            redirect('404');
        }
    }

    public function borrar_generales($solicitud_id) {
         if ($this->input->is_ajax_request()) {
            $this->ajax_header();
            $solicitud = $this->infocompra_model->get($solicitud_id);
            if ($solicitud) {
                if ($solicitud->vendedor_id == $this->identidad->get_vendedor_id()) {
                    $this->infocompra_model->delete($solicitud_id);
                    echo json_encode(array("success" => true));
                }else{
                    echo json_encode(array("error" => true));
                }
            }else{
                echo json_encode(array("error" => true));
            }            
        } else {
            redirect('404');
        }
    }
    
    public function responder_generales($solicitud_id) {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $solicitud = $this->infocompra_model->get($solicitud_id);
        if ($solicitud) {
            $mensajes = $this->mensaje_model->get_mensajes($solicitud->id);

            if ($solicitud->vendedor_id == $this->identidad->get_vendedor_id()) {
                $formValues = $this->input->post();
                if ($formValues !== false) { 
                    $config['upload_path'] = './assets/uploads/infocompras/' . $this->identidad->get_vendedor_id();
                    $config['allowed_types'] = 'jpg|pdf|word|doc|docx';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);
                    
                    if (!is_dir('./assets/uploads/infocompras/' . $this->identidad->get_vendedor_id())) {
                        mkdir('./assets/uploads/infocompras/' . $this->identidad->get_vendedor_id(), 0777, true);
                    }

                    if ($_FILES AND $_FILES['userfile']['name']) {
                        if (!$this->upload->do_upload()) {
                            $file_name = null;
                            $this->session->set_flashdata('error', $this->upload->display_errors());
                            redirect('panel_vendedor/infocompras/generales/responder/' . $solicitud_id);
                            die();
                        } else {
                            $data_upload = $this->upload->data();
                            $file_name = $data_upload["file_name"];
                        }
                    } else {
                        $file_name = null;
                    }
                    
                    $ventajas = "<ul>";
                    $flag = true;
                    if ($this->input->post('ventaja1') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja1') . "</li>";
                    }
                    if ($this->input->post('ventaja2') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja2') . "</li>";
                    }
                    if ($this->input->post('ventaja3') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja3') . "</li>";
                    }
                    if ($this->input->post('ventaja4') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja4') . "</li>";
                    }
                    if ($this->input->post('ventaja5') != "") {
                        $flag = false;
                        $ventajas.="<li>" . $this->input->post('ventaja5') . "</li>";
                    }
                    $ventajas.="</ul>";

                    if ($flag) {
                        $ventajas = "";
                    }

                    $precio = $this->input->post('precio');                    
                    $link_file = ($file_name != null) ? $this->identidad->get_vendedor_id() . '/' . $file_name : null;

                    if (!$mensajes) {
                        $data = array(
                            "estado" => "1",
                            "ventajas" => $ventajas,
                            "precio" => $precio,
                            "link_file" => $link_file
                        );
                    } else {
                        $data = array(
                            "estado" => "1",
                            "precio" => $precio
                        );
                    }

                    $this->infocompra_model->update($solicitud->id, $data);

                    $respuesta = $this->input->post('respuesta');


                    $data_mensaje = array(
                        "infocompra_id" => $solicitud->id,
                        "mensaje" => $respuesta,
                        "fecha" => date("Y-m-d"),
                        "enviado_por" => "0",
                    );

                    $this->mensaje_model->insert($data_mensaje);

                    if ($this->config->item('emails_enabled')) {
                        $cliente = $this->cliente_model->get($solicitud->cliente_id);
                        $usuario = $this->usuario_model->get($cliente->usuario_id);

                        $this->load->library('email');
                        $this->email->initialize($this->config->item('email_info'));
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Se ha respondido a tu solicitud de presupuesto');
                        //$data_mail = array("solicitud_id"=>$solicitud->id);
                        //$link=site_url('usuario/infocompras-seguros/respuesta/'.$solicitud->id);
                        $data_mail = array(
                            "link"=>site_url("auth").'?email='.$usuario->email.'&continue='.site_url('usuario/infocompras-general/respuesta/'.$solicitud->id),
                            "identidad"=>$this->identidad->vendedor->nombre);
                        
                        if($usuario->temporal=="1"){
                            $this->email->message($this->load->view('home/emails/solicitud_presupuesto_registro', $data_mail, true));
                        }else{
                            $this->email->message($this->load->view('home/emails/solicitud_presupuesto_2', $data_mail, true));
                        }                                                
                        $this->email->send();
                    }

                    redirect("panel_vendedor/infocompras/generales");
                } else {
                    $this->load->helper('ckeditor');

                    $data = array("solicitud" => $solicitud);
                    $data['ckeditor'] = array(
                        'id' => 'content',
                        'path' => 'assets/js/ckeditor',
                        'config' => array(
                            'customConfig'=>assets_url('js/ckeditor_config_sm.js'),
                            'height' => '300px',
                        ),
                    );
                    $data["informacion"] = unserialize($solicitud->datos);
                    $data["mensajes"] = $mensajes;

                    $this->template->add_js("modules/admin/panel_vendedores/form_validation.js");
                    $this->template->load_view('admin/panel_vendedores/infocompras/general/responder_general', $data);
                }
            } else {
                redirect('panel_vendedor/infocompras/seguros');
            }
        } else {
            redirect('panel_vendedor/infocompras/seguros');
        }
    }

}
