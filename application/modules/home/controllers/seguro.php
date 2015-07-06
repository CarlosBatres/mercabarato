<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seguro extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function view_seguros() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            //$this->template->add_js('modules/home/perfil.js');
            $data = array();
            $this->template->load_view('home/seguro/formulario', $data);
        } else {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $this->template->load_view('home/login_necesario');
        }
    }

}
