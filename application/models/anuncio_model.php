<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Anuncio_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "anuncio";
    }
    
    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("anuncio.*,vendedor.nombre AS Vendedor,usuario.email");
        $this->db->from($this->_table);
        $this->db->join("vendedor", "vendedor.id=anuncio.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');

        if (isset($params['titulo'])) {
            $this->db->like('anuncio.titulo', $params['titulo'], 'both');
        }        
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }
        if (isset($params['vendedor_id'])) {
            $this->db->where('anuncio.vendedor_id', $params['vendedor_id']);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('id', 'asc');
            $this->db->limit($limit, $offset);
            $anuncios = $this->db->get()->result();
            $this->db->flush_cache();
            return array("anuncios" => $anuncios, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    
    public function get_anuncio($id){
        $this->db->select("anuncio.*,vendedor.nombre as vendedor_nombre,usuario.email");
        $this->db->from($this->_table);
        $this->db->join("vendedor", "vendedor.id=anuncio.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');
        $this->db->where('anuncio.id', $id);                
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return FALSE;
        }  
    }
    
    public function get_ultimos_anuncios(){
        $this->db->select("anuncio.*");
        $this->db->from($this->_table);                
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }  
        
    }
    
    public function get_vendedor_id_del_anuncio($anuncio_id){
        $anuncio=$this->get($anuncio_id);
        if($anuncio){
            return $anuncio->vendedor_id;
        }else{
            return FALSE;
        }            
    }
}
