<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tarifa_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "tarifa";
    }

    public function get_tarifas_detalles($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("tarifa.id,producto.precio as viejo_costo,tarifa.nuevo_costo,tarifa.comentario,COUNT(grupo_tarifa.grupo_id) total_clientes");
        $this->db->from($this->_table);
        $this->db->join("grupo_tarifa", "grupo_tarifa.tarifa_id=tarifa.id", 'INNER');
        $this->db->join("producto", "producto.id=tarifa.producto_id", 'INNER');

        if (isset($params['producto_id'])) {
            $this->db->where("tarifa.producto_id", $params["producto_id"]);
        }

        $this->db->group_by('grupo_tarifa.tarifa_id');

        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('tarifa.id', 'asc');
            $this->db->limit($limit, $offset);
            $tarifas = $this->db->get()->result();
            $this->db->flush_cache();
            return array("tarifas" => $tarifas, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function get_vendedor_id_de_tarifa($tarifa_id) {
        $tarifa = $this->get($tarifa_id);
        if ($tarifa) {
            $producto = $this->producto_model->get($tarifa->producto_id);
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
        $grupos = $this->grupo_tarifa_model->get_many_by("tarifa_id", $id);
        if ($grupos) {
            $this->grupo_tarifa_model->delete_by("tarifa_id", $id);
            foreach ($grupos as $grupo) {
                $this->grupo_model->delete($grupo->id);
            }
        }
        parent::delete($id);
    }

    /**
     * Devuelve los clientes que ya tienen tarifas en base a un array de productos.
     * @param type $producto_ids
     */
    public function get_clientes_for_productos($producto_ids) {
        $this->db->select("grupo.cliente_id");
        $this->db->from("grupo");        
        $this->db->join("grupo_tarifa", "grupo_tarifa.grupo_id=grupo.id", 'INNER');
        $this->db->join("tarifa", "tarifa.id=grupo_tarifa.tarifa_id", 'INNER');
        
        $this->db->where_in("tarifa.producto_id", $producto_ids);
        
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

}
