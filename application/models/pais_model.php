<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pais_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "pais";
    }       
    
     function get_all() {
        $this->db->where("estado", 1);
        $query = $this->db->get($this->_table);
        if ($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

}
