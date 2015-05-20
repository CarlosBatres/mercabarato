<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Provincia_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table_name = "provincia";
    }

    function get_all_by_pais($pais_id) {
        $this->db->where("pais_id", $pais_id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
