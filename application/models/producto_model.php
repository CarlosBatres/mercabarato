<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table_name = "producto";
    }

    public function get_admin_search($nombre, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("producto.*,categoria.nombre AS Categoria,vendedor.nombre AS Vendedor");
        $this->db->from($this->table_name);
        $this->db->join("categoria", "categoria.id=producto.categoria_id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=producto.vendedor_id", 'INNER');
        $this->db->like('producto.nombre', $nombre);
        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            return array("productos"=>$productos,"total"=>$count);
        } else {
            return array("total"=>0);
        }
    }

}
