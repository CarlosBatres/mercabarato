<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_resource_model extends MY_Model {

    public $belongs_to = array('producto' => array('model' => 'producto_model'));

    function __construct() {
        parent::__construct();
        $this->_table = "producto_resource";
    }

    public function get_producto_imagen($producto_id) {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('producto_id', $producto_id);
        $this->db->where('tipo', 'imagen_principal');
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
    
    public function get_producto_imagenes($producto_id,$limit=3) {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('producto_id', $producto_id);
        $this->db->where('(tipo="imagen_principal" OR tipo="imagen_alternativas")');
        $this->db->order_by('orden','asc');
        $this->db->limit($limit,'0');
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function cleanup_resources($producto_id) {
        $resources = $this->get_many_by("producto_id",$producto_id);
        foreach ($resources as $resource) {
            if ($resource->tipo == "imagen_principal") {
                unlink('./assets/'.$this->config->item('productos_img_path').'/'.$resource->filename);
                unlink('./assets/'.$this->config->item('productos_img_path').'/thumbnail/'.$resource->filename);
            }else if($resource->tipo == "imagen_alternativas"){
                unlink('./assets/'.$this->config->item('productos_img_path').'/'.$resource->filename);
                unlink('./assets/'.$this->config->item('productos_img_path').'/thumbnail/'.$resource->filename);
            }
        }
        $this->delete_by("producto_id",$producto_id);
    }

}
