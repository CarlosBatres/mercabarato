<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     * 
     */
    public function view_listado() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/clientes_listado.js");
        $this->template->load_view('admin/cliente/listado');
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
                    "usuario_id" => $user_id,
                    "nombres" => ($this->input->post('nombres') != '') ? $this->input->post('nombres') : null,
                    "apellidos" => ($this->input->post('apellidos') != '') ? $this->input->post('apellidos') : null,
                    "sexo" => ($this->input->post('sexo') != 'X') ? $this->input->post('sexo') : null,
                    "fecha_nacimiento" => ($this->input->post('fecha_nacimiento') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_nacimiento'))) : null,
                    "codigo_postal" => ($this->input->post('codigo_postal') != '') ? $this->input->post('codigo_postal') : null,
                    "direccion" => ($this->input->post('direccion') != '') ? $this->input->post('direccion') : null,
                    "telefono_fijo" => ($this->input->post('telefono_fijo') != '') ? $this->input->post('telefono_fijo') : null,
                    "telefono_movil" => ($this->input->post('telefono_movil') != '') ? $this->input->post('telefono_movil') : null,
                );

                $this->cliente_model->insert($data);
                $this->session->set_flashdata('success', 'Usuario creado con exito');
                redirect('admin/usuarios');
            } else {
                redirect('admin');
            }
        } else {
            $this->template->set_title("Panel de Administracion - Mercabarato.com");
            //$this->template->add_js("fileupload.js");
            $this->template->add_js("modules/admin/clientes.js");
            $this->template->load_view('admin/cliente/nuevo');
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
                $cliente_id = $this->input->post('id');
                $data = array(
                    "nombres" => ($this->input->post('nombres') != '') ? $this->input->post('nombres') : null,
                    "apellidos" => ($this->input->post('apellidos') != '') ? $this->input->post('apellidos') : null,
                    "sexo" => ($this->input->post('sexo') != 'X') ? $this->input->post('sexo') : null,
                    "fecha_nacimiento" => ($this->input->post('fecha_nacimiento') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_nacimiento'))) : null,
                    "codigo_postal" => ($this->input->post('codigo_postal') != '') ? $this->input->post('codigo_postal') : null,
                    "direccion" => ($this->input->post('direccion') != '') ? $this->input->post('direccion') : null,
                    "telefono_fijo" => ($this->input->post('telefono_fijo') != '') ? $this->input->post('telefono_fijo') : null,
                    "telefono_movil" => ($this->input->post('telefono_movil') != '') ? $this->input->post('telefono_movil') : null,
                );

                $this->cliente_model->update($cliente_id, $data);

                $data_usuario = array("email" => $this->input->post('email'));
                $this->usuario_model->update($this->input->post('usuario_id'), $data_usuario);

                $this->session->set_flashdata('success', 'Usuario modificado con exito');
                redirect('admin/usuarios');
            } else {
                redirect('admin');
            }
        } else {
            $cliente = $this->cliente_model->get($id);
            if ($cliente) {
                $this->template->set_title("Panel de Administracion - Mercabarato.com");
                $this->template->add_js("modules/admin/clientes.js");
                $usuario = $this->usuario_model->get($cliente->usuario_id);
                $usuario_data = array(
                    "id" => $usuario->id,
                    "email" => $usuario->email);

                $data = array(
                    "cliente" => $cliente,
                    "usuario" => $usuario_data
                );

                $this->template->load_view('admin/cliente/editar', $data);
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
            $cliente = $this->cliente_model->get($id);
            $usuario = $this->usuario_model->get($cliente->usuario_id);

            if ($usuario->id == 1 && $usuario->email === "admin@mail.com") {
                $this->session->set_flashdata('error', 'Esta cuenta de usuario <strong>admin@mail.com</strong> no se puede eliminar.');
            } else {
                $this->cliente_model->delete($id);
                $this->usuario_model->delete($cliente->usuario_id);
                $this->session->set_flashdata('success', 'Cliente/Usuario eliminado con exito.');
            }
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
            $params["excluir_admins"]=true;            
            $params["es_vendedor"]="0";
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $clientes_array = $this->cliente_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($clientes_array["total"] / $limit);
        $ent = (int) ($clientes_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($clientes_array["total"] == 0) {
            $clientes_array["clientes"] = array();
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
        $pagination=  build_paginacion($search_params);
        
        $data = array(
            "clientes" => $clientes_array["clientes"],
            "pagination"=>$pagination);

        $this->template->load_view('admin/cliente/tabla_resultados', $data);
    }

}
