<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Provincia extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function ajax_get_provincias_htmlselect() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $pais_id = $this->input->post('pais_id');
                $provincias = $this->provincia_model->get_all_by_pais($pais_id);
                $html = "<option value='0'>Provincia</option>";
                foreach ($provincias as $provincia) {
                    $html.="<option value='" . $provincia->id . "'>" . $provincia->nombre . "</option>";
                }

                echo json_encode(array("html" => $html));
            } else {
                echo json_encode(array("html" => array()));
            }
        }
    }

}
