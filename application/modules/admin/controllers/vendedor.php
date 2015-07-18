<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendedor extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     * 
     */
    public function view_listado() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/vendedores_listado.js");

        $user_id = $this->authentication->read('identifier');
        $restriccion = $this->restriccion_model->get_by("usuario_id", $user_id);
        $data = array();
        if ($restriccion) {
            if ($restriccion->pais_id != null) {
                $data["pais"] = $this->pais_model->get($restriccion->pais_id);
            } else {
                $data["pais"] = false;
            }
            if ($restriccion->provincia_id != null) {
                $data["provincia"] = $this->provincia_model->get($restriccion->provincia_id);
            } else {
                $data["provincia"] = false;
            }
            if ($restriccion->poblacion_id != null) {
                $data["poblacion"] = $this->poblacion_model->get($restriccion->poblacion_id);
            } else {
                $data["poblacion"] = false;
            }
        }else{
            $data["pais"] = false;
        }


        $this->template->load_view('admin/vendedor/listado', $data);
    }

    /**
     *  Crear
     * 
     * 
     */
    public function crear() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "form-crear") {
                $user_id = $this->authentication->create_user($this->input->post('email'), $this->input->post('password'));

                if ($user_id !== FALSE) {
                    $ip_address = $this->session->userdata('ip_address');
                    $usuario = $this->usuario_model->get($user_id);
                    $usuario->ip_address = $ip_address;
                    $usuario->fecha_creado = date("Y-m-d H:i:s");
                    $usuario->ultimo_acceso = date("Y-m-d H:i:s");
                    $usuario->activo = 1;
                    //$usuario->is_admin = 0;

                    $this->usuario_model->update($user_id, $usuario);
                }

                $data = array(
                    "direccion" => $this->input->post('direccion'),
                    "telefono_fijo" => $this->input->post('telefono_fijo'),
                    "telefono_movil" => $this->input->post('telefono_movil'),
                    "usuario_id" => $user_id,
                );

                $cliente_id = $this->cliente_model->insert($data);

                $data_vendedor = array(
                    "nombre" => $this->input->post('nombre_empresa'),
                    "descripcion" => $this->input->post('descripcion'),
                    "actividad" => $this->input->post('actividad'),
                    "sitio_web" => $this->input->post('sitio_web'),
                    "cliente_id" => $cliente_id
                );

                $this->vendedor_model->insert($data_vendedor);

                redirect('admin/vendedores');
            } else {
                redirect('admin');
            }
        } else {
            $this->template->set_title("Panel de Administracion - Mercabarato.com");
            //$this->template->add_js("fileupload.js");
            $this->template->add_js("modules/admin/vendedores.js");
            $this->template->load_view('admin/vendedor/nuevo');
        }
    }

    /**
     *  Editar
     * @param type $id
     */
    public function editar($id) {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "form-editar") {
                $vendedor_id = $this->input->post('id');
                $vendedor = $this->vendedor_model->get_vendedor($vendedor_id);

                $data = array(
                    "nombre" => $this->input->post('nombre_empresa'),
                    "descripcion" => $this->input->post('descripcion'),
                    "actividad" => $this->input->post('actividad'),
                    "sitio_web" => $this->input->post('sitio_web'),
                );

                $this->vendedor_model->update($vendedor_id, $data);

                $data_cliente = array(
                    "telefono_fijo" => $this->input->post('telefono_fijo'),
                    "telefono_movil" => $this->input->post('telefono_movil'),
                    "direccion" => $this->input->post('direccion'),
                );

                $this->cliente_model->update($vendedor->cliente_id, $data_cliente);

                if ($this->input->post('email') != $vendedor->email) {
                    $data_usuario = array("email" => $this->input->post('email'));
                    $this->usuario_model->update($vendedor->usuario_id, $data_usuario);
                }

                $this->session->set_flashdata('success', 'Vendedor modificado con exito');
                redirect('admin/vendedores');
            } else {
                redirect('admin');
            }
        } else {
            $vendedor = $this->vendedor_model->get_vendedor($id);
            if ($vendedor) {
                $this->template->set_title("Panel de Administracion - Mercabarato.com");
                //$this->template->add_js("modules/admin/vendedores.js");                
                $this->template->load_view('admin/vendedor/editar', array("vendedor" => $vendedor));
            } else {
                redirect('admin');
            }
        }
    }

    /**
     * Borrar
     * 
     * @param type $id
     */
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            $vendedor = $this->vendedor_model->get($id);
            $this->vendedor_model->delete($id);
            $this->usuario_model->delete($vendedor->usuario_id);
            redirect('admin/vendedores');
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
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            if ($this->input->post('actividad') != "No Especificada") {
                $params["actividad"] = $this->input->post('actividad');
            }
            if ($this->input->post('sitio_web') != "") {
                $params["sitio_web"] = $this->input->post('sitio_web');
            }

            $user_id = $this->authentication->read('identifier');
            $restriccion = $this->restriccion_model->get_by("usuario_id", $user_id);
            if ($restriccion) {
                if ($restriccion->pais_id != null) {
                    $params["pais_id"] = $restriccion->pais_id;
                }
                if ($restriccion->provincia_id != null) {
                    unset($params["pais_id"]);
                    $params["provincia_id"] = $restriccion->provincia_id;
                }
                if ($restriccion->poblacion_id != null) {
                    unset($params["pais_id"]);
                    unset($params["provincia_id"]);
                    $params["poblacion_id"] = $restriccion->poblacion_id;
                }
            }


            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $vendedores_array = $this->vendedor_model->get_admin_search($params, $limit, $offset);
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

        $this->template->load_view('admin/vendedor/tabla_resultados', $data);
    }

    /**
     * 
     */
    public function autocomplete() {
        if ($this->input->is_ajax_request()) {
            $query = $this->input->get('query');
            $vendedores = $this->vendedor_model->get_by_nombre($query);
            if (!$vendedores) {
                $data = array();
            } else {
                $data = array();
                foreach ($vendedores as $vendedor) {
                    $data[] = array("value" => $vendedor->nombre, "data" => $vendedor->id);
                }
            }
            echo json_encode(array("suggestions" => $data));
        }
    }

    /**
     * 
     */
    public function view_listado_control() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        //$this->template->add_js("modules/admin/vendedores_listado.js");
        $this->template->load_view('admin/vendedor/listado_control');
    }

}
