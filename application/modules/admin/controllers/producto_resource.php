<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producto_resource extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();        
    }
    
    public function upload_image(){        
        $this->load->config('upload', TRUE);
        $this->load->library('UploadHandler', $this->config->item('producto', 'upload'));                        
    }

}
