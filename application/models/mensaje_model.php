<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mensaje_model extends MY_Model {

    public $before_create = array('pre_insertado');
    
    function __construct() {
        parent::__construct();
        $this->_table = "mensaje";
    }

    public function get_ultimo_mensaje($infocompra_id, $from_vendedor) {
        $this->db->select("*");
        $this->db->from("mensaje");
        $this->db->where("infocompra_id", $infocompra_id);
        if ($from_vendedor) {
            $this->db->where("enviado_por", "0");
        } else {
            $this->db->where("enviado_por", "1");
        }
        $this->db->order_by('numero desc');        
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }
    
    public function get_numero_ultimo_mensaje($infocompra_id) {
        $this->db->select("*");
        $this->db->from("mensaje");
        $this->db->where("infocompra_id", $infocompra_id);        
        $this->db->order_by('numero desc');        
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }
    
    protected function pre_insertado($mensaje) {        
        $infocompra=$this->get_numero_ultimo_mensaje($mensaje["infocompra_id"]);
        if($infocompra){
            $mensaje["numero"]=$infocompra->numero+1;
        }else{
            $mensaje["numero"]="1";
        }                
        return $mensaje;
    }
    
    public function get_mensajes($infocompra_id){
        $this->db->select("*");
        $this->db->from("mensaje");
        $this->db->where("infocompra_id", $infocompra_id);        
        $this->db->order_by('numero asc');        
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

}
