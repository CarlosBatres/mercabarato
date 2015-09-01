<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_extra_model extends MY_Model {
    
    /**
     * TIPO = 1 
     *  Usado para Precios segun cantidad de articulos
     *  - NOMBRE = La cantidad de articulos ( Numerico )
     *  - VALUE = El costo o texto describiendo cuanto vale ( Mixed )
     * 
     * 
     */
    
    function __construct() {
        parent::__construct();
        $this->_table = "producto_extra";
    }

}
