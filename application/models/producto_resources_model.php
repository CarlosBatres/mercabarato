<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_resources_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table_name = "producto_resources";
    }
    
    public function get_producto_imagen($producto_id){
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where('producto_id',$producto_id);
        $this->db->where('tipo','imagen_principal');
        $result = $this->db->get();        
        
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
    
}