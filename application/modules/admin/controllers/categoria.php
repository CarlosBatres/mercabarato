<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categoria extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     *  Crear
     * 
     * 
     */
    public function crear($id = 0) {
        $config = array(
            'table' => 'categoria',
            'id' => 'id',
            'field' => 'slug',
            'title' => 'nombre',
            'replacement' => 'dash' // Either dash or underscore
        );
        $this->load->library('slug', $config);

        $formValues = $this->input->post();

        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "form-crear") {
                $padre_id = $this->input->post('padre_id');
                $slug = $this->slug->create_uri($this->input->post('nombre'));
                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "descripcion" => $this->input->post('descripcion'),
                    "padre_id" => $padre_id,
                    "slug" => $slug,
                    "filename" => $this->input->post('file_name')
                );

                $this->categoria_model->insert($data);
                if ($padre_id != 0) {
                    $padre = $this->categoria_model->get($padre_id);
                    redirect('admin/categoria/' . $padre->slug);
                } else {
                    redirect('admin/categorias');
                }
            } else {
                redirect('admin');
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->add_js("fileupload.js");
            $this->template->add_js("modules/admin/categorias.js");
            $this->template->load_view('admin/categoria/nuevo', array("padre_id" => $id));
        }
    }

    /**
     *  Editar
     * @param type $id
     */
    public function editar($id) {
        $config = array(
            'table' => 'categoria',
            'id' => 'id',
            'field' => 'slug',
            'title' => 'nombre',
            'replacement' => 'dash' // Either dash or underscore
        );
        $this->load->library('slug', $config);

        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "form-editar") {
                $categoria_id = $this->input->post('id');
                $padre_id = $this->input->post('padre_id');
                $slug = $this->slug->create_uri($this->input->post('nombre'), $categoria_id);
                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "descripcion" => $this->input->post('descripcion'),
                    "padre_id" => $padre_id,
                    "slug" => $slug
                );

                $this->categoria_model->update($categoria_id, $data);
                $this->session->set_flashdata('success', 'Categoria modificada con exito');
                if ($padre_id != 0) {
                    $padre = $this->categoria_model->get($padre_id);
                    redirect('admin/categoria/' . $padre->slug);
                } else {
                    redirect('admin/categorias');
                }
            } else {
                redirect('admin');
            }
        } else {
            $categoria = $this->categoria_model->get($id);
            if ($categoria) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                //$this->template->add_js("modules/admin/compradores.js");

                $data = array(
                    "categoria" => $categoria,
                );

                $this->template->load_view('admin/categoria/editar', $data);
            } else {
                redirect('');
            }
        }
    }

    /**
     * 
     */
    public function view_listado() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->add_js("modules/admin/categorias_listado.js");
        $this->template->load_view('admin/categoria/listado');
    }

    /**
     * 
     */
    public function view_listado_subcategorias($slug) {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->add_js("modules/admin/categorias_listado.js");

        $categoria = $this->categoria_model->get_by('slug', $slug);
        $subcategorias = $this->categoria_model->get_by("padre_id", $categoria->id);

        $result = $this->categoria_model->get_arbol_path($categoria->padre_id);
        $categorias_arbol = array_reverse($result);

        $data = $categorias_arbol;
        $data[] = $categoria;
        $categorias_arbol_html = $this->_build_categorias_tree($data);

        $data = array(
            "categoria" => $categoria,
            "subcategorias" => $subcategorias,
            "categorias_arbol" => $categorias_arbol,
            "categorias_arbol_html" => $categorias_arbol_html);

        $this->template->load_view('admin/categoria/listado_sub', $data);
    }

    /**
     * Borrar
     * 
     * @param type $id
     */
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            //$this->categoria_model->delete($id);
            $this->categoria_model->delete_categoria($id);
            redirect('admin/categorias');
        }
    }

    /**
     *  AJAX  Listado
     */
    public function ajax_get_listado_resultados() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            $tipo = $this->input->post('tipo');
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        if ($tipo == 'base') {
            $params["padre_id"] = 0;
        } elseif ($tipo == 'sub') {
            $params["padre_id"] = $this->input->post('categoria_id');
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $categorias_array = $this->categoria_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($categorias_array["total"] / $limit);
        $ent = (int) ($categorias_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($categorias_array["total"] == 0) {
            $categorias_array["categorias"] = array();
        }

        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $categorias_array["total"],
            "hasta" => ($pagina * $limit < $categorias_array["total"]) ? $pagina * $limit : $categorias_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);

        $pagination = build_paginacion($search_params);

        $data = array(
            "categorias" => $categorias_array["categorias"],
            "pagination" => $pagination);

        $this->template->load_view('admin/categoria/tabla_resultados', $data);
    }

    public function upload_image() {
        $this->load->config('upload', TRUE);
        $this->load->library('UploadHandler', $this->config->item('categoria', 'upload'));
    }

    private function _build_categorias_tree($categorias) {
        $html = "";
        $temp_array = $categorias;
        foreach ($categorias as $key => $categoria) {
            unset($temp_array[$key]);
            if (sizeof($categorias) == 1) {
                $class = "fa fa-circle-o";
            } else {
                $class = "fa fa-circle-thin";
            }
            $html.='<li><i class="' . $class . '"></i> <a href="' . site_url("admin/categoria") . '/' . $categoria->slug . '">' . $categoria->nombre . '</a>'
                    . '<ul>' . $this->_build_categorias_tree($temp_array) . '</ul>'
                    . '</li>';
            break;
        }
        return $html;
    }

}
