<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Requisito_visitas_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "requisito_visitas";
    }

    public function cumple_todos_requisitos($oferta_general_id, $cliente_id) {        
        $grupo_oferta = $this->grupo_oferta_model->get_by(array("cliente_id" => $cliente_id, "oferta_general_id" => $oferta_general_id));

        if (!$grupo_oferta) {
            $requisitos_ids = $this->oferta_general_model->get_requisitos_ids(array("oferta_general_id" => $oferta_general_id));

            $flag = true;
            foreach ($requisitos_ids as $req) {
                $visita = $this->visita_model->get_by(array("producto_id"=>$req,"cliente_id"=>$cliente_id));
                if (!$visita) {
                    $flag = false;
                }
            }
            return $flag;
        }else{
            return false;
        }
    }

}
