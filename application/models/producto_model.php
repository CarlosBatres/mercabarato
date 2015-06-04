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
            $this->db->flush_cache();
            return array("productos" => $productos, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function get_site_search($params, $limit, $offset, $order_by, $order) {
        if (isset($params['categoria_general'])) {
            $array=$this->get_categorias($params['categoria_general']);            
            
        }        
        
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
        if (isset($params['categoria_general'])) {
           // $array=$this->get_categorias_de($params['categoria_general']);
           // $this->db->where_in('p.categoria_id', $array);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by($order_by, $order);
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            $this->db->flush_cache();
            return array("productos" => $productos, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        } 
    }
    
    public function get_categorias($id){
        $this->db->select('*');
        $this->db->from('categoria');
        $this->db->where('padre_id', $id);
        $categorias = $this->db->get()->result_array();
        
        if($categorias){
            foreach($categorias as $key=>$value){
                $res=$this->get_categorias($value['id']);
                if($res){
                    $categorias[$key]['subcategorias']=$res;
                }
            }
            return $categorias;
        }else{
            return false;
        }
    }
    
}
