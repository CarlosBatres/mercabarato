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
