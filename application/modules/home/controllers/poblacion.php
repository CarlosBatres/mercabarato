<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Poblacion extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function ajax_get_poblaciones_htmlselect() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $provincia_id = $this->input->post('provincia_id');
            $poblaciones=$this->poblacion_model->get_all_by_provincia($provincia_id);            
            $html="<option value='0'>Seleccione una Poblacion</option>";
            foreach($poblaciones as $poblacion){
                $html.="<option value='".$poblacion->id."'>".$poblacion->nombre."</option>";
            }
            
            echo json_encode(array("html" => $html));
        }else{
            echo json_encode(array("html" => array()));
        }
    }

}
