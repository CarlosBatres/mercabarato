<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function view_login() {
        $this->template->set_layout('login_page');
        $this->template->load_view('admin/login/login');
    }

    public function login() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $password = $this->input->post('password');
            $username = $this->input->post('email');

            if ($this->authentication->login($username, $password, true)) {
                $ip_address = $this->session->userdata('ip_address');
                $user_id = $this->authentication->read('identifier');
                $usuario = $this->usuario_model->get($user_id);
                $usuario->ip_address = $ip_address;
                $usuario->ultimo_acceso = date("Y-m-d H:i:s");

                $this->usuario_model->update($user_id,$usuario);
                redirect('admin');
            } else {
                redirect('admin/login');
            }
        }
    }
    
    public function logout() {
        $this->authentication->logout();
        redirect('admin/login');
    }

    public function sin_permiso() {
        $this->template->set_layout('login_page');
        $this->template->load_view('admin/login/sin_permiso');
    }

}
