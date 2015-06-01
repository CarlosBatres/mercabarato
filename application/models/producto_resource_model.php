<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_resource_model extends MY_Model {

    //public $belongs_to = array( 'producto' );
    public $belongs_to = array( 'producto' => array( 'model' => 'producto' ) );
    
    function __construct() {
        parent::__construct();
        $this->_table = "producto_resources";
    }
    
    public function get_producto_imagen($producto_id){
        $this->db->select('*');
        $this->db->from($this->_table);
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