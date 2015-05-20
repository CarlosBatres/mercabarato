<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    var $table_name = "default";

    function __construct() {
        parent::__construct();
    }

    function insert($data) {
        $this->db->insert($this->table_name, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function get($id) {
        $this->db->where("id", $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }

    function get_all() {
        $this->db->where("status", 1);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    function get_array($id) {
        $this->db->where("id", $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0){
            return $query->row_array();            
        }else{
            return false;
        }    
    }

    function update($data, $id) {
        $this->db->where("id", $id);
        $this->db->update($this->table_name, $data);
        return true;
    }

    function delete($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->table_name);
        return true;
    }

    function total($active = false) {
        $query = "SELECT * FROM " . $this->table_name;
        $query = $this->db->query($query);
        return $query->num_rows();
    }

    function exist_field($field, $value, $id = 0) {
        $conditional = "";
        if ($id != 0) {
            $conditional = "and id != $id";
        }
        $query = $this->db->query("SELECT * FROM " . $this->table_name . " WHERE upper($field)=upper('$value') " . $conditional);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
