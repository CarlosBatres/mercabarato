<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Oferta_general_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "oferta_general";
    }

    public function get_ofertas($params, $limit, $offset) {
        $query = "SELECT SQL_CALC_FOUND_ROWS t_p.id,t_p.nombre,t_p.descripcion,t_p.porcentaje,t_p.fecha_inicio,t_p.fecha_finaliza,productos,clientes ";
        $query.="FROM (";

        $query.="SELECT og.*,COUNT(o.producto_id) as productos ";
        $query.="FROM (oferta_general og) ";
        $query.="INNER JOIN oferta o ON o.oferta_general_id = og.id ";

        if (isset($params["vendedor_id"])) {
            $query.="INNER JOIN producto p ON p.id = o.producto_id ";
            $query.="WHERE p.vendedor_id = '" . $params["vendedor_id"] . "' ";
        }

        $query.="GROUP BY og.id ) as t_p ";

        $query.="INNER JOIN ";

        $query.="(SELECT og.*,COUNT(go.cliente_id) as clientes ";
        $query.="FROM (oferta_general og) ";
        $query.="INNER JOIN grupo_oferta go ON go.oferta_general_id = og.id ";
        $query.="GROUP BY og.id ) as t_c ";
        $query.="ON t_p.id=t_c.id ";

        $query.=" LIMIT " . $offset . " , " . $limit;

        $result = $this->db->query($query);
        $results = $result->result();

        $query_total = "SELECT FOUND_ROWS() as rows;";
        $result_total = $this->db->query($query_total);
        $total = $result_total->row();

        if ($total->rows > 0) {
            return array("ofertas" => $results, "total" => $total->rows);
        } else {
            return array("total" => 0);
        }
    }

    public function get_vendedor_id_de_oferta($oferta_general_id) {
        $oferta_general = $this->get($oferta_general_id);
        if ($oferta_general) {
            $oferta = $this->oferta_model->get_by("oferta_general_id", $oferta_general->id);
            if ($oferta) {
                $producto = $this->producto_model->get($oferta->producto_id);
                if ($producto) {
                    return $producto->vendedor_id;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return FALSE;
        }
    }

    public function delete($id) {
        $this->grupo_oferta_model->delete_by("oferta_general_id", $id);
        $this->oferta_model->delete_by("oferta_general_id", $id);
        parent::delete($id);
    }

    public function get_vendedor($oferta_general_id) {
        $oferta = $this->oferta_model->get_by("oferta_general_id", $oferta_general_id);
        if ($oferta) {
            $producto = $this->producto_model->get($oferta->producto_id);
            if ($producto) {
                return $producto->vendedor_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_clientes($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("c.id,c.nombres,c.apellidos,v.nombre as nombre_vendedor,u.fecha_creado,u.ultimo_acceso");
        $this->db->from($this->_table);
        $this->db->join("grupo_oferta go", "go.oferta_general_id=oferta_general.id", 'INNER');
        $this->db->join("cliente c", "c.id=go.cliente_id", 'INNER');
        $this->db->join("usuario u", "u.id=c.usuario_id", 'INNER');
        $this->db->join("vendedor v", "v.cliente_id=c.id", 'LEFT');


        if (isset($params['oferta_general_id'])) {
            $this->db->where("oferta_general.id", $params["oferta_general_id"]);
        }


        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('c.id', 'asc');
            if ($limit) {
                $this->db->limit($limit, $offset);
            }
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("clientes" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function get_productos($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("p.*,o.nuevo_costo");
        $this->db->from($this->_table);
        $this->db->join("oferta o", "o.oferta_general_id=oferta_general.id", 'INNER');
        $this->db->join("producto p", "p.id=o.producto_id", 'INNER');


        if (isset($params['oferta_general_id'])) {
            $this->db->where("oferta_general.id", $params["oferta_general_id"]);
        }


        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('p.id', 'asc');
            if ($limit) {
                $this->db->limit($limit, $offset);
            }
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("productos" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    
    public function get_clientes_ids($params){        
        $this->db->select("c.id");
        $this->db->from($this->_table);
        $this->db->join("grupo_oferta go", "go.oferta_general_id=oferta_general.id", 'INNER');               
        $this->db->join("cliente c", "c.id=go.cliente_id", 'INNER');                               
        
        if (isset($params['oferta_general_id'])) {
            $this->db->where("oferta_general.id",$params["oferta_general_id"]);            
        }                                             
        
        $result = $this->db->get()->result();        
        if (sizeof($result)>0) {
            $ids=array();
            foreach($result as $val){
                $ids[]=$val->id;
            }                                                
            return $ids;
        } else {            
            return array();
        }   
    }
    
    public function get_productos_ids($params){        
        $this->db->select("p.id");
        $this->db->from($this->_table);
        $this->db->join("oferta o", "o.oferta_general_id=oferta_general.id", 'INNER');               
        $this->db->join("producto p", "p.id=o.producto_id", 'INNER');                               
        
        if (isset($params['oferta_general_id'])) {
            $this->db->where("oferta_general.id",$params["oferta_general_id"]);            
        }                                             
        
        $result = $this->db->get()->result();        
        if (sizeof($result)>0) {
            $ids=array();
            foreach($result as $val){
                $ids[]=$val->id;
            }                                                
            return $ids;
        } else {            
            return array();
        }   
    }
    
    /**
     * Busca los productos id de las ofertas que tienen un determinado grupo de clientes
     * para asi no repetir una tarifa a un cliente
     * @param type $params
     * @return type
     */
    public function get_productos_ids_from_clientes($params){        
        $this->db->select("DISTINCT p.id",false);
        $this->db->from($this->_table);
        $this->db->join("oferta o", "o.oferta_general_id=oferta_general.id", 'INNER');               
        $this->db->join("grupo_oferta go", "go.oferta_general_id=oferta_general.id", 'INNER');                       
        $this->db->join("producto p", "p.id=o.producto_id", 'INNER');                       
                
        if (isset($params['clientes_ids'])) {
            $this->db->where_in("go.cliente_id",$params["clientes_ids"]);            
        }
        
        if (isset($params['vendedor_id'])) {
            $this->db->where("p.vendedor_id",$params["vendedor_id"]);            
        }
        
        $result = $this->db->get()->result();        
        if (sizeof($result)>0) {
            $ids=array();
            foreach($result as $val){
                $ids[]=$val->id;
            }                                                
            return $ids;
        } else {            
            return array();
        }   
    }

}
