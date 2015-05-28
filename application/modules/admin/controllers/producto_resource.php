<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producto_resource extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->authentication->is_loggedin()) {
            redirect('admin/login');
        } else {
            if (!$this->authentication->user_is_admin()) {
                redirect('admin/sin_permiso');
            }
        }
    }
    
    public function upload_image(){
        
        $this->load->config('upload', TRUE);
        $this->load->library('UploadHandler', $this->config->item('photo', 'upload'));                        
    }

}
