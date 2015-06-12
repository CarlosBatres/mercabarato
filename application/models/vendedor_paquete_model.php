<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendedor_paquete_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "vendedor_paquete";
    }
    
    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("vendedor_paquete.*,vendedor.nombre AS Vendedor,usuario.email,paquete.nombre as nombre_paquete");
        $this->db->from($this->_table);
        $this->db->join("paquete", "paquete.id=vendedor_paquete.paquete_id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=vendedor_paquete.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');        

        if (isset($params['nombre_empresa'])) {
            $this->db->like('vendedor.nombre', $params['nombre_empresa'], 'both');
        }        
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }
        
        $this->db->where("vendedor_paquete.aprobado","0");
        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('id', 'asc');
            $this->db->limit($limit, $offset);
            $vendedor_paquetes = $this->db->get()->result();
            $this->db->flush_cache();
            return array("vendedor_paquetes" => $vendedor_paquetes, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    
    public function aprobar_paquete($id){
        $data=array(
            "fecha_aprobado"=>date("Y-m-d"),
            "aprobado"=>1,
            "fecha_terminar"=>date("Y-m-d")
        );
        // TODO: Calcular fecha_terminar antes de hacer el update en base a duracion en meses
        
        $this->update($id, $data);        
    }
    
    public function get_paquetes_por_vendedor($vendedor_id){
        $this->db->select("vendedor_paquete.*,paquete.nombre as nombre_paquete,paquete.descripcion as descripcion_paquete");
        $this->db->from($this->_table);
        $this->db->join("paquete", "paquete.id=vendedor_paquete.paquete_id", 'INNER');
        $this->db->where("vendedor_paquete.vendedor_id",$vendedor_id);
        $this->db->where("vendedor_paquete.aprobado",0);
        $this->db->limit(10);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }         
    }
}