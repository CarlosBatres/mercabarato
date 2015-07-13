<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * WARNING: Las categorias se estan manejando en cache porque son muchas y no deberian cambiar necesariamente
 * pero si se modifican de alguna manera hay que limpiar el cache y volverlo a generar !IMPORTANTE!
 * 
 * Idealmente se van a modificar desde el admin solamente y mediante las funciones del sistema , NO MANUALMENTE!
 */
class Categoria_model extends MY_Model {
    
     public $after_create = array( 'clear_cache' );
     public $after_update = array( 'clear_cache' );
     public $after_delete = array( 'clear_cache' );
    
    function __construct() {
        parent::__construct();
        $this->_table = "categoria";
    }

    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("categoria.*");
        $this->db->from($this->_table);

        if (isset($params['nombre'])) {
            $this->db->like('categoria.nombre', $params['nombre'], 'both');
        }
        if (isset($params['padre_id'])) {
            $this->db->where('categoria.padre_id', $params['padre_id']);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('categoria.id', 'asc');
            $this->db->limit($limit, $offset);
            $categorias = $this->db->get()->result();
            $this->db->flush_cache();
            return array("categorias" => $categorias, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function get_arbol_path($id) {
        $array = array();
        $count = 0;
        $cat = $this->get_categoria($id);

        if ($cat) {
            $array[$count] = $cat;
            $count++;
            do {
                $var = $this->get_categoria($array[$count - 1]->padre_id);
                if ($var) {
                    $array[$count] = $var;
                    $count++;
                } else {
                    break;
                }
            } while (true);
        }
        return $array;
    }

    public function get_categoria($id) {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('id', $id);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return FALSE;
        }
    }

    public function get_parent($id) {
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('id', $id);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $categoria = $result->row();
            return $this->get_categoria($categoria->parent_id);
        } else {
            return FALSE;
        }
    }

    public function delete_categoria($categoria_id) {
        $resource = $this->get_by("id", $categoria_id);
        if ($resource) {
            unlink('./assets/'.$this->config->item('categorias_img_path').'/'.$resource->filename);
            unlink('./assets/'.$this->config->item('categorias_img_path').'/thumbnail/' . $resource->filename);
        }
        $this->delete_by("id", $categoria_id);
    }
    
    public function get_categorias_searchbar($categoria_id){
        $this->db->cache_on();
        $query="SELECT id,nombre,padre_id FROM categoria WHERE padre_id='".$categoria_id."'";
        $result = $this->db->query($query);                
        $categorias = $result->result_array();        
        $this->db->cache_off();
        if($categorias){            
            foreach($categorias as $key=>$value){                
                $res=$this->get_categorias_searchbar($value['id']);
                if($res){                    
                    $categorias[$key]['subcategorias']=$res;
                }
            }
            return $categorias;
        }else{
            return false;
        }        
        
    }
    /**     
     * @param type $id
     * @return boolean
     */
    public function get_all_categorias_of($id) {
        $this->db->cache_on();
        $query = "SELECT id,nombre FROM categoria WHERE padre_id='" . $id . "'";
        $result = $this->db->query($query);        
        $categorias = $result->result_array();
        $this->db->cache_off();
        $ids = array();
        if ($categorias) {            
            foreach ($categorias as $value) {
                $row=array();
                $row["nombre"] = $value["nombre"];
                $row["id"] = $value["id"];
                $res = $this->get_all_categorias_of($value['id']);
                if ($res) {
                    $row["children"]=$res;
                    
                }
                $ids[]=$row;
            }
            return $ids;
        } else {
            return false;
        }
    }
    
    public function get_full_tree(){        
        $categorias=$this->get_all_categorias_of("0");        
        return $categorias;        
    }
    
    public function clear_cache(){
        $this->db->cache_delete_all();
    }

}
