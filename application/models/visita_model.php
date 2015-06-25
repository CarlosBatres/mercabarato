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
    public function nueva_visita_producto($producto_id) {
        $user_id = $this->authentication->read('identifier');
        if ($user_id) {
            $usuario = $this->usuario_model->get_full_identidad($user_id);
            $ip_address = $this->session->userdata('ip_address');
            if (!$usuario->es_vendedor()) {
                $visita = $this->get_by(array(
                    "fecha" => date("Y-m-d"),
                    "producto_id" => $producto_id,
                    "cliente_id" => $usuario->get_cliente_id(),
                    "vista_producto" => "1"));

                if (!$visita) {
                    $data = array(
                        "producto_id" => $producto_id,
                        "cliente_id" => $usuario->get_cliente_id(),
                        "vista_anuncio" => "0",
                        "vista_producto" => "1",
                        "ip_address" => $ip_address,
                        "fecha" => date("Y-m-d")
                    );
                    $this->insert($data);
                }
            }
        }
    }

    /**
     * 
     */
    public function get_vendedors_visitas_durante($fecha_inicio, $fecha_fin ,$vendedor_id) {
        $this->db->select("visita.id,visita.fecha, COUNT(visita.id) as total");
        $this->db->from("visita");
        $this->db->join("producto", "producto.id=visita.producto_id", 'INNER');
        $this->db->where('visita.fecha >=', $fecha_inicio);
        $this->db->where('visita.fecha <=', $fecha_fin);
        $this->db->where('visita.vista_producto', "1");        
        $this->db->where('producto.vendedor_id', $vendedor_id);        
        $this->db->group_by('visita.fecha'); 

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }
    }

}
