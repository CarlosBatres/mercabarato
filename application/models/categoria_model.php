<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Categoria_model extends MY_Model {

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
            $this->db->order_by('categoria.nombre', 'asc');
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
        
}
