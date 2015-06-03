<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Comprador_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "comprador";
    }
        
    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("comprador.*,usuario.email,usuario.ultimo_acceso,usuario.ip_address");
        $this->db->from($this->_table);
        $this->db->join("usuario", "comprador.usuario_id=usuario.id", 'INNER');        

        if (isset($params['nombre'])) {
            $this->db->like('comprador.nombre', $params['nombre'], 'both');
        }        
        if (isset($params['sexo'])) {
            $this->db->where('comprador.sexo', $params['sexo']);
        }        
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'] ,'both');
        } 

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('comprador.id', 'asc');
            $this->db->limit($limit, $offset);
            $compradores = $this->db->get()->result();
            return array("compradores" => $compradores, "total" => $count);
        } else {
            return array("total" => 0);
        }
    }

}

