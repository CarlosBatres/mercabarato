<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Invitacion_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "invitacion";
    }   
    
    public function get_invitaciones_pendientes($cliente_id){
        $this->db->select("invitacion.id,invitacion.titulo,invitacion.comentario,vendedor.nombre,vendedor.descripcion");
        $this->db->from($this->_table);
        
        $this->db->join("vendedor", "vendedor.id=invitacion.vendedor_id", 'INNER');
        
        $this->db->where('invitacion.cliente_id',$cliente_id);
        $this->db->where('invitacion.from_vendedor','1');
        $this->db->where('invitacion.estado','1');
        
        $result = $this->db->get();

        if ($result->num_rows() > 0){
            return $result->result();
        }else{
            return false;
        }              
    }
    
    public function aceptar_invitacion($invitacion_id,$cliente_id){
        $invitacion=$this->get($invitacion_id);
        if($cliente_id==$invitacion->cliente_id){
            $this->update($invitacion_id,array("estado"=>"2"));            
            return true;
        }else{
            return false;
        }                
    }
    
    public function rechazar_invitacion($invitacion_id,$cliente_id){
        $invitacion=$this->get($invitacion_id);
        if($cliente_id==$invitacion->cliente_id){
            $this->update($invitacion_id,array("estado"=>"3"));            
            return true;
        }else{
            return false;
        }                
    }
    
         
}
