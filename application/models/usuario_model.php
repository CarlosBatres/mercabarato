<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Usuario_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "usuario";
    }

    public function email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('usuario');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
