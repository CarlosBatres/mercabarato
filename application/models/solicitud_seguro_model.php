<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Solicitud_seguro_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "solicitud_seguro";
    }       
         
    public function get_solicitudes_seguro($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("ss.*,cc.nombres,cc.apellidos,uc.email");
        $this->db->from("solicitud_seguro ss");        
        $this->db->join("cliente cc", "cc.id=ss.cliente_id", 'INNER');
        $this->db->join("usuario uc", "uc.id=cc.usuario_id", 'INNER');        
        
        if(isset($params["vendedor_id"])){
            $this->db->where("ss.vendedor_id",$params["vendedor_id"]);
        }
        
        if(isset($params["cliente_id"])){
            $this->db->where("ss.cliente_id",$params["cliente_id"]);
        }
        
        if(isset($params["estado"])){
            $this->db->where("ss.estado",$params["estado"]);
        }
        
        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('ss.estado asc,ss.fecha_solicitud desc');
            $this->db->limit($limit, $offset);
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("solicitud_seguros" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    
    public function get_solicitudes_seguro_cliente($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("solicitud_seguro.*,vendedor.nombre as nombre_vendedor,vendedor.unique_slug as vendedor_slug,vendedor.descripcion");
        $this->db->from("solicitud_seguro"); 
        $this->db->join("vendedor", "vendedor.id=solicitud_seguro.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');  
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');  
        
        
        if(isset($params["vendedor_id"])){
            $this->db->where("solicitud_seguro.vendedor_id",$params["vendedor_id"]);
        }
        
        if(isset($params["cliente_id"])){
            $this->db->where("solicitud_seguro.cliente_id",$params["cliente_id"]);
        }
        
        if(isset($params["estado"])){
            $this->db->where("solicitud_seguro.estado",$params["estado"]);
        }
        
        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('solicitud_seguro.estado desc,solicitud_seguro.fecha_solicitud desc');
            $this->db->limit($limit, $offset);
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("solicitud_seguros" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
}
