<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_model extends MY_Model {

    //public $has_many = array( 'Producto_resources' );
    public $has_many = array('producto_resources' => array('model' => 'producto_resource'));

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

    public function get_site_search($params, $limit, $offset) {

        //-------------------------------------------------------

        $this->db->select("id");
        $this->db->from($this->_table);
        if (isset($params['nombre'])) {
            $this->db->like('producto.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            $this->db->where('producto.categoria_id', $params['categoria_id']);
        }        
        $q = $this->db->get(); 
        $total_count=$q->num_rows();
        
        
        //--------------------------------------------------------              
        
        $query_params = "";
        if (isset($params['nombre'])) {
            $query_params.="p.nombre LIKE '%" . $params['nombre'] . "%' ";
        }
        if (isset($params['categoria_id'])) {
            if ($query_params != "") {
                $query_params.=" AND ";
            }
            $query_params.="p.categoria_id=" . $params['categoria_id'] . " ";
        }        
        
        $query = "(SELECT p . * , pr.url_path as imagen_nombre ";
        $query.="FROM producto p ";
        $query.="LEFT JOIN producto_resources pr ON pr.producto_id = p.id";

        if ($query_params !== "") {
            $query.=" WHERE " . $query_params;
        }

        $query.=" ) UNION (";
        $query.="SELECT p . * , pr.url_path as imagen_nombre ";
        $query.="FROM producto p ";
        $query.="RIGHT JOIN producto_resources pr ON pr.producto_id = p.id ";

        if ($query_params !== "") {
            $query.=" WHERE " . $query_params;
        }

        $query.=" )";
        
        $query.=" LIMIT ".$offset.", ".$limit;

        $result = $this->db->query($query);
        $records = $result->result_array();
        $count = count($records);
        if ($count > 0) {
            return array("productos" => $records, "total" => $total_count);
        } else {
            return array("total" => 0);
        }
    }

}
