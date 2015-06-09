<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Vista de la pagina del registro
     */
    public function view_registro() {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $this->template->add_js('modules/home/registro.js');
        $paises = $this->pais_model->get_all();
        $data = array("paises" => $paises);

        $this->template->load_view('home/usuario/registro', $data);
    }

    public function view_perfil() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $usuario = $this->usuario_model->get($user_id);
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            $this->template->load_view('home/usuario/perfil', array(
                "usuario" => $usuario,
                "cliente" => $cliente));
        } else {
            redirect('');
        }
    }

    public function view_password() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $this->template->load_view('home/usuario/cambio_password');
        } else {
            redirect('');
        }
    }

    public function modificar() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "form-editar") {
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

                $data = array(
                    "nombres" => $this->input->post('nombres'),
                    "apellidos" => $this->input->post('apellidos'),
                    "sexo" => $this->input->post('sexo'),
                    "fecha_nacimiento" => date("Y-m-d", strtotime($this->input->post('fecha_nacimiento'))),
                    "codigo_postal" => $this->input->post('codigo_postal'),
                    "direccion" => $this->input->post('direccion'),
                    "telefono_fijo" => $this->input->post('telefono_fijo'),
                    "telefono_movil" => $this->input->post('telefono_movil')
                );

                $this->cliente_model->update($cliente->id, $data);

                $this->session->set_flashdata('success', 'Tus datos han sido modificados con exito.');
            }
            redirect('usuario/perfil');
        } else {
            redirect('usuario/perfil');
        }
    }
    
    public function modificar_password(){
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "form-editar") {
                $user_id = $this->authentication->read('identifier');
                $usuario = $this->usuario_model->get($user_id);                
                                
                $password_old=$this->input->post('password_old');
                $password_new=$this->input->post('password_1');
                                
                if(md5($password_old)==$usuario->password){
                    $this->authentication->change_password($password_new);
                    $this->session->set_flashdata('success', 'Tus contraseña se ha modificado con exito.');
                }else{
                    $this->session->set_flashdata('error', 'La contraseña es incorrecta.');
                }                                
            }
            redirect('usuario/password');
        } else {
            redirect('usuario/password');
        }
    }

    /**
     * Iniciar session en la pagina
     * POST-AJAX
     */
    public function login() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $password = $this->input->post('password');
                $username = $this->input->post('email');

                if ($this->authentication->login($username, $password)) {
                    $ip_address = $this->session->userdata('ip_address');
                    $user_id = $this->authentication->read('identifier');
                    $usuario = $this->usuario_model->get($user_id);
                    $usuario->ip_address = $ip_address;
                    $usuario->ultimo_acceso = date("Y-m-d H:i:s");

                    $this->usuario_model->update($user_id, $usuario);
                    echo json_encode(array("success" => "true", "url" => site_url()));
                } else {
                    echo json_encode(array("success" => "false"));
                }
            }
        } else {
            redirect('');
        }
    }

    /**
     * Cerrar la sesion actual
     * 
     */
    public function logout() {
        $this->authentication->logout();
        redirect('');
    }

    /**
     *  Verificar que el email no exista 
     *  AJAX Call
     */
    public function check_email() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                if ($this->usuario_model->email_exists($this->input->post('email')) == TRUE) {
                    echo json_encode(FALSE);
                } else {
                    echo json_encode(TRUE);
                }
            }
        } else {
            redirect('404');
        }
    }

}
