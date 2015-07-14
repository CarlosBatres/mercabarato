<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producto extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function view_principal() {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $this->template->add_js('modules/home/producto_principal_listado.js');
        $subcategorias = $this->categoria_model->get_categorias_searchbar(0);
        $subcategorias_html = $this->_build_categorias_searchparams($subcategorias);
        $precios = precios_options();
        $paises = $this->pais_model->get_all();

        if ($this->authentication->is_loggedin()) {
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $anuncios = $this->anuncio_model->get_anuncios_para_cliente($cliente->id);
        } else {
            $anuncios = $this->anuncio_model->get_ultimos_anuncios();
        }

        if (!$anuncios) {
            $anuncios = array();
        }

        $search_query = $this->session->userdata('search_query');
        $this->session->unset_userdata('search_query');

        $data = array(
            "productos" => array(),
            "anuncios" => $anuncios,
            "precios" => $precios,
            "subcategorias" => $subcategorias_html,
            "paises" => $paises,
            "search_query" => $search_query);

        $this->template->load_view('home/producto/listado_principal', $data);
    }

    public function buscar_producto($search_query) {
        $this->session->unset_userdata('search_query');
        $query = urldecode($search_query);
        $this->session->set_userdata(array('search_query' => $query));
        redirect('');
    }

    /**
     *  AJAX Productos / Listado
     */
    public function ajax_get_listado_resultados() {
        if ($this->input->is_ajax_request()) {
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
                if ($this->input->post('precio_tipo1') !== "0") {
                    $params["precio_tipo1"] = $this->input->post('precio_tipo1');
                }
                if ($this->input->post('problacion') !== "0") {
                    $params["problacion"] = $this->input->post('problacion');
                }
                if ($this->input->post('provincia') !== "0") {
                    $params["provincia"] = $this->input->post('provincia');
                }
                if ($this->input->post('pais') !== "0") {
                    $params["pais"] = $this->input->post('pais');
                }

                if ($this->authentication->is_loggedin()) {
                    $user_id = $this->authentication->read('identifier');
                    $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
                    if ($cliente->es_vendedor == '0') {
                        $params["cliente_id"] = $cliente->id;
                    }
                }

                $params["habilitado"] = "1";
                $params["mostrar_producto"] = "1";

                if ($this->input->post('alt_layout')) {
                    $alt_layout = true;
                } else {
                    $alt_layout = false;
                }


                $pagina = $this->input->post('pagina');

                $limit = $this->config->item("principal_default_per_page");
                $offset = $limit * ($pagina - 1);
                $productos = $this->producto_model->get_site_search($params, $limit, $offset, "p.id", "ASC");
                $flt = (float) ($productos["total"] / $limit);
                $ent = (int) ($productos["total"] / $limit);
                if ($flt > $ent || $flt < $ent) {
                    $paginas = $ent + 1;
                } else {
                    $paginas = $ent;
                }

                if ($productos["total"] == 0) {
                    $productos["productos"] = array();
                }

                $search_params = array(
                    "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                    "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                    "pagina" => $pagina,
                    "total_paginas" => $paginas,
                    "por_pagina" => $limit,
                    "total" => $productos["total"],
                    "hasta" => ($pagina * $limit < $productos["total"]) ? $pagina * $limit : $productos["total"],
                    "desde" => (($pagina * $limit) - $limit) + 1);

                $pagination = build_paginacion($search_params);
                $data = array(
                    "productos" => $productos["productos"],
                    "pagination" => $pagination);

                if ($alt_layout) {
                    $this->template->load_view('home/producto/tabla_resultados_principal', $data);
                } else {
                    $this->template->load_view('home/producto/tabla_resultados', $data);
                }
            }
        } else {
            redirect('');
        }
    }

    /**
     * 
     * @param type $id
     */
    public function ver_producto($slug) {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $producto = $this->producto_model->get_by("unique_slug", $slug);
        if ($producto) {
            $producto_imagen = $this->producto_resource_model->get_producto_imagen($producto->id);

            if ($this->authentication->is_loggedin()) {
                $this->visita_model->nueva_visita_producto($producto->id);
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
                $producto_tarifa = $this->producto_model->get_tarifas_from_producto($producto->id, $cliente->id);
                if ($producto_tarifa) {
                    $tarifa = $producto_tarifa->tarifa_costo;
                } else {
                    $tarifa = false;
                }
                $data = array(
                    "producto" => $producto,
                    "producto_imagen" => $producto_imagen,
                    "tarifa" => $tarifa);
                $this->template->load_view('home/producto/ficha', $data);
            } else {
                if ($producto->mostrar_producto == 1) {
                    $tarifa = false;

                    $data = array(
                        "producto" => $producto,
                        "producto_imagen" => $producto_imagen,
                        "tarifa" => $tarifa);
                    $this->template->load_view('home/producto/ficha', $data);
                } else {
                    redirect('404');
                }
            }
        } else {
            redirect('404');
        }
    }

    /**
     * 
     * @param type $categorias
     * @return string|boolean
     */
    private function _build_categorias_searchparams($categorias) {
        if (!empty($categorias)) {
            $html = "";
            foreach ($categorias as $categoria) {
                $texto = fix_category_text($categoria['nombre']);
                if (isset($categoria['subcategorias'])) {
                    $html.='<li class="seleccion_categoria">';
                    $html.='<a href="" data-id="' . $categoria['id'] . '">' . $texto;
                    if ($categoria['padre_id'] == '0') {
                        $html.='<span class="caret arrow"></span></a>';
                    } else {
                        $html.='<span class="caret arrow"></span></a>';
                    }

                    $res_html = $this->_build_categorias_searchparams($categoria['subcategorias']);
                    $html.='<ul class="nav nav-pills nav-stacked nav-sub-level">';
                    $html.=$res_html;
                    $html.='</ul>';
                } else {
                    $html.='<li class="seleccion_categoria final">';
                    $html.='<a href="" data-id="' . $categoria['id'] . '">' . $texto;
                    $html.='</a>';
                }
                $html.='</li>';
            }
            return $html;
        } else {
            return false;
        }
    }

}
