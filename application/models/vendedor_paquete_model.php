<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendedor_paquete_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "vendedor_paquete";
    }
    
    /**
     * Funcion para el search del admin
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("vendedor_paquete.*,vendedor.nombre AS Vendedor,usuario.email");
        $this->db->from($this->_table);        
        $this->db->join("vendedor", "vendedor.id=vendedor_paquete.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');

        if (isset($params['nombre_empresa'])) {
            $this->db->like('vendedor.nombre', $params['nombre_empresa'], 'both');
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }
        if (isset($params['sitioweb'])) {
            $this->db->like('vendedor.sitio_web', $params['sitioweb'], 'both');
        }
        if (isset($params['actividad'])) {
            $this->db->like('vendedor.actividad', $params['actividad'], 'both');
        }

        $this->db->where("vendedor_paquete.aprobado", "0");
        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('vendedor_paquete.fecha_comprado', 'desc');
            $this->db->limit($limit, $offset);
            $vendedor_paquetes = $this->db->get()->result();
            $this->db->flush_cache();
            return array("vendedor_paquetes" => $vendedor_paquetes, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    
    /**
     * ( IMPORTANTE )
     * Funcion para aprobar un paquete de un vendedor
     * @param type $id del vendedor_paquete
     */
    public function aprobar_paquete($id) {                
        // TODO: Realizar alguna validacion adicional
        $vendedor_paquete=$this->get($id);
        $periodo=$vendedor_paquete->duracion_paquete;        
        // TODO : Validar que sea un periodo valido de meses ??
        $data = array(
            "fecha_aprobado" => date("Y-m-d"),
            "aprobado" => 1,
            "fecha_terminar" => date('Y-m-d', strtotime("+$periodo months", strtotime(date("Y-m-d"))))
        );
        $this->update($id, $data);
    }
    
    /**
     * Devuelve los paquetes de un vendedor
     * @param type $vendedor_id
     * @return boolean
     */
    public function get_paquetes_por_vendedor($vendedor_id) {
        $this->db->select("*");
        $this->db->from($this->_table);        
        $this->db->where("vendedor_id", $vendedor_id);
        $this->db->order_by('fecha_comprado','desc');
        $this->db->limit(10);        
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }
    }              
}
