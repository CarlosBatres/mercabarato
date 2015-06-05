<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producto extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function view_pre_listado() {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $categorias = $this->categoria_model->get_many_by('padre_id', 0);
        $data = array("categorias" => $categorias);

        $this->template->load_view('home/producto/pre_listado', $data);
    }

    public function view_listado($categoria) {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $this->template->add_js('modules/home/producto_listado.js');

        $categoria = $this->categoria_model->get_by('slug', $categoria);
        $subcategorias = $this->categoria_model->get_many_by('padre_id', $categoria->id);
        $data = array("subcategorias" => $subcategorias, "categoria" => $categoria);
        $this->template->load_view('home/producto/listado', $data);
    }

    /**
     *  AJAX Productos / Listado
     */
    public function ajax_get_listado_resultados() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('search_query') != "") {
                $params["nombre"] = $this->input->post('search_query');
                $params["descripcion"] = $this->input->post('search_query');
            }

            if ($this->input->post('categoria_id') != "") {
                $params["categoria_id"] = $this->input->post('categoria_id');
            }
            if ($this->input->post('categoria_padre') != "") {
                $params["categoria_general"] = $this->input->post('categoria_padre');
            }

            $pagina = $this->input->post('pagina');

            $limit = 8;
            $offset = $limit * ($pagina - 1);
            $productos = $this->producto_model->get_site_search($params, $limit, $offset, "id", "ASC");
            $flt = (float) ($productos["total"] / $limit);
            $ent = (int) ($productos["total"] / $limit);
            if ($flt > $ent || $flt < $ent) {
                $paginas = $ent + 1;
            } else {
                $paginas = $ent;
            }

            if ($productos["total"] == 0) {
                $productos["productos"] = array();
                // TODO: Resultados vacio
            }

            $data = array(
                "productos" => $productos["productos"],
                "search_params" => array(
                    "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                    "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                    "pagina" => $pagina,
                    "total_paginas" => $paginas,
                    "por_pagina" => $limit,
                    "total" => $productos["total"],
                    "hasta" => ($pagina * $limit < $productos["total"]) ? $pagina * $limit : $productos["total"],
                    "desde" => (($pagina * $limit) - $limit) + 1)
            );

            $this->template->load_view('home/producto/tabla_resultados', $data);
        }
    }

    public function ver_producto($id) {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        //$this->template->add_js('modules/home/producto_listado.js');
        $producto = $this->producto_model->get($id);
        $producto_imagen = $this->producto_resource_model->get_producto_imagen($id);

        $data = array(
            "producto" => $producto,
            "producto_imagen" => $producto_imagen);
        $this->template->load_view('home/producto/ficha', $data);
    }

}
