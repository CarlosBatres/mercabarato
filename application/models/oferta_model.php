<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Oferta_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "oferta";
    }  
    
    /**
     * Devuelve los clientes que ya tienen ofertas en base a un array de productos.
     * @param type $producto_ids
     */
    public function get_clientes_for_productos($producto_ids) {
        $this->db->select("grupo_oferta.cliente_id");
        $this->db->from("grupo_oferta");                
        $this->db->join("oferta", "oferta.oferta_general_id=grupo_oferta.oferta_general_id", 'INNER');
        $this->db->join("oferta_general", "oferta_general.id=oferta.oferta_general_id", 'INNER');
        
        $this->db->where_in("oferta.producto_id", $producto_ids);
        $this->db->where("oferta_general.fecha_finaliza >", date("Y-m-d"));
        
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $clientes=$result->result();
            $array=array();
            foreach($clientes as $cliente){
                $array[]=$cliente->cliente_id;
            }
            return $array;
        } else {
            return false;
        }
    }
    
    public function get_ofertas_detalles($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("oferta.id,producto.precio as viejo_costo,oferta.nuevo_costo,oferta.descripcion,COUNT(grupo_oferta.grupo_id) total_clientes");
        $this->db->from($this->_table);
        $this->db->join("grupo_oferta", "grupo_oferta.oferta_id=oferta.id", 'INNER');
        $this->db->join("producto", "producto.id=oferta.producto_id", 'INNER');

        if (isset($params['producto_id'])) {
            $this->db->where("oferta.producto_id", $params["producto_id"]);
        }

        $this->db->group_by('grupo_oferta.oferta_id');

        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('oferta.id', 'asc');
            $this->db->limit($limit, $offset);
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("ofertas" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    
    public function get_vendedor_id_de_oferta($oferta_id) {
        $oferta = $this->get($oferta_id);
        if ($oferta) {
            $producto = $this->producto_model->get($oferta->producto_id);
            if ($producto) {
                return $producto->vendedor_id;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function delete($id) {
        $grupos = $this->grupo_oferta_model->get_many_by("oferta_id", $id);
        if ($grupos) {
            $this->grupo_oferta_model->delete_by("oferta_id", $id);
            foreach ($grupos as $grupo) {
                $this->grupo_model->delete($grupo->id);
            }
        }
        parent::delete($id);
    }
         
}
