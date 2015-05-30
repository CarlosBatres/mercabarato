<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table_name = "producto";
    }

    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("producto.*,categoria.nombre AS Categoria,vendedor.nombre AS Vendedor");
        $this->db->from($this->table_name);
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

    public function get_site_search($params, $limit, $offset) {
        $query = "(SELECT p . * , pr.url_path imagen_nombre ";
        $query.="FROM producto p ";
        $query.="LEFT JOIN producto_resources pr ON pr.producto_id = p.id) ";

        $query.="UNION ";
        
        $query.="(SELECT p . * , pr.url_path imagen_nombre ";
        $query.="FROM producto p ";
        $query.="RIGHT JOIN producto_resources pr ON pr.producto_id = p.id) ";        
        
        $result=$this->db->query($query);
        $records = $result->result_array();
        $count = count($records);
        if ($count > 0) {
            return array("productos" => $records, "total" => 0);
        }else{
            return array("total" => 0);
        }
    }

}
