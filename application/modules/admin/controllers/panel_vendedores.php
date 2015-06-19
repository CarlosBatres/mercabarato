<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     * 
     */
    public function resumen() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);

        $mis_productos = $this->producto_model->get_many_by("vendedor_id", $vendedor["vendedor"]->id);
        $mis_anuncios = $this->anuncio_model->get_many_by("vendedor_id", $vendedor["vendedor"]->id);

        $data = array(
            "mis_productos" => sizeof($mis_productos),
            "mis_anuncios" => sizeof($mis_anuncios)
        );

        $this->template->load_view('admin/panel_vendedores/resumen', $data);
    }

    /**
     * LOGIN al panel de vendedores
     */
    public function login() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $password = $this->input->post('password');
            $username = $this->input->post('email');
            // LOGOUT por si estaba en el sitio principal
            $this->authentication->logout();

            if ($this->authentication->login($username, $password, false)) {
                $ip_address = $this->session->userdata('ip_address');
                $user_id = $this->authentication->read('identifier');
                $usuario = $this->usuario_model->get($user_id);
                $usuario->ip_address = $ip_address;
                $usuario->ultimo_acceso = date("Y-m-d H:i:s");

                $this->usuario_model->update($user_id, $usuario);
                $this->session->set_userdata(array('one_time_login' => true));
                redirect('panel_vendedor');
            } else {
                redirect('panel_vendedor/login');
            }
        } else {
            $this->template->set_layout('login_page');
            $this->template->load_view('admin/panel_vendedores/login');
        }
    }

    /**
     * 
     */
    public function logout() {
        $this->authentication->logout();
        redirect('');
    }

    /**
     * 
     */
    public function upload_image() {
        $this->load->config('upload', TRUE);
        $this->load->library('UploadHandler', $this->config->item('producto', 'upload'));
    }

    /**
     *  Esto es un hack para evitar un problema con el menu.
     */
    public function regresar() {
        redirect('');
    }

}
