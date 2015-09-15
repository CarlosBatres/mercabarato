<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Infocompra extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     */
    public function view_infocompras() {
        $this->session->unset_userdata('infocompras');
        $this->session->unset_userdata('infocompra_ignore_list');
        $this->session->unset_userdata('infocompra_new_user');

        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->usuario_model->get_full_identidad($user_id);

            $this->template->add_js('modules/home/infocompra.js');
            $data = array("datos_contacto" => $cliente);
            $this->template->load_view('home/infocompra/formulario', $data);
        } else {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $this->template->add_js('modules/home/infocompra.js');
            $data = array();
            $this->template->load_view('home/infocompra/formulario', $data);
        }
    }

    /**
     * 
     */
    public function paso_1() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $datos_contacto = array(
                "nombres" => ($this->input->post('nombres') != '') ? $this->input->post('nombres') : null,
                "apellidos" => ($this->input->post('apellidos') != '') ? $this->input->post('apellidos') : null,
                "telefono_contacto" => ($this->input->post('telefono_contacto') != '') ? $this->input->post('telefono_contacto') : null,
                "email" => ($this->input->post('email') != '') ? $this->input->post('email') : null,
                "comentario" => ($this->input->post('comentario') != '') ? $this->input->post('comentario') : null
            );


            $datos_formulario = array(
                "precio_desde" => ($this->input->post('precio_desde') != '') ? $this->input->post('precio_desde') : null,
                "precio_hasta" => ($this->input->post('precio_hasta') != '') ? $this->input->post('precio_hasta') : null,
                "tipo" => ($this->input->post('tipo') != '') ? $this->input->post('tipo') : null,
                "regalo_tipo" => ($this->input->post('regalo_tipo') != '') ? $this->input->post('regalo_tipo') : null,
                "sexo" => ($this->input->post('sexo') != '') ? $this->input->post('sexo') : null,
                "edad" => ($this->input->post('edad') != '') ? $this->input->post('edad') : null,
                "gustos" => ($this->input->post('gustos') != '') ? $this->input->post('gustos') : null,
                "tipo-ocio" => ($this->input->post('tipo-ocio') != '') ? $this->input->post('tipo-ocio') : null,
                "comida" => ($this->input->post('comida') != '') ? $this->input->post('comida') : null,
                "fecha_inicio_restaurante" => ($this->input->post('fecha_inicio_restaurante') != '') ? $this->input->post('fecha_inicio_restaurante') : null,
                "fecha_fin_restaurante" => ($this->input->post('fecha_fin_restaurante') != '') ? $this->input->post('fecha_fin_restaurante') : null,
                "cantidad_personas" => ($this->input->post('cantidad_personas') != '') ? $this->input->post('cantidad_personas') : null,
                "habitaciones" => ($this->input->post('habitaciones') != '') ? $this->input->post('habitaciones') : null,
                "fecha_inicio_hoteles" => ($this->input->post('fecha_inicio_hoteles') != '') ? $this->input->post('fecha_inicio_hoteles') : null,
                "fecha_fin_hoteles" => ($this->input->post('fecha_fin_hoteles') != '') ? $this->input->post('fecha_fin_hoteles') : null,
                "cantidad_personas" => ($this->input->post('cantidad_personas') != '') ? $this->input->post('cantidad_personas') : null,
                "exigencia" => ($this->input->post('exigencia') != '') ? $this->input->post('exigencia') : null,
            );

            $session_data = array();
            $session_data["infocompras_datos_contacto"] = $datos_contacto;
            $session_data["infocompras_datos_formulario"] = $datos_formulario;

            $this->session->set_userdata(array("infocompras" => $session_data));
            $categorias = $this->categoria_model->get_many_by(array("padre_id" => "0"));
            $provincias = $this->provincia_model->get_all_by_pais(70);

            $data = array("categorias" => $categorias, "provincias" => $provincias);
            $this->template->set_title('Mercabarato - Busca y Compara');
            $this->template->add_js('modules/home/infocompra.js');
            $this->template->load_view('home/infocompra/seleccionar_parte_1', $data);
        } else {
            redirect('infocompras');
        }
    }

    /**
     * 
     */
    public function paso_2() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $infocompras = $this->session->userdata('infocompras');

            if ($infocompras) {
                $data = array(
                    "categoria" => ($this->input->post('categorias')) ? $this->input->post('categorias') : false,
                    "provincia" => ($this->input->post('provincia') != "0") ? $this->input->post('provincia') : false,
                    "poblacion" => ($this->input->post('poblacion') != "0") ? $this->input->post('poblacion') : false
                );

                $infocompras["infocompras_datos_paso_2"] = $data;
                $this->session->set_userdata(array("infocompras" => $infocompras));

                redirect('infocompras/seleccionar-vendedor');
            } else {
                redirect('infocompras');
            }
        } else {
            redirect('infocompras');
        }
    }

    /**
     * 
     */
    public function seleccionar_vendedor() {
        $infocompras = $this->session->userdata('infocompras');
        if ($infocompras) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $this->template->add_js('modules/home/infocompra_listado.js');

            $data = array();
            $data["hide_terminar"] = false;

            $this->template->load_view('home/infocompra/seleccionar_vendedor', $data);
        } else {
            redirect('infocompras');
        }
    }

    /**
     * 
     */
    public function ajax_get_listado_resultados() {
        //$this->show_profiler();
        $formValues = $this->input->post();
        $params = array();
        if ($formValues !== false) {
            $infocompras = $this->session->userdata('infocompras');

            if ($infocompras) {
                if ($infocompras["infocompras_datos_paso_2"]["provincia"]) {
                    $params["provincia"] = $infocompras["infocompras_datos_paso_2"]["provincia"];
                }
                if ($infocompras["infocompras_datos_paso_2"]["poblacion"]) {
                    $params["poblacion"] = $infocompras["infocompras_datos_paso_2"]["poblacion"];
                }
                if ($infocompras["infocompras_datos_paso_2"]["categoria"]) {
                    $keyword = "";
                    foreach ($infocompras["infocompras_datos_paso_2"]["categoria"] as $categoria) {
                        $cat_obj = $this->categoria_model->get($categoria);
                        $keyword.=$cat_obj->nombre . ";";
                    }
                    $params["keyword"] = substr($keyword, 0, -1);
                }
            }
            $params["paquete_vigente"] = true;

            $ignore_list = $this->session->userdata('infocompra_ignore_list');
            if ($ignore_list) {
                $params["not_vendedor"] = $ignore_list;
            }
            if ($this->authentication->is_loggedin()) {
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->usuario_model->get_full_identidad($user_id);
                if (!$ignore_list) {
                    if (isset($cliente->vendedor)) {
                        $params["not_vendedor"] = $cliente->vendedor->id;
                    }
                } else {
                    if (isset($cliente->vendedor)) {
                        $params["not_vendedor"] = array_merge($ignore_list, array($cliente->vendedor->id));
                    } else {
                        $params["not_vendedor"] = $ignore_list;
                    }
                }
            }

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        //$limit = $this->config->item("principal_default_per_page");
        $limit = 5;
        $offset = $limit * ($pagina - 1);
        //$vendedores_array = $this->vendedor_paquete_model->buscar_vendedores($params, $limit, $offset);
        $vendedores_array = $this->vendedor_model->get_site_search($params, $limit, $offset);
        $flt = (float) ($vendedores_array["total"] / $limit);
        $ent = (int) ($vendedores_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($vendedores_array["total"] == 0) {
            $vendedores_array["vendedores"] = array();
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $vendedores_array["total"],
            "hasta" => ($pagina * $limit < $vendedores_array["total"]) ? $pagina * $limit : $vendedores_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "vendedores" => $vendedores_array["vendedores"],
            "pagination" => $pagination);

        $html = $this->load->view('home/infocompra/tabla_resultados', $data, true);
        $result = array("html" => $html);
        if ($vendedores_array["total"] > 0) {
            $result["result"] = "success";
        } else {
            $result["result"] = "empty";
        }
        echo json_encode($result);
    }

    /**
     * 
     */
    public function crear_infocompra() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $vendedor_id = $this->input->post('id');
            $vendedor = $this->vendedor_model->get($vendedor_id);
            $this->enviar_solicitud($vendedor_id);
            $this->session->set_flashdata('success', 'La solicitud ha sido enviada con exito.<br> Se envio al vendedor <strong>' . $vendedor->nombre . '</strong>');
        }
    }

    /**
     * 
     * @param type $vendedor_id
     */
    private function enviar_solicitud($vendedor_id) {
        $infocompras = $this->session->userdata('infocompras');
        $datos_contacto = $infocompras["infocompras_datos_contacto"];

        if ($this->authentication->is_loggedin()) {
            /**
             * Si existe el cliente
             */
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_id = $cliente->id;
        } else if ($this->session->userdata('infocompra_new_user')) {
            $cliente_id = $this->session->userdata('infocompra_new_user');
        } else {
            /**
             * Si no existe el cliente lo creo temporal para que se pueda registrar despues
             */
            $user_id = $this->authentication->create_user($datos_contacto["email"], "passwordtemporal");
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
                "nombres" => $datos_contacto["nombres"],
                "apellidos" => $datos_contacto["apellidos"],
                "sexo" => null,
                "fecha_nacimiento" => null,
                "codigo_postal" => null,
                "direccion" => null,
                "telefono_fijo" => null,
                "telefono_movil" => null,
                "keyword" => null
            );

            $cliente_id = $this->cliente_model->insert($data);
            $this->session->set_userdata(array(
                'infocompra_new_user' => $cliente_id,
            ));
        }


        $informacion = $infocompras['infocompras_datos_formulario'];
        $data = array(
            'datos_contacto' => $datos_contacto,
            'informacion' => $informacion
        );

        $solicitud_infocompra = array(
            "vendedor_id" => $vendedor_id,
            "cliente_id" => $cliente_id,
            "datos" => serialize($data),
            "fecha_solicitud" => date("Y-m-d"),
            "estado" => 0,
            "infocompra_general" => 1
        );

        $ignore_list = $this->session->userdata('infocompra_ignore_list');
        if (!$ignore_list) {
            $ignore_list = array();
        }
        $ignore_list[] = $vendedor_id;
        $this->session->set_userdata(array(
            'infocompra_ignore_list' => $ignore_list,
        ));

        $solicitud_id = $this->infocompra_model->insert($solicitud_infocompra);
        $vendedor = $this->vendedor_model->get($vendedor_id);

        if ($this->config->item('emails_enabled')) {
            $cliente = $this->cliente_model->get($vendedor->cliente_id);
            $usuario = $this->usuario_model->get($cliente->usuario_id);

            $this->load->library('email');
            $this->email->from($this->config->item('site_noreply_email'), 'Mercabarato.com');
            $this->email->to($usuario->email);
            $this->email->subject('Nueva solicitud de presupuesto');
            //$data_email = array("solicitud_id" => $solicitud_id);
            $link = site_url('panel_vendedor/infocompras/generales/responder/' . $solicitud_id);
            $data_email = array("link" => $link);
            $this->email->message($this->load->view('home/emails/solicitud_presupuesto', $data_email, true));
            $this->email->send();
        }
    }

    /**
     * 
     */
    public function finalizar() {
        $this->session->unset_userdata('infocompras');
        $this->session->unset_userdata('infocompra_ignore_list');
        $this->session->unset_userdata('infocompra_new_user');
        redirect('usuario/infocompras-general');
    }

}
