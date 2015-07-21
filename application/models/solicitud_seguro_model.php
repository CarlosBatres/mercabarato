<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Solicitud_seguro_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "solicitud_seguro";
    }       
         
    public function get_solicitudes_seguro($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("solicitud_seguro.*,cliente.nombres,cliente.apellidos,usuario.email");
        $this->db->from($this->_table);        
        $this->db->join("cliente", "cliente.id=solicitud_seguro.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');
        
        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('solicitud_seguro.fecha_solicitud', 'desc');
            $this->db->limit($limit, $offset);
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("solicitud_seguros" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
}
