<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Punto_venta_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "punto_venta";
    }

}
