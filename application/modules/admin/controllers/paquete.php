<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paquete extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->authentication->is_loggedin()) {
            redirect('admin/login');
        } else {
            if (!$this->authentication->user_is_admin()) {
                redirect('admin/sin_permiso');
            }
        }
    }

    /**
     *  Listado
     */
    public function view_listado() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/paquetes_listado.js");
        $this->template->load_view('admin/paquete/listado');
    }

    /**
     *  Crear
     */
    public function crear() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $tipo = $this->input->post('tipo');
            if ($tipo == "productos") {
                if ($this->input->post('limite_productos') == "") {
                    $limite_productos = -1;
                } else {
                    $limite_productos = $this->input->post('limite_productos');
                }
                if ($this->input->post('limite_anuncios') == "") {
                    $limite_anuncios = -1;
                } else {
                    $limite_anuncios = $this->input->post('limite_anuncios');
                }
                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "descripcion" => $this->input->post('descripcion'),
                    "limite_productos" => $limite_productos,
                    "limite_anuncios" => $limite_anuncios,
                    "duracion" => $this->input->post('duracion'),
                    "costo" => $this->input->post('costo'),
                    "orden" => ($this->input->post('orden') != '') ? $this->input->post('orden') : 0,
                    "activo" => 1,
                    "mostrar" => $this->input->post('mostrar'),
                    "infocompra"=>0
                );
            } else {
                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "descripcion" => $this->input->post('descripcion'),
                    "limite_productos" => 0,
                    "limite_anuncios" => 0,
                    "duracion" => $this->input->post('duracion'),
                    "costo" => $this->input->post('costo'),
                    "orden" => ($this->input->post('orden') != '') ? $this->input->post('orden') : 0,
                    "activo" => 1,
                    "mostrar" => $this->input->post('mostrar'),
                    "infocompra"=>1
                );
            }

            $this->paquete_model->insert($data);
            redirect('admin/paquetes');
        } else {
            $this->template->set_title("Panel de Administracion - Mercabarato.com");            
            $this->template->add_js("modules/admin/paquetes.js");
            $this->template->load_view('admin/paquete/nuevo');
        }
    }

    /**
     * Borrar
     * @param type $id
     */
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            $this->paquete_model->delete($id);
            redirect('admin/paquetes');
        }
    }

    /**
     *  AJAX Productos / Listado
     */
    public function ajax_get_listado_resultados() {
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $paquetes_array = $this->paquete_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($paquetes_array["total"] / $limit);
        $ent = (int) ($paquetes_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($paquetes_array["total"] == 0) {
            $paquetes_array["paquetes"] = array();
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $paquetes_array["total"],
            "hasta" => ($pagina * $limit < $paquetes_array["total"]) ? $pagina * $limit : $paquetes_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "paquetes" => $paquetes_array["paquetes"],
            "pagination" => $pagination);

        $this->template->load_view('admin/paquete/tabla_resultados', $data);
    }

}
