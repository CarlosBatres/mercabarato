<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_anuncios extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }

    /**
     * 
     */
    public function agregar() {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        $cantidad = $this->vendedor_model->get_cantidad_anuncios_disp($vendedor->get_vendedor_id());

        if ($cantidad > 0) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $accion = $this->input->post('accion');

                if ($accion === "item-crear") {
                    $data = array(
                        "titulo" => $this->input->post('titulo'),
                        "contenido" => $this->input->post('contenido'),
                        "fecha_publicacion" => date("Y-m-d H:i:s"),
                        "destacada" => 0,
                        "vendedor_id" => $vendedor->get_vendedor_id(),
                        "imagen" => null,
                        "habilitado" => 1
                    );

                    $anuncio_id = $this->anuncio_model->insert($data);
                    $this->session->set_flashdata('success', 'Anuncio creado con exito..');

                    redirect('panel_vendedor/anuncio/seleccionar-clientes/' . $anuncio_id);
                } else {
                    redirect('panel_vendedor');
                }
            } else {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $this->template->add_js("modules/admin/panel_vendedores/form_validation.js");
                $this->load->helper('ckeditor');

                $data['ckeditor'] = array(
                    'id' => 'content',
                    'path' => 'assets/js/ckeditor',
                    'config' => array(
                        'customConfig' => assets_url('js/ckeditor_config_full.js'),
                        'height' => '400px', //Setting a custom height
                        'filebrowserImageUploadUrl' => assets_url('/js/ckeditor/plugins/imgupload.php?url=anuncios'),
                    ),
                );

                $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_agregar', $data);
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_limite');
        }
    }

    /**
     * 
     * @param type $id
     */
    public function editar($id) {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        $anuncio_id = $id;

        $res = $this->anuncio_model->get_vendedor_id_del_anuncio($anuncio_id);
        if ($res == $vendedor->get_vendedor_id()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $accion = $this->input->post('accion');

                if ($accion === "item-editar") {
                    $data = array(
                        "titulo" => $this->input->post('titulo'),
                        "contenido" => $this->input->post('contenido'),
                    );

                    $this->anuncio_model->update($anuncio_id, $data);
                    $this->session->set_flashdata('success', 'Anuncio modificado con exito');
                    redirect('panel_vendedor/anuncio/listado');
                } else {
                    redirect('panel_vendedor');
                }
            } else {
                $anuncio = $this->anuncio_model->get($id);
                if ($anuncio) {
                    $this->template->set_title("Panel de Control - Mercabarato.com");
                    $this->template->add_js("modules/admin/panel_vendedores/form_validation.js");
                    $vendedor = $this->vendedor_model->get($anuncio->vendedor_id);

                    $data = array(
                        "anuncio" => $anuncio);

                    $this->load->helper('ckeditor');

                    $data['ckeditor'] = array(
                        //ID of the textarea that will be replaced
                        'id' => 'content',
                        'path' => 'assets/js/ckeditor',
                        //Optionnal values
                        'config' => array(
                            'customConfig' => assets_url('js/ckeditor_config_full.js'),
                            'height' => '400px', //Setting a custom height
                            'filebrowserImageUploadUrl' => assets_url('/js/ckeditor/plugins/imgupload.php?url=anuncios')
                        ),
                    );


                    $this->template->set_layout('panel_vendedores');
                    $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_editar', $data);
                } else {
                    redirect('panel_vendedor/anuncio/listado');
                }
            }
        } else {
            redirect('panel_vendedor/anuncio/listado');
        }
    }

    /**
     * 
     */
    public function listado() {
        $this->session->keep_flashdata("success");
        $this->session->keep_flashdata("error");
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/anuncios_listado.js");
        $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_listado');
    }

    /**
     * 
     */
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $anuncio_id = $id;

            $res = $this->anuncio_model->get_vendedor_id_del_anuncio($anuncio_id);
            if ($res == $vendedor->get_vendedor_id()) {
                $this->anuncio_model->delete($id);
                $this->session->set_flashdata('success', 'Anuncio eliminado con exito..');
            } else {
                $this->session->set_flashdata('error', 'No puedes realizar esta accion.');
            }
            echo json_encode(array("success" => true));
        } else {
            show_404();
        }
    }

    public function borrar_multi() {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);

            $formValues = $this->input->post();
            if ($formValues !== false) {
                $anuncio_ids = $this->input->post('anuncio_ids');
                $ids = explode(";;", $anuncio_ids);

                $flag = 0;
                foreach ($ids as $id) {
                    $res = $this->anuncio_model->get_vendedor_id_del_anuncio($id);
                    if ($res == $vendedor->get_vendedor_id()) {
                        $this->anuncio_model->delete($id);
                    } else {
                        $flag = 1;
                    }
                }
                if ($flag == 0) {
                    $this->session->set_flashdata('success', 'Anuncios eliminados con exito..');
                } elseif ($flag == 1) {
                    $this->session->set_flashdata('error', 'Ha ocurrido un error durante la operacion.');
                }

                echo json_encode(array("success" => true));
            }
        } else {
            show_404();
        }
    }

    /**
     * 
     */
    public function ajax_get_listado_resultados() {
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('titulo') != "") {
                $params["titulo"] = $this->input->post('titulo');
            }
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $params["vendedor_id"] = $vendedor->get_vendedor_id();
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $anuncios_array = $this->anuncio_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($anuncios_array["total"] / $limit);
        $ent = (int) ($anuncios_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($anuncios_array["total"] == 0) {
            $anuncios_array["anuncios"] = array();
        }

        $paquete_en_curso = $this->vendedor_model->get_paquete_en_curso($vendedor->get_vendedor_id());
        $ilimitado = false;
        $limite_anuncios = 0;
        if ($paquete_en_curso) {
            if ($paquete_en_curso->limite_anuncios == -1) {
                $ilimitado = true;
            } else {
                $limite_anuncios = $paquete_en_curso->limite_anuncios;
            }
            $anuncios_publicados=$paquete_en_curso->anuncios_publicados;
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $anuncios_array["total"],
            "hasta" => ($pagina * $limit < $anuncios_array["total"]) ? $pagina * $limit : $anuncios_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "anuncios" => $anuncios_array["anuncios"],
            "pagination" => $pagination,
            "anuncios_total" => $anuncios_publicados,
            "ilimitado" => $ilimitado,
            "limite_anuncios" => $limite_anuncios);

        $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_tabla_resultados', $data);
    }

    public function inhabilitar($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $anuncio_id = $id;

            $res = $this->anuncio_model->get_vendedor_id_del_anuncio($anuncio_id);
            if ($res == $vendedor->get_vendedor_id()) {
                $this->anuncio_model->inhabilitar($id);
                $this->session->set_flashdata('success', 'Anuncio inhabilitado con exito..');
            } else {
                $this->session->set_flashdata('error', 'No puedes realizar esta accion.');
            }
        } else {
            show_404();
        }
    }

    /**
     * 
     * @param type $id
     */
    public function habilitar($id) {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $anuncio_id = $id;

            $res = $this->anuncio_model->get_vendedor_id_del_anuncio($anuncio_id);
            if ($res == $vendedor->get_vendedor_id()) {
                $cant = $this->vendedor_model->get_cantidad_anuncios_por_habilitar($vendedor->get_vendedor_id());
                if ($cant >= 1) {
                    $this->anuncio_model->habilitar($id);
                    $this->session->set_flashdata('success', 'Anuncio habilitado con exito..');
                } else {
                    $this->session->set_flashdata('error', 'Has llegado al limite de productos.');
                }
            } else {
                $this->session->set_flashdata('error', 'No puedes realizar esta accion.');
            }
        } else {
            show_404();
        }
    }

    /**
     *
     * @param type $anuncio_id
     */
    public function seleccionar_clientes($anuncio_id) {
        $this->session->keep_flashdata("success");
        $this->session->keep_flashdata("error");
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);

        $res = $this->anuncio_model->get_vendedor_id_del_anuncio($anuncio_id);
        if ($res == $vendedor->get_vendedor_id()) {

            $this->template->add_js("modules/admin/panel_vendedores/anuncios_seleccionar_clientes.js");
            $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_seleccionar_clientes', array("anuncio_id" => $anuncio_id));
        } else {
            show_404();
        }
    }

    public function ajax_get_invitados() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            $params['usuario_activo'] = "1";
            $params["usuario_id"] = $this->identidad->usuario->id;
            $params["excluir_admins"] = true;
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->invitacion_model->get_invitaciones_aceptadas($params, $limit, $offset, "ultimo_acceso", "DESC");
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


        $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_invitados_tabla_resultados', $data);
    }

    /**
     * 
     * @param type $anuncio_id
     */
    public function seleccionar_productos($anuncio_id) {
        $this->session->keep_flashdata("success");
        $this->session->keep_flashdata("error");
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);

        $res = $this->anuncio_model->get_vendedor_id_del_anuncio($anuncio_id);
        if ($res == $vendedor->get_vendedor_id()) {

            $this->template->add_js("modules/admin/panel_vendedores/anuncios_seleccionar_productos.js");
            $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_seleccionar_productos', array("anuncio_id" => $anuncio_id));
        } else {
            show_404();
        }
    }

    public function ajax_get_productos() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            $user_id = $this->authentication->read('identifier');
            $vendedor = $this->usuario_model->get_full_identidad($user_id);
            $params["vendedor_id"] = $vendedor->get_vendedor_id();

            if ($this->input->post("no_results") != "") {
                $params["vendedor_id"] = "-100"; // Hack vendedor inexistente
            }

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $productos_array = $this->producto_model->get_admin_search($params, $limit, $offset);
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
            "pagination" => $pagination);

        $this->template->load_view('admin/panel_vendedores/anuncio/anuncio_productos_tabla_resultados', $data);
    }

    /**
     * 
     */
    public function enviar_anuncio_invitados() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            $params = array();
            if ($formValues !== false) {
                $anuncio_id = $this->input->post("anuncio_id");
                $anuncio = $this->anuncio_model->get($anuncio_id);

                $user_id = $this->authentication->read('identifier');
                $vendedor = $this->usuario_model->get_full_identidad($user_id);

                $res = $this->anuncio_model->get_vendedor_id_del_anuncio($anuncio_id);
                if ($res == $vendedor->get_vendedor_id()) {
                    $cliente_ids = $this->input->post("cliente_ids");
                    if ($cliente_ids != "") {
                        $array_cliente_id = explode(";;", $cliente_ids);
                    } else {
                        $array_cliente_id = false;
                    }

                    $producto_ids = $this->input->post("producto_ids");
                    if ($producto_ids != "") {
                        $array_producto_id = explode(";;", $producto_ids);
                    } else {
                        $array_producto_id = false;
                    }

                    if ($this->config->item('emails_enabled')) {
                        $this->load->library('email');
                        $this->email->initialize($this->config->item('email_info'));
                    }

                    if ($array_cliente_id) {
                        foreach ($array_cliente_id as $id) {
                            $email = $this->cliente_model->get_email($id);

                            if ($array_producto_id) {
                                $params = array();
                                $params["cliente_id"] = $id;
                                $params["producto_ids"] = $array_producto_id;
                                $productos = $this->producto_model->get_productos_tarifas($params);
                            } else {
                                $productos = false;
                            }

                            if ($this->config->item('emails_enabled') && $email) {
                                $this->email->clear();
                                $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                                $this->email->to($email);
                                $this->email->subject($anuncio->titulo);
                                $data_email = array("titulo" => $anuncio->titulo, "contenido" => $anuncio->contenido, "productos" => $productos);
                                $this->email->message($this->load->view('home/emails/enviar_anuncio_email', $data_email, true));
                                $this->email->send();
                            }
                            
                        }
                    }
                }
                echo json_encode(array("response" => true));
            }
        }
    }

}
