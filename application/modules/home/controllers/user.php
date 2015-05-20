<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    /**
     * Vista de la pagina del registro
     */
    public function view_registro() {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $this->template->add_js('registro.js');
        $paises=$this->pais_model->get_all();
        $data=array("paises"=>$paises);

        $this->template->load_view('home/registro',$data);
    }

    /**
     * Iniciar session en la pagina
     * POST-AJAX
     */
    public function login() {
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
     * Crear nuevo usuario
     * POST
     */
    public function new_user() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $password = $this->input->post('password');
            $username = $this->input->post('email');

            $user_id = $this->authentication->create_user($username, $password);

            if ($user_id !== FALSE) {
                $ip_address = $this->session->userdata('ip_address');
                $usuario = $this->usuario_model->get($user_id);
                $usuario->ip_address = $ip_address;
                $usuario->fecha_creado = date("Y-m-d H:i:s");
                $usuario->ultimo_acceso = date("Y-m-d H:i:s");
                $usuario->estado = 1;

                $this->usuario_model->update($usuario, $user_id);

                $this->authentication->login($username, $password);
                redirect(site_url());
            } else {
                // There was an ERROR creating the user
                redirect(site_url());
            }
        }
    }

}
