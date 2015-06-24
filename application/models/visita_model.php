<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Visita_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "visita";
    }
    
    /**
     * 
     * @param type $producto_id
     * @param type $vista_producto
     */
    public function nueva_visita($producto_id, $vista_producto) {
        $user_id = $this->authentication->read('identifier');
        if ($user_id) {
            $usuario = $this->usuario_model->get_full_identidad($user_id);
            $ip_address = $this->session->userdata('ip_address');
            if (!isset($usuario["vendedor"])) {
                $visita = $this->get_by(array("fecha" => date("Y-m-d"), "producto_id" => $producto_id, "cliente_id" => $usuario["cliente"]->id, "vista_producto" => "1"));

                if ($visita) {
                    $data = array(                        
                        "ocurrencia" => $visita->ocurrencia+1,                        
                        "ip_address" => $ip_address,                        
                    );
                    $this->update($visita->id,$data);
                    
                } else {
                    $data = array(
                        "producto_id" => $producto_id,
                        "cliente_id" => $usuario["cliente"]->id,
                        "ocurrencia" => "1",
                        "buscador" => ($vista_producto) ? "0" : "1",
                        "vista_producto" => ($vista_producto) ? "1" : "0",
                        "ip_address" => $ip_address,
                        "fecha" => date("Y-m-d")
                    );
                    $this->insert($data);
                }
            }
        }
    }

}
