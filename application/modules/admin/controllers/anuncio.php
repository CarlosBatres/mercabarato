<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Anuncio extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     *  Listado
     */
    public function view_listado() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->add_js("modules/admin/anuncios_listado.js");
        $this->template->load_view('admin/anuncio/listado');
    }

    /**
     *  Crear
     */
    public function crear() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "item-crear") {
                $vendedor_id = $this->input->post('vendedor_id');
                $vendedor = $this->vendedor_model->get_vendedor($vendedor_id);

                if ($vendedor) {
                    $data = array(
                        "titulo" => $this->input->post('titulo'),
                        "contenido" => $this->input->post('contenido'),
                        "fecha_publicacion" => date("Y-m-d H:i:s"),
                        "destacada" => 0,
                        "vendedor_id" => $vendedor_id,
                        "imagen" => null,
                    );

                    $this->anuncio_model->insert($data);
                    redirect('admin/anuncios');
                } else {
                    $this->session->set_flashdata('error', 'El vendedor no existe.');
                    redirect('admin/anuncios/crear');
                }
            } else {
                redirect('admin');
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            //$this->template->add_js("fileupload.js");
            $this->template->add_js("modules/admin/anuncios.js");            

            $this->template->load_view('admin/anuncio/nuevo',$data);
        }
    }

    /**
     * Borrar
     * @param type $id
     */
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            $this->anuncio_model->delete($id);
            redirect('admin/anuncios');
        }
    }

    /**
     * Editar
     * @param type $id
     */
    public function editar($id) {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "item-editar") {
                $vendedor_id = $this->input->post('vendedor_id');
                $vendedor = $this->vendedor_model->get($vendedor_id);
                $anuncio_id = $this->input->post('id');

                if ($vendedor) {
                    $data = array(
                        "titulo" => $this->input->post('titulo'),
                        "contenido" => $this->input->post('contenido'),
                        "vendedor_id" => $vendedor_id,
                    );

                    $this->anuncio_model->update($anuncio_id, $data);

                    $this->session->set_flashdata('success', 'Anuncio modificado con exito');
                    redirect('admin/anuncios');
                } else {
                    $this->session->set_flashdata('error', 'El vendedor no existe.');
                    redirect('admin/anuncios/editar/' . $anuncio_id);
                }
            } else {
                redirect('admin');
            }
        } else {
            $anuncio = $this->anuncio_model->get_anuncio($id);
            if ($anuncio) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->add_js("modules/admin/anuncios.js");

                $data = array(
                    "anuncio" => $anuncio,
                );

                $this->template->load_view('admin/anuncio/editar', $data);
            } else {
                redirect('admin');
            }
        }
    }

    /**
     *  AJAX Productos / Listado
     */
    public function ajax_get_listado_resultados() {
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('titulo') != "") {
                $params["titulo"] = $this->input->post('titulo');
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            if ($this->input->post('vendedor') != "") {
                $params["vendedor"] = $this->input->post('vendedor');
            }
            $user_id = $this->authentication->read('identifier');
            $restriccion = $this->restriccion_model->get_by("usuario_id", $user_id);
            if ($restriccion) {
                $params["autorizado_por"] = $user_id;
            }
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
            "pagination" => $pagination);

        $this->template->load_view('admin/anuncio/tabla_resultados', $data);
    }

}
