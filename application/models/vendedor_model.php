<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendedor_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "vendedor";
    }

    function get_by_nombre($nombre) {
        $limit = 10;
        $this->db->select('id,nombre');
        $this->db->from($this->_table);
        $this->db->like('nombre', $nombre, 'both');
        $this->db->limit($limit);

        $vendedores = $this->db->get()->result();

        if (sizeof($vendedores) > 0) {
            return $vendedores;
        } else {
            return false;
        }
    }

    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("vendedor.*,usuario.email,usuario.ultimo_acceso,usuario.ip_address");
        $this->db->from($this->_table);
        $this->db->join("usuario", "vendedor.usuario_id=usuario.id", 'INNER');

        if (isset($params['nombre'])) {
            $this->db->like('vendedor.nombre', $params['nombre'], 'both');
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }
        if (isset($params['actividad'])) {
            $this->db->like('vendedor.actividad', $params['actividad'], 'both');
        }
        if (isset($params['sitioweb'])) {
            $this->db->like('vendedor.sitioweb', $params['sitioweb'], 'both');
        }
        if (isset($params['telefono1'])) {
            $this->db->where('vendedor.telefono1', $params['telefono1']);
        }
        if (isset($params['telefono2'])) {
            $this->db->where('vendedor.telefono2', $params['telefono2']);
        }
        if (isset($params['codigo_postal'])) {
            $this->db->where('vendedor.codigo_postal', $params['codigo_postal']);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('vendedor.id', 'asc');
            $this->db->limit($limit, $offset);
            $vendedores = $this->db->get()->result();
            return array("vendedores" => $vendedores, "total" => $count);
        } else {
            return array("total" => 0);
        }
    }

}
