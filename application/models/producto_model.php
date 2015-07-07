<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_model extends MY_Model {

    public $has_many = array('producto_resources' => array('model' => 'producto_resource_model', 'primary_key' => 'producto_id'));
    public $before_create = array('pre_insertado');
    public $protected_attributes = array('id');

    function __construct() {
        parent::__construct();
        $this->_table = "producto";
    }

    /**
     * 
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("producto.*,categoria.nombre AS Categoria,vendedor.nombre AS Vendedor");
        $this->db->from($this->_table);
        $this->db->join("categoria", "categoria.id=producto.categoria_id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=producto.vendedor_id", 'INNER');

        if (isset($params['nombre'])) {
            $this->db->like('producto.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            $this->db->where('producto.categoria_id', $params['categoria_id']);
        }
        if (isset($params['vendedor'])) {
            $this->db->like('vendedor.nombre', $params['vendedor'], 'both');
        }
        if (isset($params['vendedor_id'])) {
            $this->db->where('vendedor.id', $params['vendedor_id']);
        }


        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('id', 'asc');
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            $this->db->flush_cache();
            return array("productos" => $productos, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    /**
     * 
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @param type $order_by
     * @param type $order
     * @return type
     */
    public function get_site_search($params, $limit, $offset, $order_by, $order) {
        $this->db->start_cache();
        $this->db->select('p.*,pr.filename as imagen_nombre');
        $this->db->from('producto p');
        $this->db->join('producto_resource pr', 'pr.producto_id = p.id AND pr.tipo="imagen_principal"', 'left');
        $this->db->join('productos_localizacion pl', 'pl.producto_id = p.id', 'inner');

        if (isset($params['nombre'])) {
            $this->db->like('p.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            //$arriba = $this->get_categorias_arbol($params['categoria_id']);
            $arriba[] = $params['categoria_id'];
            $abajo = $this->get_all_categorias_of($params['categoria_id']);
            if ($abajo) {
                $categorias_array = array_merge($arriba, $abajo);
            }else{
                $categorias_array = $arriba;
            }
            
            $this->db->where_in('p.categoria_id', $categorias_array);
        }
        if (isset($params['categoria_general'])) {
            if (isset($params['categoria_id'])) {
                $cat = $params['categoria_id'];
            } else {
                $cat = $params['categoria_general'];
            }
            $array = $this->get_all_categorias_of($cat);
            $array[] = $cat;
            $this->db->where_in('p.categoria_id', $array);
        }

        if (isset($params['precio_tipo1'])) {
            if ($params['precio_tipo1'] != '0') {
                $precios = explode(";;", $params['precio_tipo1']);
                // TODO : Aqui el precio puede ser precio oferta o una tarifa especifica. Resolver dependiendo de quien este conectado haciendo la busqueda
                $this->db->where('p.precio >', $precios['0']);
                $this->db->where('p.precio <=', $precios['1']);
            }
        }

        if (isset($params["poblacion"])) {
            if ($params['poblacion'] != '0') {
                $this->db->where('pl.problacion_id', $params['poblacion']);
            }
        }

        if (isset($params["provincia"])) {
            if ($params['provincia'] != '0') {
                $this->db->where('pl.provincia_id', $params['provincia']);
            }
        }

        if (isset($params["pais"])) {
            if ($params['pais'] != '0') {
                $this->db->where('pl.pais_id', $params['pais']);
            }
        }
        
        if(isset($params["habilitado"])){
            $this->db->where('p.habilitado',$params['habilitado']);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by($order_by, $order);
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            $this->db->flush_cache();
            return array("productos" => $productos, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    /**
     * Devuelve todas las categorias incluidas
     * @param type $id
     * @return boolean
     */
    public function get_all_categorias_of($id) {
        $this->db->cache_on();
        $query = "SELECT id FROM categoria WHERE padre_id='" . $id . "'";
        $result = $this->db->query($query);
        $categorias = $result->result_array();
        $this->db->cache_off();
        $ids = array();
        if ($categorias) {
            foreach ($categorias as $value) {
                $ids[] = $value["id"];
                $res = $this->get_all_categorias_of($value['id']);
                if ($res) {
                    foreach ($res as $val) {
                        $ids[] = $val;
                    }
                }
            }
            return $ids;
        } else {
            return false;
        }
    }

    /**
     * Devuelve todas las categorias padre hasta la raiz
     * @param type $id
     * @return boolean
     */
    public function get_categorias_arbol($id) {
        $query = "SELECT padre_id FROM categoria WHERE id='" . $id . "'";
        $result = $this->db->query($query);
        $categoria = $result->row();

        $ids = array();
        if ($categoria) {
            if ($categoria->padre_id != '0') {
                $ids[] = $categoria->padre_id;
                $res = $this->get_categorias_arbol($categoria->padre_id);
                if ($res) {
                    foreach ($res as $val) {
                        $ids[] = $val;
                    }
                }
            } else {
                return false;
            }
            return $ids;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $producto_id
     * @return boolean
     */
    public function get_vendedor_id_del_producto($producto_id) {
        $producto = $this->get($producto_id);
        if ($producto) {
            return $producto->vendedor_id;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $vendedor_id
     * @param type $count
     * @return boolean
     */
    public function get_ultimos_productos_ids($vendedor_id, $count) {
        $this->db->select('id');
        $this->db->from('producto');
        $this->db->where("vendedor_id", $vendedor_id);
        $this->db->order_by("id", "desc");
        $this->db->limit($count, 0);
        $response = $this->db->get()->result_array();

        if ($response) {
            $producto_ids = array();
            foreach ($response as $val) {
                $producto_ids[] = $val['id'];
            }
            return $producto_ids;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $params
     */
    public function habilitar_productos($params) {
        $data = array("habilitado" => 1);
        if (isset($params["limit"]) && isset($params["vendedor_id"])) {
            $ids = $this->get_ultimos_productos_ids($params["vendedor_id"], $params["limit"]);

            $this->db->where_in('id', $ids);
            $this->db->where('vendedor_id', $params["vendedor_id"]);
        }
        $this->db->update("producto", $data);
        return $this->db->affected_rows();
    }

    /**
     * 
     * @param array $producto
     * @return type
     */
    protected function pre_insertado($producto) {
        $producto['fecha_insertado'] = date('Y-m-d');
        return $producto;
    }
    
    public function inhabilitar($producto_id){
        $this->update($producto_id, array("habilitado"=>"0"));
    }
    
    public function habilitar($producto_id){
        $this->update($producto_id, array("habilitado"=>"1"));
    }
    
    public function get_tarifas_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("producto.*,categoria.nombre AS Categoria,tarifa.nuevo_costo as precio_tarifa");
        $this->db->from($this->_table);
        $this->db->join("categoria", "categoria.id=producto.categoria_id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=producto.vendedor_id", 'INNER');
        $this->db->join("tarifa", "tarifa.producto_id=producto.id", 'LEFT');

        if (isset($params['nombre'])) {
            $this->db->like('producto.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            $this->db->where('producto.categoria_id', $params['categoria_id']);
        }        
        if (isset($params['vendedor_id'])) {
            $this->db->where('vendedor.id', $params['vendedor_id']);
        }


        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('id', 'asc');
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            $this->db->flush_cache();
            return array("productos" => $productos, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    /**
     * Full Delete de un producto
     * @param type $id
     */
    public function delete($id) {
        $this->producto_resource_model->cleanup_resources($id);
        $this->visita_model->delete_by("producto_id",$id);
        parent::delete($id);
    }

}
