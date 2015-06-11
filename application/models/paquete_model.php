<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Paquete_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "paquete";
    }
    
    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("paquete.*");
        $this->db->from($this->_table);        

        if (isset($params['nombre'])) {
            $this->db->like('paquete.nombre', $params['nombre'], 'both');
        }               

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('id', 'asc');
            $this->db->limit($limit, $offset);
            $paquetes = $this->db->get()->result();
            $this->db->flush_cache();
            return array("paquetes" => $paquetes, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    
    public function get_paquetes(){
        $this->db->select("*");
        $this->db->from("paquete");
        $this->db->where("mostrar",1);
        $this->db->where("activo",1);
        $this->db->order_by('orden', 'asc');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }
    
    public function validar_paquete($id){
        $this->db->select("*");
        $this->db->from("paquete");
        $this->db->where("mostrar",1);
        $this->db->where("activo",1);
        $this->db->where("id",$id);        
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}