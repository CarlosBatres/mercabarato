<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_model extends MY_Model {

    public $has_many = array('producto_resources' => array('model' => 'producto_resource_model', 'primary_key' => 'producto_id'));

    function __construct() {
        parent::__construct();
        $this->_table = "producto";
    }

    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("producto.*,categoria.nombre AS Categoria,vendedor.nombre AS Vendedor");
        $this->db->from($this->_table);
        $this->db->join("categoria", "categoria.id=producto.categoria_id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=producto.vendedor_id", 'INNER');

        if (isset($params['nombre'])) {
            $this->db->like('producto.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            $this->db->where('producto.categoria_id', $params['categoria_id']);
        }
        if (isset($params['vendedor'])) {
            $this->db->like('vendedor.nombre', $params['vendedor'], 'both');
        }


        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('id', 'asc');
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            return array("productos" => $productos, "total" => $count);
        } else {
            return array("total" => 0);
        }
    }

    public function get_site_search($params, $limit, $offset, $order_by, $order) {
        $this->db->start_cache();
        $this->db->select('p.*,pr.url_path as imagen_nombre');
        $this->db->from('producto p');
        $this->db->join('producto_resources pr', 'pr.producto_id = p.id AND pr.tipo="imagen_principal"', 'left');

        if (isset($params['nombre'])) {
            $this->db->like('p.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            $this->db->where('p.categoria_id', $params['categoria_id']);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by($order_by, $order);
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            return array("productos" => $productos, "total" => $count);
        } else {
            return array("total" => 0);
        } 
    }
    
}
