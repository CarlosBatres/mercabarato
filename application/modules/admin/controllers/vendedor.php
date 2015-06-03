<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendedor extends MY_Controller {

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
        $this->template->add_js("modules/admin/vendedores_listado.js");
        $this->template->load_view('admin/vendedor/listado');
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
                    "descripcion" => $this->input->post('descripcion'),
                    "actividad" => $this->input->post('actividad'),                    
                    "codigo_postal" => $this->input->post('postal'),
                    "telefono1" => $this->input->post('telefono_principal'),
                    "telefono2" => $this->input->post('telefono_secundario'),
                    "sitioweb" => $this->input->post('sitio_web'),
                    "usuario_id" => $user_id,                    
                );

                $this->vendedor_model->insert($data);
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
                $data = array(
                    "nombre" => $this->input->post('nombre'),
                    "descripcion" => $this->input->post('descripcion'),
                    "actividad" => $this->input->post('actividad'),                    
                    "codigo_postal" => $this->input->post('postal'),
                    "telefono1" => $this->input->post('telefono_principal'),
                    "telefono2" => $this->input->post('telefono_secundario'),
                    "sitioweb" => $this->input->post('sitio_web'),                    
                );

                $this->vendedor_model->update($vendedor_id, $data);               
                
                $data_usuario=array("email"=>$this->input->post('email'));                
                $this->usuario_model->update($this->input->post('usuario_id'),$data_usuario);

                $this->session->set_flashdata('success', 'Comprador modificado con exito');
                redirect('admin/vendedores');
            } else {
                redirect('admin');
            }
        } else {
            $vendedor = $this->vendedor_model->get($id);
            if ($vendedor) {
                $this->template->set_title("Panel de Administracion - Mercabarato.com");
                //$this->template->add_js("modules/admin/vendedores.js");
                $usuario = $this->usuario_model->get($vendedor->usuario_id);
                $usuario_data = array(
                    "id"=>$usuario->id,
                    "email" => $usuario->email);

                $data = array(
                    "vendedor" => $vendedor,
                    "usuario" => $usuario_data
                );

                $this->template->load_view('admin/vendedor/editar', $data);
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
            if ($this->input->post('sitioweb') != "") {
                $params["sitioweb"] = $this->input->post('sitioweb');
            }
            if ($this->input->post('telefono1') != "") {
                $params["telefono1"] = $this->input->post('telefono1');
            }
            if ($this->input->post('codigo_postal') != "") {
                $params["codigo_postal"] = $this->input->post('codigo_postal');
            }
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = 15;
        $offset = $limit * ($pagina - 1);
        $vendedores_array = $this->vendedor_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($vendedores_array["total"] / $limit);
        $ent = (int) ($vendedores_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }
        // TODO: Falta testear mas

        if ($vendedores_array["total"] == 0) {
            $vendedores_array["vendedores"] = array();
            // TODO: Resultados vacio
        }
        $data = array(
            "vendedores" => $vendedores_array["vendedores"],
            "search_params" => array(
                "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina" => $limit,
                "total" => $vendedores_array["total"],
                "hasta" => ($pagina * $limit < $vendedores_array["total"]) ? $pagina * $limit : $vendedores_array["total"],
                "desde" => (($pagina * $limit) - $limit) + 1));

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

}
