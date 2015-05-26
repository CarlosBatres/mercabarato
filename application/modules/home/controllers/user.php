<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {

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

        $this->template->load_view('home/user/registro', $data);
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

                    $this->usuario_model->update($usuario, $user_id);
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

}
