<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_infocompras extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }

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

        $solicitud_seguro = $this->solicitud_seguro_model->get($solicitud_seguro_id);
        if ($solicitud_seguro) {
            if ($solicitud_seguro->vendedor_id == $this->identidad->get_vendedor_id()) {
                $formValues = $this->input->post();
                if ($formValues !== false) {                    
                    $config['upload_path'] =  './assets/uploads/seguros/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|word|doc|docx|xlsx|txt|psd';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload()) {
                        $error = array('error' => $this->upload->display_errors());                        
                        $file_name=null;
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect('panel_vendedor/infocompras/seguros/responder/'.$solicitud_seguro_id);
                        die();
                    }else{
                        $data_upload = $this->upload->data();
                        $file_name=$data_upload["file_name"];
                    }
                    
                    $respuesta = $this->input->post('respuesta');
                    $data = array("estado" => "2", "respuesta" => $respuesta, "fecha_respuesta" => date("Y-m-d"),"link_file"=>$file_name);

                    $this->solicitud_seguro_model->update($solicitud_seguro->id, $data);

                    if ($this->config->item('emails_enabled')) {
                        $cliente = $this->cliente_model->get($solicitud_seguro->cliente_id);
                        $usuario = $this->usuario_model->get($cliente->usuario_model);
                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Se ha respondido a tu solicitud de presupuesto');
                        $data_mail = array();
                        $this->email->message($this->load->view('home/emails/solicitud_presupuesto_2', $data_mail, true));
                        $this->email->send();
                    }

                    redirect("panel_vendedor/infocompras/seguros");
                } else {
                    $this->load->helper('ckeditor');

                    $data = array("solicitud_seguro" => $solicitud_seguro);
                    $data['ckeditor'] = array(
                        //ID of the textarea that will be replaced
                        'id' => 'content',
                        'path' => 'assets/js/ckeditor',
                        //Optionnal values
                        'config' => array(
                            'toolbar' => "Full", //Using the Full toolbar                        
                            'height' => '300px', //Setting a custom height
                        ),
                    );
                    $data["informacion"] = unserialize($solicitud_seguro->datos);

                    //$this->template->add_js("modules/admin/panel_vendedores/seguros_listado.js");
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
        $detalles_array = $this->solicitud_seguro_model->get_solicitudes_seguro($params, $limit, $offset);
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

}
