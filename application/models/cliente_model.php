<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cliente_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "cliente";
    }

    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("cliente.*,usuario.email,usuario.ultimo_acceso,usuario.ip_address");
        $this->db->from($this->_table);
        $this->db->join("usuario", "cliente.usuario_id=usuario.id", 'INNER');

        if (isset($params['nombre'])) {
            // TODO: Agregar el apellido a este search
            $this->db->like('cliente.nombres', $params['nombre'], 'both');
        }
        if (isset($params['sexo'])) {
            $this->db->where('cliente.sexo', $params['sexo']);
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('cliente.id', 'asc');
            $this->db->limit($limit, $offset);
            $clientes = $this->db->get()->result();
            $this->db->flush_cache();
            return array("clientes" => $clientes, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function es_vendedor($cliente_id) {        
        $this->db->where('cliente_id', $cliente_id);
        $query = $this->db->get('vendedor');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
