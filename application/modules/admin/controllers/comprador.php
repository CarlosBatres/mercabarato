<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comprador extends MY_Controller {

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
     * 
     */
    public function view_listado() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/compradores_listado.js");
        $this->template->load_view('admin/comprador/listado');
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
                    $usuario->estado = 1;
                    $usuario->is_admin = 0;

                    $this->usuario_model->update($user_id, $usuario);
                }

                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "apellidos" => $this->input->post('apellidos'),
                    "sexo" => $this->input->post('sexo'),
                    "usuario_id" => $user_id
                );

                $this->comprador_model->insert($data);
                redirect('admin/compradores');
            } else {
                redirect('admin');
            }
        } else {
            $this->template->set_title("Panel de Administracion - Mercabarato.com");
            //$this->template->add_js("fileupload.js");
            $this->template->add_js("modules/admin/comprador.js");
            $this->template->load_view('admin/comprador/nuevo');
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
                $comprador_id = $this->input->post('id');
                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "apellidos" => $this->input->post('apellidos'),
                    "sexo" => $this->input->post('sexo'),                    
                );

                $this->comprador_model->update($comprador_id, $data);               
                
                $data_usuario=array("email"=>$this->input->post('email'));                
                $this->usuario_model->update($this->input->post('usuario_id'),$data_usuario);

                $this->session->set_flashdata('success', 'Comprador modificado con exito');
                redirect('admin/compradores');
            } else {
                redirect('admin');
            }
        } else {
            $comprador = $this->comprador_model->get($id);
            if ($comprador) {
                $this->template->set_title("Panel de Administracion - Mercabarato.com");
                //$this->template->add_js("modules/admin/productos.js");
                $usuario = $this->usuario_model->get($comprador->usuario_id);
                $usuario_data = array(
                    "id"=>$usuario->id,
                    "email" => $usuario->email);

                $data = array(
                    "comprador" => $comprador,
                    "usuario" => $usuario_data
                );

                $this->template->load_view('admin/comprador/editar', $data);
            } else {
                //TODO : No se encuentra el producto
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
            $comprador = $this->comprador_model->get($id);
            $this->comprador_model->delete($id);
            $this->usuario_model->delete($comprador->usuario_id);
            redirect('admin/compradores');
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
            if ($this->input->post('sexo') != 'X') {
                $params["sexo"] = $this->input->post('sexo');
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = 15;
        $offset = $limit * ($pagina - 1);
        $compradores_array = $this->comprador_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($compradores_array["total"] / $limit);
        $ent = (int) ($compradores_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }
        // TODO: Falta testear mas

        if ($compradores_array["total"] == 0) {
            $compradores_array["compradores"] = array();
            // TODO: Resultados vacio
        }
        $data = array(
            "compradores" => $compradores_array["compradores"],
            "search_params" => array(
                "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina" => $limit,
                "total" => $compradores_array["total"],
                "hasta" => ($pagina * $limit < $compradores_array["total"]) ? $pagina * $limit : $compradores_array["total"],
                "desde" => (($pagina * $limit) - $limit) + 1));

        $this->template->load_view('admin/comprador/tabla_resultados', $data);
    }

}
