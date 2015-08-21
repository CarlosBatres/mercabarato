<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Keyword_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "keyword";
    }

    public function get_keyword($id) {
        $this->db->where("id", $id);
        $query = $this->db->get($this->_table);
        if ($query->num_rows() > 0) {
            $result=$query->row();
            if($result->keywords!=""){
                return $result->keywords;
            }else{
                return false;
            }            
        } else {
            return false;
        }
    }

}
