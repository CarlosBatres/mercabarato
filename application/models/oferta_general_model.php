<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Oferta_general_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "oferta_general";
    }       
         
}
